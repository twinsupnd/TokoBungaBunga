<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEventRequest;
use App\Http\Requests\UpdateEventRequest;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Schema;

class EventController extends Controller
{
    public function index(Request $request)
    {
        $month = $request->query('month', now()->format('Y-m'));
        try {
            $start = Carbon::parse($month . '-01')->startOfMonth();
        } catch (\Exception $e) {
            $start = now()->startOfMonth();
            $month = $start->format('Y-m');
        }
        $end = (clone $start)->endOfMonth();

        $events = collect();
        $eventsList = collect();
        $missingTable = false;
        $missingColumns = [];

        if (! Schema::hasTable('events')) {
            $missingTable = true;
        } else {
            // verify expected columns exist before running queries
            // expected columns based on the existing DB schema (as provided)
            $expected = ['tanggal', 'nama_acara', 'waktu_mulai', 'waktu_selesai', 'tempat', 'kategori'];
            foreach ($expected as $col) {
                if (! Schema::hasColumn('events', $col)) {
                    $missingColumns[] = $col;
                }
            }

            if (empty($missingColumns)) {
                // safe to query: use tanggal (date) and waktu_mulai for ordering
                $events = Event::whereBetween('tanggal', [$start->toDateString(), $end->toDateString()])
                    ->orderBy('tanggal')
                    ->orderBy('waktu_mulai')
                    ->get();

                // provide a paginated event list view for manager
                $eventsList = Event::query()
                    ->orderBy('tanggal', 'desc')
                    ->orderBy('waktu_mulai', 'desc')
                    ->paginate(15)
                    ->withQueryString();
            }
        }

        // If there is no table or required columns, make sure $eventsList behaves like a paginator
        // so view calls like ->total(), ->firstItem(), and ->links() won't fail.
        if (! $eventsList instanceof LengthAwarePaginator) {
            $eventsList = new LengthAwarePaginator([], 0, 15, $request->query('page', 1));
            // preserve query string on pagination links
            if (method_exists($eventsList, 'withQueryString')) {
                $eventsList = $eventsList->withQueryString();
            }
        }

        return view('dashboard.manager.calendar', compact('events', 'eventsList', 'start', 'end', 'month', 'missingTable', 'missingColumns'));
    }

    public function create()
    {
        return view('dashboard.manager.create-event');
    }

    public function store(StoreEventRequest $request)
    {
        $data = $request->validated();
        // Ensure kategori has a sane default as an extra-safety (validation should already enforce this)
        $data['kategori'] = $data['kategori'] ?? 'Personal';
        Event::create($data);

        return redirect()->route('manager.dashboard')->with('success', 'Event dibuat.');
    }

    public function edit(Event $event)
    {
        return view('dashboard.manager.edit-event', ['event' => $event]);
    }

    public function update(UpdateEventRequest $request, Event $event)
    {
        $event->update($request->validated());
        return redirect()->route('manager.dashboard')->with('success', 'Event diperbarui.');
    }

    public function destroy(Event $event)
    {
        $event->delete();
        return redirect()->route('manager.dashboard')->with('success', 'Event dihapus.');
    }
}

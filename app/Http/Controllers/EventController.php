<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEventRequest;
use App\Http\Requests\UpdateEventRequest;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class EventController extends Controller
{
    public function index(Request $request)
    {
        // show events for the currently selected month
        $month = $request->query('month', now()->format('Y-m'));
        try {
            $start = Carbon::parse($month . '-01')->startOfMonth();
        } catch (\Exception $e) {
            $start = now()->startOfMonth();
            $month = $start->format('Y-m');
        }
        $end = (clone $start)->endOfMonth();

        $events = Event::whereBetween('start_at', [$start->toDateTimeString(), $end->toDateTimeString()])
            ->orderBy('start_at')
            ->get();

        return view('dashboard.admin.calendar', compact('events', 'start', 'end', 'month'));
    }

    public function create()
    {
        return view('dashboard.admin.create-event');
    }

    public function store(StoreEventRequest $request)
    {
        $data = $request->validated();
        $data['created_by'] = auth()->id();
        $event = Event::create($data);

        return redirect()->route('dashboard.admin.index')->with('success', 'Event dibuat.');
    }

    public function edit(Event $event)
    {
        return view('dashboard.admin.edit-event', ['event' => $event]);
    }

    public function update(UpdateEventRequest $request, Event $event)
    {
        $event->update($request->validated());
        return redirect()->route('dashboard.admin.index')->with('success', 'Event diperbarui.');
    }

    public function destroy(Event $event)
    {
        $event->delete();
        return redirect()->route('dashboard.admin.index')->with('success', 'Event dihapus.');
    }
}

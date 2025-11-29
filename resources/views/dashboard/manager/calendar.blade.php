@extends('dashboard.layout')

@section('title', 'Kalendar')

@section('content')

<div class="dashboard-header" style="display:flex; align-items:center; justify-content:space-between; gap:12px;">
    <div>
        <h1 class="page-title">Kalendar</h1>
        <p class="text-sm text-gray-500">Kelola acara tim — lihat, buat, atau edit event.</p>
    </div>

    <a href="{{ route('manager.calendar.create') }}" style="background:#7c3aed;color:white;padding:8px 12px;border-radius:6px;text-decoration:none;font-weight:700;">+ Add Event</a>
</div>

@if(session('success'))
    <div style="margin-top:12px;background:#ecfccb;padding:10px;border-radius:6px;color:#365314;">{{ session('success') }}</div>
@endif

<div style="display:flex; gap:18px; margin-top:18px;">
    <div style="width:320px;">
        <div style="background:white;padding:12px;border-radius:8px;box-shadow:0 1px 4px rgba(0,0,0,.06);">
            <div style="display:flex; align-items:center; justify-content:space-between;">
                <div style="font-weight:700">{{ $start->format('F Y') }}</div>
                <div>
                    <a href="?month={{ $start->copy()->subMonth()->format('Y-m') }}">◀</a>
                    <a href="?month={{ $start->copy()->addMonth()->format('Y-m') }}">▶</a>
                </div>
            </div>

            <div style="display:grid; grid-template-columns: repeat(7, 1fr); gap:4px; margin-top:12px; font-size:12px; color:#6b7280;">
                @foreach(['Sun','Mon','Tue','Wed','Thu','Fri','Sat'] as $d)
                    <div style="text-align:center;">{{ $d }}</div>
                @endforeach
            </div>

            @php
                $firstDay = $start->startOfMonth();
                $firstWeekday = $firstDay->dayOfWeek; // 0 (Sun) - 6 (Sat)
                $daysInMonth = $start->daysInMonth;

                $cells = [];
                for ($i = 0; $i < $firstWeekday; $i++) $cells[] = null;
                for ($d = 1; $d <= $daysInMonth; $d++) $cells[] = $d;
                while (count($cells) % 7 !== 0) $cells[] = null;

                $eventsByDay = [];
                foreach($events as $e){
                    $day = $e->start_at->format('j');
                    $eventsByDay[$day][] = $e;
                }
            @endphp

            <div style="display:grid; grid-template-columns: repeat(7, 1fr); gap:8px; margin-top:8px;">
                @foreach($cells as $cell)
                    <div style="min-height:70px; border-radius:6px; padding:6px; background: #fff; border:1px solid #f3f4f6;">
                        @if($cell)
                            <div style="display:flex; justify-content:space-between; align-items:center;">
                                <div style="font-size:13px; font-weight:700;">{{ $cell }}</div>
                                <div style="font-size:11px; color:#6b7280;">&nbsp;</div>
                            </div>

                            <div style="margin-top:6px; display:flex; flex-direction:column; gap:6px;">
                                @foreach($eventsByDay[$cell] ?? [] as $e)
                                    <a href="{{ route('manager.calendar.edit', $e) }}" style="display:block; background:{{ $e->color ?? '#c7f9cc' }}; color:#04111b; padding:4px 6px; border-radius:4px; font-size:12px; text-decoration:none;">
                                        {{ \Illuminate\Support\Str::limit($e->title, 28) }}
                                    </a>
                                @endforeach
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>

        <div style="margin-top:12px; background:white;padding:12px;border-radius:8px; box-shadow:0 1px 4px rgba(0,0,0,.06);">
            <h4 style="margin:0 0 8px 0;">Event Filters</h4>
            <div style="display:flex; flex-direction:column; gap:8px;">
                <label><input type="checkbox" checked /> View All</label>
                <label><input type="checkbox" /> Personal</label>
                <label><input type="checkbox" /> Business</label>
                <label><input type="checkbox" /> Family</label>
            </div>
        </div>
    </div>

    <div style="flex:1;">
        <div style="background:white;padding:12px;border-radius:8px;box-shadow:0 1px 4px rgba(0,0,0,.06);">
            <div style="display:flex; align-items:center; justify-content:space-between;">
                <div style="font-weight:700; font-size:18px;">{{ $start->format('F Y') }}</div>
                <div style="display:flex; gap:8px; align-items:center;">
                    <a href="?month={{ $start->copy()->subMonth()->format('Y-m') }}">◀</a>
                    <a href="?month={{ now()->format('Y-m') }}" style="font-size:12px; background:#f3f4f6; padding:6px 10px;border-radius:6px;">Today</a>
                    <a href="?month={{ $start->copy()->addMonth()->format('Y-m') }}">▶</a>
                </div>
            </div>

            <div style="margin-top:14px; display:grid; grid-template-columns: repeat(7, 1fr); gap:8px; color:#6b7280;">
                @foreach(['Sun','Mon','Tue','Wed','Thu','Fri','Sat'] as $d)
                    <div style="text-align:center; font-weight:700;">{{ $d }}</div>
                @endforeach
            </div>

            <div style="margin-top:14px;">
                @php $weeks = array_chunk($cells, 7); @endphp

                <div style="display:flex; flex-direction:column; gap:10px;">
                    @foreach($weeks as $week)
                        <div style="display:grid; grid-template-columns: repeat(7, 1fr); gap:8px;">
                            @foreach($week as $day)
                                <div style="min-height:90px; background:#fff; border:1px solid #eef2f7; padding:8px; border-radius:6px;">
                                    @if($day)
                                        <div style="display:flex; justify-content:space-between; align-items:start;">
                                            <div style="font-weight:700;">{{ $day }}</div>
                                            <div style="font-size:12px; color:#9ca3af;">&nbsp;</div>
                                        </div>
                                        <div style="margin-top:8px; display:flex; flex-direction:column; gap:6px;">
                                            @foreach($eventsByDay[$day] ?? [] as $e)
                                                <div style="display:flex; justify-content:space-between; align-items:center; gap:8px;">
                                                    <a href="{{ route('manager.calendar.edit', $e) }}" style="display:block; flex:1; padding:6px 8px; background:{{ $e->color ?? '#eef8ff' }}; border-radius:999px; color:#04111b; text-decoration:none; font-weight:600; font-size:13px;">
                                                        {{ \Illuminate\Support\Str::limit($e->title, 50) }}
                                                    </a>
                                                    <form action="{{ route('manager.calendar.destroy', $e) }}" method="POST" onsubmit="return confirm('Hapus event {{ addslashes($e->title) }}?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" style="border:none;background:transparent;color:#ef4444;font-weight:700;">✕</button>
                                                    </form>
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div style="margin-top:12px;">
            <div style="display:flex; gap:12px; align-items:center;">
                <div class="stat-card" style="flex:1; padding:10px;">Total events: <strong>{{ $events->count() }}</strong></div>
            </div>
        </div>
    </div>
</div>

@endsection

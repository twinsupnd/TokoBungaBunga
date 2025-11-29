@extends('dashboard.layout')

@section('title', 'Edit Event')

@section('content')

<div class="dashboard-header">
    <h1 class="page-title">Edit Event</h1>
    <p class="text-sm text-gray-500">Edit the event details.</p>
</div>

@if($errors->any())
    <div style="background:#fee2e2;padding:10px;border-radius:6px;margin-bottom:12px;color:#b91c1c;">
        <strong>Errors</strong>
        <ul>
            @foreach($errors->all() as $err)
                <li>{{ $err }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form method="POST" action="{{ route('manager.calendar.update', $event) }}">
    @csrf
    @method('PUT')

    <div style="display:grid; gap:12px;">
        <div>
            <label>Nama Acara</label>
            <input name="nama_acara" value="{{ old('nama_acara', $event->nama_acara) }}" required style="width:100%;padding:8px;border:1px solid #e5e7eb;border-radius:6px;" />
        </div>

        <div style="display:grid; grid-template-columns:1fr; gap:12px;">
            <div>
                <label>Tanggal</label>
                <input type="date" name="tanggal" value="{{ old('tanggal', $event->tanggal ? $event->tanggal->format('Y-m-d') : '') }}" required style="width:100%;padding:8px;border:1px solid #e5e7eb;border-radius:6px;" />
            </div>
        </div>

        <div style="display:grid; grid-template-columns:1fr 1fr; gap:12px; margin-top:6px;">
            <div>
                <label>Waktu Mulai</label>
                @php
                    $wm = old('waktu_mulai', $event->waktu_mulai);
                    if ($wm) {
                        $wm = preg_replace('/\s+/', '', str_replace('.', ':', $wm));
                        if (preg_match('/^\d{1,2}:\d{2}:\d{2}$/', $wm)) {
                            $wm = substr($wm, 0, 5);
                        } elseif (preg_match('/^\d{3,4}$/', $wm)) {
                            $wm = substr($wm, 0, -2) . ':' . substr($wm, -2);
                        }
                    }
                @endphp
                <input type="time" name="waktu_mulai" value="{{ $wm ?? '' }}" required style="width:100%;padding:8px;border:1px solid #e5e7eb;border-radius:6px;" />
            </div>
            <div>
                <label>Waktu Selesai</label>
                @php
                    $ws = old('waktu_selesai', $event->waktu_selesai);
                    if ($ws) {
                        $ws = preg_replace('/\s+/', '', str_replace('.', ':', $ws));
                        if (preg_match('/^\d{1,2}:\d{2}:\d{2}$/', $ws)) {
                            $ws = substr($ws, 0, 5);
                        } elseif (preg_match('/^\d{3,4}$/', $ws)) {
                            $ws = substr($ws, 0, -2) . ':' . substr($ws, -2);
                        }
                    }
                @endphp
                <input type="time" name="waktu_selesai" value="{{ $ws ?? '' }}" style="width:100%;padding:8px;border:1px solid #e5e7eb;border-radius:6px;" />
            </div>
        </div>

        <div style="display:grid; grid-template-columns:1fr 1fr; gap:12px; margin-top:6px;">
            <div>
                <label>Tempat</label>
                <input name="tempat" value="{{ old('tempat', $event->tempat) }}" placeholder="Lokasi / Tempat" style="width:100%;padding:8px;border:1px solid #e5e7eb;border-radius:6px;" />
            </div>
            <div>
                <label>Kategori</label>
                <select name="kategori" style="width:100%;padding:8px;border:1px solid #e5e7eb;border-radius:6px;">
                    <option value="">-- pilih kategori --</option>
                    <option value="Personal" {{ old('kategori', $event->kategori) == 'Personal' ? 'selected' : '' }}>Personal</option>
                    <option value="Business" {{ old('kategori', $event->kategori) == 'Business' ? 'selected' : '' }}>Business</option>
                </select>
            </div>
        </div>

        <div>
            <button type="submit" style="background:#7c3aed;color:white;padding:8px 12px;border-radius:6px;border:none;font-weight:700;">Save</button>
            <a href="{{ route('manager.dashboard') }}" style="margin-left:12px;">Cancel</a>
        </div>
    </div>
</form>

@endsection

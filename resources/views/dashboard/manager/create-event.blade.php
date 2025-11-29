@extends('dashboard.layout')

@section('title', 'Add Event')

@section('content')

<div class="dashboard-header">
    <h1 class="page-title">Add Event</h1>
    <p class="text-sm text-gray-500">Create a new event.</p>
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

<form method="POST" action="{{ route('manager.calendar.store') }}">
    @csrf

    <div style="display:grid; gap:12px;">
        <div>
            <label>Nama Acara</label>
            <input name="nama_acara" value="{{ old('nama_acara') }}" required style="width:100%;padding:8px;border:1px solid #e5e7eb;border-radius:6px;" />
        </div>

        <div style="display:grid; grid-template-columns:1fr 1fr; gap:12px;">
            <div>
                <label>Tanggal</label>
                <input type="date" name="tanggal" value="{{ old('tanggal') }}" required style="width:100%;padding:8px;border:1px solid #e5e7eb;border-radius:6px;" />
            </div>
            <div>
                <label>Waktu Mulai</label>
                <input type="time" name="waktu_mulai" value="{{ old('waktu_mulai') }}" required style="width:100%;padding:8px;border:1px solid #e5e7eb;border-radius:6px;" />
            </div>
        </div>

        <div style="display:grid; grid-template-columns:1fr 1fr; gap:12px; margin-top:6px;">
            <div>
                <label>Waktu Selesai</label>
                <input type="time" name="waktu_selesai" value="{{ old('waktu_selesai') }}" style="width:100%;padding:8px;border:1px solid #e5e7eb;border-radius:6px;" />
            </div>
            <div>
                <label>Tempat</label>
                <input name="tempat" value="{{ old('tempat') }}" placeholder="Lokasi / Tempat" style="width:100%;padding:8px;border:1px solid #e5e7eb;border-radius:6px;" />
            </div>
        </div>

        <div style="display:flex; gap:12px; align-items:center; margin-top:6px;">
            <label style="display:block; width:100%;">
                <div style="font-size:12px; color:#6b7280; margin-bottom:6px;">Kategori</div>
                <select name="kategori" required style="width:100%;padding:8px;border:1px solid #e5e7eb;border-radius:6px;">
                    <option value="Personal" {{ old('kategori', 'Personal') == 'Personal' ? 'selected' : '' }}>Personal</option>
                    <option value="Business" {{ old('kategori') == 'Business' ? 'selected' : '' }}>Business</option>
                </select>
            </label>
        </div>

        <div>
            <button type="submit" style="background:#7c3aed;color:white;padding:8px 12px;border-radius:6px;border:none;font-weight:700;">Create</button>
            <a href="{{ route('manager.dashboard') }}" style="margin-left:12px;">Cancel</a>
        </div>
    </div>
</form>

@endsection

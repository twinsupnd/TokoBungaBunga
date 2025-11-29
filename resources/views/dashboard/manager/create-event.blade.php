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
            <label>Title</label>
            <input name="title" value="{{ old('title') }}" required style="width:100%;padding:8px;border:1px solid #e5e7eb;border-radius:6px;" />
        </div>

        <div>
            <label>Description</label>
            <textarea name="description" style="width:100%;padding:8px;border:1px solid #e5e7eb;border-radius:6px;" rows="4">{{ old('description') }}</textarea>
        </div>

        <div style="display:grid; grid-template-columns:1fr 1fr; gap:12px;">
            <div>
                <label>Start</label>
                <input type="datetime-local" name="start_at" value="{{ old('start_at') }}" required style="width:100%;padding:8px;border:1px solid #e5e7eb;border-radius:6px;" />
            </div>
            <div>
                <label>End</label>
                <input type="datetime-local" name="end_at" value="{{ old('end_at') }}" style="width:100%;padding:8px;border:1px solid #e5e7eb;border-radius:6px;" />
            </div>
        </div>

        <div style="display:flex; gap:12px; align-items:center;">
            <label style="display:flex; gap:8px; align-items:center;"><input type="checkbox" name="all_day" value="1"> All day</label>
            <input name="category" placeholder="Category" style="flex:1;padding:8px;border:1px solid #e5e7eb;border-radius:6px;" />
            <input type="color" name="color" value="#c7f9cc" style="width:48px; padding:4px; border-radius:6px; border:none;" />
        </div>

        <div>
            <button type="submit" style="background:#7c3aed;color:white;padding:8px 12px;border-radius:6px;border:none;font-weight:700;">Create</button>
            <a href="{{ route('manager.dashboard') }}" style="margin-left:12px;">Cancel</a>
        </div>
    </div>
</form>

@endsection

@extends('dashboard.layout')

@section('title', 'Tambah Admin (dinonaktifkan)')

@section('content')

    <div style="padding:2rem;background:#fff;border-radius:8px;box-shadow:0 4px 6px rgba(0,0,0,0.04)">
        <h2>Fitur Pembuatan Admin Dinonaktifkan</h2>
        <p>Pembuatan admin melalui UI dinonaktifkan. Kembali ke <a href="{{ route('dashboard') }}">Dashboard</a>.</p>
    </div>

@endsection

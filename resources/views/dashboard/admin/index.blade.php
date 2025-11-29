@extends('dashboard.layout')

@section('title', 'Data Admin (dinonaktifkan)')

@section('content')

    <div style="padding:2rem;background:#fff;border-radius:8px;box-shadow:0 4px 6px rgba(0,0,0,0.04)">
        <h2>Fitur Kelola Admin Dinonaktifkan</h2>
        <p>Halaman ini telah dinonaktifkan karena admin tidak diizinkan untuk mengelola akun admin lainnya.</p>
        <p>Kembali ke <a href="{{ route('dashboard') }}">Dashboard</a>.</p>
    </div>

@endsection

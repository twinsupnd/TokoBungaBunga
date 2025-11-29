@extends('dashboard.layout')

@section('title', 'Buat Admin Baru')

@section('content')

<div class="dashboard-header">
    <h1 class="page-title">Buat Admin Baru</h1>
    <p class="text-sm text-gray-500">Isi data untuk membuat akun admin baru.</p>
</div>

<div class="mt-6">
    @if($errors->any())
        <div style="background:#fee2e2;padding:10px;border-radius:6px;margin-bottom:12px;color:#b91c1c;">
            <strong>Ada error:</strong>
            <ul style="margin-top:8px;">
                @foreach($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('manager.kelola.store') }}">
        @csrf

        <div style="margin-bottom:10px;">
            <label>Nama</label>
            <input type="text" name="name" value="{{ old('name') }}" required style="width:100%;padding:8px;border:1px solid #e5e7eb;border-radius:6px;" />
        </div>

        <div style="margin-bottom:10px;">
            <label>Email</label>
            <input type="email" name="email" value="{{ old('email') }}" required style="width:100%;padding:8px;border:1px solid #e5e7eb;border-radius:6px;" />
        </div>

        <div style="margin-bottom:10px;">
            <label>Password</label>
            <input type="password" name="password" required style="width:100%;padding:8px;border:1px solid #e5e7eb;border-radius:6px;" />
        </div>

        <div style="margin-bottom:18px;">
            <label>Konfirmasi Password</label>
            <input type="password" name="password_confirmation" required style="width:100%;padding:8px;border:1px solid #e5e7eb;border-radius:6px;" />
        </div>

        <div>
            <button type="submit" style="background:var(--accent);color:white;padding:10px 14px;border-radius:6px;border:none;font-weight:700;">Buat Admin</button>
            <a href="{{ route('manager.kelolaAdmin') }}" style="margin-left:12px;">Batal</a>
        </div>
    </form>
</div>

@endsection

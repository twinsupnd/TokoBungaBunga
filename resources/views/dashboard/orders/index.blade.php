@extends('dashboard.layout')

@section('content')
    <div class="card">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-xl font-semibold">Daftar Pesanan</h2>
            <form method="GET" action="{{ route('dashboard.pesanan.index') }}">
                <input type="search" name="q" value="{{ request('q') }}" placeholder="Cari order, nama, telepon" class="px-3 py-2 border rounded-md">
                <button class="ml-2 px-3 py-2 bg-[#ED3878] text-white rounded-md">Cari</button>
            </form>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full table-auto border-collapse">
                <thead>
                    <tr class="text-left text-sm text-gray-600 border-b">
                        <th class="py-2 px-3">Order</th>
                        <th class="py-2 px-3">Nama</th>
                        <th class="py-2 px-3">Telepon</th>
                        <th class="py-2 px-3">Total</th>
                        <th class="py-2 px-3">Status</th>
                        <th class="py-2 px-3">Dibuat</th>
                        <th class="py-2 px-3">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($orders as $order)
                        <tr class="border-b">
                            <td class="py-2 px-3 font-mono text-sm">{{ $order->order_number ?? '—' }}</td>
                            <td class="py-2 px-3">{{ $order->name ?? '—' }}</td>
                            <td class="py-2 px-3">{{ $order->phone ?? '—' }}</td>
                            <td class="py-2 px-3">Rp{{ number_format($order->total ?? 0, 0, ',', '.') }}</td>
                            <td class="py-2 px-3">{{ ucfirst($order->status) }}</td>
                            <td class="py-2 px-3">{{ $order->created_at ? $order->created_at->format('Y-m-d H:i') : '-' }}</td>
                            <td class="py-2 px-3">
                                <a href="#" class="text-sm text-blue-600">Lihat</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="p-6 text-center text-gray-500">Belum ada pesanan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $orders->links() }}
        </div>
    </div>
@endsection

@extends('dashboard.layout')

@section('content')
    <style>
        .orders-card {
            background: linear-gradient(135deg, #FFF8FB 0%, #F8F6FF 100%);
            border-radius: 14px;
            padding: 24px;
            box-shadow: 0 8px 20px rgba(34, 34, 59, 0.04);
        }
        
        .search-box {
            display: flex;
            gap: 8px;
            align-items: center;
        }
        
        .search-box input {
            flex: 1;
            padding: 10px 14px;
            border: 1px solid #E5E0F0;
            border-radius: 8px;
            font-size: 14px;
            transition: all 0.2s ease;
        }
        
        .search-box input:focus {
            outline: none;
            border-color: #ED3878;
            box-shadow: 0 0 0 3px rgba(237, 56, 120, 0.1);
        }
        
        .search-btn {
            padding: 10px 16px;
            background: linear-gradient(135deg, #ED3878 0%, #E02E5F 100%);
            color: white;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s ease;
            box-shadow: 0 4px 12px rgba(237, 56, 120, 0.25);
        }
        
        .search-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(237, 56, 120, 0.35);
        }
        
        .table-wrapper {
            overflow-x: auto;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
            margin-top: 20px;
        }
        
        .orders-table {
            width: 100%;
            border-collapse: collapse;
            background: white;
        }
        
        .orders-table thead {
            background: linear-gradient(90deg, #F0E9FF 0%, #FFE9F3 100%);
            border-bottom: 2px solid #E5E0F0;
        }
        
        .orders-table th {
            padding: 14px 16px;
            text-align: left;
            font-weight: 700;
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #5A4B4B;
        }
        
        .orders-table tbody tr {
            border-bottom: 1px solid #F0E9FF;
            transition: background-color 0.15s ease;
        }
        
        .orders-table tbody tr:hover {
            background-color: #FAF8FF;
        }
        
        .orders-table td {
            padding: 14px 16px;
            font-size: 14px;
            color: #5A4B4B;
        }
        
        .order-id {
            font-family: 'Courier New', monospace;
            font-weight: 600;
            color: #ED3878;
        }
        
        .status-badge {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 6px;
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .status-pending {
            background-color: #FFF2D9;
            color: #D69E00;
        }
        
        .status-paid {
            background-color: #E9F8EF;
            color: #1C7B2A;
        }
        
        .status-cancelled {
            background-color: #FFECEC;
            color: #C41E3A;
        }
        
        .amount-text {
            font-weight: 700;
            color: #1C7B2A;
        }
        
        .action-buttons {
            display: flex;
            gap: 8px;
        }
        
        .btn-small {
            padding: 6px 12px;
            border: none;
            border-radius: 6px;
            font-size: 12px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s ease;
            text-decoration: none;
            display: inline-block;
        }
        
        .btn-view {
            background-color: #E0E7FF;
            color: #4F46E5;
        }
        
        .btn-view:hover {
            background-color: #C7D2FE;
            transform: translateY(-1px);
        }
        
        .empty-state {
            text-align: center;
            padding: 40px 20px;
            color: #999;
        }
        
        .empty-state svg {
            width: 60px;
            height: 60px;
            margin-bottom: 16px;
            opacity: 0.3;
        }
        
        .pagination-wrapper {
            margin-top: 24px;
            display: flex;
            justify-content: center;
        }
    </style>

    <div class="orders-card">
        <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 24px;">
            <div>
                <h2 style="font-size: 24px; font-weight: 700; color: #22223B; margin: 0;">Daftar Pesanan</h2>
                <p style="font-size: 13px; color: #7B7B8B; margin-top: 4px;">Kelola dan monitor semua pesanan pelanggan</p>
            </div>
        </div>

        <form method="GET" action="{{ route('dashboard.pesanan.index') }}" class="search-box">
            <input type="search" name="q" value="{{ request('q') }}" placeholder="Cari Order ID, Nama Pelanggan, atau Nomor Telepon..." />
            <button type="submit" class="search-btn">Cari</button>
        </form>

        <div class="table-wrapper">
            <table class="orders-table">
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Pelanggan</th>
                        <th>Telepon</th>
                        <th>Total Pesanan</th>
                        <th>Status</th>
                        <th>Tanggal Pesanan</th>
          
                    </tr>
                </thead>
                <tbody>
                    @forelse($orders as $order)
                        <tr>
                            <td><span class="order-id">{{ $order->order_number ?? '—' }}</span></td>
                            <td><strong>{{ $order->name ?? '—' }}</strong></td>
                            <td>{{ $order->phone ?? '—' }}</td>
                            <td><span class="amount-text">Rp{{ number_format($order->total ?? 0, 0, ',', '.') }}</span></td>
                            <td>
                                @php
                                    $statusClass = match($order->status) {
                                        'paid' => 'status-paid',
                                        'cancelled' => 'status-cancelled',
                                        default => 'status-pending',
                                    };
                                @endphp
                                <span class="status-badge {{ $statusClass }}">
                                    @if($order->status === 'paid')
                                        ✓ Dibayar
                                    @elseif($order->status === 'cancelled')
                                        ✕ Dibatalkan
                                    @else
                                        ⏳ Pending
                                    @endif
                                </span>
                            </td>
                            <td>{{ $order->created_at ? $order->created_at->format('d M Y • H:i') : '-' }}</td>
                            
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7">
                                <div class="empty-state">
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                                    </svg>
                                    <p style="font-size: 16px; margin: 0;">Belum ada pesanan</p>
                                    <p style="font-size: 13px; margin-top: 4px;">Pesanan pelanggan akan muncul di sini</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="pagination-wrapper">
            {{ $orders->links() }}
        </div>
    </div>
@endsection

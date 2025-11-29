@extends('dashboard.layout')

@section('title', 'Analitik Keuangan')

@section('content')

<style>
    .analytics-header {
        margin-bottom: 28px;
    }

    .analytics-title {
        font-size: 28px;
        font-weight: 700;
        color: var(--text);
        margin: 0 0 6px 0;
    }

    .analytics-subtitle {
        font-size: 14px;
        color: var(--muted);
        margin: 0;
    }

    .back-btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 10px 18px;
        background: linear-gradient(135deg, var(--pastel-accent), var(--pastel-accent-2));
        color: white;
        border: none;
        border-radius: 10px;
        font-weight: 600;
        cursor: pointer;
        text-decoration: none;
        transition: all 0.3s ease;
        font-size: 14px;
        margin-top: 16px;
    }

    .back-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 16px rgba(199,183,255,0.3);
    }

    .analytics-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
        gap: 18px;
        margin-bottom: 28px;
    }

    .metric-card {
        background: var(--pastel-card);
        border-radius: 14px;
        padding: 22px;
        box-shadow: 0 8px 20px rgba(34,34,59,0.04);
        border: 1px solid rgba(199,183,255,0.1);
        border-left: 4px solid var(--pastel-accent);
        transition: all 0.3s ease;
    }

    .metric-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 12px 24px rgba(199,183,255,0.15);
    }

    .metric-label {
        font-size: 12px;
        color: var(--muted);
        text-transform: uppercase;
        font-weight: 600;
        margin-bottom: 8px;
        letter-spacing: 0.5px;
    }

    .metric-value {
        font-size: 24px;
        font-weight: 700;
        color: var(--pastel-accent);
    }

    .metric-subtext {
        font-size: 13px;
        color: var(--muted);
        margin-top: 8px;
    }

    .chart-container {
        background: var(--pastel-card);
        border-radius: 14px;
        padding: 24px;
        box-shadow: 0 8px 20px rgba(34,34,59,0.04);
        border: 1px solid rgba(199,183,255,0.1);
        margin-bottom: 28px;
    }

    .chart-title {
        font-size: 16px;
        font-weight: 700;
        color: var(--text);
        margin: 0 0 18px 0;
    }

    .chart-wrapper {
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 300px;
        background: linear-gradient(135deg, rgba(199,183,255,0.06), rgba(255,214,224,0.06));
        border-radius: 10px;
        padding: 24px;
    }

    .pie-chart {
        width: 150px;
        height: 150px;
        border-radius: 50%;
        background: conic-gradient(
            var(--pastel-accent) 0% 94%,
            var(--pastel-accent-2) 94% 100%
        );
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
        box-shadow: 0 8px 16px rgba(199,183,255,0.2);
    }

    .pie-chart::after {
        content: '';
        position: absolute;
        width: 120px;
        height: 120px;
        background: var(--pastel-card);
        border-radius: 50%;
    }

    .pie-label {
        position: absolute;
        font-weight: 700;
        font-size: 18px;
        color: var(--pastel-accent);
        z-index: 1;
    }

    .pie-stats {
        display: flex;
        gap: 28px;
        margin-top: 16px;
        justify-content: center;
    }

    .pie-stat {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 14px;
        color: var(--text);
    }

    .pie-stat-dot {
        width: 12px;
        height: 12px;
        border-radius: 2px;
    }

    .bar-chart {
        display: flex;
        align-items: flex-end;
        gap: 12px;
        height: 200px;
        justify-content: space-around;
        padding: 12px 0;
    }

    .bar {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 8px;
    }

    .bar-column {
        background: linear-gradient(180deg, var(--pastel-accent), var(--pastel-accent-2));
        border-radius: 6px 6px 0 0;
        min-width: 40px;
        transition: all 0.3s ease;
        box-shadow: 0 4px 8px rgba(199,183,255,0.2);
    }

    .bar-column:hover {
        opacity: 0.85;
        box-shadow: 0 6px 12px rgba(199,183,255,0.3);
    }

    .bar-label {
        font-size: 12px;
        color: var(--muted);
        font-weight: 600;
    }

    .bar-value {
        font-size: 12px;
        color: var(--text);
        font-weight: 700;
    }

    .table-container {
        overflow-x: auto;
        background: var(--pastel-card);
        border-radius: 14px;
        padding: 24px;
        box-shadow: 0 8px 20px rgba(34,34,59,0.04);
        border: 1px solid rgba(199,183,255,0.1);
        margin-bottom: 28px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    th {
        background: linear-gradient(90deg, rgba(199,183,255,0.08), rgba(255,214,224,0.08));
        padding: 14px;
        text-align: left;
        font-weight: 600;
        color: var(--text);
        font-size: 12px;
        text-transform: uppercase;
        border-bottom: 2px solid rgba(199,183,255,0.1);
    }

    td {
        padding: 14px;
        border-bottom: 1px solid rgba(199,183,255,0.08);
        color: var(--text);
        font-size: 14px;
    }

    tr:hover {
        background: rgba(199,183,255,0.04);
    }

    .badge {
        display: inline-block;
        padding: 6px 12px;
        border-radius: 6px;
        font-size: 12px;
        font-weight: 600;
    }

    .badge-success {
        background: rgba(199,183,255,0.15);
        color: var(--pastel-accent);
    }

    .badge-warning {
        background: rgba(255,214,224,0.3);
        color: var(--pastel-accent-2);
    }

    .badge-danger {
        background: rgba(255,107,107,0.15);
        color: #FF6B6B;
    }

    .currency {
        font-weight: 600;
        color: var(--pastel-accent);
    }

    @media (max-width: 768px) {
        .analytics-grid {
            grid-template-columns: 1fr;
        }

        .chart-wrapper {
            min-height: 250px;
        }

        table {
            font-size: 12px;
        }

        th, td {
            padding: 10px;
        }
    }
</style>

<div class="analytics-header">
    <div>
        <h1 class="analytics-title">📊 Analitik Keuangan</h1>
        <p class="analytics-subtitle">Laporan performa dan transaksi bulan {{ $financialData['currentMonth'] }}</p>
    </div>
    <a href="{{ route('dashboard') }}" class="back-btn">← Kembali</a>
</div>

<!-- Key Metrics -->
<div class="analytics-grid">
    <div class="metric-card" style="border-left-color: #FFB5A7;">
        <div class="metric-label">Penjualan Bulan Ini</div>
        <div class="metric-value"><span class="currency">Rp</span> {{ number_format($financialData['salesThisMonth'], 0, ',', '.') }}</div>
        <div class="metric-subtext">Total transaksi: {{ $financialData['totalTransactions'] }}</div>
    </div>

    <div class="metric-card" style="border-left-color: #FCD5CE;">
        <div class="metric-label">Penjualan Minggu Ini</div>
        <div class="metric-value"><span class="currency">Rp</span> {{ number_format($financialData['salesThisWeek'], 0, ',', '.') }}</div>
        <div class="metric-subtext">Per minggu (7 hari)</div>
    </div>

    <div class="metric-card" style="border-left-color: #10b981;">
        <div class="metric-label">Tingkat Sukses</div>
        <div class="metric-value">{{ $financialData['successRate'] }}%</div>
        <div class="metric-subtext">Transaksi berhasil</div>
    </div>
</div>

<!-- Transaction Status Chart -->
<div class="chart-container">
    <h3 class="chart-title">Status Transaksi</h3>
    <div class="chart-wrapper">
        <div>
            <div style="display: flex; gap: 3rem; align-items: center;">
                <div class="pie-chart">
                    <div class="pie-label">{{ $financialData['successRate'] }}%</div>
                </div>
                <div>
                    <div class="pie-stats">
                        <div style="display: flex; flex-direction: column; gap: 1rem;">
                            <div class="pie-stat">
                                <div class="pie-stat-dot" style="background: #FFB5A7;"></div>
                                <span>Sukses: {{ $financialData['transactionStatus']['completed'] }}</span>
                            </div>
                            <div class="pie-stat">
                                <div class="pie-stat-dot" style="background: #FCD5CE;"></div>
                                <span>Pending: {{ $financialData['transactionStatus']['pending'] }}</span>
                            </div>
                            <div class="pie-stat">
                                <div class="pie-stat-dot" style="background: #ef4444;"></div>
                                <span>Batal: {{ $financialData['transactionStatus']['cancelled'] }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Daily Sales Chart -->
<div class="chart-container">
    <h3 class="chart-title">Penjualan Harian (Minggu Ini)</h3>
    <div class="chart-wrapper">
            <div style="width:100%;">
            <canvas id="dailySalesChart" aria-label="Grafik penjualan harian" role="img" style="display:block; width:100%; height:260px;"></canvas>
        </div>
    </div>
</div>

@push('scripts')
    <!-- Chart.js via CDN (lightweight & widely used) -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.3.0/dist/chart.umd.min.js"></script>
    <script>
        (function () {
            // Prepare data from server-rendered PHP variable
            const daily = @json($financialData['dailySales']);

            const labels = daily.map(d => d.day);
            const values = daily.map(d => Math.round(d.amount / 1000)); // use in thousands for readable axis

            const ctx = document.getElementById('dailySalesChart');
            if (!ctx) return;

            // Responsive chart: determine locale currency formatting
            const options = {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    x: {
                        grid: { display: false },
                        ticks: { color: getComputedStyle(document.documentElement).getPropertyValue('--text-light') || '#6b7280' }
                    },
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(val){
                                // Tick label converting back to full currency
                                return 'Rp ' + (val * 1000).toLocaleString('id-ID');
                            },
                            color: getComputedStyle(document.documentElement).getPropertyValue('--text-light') || '#6b7280'
                        }
                    }
                },
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        callbacks: {
                            label: function(ctx){
                                const n = ctx.parsed.y * 1000; // reverse the /1000
                                return 'Rp ' + n.toLocaleString('id-ID');
                            }
                        }
                    }
                }
            };

            // Destroy existing if any (hot-reload safe)
            if (ctx._chart) ctx._chart.destroy();

            ctx._chart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        data: values,
                        backgroundColor: '#ec4899',
                        borderRadius: 6,
                        barPercentage: 0.6,
                    }]
                },
                options: options
            });
        })();
    </script>
@endpush

<!-- Top Products Table -->
<div class="table-container">
    <h3 class="chart-title" style="margin-bottom: 1.5rem;">Produk Terlaris</h3>
    <table>
        <thead>
            <tr>
                <th>Produk</th>
                <th>Jumlah Terjual</th>
                <th>Total Penjualan</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($financialData['topProducts'] as $product)
                <tr>
                    <td>{{ $product['name'] }}</td>
                    <td>{{ $product['quantity'] }} unit</td>
                    <td><span class="currency">Rp {{ number_format($product['sales'], 0, ',', '.') }}</span></td>
                    <td>
                        @if($product['quantity'] > 15)
                            <span class="badge badge-success">Laris</span>
                        @elseif($product['quantity'] > 10)
                            <span class="badge badge-warning">Normal</span>
                        @else
                            <span class="badge badge-danger">Lambat</span>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- Monthly Comparison -->
<div class="table-container">
    <h3 class="chart-title" style="margin-bottom: 1.5rem;">Perbandingan Bulanan</h3>
    <table>
        <thead>
            <tr>
                <th>Bulan</th>
                <th>Total Penjualan</th>
                <th>Perubahan</th>
            </tr>
        </thead>
        <tbody>
            @foreach($financialData['monthlyComparison'] as $index => $month)
                <tr>
                    <td>{{ $month['month'] }}</td>
                    <td><span class="currency">Rp {{ number_format($month['amount'], 0, ',', '.') }}</span></td>
                    <td>
                        @if($index > 0)
                            @php
                                $change = (($month['amount'] - $financialData['monthlyComparison'][$index-1]['amount']) / $financialData['monthlyComparison'][$index-1]['amount']) * 100;
                            @endphp
                            @if($change > 0)
                                <span class="badge badge-success">↑ {{ number_format($change, 1) }}%</span>
                            @else
                                <span class="badge badge-danger">↓ {{ number_format(abs($change), 1) }}%</span>
                            @endif
                        @else
                            <span class="badge" style="background: #e0e0e0; color: #666;">Dasar</span>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endsection

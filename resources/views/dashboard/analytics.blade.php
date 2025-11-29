@extends('dashboard.layout')

@section('title', 'Analitik Keuangan')

@section('content')

<style>
    .analytics-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2rem;
    }

    .analytics-title {
        font-size: 2rem;
        font-weight: 700;
        color: var(--text-dark, #1f2937);
    }

    .analytics-subtitle {
        font-size: 0.875rem;
        color: var(--text-light, #6b7280);
        margin-top: 0.25rem;
    }

    .back-btn {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.75rem 1.5rem;
        background: linear-gradient(135deg, #ec4899 0%, #f97316 100%);
        color: white;
        border: none;
        border-radius: 8px;
        font-weight: 600;
        cursor: pointer;
        text-decoration: none;
        transition: all 0.3s ease;
    }

    .back-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
    }

    .analytics-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }

    .metric-card {
        background: white;
        border-radius: 12px;
        padding: 1.5rem;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        border-left: 4px solid var(--primary-color, #ec4899);
        transition: all 0.3s ease;
    }

    .metric-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
    }

    .metric-label {
        font-size: 0.875rem;
        color: var(--text-light, #6b7280);
        text-transform: uppercase;
        font-weight: 600;
        margin-bottom: 0.5rem;
    }

    .metric-value {
        font-size: 1.875rem;
        font-weight: 700;
        color: var(--text-dark, #1f2937);
    }

    .metric-subtext {
        font-size: 0.75rem;
        color: var(--text-light, #6b7280);
        margin-top: 0.5rem;
    }

    .chart-container {
        background: white;
        border-radius: 12px;
        padding: 2rem;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        margin-bottom: 2rem;
    }

    .chart-title {
        font-size: 1.25rem;
        font-weight: 700;
        color: var(--text-dark, #1f2937);
        margin-bottom: 1.5rem;
    }

    .chart-wrapper {
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 300px;
        background: linear-gradient(135deg, rgba(236, 72, 153, 0.05) 0%, rgba(249, 115, 22, 0.05) 100%);
        border-radius: 8px;
        padding: 2rem;
    }

    .pie-chart {
        width: 150px;
        height: 150px;
        border-radius: 50%;
        background: conic-gradient(
            #ec4899 0% 94%,
            #f97316 94% 100%
        );
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    }

    .pie-chart::after {
        content: '';
        position: absolute;
        width: 120px;
        height: 120px;
        background: white;
        border-radius: 50%;
    }

    .pie-label {
        position: absolute;
        font-weight: 700;
        font-size: 1.5rem;
        color: var(--text-dark, #1f2937);
        z-index: 1;
    }

    .pie-stats {
        display: flex;
        gap: 2rem;
        margin-top: 1.5rem;
        justify-content: center;
    }

    .pie-stat {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        font-size: 0.875rem;
    }

    .pie-stat-dot {
        width: 12px;
        height: 12px;
        border-radius: 2px;
    }

    .bar-chart {
        display: flex;
        align-items: flex-end;
        gap: 1rem;
        height: 200px;
        justify-content: space-around;
        padding: 1rem 0;
    }

    .bar {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 0.5rem;
    }

    .bar-column {
        background: linear-gradient(180deg, #ec4899 0%, #f97316 100%);
        border-radius: 4px 4px 0 0;
        min-width: 40px;
        transition: all 0.3s ease;
    }

    .bar-column:hover {
        opacity: 0.8;
    }

    .bar-label {
        font-size: 0.75rem;
        color: var(--text-light, #6b7280);
        font-weight: 600;
    }

    .bar-value {
        font-size: 0.75rem;
        color: var(--text-dark, #1f2937);
        font-weight: 700;
    }

    .table-container {
        overflow-x: auto;
        background: white;
        border-radius: 12px;
        padding: 1.5rem;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        margin-bottom: 2rem;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    th {
        background: linear-gradient(135deg, rgba(236, 72, 153, 0.1) 0%, rgba(249, 115, 22, 0.1) 100%);
        padding: 1rem;
        text-align: left;
        font-weight: 600;
        color: var(--text-dark, #1f2937);
        font-size: 0.875rem;
        text-transform: uppercase;
        border-bottom: 2px solid #e5e7eb;
    }

    td {
        padding: 1rem;
        border-bottom: 1px solid #e5e7eb;
        color: var(--text-dark, #1f2937);
    }

    tr:hover {
        background: #f9fafb;
    }

    .badge {
        display: inline-block;
        padding: 0.25rem 0.75rem;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
    }

    .badge-success {
        background: #d1fae5;
        color: #065f46;
    }

    .badge-warning {
        background: #fed7aa;
        color: #92400e;
    }

    .badge-danger {
        background: #fee2e2;
        color: #7f1d1d;
    }

    .currency {
        font-weight: 600;
        color: var(--primary-color, #ec4899);
    }

    @media (max-width: 768px) {
        .analytics-header {
            flex-direction: column;
            gap: 1rem;
            align-items: flex-start;
        }

        .analytics-grid {
            grid-template-columns: 1fr;
        }

        .chart-wrapper {
            min-height: 250px;
        }

        .bar-chart {
            height: 150px;
            gap: 0.75rem;
        }

        .bar-column {
            min-width: 30px;
        }

        .pie-stats {
            flex-direction: column;
            gap: 1rem;
        }

        table {
            font-size: 0.875rem;
        }

        th, td {
            padding: 0.75rem;
        }
    }
</style>

<div class="analytics-header">
    <div>
        <h1 class="analytics-title">📊 Analitik Keuangan</h1>
        <p class="analytics-subtitle">Laporan performa dan transaksi bulan {{ $financialData['currentMonth'] }}</p>
    </div>
    <a href="{{ route('dashboard') }}" class="back-btn">← Kembali ke Dashboard</a>
</div>

<!-- Key Metrics -->
<div class="analytics-grid">
    <div class="metric-card" style="border-left-color: #ec4899;">
        <div class="metric-label">Penjualan Bulan Ini</div>
        <div class="metric-value"><span class="currency">Rp</span> {{ number_format($financialData['salesThisMonth'], 0, ',', '.') }}</div>
        <div class="metric-subtext">Total transaksi: {{ $financialData['totalTransactions'] }}</div>
    </div>

    <div class="metric-card" style="border-left-color: #f97316;">
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
                                <div class="pie-stat-dot" style="background: #ec4899;"></div>
                                <span>Sukses: {{ $financialData['transactionStatus']['completed'] }}</span>
                            </div>
                            <div class="pie-stat">
                                <div class="pie-stat-dot" style="background: #f97316;"></div>
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

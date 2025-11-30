@extends('dashboard.layout')

@section('title', 'Analitik Keuangan')

@section('content')

<style>
    :root{
        --primary: #C7B7FF;
        --primary-dark: #8B5A9E;
        --text-dark: #1F2937;
        --text-muted: #6B7280;
        --border: #E5E7EB;
    }

    .analytics-container{
        max-width: 980px;
        margin: 0 auto;
        padding: 18px 14px;
    }

    .analytics-header{
        display:flex;
        justify-content:space-between;
        align-items:center;
        gap:12px;
        margin-bottom:18px;
        flex-wrap:wrap;
    }

    .analytics-title{ font-size:24px; font-weight:800; color:var(--text-dark); margin:0; }
    .analytics-subtitle{ font-size:13px; color:var(--text-muted); margin:0; }

    .back-btn{ display:inline-block; padding:8px 12px; background:#fff; color:var(--primary-dark); border:1px solid rgba(139,90,158,0.12); border-radius:8px; font-weight:700; text-decoration:none; }

    .analytics-grid{ display:grid; grid-template-columns: repeat(auto-fit,minmax(200px,1fr)); gap:12px; margin-bottom:16px; }

    .metric-card{ background:#fff; border-radius:10px; padding:14px; box-shadow:0 1px 6px rgba(16,24,40,0.04); border:1px solid var(--border); border-left:6px solid var(--primary); transition:transform .18s ease, box-shadow .18s ease; }
    .metric-card:hover{ transform: translateY(-6px) scale(1.02); box-shadow:0 10px 30px rgba(139,90,158,0.08); }

    .metric-label{ font-size:11px; color:var(--text-muted); font-weight:600; text-transform:uppercase; margin-bottom:6px; }
    .metric-value{ font-size:18px; font-weight:600; color:var(--primary-dark); margin-bottom:6px; }
    .metric-subtext{ font-size:12px; color:var(--text-muted); font-weight:500; }
    .trend { font-size:12px; display:inline-flex; align-items:center; gap:6px; margin-left:8px; }
    .trend-up { color:#059669; font-weight:700; }
    .trend-down { color:#dc2626; font-weight:700; }
    .trend-neutral { color:var(--text-muted); font-weight:700; }

    .chart-container{ background:#fff; border-radius:8px; padding:14px; box-shadow:0 1px 6px rgba(16,24,40,0.04); border:1px solid var(--border); margin-bottom:16px; }
    .chart-title{ font-size:14px; font-weight:700; color:var(--text-dark); margin:0 0 10px 0; }

    .chart-wrapper{ display:flex; align-items:center; justify-content:center; gap:18px; min-height:220px; padding:12px; background:transparent; border-radius:6px; }

    /* Elegant donut ring */
    .pie-chart{ width:160px; height:160px; border-radius:50%; display:flex; align-items:center; justify-content:center; position:relative; box-shadow:0 6px 18px rgba(139,90,158,0.06); transition:transform .2s ease, box-shadow .2s ease; margin:0 auto; }
    .pie-chart::after{ content:''; position:absolute; width:104px; height:104px; background:#fff; border-radius:50%; box-shadow: inset 0 1px 0 rgba(0,0,0,0.02); }
    .pie-chart:hover{ transform: scale(1.04); box-shadow:0 14px 40px rgba(139,90,158,0.09); }
    .pie-label{ position:absolute; font-weight:700; font-size:18px; color:var(--primary-dark); z-index:1; }

    /* Detail panel: simpler info cards */
    .detail .metric-card{ border-left-width:4px !important; padding:10px !important; box-shadow:none !important; }
    .detail .metric-card .metric-value{ font-weight:600; font-size:16px; }

    .pie-stats{ display:flex; gap:12px; margin-top:10px; justify-content:center; }
    .pie-stat{ display:flex; align-items:center; gap:8px; font-size:13px; color:var(--text-dark); font-weight:600; }
    .pie-stat-dot{ width:10px; height:10px; border-radius:3px; flex-shrink:0; }

    .table-container{ overflow-x:auto; background:#fff; border-radius:8px; padding:14px; box-shadow:0 1px 6px rgba(16,24,40,0.04); border:1px solid var(--border); margin-bottom:16px; }

    table{ width:100%; border-collapse:collapse; }
    th{ padding:10px 8px; text-align:left; font-weight:700; font-size:12px; color:var(--text-dark); background:transparent; }
    td{ padding:10px 8px; border-bottom:1px solid var(--border); color:var(--text-dark); font-size:13px; }
    tr:hover td{ background:rgba(0,0,0,0.02); }

    .badge{ display:inline-block; padding:4px 8px; border-radius:6px; font-size:11px; font-weight:700; text-transform:uppercase; }
    .badge-success{ background:rgba(199,183,255,0.15); color:var(--primary-dark); }
    .badge-warning{ background:rgba(255,214,224,0.25); color:#D64A5C; }
    .badge-danger{ background:rgba(255,107,107,0.12); color:#DC2626; }

    .currency{ font-weight:800; color:var(--primary-dark); }

    @media (max-width:768px){
        .analytics-container{ padding:14px; }
        .analytics-title{ font-size:18px; }
        .chart-wrapper{ min-height:200px; }
        .metric-card{ padding:10px; }
    }
</style>

<div class="analytics-container">
    <div class="analytics-header">
        <div class="analytics-header-info">
            <h2 class="analytics-title">Analitik Keuangan</h2>
            <p class="analytics-subtitle">Laporan Analitik dan Transaksi {{ $financialData['currentMonth'] }}</p>
        </div>
    </div>

<!-- Key Metrics -->
<div class="analytics-grid">
    @php
        // previous period safe fallbacks
        $prevMonthSales = $financialData['previousMonthSales'] ?? null;
        if (is_null($prevMonthSales) && !empty($financialData['monthlyComparison']) && count($financialData['monthlyComparison']) > 1) {
            // use previous entry (last - 1) if available
            $mc = $financialData['monthlyComparison'];
            $prevMonthSales = $mc[count($mc)-2]['amount'] ?? null;
        }

        $prevWeekSales = $financialData['previousWeekSales'] ?? null;
        // previous success rate fallback
        $prevSuccessRate = $financialData['previousSuccessRate'] ?? null;

        // helper to compute percent change (return null when not computable)
        $percentChange = function($current, $previous){
            if (is_null($previous) || $previous == 0) return null;
            return round((($current - $previous) / abs($previous)) * 100, 1);
        };

        $salesMonthChange = $percentChange($financialData['salesThisMonth'] ?? 0, $prevMonthSales);
        $salesWeekChange = $percentChange($financialData['salesThisWeek'] ?? 0, $prevWeekSales);
        $successRateChange = $percentChange($financialData['successRate'] ?? 0, $prevSuccessRate);
    @endphp
    <div class="metric-card" style="border-left-color: #FFB5A7;">
        <div class="metric-label">Penjualan Bulan Ini
            @if(!is_null($salesMonthChange))
                <span class="trend {{ $salesMonthChange >= 0 ? 'trend-up' : 'trend-down' }}">{{ $salesMonthChange >= 0 ? '▲' : '▼' }} {{ abs($salesMonthChange) }}%</span>
            @else
                <span class="trend trend-neutral">—</span>
            @endif
        </div>
        <div class="metric-value"><span class="currency">Rp</span> <span class="animate-number" data-value="{{ $financialData['salesThisMonth'] }}">0</span></div>
        <div class="metric-subtext">Total transaksi: {{ $financialData['totalTransactions'] }}</div>
    </div>

    <div class="metric-card" style="border-left-color: #FCD5CE;">
        <div class="metric-label">Penjualan Minggu Ini
            @if(!is_null($salesWeekChange))
                <span class="trend {{ $salesWeekChange >= 0 ? 'trend-up' : 'trend-down' }}">{{ $salesWeekChange >= 0 ? '▲' : '▼' }} {{ abs($salesWeekChange) }}%</span>
            @else
                <span class="trend trend-neutral">—</span>
            @endif
        </div>
        <div class="metric-value"><span class="currency">Rp</span> <span class="animate-number" data-value="{{ $financialData['salesThisWeek'] }}">0</span></div>
        <div class="metric-subtext">Per minggu (7 hari)</div>
    </div>

    <div class="metric-card" style="border-left-color: #10b981;">
        <div class="metric-label">Tingkat Sukses
            @if(!is_null($successRateChange))
                <span class="trend {{ $successRateChange >= 0 ? 'trend-up' : 'trend-down' }}">{{ $successRateChange >= 0 ? '▲' : '▼' }} {{ abs($successRateChange) }}%</span>
            @else
                <span class="trend trend-neutral">—</span>
            @endif
        </div>
        <div class="metric-value"><span class="animate-number" data-value="{{ $financialData['successRate'] }}">0</span>%</div>
        <div class="metric-subtext">Transaksi berhasil</div>
    </div>
</div>

<!-- Transaction Status Chart -->
<div class="chart-container">
    <h3 class="chart-title">Status Transaksi</h3>
    <div class="chart-wrapper">
            <div style="display: flex; gap: 28px; align-items: flex-start; flex-wrap:wrap; justify-content:center; width:100%;">
            <div class="pie-chart">
                <canvas id="statusDonut" width="140" height="140" aria-label="Status transaksi" role="img"></canvas>
                <div class="pie-label" id="statusDonutLabel">{{ $financialData['successRate'] }}%</div>
            </div>

            {{-- Detail panel: compact analytics beside donut --}}
            <div style="flex:1; min-width:260px; max-width:520px;">
                @php
                    $completed = $financialData['transactionStatus']['completed'] ?? 0;
                    $pending = $financialData['transactionStatus']['pending'] ?? 0;
                    $cancelled = $financialData['transactionStatus']['cancelled'] ?? 0;
                    $totalTx = $financialData['totalTransactions'] ?? ($completed + $pending + $cancelled);
                    $salesThisMonth = $financialData['salesThisMonth'] ?? 0;
                    $avgOrder = $totalTx ? intval($salesThisMonth / max(1, $totalTx)) : 0;
                    $dailyAmounts = array_column($financialData['dailySales'] ?? [], 'amount');
                    $days = count($dailyAmounts) ?: 1;
                    $avgPerDay = $days ? intval(array_sum($dailyAmounts) / $days) : 0;
                    $topProduct = $financialData['topProducts'][0]['name'] ?? '-';
                @endphp

                <div style="display:grid; grid-template-columns:repeat(2,1fr); gap:10px;">
                    <div class="metric-card" style="border-left-color: #8B5A9E; padding:10px;">
                        <div class="metric-label">Total Transaksi</div>
                        <div class="metric-value">{{ $totalTx }}</div>
                        <div class="metric-subtext">Per bulan</div>
                    </div>

                    <div class="metric-card" style="border-left-color: #FFB5A7; padding:10px;">
                        <div class="metric-label">Rata-rata / Transaksi</div>
                        <div class="metric-value"><span class="currency">Rp</span> {{ number_format($avgOrder,0,',','.') }}</div>
                        <div class="metric-subtext">Per transaksi</div>
                    </div>

                    <div class="metric-card" style="border-left-color: #FCD5CE; padding:10px;">
                        <div class="metric-label">Rata-rata / Hari</div>
                        <div class="metric-value"><span class="currency">Rp</span> {{ number_format($avgPerDay,0,',','.') }}</div>
                        <div class="metric-subtext">Dalam periode</div>
                    </div>

                    <div class="metric-card" style="border-left-color: #10b981; padding:10px;">
                        <div class="metric-label">Produk Teratas</div>
                        <div class="metric-value" style="font-size:15px;">{{ $topProduct }}</div>
                        <div class="metric-subtext">Berdasarkan penjualan</div>
                    </div>
                </div>

                <div style="margin-top:12px; display:flex; gap:8px; align-items:center;">
                    <div class="pie-stat" style="display:flex; align-items:center; gap:8px;">
                        <div class="pie-stat-dot" style="width:12px;height:12px;background:#8B5A9E;border-radius:3px"></div>
                        <div><strong>{{ $completed }}</strong> Sukses</div>
                    </div>
                    <div class="pie-stat" style="display:flex; align-items:center; gap:8px;">
                        <div class="pie-stat-dot" style="width:12px;height:12px;background:#FFD6E0;border-radius:3px"></div>
                        <div><strong>{{ $pending }}</strong> Pending</div>
                    </div>
                    <div class="pie-stat" style="display:flex; align-items:center; gap:8px;">
                        <div class="pie-stat-dot" style="width:12px;height:12px;background:#ef4444;border-radius:3px"></div>
                        <div><strong>{{ $cancelled }}</strong> Batal</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <!-- Chart.js via CDN (lightweight & widely used) -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.3.0/dist/chart.umd.min.js"></script>
    <script>
        // Animated number counter with smooth easing
        function animateNumbers() {
            const elements = document.querySelectorAll('.animate-number');
            elements.forEach((el, idx) => {
                setTimeout(() => {
                    const target = parseInt(el.dataset.value) || 0;
                    const duration = 1200;
                    const start = performance.now();
                    const easeOutCubic = (t) => 1 - Math.pow(1 - t, 3);

                    function frame(now) {
                        const elapsed = now - start;
                        const progress = Math.min(elapsed / duration, 1);
                        const eased = easeOutCubic(progress);
                        const current = Math.floor(target * eased);
                        el.textContent = current.toLocaleString('id-ID');
                        if (progress < 1) requestAnimationFrame(frame);
                        else el.textContent = target.toLocaleString('id-ID');
                    }

                    requestAnimationFrame(frame);
                }, idx * 100);
            });
        }

        // Initialize on page load
        document.addEventListener('DOMContentLoaded', () => {
            animateNumbers();
        });

        (function () {
            // Prepare data from server-rendered PHP variable
            const daily = @json($financialData['dailySales']);

            const labels = daily.map(d => d.day);
            const values = daily.map(d => Math.round(d.amount / 1000000)); // use in millions for readable axis

            const ctx = document.getElementById('dailySalesChart');
            if (!ctx) return;

            const options = {
                responsive: true,
                maintainAspectRatio: false,
                animation: { duration: 1000, easing: 'easeInOutQuad' },
                scales: {
                    x: { grid: { display: false }, ticks: { color: '#6b7280' } },
                    y: { beginAtZero: true, grid: { color: 'rgba(139,90,158,0.06)' }, ticks: { callback: (v) => 'Rp ' + v + 'M', color: '#6b7280' } }
                },
                plugins: { legend: { display: false } }
            };

            if (ctx._chart) ctx._chart.destroy();

            const ctx2 = ctx.getContext('2d');
            const gradient = ctx2.createLinearGradient(0, 0, 0, 320);
            gradient.addColorStop(0, 'rgba(139, 90, 158, 0.14)');
            gradient.addColorStop(1, 'rgba(139, 90, 158, 0.02)');

            ctx._chart = new Chart(ctx, {
                type: 'line',
                data: { labels, datasets: [{ label: 'Penjualan', data: values, borderColor: '#8B5A9E', backgroundColor: gradient, fill: true, tension: 0.35, pointRadius: 4, borderWidth: 2 }] },
                options
            });

            // Soft fade-in for canvas
            ctx.style.opacity = 0;
            let start = null;
            function fadeIn(ts) {
                if (!start) start = ts;
                const progress = Math.min((ts - start) / 350, 1);
                ctx.style.opacity = progress;
                if (progress < 1) requestAnimationFrame(fadeIn);
            }
            requestAnimationFrame(fadeIn);

            // Render status donut using Chart.js (animated) and update center label during animation
            (function renderStatusDonut(){
                const data = @json($financialData['transactionStatus']);
                const completed = data.completed || 0;
                const pending = data.pending || 0;
                const cancelled = data.cancelled || 0;
                const total = completed + pending + cancelled || 1;
                const computedSuccess = Math.round((completed / total) * 100);

                const canvas = document.getElementById('statusDonut');
                const centerLabel = document.getElementById('statusDonutLabel');
                if (!canvas) return;

                const statusChart = new Chart(canvas, {
                    type: 'doughnut',
                    data: {
                        labels: ['Sukses','Pending','Batal'],
                        datasets: [{
                            data: [completed, pending, cancelled],
                            backgroundColor: ['#8B5A9E', '#FFD6E0', '#ef4444'],
                            hoverOffset: 8,
                            borderWidth: 0
                        }]
                    },
                    options: {
                        cutout: '78%',
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            // legend positioned at bottom so chart appears centered visually
                            legend: { position: 'bottom', align: 'center', labels: { usePointStyle: true, pointStyle: 'circle', boxWidth: 10 } },
                            tooltip: { callbacks: { label: function(ctx){ return ctx.label + ': ' + ctx.parsed + ' transaksi'; } } }
                        },
                        animation: {
                            duration: 900,
                            easing: 'easeOutCubic',
                            onProgress: function(anim) {
                                const progress = anim.currentStep / Math.max(anim.numSteps,1);
                                const current = Math.round(computedSuccess * progress);
                                if (centerLabel) centerLabel.textContent = current + '%';
                            },
                            onComplete: function() { if (centerLabel) centerLabel.textContent = computedSuccess + '%'; }
                        }
                    }
                });
            })();
        })();
    </script>
@endpush

<!-- Top Products Table -->
<div class="table-container">
    <h3 class="chart-title">Produk Terlaris</h3>
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
                            <span class="badge badge-danger">Kurang</span>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- Monthly Comparison -->
<div class="table-container">
    <h3 class="chart-title">Perbandingan Bulanan</h3>
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
                            <span class="badge" style="background: #f3f4f6; color: #6b7280;">Dasar</span>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
</div>

@endsection

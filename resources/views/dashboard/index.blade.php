@extends('dashboard.layout')

@section('title', 'Dashboard')

@section('content')

    <style>
        .dashboard-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
            margin-bottom: 28px;
        }

        .dashboard-header h1 {
            margin: 0 0 4px 0;
            font-size: 28px;
            color: var(--text);
            font-weight: 700;
        }

        .dashboard-header p {
            margin: 0;
            font-size: 14px;
            color: var(--muted);
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .user-details {
            text-align: right;
        }

        .user-details-name {
            font-weight: 700;
            color: var(--text);
        }

        .user-details-role {
            font-size: 12px;
            color: var(--muted);
        }

        .role-badge {
            background: linear-gradient(90deg, var(--pastel-accent), var(--pastel-accent-2));
            color: #fff;
            padding: 6px 12px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 12px;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 18px;
            margin-bottom: 28px;
        }

        .stat-card {
            background: var(--pastel-card);
            border-radius: 14px;
            padding: 22px;
            box-shadow: 0 8px 20px rgba(34, 34, 59, 0.04);
            border: 1px solid rgba(199, 183, 255, 0.1);
        }

        .stat-card h3 {
            margin: 0 0 12px 0;
            font-size: 14px;
            font-weight: 600;
            color: var(--muted);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .stat-card p {
            margin: 0;
            font-size: 28px;
            font-weight: 700;
            color: #231d43;
        }

        .activity-section {
            background: var(--pastel-card);
            border-radius: 14px;
            padding: 22px;
            box-shadow: 0 8px 20px rgba(34, 34, 59, 0.04);
            border: 1px solid rgba(199, 183, 255, 0.1);
        }

        .activity-section h3 {
            margin: 0 0 16px 0;
            font-size: 16px;
            font-weight: 700;
            color: var(--text);
        }

        .activity-list {
            list-style: none;
            margin: 0;
            padding: 0;
        }

        .activity-list li {
            padding: 10px 0;
            font-size: 14px;
            color: var(--text);
            border-bottom: 1px solid rgba(199, 183, 255, 0.1);
        }

        .activity-list li:last-child {
            border-bottom: none;
        }

        .activity-list strong {
            color: #5748ad;
            font-weight: 600;
        }

        @media (max-width: 768px) {
            .dashboard-header {
                flex-direction: column;
                align-items: flex-start;
            }

            .stats-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>

    <div class="dashboard-header">
        <div>
            <h1>Dashboard</h1>
            <p>Ringkasan Performa dan Aktivitas.</p>
        </div>

        <div class="user-info">
            @if (auth()->check())
                <div class="user-details">
                    <div class="user-details-name">{{ auth()->user()->name }}</div>
                    <div class="user-details-role">{{ ucfirst(auth()->user()->role) }}</div>
                </div>
                <div class="role-badge">{{ strtoupper(auth()->user()->role) }}</div>
            @endif
        </div>
    </div>

    <!-- Feature highlights (buyers) -->
    <div class="feature-highlights" style="margin-bottom:20px;">
        <style>
            .features-row {
                display: flex;
                gap: 24px;
                align-items: flex-start;
                justify-content: space-between;
            }

            .feature-item {
                display: flex;
                gap: 12px;
                align-items: flex-start;
                flex: 1;
                min-width: 180px;
            }

            .feature-item img {
                width: 46px;
                height: 46px;
                object-fit: contain;
                flex: 0 0 46px;
            }

            .feature-item h4 {
                margin: 0;
                font-size: 15px;
                font-weight: 700;
                color: var(--text);
            }

            .feature-item p {
                margin: 4px 0 0 0;
                font-size: 13px;
                color: var(--muted);
                line-height: 1.3;
            }

            @media (max-width:900px) {
                .features-row {
                    flex-direction: column;
                    gap: 12px;
                }

                .feature-item img {
                    width: 40px;
                    height: 40px;
                }
            }
        </style>

        {{-- <div class="features-row">
            <div class="feature-item">
                <img src="{{ asset('images/feature-personalized.svg') }}" alt="Personalized Services" />
                <div>
                    <h4>Personalized Services</h4>
                    <p>Rekomendasi secara personal untuk occasion Anda. Gratis!</p>
                </div>
            </div>

            <div class="feature-item">
                <img src="{{ asset('images/feature-ontime.svg') }}" alt="Garansi Tepat Waktu" />
                <div>
                    <h4>Garansi Tepat Waktu</h4>
                    <p>Pesanan Anda dijamin tiba sesuai jadwal.</p>
                </div>
            </div>

            <div class="feature-item">
                <img src="{{ asset('images/feature-wide-reach.svg') }}" alt="Jangkauan Luas" />
                <div>
                    <h4>Jangkauan Luas</h4>
                    <p>Kirim ke lebih dari 200++ kota di Indonesia.</p>
                </div>
            </div>

            <div class="feature-item">
                <img src="{{ asset('images/feature-free-shipping.svg') }}" alt="Gratis Ongkir" />
                <div>
                    <h4>Gratis Ongkir</h4>
                    <p>FREE ONGKIR* Pengiriman dalam kota.</p>
                </div>
            </div>
        </div> --}}
    </div>



    <div class="stats-grid">
        <div class="stat-card">
            <h3>Penjualan Hari Ini</h3>
            <p>Rp 1.250.000</p>
        </div>

        <div class="stat-card">
            <h3>Total Bulanan</h3>
            <p>Rp 5.860.000</p>
        </div>

        <div class="stat-card">
            <h3>Admin Aktif</h3>
            <p>4 orang</p>
        </div>

    </div>

    <div class="activity-section">
        <h3>Aktivitas Terakhir</h3>
        <ul class="activity-list">
            <li>1. Riwayat login admin: <strong>2 jam lalu</strong></li>
            <li>2. Pesanan baru: <strong>3 pesanan</strong></li>
            <li>3. Stok <strong>Baby Blooms Bouquet</strong> di bawah threshold</li>
        </ul>
    </div>

@endsection

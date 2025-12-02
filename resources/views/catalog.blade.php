@extends('dashboard.layout')

@section('content')
    <div class="dashboard-container">
        <div class="content-header">
            <h1>📋 Preview Katalog</h1>
            <p class="text-muted">Lihat tampilan katalog produk dari perspektif pelanggan</p>
        </div>

        @if ($products->isEmpty())
            <div class="empty-state">
                <p class="empty-icon">🌸</p>
                <p class="empty-text">Belum ada produk. <a href="{{ route('dashboard.jenis.index') }}">Tambah produk
                        sekarang</a></p>
            </div>
        @else
            <div class="catalog-grid">
                @foreach ($products as $product)
                    <div class="product-card">
                        <div class="product-image">
                            @if ($product->image)
                                <img src="{{ asset($product->image) }}?v={{ strtotime($product->updated_at) }}"
                                    alt="{{ $product->name }}">
                            @else
                                <div class="placeholder-image">No Image</div>
                            @endif
                        </div>
                        <div class="product-info">
                            <h3 class="product-name">{{ $product->name }}</h3>
                            <p class="product-description">{{ Str::limit($product->description, 100) }}</p>
                            <div class="product-footer">
                                <span class="product-price">Rp
                                    {{ number_format((float) $product->price, 0, ',', '.') }}</span>
                                <a href="{{ route('jenis.show', $product->slug) }}" class="btn-view" target="_blank">Lihat
                                    Detail</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <style>
        .dashboard-container {
            padding: 30px;
        }

        .content-header {
            margin-bottom: 30px;
        }

        .content-header h1 {
            font-size: 28px;
            font-weight: 700;
            color: #333;
            margin: 0 0 8px 0;
        }

        .text-muted {
            color: #999;
            font-size: 14px;
            margin: 0;
        }

        .empty-state {
            background: #faf8ff;
            border: 2px dashed #c7b7ff;
            border-radius: 12px;
            padding: 60px 30px;
            text-align: center;
        }

        .empty-icon {
            font-size: 48px;
            margin: 0 0 16px 0;
        }

        .empty-text {
            color: #666;
            font-size: 16px;
            margin: 0;
        }

        .empty-text a {
            color: #c7b7ff;
            font-weight: 600;
            text-decoration: none;
        }

        .empty-text a:hover {
            text-decoration: underline;
        }

        .catalog-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 24px;
        }

        .product-card {
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            border: 1px solid #f0f0f0;
        }

        .product-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 16px rgba(199, 183, 255, 0.15);
        }

        .product-image {
            width: 100%;
            height: 240px;
            background: linear-gradient(135deg, #f8f6ff 0%, #fff5f8 100%);
            overflow: hidden;
        }

        .product-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .placeholder-image {
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #ccc;
            font-size: 14px;
            background: linear-gradient(135deg, #f0f0f0 0%, #e8e8e8 100%);
        }

        .product-info {
            padding: 20px;
        }

        .product-name {
            font-size: 16px;
            font-weight: 600;
            color: #333;
            margin: 0 0 8px 0;
            line-height: 1.3;
        }

        .product-description {
            font-size: 13px;
            color: #999;
            margin: 0 0 16px 0;
            line-height: 1.4;
        }

        .product-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .product-price {
            font-size: 15px;
            font-weight: 700;
            color: #c7b7ff;
        }

        .btn-view {
            padding: 8px 16px;
            background: linear-gradient(135deg, #c7b7ff 0%, #ffd6e0 100%);
            color: white;
            text-decoration: none;
            border-radius: 6px;
            font-size: 12px;
            font-weight: 600;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
        }

        .btn-view:hover {
            transform: scale(1.05);
            box-shadow: 0 4px 12px rgba(199, 183, 255, 0.4);
        }

        @media (max-width: 768px) {
            .catalog-grid {
                grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
                gap: 16px;
            }

            .content-header h1 {
                font-size: 24px;
            }

            .product-image {
                height: 180px;
            }
        }
    </style>
@endsection

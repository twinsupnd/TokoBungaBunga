@extends('dashboard.layout')

@section('title', 'Laporan')

@section('content')

<style>
    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2rem;
        gap: 1rem;
    }

    .page-title {
        font-size: 2rem;
        font-weight: 700;
        color: #1f2937;
    }

    .page-subtitle {
        font-size: 0.875rem;
        color: #6b7280;
        margin-top: 0.25rem;
    }

    .alert-success {
        background: #d1fae5;
        color: #065f46;
        border: 1px solid #a7f3d0;
        padding: 1rem;
        border-radius: 8px;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
        font-weight: 500;
    }

    .reviews-container {
        background: white;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    }

    .review-item {
        padding: 1.5rem;
        border-bottom: 1px solid #e5e7eb;
        transition: background 0.2s ease;
    }

    .review-item:hover {
        background: #f9fafb;
    }

    .review-item:last-child {
        border-bottom: none;
    }

    .review-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 1rem;
        gap: 1rem;
    }

    .reviewer-info {
        display: flex;
        gap: 1rem;
        flex: 1;
    }

    .reviewer-avatar {
        width: 48px;
        height: 48px;
        border-radius: 50%;
        background: linear-gradient(135deg, #ec4899 0%, #f97316 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: 700;
        font-size: 1rem;
        flex-shrink: 0;
    }

    .reviewer-details {
        display: flex;
        flex-direction: column;
        gap: 0.25rem;
    }

    .reviewer-name {
        font-weight: 600;
        color: #1f2937;
        font-size: 0.95rem;
    }

    .review-date {
        font-size: 0.75rem;
        color: #6b7280;
    }

    .review-product {
        font-size: 0.85rem;
        color: #ec4899;
        font-weight: 500;
    }

    .rating-stars {
        display: flex;
        gap: 0.25rem;
        margin: 0.5rem 0;
    }

    .star {
        color: #fbbf24;
        font-size: 1rem;
    }

    .review-comment {
        color: #374151;
        line-height: 1.6;
        margin: 1rem 0;
        padding: 0.75rem;
        background: #f9fafb;
        border-left: 3px solid #ec4899;
        border-radius: 4px;
        font-size: 0.95rem;
    }

    .review-actions {
        display: flex;
        gap: 0.5rem;
        justify-content: flex-end;
    }

    .btn-delete {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        padding: 0.5rem 1rem;
        background: #fee2e2;
        color: #dc2626;
        border: none;
        border-radius: 6px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        font-size: 0.875rem;
    }

    .btn-delete:hover {
        background: #fecaca;
        transform: translateY(-2px);
    }

    .empty-state {
        text-align: center;
        padding: 3rem 1rem;
        background: white;
        border-radius: 12px;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    }

    .empty-icon {
        font-size: 3rem;
        margin-bottom: 1rem;
    }

    .empty-title {
        font-size: 1.25rem;
        font-weight: 700;
        color: #1f2937;
        margin-bottom: 0.5rem;
    }

    .empty-subtitle {
        color: #6b7280;
    }

    .pagination-wrapper {
        margin-top: 2rem;
        display: flex;
        justify-content: center;
    }

    .pagination {
        display: flex;
        gap: 0.5rem;
        align-items: center;
    }

    .pagination a,
    .pagination span {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 36px;
        height: 36px;
        border-radius: 6px;
        border: 1px solid #e5e7eb;
        color: #1f2937;
        text-decoration: none;
        transition: all 0.3s ease;
        font-weight: 500;
    }

    .pagination a:hover {
        background: linear-gradient(135deg, #ec4899 0%, #f97316 100%);
        color: white;
        border-color: transparent;
    }

    .pagination .active span {
        background: linear-gradient(135deg, #ec4899 0%, #f97316 100%);
        color: white;
        border-color: transparent;
    }

    @media (max-width: 768px) {
        .page-header {
            flex-direction: column;
            align-items: flex-start;
        }

        .review-header {
            flex-direction: column;
            align-items: flex-start;
        }

        .review-actions {
            width: 100%;
            margin-top: 1rem;
        }

        .btn-delete {
            flex: 1;
            justify-content: center;
        }

        .pagination {
            flex-wrap: wrap;
        }
    }
</style>

<div class="page-header">
    <div>
        <h1 class="page-title">📋 Laporan & Komentar</h1>
        <p class="page-subtitle">Kelola komentar dan ulasan dari pelanggan</p>
    </div>
</div>

@if(session('success'))
    <div class="alert-success">
        ✓ {{ session('success') }}
    </div>
@endif

@if($reviews->count() > 0)
    <div class="reviews-container">
        @foreach($reviews as $review)
            <div class="review-item">
                <div class="review-header">
                    <div class="reviewer-info">
                        <div class="reviewer-avatar">
                            {{ strtoupper(substr($review->user->name, 0, 1)) }}
                        </div>
                        <div class="reviewer-details">
                            <div class="reviewer-name">{{ $review->user->name }}</div>
                            <div class="review-date">
                                {{ $review->created_at->format('d M Y H:i') }}
                            </div>
                            <div class="review-product">
                                📦 {{ $review->jenis->nama ?? 'Produk Tidak Diketahui' }}
                            </div>
                        </div>
                    </div>
                    <div class="rating-stars">
                        @for($i = 0; $i < $review->rating; $i++)
                            <span class="star">★</span>
                        @endfor
                        @for($i = $review->rating; $i < 5; $i++)
                            <span class="star" style="color: #d1d5db;">★</span>
                        @endfor
                    </div>
                </div>

                <div class="review-comment">
                    {{ $review->comment }}
                </div>

                <div class="review-actions">
                    <form method="POST" action="{{ route('dashboard.laporan.destroy', $review->id) }}" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-delete" onclick="return confirm('Yakin ingin menghapus laporan ini?')">
                            🗑 Hapus
                        </button>
                    </form>
                </div>
            </div>
        @endforeach
    </div>

    @if($reviews->hasPages())
        <div class="pagination-wrapper">
            {{ $reviews->links() }}
        </div>
    @endif
@else
    <div class="empty-state">
        <div class="empty-icon">📭</div>
        <div class="empty-title">Belum Ada Laporan</div>
        <div class="empty-subtitle">Pelanggan belum memberikan komentar atau ulasan</div>
    </div>
@endif

@endsection

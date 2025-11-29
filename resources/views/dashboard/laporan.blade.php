@extends('dashboard.layout')

@section('title', 'Laporan')

@section('content')

<style>
    .page-header {
        margin-bottom: 28px;
    }

    .page-title {
        font-size: 28px;
        font-weight: 700;
        color: var(--text);
        margin: 0 0 6px 0;
    }

    .page-subtitle {
        font-size: 14px;
        color: var(--muted);
        margin: 0;
    }

    .alert-success {
        background: linear-gradient(135deg, rgba(199,183,255,0.1), rgba(255,214,224,0.1));
        color: var(--pastel-accent);
        border: 1px solid rgba(199,183,255,0.3);
        padding: 14px 18px;
        border-radius: 10px;
        margin-bottom: 24px;
        display: flex;
        align-items: center;
        gap: 12px;
        font-weight: 500;
        font-size: 14px;
    }

    .reviews-container {
        background: var(--pastel-card);
        border-radius: 14px;
        overflow: hidden;
        box-shadow: 0 8px 20px rgba(34,34,59,0.04);
        border: 1px solid rgba(199,183,255,0.1);
    }

    .review-item {
        padding: 22px;
        border-bottom: 1px solid rgba(199,183,255,0.1);
        transition: background 0.2s ease;
    }

    .review-item:hover {
        background: rgba(199,183,255,0.04);
    }

    .review-item:last-child {
        border-bottom: none;
    }

    .review-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 16px;
        gap: 16px;
    }

    .reviewer-info {
        display: flex;
        gap: 14px;
        flex: 1;
    }

    .reviewer-avatar {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--pastel-accent), var(--pastel-accent-2));
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: 700;
        font-size: 16px;
        flex-shrink: 0;
        box-shadow: 0 4px 12px rgba(199,183,255,0.2);
    }

    .reviewer-details {
        display: flex;
        flex-direction: column;
        gap: 4px;
        justify-content: center;
    }

    .reviewer-name {
        font-weight: 700;
        color: var(--text);
        font-size: 15px;
    }

    .review-meta {
        display: flex;
        gap: 16px;
        font-size: 13px;
        color: var(--muted);
    }

    .review-date {
        display: flex;
        align-items: center;
        gap: 4px;
    }

    .review-product {
        display: flex;
        align-items: center;
        gap: 4px;
        color: var(--pastel-accent);
        font-weight: 600;
    }

    .rating-section {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .rating-stars {
        display: flex;
        gap: 2px;
    }

    .star {
        color: #FFD700;
        font-size: 18px;
        text-shadow: 0 1px 2px rgba(0,0,0,0.1);
    }

    .star-empty {
        color: rgba(199,183,255,0.2);
    }

    .review-comment {
        color: var(--text);
        line-height: 1.7;
        margin: 16px 0;
        padding: 14px;
        background: rgba(199,183,255,0.06);
        border-left: 4px solid var(--pastel-accent);
        border-radius: 8px;
        font-size: 14px;
        word-break: break-word;
    }

    .review-actions {
        display: flex;
        gap: 12px;
        justify-content: flex-end;
    }

    .btn-delete {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        padding: 8px 14px;
        background: linear-gradient(135deg, rgba(199,183,255,0.15), rgba(255,214,224,0.15));
        color: var(--pastel-accent);
        border: 1px solid var(--pastel-accent);
        border-radius: 8px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        font-size: 13px;
    }

    .btn-delete:hover {
        background: linear-gradient(135deg, var(--pastel-accent), var(--pastel-accent-2));
        color: white;
        border-color: transparent;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(199,183,255,0.3);
    }

    .empty-state {
        text-align: center;
        padding: 48px 24px;
        background: var(--pastel-card);
        border-radius: 14px;
        box-shadow: 0 8px 20px rgba(34,34,59,0.04);
        border: 1px solid rgba(199,183,255,0.1);
    }

    .empty-icon {
        font-size: 48px;
        margin-bottom: 16px;
        opacity: 0.7;
    }

    .empty-title {
        font-size: 18px;
        font-weight: 700;
        color: var(--text);
        margin-bottom: 8px;
    }

    .empty-subtitle {
        color: var(--muted);
        font-size: 14px;
    }

    .pagination-wrapper {
        margin-top: 28px;
        display: flex;
        justify-content: center;
    }

    @media (max-width: 768px) {
        .page-header {
            margin-bottom: 20px;
        }

        .review-header {
            flex-direction: column;
            gap: 12px;
        }

        .rating-section {
            justify-content: space-between;
            width: 100%;
        }

        .review-actions {
            width: 100%;
            margin-top: 12px;
        }

        .btn-delete {
            flex: 1;
        }
    }
</style>

<div class="page-header">
    <h1 class="page-title">📋 Laporan & Ulasan Pelanggan</h1>
    <p class="page-subtitle">Kelola komentar dan ulasan dari pelanggan</p>
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
                            <div class="review-meta">
                                <div class="review-date">
                                    📅 {{ $review->created_at->format('d M Y') }}
                                </div>
                                <div class="review-product">
                                    📦 {{ $review->jenis->nama ?? 'Produk Tidak Diketahui' }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="rating-section">
                        <div class="rating-stars">
                            @for($i = 0; $i < $review->rating; $i++)
                                <span class="star">★</span>
                            @endfor
                            @for($i = $review->rating; $i < 5; $i++)
                                <span class="star star-empty">★</span>
                            @endfor
                        </div>
                    </div>
                </div>

                <div class="review-comment">
                    {{ $review->comment }}
                </div>

                <div class="review-actions">
                    <form method="POST" action="{{ route('dashboard.laporan.destroy', $review->id) }}" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-delete" onclick="return confirm('Yakin ingin menghapus ulasan ini?')">
                            🗑️ Hapus
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
        <div class="empty-title">Belum Ada Ulasan</div>
        <div class="empty-subtitle">Pelanggan belum memberikan komentar atau ulasan untuk produk kami</div>
    </div>
@endif

@endsection

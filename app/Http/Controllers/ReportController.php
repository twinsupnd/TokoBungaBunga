<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    /**
     * Display all reviews/reports.
     */
    public function index(): View
    {
        // Only admins and managers can view reports
        if (!in_array(Auth::user()->role, ['admin', 'manager'])) {
            abort(403, 'Anda tidak memiliki akses ke halaman ini.');
        }

        $reviews = Review::with(['user', 'jenis'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('dashboard.laporan', compact('reviews'));
    }

    /**
     * Store a new review (from customer).
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'jenis_id' => 'required|exists:jenis,id',
            'rating' => 'required|integer|between:1,5',
            'comment' => 'required|string|min:3|max:1000',
        ]);

        $validated['user_id'] = Auth::id();

        Review::create($validated);

        return redirect()->back()->with('success', 'Terima kasih! Ulasan Anda telah diterima.');
    }

    /**
     * Delete a review.
     */
    public function destroy(Review $review): RedirectResponse
    {
        // Only admins and managers can delete reviews
        if (!in_array(Auth::user()->role, ['admin', 'manager'])) {
            abort(403, 'Anda tidak memiliki akses untuk menghapus laporan.');
        }

        $reviewerName = $review->user->name;
        $jenisName = $review->jenis->nama ?? 'Produk Tidak Diketahui';
        
        $review->delete();

        return redirect()->route('dashboard.laporan')
            ->with('success', "Laporan dari {$reviewerName} untuk {$jenisName} berhasil dihapus.");
    }
}

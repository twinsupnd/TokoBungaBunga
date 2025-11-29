<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class AnalyticsController extends Controller
{
    /**
     * Display the financial analytics page.
     */
    public function financialAnalytics(Request $request): View
    {
        // Get current month data
        $currentMonth = now()->format('F');
        
        // Sample data - replace with actual database queries
        $financialData = [
            'currentMonth' => $currentMonth,
            'salesThisMonth' => 12860000,
            'salesThisWeek' => 3200000,
            'totalTransactions' => 47,
            'successRate' => 94,
            'failureRate' => 6,
            
            // Daily sales data for chart
            'dailySales' => [
                ['day' => 'Mon', 'amount' => 1200000],
                ['day' => 'Tue', 'amount' => 1450000],
                ['day' => 'Wed', 'amount' => 980000],
                ['day' => 'Thu', 'amount' => 1650000],
                ['day' => 'Fri', 'amount' => 1890000],
                ['day' => 'Sat', 'amount' => 2150000],
                ['day' => 'Sun', 'amount' => 1540000],
            ],
            
            // Product sales breakdown
            'topProducts' => [
                ['name' => 'Baby Blooms Bouquet', 'sales' => 4200000, 'quantity' => 28],
                ['name' => 'Sunflower Delight', 'sales' => 3150000, 'quantity' => 21],
                ['name' => 'Rose Garden', 'sales' => 2890000, 'quantity' => 18],
                ['name' => 'Tulip Paradise', 'sales' => 1680000, 'quantity' => 12],
                ['name' => 'Helleborus Mix', 'sales' => 940000, 'quantity' => 8],
            ],
            
            // Transaction status breakdown
            'transactionStatus' => [
                'completed' => 44,
                'pending' => 2,
                'cancelled' => 1,
            ],
            
            // Monthly comparison
            'monthlyComparison' => [
                ['month' => 'Oct', 'amount' => 8900000],
                ['month' => 'Nov', 'amount' => 12860000],
            ],
        ];

        return view('dashboard.analytics', compact('financialData'));
    }
}

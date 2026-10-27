<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ingredient;
use App\Models\PurchaseRequest;
use App\Models\InventoryActivity;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Metric Card Counts
        $totalIngredients = Ingredient::count();

        // Adjust column names ('quantity', 'min_quantity', 'expiration_date') if your database uses different names
        $lowStockItems = Ingredient::whereColumn('quantity', '<=', 'min_quantity')->get();
        $lowStockCount = $lowStockItems->count();

        $pendingRequestsCount = PurchaseRequest::where('status', 'pending')->count();

        $expiringSoonCount = Ingredient::whereBetween('expiration_date', [now(), now()->addDays(7)])->count();

        // 2. Recent Inventory Activity (latest 5 logs)
        $recentActivities = InventoryActivity::latest()->take(5)->get();

        return view('dashboard', compact(
            'totalIngredients',
            'lowStockCount',
            'pendingRequestsCount',
            'expiringSoonCount',
            'lowStockItems',
            'recentActivities'
        ));
    }
}
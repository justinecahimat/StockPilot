<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;
use App\Models\Ingredient;
use App\Models\PurchaseRequest;
use App\Models\InventoryActivity;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $totalIngredients = Ingredient::count();

        $lowStockItems = Ingredient::whereColumn('quantity', '<=', 'min_quantity')->get();
        $lowStockCount = $lowStockItems->count();

        $pendingRequestsCount = PurchaseRequest::where('status', 'pending')->count();

        $expiringSoonCount = Ingredient::whereBetween('expiration_date', [
            Carbon::now(),
            Carbon::now()->addDays(7),
        ])->count();

        $recentActivities = InventoryActivity::with(['ingredient', 'user'])
            ->latest()
            ->take(5)
            ->get();

        // Build 7-day Inventory Overview bar chart data
        $hasActivities = Schema::hasTable('inventory_activities')
            && InventoryActivity::whereDate('created_at', '>=', Carbon::now()->subDays(6)->startOfDay())->exists();

        $dailyTotals = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);

            if ($hasActivities) {
                $total = (float) InventoryActivity::whereDate('created_at', $date->toDateString())->sum('quantity');
            } else {
                $total = (float) Ingredient::whereDate('updated_at', $date->toDateString())->sum('quantity');
            }

            $formattedTotal = rtrim(rtrim(number_format($total, 2, '.', ''), '0'), '.');

            $dailyTotals[] = [
                'label'         => $date->format('D'),
                'value'         => $total,
                'display_value' => $formattedTotal === '' ? '0' : $formattedTotal,
            ];
        }

        $maxTotal = max(array_column($dailyTotals, 'value'));

        $overviewData = array_map(function ($day) use ($maxTotal) {
            $height = ($maxTotal > 0 && $day['value'] > 0)
                ? max(14, (int) round(($day['value'] / $maxTotal) * 100))
                : 4;

            return [
                'label'         => $day['label'],
                'value'         => $day['value'],
                'display_value' => $day['display_value'],
                'height'        => $height,
            ];
        }, $dailyTotals);

        return view('dashboard', compact(
            'totalIngredients',
            'lowStockItems',
            'lowStockCount',
            'pendingRequestsCount',
            'expiringSoonCount',
            'recentActivities',
            'overviewData'
        ));
    }

    public function globalSearch(Request $request)
    {
        $rawQuery = trim((string) $request->input('q', ''));
        $term = strtolower(str_replace(['-', '_'], ' ', $rawQuery));
        $term = preg_replace('/\s+/', ' ', $term);

        // Ordered from most specific to broader keywords
        $pageMap = [
            'low stock alert'      => 'low-stock-alert',
            'low stock alerts'     => 'low-stock-alert',
            'low stock'            => 'low-stock-alert',
            'alert'                => 'low-stock-alert',
            'purchase request'     => 'purchase-request',
            'purchase requests'    => 'purchase-request',
            'purchase'             => 'purchase-request',
            'request'              => 'purchase-request',
            'inventory history'    => 'inventory.history',
            'history'              => 'inventory.history',
            'ingredients supplies' => 'ingredients.index',
            'ingredients'          => 'ingredients.index',
            'ingredient'           => 'ingredients.index',
            'supplies'             => 'ingredients.index',
            'categor'              => 'categories.index',
            'supplier'             => 'suppliers.index',
            'stock in'             => 'stock-in.create',
            'stock out'            => 'stock-out.create',
            'user management'      => 'users.index',
            'users'                => 'users.index',
            'user'                 => 'users.index',
            'reports'              => 'reports.index',
            'report'               => 'reports.index',
            'dashboard'            => 'dashboard',
        ];

        if ($term !== '') {
            foreach ($pageMap as $keyword => $routeName) {
                if (str_contains($term, $keyword) && Route::has($routeName)) {
                    return redirect()->route($routeName);
                }
            }
        }

        return redirect()->route('ingredients.index', ['search' => $rawQuery]);
    }
}
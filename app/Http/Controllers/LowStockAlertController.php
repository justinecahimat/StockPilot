<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ingredient;
use Carbon\Carbon;

class LowStockAlertController extends Controller
{
    public function index()
    {
        // Get today's date and the date 7 days from now
        $today = Carbon::today();
        $sevenDaysLater = Carbon::today()->addDays(7);

        // 1. Critical stock: below 25% of minimum quantity
        $criticalIngredients = Ingredient::where('min_quantity', '>', 0)
            ->whereRaw('quantity < min_quantity * 0.25')
            ->get();

        // 2. Low stock: below minimum, but not critical
        $lowStockIngredients = Ingredient::where('min_quantity', '>', 0)
            ->whereRaw('quantity < min_quantity')
            ->whereRaw('quantity >= min_quantity * 0.25')
            ->get();

        // 3. Expiring within the next 7 days
        $expiringIngredients = Ingredient::whereNotNull('expiration_date')
            ->whereDate('expiration_date', '>=', $today)
            ->whereDate('expiration_date', '<=', $sevenDaysLater)
            ->get();

        // 4. Already expired
        $expiredIngredients = Ingredient::whereNotNull('expiration_date')
            ->whereDate('expiration_date', '<', $today)
            ->get();

        // Get all ingredients that need attention
        $alerts = Ingredient::where(function ($query) use ($today, $sevenDaysLater) {

            $query->where(function ($stockQuery) {
                $stockQuery->where('min_quantity', '>', 0)
                    ->whereRaw('quantity < min_quantity');
            })

            ->orWhere(function ($expiryQuery) use ($today, $sevenDaysLater) {
                $expiryQuery->whereNotNull('expiration_date')
                    ->whereDate('expiration_date', '<=', $sevenDaysLater);
            });

        })->get();

        // Assign an alert status to each ingredient
        $alerts = $alerts->map(function ($ingredient) use ($today, $sevenDaysLater) {

            if ($ingredient->expiration_date && $ingredient->expiration_date < $today->toDateString()) {
                $ingredient->alert_status = 'Expired';
            } elseif (
                $ingredient->expiration_date &&
                $ingredient->expiration_date <= $sevenDaysLater->toDateString()
            ) {
                $ingredient->alert_status = 'Expiring Soon';
            } elseif (
                $ingredient->min_quantity > 0 &&
                $ingredient->quantity < $ingredient->min_quantity * 0.25
            ) {
                $ingredient->alert_status = 'Critical';
            } else {
                $ingredient->alert_status = 'Low Stock';
            }

            return $ingredient;
        });

        return view('low-stock-alerts', compact(
            'criticalIngredients',
            'lowStockIngredients',
            'expiringIngredients',
            'expiredIngredients',
            'alerts'
        ));
    }
}
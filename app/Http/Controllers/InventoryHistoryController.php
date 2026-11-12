<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InventoryHistoryController extends Controller
{
    public function index(Request $request)
    {
        $query = DB::table('inventory_activities')
            ->join('ingredients', 'inventory_activities.ingredient_id', '=', 'ingredients.id')
            ->join('users', 'inventory_activities.user_id', '=', 'users.id')
            ->select(
                'inventory_activities.*',
                'ingredients.name as ingredient_name',
                'users.name as recorded_by'
            );

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where('ingredients.name', 'like', "%{$search}%");
        }

        $activities = $query->orderBy('inventory_activities.created_at', 'desc')->paginate(10);

        return view('inventory-history.index', compact('activities'));
    }
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InventoryActivity extends Model
{
    protected $fillable = [
        'ingredient_id',
        'transaction_type',
        'quantity',
        'user_id',
    ];

    // Each activity belongs to one ingredient
    public function ingredient(): BelongsTo
    {
        return $this->belongsTo(Ingredient::class);
    }

    // Each activity belongs to one user
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}

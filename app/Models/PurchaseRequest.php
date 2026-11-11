<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PurchaseRequest extends Model
{
    protected $fillable = [
        'reference_no',
        'requested_by',
        'status',
    ];

    // A purchase request belongs to one user
    public function requester(): BelongsTo
    {
        return $this->belongsTo(User::class, 'requested_by');
    }

    // A purchase request can contain multiple items
    public function items(): HasMany
    {
        return $this->hasMany(PurchaseRequestItem::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockOut extends Model
{
    use HasFactory;

    protected $fillable = [
    'ingredient',
    'quantity',
    'unit_cost',
    'reason',
    'issued_to',
    'date',
    'notes',
    ];
}
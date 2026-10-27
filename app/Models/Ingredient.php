<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ingredient extends Model
{
    use HasFactory;

   protected $fillable = [
    'name',
    'category',
    'unit',
    'quantity',
    'min_quantity',
    'supplier',
    'expiration_date',
    'notes',
];
}
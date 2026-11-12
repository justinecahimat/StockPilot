<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('purchase_request_items', function (Blueprint $table) {
            // All columns already exist from the base table creation
        });
    }

    public function down(): void
    {
        Schema::table('purchase_request_items', function (Blueprint $table) {
            $table->dropForeign(['purchase_request_id']);
            $table->dropForeign(['ingredient_id']);

            $table->dropColumn([
                'purchase_request_id',
                'ingredient_id',
                'requested_quantity',
                'unit',
                'current_stock',
                'unit_cost',
            ]);
        });
    }
};
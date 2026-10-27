<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
{
    Schema::table('ingredients', function (Blueprint $table) {
        if (!Schema::hasColumn('ingredients', 'category')) {
            $table->string('category')->nullable();
        }
        if (!Schema::hasColumn('ingredients', 'supplier')) {
            $table->string('supplier')->nullable();
        }
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ingredients', function (Blueprint $table) {
            //
        });
    }
};

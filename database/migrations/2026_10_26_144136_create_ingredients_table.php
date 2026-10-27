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
        Schema::create('ingredients', function (Blueprint $table) {
            $table->id();
            $table->string('name');                    // <--- Adds the ingredient name
            $table->integer('quantity')->default(0);   // <--- Adds the stock count
            $table->integer('min_quantity')->default(0); // <--- Adds the low stock limit
            $table->date('expiration_date')->nullable(); // <--- Adds the expiration date
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ingredients');
    }
};

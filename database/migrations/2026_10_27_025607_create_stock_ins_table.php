<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
{
    Schema::create('stock_outs', function (Blueprint $table) {
        $table->id();$table->string('ingredient');
        $table->decimal('quantity', 10, 2);$table->string('reason');
        $table->string('issued_to')->nullable();$table->date('date');
        $table->text('notes')->nullable();$table->timestamps();
    });
}

    public function down(): void
    {
        Schema::dropIfExists('stock_ins');
    }
};
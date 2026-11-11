
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('purchase_request_items', function (Blueprint $table) {
            $table->id();

            // Connect to the main purchase request
            $table->foreignId('purchase_request_id')
                  ->constrained('purchase_requests')
                  ->cascadeOnDelete();

            // Connect to the ingredient
            $table->foreignId('ingredient_id')
                  ->constrained('ingredients')
                  ->restrictOnDelete();

            // Requested ingredient information
            $table->decimal('requested_quantity', 10, 2);
            $table->string('unit', 50)->nullable();
            $table->integer('current_stock')->default(0);
            $table->decimal('unit_cost', 10, 2)->default(0);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('purchase_request_items');
    }
};

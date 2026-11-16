
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('purchase_requests', function (Blueprint $table) {

            // Record who approved the request
            $table->foreignId('approved_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            // Record when the request was approved
            $table->timestamp('approved_at')->nullable();

        });
    }

    public function down(): void
    {
        Schema::table('purchase_requests', function (Blueprint $table) {

            $table->dropForeign(['approved_by']);

            $table->dropColumn([
                'approved_by',
                'approved_at'
            ]);

        });
    }
};


<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('purchase_requests', 'approved_by')) {
            Schema::table('purchase_requests', function (Blueprint $table) {
                $table->foreignId('approved_by')
                    ->nullable()
                    ->constrained('users')
                    ->nullOnDelete();
            });
        }

        if (!Schema::hasColumn('purchase_requests', 'approved_at')) {
            Schema::table('purchase_requests', function (Blueprint $table) {
                $table->timestamp('approved_at')->nullable();
            });
        }
    }

    public function down(): void
    {
        // This migration repairs missing fields only.
        // Do not drop fields that may belong to another migration.
    }
};

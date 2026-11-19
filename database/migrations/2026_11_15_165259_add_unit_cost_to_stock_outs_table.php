
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('stock_outs', 'unit_cost')) {
            Schema::table('stock_outs', function (Blueprint $table) {
                $table->decimal('unit_cost', 10, 2)
                    ->nullable()
                    ->after('quantity');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('stock_outs', 'unit_cost')) {
            Schema::table('stock_outs', function (Blueprint $table) {
                $table->dropColumn('unit_cost');
            });
        }
    }
};


<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('ingredients', 'unit_cost')) {
            Schema::table('ingredients', function (Blueprint $table) {
                $table->decimal('unit_cost', 10, 2)
                    ->default(0)
                    ->after('quantity');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('ingredients', 'unit_cost')) {
            Schema::table('ingredients', function (Blueprint $table) {
                $table->dropColumn('unit_cost');
            });
        }
    }
};

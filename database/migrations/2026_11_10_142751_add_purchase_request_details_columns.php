
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('purchase_requests', function (Blueprint $table) {
         // $table->string('reference_no', 50)->unique();
 
         // $table->foreignId('requested_by')
         //         ->constrained('users')
         //         ->restrictOnDelete();
         
        });
    }

    public function down(): void
    {
        Schema::table('purchase_requests', function (Blueprint $table) {
            $table->dropForeign(['requested_by']);
            $table->dropUnique(['reference_no']);
            $table->dropColumn(['requested_by', 'reference_no']);
        });
    }
};

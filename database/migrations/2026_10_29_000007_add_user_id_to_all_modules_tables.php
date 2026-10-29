<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $tables = ['products', 'stores', 'orders', 'vendors', 'promotions', 'marketing_campaigns'];

        foreach ($tables as $tableName) {
            if (Schema::hasTable($tableName) && !Schema::hasColumn($tableName, 'user_id')) {
                Schema::table($tableName, function (Blueprint $table) {
                    $table->foreignId('user_id')->nullable()->after('id')->constrained('users')->cascadeOnDelete();
                    $table->index('user_id');
                });
            }
        }

        // Assign existing records to the primary admin user (id = 1)
        $firstUserId = DB::table('users')->orderBy('id')->value('id');
        if ($firstUserId) {
            foreach ($tables as $tableName) {
                if (Schema::hasTable($tableName) && Schema::hasColumn($tableName, 'user_id')) {
                    DB::table($tableName)->whereNull('user_id')->update(['user_id' => $firstUserId]);
                }
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $tables = ['products', 'stores', 'orders', 'vendors', 'promotions', 'marketing_campaigns'];

        foreach ($tables as $tableName) {
            if (Schema::hasTable($tableName) && Schema::hasColumn($tableName, 'user_id')) {
                Schema::table($tableName, function (Blueprint $table) {
                    $table->dropForeign(['user_id']);
                    $table->dropColumn('user_id');
                });
            }
        }
    }
};

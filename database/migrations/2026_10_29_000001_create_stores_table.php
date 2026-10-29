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
        Schema::create('stores', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code')->unique();
            $table->string('type')->default('Retail Outlet'); // Flagship, Retail Outlet, Warehouse, Online
            $table->string('address');
            $table->string('city');
            $table->string('phone')->nullable();
            $table->string('manager_name')->nullable();
            $table->string('status')->default('Active'); // Active, Maintenance, Closed
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stores');
    }
};

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
        Schema::table('service_bookings', function (Blueprint $table) {
            $table->string('phone')->nullable()->after('status');
            $table->text('address')->nullable()->after('phone');
            $table->decimal('total_price', 10, 2)->default(0.00)->after('address');
            $table->text('notes')->nullable()->after('total_price');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('service_bookings', function (Blueprint $table) {
            $table->dropColumn(['phone', 'address', 'total_price', 'notes']);
        });
    }
};

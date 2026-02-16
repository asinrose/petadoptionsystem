<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration 
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('service_bookings', function (Blueprint $table) {
            if (!Schema::hasColumn('service_bookings', 'start_time')) {
                $table->time('start_time')->nullable()->after('date');
            }
            if (!Schema::hasColumn('service_bookings', 'end_time')) {
                $table->time('end_time')->nullable()->after('start_time');
            }
        });

        if (Schema::hasColumn('service_bookings', 'time')) {
            // Copy existing time data to start_time
            DB::statement('UPDATE service_bookings SET start_time = time WHERE start_time IS NULL');

            Schema::table('service_bookings', function (Blueprint $table) {
                $table->dropColumn('time');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('service_bookings', function (Blueprint $table) {
            $table->time('time')->nullable()->after('date');
        });

        DB::statement('UPDATE service_bookings SET time = start_time');

        Schema::table('service_bookings', function (Blueprint $table) {
            $table->dropColumn(['start_time', 'end_time']);
        });
    }
};

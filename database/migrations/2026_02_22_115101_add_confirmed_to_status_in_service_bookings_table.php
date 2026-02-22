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
        // For MySQL, use a raw statement to alter the ENUM to include 'confirmed'
        \Illuminate\Support\Facades\DB::statement("ALTER TABLE service_bookings MODIFY COLUMN status ENUM('booked', 'confirmed', 'completed', 'cancelled') DEFAULT 'booked'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert it to the original enum (Note: this might fail if there are 'confirmed' rows)
        \Illuminate\Support\Facades\DB::statement("ALTER TABLE service_bookings MODIFY COLUMN status ENUM('booked', 'completed', 'cancelled') DEFAULT 'booked'");
    }
};

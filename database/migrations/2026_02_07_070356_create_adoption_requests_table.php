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
    Schema::create('adoption_requests', function (Blueprint $table) {
        $table->id(); // PK

        $table->foreignId('user_id')->constrained()->onDelete('cascade');
        $table->foreignId('pet_id')->constrained()->onDelete('cascade');

        $table->enum('status', ['pending', 'approved', 'rejected'])
              ->default('pending');

        $table->date('request_date');

        $table->timestamps(); // created_at & updated_at
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('adoption_requests');
    }
};

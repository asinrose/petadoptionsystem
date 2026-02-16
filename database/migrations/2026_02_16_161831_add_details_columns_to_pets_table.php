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
        Schema::table('pets', function (Blueprint $table) {
            $table->string('weight')->nullable(); // Optional
            $table->enum('vaccination_status', ['vaccinated', 'not_vaccinated'])->default('not_vaccinated');
            $table->date('vaccination_date')->nullable();
            $table->boolean('dewormed')->default(false); // Yes/No
            $table->text('medical_conditions')->nullable(); // If any
            $table->text('special_care_requirements')->nullable();
            $table->enum('adoption_type', ['free', 'fee'])->default('free');
            $table->decimal('adoption_fee', 8, 2)->nullable(); // In case fee is selected
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pets', function (Blueprint $table) {
            $table->dropColumn([
                'weight',
                'vaccination_status',
                'vaccination_date',
                'dewormed',
                'medical_conditions',
                'special_care_requirements',
                'adoption_type',
                'adoption_fee'
            ]);
        });
    }
};

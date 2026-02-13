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
        Schema::create('availabilities', function (Blueprint $table) {
            $table->id();
            $table->string('owner_type'); // 'tutor' ou 'student'
            $table->unsignedBigInteger('owner_id');
            $table->unsignedTinyInteger('day_of_week'); // 0 = lundi, 6 = dimanche par ex.
            $table->time('start_time');
            $table->time('end_time');
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('availabilities');
    }
};

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
        Schema::create('schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('started_route')->constrained('routes')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('end_route')->constrained('routes')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('id_passenger')->constrained('passengers')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('id_segment')->constrained('segments')->cascadeOnUpdate()->cascadeOnDelete();
            $table->date('date');
            $table->time('departure_time');
            $table->time('arrival_time');
            $table->decimal('ticket_price', 8, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schedules');
    }
};

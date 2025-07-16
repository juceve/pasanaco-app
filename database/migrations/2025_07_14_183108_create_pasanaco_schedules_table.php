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
        Schema::create('pasanaco_schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pasanaco_group_id')->constrained()->cascadeOnDelete();
            $table->foreignId('participant_id')->nullable()->constrained()->nullOnDelete();
            $table->date('scheduled_date');
            $table->enum('status', ['pending', 'completed', 'missed', 'canceled'])->default('pending');
            $table->boolean('adjusted')->default(false); // Si fue reprogramado
            $table->text('adjustment_reason')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pasanaco_schedules');
    }
};

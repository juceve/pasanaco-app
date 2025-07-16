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
        Schema::create('pasanaco_groups', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->date('start_date');
            $table->enum('frequency', ['daily', 'weekly', 'monthly', 'custom']);
            $table->integer('custom_days_interval')->nullable(); // Solo si frequency == custom
            $table->string('day_of_week')->nullable(); // Solo si weekly
            $table->integer('day_of_month')->nullable(); // Solo si monthly
            $table->decimal('amount_per_participant', 10, 2);
            $table->enum('status', ['in_progress', 'completed'])->default('in_progress');
            $table->unsignedTinyInteger('progress_percent')->default(0); // 0 a 100
            $table->json('settings')->nullable(); // JSON para futura extensión
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pasanaco_groups');
    }
};

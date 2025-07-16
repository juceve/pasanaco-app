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
        Schema::create('pasanaco_schedule_changes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pasanaco_schedule_id')->constrained()->cascadeOnDelete();
            $table->string('action'); // E.g. 'participant_removed', 'participant_added', 'rescheduled'
            $table->text('details')->nullable();
            $table->timestamp('changed_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pasanaco_schedule_changes');
    }
};

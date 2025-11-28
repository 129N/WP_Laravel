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
        Schema::create('participant_locations', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->unsignedBigInteger('event_id');   //  foreing_ID from Registration
            $table->unsignedBigInteger('user_id');    // foreing ID from participants.

            $table->decimal('lat', 10, 7);
            $table->decimal('lon', 10, 7);

            $table->float('speed')->nullable();
            $table->float('heading')->nullable();  // 0-360


             // Indexes for fast queries
            $table->index(['event_id', 'user_id']); //$table->unique(['event_id', 'user_id']); // it prvents duplicates automatically.
            $table->index('created_at');

            // Foreign key
            $table->foreign('event_id')->references('id')->on('events')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('user_reacts')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('participant_locations');
    }
};

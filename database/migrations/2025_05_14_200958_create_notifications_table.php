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
        Schema::create('notifications', function (Blueprint $table) {
        $table->id(); //primary key
            $table->unsignedBigInteger('participant_id'); //foreign key from UserReact
            $table->unsignedBigInteger('event_id'); //foreign key from UserReact
        $table->enum('type', ['emergency', 'surrender', 'waypoint', 'offline']);
        $table->string('message');
        $table->string('event_code')->nullable(); //newly added
        $table->timestamps();

//Foreign key
        $table->foreign('event_id')->references('id')->on('events')->onDelete('cascade');
        $table->foreign('participant_id')->references('id')->on('user_reacts')->onDelete('cascade');
 // Indexes for performance
        $table->index(['event_id', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};

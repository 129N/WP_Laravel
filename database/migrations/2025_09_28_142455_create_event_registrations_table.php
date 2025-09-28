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
        Schema::create('event_registrations', function (Blueprint $table) {
            $table->id(); // event_reg_ID
            $table->unsignedBigInteger('event_id'); // foreing_ID from Registration
            $table->unsignedBigInteger('user_id'); // foreing ID from participants.
            $table->string('group_name')->nullable(); // group/team
            $table->enum('status', ['registered', 'checked_in', 'finished'])->default('registered');
            $table->timestamps();

            $table->unique(['event_id', 'user_id']); // it prvents duplicates automatically.
            $table->foreign('event_id')->references('id')->on('events')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('event_registrations');
    }
};

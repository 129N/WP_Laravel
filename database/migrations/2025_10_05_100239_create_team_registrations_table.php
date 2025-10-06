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
        Schema::create('team_registrations', function (Blueprint $table) {
            $table->id();
            $table->string('team_code')->unique();// TEAM001
                $table->unsignedBigInteger('event_id'); //foreign ID from Event event_code?
                $table->unsignedBigInteger('leader_id'); //foreign ID from User reacts?
            $table->string('team_name');
            $table->enum('status', ['registered', 'checked_in', 'finished'])->default('registered');
            $table->timestamps();
            
            //Foreing IDs
            $table-> foreign('event_id')->references('id')->on('events')->onDelete('cascade');
            $table-> foreign('leader_id')->references('id')->on('user_reacts')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('team_registrations');
    }
};

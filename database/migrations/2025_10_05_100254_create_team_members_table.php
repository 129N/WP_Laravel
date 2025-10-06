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
        Schema::create('team_members', function (Blueprint $table) {
            $table->id();
         
            $table->string('member_name');
            $table->string('member_email');
            $table->string('role')->nullable(); //section runner1 runner2
                $table->unsignedBigInteger('team_registration_id'); //Foreign ID
                $table->unsignedBigInteger('member_id'); //foreign ID from User reacts
            $table->timestamps();
            //Foreing ID from team_registrations
            $table->foreign('team_registration_id')
            ->references('id')->on('team_registrations')->onDelete('cascade');

            $table-> foreign('member_id')
            ->references('id')->on('user_reacts')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('team_members');
    }
};

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
        Schema::create('events', function (Blueprint $table) {
            $table->id(); //auto generate primary key
            $table->string('event_code')->unique(); // EV01, EV02... to show user.
            $table->string('event_title');
            $table->text('description');
            $table->dateTime('event_date');
            $table->unsignedBigInteger('created_by'); // foreign key referencing an admin’s ID.
            // $table->string('event_creatorName'); 
            $table->timestamps();

            $table->foreign('created_by')->references('id')->on('User_react')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};

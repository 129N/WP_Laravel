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
        Schema::create('w_p_reacts', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['wpt', 'trkpt']);
            $table->decimal('lat', 10, 6);
            $table->decimal('lon', 10, 6);
            $table->string('name')->nullable();
            $table->string('desc')->nullable();
            $table->float('ele')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('w_p_reacts');
    }
};

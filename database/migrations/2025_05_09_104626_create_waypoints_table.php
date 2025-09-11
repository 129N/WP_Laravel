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
        Schema::create('waypoints', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->decimal('latitude', 10, 7);
            $table->decimal('longitude', 10, 7);
            $table->decimal('elevation', 8, 2)->nullable();
            $table->timestamp('time')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('waypoints');
    }
};


/*

$table->id();: Creates an auto-incrementing primary key.

$table->string('name')->nullable();: Stores the waypoint name (can be nullable).

$table->decimal('latitude', 10, 7); and $table->decimal('longitude', 10, 7);: Record the coordinates with high precision.

$table->decimal('elevation', 8, 2)->nullable();: Stores elevation (optional).

$table->timestamp('time')->nullable();: Records the timestamp if available (optional).

$table->timestamps();: Automatically manages created_at and updated_at.
*/
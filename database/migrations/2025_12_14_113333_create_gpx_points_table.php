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
        Schema::create('gpx_points', function (Blueprint $table) {
                $table->id();

                $table->unsignedBigInteger('gpx_file_id');

                $table->enum('type', ['wpt', 'trkpt']);
                $table->decimal('lat', 10, 7);
                $table->decimal('lon', 10, 7);
                $table->string('name')->nullable();
                $table->string('desc')->nullable();
                $table->float('ele')->nullable();

                $table->timestamps();

                $table->foreign('gpx_file_id')
                    ->references('id')
                    ->on('gpx_files')
                    ->onDelete('cascade');

                $table->index('gpx_file_id');
            });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gpx_points');
    }
};

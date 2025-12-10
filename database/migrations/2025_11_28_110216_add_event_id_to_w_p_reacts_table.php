<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations. To run the GPX file upload either with eventId or without eventID.
     */
    public function up(): void
    {
        Schema::table('w_p_reacts', function (Blueprint $table) {
            $table->unsignedBigInteger('gpx_file_id')->nullable()->after('id');
            $table->foreign('gpx_file_id')->references('id')->on('gpx_files')
            ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('w_p_reacts', function (Blueprint $table) {
            //
            $table->dropForeign(['gpx_file_id']);
            $table->dropColumn('gpx_file_id');
        });
    }
};

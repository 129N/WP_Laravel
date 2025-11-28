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
            //Foreign key
            $table->unsignedBigInteger('event_id')->nullable()->after('id');

            //Optional
            $table->foreign('event_id')->references('id')->on('events')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('w_p_reacts', function (Blueprint $table) {
            //
            $table->dropForeign(['event_id']);
            $table->dropColumn('event_id');
        });
    }
};

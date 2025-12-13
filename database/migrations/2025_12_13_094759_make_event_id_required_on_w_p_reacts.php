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
        //
        Schema::table('w_p_reacts', function (Blueprint $table) {
        $table->unsignedBigInteger('event_id')->nullable(false)->change();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        Schema::table('w_p_reacts', function (Blueprint $table) {
        $table->unsignedBigInteger('event_id')->nullable()->change();
    });
    }
};

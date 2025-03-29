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
        Schema::table('medicine_alerts', function (Blueprint $table) {
            $table->boolean('google_calendar_sync_status')->default(false)->after('alert_data');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('medicine_alerts', function (Blueprint $table) {
            $table->dropColumn('google_calendar_sync_status');
        });
    }
};

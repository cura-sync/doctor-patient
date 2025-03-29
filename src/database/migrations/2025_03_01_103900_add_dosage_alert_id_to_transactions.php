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
        Schema::table('transactions', function (Blueprint $table) {
            $table->unsignedBigInteger('dosage_alert_id')->nullable()->after('bill_analysis_id');

            $table->foreign('dosage_alert_id')->references('id')->on('medicine_alerts')->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropForeign(['dosage_alert_id']);
            $table->dropColumn('dosage_alert_id');
        });
    }
};

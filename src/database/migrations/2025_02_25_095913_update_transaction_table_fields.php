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
            $table->unsignedBigInteger('prescription_transalation_id')->nullable()->after('id');
            $table->unsignedBigInteger('bill_analysis_id')->nullable()->after('prescription_transalation_id');
        });

        Schema::table('transactions', function (Blueprint $table) {
            if (Schema::hasTable('prescriptions')) {
                $table->foreign('prescription_transalation_id')->references('id')->on('prescriptions')->onDelete('cascade');
            }
            if (Schema::hasTable('bills')) {
                $table->foreign('bill_analysis_id')->references('id')->on('bills')->onDelete('cascade');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropForeign(['prescription_transalation_id']);
            $table->dropForeign(['bill_analysis_id']);
            $table->dropColumn('prescription_transalation_id');
            $table->dropColumn('bill_analysis_id');
        });
    }
};
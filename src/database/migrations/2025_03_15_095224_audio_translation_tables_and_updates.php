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
        Schema::create('audio_files', function (Blueprint $table) {
            $table->id()->primary();
            $table->string('file_name');
            $table->boolean('translation_success');
            $table->timestamps();
        });

        Schema::create('audio_content', function(Blueprint $table) {
            $table->id()->primary();
            $table->unsignedBigInteger('audio_file_id');
            $table->unsignedBigInteger('transaction_registered_id');
            $table->text('original_transcript');
            $table->text('simplified_data');
            $table->text('prescription_data')->nullable();
            $table->timestamps();

            $table->foreign('audio_file_id')->references('id')->on('audio_files');
            $table->foreign('transaction_registered_id')->references('id')->on('transactions');
        });

        Schema::create('prescription_template', function(Blueprint $table) {
            $table->id()->primary();
            $table->unsignedBigInteger('user_id');
            $table->text('template');
            $table->integer('type');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
        });

        Schema::table('transactions', function(Blueprint $table) {
            $table->unsignedBigInteger('audio_conversion_id')->nullable()->after('dosage_alert_id');

            $table->foreign('audio_conversion_id')->references('id')->on('audio_files');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('audio_files');
        Schema::dropIfExists('audio_content');
        Schema::dropIfExists('prescription_template');
        Schema::dropIfExists('transactions');
    }
};
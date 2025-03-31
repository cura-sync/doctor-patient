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
        Schema::create('audio_content', function (Blueprint $table) {
            $table->id()->primary();
            $table->unsignedBigInteger('document_id');
            $table->text('original_transcription');
            $table->text('simplified_transcription')->nullable();
            $table->text('prescription_content')->nullable();
            $table->integer('created_at');
            $table->integer('updated_at');

            $table->foreign('document_id')->references('id')->on('documents')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('audio_content');
    }
};

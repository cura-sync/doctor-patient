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
        Schema::create('document_contents', function (Blueprint $table) {
            $table->id()->primary();
            $table->unsignedBigInteger('transaction_registered_id');
            $table->text('original_text');
            $table->json('translated_text');
            $table->timestamps();
        
            $table->foreign('transaction_registered_id')->references('id')->on('transactions')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('document_contents');
    }
};

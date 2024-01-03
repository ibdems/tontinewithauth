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
        Schema::create('cotisations', function (Blueprint $table) {
            $table->id();
            $table->string('codeCotisation');
            $table->integer('montantCotisation');
            $table->date('dateCotisation');
            $table->foreignId('tontine')->references('id')->on('tontine_individuelles')->onDelete('cascade');
            $table->foreignId('membre')->references('id')->on('membres')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cotisations');
    }
};

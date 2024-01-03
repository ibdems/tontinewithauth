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
        Schema::create('comptes', function (Blueprint $table) {
            $table->id();
            $table->integer('montantVerser');
            $table->date('dateVersement');
            $table->foreignId('tontineIndividuelle')->references('id')->on('tontine_individuelles')->onDelete('cascade')->nullable();
            $table->foreignId('tontineCollectives')->references('id')->on('tontine_collectives')->onDelete('cascade')->nullable();
            $table->foreignId('agent')->references('id')->on('agents')->onDelete('cascade')->nullable();
            $table->timestamps();
        });
    }

    /** 
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comptes');
    }
};

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
        Schema::create('tontine_individuelles', function (Blueprint $table) {
            $table->id();
            $table->string('codeTontineI');
            $table->string('nomTontineI');
            $table->date('debutTontineI');
            $table->integer('montantTontineI');
            $table->boolean('statutTontinteI')->nullable();
            $table->foreignId('membre')->references('id')->on('membres')->onDelete('cascade');
            $table->foreignId('agent')->references('id')->on('agents')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tontine_individuelles');
    }
};

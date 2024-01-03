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
        Schema::create('payement_collectives', function (Blueprint $table) {
            $table->id();
            $table->string('codePayementC');
            $table->integer('montantPayementC');
            $table->date('datePayementC');
            $table->foreignId('tontine')->references('id')->on('tontine_collectives')->onDelete('cascade');
            $table->foreignId('membre')->references('id')->on('membres')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payement_collectives');
    }
};

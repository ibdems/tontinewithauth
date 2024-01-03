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
        Schema::create('tontine_collectives', function (Blueprint $table) {
            $table->id();
            $table->string('codeTontineC');
            $table->string('nomTontineC');
            $table->date('debutTontineC');
            $table->integer('montant');
            $table->string('frequence');
            $table->integer('nombreParticipant')->nullable();
            $table->integer('statutTontineC')->nullable();
            $table->foreignId('agent')->references('id')->on('agents')->onDelete('cascade');
            $table->bigInteger('totalVersement')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tontine_collectives');
    }
};

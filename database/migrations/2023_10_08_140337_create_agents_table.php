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
        Schema::create('agents', function (Blueprint $table) {
            $table->id();
            $table->string('codeAgent')->unique();
            $table->string('nomAgent');
            $table->string('prenomAgent');
            $table->string('adresseAgent');
            $table->string('telAgent');
            $table->string('mailAgent')->nullable()->unique();
            $table->string('photoAgent')->nullable();
            $table->date('dateAdhesion');
            $table->boolean('statutAgent');
            $table->foreignId('Agence')->references('id')->on('agences')->onDelete('cascade');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('agents');
    }
};

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
        Schema::create('delegues', function (Blueprint $table) {
            $table->id();
            $table->string('codeDelegue')->unique();
            $table->string('nomDelegue');
            $table->string('prenomDelegue');
            $table->string('adresseDelegue');
            $table->string('telDelegue');
            $table->string('mailDelegue')->nullable()->unique();
            $table->string('photoDelegue')->nullable();
            $table->date('dateAdhesion');
            $table->unsignedBigInteger('agence_id')->nullable();
            $table->foreign('agence_id')->references('id')->on('agences')->onDelete('cascade');
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
        Schema::dropIfExists('delegues');
    }
};

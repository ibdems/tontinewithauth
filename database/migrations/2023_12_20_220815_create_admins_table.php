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
        Schema::create('admins', function (Blueprint $table) {
            $table->id();
            $table->string('codeAdmin')->unique();
            $table->string('nomAdmin');
            $table->string('prenomAdmin');
            $table->string('adresseAdmin');
            $table->string('telAdmin');
            $table->string('mailAdmin')->nullable()->unique();
            $table->string('photoAdmin')->nullable();
            $table->date('dateAdhesion');
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
        Schema::dropIfExists('admins');
    }
};

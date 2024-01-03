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
        Schema::table('comptes', function (Blueprint $table) {
             // Rendre les clés étrangères nullable
            $table->foreignId('tontineIndividuelle')->nullable()->change();
            $table->foreignId('tontineCollectives')->nullable()->change();
            $table->foreignId('agent')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('comptes', function (Blueprint $table) {
            $table->foreignId('tontineIndividuelle')->change();
            $table->foreignId('tontineCollectives')->change();
            $table->foreignId('agent')->change();
        });
    }
};

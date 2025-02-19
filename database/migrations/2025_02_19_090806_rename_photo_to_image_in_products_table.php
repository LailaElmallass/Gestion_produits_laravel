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
        Schema::table('products', function (Blueprint $table) {
            // Supprimer la colonne 'photo'
            $table->dropColumn('photo');
            
            // Ajouter la nouvelle colonne 'image'
            $table->string('image')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // Revenir en arrière (supprimer 'image' et remettre 'photo')
            $table->dropColumn('image');
            $table->string('photo')->nullable();
        });
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('formations', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->string('slug')->unique();
            $table->text('description');
            $table->longText('contenu')->nullable();
            $table->string('image_url')->nullable();
            $table->decimal('prix', 10, 2);
            $table->decimal('prix_barre', 10, 2)->nullable();
            $table->string('badge', 50)->nullable();
            $table->string('couleur_badge', 20)->default('#f97316');
            $table->decimal('note', 2, 1)->default(5.0);
            $table->string('niveau', 50)->default('Débutant');
            $table->string('duree', 50)->nullable();
            $table->string('lien_achat')->nullable();
            $table->boolean('actif')->default(true);
            $table->integer('ordre')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('formations');
    }
};

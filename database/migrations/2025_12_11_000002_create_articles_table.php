<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->string('titre');
            $table->string('slug')->unique();
            $table->text('extrait');
            $table->longText('contenu');
            $table->string('image_url')->nullable();
            $table->string('auteur')->default('Coach Didi');
            $table->string('temps_lecture', 20)->default('5 min');
            $table->foreignId('categorie_id')->constrained('categories')->onDelete('cascade');
            $table->boolean('actif')->default(true);
            $table->boolean('featured')->default(false);
            $table->integer('vues')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('articles');
    }
};

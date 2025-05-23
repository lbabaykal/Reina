<?php

use App\Models\Anime;
use App\Models\AnimeEpisode;
use App\Models\AnimeFolder;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('favorite_animes', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class)
                ->constrained()
                ->cascadeOnDelete();
            $table->foreignIdFor(Anime::class)
                ->constrained()
                ->cascadeOnDelete();
            $table->foreignIdFor(AnimeFolder::class)
                ->constrained()
                ->cascadeOnDelete();
            $table->foreignIdFor(AnimeEpisode::class)
                ->nullable()
                ->constrained()
                ->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('favorite_animes');
    }
};

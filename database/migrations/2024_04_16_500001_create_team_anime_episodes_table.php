<?php

use App\Models\AnimeEpisode;
use App\Models\Team;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('team_anime_episodes', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(AnimeEpisode::class)
                ->constrained()
                ->cascadeOnDelete();
            $table->foreignIdFor(Team::class)
                ->constrained()
                ->cascadeOnDelete();
            $table->enum('type', ['VOICEOVER', 'DUBBING', 'SUBTITLES'])->default('VOICEOVER');
            $table->string('link');
            $table->text('note')->nullable();
            $table->enum('status', ['PUBLISHED', 'DRAFT', 'IN_ARCHIVE', 'ON_MODERATION'])->default('DRAFT');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('team_anime_episodes');
    }
};

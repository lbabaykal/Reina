<?php

use App\Models\Anime;
use App\Models\Character;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('anime_character', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Anime::class)
                ->constrained()
                ->cascadeOnDelete();
            $table->foreignIdFor(Character::class)
                ->constrained()
                ->cascadeOnDelete();
            $table->enum('role', ['MAIN', 'SECONDARY', 'EPISODIC'])->default('SECONDARY');
            $table->timestamps();

            $table->unique(['anime_id', 'character_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('anime_characters');
    }
};

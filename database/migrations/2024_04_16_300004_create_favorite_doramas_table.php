<?php

use App\Models\Dorama;
use App\Models\DoramaEpisode;
use App\Models\DoramaFolder;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('favorite_doramas', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class)
                ->constrained()
                ->cascadeOnDelete();
            $table->foreignIdFor(Dorama::class)
                ->constrained()
                ->cascadeOnDelete();
            $table->foreignIdFor(DoramaFolder::class)
                ->constrained()
                ->cascadeOnDelete();
            $table->foreignIdFor(DoramaEpisode::class)
                ->nullable()
                ->constrained()
                ->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('favorite_doramas');
    }
};

<?php

use App\Models\Anime;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('anime_ratings', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Anime::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(User::class)->constrained()->cascadeOnDelete();
            $table->unsignedTinyInteger('assessment');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('anime_ratings');
    }
};

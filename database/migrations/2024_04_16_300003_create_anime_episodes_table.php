<?php

use App\Models\Anime;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('anime_episodes', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Anime::class)
                ->constrained()
                ->cascadeOnDelete();
            $table->string('name_org');
            $table->string('name_ru');
            $table->string('name_en');
            $table->date('release_date');
            $table->text('note')->nullable();
            $table->enum('status', ['PUBLISHED', 'DRAFT', 'IN_ARCHIVE', 'ON_MODERATION'])->default('DRAFT');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('anime_episodes');
    }
};

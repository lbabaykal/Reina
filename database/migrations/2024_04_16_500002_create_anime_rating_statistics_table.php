<?php

use App\Models\Anime;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('anime_rating_statistics', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Anime::class)->constrained()->cascadeOnDelete();
            $table->unsignedBigInteger('assessment_1')->default(0);
            $table->unsignedBigInteger('assessment_2')->default(0);
            $table->unsignedBigInteger('assessment_3')->default(0);
            $table->unsignedBigInteger('assessment_4')->default(0);
            $table->unsignedBigInteger('assessment_5')->default(0);
            $table->unsignedBigInteger('assessment_6')->default(0);
            $table->unsignedBigInteger('assessment_7')->default(0);
            $table->unsignedBigInteger('assessment_8')->default(0);
            $table->unsignedBigInteger('assessment_9')->default(0);
            $table->unsignedBigInteger('assessment_10')->default(0);
            $table->unsignedBigInteger('count_assessments')->default(0);
            $table->float('rating', 2)->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('anime_rating_statistics');
    }
};

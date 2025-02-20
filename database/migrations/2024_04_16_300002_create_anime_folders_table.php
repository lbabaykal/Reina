<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('anime_folders', function (Blueprint $table) {
            $table->id();
            $table->string('title', 32);
            $table->unsignedBigInteger('user_id');
            $table->boolean('is_private')->default(true);
            $table->unsignedBigInteger('number');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('anime_folders');
    }
};

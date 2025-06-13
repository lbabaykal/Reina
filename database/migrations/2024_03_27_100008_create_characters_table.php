<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('characters', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->string('full_name_org');
            $table->string('full_name_ru');
            $table->string('full_name_en');
            $table->string('photo')->nullable();
            $table->text('description')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('characters');
    }
};

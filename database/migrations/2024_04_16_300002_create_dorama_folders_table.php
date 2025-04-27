<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('dorama_folders', function (Blueprint $table) {
            $table->id();
            $table->string('name', 32);
            $table->unsignedBigInteger('user_id');
            $table->boolean('is_private')->default(true);
            $table->unsignedBigInteger('number')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dorama_folders');
    }
};

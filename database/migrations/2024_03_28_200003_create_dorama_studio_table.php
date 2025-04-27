<?php

use App\Models\Dorama;
use App\Models\Studio;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('dorama_studio', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Dorama::class)
                ->constrained()
                ->cascadeOnDelete();
            $table->foreignIdFor(Studio::class)
                ->constrained()
                ->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dorama_studio');
    }
};

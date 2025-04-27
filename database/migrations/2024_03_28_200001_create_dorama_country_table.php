<?php

use App\Models\Country;
use App\Models\Dorama;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('dorama_country', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Dorama::class)
                ->constrained()
                ->cascadeOnDelete();
            $table->foreignIdFor(Country::class)
                ->constrained()
                ->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dorama_country');
    }
};

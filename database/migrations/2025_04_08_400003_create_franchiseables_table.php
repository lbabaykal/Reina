<?php

use App\Models\Franchise;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('franchiseables', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Franchise::class)
                ->constrained()
                ->cascadeOnDelete();
            $table->morphs('franchiseable');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('franchiseables');
    }
};

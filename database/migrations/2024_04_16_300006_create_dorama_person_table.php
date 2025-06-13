<?php

use App\Models\Dorama;
use App\Models\Person;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('dorama_person', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Dorama::class)
                ->constrained()
                ->cascadeOnDelete();
            $table->foreignIdFor(Person::class)
                ->constrained()
                ->cascadeOnDelete();
            $table->enum('role', ['MAIN', 'SECONDARY', 'EPISODIC'])->default('SECONDARY');
            $table->timestamps();

            $table->unique(['dorama_id', 'person_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dorama_persons');
    }
};

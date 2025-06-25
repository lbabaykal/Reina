<?php

use App\Models\Anime;
use App\Models\Person;
use App\Models\PersonRole;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('anime_person', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Anime::class)
                ->constrained()
                ->cascadeOnDelete();
            $table->foreignIdFor(Person::class)
                ->constrained()
                ->cascadeOnDelete();
            $table->foreignIdFor(PersonRole::class)
                ->constrained()
                ->cascadeOnDelete();
            $table->timestamps();

            $table->unique(['anime_id', 'person_id', 'person_role_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('anime_person');
    }
};

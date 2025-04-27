<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::connection('timescale')->create('dorama_views', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('dorama_id')->index();
            $table->ipAddress();
            $table->string('user_agent')->nullable();
            $table->timestamps();

            $table->primary(['id', 'created_at']);
        });

        DB::connection('timescale')->statement('
            SELECT create_hypertable(\'dorama_views\', \'created_at\', chunk_time_interval => interval \'1 month\');
        ');
    }

    public function down(): void
    {
        DB::connection('timescale')->statement('DROP TABLE IF EXISTS dorama_views CASCADE;');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('movies', function (Blueprint $table) {
            $table->id();
            $table->string('imdb_id'); // tconst
            $table->string('type'); // titleType
            $table->string('primary_title'); // primaryTitle
            $table->string('original_title')->nullable(); // originalTitle (nullable if not always present)
            $table->boolean('is_adult')->default(false); // isAdult
            $table->integer('start_year')->nullable(); // startYear (nullable if not always present)
            $table->integer('end_year')->nullable(); // endYear (nullable if not always present)
            $table->integer('runtime_minutes')->nullable(); // runtimeMinutes (nullable if not always present)
            $table->string('genres')->nullable(); // genres (nullable if not always present)
            $table->decimal('avg_rating', 5, 2)->default(0.0);
            $table->unsignedInteger('num_votes')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('movies');
    }
};

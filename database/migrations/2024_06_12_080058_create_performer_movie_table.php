<?php

use App\Models\Movie;
use App\Models\Performer;
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
        Schema::create('performer_movie', function (Blueprint $table) {
            $table->foreignIdFor(Performer::class)->constrained();
            $table->foreignIdFor(Movie::class)->constrained();
            $table->primary(['performer_id', 'movie_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('performer_movie');
    }
};

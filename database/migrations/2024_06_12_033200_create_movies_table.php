<?php

use App\Models\Category;
use App\Models\Classify;
use App\Models\Director;
use App\Models\Format;
use App\Models\Language;
use App\Models\User;
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
            $table->string('name');
            $table->integer('price');
            $table->string('image')->nullable();
            $table->text('content');
            $table->string('trailer')->nullable();
            $table->date('premiere')->nullable();
            $table->integer('time');
            $table->foreignIdFor(Category::class)->constrained();
            $table->foreignIdFor(Classify::class)->constrained();
            $table->foreignIdFor(Format::class)->constrained();
            $table->foreignIdFor(Language::class)->constrained();
            $table->foreignIdFor(User::class)->constrained();
            $table->foreignIdFor(Director::class)->constrained();
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

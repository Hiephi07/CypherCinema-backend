<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'price',
        'image',
        'content',
        'trailer',
        'premiere',
        'time',
        'category_id',
        'classify_id',
        'format_id',
        'director_id',
        'language_id',
        'user_id',
    ];

    public function category() {
        return $this->belongsTo(Category::class);
    }

    public function language() {
        return $this->belongsTo(Language::class);
    }

    public function format() {
        return $this->belongsTo(Format::class);
    }

    public function classify() {
        return $this->belongsTo(Classify::class);
    }

    public function director() {
        return $this->belongsTo(Director::class);
    }

    public function performers() {
        return $this->belongsToMany(Performer::class, 'performer_movie');
    }

    public function showtimes() {
        return $this->hasMany(Showtime::class);
    }
}

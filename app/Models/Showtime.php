<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Showtime extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['movie_id', 'date', 'time_start', 'theater_id'];

    public function movie() {
        return $this->belongsTo(Movie::class);
    }

    public function room() {
        return $this->belongsTo(Room::class);
    }
}

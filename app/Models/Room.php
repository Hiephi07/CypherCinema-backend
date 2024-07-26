<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Room extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['name', 'theater_id', 'status'];

    public function showtimes() {
        return $this->hasMany(Showtime::class);
    }

    public function theater() {
        return $this->belongsTo(Theater::class);
    }

    public function seats() {
        return $this->hasMany(Seat::class);
    }
}

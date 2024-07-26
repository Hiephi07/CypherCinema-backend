<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Theater extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['name', 'image', 'content', 'address', 'email', 'phone', 'city_id'];

    public function rooms() {
        return $this->hasMany(Room::class);
    }

    public function city () {
        return $this->belongsTo(City::class);
    }
}

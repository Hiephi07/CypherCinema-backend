<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Seat extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $fillable = ['row', 'col', 'status', 'price', 'seat_type_id', 'room_id'];

    public function room() {
        return $this->belongsTo(Room::class);
    }

    public function seatType() {
        return $this->belongsTo(SeatType::class);
    }
}

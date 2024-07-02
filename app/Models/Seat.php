<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seat extends Model
{
    use HasFactory;
    
    protected $fillable = ['row', 'col', 'status', 'seat_type_id', 'room_id'];

    public function room() {
        return $this->belongsTo(Room::class);
    }

    public function seatType() {
        return $this->belongsTo(SeatType::class);
    }
}

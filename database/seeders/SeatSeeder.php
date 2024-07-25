<?php

namespace Database\Seeders;

use App\Models\Room;
use App\Models\Seat;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class SeatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        Seat::truncate();

        $rows = ['A', 'B', 'C', 'D'];
        $cols = ['1', '2', '3', '4'];

        $roomIds = Room::pluck('id');

        foreach ($roomIds as $roomId) {
            foreach ($rows as $row) {
                foreach ($cols as $col) {
                    $seatTypeId = 1; 
                    if (($row == 'B' && ($col == '3' || $col == '4')) || ($row == 'C' && ($col == '3' || $col == '4'))) {
                        $seatTypeId = 2;
                    }
                    Seat::create([
                        'row' => $row,
                        'col' => $col,
                        'status' => 1,
                        'price' => 200000,
                        'seat_type_id' => $seatTypeId,
                        'room_id' => $roomId,
                    ]);
                }
            }
        }
        
    }
}

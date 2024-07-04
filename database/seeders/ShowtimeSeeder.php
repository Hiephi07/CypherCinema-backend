<?php

namespace Database\Seeders;

use App\Models\Showtime;
use App\Models\Theater;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class ShowtimeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {   
        Schema::disableForeignKeyConstraints();
        Showtime::truncate();
        Theater::truncate();
        for ($i = 0; $i < 5; $i++) { 
            Theater::create([
                'name' => fake()->name(),
                'image' => 'https://bhdstar.vn/wp-content/uploads/2023/12/GARDEN-243x330-1.jpg',
                'content' => fake()->paragraph(5)
            ]);
        }

        for ($i = 0; $i < 10; $i++) {
            Showtime::create([
                'movie_id' => random_int(1, 20),
                'date' => Carbon::now()->addDays(random_int(1, 30))->format('Y-m-d'),
                'time_start' => Carbon::createFromTime(random_int(7, 23), random_int(0, 59), random_int(0, 59))->format('H:i:s'),
                'theater_id' => random_int(1, 5)
            ]);
        }
    }
}

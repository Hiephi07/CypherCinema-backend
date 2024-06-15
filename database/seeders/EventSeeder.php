<?php

namespace Database\Seeders;

use App\Models\Event;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Event::truncate();

        for($i = 0; $i < 3; $i++) {
            Event::create([
                'title' => fake()->sentence(),
                'title_sub' => fake()->sentence(10),
                'image' => 'https://bhdstar.vn/wp-content/uploads/2024/04/WEB-LED-COMBO-LY-DOI-MAU-KO-GIA.jpg',
                'content' => fake()->paragraph(5),
                'status' => true
            ]);
        }
    }
}

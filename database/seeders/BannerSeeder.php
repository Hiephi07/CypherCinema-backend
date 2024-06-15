<?php

namespace Database\Seeders;

use App\Models\Banner;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BannerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Banner::truncate();
        foreach (['main', 'sub', 'sub'] as $key => $value) {
            Banner::create([
                'image' => 'https://bhdstar.vn/wp-content/uploads/2024/03/duoi-13-t-va-duoi-16t.jpg',
                'status' => ($key % 2 == 0) ? true : false,
                'type' => $value,
            ]);
        }
    }
}

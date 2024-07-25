<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = new User;
        $user->email = "abc@gmail.com";
        $user->password = Hash::make("abcxyz");
        $user->fullname = "Dao Le Man Buoi";
        $user->number_phone = "0987654321";
        $user->sex = 1;
        $user->birthday = "2000-01-01";
        $user->save();
    }
}

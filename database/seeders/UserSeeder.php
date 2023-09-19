<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users= [
            [
                
                'name'=> "David Lightman",
                'email' => "defcon@one.com",
                'email_verified_at' => '2023-07-06 16:58:34',
                'password'=> "$2y$10$4cEHvJXsKhCBcN.9c9GlKuWh6IUIbzNlOzj55hLPow7PGfiPDY26W",
                'profile_photo_path' => 'photos/XfSVHcZlBgnZiUsyV7VgEFRJG49iVkhDhN9iwAid.jpg',
                'created_at' => '2023-07-06 16:48:59',
                'updated_at' => '2023-07-06 16:58:34',
            ],
        ];

        foreach ($users as $userData) {
            User::create($userData);
        }
    }
}

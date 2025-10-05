<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        for ($i = 1; $i <= 20; $i++) {
            User::factory()->create([
                'name' => "User $i",
                'email' => "user$i@example.com",
            ]);
        }
    }
}

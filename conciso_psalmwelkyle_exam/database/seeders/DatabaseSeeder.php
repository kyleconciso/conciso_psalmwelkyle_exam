<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{

    public function run(): void
    {
        // Create admin and dummy products
        $this->call(AdminUserSeeder::class);
        $this->call(ProductSeeder::class);
    }
}
<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Reservation;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        $this->call([
            UserSeeder::class,
            CategorySeeder::class,
            MenuItemSeeder::class,
            TestimonySeeder::class,
            BranchesTableSeeder::class,
            TablesSeeder::class,
            ReservationsSeeder::class,
            ReviewsSeeder::class,
            ordersSeeder::class,
            order_itemsSeeder::class
        ]);

        
    }
}

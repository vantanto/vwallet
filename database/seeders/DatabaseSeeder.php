<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        \App\Models\User::factory()->create([
            'name' => 'Test Admin',
            'username' => 'admin',
            'email' => 'admin@example.com',
        ]);
        \App\Models\User::factory()->create([
            'name' => 'Test Admin 2',
            'username' => 'admin2',
            'email' => 'admin2@example.com',
        ]);

        $this->call([
            CategoriesSeeder::class,
            WalletsSeeder::class,
        ]);
    }
}

<?php

namespace Database\Seeders;

use App\Models\Wallet;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class WalletsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Wallet::create([
            'name' => 'My Wallet 1',
            'initial_balance' => 100000,
            'balance' => 100000,
            'is_main' => true,
            'user_id' => 1,
        ]);
        Wallet::create([
            'name' => 'My Wallet 2',
            'initial_balance' => 200000,
            'balance' => 200000,
            'is_main' => true,
            'user_id' => 2,
        ]);
    }
}

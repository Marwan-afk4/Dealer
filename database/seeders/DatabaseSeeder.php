<?php

namespace Database\Seeders;

use App\Models\Ad;
use App\Models\Brocker;
use App\Models\Developer;
use App\Models\Lead;
use App\Models\Request;
use App\Models\SalePeople;
use App\Models\Uptown;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Ad::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}

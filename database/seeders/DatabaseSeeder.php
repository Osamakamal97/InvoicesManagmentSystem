<?php

namespace Database\Seeders;

use App\Models\User;
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
        User::create([
            'name' => 'osama',
            'email' => 'osama@example.com',
            'password' => 'password',
        ]);
        
        $this->call([
            SectionSeeder::class,
            ProductSeeder::class,
        ]);
    }
}

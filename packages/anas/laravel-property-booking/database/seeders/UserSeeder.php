<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        \App\Models\User::factory()->count(5)->state(['role' => 'host'])->create();
        \App\Models\User::factory()->count(10)->state(['role' => 'guest'])->create();
    }

}

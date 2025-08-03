<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Team;
use App\Models\User;

class TeamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Team::factory()->count(5)->create()->each(function ($team) {
            $team->users()->attach(User::inRandomOrder()->take(3)->pluck('id'));
        });
    }
}

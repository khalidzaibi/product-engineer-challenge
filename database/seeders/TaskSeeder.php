<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Task;
use App\Models\User;
use Carbon\Carbon;

class TaskSeeder extends Seeder
{
    public function run(): void
    {
        $userIds = User::pluck('id')->toArray();

        $taskTitles = [
            'Fix login issue on production',
            'Refactor API authentication logic',
            'Implement search feature using Laravel Scout',
            'Configure NGINX for subdomain routing',
            'Set up unit testing for Task module',
            'Upgrade PHP to 8.3 in Docker',
            'Optimize SQL queries for dashboard',
            'Create REST API for mobile app',
            'Migrate project to Laravel 11',
            'Integrate Sentry for error tracking',
        ];

        foreach ($taskTitles as $title) {
            $startDate = Carbon::now()->subDays(rand(1, 7));
            $endDate = (clone $startDate)->addDays(rand(1, 5));

            Task::create([
                'title'        => $title,
                'description'  => fake()->sentence(8),
                'assigned_to'  => $userIds[array_rand($userIds)],
                'created_by'   => $userIds[array_rand($userIds)],
                'start_date'   => $startDate->toDateString(),
                'end_date'     => $endDate->toDateString(),
                'is_completed' => rand(0, 1),
            ]);
        }
    }
}

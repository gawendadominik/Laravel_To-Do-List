<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Tasks;

class TasksSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get or create a test user
        $user = \App\Models\User::first() ?? \App\Models\User::factory()->create();

        Tasks::create([
            'id' => (string) \Illuminate\Support\Str::uuid(),
            'user_id' => $user->id,
            'title' => "Task " . \Illuminate\Support\Str::random(8),
            'description' => "Description: " . \Illuminate\Support\Str::random(20),
            'priority' => 'low',
            'status' => 'to-do',
            'due_date' => now()->toDateString(),
        ]);

        Tasks::create([
            'id' => (string) \Illuminate\Support\Str::uuid(),
            'user_id' => $user->id,
            'title' => "Task " . \Illuminate\Support\Str::random(8),
            'description' => "Description: " . \Illuminate\Support\Str::random(20),
            'priority' => 'high',
            'status' => 'to-do',
            'due_date' => now()->addDays(5)->toDateString(),
        ]);

        foreach (range(1, 10) as $index) {
            Tasks::create([
                'id' => (string) \Illuminate\Support\Str::uuid(),
                'user_id' => $user->id,
                'title' => "Task " . \Illuminate\Support\Str::random(8),
                'description' => "Description: " . \Illuminate\Support\Str::random(20),
                'priority' => 'medium',
                'status' => 'to-do',
                'due_date' => now()->addDays($index)->toDateString(),
            ]);
        }
    }
}

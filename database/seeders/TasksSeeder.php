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
        foreach (range(1, 10) as $index) {
            Tasks::create([
                'id' => (string) \Illuminate\Support\Str::uuid(),
                'user_id' => (string) \Illuminate\Support\Str::uuid(),
                'title' => "Task " . \Illuminate\Support\Str::random(8),
                'description' => "Description: " . \Illuminate\Support\Str::random(20),
                'priority' => 'medium',
                'status' => 'to-do',
                'due_date' => now()->addDays($index)->toDateString(),
            ]);
        }
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Tasks;
use Illuminate\Http\Request;
use App\Models\PublicTaskLink;
use Illuminate\Support\Str;

class TasksController extends Controller
{
    public function index()
    {
        // Fetch and return all tasks
        return response()->json(
            Tasks::where('user_id', auth()->user()->id)
                ->where('is_deleted', false)
                ->orderBy('due_date')
                ->get()
                ->groupBy('due_date')
        );
    }

    public function store(Request $request)
    {
        // Validate and create a new task
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'priority' => 'required|in:low,medium,high',
            'status' => 'required|in:to-do,in progress,done',
            'due_date' => 'required|date',
        ]);

        $validatedData['user_id'] = auth()->user()->id;

        $task = Tasks::create($validatedData);

        return response()->json($task, 201);
    }

    public function show($id)
    {
        // Fetch and return a specific task
        $task = Tasks::where('id', $id)
            ->where('user_id', auth()->user()->id)
            ->where('is_deleted', false)
            ->firstOrFail();

        return response()->json($task);
    }

    public function update(Request $request, $id)
    {
        // Validate and update a specific task
        $validatedData = $request->validate([
            'title' => 'sometimes|string|max:255',
            'description' => 'nullable|string',
            'priority' => 'sometimes|in:low,medium,high',
            'status' => 'sometimes|in:to-do,in progress,done',
            'due_date' => 'sometimes|date',
        ]);

        $isIdExists = Tasks::find($id); // Use 'id' instead of 'uuid'
        if (!$isIdExists) {
            return response()->json(['error' => 'Task not found'], 404);
        }
        // dd($id);
        $task = Tasks::where('id', $id)->where('user_id', auth()->user()->id)->firstOrFail();
        $task->update($validatedData);

        return response()->json($task);
    }

    public function destroy($id)
    {
        // dd($id);
        // Soft delete a specific task by setting is_deleted to true
        $task = Tasks::where('id', $id)->where('user_id', auth()->user()->id)->firstOrFail();
        $task->update(['is_deleted' => true]);

        return response()->json(null, 204);
    }

    public function createPublicLink($taskId)
    {
        $token = Str::random(40);
        $publicLink = PublicTaskLink::create([
            'task_id' => $taskId,
            'token' => $token,
            'expires_at' => now()->addDays(7), // optional
        ]);

        return response()->json([
            'link' => route('public.task.show', $publicLink->token),
            'expires_at' => $publicLink->expires_at,
        ]);
    }

    public function getPublicLink($taskId)
    {
        $publicLink = PublicTaskLink::where('task_id', $taskId)
            ->where(function ($query) {
                $query->whereNull('expires_at')
                    ->orWhere('expires_at', '>', now());
            })
            ->first();

        if (!$publicLink) {
            return response()->json(['error' => 'Public link not found or expired'], 404);
        }
        return response()->json([
            'link' => route('public.task.show', $publicLink->token),
            'expires_at' => $publicLink->expires_at,
        ]);
    }
}

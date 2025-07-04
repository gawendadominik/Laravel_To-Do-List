<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tasks;

class TasksController extends Controller
{
    public function index()
    {
        // Fetch and return all tasks
        return response()->json(
            Tasks::all()
                ->sortBy('due_date')
                ->groupBy('due_date')
        );
    }

    public function store(Request $request)
    {
        // Validate and create a new task
        $validatedData = $request->validate([
            'user_id' => 'required|exists:users',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'priority' => 'required|in:low,medium,high',
            'status' => 'required|in:to-do,in progress,done',
            'due_date' => 'required|date',
        ]);

        $task = Tasks::create($validatedData);

        return response()->json($task, 201);
    }

    public function show($id)
    {
        // Fetch and return a specific task
        $task = Tasks::findOrFail($id);

        return response()->json($task);
    }

    public function update(Request $request, $id)
    {
        // Validate and update a specific task
        $validatedData = $request->validate([
            'user_id' => 'sometimes|exists:users,id',
            'title' => 'sometimes|string|max:255',
            'description' => 'nullable|string',
            'priority' => 'sometimes|in:low,medium,high',
            'status' => 'sometimes|in:to-do,in progress,done',
            'due_date' => 'sometimes|date',
        ]);

        $task = Tasks::findOrFail($id);
        $task->update($validatedData);

        return response()->json($task);
    }

    public function destroy($id)
    {
        // Delete a specific task
        $task = Tasks::findOrFail($id);
        $task->delete();

        return response()->json(null, 204);
    }
}

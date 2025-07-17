<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    public function index()
    {
        return response()->json([
            'tasks' => Auth::user()->tasks()->latest()->get()
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:Pending,In Progress,Completed,On Hold',
            'priority' => 'required|in:Low,Medium,High,Critical',
            'due_date' => 'nullable|date',
        ]);

        $task = Auth::user()->tasks()->create($validated);

        return response()->json([
            'message' => 'Task created successfully',
            'task' => $task
        ], 201);
    }

    public function show(Task $task)
    {
        return response()->json(['task' => $task]);
    }

    public function update(Request $request, Task $task)
    {

        $validated = $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'sometimes|required|in:Pending,In Progress,Completed,On Hold',
            'priority' => 'sometimes|required|in:Low,Medium,High,Critical',
            'due_date' => 'nullable|date',
        ]);

        $task->update($validated);

        return response()->json([
            'message' => 'Task updated successfully',
            'task' => $task
        ]);
    }

    public function destroy(Task $task)
    {
        $task->delete();
        return response()->json(['message' => 'Task deleted successfully']);
    }
}

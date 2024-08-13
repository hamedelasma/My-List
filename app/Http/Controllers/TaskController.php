<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{


    public function store(Request $request)
    {
        $inputs = $request->validate([
            'name' => ['string', 'required'],
            'description' => ['max:1000'],
            'is_done' => ['boolean'],
            'before_date' => [],
            'priority' => ['required', 'string', 'in:low,mid,high']
        ]);

        Task::create($inputs);

        return response()->json([
            'data' => 'task created successfully'
        ]);
    }

    public function index(Request $request)
    {
        $request->validate([
            'sort' => ['in:before_date,priority,id'],
            'is_done' => ['boolean']
        ]);
        $tasks = Task::query();

        if ($request->has('priority')) {
            $tasks = $tasks->where('priority', '=', $request->input('priority'));
        }
        if ($request->has('upcoming')) {
            $tasks = $tasks->where('before_date', '>=', date('Y-m-d H-i'));
        }

        if ($request->has('sort')) {
            $tasks = $tasks->orderBy($request->input('sort'), 'asc');
        }

        if ($request->has('is_done')) {
            $tasks = $tasks->where('is_done', '=', $request->input('is_done'));
        }

        return response()->json([
            'data' => $tasks->get()
        ]);
    }

    public function complete($id)
    {
        $task = Task::where('id', '=', $id)->where('is_done', '!=', 1)->firstOrFail();

        $task->update([
            'is_done' => true
        ]);

        return response()->json([
            'data' => 'task updated successfully'
        ]);
    }

    public function cancel($id)
    {
        $task = Task::findOrFail($id);

        if ($task->is_done === 0) {
            return response()->json([
                'data' => 'Task is not completed yet.'
            ], 422);
        }

        $task->update([
            'is_done' => false
        ]);

        return response()->json([
            'data' => 'task updated successfully'
        ]);
    }
}

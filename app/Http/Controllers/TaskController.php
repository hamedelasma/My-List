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

        $tasks = Task::query();

        if ($request->has('priority')) {
            $tasks = $tasks->where('priority', '=', $request->input('priority'));
        }
        if ($request->has('upcoming')) {
            $tasks = $tasks->where('before_date', '>=', date('Y-m-d H-i'));
        }


        return response()->json([
            'data' => $tasks->get()
        ]);
    }
}

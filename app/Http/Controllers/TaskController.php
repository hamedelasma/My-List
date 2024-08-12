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
        if ($request->has('priority')){
            $tasks = Task::where('priority','=',$request->input('priority'))->get();
            return  response()->json([
                'data' => $tasks
            ]);
        }
        $tasks = Task::all();

        return response()->json([
            'data' => $tasks
        ]);
    }
}

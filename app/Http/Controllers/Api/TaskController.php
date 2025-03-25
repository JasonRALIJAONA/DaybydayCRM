<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\Task;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = Task::all();

        return response()->json([
            'success' => true,
            'message' => 'Task data',
            'data' => $tasks,
        ], 200);
    }
}
<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /* Display a listing of the task.*/
    public function index()
    {
        return response(Task::all(),200);
    }

    /* Display the specified task.*/
    public function show($id)
    {
        try{
            return Task::findOrFail($id);
        }catch(\Exception $exception) {
            return Response()->json(['Error message ' => $exception->getMessage()], 404);
        }
    }

    /* Store a newly created task in storage. */
    public function store(Request $request){
        try {
            $validated = $request->validate([
                'title' => 'required|max:50',
            ]);
            $task = new task();
            $task->title = $request->input('title');
            if (($request->exists('is_completed'))){
                $task->is_completed = $request -> input('is_completed');
            }
            $task -> save();
            return response($task);
        }catch(\Exception $exception) {
            return Response()->json(['Error message ' => $exception->getMessage()], 404);
        }

    }

    /* Update the specified task in storage. */
    public function update(Request $request, $id)
    {
        try {
            $taskEdit = Task::findOrFail($id);
            if ($request->exists('title')) {

                $taskEdit->title = $request->title;
            }
            if ($request->exists('is_completed')) {
                $taskEdit->is_completed = $request->is_completed;
            }
            $taskEdit->save();
            return response($taskEdit);
        }catch(\Exception $exception) {
            return Response()->json(['Error message ' => $exception->getMessage()], 404);
        }

    }

    /* Remove the specified task from storage. */
    public function destroy($id)
    {
        try
        {
            $taskDelete = Task::findOrFail($id);
            $taskDelete->delete();
            return response()->json(['success' =>'Task has been deleted']);
        }
        catch(\Exception $exception) {
           return Response()->json(['Error message ' => $exception->getMessage()], 404);
        }

       }

    /* Remove multiple task from storage. */
    public function multipleDelete(Request $request)
    {
        try {
            Task::destroy($request->ids);
            return response()->json(['success' =>'Tasks have been deleted']);
        }catch(\Exception $exception) {
            return Response()->json(['Error message ' => $exception->getMessage()], 404);
        }

    }

    /* Store multiple task in storage. */
    public function multipleStore(Request $request)
    {
        try {
            Task::insert($request->tasks);
            return response('Tasks stored successfully.');
        }catch(\Exception $exception) {
            return Response()->json(['Error message ' => $exception->getMessage()], 404);
        }

    }
}

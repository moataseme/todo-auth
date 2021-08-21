<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $status = true;
        $data = Task::where('user_id', $request->user()->id)->get();
        $errors = [];

        $response = array(
            'status' => $status,
            'data' => $data,
            'errors' => $errors
        );

        return response()->json($response);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = Validator::make($request->only(['title']), [
            'title' => 'required|min:3|regex:/(^[A-Za-z0-9 ]+$)+/'
        ], [
            'title.regex' => 'Invalid title, Only characters, numbers and spaces allowed'
        ]);

        $status = true;
        $data = [];
        $errors = [];

        if ($validated->fails()) {
            $status = false;
            $errors = $validated->errors();
        }else{
            $task = Task::make($validated->validated());
            $task->user_id = $request->user()->id;
            $task->save();
        }

        $response = array(
            'status' => $status,
            'data' => $data,
            'errors' => $errors
        );

        return response()->json($response);
    }

    //Update 
    public function update(Request $request, $id)
    { 
        $validated = Validator::make($request->only(['isCompleted']), [
            'isCompleted' => 'required|boolean'
        ]);

        $update = Task::where('id', $id)->where('user_id', auth()->user()->id)->update($validated->validated());

        $status = true;
        $data = [];
        $errors = [];

        if (!$update) {
            $status = 'false';
            $errors = array(['Task not found']);
        }

        $response = array(
            'status' => $status,
            'data' => $data,
            'errors' => $errors
        );

        return response()->json($response);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function destroy(Task $task, $id)
    { 
        $destroy = Task::where('id', $id)->where('user_id', auth()->user()->id)->delete();

        $status = true; $data = []; $errors = [];

        if (!$destroy) {
            $status = 'false';
            $errors = array(['Task not found']);
        }

        $response = array(
            'status' => $status,
            'data' => $data,
            'errors' => $errors
        );

        return response()->json($response);
    }
}

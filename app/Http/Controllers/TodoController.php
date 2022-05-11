<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use Illuminate\Http\Request;
use App\Http\Requests\Todo\CreateTodoRequest;

class TodoController extends Controller
{
    public function createtodo(CreateTodoRequest $request) {
        $newtodo = Todo::create($request->all());
        $newtodo->refresh();
        return response()->json([
            "message" => "New todo created successfully.",
            "status" => "success",
            "todo" => $newtodo
        ], 200);
    } 

    public function singletodo($id) {
        $todo = Todo::where("id", $id)->first();
        if ($todo == null) {
            return response([
                "message" => "No todo available",
                "status" => "error",
                "todo" => $todo
            ], 400);        
        }
        return response([
            "message" => "Todo fetched success",
            "status" => "success",
            "todo" => $todo
        ], 200);        
    }

    public function deletetodo($id) {
        $todo = Todo::where("id", $id)->first();
        if ($todo == null) {
            return response([
                "message" => "No todo available.",
                "status" => "error",
                "todo" => $todo
            ], 400);        
        }
        $todo->delete();
        return response([
            "message" => "Todo deleted success.",
            "status" => "success",
        ], 200);        
    }

    public function clear_completed() {
        $todos = Todo::where("status", '1')->delete();
        return response([
            "message" => "Completed Todos cleared successfully.",
            "status" => "success",
        ], 200);   
    }

    public function complete_todo($id) {
        $todo = Todo::where("id", $id)->first();
        if ($todo == null) {
            return response([
                "message" => "No todo available.",
                "status" => "error",
            ], 400);        
        }
        if ($todo->status == '1') {
            return response([
                "message" => "Todo already completed.",
                "status" => "error",
            ], 400); 
        }
        $todo->update([
            "status" => "1"
        ]);
        $todo->refresh();
        return response([
            "message" => "Todo move to compeleted successfully.",
            "status" => "success",
            "todo" => $todo
        ], 200);        
    }

    public function movetodo_toactive($id) {
        $todo = Todo::where("id", $id)->first();
        if ($todo == null) {
            return response([
                "message" => "No todo available.",
                "status" => "error",
            ], 400);        
        }
        if ($todo->status == '0') {
            return response([
                "message" => "Todo is active.",
                "status" => "error",
            ], 400); 
        }
        $todo->update([
            "status" => "0"
        ]);
        $todo->refresh();
        return response([
            "message" => "Todo moved to active successfully.",
            "status" => "success",
            "todo" => $todo
        ], 200);        
    }

    public function listodo(Request $request) {
        $request->validate([
            "status" => "nullable|string",
            "page_number" => "nullable|integer"
        ]);
        if ($request->status == null) {
            $todos = Todo::orderBy('created_at', 'DESC')->get();
            if ($todos->isEmpty()) {
                return response([
                    "message" => "No todos available.",
                    "status" => "error",
                    "todos" => $todos
                ], 200);        
            }
            if ($todos->isNotEmpty()) {
                return response([
                    "message" => "Todos fetched successfullly.",
                    "status" => "success",
                    "todos" => $todos
                ], 200);     
            }
        }

        $todos = Todo::where("status", $request->status)->get();
        if ($todos->isEmpty()) {
            return response([
                "message" => "No todos available.",
                "status" => "error",
                "todos" => $todos
            ], 400);        
        }
        if ($todos->isNotEmpty()) {
            return response([
                "message" => "Todos fetched successfullly.",
                "status" => "success",
                "todos" => $todos
            ], 200);     
        }
        
    }
}

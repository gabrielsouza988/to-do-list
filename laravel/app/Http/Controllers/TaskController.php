<?php

namespace App\Http\Controllers;

use App\Models\ItemsTask;
use App\Models\Task;
use ErrorException as ErrorExceptionAlias;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $tasks = Task::where('user_id', Auth::user()->id)->get();

        if (empty($tasks)) {
            return response()->json(['tasks' => 'Você ainda não tem nenhuma task!', 'hasError' => false], 200);
        }

        return response()->json(['tasks' => $tasks, 'hasError' => false], 202);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        try {
            $task = Task::create([
                'user_id' => Auth::user()->id,
                'task' => $request['task'],
                'date' => date('Y-m-d'),
            ]);

            return response()->json([
                'message' => "tarefa criada com sucesso!",
                'task' => $task,
                'hasError' => false
            ], 202);
        } catch (QueryException $e) {
            return response()->json(['message' => "Houve algum erro!", 'error' => $e, 'hasError' => true], 400);
        }
    }


    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        try {
            $task = Task::find($id);
            if (empty($task)) {
                return response()->json(['message' => 'Tarefa não encontrada!', 'hasError' => true], 400);
            }

            return response()->json(["message" => "Tarefa encontrada!", 'task' => $task, 'hasError' => false], 202);
        } catch (QueryException $e) {
            return response()->json(['message' => "Houve algum erro!", 'error' => $e, 'hasError' => true], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function delete(int $id): JsonResponse
    {
        try {
            $task = Task::find($id);
            if (empty($task)) {
                return response()->json(['message' => 'Tarefa não encontrada!', 'hasError' => true], 400);
            }

            $task->delete();
            $tasks = Task::find($id);
            return response()->json([
                'task' => $tasks,
                'message' => 'Tarefa deletada com sucesso!',
                'hasError' => false
            ], 202);
        } catch (QueryException $e) {
            return response()->json(['message' => "Houve algum erro!", 'error' => $e, 'hasError' => true], 400);
        }
    }
}

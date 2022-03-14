<?php

namespace App\Http\Controllers;

use App\Models\SecondaryTask;
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
            return response()->json(['tasks' => 'Você ainda não tem nenhuma task!'], 200);
        }

        return response()->json(['tasks' => $tasks], 202);
    }

    public function secondaryTasks($id)
    {
        $tasks = SecondaryTask::where('task_id', $id)->get();

        if (empty($tasks)) {
            return response()->json(['tasks' => 'Você ainda não tem nenhuma task!'], 200);
        }

        return response()->json(['tasksSecondary' => $tasks], 202);
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
                'task' => $task
            ], 202);
        } catch (QueryException $e) {
            return response()->json(['message' => "Houve algum erro!", 'error' => $e], 400);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function storeSecondaryTask(Request $request): JsonResponse
    {
        try {
            $task = SecondaryTask::create([
                'task_id' => $request['taskPrimary'],
                'task' => $request['task'],
                'date_execution' => $request['date'],
                'status' => '0'
            ]);

            return response()->json([
                'message' => "tarefa secundaria criada com sucesso!",
                'task' => $task
            ], 202);
        } catch (QueryException $e) {
            return response()->json(['message' => "Houve algum erro!", 'error' => $e], 400);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show($id): JsonResponse
    {
        try {
            $task = Task::find($id);
            if (empty($task)) {
                return response()->json(['message' => 'Tarefa não encontrada!'], 400);
            }

            return response()->json(["message" => "Tarefa encontrada!", 'task' => $task], 202);
        } catch (QueryException $e) {
            return response()->json(['message' => "Houve algum erro!", 'error' => $e], 400);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(Request $request, int $id): JsonResponse
    {
        try {
            $task = Task::find($id);
            if (empty($task)) {
                return response()->json(['message' => 'Tarefa não encontrada!'], 400);
            }

            $data = [];
            if ($task->task != $request['task']) {
                $data['task'] = $request['task'];
            }

            if ($task->task != $request['task']) {
                $data['date_execution'] = $request['date'];
            }

            if (!empty($data)) {
                $newTask = $task->update($data);
            }

            return response()->json(["message" => "Tarefa atualizada com sucesso!", 'task' => $newTask], 202);
        } catch (QueryException $e) {
            return response()->json(['message' => "Houve algum erro!", 'error' => $e], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}

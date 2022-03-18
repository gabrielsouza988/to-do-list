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

    /**
     * @param int $id
     * @return JsonResponse
     */
    public function secondaryTasks(int $id): JsonResponse
    {
        $tasks = SecondaryTask::where('task_id', $id)->get();

        if (empty($tasks)) {
            return response()->json(['tasks' => 'Você ainda não tem nenhuma task!'], 200);
        }

        return response()->json(['task' => Task::find($id), 'tasksSecondary' => $tasks], 202);
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
     * @param $idTaskPrimary
     * @return JsonResponse
     */
    public function storeSecondaryTask(Request $request, int $idTaskPrimary): JsonResponse
    {
        try {
            $task = SecondaryTask::create([
                'task_id' => $idTaskPrimary,
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
    public function show(int $id): JsonResponse
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

            if ($task->date != $request['date']) {
                $data['date'] = $request['date'];
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
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */
    public function secondaryTaskUpdate(Request $request, int $id): JsonResponse
    {
        try {
            $task = SecondaryTask::find($id);
            if (empty($task)) {
                return response()->json(['message' => 'Tarefa não encontrada!'], 400);
            }

            $data = [];
            if (isset($request['task'])){
                $data['task'] = $request['task'];
            }

            if (isset($request['date'])){
                $data['date_execution'] = $request['date'];
            }

            if (isset($request['status'])){
                $data['status'] = $request['status'];
            }

            $response = [
                'message' => 'Você não esta mandando dados no body!'
            ];
            $status = 400;
            if (!empty($data)) {
                $newTask = $task->update($data);
                $allTasks = SecondaryTask::where('task_id', $task->task_id)->get();

                $response = [
                    'newTask' => $newTask,
                    'allTasks' => $allTasks,
                    'message' => 'Tarefa atualizada com sucesso!'
                ];
                $status = 202;
            }

            return response()->json($response, $status);
        } catch (QueryException $e) {
            return response()->json(['message' => "Houve algum erro!", 'error' => $e], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function removeTask(int $id): JsonResponse
    {
        try {
            $task = Task::find($id);
            if (empty($task)) {
                return response()->json(['message' => 'Tarefa não encontrada!'], 400);
            }
            $task->delete();
            $tasks = Task::find($id);
            return response()->json([
                'task' => $tasks,
                'message' => 'Tarefa deletada com sucesso!'], 202);
        } catch (QueryException $e) {
            return response()->json(['message' => "Houve algum erro!", 'error' => $e], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function removeSecondaryTask(int $id): JsonResponse
    {
        try {
            $task = SecondaryTask::find($id);
            if (empty($task)) {
                return response()->json(['message' => 'Tarefa não encontrada!'], 400);
            }
            $task->delete();
            $tasks = SecondaryTask::where('task_id', $task->task_id)->get();
            return response()->json([
                'secondaryTask' => $tasks,
                'message' => 'Tarefa deletada com sucesso!'], 202);
        } catch (QueryException $e) {
            return response()->json(['message' => "Houve algum erro!", 'error' => $e], 400);
        }
    }
}

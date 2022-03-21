<?php

namespace App\Http\Controllers;

use App\Models\ItemsTask;
use App\Models\Task;
use App\Repositories\itemsTaskRepository;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ItensTaskController
{

    /**
     * @param int $id
     * @return JsonResponse
     */
    public function index(int $id): JsonResponse
    {
        $tasks = ItemsTask::where('task_id', $id)->get();

        if (empty($tasks)) {
            return response()->json(['tasks' => 'Você ainda não tem nenhuma task!', 'hasError' => false], 200);
        }

        return response()->json(['task' => Task::find($id), 'itemsTask' => $tasks, 'hasError' => false], 202);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @param $idTaskPrimary
     * @return JsonResponse
     */
    public function store(Request $request, int $idTaskPrimary): JsonResponse
    {
        try {
            $task = ItemsTask::create([
                'task_id' => $idTaskPrimary,
                'task' => $request['task'],
                'date_execution' => $request['date'],
                'status' => '0'
            ]);

            return response()->json([
                'message' => "Item criado com sucesso!",
                'task' => $task,
                'hasError' => false
            ], 202);
        } catch (QueryException $e) {
            return response()->json(['message' => "Houve algum erro!", 'error' => $e, 'hasError' => true], 400);
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
            $taskitens = new itemsTaskRepository();

            return $taskitens->update($request, $id);
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
            $taskitens = new itemsTaskRepository();

            return $taskitens->delete($id);
        } catch (QueryException $e) {
            return response()->json(['message' => "Houve algum erro!", 'error' => $e, 'hasError' => true], 400);
        }
    }

}

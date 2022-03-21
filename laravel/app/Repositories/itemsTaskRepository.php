<?php

namespace App\Repositories;

use App\Models\ItemsTask;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class itemsTaskRepository
{

    public function update(Request $request, int $id): JsonResponse
    {
        $itemTask = $this->findItem($id);
        if (empty($itemTask)) {
            return response()->json(array('message' => 'Você não esta mandando dados no body!', 'hasError' => true), 400);
        }

        if (isset($request['status'])){
            $data = ['status' => $request['status']];
        }

        if (empty($data)) {
            return response()->json(array('message' => 'Você não esta mandando dados no body!', 'hasError' => true), 400);
        }

        $newTask = $itemTask->update($data);
        $allTasks = ItemsTask::where('task_id', $itemTask->task_id)->get();

        return response()->json(array('updateTask' => $newTask, 'allTasks' => $allTasks, 'message' => 'Tarefa atualizada com sucesso!', 'hasError' => false), 200);
    }

    public function delete(int $id): JsonResponse
    {
        $itemTask = $this->findItem($id);
        if (empty($itemTask)) {
            return response()->json(['message' => 'Item não encontrado!', 'hasError' => true], 400);
        }

        $itemTask->delete();
        $tasks = ItemsTask::where('task_id', $itemTask->task_id)->get();

        return response()->json(['itemsTask' => $tasks, 'message' => 'Item deletado com sucesso!', 'hasError' => false], 202);
    }

    private function findItem(int $id): ItemsTask
    {
        return ItemsTask::find($id);
    }

}

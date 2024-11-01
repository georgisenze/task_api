<?php

namespace App\Http\Traits;

use App\Models\Task;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

trait TaskTrait
{

    public function getAllTasks()
    {
        try {
            DB::beginTransaction();
            $data = Task::where('user_id', auth()->user()->id)->get();
            DB::commit();
            return response()->json(['data' => $data], Response::HTTP_OK);
        } catch (\Exception $th) {
            DB::rollBack();
            Log::info(['error' =>  $th->getMessage()]);
            return response()->json(['success' => false, 'message' => 'Une erreur est survenue lors de la recupération des taches.'], Response::HTTP_BAD_REQUEST);
        }
    }

    public function createTask($request)
    {
        try {
            DB::beginTransaction();
            $data = $request->all();
            $data['user_id'] = auth()->user()->id;
            $data = Task::create($data);
            DB::commit();
            return response()->json(['data' => $data, 'message' => 'Tâche ajouter avec suucès'], Response::HTTP_OK);
        } catch (\Exception $th) {
            DB::rollBack();
            Log::info(['error' =>  $th->getMessage()]);
            return response()->json(['success' => false, 'message' => 'Une erreur est survenue lors de l\'enregistrement.'], Response::HTTP_BAD_REQUEST);
        }
    }

    public function updateTask($request, $id)
    {
        try {
            DB::beginTransaction();
            $data = $request->all();
            $task = Task::findOrFail($id);
            $task->update($data);
            DB::commit();
            return response()->json(['data' => $task, 'message' => 'Tâche modifier avec suucès'], Response::HTTP_OK);
        } catch (\Exception $th) {
            DB::rollBack();
            Log::info(['error' =>  $th->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Une erreur est survenue lors de la mise à jour. Veuillez réessayer'
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function deleteTaskById($id)
    {
        try {
            DB::beginTransaction();
            $data = Task::findOrFail($id)->delete();
            DB::commit();
            return response()->json(['message' => 'Tâche supprimer avec suucès'], Response::HTTP_OK);
        } catch (\Exception $th) {
            DB::rollBack();
            Log::info(['error' =>  $th->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Une erreur est survenue lors de la suppression. Veuillez réessayer'
            ], Response::HTTP_BAD_REQUEST);
        }
    }
}

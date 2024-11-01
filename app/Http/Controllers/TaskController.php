<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Http\Traits\TaskTrait;
use Illuminate\Http\Request;

class TaskController extends Controller
{

    use TaskTrait;

    public function index()
    {
        return $this->getAllTasks();
    }

    public function store(StoreTaskRequest $request)
    {
        return $this->createTask($request);
    }

    public function update(UpdateTaskRequest $request, $id)
    {
        return $this->updateTask($request, $id);
    }

    public function destroy($id)
    {
        return $this->deleteTaskById($id);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Repositories\Task\TaskRepositoryInterface;

class TaskController extends Controller
{
    protected $taskRepo;

    public function __construct(TaskRepositoryInterface $taskRepo)
    {
        $this->taskRepo = $taskRepo;
    }

    public function index(Request $request)
    {
        $filters = $request->only([
            'assigned_to',
            'is_completed',
            'start_date',
            'end_date',
            'title',
        ]);
        $tasks = $this->taskRepo->getAll($filters);
        return response()->json($tasks);
    }

    public function store(StoreTaskRequest $request)
    {
        try {
            DB::beginTransaction();
            $data = $request->validated();
            $task = $this->taskRepo->create($data);
            DB::commit();
            return response()->json([
                'message' => 'Task created successfully.',
                'task' => $task
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 500);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function show($id)
    {
        return response()->json($this->taskRepo->find($id));
    }

    public function update(UpdateTaskRequest $request, $id)
    {
        try {
            DB::beginTransaction();
            // $id = $request->get('id');
            $task = $this->taskRepo->update($id, $request->validated());
            DB::commit();
            return response()->json([
                'message' => 'Task updated successfully.',
                'task' => $task
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        try {
            DB::beginTransaction();
            $this->taskRepo->delete($id);
            DB::commit();
            return response()->json(['message' => 'Task deleted successfully.']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    public function updateStatus(Request $request, Task $task)
    {
        try {
            DB::beginTransaction();
            $request->validate([
                'is_completed' => 'required|boolean',
            ]);

            $task->is_completed = $request->input('is_completed');
            $task->save();
            DB::commit();
            return response()->json(['message' => 'Status updated successfully']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}

<?php

namespace App\Repositories\Task;

use App\Models\Task;
use App\Http\Resources\TaskResource;
use Illuminate\Support\Facades\Auth;

class TaskRepository implements TaskRepositoryInterface
{
    public function getAll($filters = [])
    {
        $tasks = Task::with(['assignedUser', 'creator'])
            ->when(!empty($filters['assigned_to']), fn($q) => $q->where('assigned_to', $filters['assigned_to']))
            ->when(isset($filters['is_completed']), fn($q) => $q->where('is_completed', $filters['is_completed']))
            ->when(!empty($filters['title']), fn($q) => $q->where('title', 'like', '%' . $filters['title'] . '%'))
            ->when(!empty($filters['start_date']), function ($q) use ($filters) {
                $q->whereDate('start_date', '>=', $filters['start_date']);
            })
            ->when(!empty($filters['end_date']), function ($q) use ($filters) {
                $q->whereDate('end_date', '<=', $filters['end_date']);
            })
            ->orderByDesc('created_at');

        $tasks = $tasks->get();
        return TaskResource::collection($tasks);
    }

    public function create(array $data)
    {
        $data['created_by'] = Auth::user()->id;
        return Task::create($data);
    }

    public function find($id)
    {
        return Task::findOrFail($id);
    }

    public function update($id, array $data)
    {
        $task = $this->find($id);
        $task->update($data);
        return $task;
    }

    public function delete($id)
    {
        $task = $this->find($id);
        return $task->delete();
    }
}

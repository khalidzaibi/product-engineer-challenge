<?php

namespace App\Repositories\Task;

interface TaskRepositoryInterface
{
    public function getAll($filters);
    public function create(array $data);
    public function find($id);
    public function update($id, array $data);
    public function delete($id);
}

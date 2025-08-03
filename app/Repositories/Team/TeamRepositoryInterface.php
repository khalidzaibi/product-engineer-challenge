<?php

namespace App\Repositories\Team;

interface TeamRepositoryInterface
{
    public function all(array $filters = []);
    public function create(array $data);
    public function update($id, array $data);
    public function delete($id);
    public function find($id);
    public function assignUsers($teamId, array $userIds);
}

<?php

namespace App\Repositories\User;

use App\Models\User;

interface UserRepositoryInterface
{
    public function all();
    public function find(int $id);
    public function create(array $data);
    public function update(User $user, array $data);
    public function delete(User $user);
}

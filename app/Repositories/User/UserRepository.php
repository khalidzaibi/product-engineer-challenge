<?php

namespace App\Repositories\User;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserRepository implements UserRepositoryInterface
{
    public function all()
    {
        return User::all();
    }

    public function find(int $id)
    {
        return User::findOrFail($id);
    }

    public function create(array $data)
    {
        $data['password'] = Hash::make('password');
        return User::create($data);
    }

    public function update(User $user, array $data)
    {
        // if (isset($data['password'])) {
        //     $data['password'] = Hash::make($data['password']);
        // } else {
        //     unset($data['password']);
        // }

        $user->update($data);
        return $user;
    }

    public function delete(User $user)
    {
        return $user->delete();
    }
}

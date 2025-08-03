<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Repositories\User\UserRepositoryInterface;

class UserController extends Controller
{
    protected $userRepo;

    public function __construct(UserRepositoryInterface $userRepo)
    {
        $this->userRepo = $userRepo;
    }

    public function index()
    {
        return response()->json($this->userRepo->all());
    }

    public function show($id)
    {
        return response()->json($this->userRepo->find($id));
    }

    public function store(StoreUserRequest $request)
    {
        return response()->json($this->userRepo->create($request->validated()));
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        return response()->json($this->userRepo->update($user, $request->validated()));
    }

    public function destroy(User $user)
    {
        return response()->json(['deleted' => $this->userRepo->delete($user)]);
    }
}

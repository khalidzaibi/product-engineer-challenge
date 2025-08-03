<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTeamRequest;
use App\Http\Requests\UpdateTeamRequest;
use Illuminate\Http\Request;
use App\Repositories\Team\TeamRepositoryInterface;
use Illuminate\Support\Facades\DB;

class TeamController extends Controller
{
    protected $teamRepo;

    public function __construct(TeamRepositoryInterface $teamRepo)
    {
        $this->teamRepo = $teamRepo;
    }

    public function index(Request $request)
    {
        $filters = $request->only([
            'name',
        ]);
        $teams = $this->teamRepo->all($filters);
        return response()->json($teams);
    }

    public function store(StoreTeamRequest $request)
    {
        try {
            DB::beginTransaction();
            $data = $request->validated();
            $team = $this->teamRepo->create($data);
            DB::commit();
            return response()->json([
                'message' => 'Team created successfully.',
                'team' => $team
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function show($id)
    {
        return response()->json($this->teamRepo->find($id));
    }

    public function update(UpdateTeamRequest $request, $id)
    {
        try {
            DB::beginTransaction();
            $data = $request->validated();
            $team = $this->teamRepo->update($id, $data);
            DB::commit();
            return response()->json([
                'message' => 'Team updated successfully.',
                'team' => $team
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
            $this->teamRepo->delete($id);
            DB::commit();
            return response()->json(['message' => 'Team deleted successfully.']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function assignUsers(Request $request, $teamId)
    {
        $data = $request->validate(['user_ids' => 'required|array']);
        return response()->json($this->teamRepo->assignUsers($teamId, $data['user_ids']));
    }
}

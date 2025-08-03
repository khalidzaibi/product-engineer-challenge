<?php

namespace App\Repositories\Team;

use App\Models\Team;
use App\Http\Resources\TeamResource;
use Illuminate\Support\Facades\Auth;

class TeamRepository implements TeamRepositoryInterface
{
    public function all(array $filters = [])
    {
        $teams = Team::with('users')
            ->when(!empty($filters['name']), fn($q) => $q->where('name', 'like', '%' . $filters['name'] . '%'))
            ->get();
        return TeamResource::collection($teams);
    }

    public function create(array $data)
    {
        $team = Team::create([
            'name' => $data['name'],
            'created_by' =>  Auth::user()->id
        ]);
        $userIds = isset($data['user_ids']) ? $data['user_ids'] : [];
        if (!empty($userIds)) {
            $this->assignUsers($team->id, $userIds);
        }
        return $team->load('users');
    }

    public function update($id, array $data)
    {
        $team = Team::findOrFail($id);
        $team->update([
            'name' => $data['name']
        ]);
        if (isset($data['user_ids'])) {
            $this->assignUsers($id, $data['user_ids']);
        }
        return $team;
    }

    public function delete($id)
    {
        $team = Team::findOrFail($id);
        $team->users()->detach();
        $team->delete();
        return true;
    }

    public function find($id)
    {
        return Team::with('users')->findOrFail($id);
    }

    public function assignUsers($teamId, array $userIds)
    {
        $team = Team::findOrFail($teamId);
        $team->users()->sync($userIds);
        return $team->load('users');
    }
}

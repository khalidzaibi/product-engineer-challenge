<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Task;
use App\Models\Team;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{

    public function __construct() {}

    public function index()
    {
        $tasks = $this->tasks();

        $data['totalUsers'] = $this->userCount();
        $data['totalTasks'] = $tasks->total;
        $data['completedTasks'] = $tasks->completed;
        $data['pendingTasks'] = $tasks->pending;
        $data['totalTeams'] = $this->teamsC();
        return response()->json($data);
    }

    private function userCount()
    {
        return User::count();
    }
    private function tasks()
    {
        return Task::selectRaw("
            COUNT(*) as total,
            SUM(CASE WHEN is_completed = 1 THEN 1 ELSE 0 END) as completed,
            SUM(CASE WHEN is_completed = 0 THEN 1 ELSE 0 END) as pending
        ")->first();
    }

    private function teamsC()
    {
        return Team::count();
    }

    public function dashboardRangeData(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $start = Carbon::parse($startDate)->toDateString();
        $end   = Carbon::parse($endDate)->toDateString();
        $rangeData = $this->getRangeData($start, $end);
        return response()->json($rangeData);
    }

    private function getRangeData($start, $end)
    {
        $tasks = Task::whereDate('start_date', '>=', $start)
            ->whereDate('end_date', '<=', $end)
            ->selectRaw("
                    COUNT(*) as total,
                    SUM(CASE WHEN is_completed = 1 THEN 1 ELSE 0 END) as completed,
                    SUM(CASE WHEN is_completed = 0 THEN 1 ELSE 0 END) as pending
                ")->first();
        return [
            'totalTasks' =>  (int) $tasks->total,
            'completedTasks' => (int) $tasks->completed,
            'pendingTasks' =>  (int) $tasks->pending,
            'startDate' => $start,
            'endDate' => $end
        ];
    }
}

<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Models\TaskUserTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    public function getAllTime(Request $request): array
    {
        $taskId = (int)$request->get('id', 0);

        $userTime = TaskUserTime::query()
            ->where('user_id', Auth::id())
            ->where('task_id', $taskId)
            ->first();

        return [
            'timer' => $userTime->timer ?? 0
        ];
    }

    public function updateTimer(Request $request): array
    {
        $taskId = (int)$request->post('id', 0);

        $taskUserTime = TaskUserTime::query()->firstOrCreate([
            'user_id' => Auth::id(),
            'task_id' => $taskId
        ]);

        $newTimerValue = $taskUserTime->timer++;

        $taskUserTime->save(['timer' => $newTimerValue]);

        return [
            'timer' => $newTimerValue
        ];
    }


}

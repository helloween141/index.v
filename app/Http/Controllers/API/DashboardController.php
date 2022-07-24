<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\TaskResource;
use App\Models\Task;
use App\Models\TaskUserTime;
use App\Modules\Vpanel\models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class DashboardController extends Controller
{
    const NORM_DAY_HOURS = 6;

    // TODO: refactoring
    public function getPerformance(Request $request): array
    {
        $yearFilter = (int)$request->get('filter_year', 0);
        $monthFilter = (int)$request->get('filter_month', 0);

        if (!$yearFilter || !$monthFilter) {
            return [];
        }

        $currentDate = Carbon::create($yearFilter, $monthFilter);
        $currentYear = $currentDate->year;
        $currentDayStart = $currentDate->startOfMonth()->toDateString();
        $currentDayEnd = $currentDate->endOfMonth()->toDateString();

        $lastDate = Carbon::create($yearFilter, $monthFilter)->subMonthsNoOverflow();
        $lastYear = $lastDate->year;
        $lastDayStart = $lastDate->startOfMonth()->toDateString();
        $lastDayEnd = $lastDate->endOfMonth()->toDateString();

        $beforeLastDate = Carbon::create($yearFilter, $monthFilter)->subMonthsNoOverflow(2);
        $beforeLastYear = $lastDate->year;
        $beforeLastDayStart = $lastDate->startOfMonth()->toDateString();
        $beforeLastDayEnd = $lastDate->endOfMonth()->toDateString();

        $executorsTime = User::getExecutors()
            ->map(function ($user) use (
                $lastDayStart, $beforeLastDayStart,
                $currentDayStart, $beforeLastDayEnd, $beforeLastYear,
                $lastDayEnd, $currentDayEnd, $lastYear, $currentYear
            ) {
                $currentMonthTime = TaskUserTime::getSumMonthTime($user->id, $currentYear, [$currentDayStart, $currentDayEnd]);
                $lastMonthTime = TaskUserTime::getSumMonthTime($user->id, $lastYear, [$lastDayStart, $lastDayEnd]);
                $beforeLastMonthTime = TaskUserTime::getSumMonthTime($user->id, $beforeLastYear, [$beforeLastDayStart, $beforeLastDayEnd]);

                return [
                    'id' => $user->id,
                    'name' => $user->name,
                    'current_time' => $currentMonthTime,
                    'last_time' => $lastMonthTime,
                    'before_last_time' => $beforeLastMonthTime
                ];
            })
            ->toArray();

        $monthNorm = $this->getNorm(Carbon::create($yearFilter, $monthFilter), Carbon::create($yearFilter, $monthFilter)->daysInMonth);
        $todayNorm = $this->getNorm(Carbon::create($yearFilter, $monthFilter), Carbon::now()->day);

        return [
            'month_norm' => $monthNorm,
            'today_norm' => $todayNorm,
            'months' => [
                $lastDate->month,
                $beforeLastDate->month
            ],
            'executors' => $executorsTime
        ];
    }

    public function getActiveTasks(Request $request): AnonymousResourceCollection
    {
        $userId = (int)$request->input('user_id');
        $tasks = Task::getActiveForUser($userId);

        return TaskResource::collection($tasks);
    }

    private function getNorm($now, $endDay): float|int
    {
        $result = 0;

        for ($i = 1; $i <= $endDay; $i++) {
            $date = Carbon::create($now->year, $now->month, $i);
            if (!$date->isWeekend()) {
                $result += self::NORM_DAY_HOURS;
            }
        }
        return $result;
    }

}

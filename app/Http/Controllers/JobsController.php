<?php

namespace App\Http\Controllers;

use App\Models\Developer;
use App\Models\Job;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class JobsController extends Controller
{

    /*
    * Atama kısıtı olduğu varsayılmıştır
    */
    public function index()
    {
        $jobs = Developer::with('Jobs')
            ->select(
                'id',
                'name',
                'difficult',
                DB::raw('(SELECT SUM(estimated_duration) FROM jobs WHERE jobs.difficult = developers.difficult) as totalHours')
            )
            ->get();

        $devs = Developer::all();

        return view('jobs.index', [
            'jobs' => $jobs,
            'developers' => $devs
        ]);
    }

    /*
     * Atama kısıtına göre gerekebilir
     *
    public function calculateWorkForceHourly()
    {
        $ascendingIndex = 0;
        $descendingIndex = 0;

        $jobs = DB::table('jobs')
            ->select('code',
                'difficult',
                'estimated_duration',
                'estimated_duration as reaming_duration',
                DB::raw('0 as takedBy'),
                DB::raw('0 as isFinished'),
                DB::raw('0 as isTaked'),
                DB::raw('(estimated_duration * difficult) as calcWeight'))
            ->get()
            ->sortBy('calcWeight')
            ->values()
            ->toArray();

        $descendingIndex = count($jobs) - 1;

        $devHour = [
            [],
            [],
            [],
            [],
            []
        ];

        $finishedJobs = count($jobs);

        for ($hour = 0; 0 < $finishedJobs; $hour++) {
            for ($dev = 0; $dev < 5; $dev++) {
                if ($dev < 3) {
                    for ($i = 0; $i < count($jobs); $i++) {
                        if (!$jobs[$i]->isFinished && (!$jobs[$i]->isTaked || ($jobs[$i]->takedBy == $dev && $jobs[$i]->reaming_duration > 0))) {
                            $jobs[$i]->isTaked = 1;
                            $jobs[$i]->takedBy = $dev;
                            $jobs[$i]->reaming_duration--;

                            if (!$jobs[$i]->reaming_duration) {
                                $jobs[$i]->isFinished = 1;
                                $finishedJobs--;
                            }

                            $devHour[$dev][] = $jobs[$i]->code;
                            break;
                        }
                    }
                } else {
                    for ($i = count($jobs) - 1; 0 <= $i; $i--) {
                        if (!$jobs[$i]->isFinished && (!$jobs[$i]->isTaked || ($jobs[$i]->takedBy == $dev && $jobs[$i]->reaming_duration > 0))) {
                            $jobs[$i]->isTaked = 1;
                            $jobs[$i]->takedBy = $dev;
                            $jobs[$i]->reaming_duration--;

                            if (!$jobs[$i]->reaming_duration) {
                                $jobs[$i]->isFinished = 1;
                                $finishedJobs--;
                            }

                            $devHour[$dev][] = $jobs[$i]->code;
                            break;
                        }
                    }
                }
            }
        }

        dd($jobs, $devHour);
    }
    */
}

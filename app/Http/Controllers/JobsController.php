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
}

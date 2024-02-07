<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MyScheduleController extends Controller
{
    public function __invoke()
    {
        return view('active-ride', [
            'schedules' => Schedule::query()
                ->when(Auth::user()->hasRole('driver'),
                    function ($query) {
                        $query->where('driver_id', Auth::id());
                    }
                )
                ->when(Auth::user()->hasRole('conductor'),
                    function ($query) {
                        $query->where('conductor_id', Auth::id());
                    }
                )
                ->get()
        ]);
    }
}

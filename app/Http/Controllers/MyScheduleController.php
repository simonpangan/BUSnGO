<?php

namespace App\Http\Controllers;

use App\Models\Conductor;
use App\Models\Driver;
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
                        $driver = Driver::where('user_id', Auth::id())->first();
                        $query->where('driver_id', $driver->id);
                    }
                )
                ->when(Auth::user()->hasRole('conductor'),
                    function ($query) {
                        $conductor = Conductor::where('user_id', Auth::id())->first();
                        $query->where('conductor_id', $conductor->id);
                    }
                )
                ->get()
        ]);
    }
}

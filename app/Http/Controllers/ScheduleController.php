<?php

namespace App\Http\Controllers;

use App\Models\Bus;
use App\Models\Schedule;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Luigel\Paymongo\Facades\Paymongo;

class ScheduleController extends Controller
{
    public function index()
    {
        return view('schedules.index', [
            'schedules' => Schedule::query()
                ->latest()
                ->get()
        ]);
    }

    public function show(Schedule $schedule)
    {
        return view('schedules.show', [
            'schedule' => $schedule
        ]);
    }
}

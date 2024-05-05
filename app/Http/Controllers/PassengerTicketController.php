<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Schedule;
use App\Models\Ticket;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class PassengerTicketController
{
    public function index()
    {
        $schedules = Schedule::query()
             ->get();

        $now = Carbon::now();
        foreach ($schedules as $schedule) {
            if ($now->gte($schedule->arrival_time)) {
                $schedule->status = 'Arrived';
                $schedule->save();
            }
        }


        return view('passenger.tickets', [
            'payments' => Payment::query()
                ->with(['tickets', 'schedule.bus', 'schedule.terminal'])
                ->where('passenger_id', Auth::id())
                ->latest('paid_at')
                ->get()
        ]);
    }
}

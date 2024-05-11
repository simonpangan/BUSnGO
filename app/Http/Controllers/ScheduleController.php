<?php

namespace App\Http\Controllers;

use App\Models\Bus;
use App\Models\Schedule;
use App\Models\Ticket;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Luigel\Paymongo\Facades\Paymongo;

class ScheduleController extends Controller
{
    public function index()
    {
        $authUserRole = Auth::user()?->hasRole('admin');
        $schedules = null;

        if ($authUserRole) {
            $schedules = Schedule::query()
                ->when(Auth::user()->hasRole('bus admin'), function ($query, $search) {
                    return $query->where('company_id', Auth::user()->companyAdmin->company_id);
                })
                ->latest()
                ->get();
        } else {
            $schedules = Schedule::query()
                ->whereHas('tickets', function (Builder $query) {
                    $query->where('status', '=', "available");
                }, '>=', 1)
                ->where('departure_time', ">=", Carbon::now())
                ->get();
        }

        $now = Carbon::now();
        foreach ($schedules as $schedule) {
            if ($now->gte($schedule->arrival_time)) {
                $schedule->status = 'Arrived';
                $schedule->save();
            }
        }

        return view('schedules.index', [
            'schedules' => $schedules
        ]);
    }

    public function generatePDF()
    {
        $authUserRole = Auth::user()?->hasRole('admin');
        $schedules = null;

        if ($authUserRole) {
            $schedules = Schedule::query()
                ->with('terminal')
                 ->latest()
                 ->get();
        } else {
            $schedules = Schedule::query()
                ->with('terminal')
                 ->where('departure_time', ">=", Carbon::now())
                ->get();
        }

        $pdf = Pdf::loadView('pdf.schedules', [
            'schedules' => $schedules
                ->map(function ($schedule) {
                    return [
                        'terminal_from' => $schedule->terminal->from,
                        'terminal_to' => $schedule->terminal->to,
                        'departure_time' => $schedule->departure_time->format('l, F j, Y g:i A'),
                        'arrival_time' => $schedule->arrival_time->format('l, F j, Y g:i A'),
                        'status' => $schedule->status,
                    ];
                })
                ->toArray()
        ]);

        return $pdf->download('schedules.pdf');
    }

    public function show(Schedule $schedule)
    {
        $now = Carbon::now();
        if ($now->gte($schedule->arrival_time)) {
            $schedule->status = 'Arrived';
            $schedule->save();
        }

        return view('schedules.show', [
            'schedule'        => $schedule,
            'scheduleTickets' =>
                $schedule->tickets
                    ->chunk(4)
                    ->map
                    ->values()
            ,
            'authUserTickets' => $schedule->tickets
                ->where('passenger_id', Auth::id())
                ->pluck('seat_no')
                ->toArray()
        ]);
    }
}

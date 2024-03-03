<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Bus;
use App\Models\Conductor;
use App\Models\Driver;
use App\Models\Schedule;
use App\Models\Terminal;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

class AdminScheduleController extends Controller
{
    public function create()
    {
        return view('schedules.create', [
            'buses' => Bus::all(),
            'terminals' => Terminal::all(),
            'drivers'    => Driver::all(),
            'conductors' => Conductor::all(),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'bus_id' => ['required', 'integer', 'exists:buses,id'],
            'departure_time' => ['required', 'date',
//                'after:tomorrow'
            ],
            'arrival_time' => ['required', 'date', 'after:departure_time'],
            'status' => ['required', 'string'],
            'terminal_id' => ['required', 'integer', 'exists:terminals,id'],
            'driver_id'          => ['required', 'integer', 'exists:drivers,id'],
            'conductor_id'       => ['required', 'integer', 'exists:conductors,id'],
        ]);

        $schedule = Schedule::create([
            'bus_id' => $request->bus_id,
            'departure_time' => $request->departure_time,
            'arrival_time' => $request->arrival_time,
            'status' => $request->status,
            'terminal_id' => $request->terminal_id,
            'driver_id' => $request->driver_id,
            'conductor_id' => $request->conductor_id,
        ]);

        $bus = Bus::find($request->bus_id);
        $tickets = Collection::times(
            $bus->seat,
            fn(int $number) => [
                'seat_no' => $number,
                'status' => 'available'
            ]
        );

        $schedule->tickets()->createMany($tickets);

        if (Carbon::parse($request->departure_time)->lt(Carbon::now())) {
            return redirect()->route('admin.schedules.edit', $schedule)
             ->with(
                 'warning',
                 'Schedule created successfully. We suggest to pick a date that is close to current time. '
             );
        }

        return to_route('schedules.index')
            ->with('success', 'Schedule created successfully');
    }

    public function edit(Schedule $schedule)
    {
        return view('schedules.edit', [
            'buses' => Bus::all(),
            'terminals' => Terminal::all(),
            'schedule' => $schedule,
             'drivers'    => Driver::all(),
            'conductors' => Conductor::all(),
        ]);
    }

    public function update(Request $request, Schedule $schedule)
    {
        $request->validate([
            'bus_id' => ['required', 'integer', 'exists:buses,id'],
            'departure_time' => ['required', 'date',
//                'after:tomorrow'
            ],
            'arrival_time' => ['required', 'date', 'after:departure_time'],
            'status' => ['required', 'string'],
            'terminal_id' => ['required', 'integer', 'exists:terminals,id'],
            'driver_id'          => ['required', 'integer', 'exists:drivers,id'],
            'conductor_id'       => ['required', 'integer', 'exists:conductors,id'],
        ]);

        $schedule->update([
            'bus_id' => $request->bus_id,
            'departure_time' => $request->departure_time,
            'arrival_time' => $request->arrival_time,
            'status' => $request->status,
            'terminal_id' => $request->terminal_id,
            'driver_id' => $request->driver_id,
            'conductor_id' => $request->conductor_id,
        ]);

        if (Carbon::parse($request->departure_time)->lt(Carbon::now())) {
            return redirect()->route('admin.schedules.edit', $schedule)
             ->with(
                 'warning',\
                 'Schedule created successfully. We suggest to pick a date that is close to current time.'
             );
        }

        return redirect()->route('admin.schedules.edit', $schedule)
             ->with('success', 'Schedule updated successfully');
    }

    public function destroy(Schedule $schedule)
    {
        $schedule->delete();

        return redirect()->route('schedules.index')
             ->with('success', 'Schedule deleted successfully');
    }
}

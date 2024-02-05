<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Bus;
use App\Models\Schedule;
use App\Models\Terminal;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class AdminScheduleController extends Controller
{
    public function create()
    {
        return view('schedules.create', [
            'buses' => Bus::all(),
            'terminals' => Terminal::all(),
        ]);
    }

    public function store(Request $request)
    {
        $schedule = Schedule::create([
            'bus_id' => $request->bus_id,
            'departure_time' => $request->departure_time,
            'arrival_time' => $request->arrival_time,
            'status' => $request->status,
            'terminal_id' => $request->terminal_id
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

        return to_route('schedules.index')
            ->with('success', 'Schedule created successfully');
    }

    public function edit(Schedule $schedule)
    {
        return view('schedules.edit', [
            'buses' => Bus::all(),
            'terminals' => Terminal::all(),
            'schedule' => $schedule
        ]);
    }

    public function update(Request $request, Schedule $schedule)
    {
        $schedule->update([
            'bus_id' => $request->bus_id,
            'departure_time' => $request->departure_time,
            'arrival_time' => $request->arrival_time,
            'status' => $request->status,
            'terminal_id' => $request->terminal_id
        ]);

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
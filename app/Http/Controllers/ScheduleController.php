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
    public function __construct()
    {
        $this->middleware('role:admin')->only([
            'create', 'edit', 'update', 'destroy'
        ]);
    }

    public function index()
    {
        return view('schedules.index', [
            'schedules' => Schedule::query()
                ->latest()
                ->get()
        ]);
    }

    public function create()
    {
        return view('schedules.create', [
            'buses' => Bus::all(),
        ]);
    }

    public function store(Request $request)
    {
        $schedule = Schedule::create([
            'bus_id' => $request->bus_id,
            'departure_time' => $request->departure_time,
            'arrival_time' => $request->arrival_time,
            'status' => $request->status,
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

    public function show(Schedule $schedule)
    {
        return view('schedules.show', [
            'schedule' => $schedule
        ]);
    }

    public function edit(Schedule $schedule)
    {
        return view('schedules.edit', [
            'buses' => Bus::all(),
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
        ]);

        return redirect()->route('schedules.edit', $schedule)
            ->with('success', 'Schedule updated successfully');
    }

    public function destroy(Schedule $schedule)
    {
        $schedule->delete();

        return redirect()->route('schedules.index')
            ->with('success', 'Schedule deleted successfully');
    }
}

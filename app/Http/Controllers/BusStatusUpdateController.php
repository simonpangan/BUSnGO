<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use Illuminate\Http\Request;

class BusStatusUpdateController extends Controller
{
    public function __invoke(Request $request)
    {
        $schedule = Schedule::findOrFail($request->schedule_id);
        $schedule->update([
            'status' => $request->status
        ]);

        return back()
            ->with('success', 'Bus status updated successfully');
    }
}

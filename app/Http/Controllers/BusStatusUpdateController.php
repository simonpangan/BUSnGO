<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Schedule;
use Illuminate\Http\Request;

class BusStatusUpdateController extends Controller
{
    public function __invoke(Request $request)
    {
        $schedule = Schedule::findOrFail($request->schedule_id);

        if ($request->status === 'Onboarding') {
            $payments = Payment::where('schedule_id', $request->schedule_id)->get();
            if (count($payments) > 0) {
                dd($payments);
                dd($payments[0]->passenger);
            }
        }

        $schedule->update([
            'status' => $request->status
        ]);

        return back()
            ->with('success', 'Bus status updated successfully');
    }
}

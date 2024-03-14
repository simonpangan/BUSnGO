<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Schedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class BusStatusUpdateController extends Controller
{
    public function __invoke(Request $request)
    {
        $schedule = Schedule::findOrFail($request->schedule_id);

        if ($request->status === 'Onboarding') {
            $payments = Payment::where('schedule_id', $request->schedule_id)->get();
            //There is no payments sending m360 is a waste
            if (count($payments) > 0) {
                foreach ($payments as $payment) {
                    Http::post('https://api.m360.com.ph/v3/api/broadcast', [
                        "username" => "Project_case",
                        "password" => "SScDpn6J",
                        "msisdn" => $payment->contact_no,
                        "content" => "Hello,this is a samplebroadcast.",
                        "shortcode_mask" => "BUSnGO",
                        "is_intl" => false
                    ]);
                }
                dd('asd');
            }
        }

        $schedule->update([
            'status' => $request->status
        ]);

        return back()
            ->with('success', 'Bus status updated successfully');
    }
}

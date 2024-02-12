<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Luigel\Paymongo\Facades\Paymongo;

class PassengerTicketPaymentController
{
    public function book(Request $request)
    {
        $schedule = Schedule::findOrFail($request->schedule_id);

        $payment = Paymongo::source()->create([
            'type'     => ($request->wallet == 'G-CASH') ? 'gcash' : 'grab_pay',
            'amount'   => $schedule->ticket_cost * count($request->tickets),
            'currency' => 'PHP',
            'redirect' => [
                'success' => route('payment.callback'),
                'failed'  => route('payment.failed'),
            ]
        ]);

        Session::put([
            'tickets'    => $request->tickets,
            'scheduleID' => $request->schedule_id
        ]);

        return redirect()->to($payment->redirect['checkout_url']);
    }

    public function callback()
    {
        $tickets    = Session::pull('tickets');
        $scheduleID = Session::pull('scheduleID');

        Ticket::query()
              ->whereIn('id', array_values($tickets))
              ->update([
                  'status'       => 'booked',
                  'passenger_id' => Auth::id()
              ]);

        return to_route('schedules.show', [
            'schedule' => $scheduleID
        ])->with('success', 'Successfully booked your ticket');
    }

    public function failed(Request $request)
    {
        Session::forget('tickets');

        return to_route('schedules.show', [
            'schedule' => Session::pull('scheduleID')
        ])->with('error', 'Transaction Error');
    }
}

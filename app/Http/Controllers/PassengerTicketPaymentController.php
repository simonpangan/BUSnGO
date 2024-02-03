<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\MessageBag;
use Luigel\Paymongo\Facades\Paymongo;

class PassengerTicketPaymentController
{
    public function index()
    {
        return view('payment.index');
    }

    public function book(Request $request)
    {
        dd($request->tickets);
        $payment = Paymongo::source()->create([
            'type'     => ($request->wallet == 'G-CASH') ? 'gcash' : 'grab_pay',
//            'amount'   => $request->price, // schedule price
            'amount'   => 123,
            'currency' => 'PHP',
            'redirect' => [
                'success' => route('payment.callback'),
                'failed'  => route('payment.failed'),
            ]
        ]);

        Session::put([
            'ticketID' => $request->ticket_id,
            'scheduleID' => $request->schedule_id
        ]);

        return redirect()->to($payment->redirect['checkout_url']);
    }

    public function callback()
    {
        $ticketID =  Session::pull('ticketID');
        $scheduleID =  Session::pull('scheduleID');

        $ticket = Ticket::findOrFail($ticketID);
        $ticket->update([
            'status' => 'booked',
            'passenger_id' => Auth::id()
        ]);

        return to_route('schedules.show', [
            'schedule' => $scheduleID
        ])->with('success', 'Successfully booked your ticket');
    }

    public function failed(Request $request)
    {
        Session::forget('ticketID');

        return to_route('schedules.show', [
            'schedule' => Session::pull('scheduleID')
        ])->with('error', 'Transaction Error');
    }
}

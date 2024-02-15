<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Schedule;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Luigel\Paymongo\Facades\Paymongo;
use Luigel\Paymongo\Models\Refund;

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

        Session::put('payment_details', [
            'tickets'     => $request->tickets,
            'schedule_id' => $request->schedule_id,
            'amount'      => $payment->amount,
        ]);

        Session::put('payment_id', $payment->id);

        return redirect()->to($payment->redirect['checkout_url']);
    }


    public function callback()
    {
        $paymentDetails = Session::pull('payment_details');
        $paymentID      = Session::pull('payment_id');

        $payment = Paymongo::payment()
           ->create([
               'amount'   => $paymentDetails['amount'],
               'currency' => 'PHP',
               'source'   => [
                   'id'   => $paymentID,
                   'type' => 'source'
               ]
           ]);

        $paidAt = Carbon::now();

        Ticket::query()
              ->whereIn('id', array_values($paymentDetails['tickets']))
              ->update([
                  'status'       => 'booked',
                  'passenger_id' => Auth::id(),
                  'paid_at'      => $paidAt
              ]);

        Payment::create([
            'amount'      => $paymentDetails['amount'],
            'paymongo_id' => $payment->id,
            'passenger_id'     => Auth::id(),
            'schedule_id' => $paymentDetails['schedule_id'],
            'tickets_id'  => $paymentDetails['tickets'],
            'status'      => 'paid',
            'paid_at' => $paidAt
        ]);

        return to_route('schedules.show', [
            'schedule' => $paymentDetails['schedule_id']
        ])->with('success', 'Successfully booked your ticket');
    }

    public function failed()
    {
        Session::forget('tickets');

        return to_route('schedules.show', [
            'schedule' => Session::pull('scheduleID')
        ])->with('error', 'Transaction Error');
    }

    public function refund(Payment $payment)
    {
        //TODO: ADD REFUND TIME LIMIT LOGIC
//        if ($this->somethingIsInvalid()) {
//            throw ValidationException::withMessages([
//                'some_error' => 'Something is invalid.'),
//         ]);

        Paymongo::refund()->create([
            'amount'     => $payment->amount,
            'payment_id' => $payment->paymongo_id,
            'reason'     => Refund::REASON_REQUESTED_BY_CUSTOMER,
        ]);

        Ticket::query()
              ->whereIn('id', array_values($payment->tickets_id))
              ->update([
                  'status'       => 'available',
                  'passenger_id' => null,
                  'paid_at'      => null
              ]);

        $payment->update([
            'status' => 'refunded'
        ]);

        return to_route('passenger.tickets')
            ->with('success', 'Successfully refunded your ticket');
    }
}

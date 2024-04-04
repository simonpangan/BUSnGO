<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Schedule;
use App\Models\Ticket;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\ValidationException;
use Luigel\Paymongo\Facades\Paymongo;
use Luigel\Paymongo\Models\Refund;

class PassengerTicketPaymentController
{
    public function receipt(Payment $payment)
    {
        $payment->load('schedule');

        return view('payment.receipt', compact('payment'));
    }

    public function receiptGenerate(Payment $payment)
    {
        $pdf = Pdf::loadView('pdf.receipt', [
            'payment' => [
                'reference_number' => $payment->id,
                'schedule_id' => $payment->schedule->id,
                'passenger_name' => $payment->passenger->name,
                'tickets_seat_no' => $payment->tickets->pluck('seat_no')->toArray(),
                'amount' => $payment->amount,
                'status' => $payment->status,
                'paid_at' => $payment->paid_at->format('l, F j, Y g:i A'),
                'departure_time' => $payment->schedule->departure_time->format('l, F j, Y g:i A'),
                'arrival_time' => $payment->schedule->arrival_time->format('l, F j, Y g:i A'),
            ]
        ]);

        return $pdf->download('payment.pdf');
    }
    public function book(Request $request)
    {
        $request->validate([
            'tickets'     => ['required', 'array'],
            'tickets.*'   => ['required', 'integer', 'exists:tickets,id'],
            'schedule_id' => ['required', 'integer', 'exists:schedules,id'],
            'wallet'      => ['required', 'string', 'in:G-CASH,GRAB-PAY'],
            'acknowledge' => ['accepted'],
        ]);

        $schedule = Schedule::findOrFail($request->schedule_id);

        $ticketCost = $schedule->terminal->ticket_cost * count($request->tickets);
        //https://paymongo.help/en/articles/4318573-what-are-the-minimum-and-maximum-transaction-amounts
        if ($ticketCost > 100000) {
            return back()
                ->withErrors([
                    'tickets' => 'Maximum transaction amount is 100,000.00 PHP. Please try to book less tickets.'
                ])
                ->withInput();
        }

        $payment = Paymongo::source()->create([
            'type'     => ($request->wallet == 'G-CASH') ? 'gcash' : 'grab_pay',
            'amount'   => $ticketCost,
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
            'schedule' => Session::pull('payment_details.schedule_id')
        ])->with('error', 'Transaction Error');
    }

            public function refund(Payment $payment)
    {
        $currentTime = Carbon::now();
        $eightHoursBeforeDepartureTime = $payment
            ->schedule
            ->departure_time
            ->copy()
            ->subHours(8);

        if (! $currentTime->lte($eightHoursBeforeDepartureTime)) {
            throw ValidationException::withMessages([
                'refund_time_limit' => 'Refund is not allowed within 8 hours before departure time.'
            ]);
        }

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
            ->with('success', 'Successfully refunded your ticket. Your refund may take 24 hrs to reflect on your account.');
    }
}

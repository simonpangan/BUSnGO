<?php

namespace App\Http\Controllers\TicketPaymentController;

use App\Http\Controllers\Request;
use Illuminate\Support\Facades\Auth;
use Luigel\Paymongo\Facades\Paymongo;

class PassengerTicketPaymentController
{
    public function index()
    {
        return view('payment.index');
    }
    public function pay(Request $request, string $ticketID)
    {
        $payment = Paymongo::source()->create([
            'type'     => ($request->wallet == 'G-CASH') ? 'gcash' : 'grab_pay',
            'amount'   => $request->price, // schedule price
            'currency' => 'PHP',
            'redirect' => [
                'success' => route('payment.callback'),
                'failed'  => route('payment.failed'),
            ]
        ]);

        session([
            'payment_details' => [
                'ticket_id' => $request->$ticketID,
                'wallet'    => $request->wallet,
                'price'     => $request->price,
            ]
        ]);

        session(['payment_id' => $payment->id]);

        return redirect()->to($payment->redirect['checkout_url']);
    }

    public function callback()
    {
        $paymentDetails = session()->pull('payment_details');
        $paymentID =  session()->pull('payment_id');

        $program = CharityProgram::findOrFail($paymentDetails['program_id']);

        $message =  'Paid an amount for ' . $paymentDetails['price'] . ' to ' .
                    $program->name . ' with a tip level of ' . $paymentDetails['tip_level'] . '%.';

        $charitableTip = $paymentDetails['price'] * ($paymentDetails['tip_level'] / 100);

        try {
            $payment = Paymongo::payment()
                               ->create([
                                   'amount' => $paymentDetails['price'],
                                   'currency' => 'PHP',
                                   'description' => $message,
                                   'statement_descriptor' => $message,
                                   'source' => [
                                       'id' => $paymentID,
                                       'type' => 'source'
                                   ]
                               ]);
        } catch (\Throwable $th) {
            abort(403);
        }

        $totalDonation = ($payment->net_amount / 100) - $charitableTip;

        $programDonation = ProgramDonation::create([
            'benefactor_id' => Auth::id(),
            'charity_program_id' => $paymentDetails['program_id'],
            'amount' => $totalDonation,
            // 'donated_at' => Carbon::createFromTimestamp($payment->created_at)->format('Y-m-d\TH:i:s.uP'),
            'donated_at' => now(),
            'transaction_id' => $payment->id,
            'tip_price' => $charitableTip,
            'is_anonymous' => ($paymentDetails['is_anonymous'] == 'true') ? 1 : 0,
        ]);

        session(['program_donation_id' => $programDonation->id]);

        Auth::user()->createLog($message);

        Paymongo::payment()->find($payment->id);

        return to_route('charity.donate.create', [
            'id' => $paymentDetails['program_id'],
        ]);
    }

    public function failed(Request $request)
    {
        session()->forget('payment_id');

        $paymentDetails = session()->pull('payment_details');

        $wallet = ($paymentDetails['wallet'] == 'G-CASH') ? 'G-CASH' : 'GRAB PAY';

        return to_route('charity.donate.create', $paymentDetails['program_id'])->withErrors(
            new MessageBag(['paymongo' => "Invalid {$wallet} Transaction"])
        );
    }

}

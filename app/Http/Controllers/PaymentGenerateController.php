<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Schedule;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentGenerateController extends Controller
{
    public function __invoke()
    {
        $payments = Payment::where('schedule_id', request()->schedule)->get();

        $pdf = Pdf::loadView('pdf.payments', [
            'schedule_id' => request()->schedule,
            'payments' => $payments
                ->map(function ($payment) {
                    return [
                        'reference_number' => $payment->id,
                        'tickets_seat_no' => $payment->tickets->pluck('seat_no')->toArray(),
                        'paid_by' => $payment->passenger->name,
                        'amount' => $payment->amount,
                        'paid_at' => $payment->paid_at->format('l, F j, Y g:i A'),
                    ];
                })
                ->toArray()
        ]);

        return $pdf->download('receipts.pdf');
    }
}

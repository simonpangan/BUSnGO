<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Ticket;
use Illuminate\Support\Facades\Auth;

class PassengerTicketController
{
    public function index()
    {
        return view('passenger.tickets', [
            'payments' => Payment::query()
                ->with('tickets')
                 ->where('passenger_id', Auth::id())
                 ->latest('paid_at')
                 ->get()
        ]);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Support\Facades\Auth;

class PassengerTicketController extends Controller
{
    public function __invoke()
    {
        return view('passenger.tickets', [
            'tickets' => Ticket::query()
                ->where('passenger_id', Auth::id())
                ->latest('updated_at')
                ->get()
        ]);
    }
}

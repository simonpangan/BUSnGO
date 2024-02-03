<?php

namespace App\Http\Controllers\TicketPaymentController;

use App\Http\Controllers\CharityProgram;
use App\Http\Controllers\Controller;
use App\Http\Controllers\MessageBag;
use App\Http\Controllers\ProgramDonation;
use App\Http\Controllers\Request;
use App\Models\Ticket;
use Illuminate\Support\Facades\Auth;
use Luigel\Paymongo\Facades\Paymongo;

class PassengerTicketController extends Controller
{
    public function index()
    {
        return view('passenger.tickets', [
            'tickets' => Ticket::query()
                ->where('passenger_id', Auth::id())
                ->latest('updated_at')
                ->get()
        ]);
    }
}

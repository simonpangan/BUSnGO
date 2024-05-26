<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Ticket;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class AdminDashboardController extends Controller
{
    public function index()
    {
        //Count the total of bookings this month
        $tickets =
            Ticket::query()
                  ->whereIn('schedule_id', function ($query) {
                      $query->select('id')
                            ->where('company_id', Auth::user()->companyAdmin->company_id)
                            ->from('schedules');
                  })
                  ->whereMonth('paid_at', Carbon::now()->month)
                  ->count();

        $bookingsPerYear =
            Ticket::query()
                  ->whereIn('schedule_id', function ($query) {
                      $query->select('id')
                            ->where('company_id', Auth::user()->companyAdmin->company_id)
                            ->from('schedules');
                  })
                    ->whereMonth('paid_at', Carbon::now()->month)
                    ->whereYear('paid_at', Carbon::now()->year)
                  ->count();

        $bookingsPerMonth = Ticket::whereYear('paid_at', Carbon::now()->year)
            ->selectRaw('MONTH(paid_at) as month, COUNT(*) as total')
            ->whereIn('schedule_id', function ($query) {
              $query->select('id')
                    ->where('company_id', Auth::user()->companyAdmin->company_id)
                    ->from('schedules');
            })
            ->groupByRaw('MONTH(paid_at)')
            ->get();

        $totalEarningsThisYear = Payment::query()
                                        ->selectRaw('SUM(amount) as amount')
              ->whereIn('schedule_id', function ($query) {
                  $query->select('id')
                        ->where('company_id', Auth::user()->companyAdmin->company_id)
                        ->from('schedules');
              })
              ->first();

        $totalEarningsPerMonth = Payment::whereYear('paid_at', Carbon::now()->year)
               ->selectRaw('MONTH(paid_at) as month, SUM(amount) as amount')
               ->whereIn('schedule_id', function ($query) {
                   $query->select('id')
                         ->where('company_id', Auth::user()->companyAdmin->company_id)
                         ->from('schedules');
               })
               ->groupByRaw('MONTH(paid_at)')
               ->get();

        $totalRefundsThisYear = Payment::query()
            ->selectRaw('count(*) as amount')
            ->whereIn('schedule_id', function ($query) {
                $query->select('id')
                      ->where('company_id', Auth::user()->companyAdmin->company_id)
                      ->from('schedules');
            })
            ->whereStatus('refunded')
            ->whereYear('paid_at', Carbon::now()->year)
            ->first();

        $totalRefundsPerMonth = Payment::query()
            ->selectRaw('MONTH(paid_at) as month, count(*) as amount')
            ->whereStatus('refunded')
            ->whereYear('paid_at', Carbon::now()->year)
            ->whereIn('schedule_id', function ($query) {
                $query->select('id')
                      ->where('company_id', Auth::user()->companyAdmin->company_id)
                      ->from('schedules');
            })
            ->groupByRaw('MONTH(paid_at)')
            ->get();


        return view('admin.dashboard', [
            'bookingsThisMonth' => $tickets,
            'bookingsThisYear' => $bookingsPerYear,
            'bookingsPerMonth' => $bookingsPerMonth,
            'totalEarningsThisYear' => $totalEarningsThisYear,
            'totalEarningsPerMonth' => $totalEarningsPerMonth,
            'totalRefundsThisYear' => $totalRefundsThisYear,
            'totalRefundsPerMonth' => $totalRefundsPerMonth
        ]);
    }
}

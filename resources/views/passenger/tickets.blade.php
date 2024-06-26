@php use Carbon\Carbon @endphp
<x-app-layout>
    @section('css')
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.13.8/datatables.min.css"/>
        <link rel="stylesheet" type="text/css"
              href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.dataTables.min.css"/>
    @endsection

    <div class="container mt-4">
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div class="d-flex justify-content-between align-items-center">
            <h2>Tickets List</h2>
        </div>

        <div>
            <table id="myBuses" style="width: 1200px;" class="display table mt-3">
                <thead>
                <tr>
                    <th>Amount</th>
                    <th>Bus No</th>
                    <th>Seat No</th>
                    <th>Terminal</th>
                    <th>Schedule Status</th>
                    <th>Ticket Status</th>
                    <th>Paid At</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @foreach($payments as $payment)
                    <tr>
                        <td>₱{{ $payment->amount }}</td>
                        <td>{{ $payment->schedule->bus->no }}</td>
                        <td>
                            {{ implode(",", $payment->tickets->pluck('seat_no')->toArray()) }}
                        </td>
                        <td>From: {{ $payment->schedule->terminal->from }},
                            To: {{ $payment->schedule->terminal->to }}</td>
                        <td>
                            {{ $payment->schedule->status }}
                            <br/>
                            @if($payment->schedule->deleted_at == null)
                                <a href="{{ route('schedules.show', $payment->schedule->id) }}"
                                   class="btn btn-sm btn-primary">View
                                </a>
                            @endif
                        </td>
                        <td>{{ $payment->status }}</td>
                        <td>
                            {{ $payment->paid_at->diffForHumans() }}
                        </td>
                        <td>
                            @if($payment->status != 'refunded')
                                <a href="{{ route('payment.receipt', $payment->id) }}" class="btn btn-info btn-sm">
                                    Receipt </a>
                                <a href="{{ route('payment.receipt.generate', $payment->id) }}"
                                   class="btn btn-danger btn-sm">
                                    <i class="bi bi-file-pdf"></i>
                                </a>
                            @endif
                            <form method="post" action="{{ route('payment.refund', $payment->id) }}"
                                  style="display:inline">
                                @csrf
                                @if(($payment->status != 'refunded'))
                                <button type="submit" class="btn btn-danger btn-sm"
                                        @php
                                            $currentTime = Carbon::now();
                                            $eightHoursBeforeDepartureTime = $payment
                                                ->schedule
                                                ->departure_time
                                                ->copy()
                                                ->subHours(8);
                                        @endphp
                                        @if(($payment->status == 'refunded') || (! $currentTime->lte($eightHoursBeforeDepartureTime)))
                                            {{ 'disabled' }}
                                        @endif
                                        onclick="return confirm('Are you sure?')">
                                    Refund
                                </button>
                                @endif
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

    @section('javascript')
        <script src="https://cdn.datatables.net/v/dt/dt-1.13.8/datatables.min.js"></script>
        <script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
        <script>
            $(document).ready(function () {
                $('#myBuses').DataTable({
                    responsive: true,
                    'sort': []
                })
            });
        </script>
    @endsection
</x-app-layout>

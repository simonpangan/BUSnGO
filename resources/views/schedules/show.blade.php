<x-app-layout>
    <div class="container mt-4">
        <a href="{{ route('schedules.index')  }}" class="btn btn-primary">Back to list</a>

        <h2 class="text-center"> Schedule</h2>

        <div class="row justify-content-center">
            <div class="col-12 col-md-3">
                <div class="card rounded p-3" style="max-width: 500px;">
                    <div class="mb-3">
                        <strong>Bus</strong>: {{ $schedule->bus->no }}
                    </div>
                    <div class="mb-3">
                        <strong>Terminal</strong>
                        <br/>
                        From: {{ $schedule->terminal->from }}
                        <br/>
                        To : {{ $schedule->terminal->to }}
                    </div>
                    <div class="mb-3">
                        <strong>Departure Time:</strong> {{ $schedule->departure_time->format('l, F j, Y g:i A') }}
                    </div>

                    <div class="mb-3">
                        <strong>Arrival Time</strong>: {{ $schedule->arrival_time->format('l, F j, Y g:i A') }}
                    </div>

                    <div class="mb-3">
                        <strong>Status</strong>: {{ $schedule->status }}
                    </div>

                    <div>
                        <strong>Driver</strong>: <a
                            target="_blank"
                            href="{{ route('drivers.show',
                    $schedule->driver->id
                )}}"> {{ $schedule->driver->name }}</a>
                    </div>
                    <div>
                        <strong>Conductor:</strong> <a
                            target="_blank"
                            href="{{ route('conductors.show',
                    $schedule->conductor->id
                )}}"> {{ $schedule->conductor->name }}</a>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-3">
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif
                <form method="post" action="{{ route('payment.book', [
                    'schedule_id' => $schedule->id,
                ])}}"
                >
                    @csrf
                    <button type="submit" class="btn btn-warning btn-sm mb-2"
                            onclick="return confirm('Are you sure?')"
                    >
                        Book Selected
                    </button>
                    <br/>
                    <div class="fw-bold">Payment Method #:</div>
                    <div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="wallet" id="gCashRadio"
                                   value="G-CASH">
                            <label class="form-check-label" for="gCashRadio">G-Cash</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="wallet" id="grabPay"
                                   value="GRAB-PAY">
                            <label class="form-check-label" for="grabPay">Grab Pay</label>
                        </div>
                    </div>
                    <br/>
                    <div class="fw-bold">Seat #:</div>
                    @foreach($scheduleTickets as $ticket)
                        <div class="row">
                            <div class="col-6 d-flex">
                                @if(isset($ticket[0]))
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input ticket-input" type="checkbox"
                                               name="tickets[]"
                                               value="{{ $ticket[0]->id }}"
                                               id="tsCheckBox"
                                            {{ $ticket[0]->status != "available" ? "disabled" : "" }}
                                        >
                                        <label class="form-check-label" for="tsCheckBox">
                                            #{{ $ticket[0]->seat_no }}
                                        </label>
                                    </div>
                                @endif
                                @if(isset($ticket[1]))
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input ticket-input" type="checkbox"
                                               name="tickets[]"
                                               value="{{ $ticket[1]->id }}"
                                               id="tsCheckBox"
                                            {{ $ticket[1]->status != "available" ? "disabled" : "" }}
                                        >
                                        <label class="form-check-label" for="tsCheckBox">
                                            #{{ $ticket[1]->seat_no }}
                                        </label>
                                    </div>
                                @endif
                            </div>
                            <div class="col-6 d-flex">
                                @if(isset($ticket[2]))
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input ticket-input" type="checkbox"
                                               name="tickets[]"
                                               value="{{ $ticket[2]->id }}"
                                               id="tsCheckBox"
                                            {{ $ticket[2]->status != "available" ? "disabled" : "" }}
                                        >
                                        <label class="form-check-label" for="tsCheckBox">
                                            #{{ $ticket[2]->seat_no }}
                                        </label>
                                    </div>
                                @endif
                                @if(isset($ticket[3]))
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input ticket-input" type="checkbox"
                                               name="tickets[]"
                                               value="{{ $ticket[3]->id }}"
                                               id="tsCheckBox"
                                            {{ $ticket[3]->status != "available" ? "disabled" : "" }}
                                        >
                                        <label class="form-check-label" for="tsCheckBox">
                                            #{{ $ticket[3]->seat_no }}
                                        </label>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </form>
                <br/>
                <div id="totalCost">
                    <span class="fw-bold">Total Cost</span>:
                    ₱<span id="totalCostValue">0</span>
                </div>

                <br/>

                @if(count($authUserTickets) > 0)
                    <div class="fw-bold">Your Tickets:</div>
                    <div>
                        {{ implode(', ', $authUserTickets) }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    @section('javascript')
        <script>
            $(document).ready(function () {
                let totalCost = 0

                $('.ticket-input').change(function () {
                    const ticketCost = {{ $schedule->ticket_cost }}

                    if($(this).prop('checked')) {
                        totalCost += ticketCost;
                    } else {
                        totalCost -= ticketCost;
                    }

                    $('#totalCostValue').text(totalCost.toFixed(2));
                });
            });
        </script>
    @endsection
</x-app-layout>

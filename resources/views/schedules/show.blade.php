<x-app-layout>
    <div class="container mt-4">
        <a href="{{ route('schedules.index')  }}" class="btn btn-primary">Back to list</a>

        <h2 class="text-center"> Schedule</h2>

        <div class="row justify-content-center">
            <div class="col-12 col-md-3">
                <div class="card rounded p-3" style="max-width: 500px;">
                    <div>
                        <strong># Seats Remaining</strong>:
                        {{ $schedule->tickets
                            ->where('status', 'available')
                            ->count()
                        }}
                    </div>
                    <hr />
                    <div class="mb-3">
                        <strong>Schedule ID</strong>: {{ $schedule->id }}
                    </div>
                    <div class="mb-3">
                        <strong>Bus</strong>: {{ $schedule->bus->no }}
                    </div>
                    <div class="mb-3">
                        <strong>Departure Terminal: </strong> {{ $schedule->terminal->from }}
                        <br/>
                        <strong> Arrival Terminal : </strong>{{ $schedule->terminal->to }}
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
                        <strong>Driver</strong>:
                        @if( $schedule->driver->deleted_at != null)
                            {{ $schedule->driver->name }}
                        @else
                        <a
                            target="_blank"
                            href="{{ route('drivers.show',
                                $schedule->driver->id
                            )}}"
                        >
                            {{ $schedule->driver->name }}
                        </a>
                        @endif
                    </div>
                    <div>
                        <strong>Conductor:</strong>
                        @if( $schedule->conductor->deleted_at != null)
                            {{ $schedule->conductor->name }}
                        @else
                            <a
                                target="_blank"
                                href="{{ route('conductors.show',
                        $schedule->conductor->id
                    )}}"> {{ $schedule->conductor->name }}</a>
                        @endif
                    </div>
                </div>
            </div>

            @unlessrole('admin|conductor|driver')
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
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
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
                                   value="G-CASH"
                                   {{ old('wallet') == "G-CASH" ? 'checked' : '' }}
                            >
                            <label class="form-check-label" for="gCashRadio">G-Cash</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="wallet" id="grabPay"
                                   value="GRAB-PAY"
                                    {{ old('wallet') == "GRAB-PAY" ? 'checked' : '' }}
                            >
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
                                            <div class="d-flex">
                                                <img height="25" width="25"
                                                     src="{{ $ticket[0]->status != "available" ? 'https://static.thenounproject.com/png/629421-200.png' : asset('available-seat.png') }}"
                                                />
                                                <span>{{ $ticket[0]->seat_no }}</span>
                                            </div>
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
                                            <div class="d-flex">
                                                <img height="25" width="25"
                                                     src="{{ $ticket[1]->status != "available" ? 'https://static.thenounproject.com/png/629421-200.png' : asset('available-seat.png') }}"
                                                /> {{ $ticket[1]->seat_no }}
                                            </div>
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
                                            <div class="d-flex">
                                                <img height="25" width="25"
                                                     src="{{ $ticket[2]->status != "available" ? 'https://static.thenounproject.com/png/629421-200.png' : asset('available-seat.png') }}"
                                                /> {{ $ticket[2]->seat_no }}
                                            </div>
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
                                            <div class="d-flex">
                                                <img height="25" width="25"
                                                     src="{{ $ticket[3]->status != "available" ? 'https://static.thenounproject.com/png/629421-200.png' : asset('available-seat.png') }}"
                                                /> {{ $ticket[3]->seat_no }}
                                            </div>
                                        </label>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                    <br/>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="acknowledge" value="yes"
                               {{ old('acknowledge') ? "checked" : "" }}
                               id="flexCheckIndeterminate">
                        <label class="form-check-label" for="flexCheckIndeterminate">
                            I agree to the <a href="{{ route('terms-and-condition') }}" target="_blank">terms and conditions </a>
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="verify" value="yes"
                               {{ old('verify') ? "checked" : "" }}
                               id="flexCheckIndeterminate">
                        <label class="form-check-label" for="flexCheckIndeterminate">
                            I verify that my profile name matches the name on my valid government ID.
                        </label>
                    </div>
                </form>

                <br/>

                @if(count($authUserTickets) > 0)
                    <div class="fw-bold">Your Tickets:</div>
                    <div>
                        {{ implode(', ', $authUserTickets) }}
                    </div>
                @endif
            </div>
            <div class="col-12 col-md-3">
                <br/>
                <div id="totalCost">
                    <div class="fw-bold">Cost</div>
                    <div class="d-flex justify-content-between mt-2">
                        <div>Ticket Cost: </div>
                        <div>
                            {{ $schedule->terminal->ticket_cost }}
                        </div>
                    </div>
                    <div class="d-flex justify-content-between mt-2">
                        <div>Quantity: </div>
                        <div id="quantity">0</div>
                    </div>
                    <div class="d-flex justify-content-between mt-2">
                        <div>Sub Total: </div>
                        <div id="subTotalCost">0</div>
                    </div>
                    <hr />
                    <div class="d-flex justify-content-between mt-2">
                        <div>BUSnGO Service Fee (5%): </div>
                        <div id="serviceFee">0</div>
                    </div>
                    <hr />
                    <div class="d-flex justify-content-between mt-2">
                        <div>Total: </div>
                        <div id="totalCal">0</div>
                    </div>
                </div>
                <br/>

                @if(count($authUserTickets) > 0)
                    <div class="fw-bold">Your Tickets:</div>
                    <div>
                        {{ implode(', ', $authUserTickets) }}
                    </div>
                @endif
            </div>
            @endunlessrole


            @role('admin|conductor|driver')
            <div class="col-12 col-md-3">
                <div class="fw-bold">Seat #:</div>
                @foreach($scheduleTickets as $ticket)
                    <div class="row">
                        <div class="col-6 d-flex">
                            @if(isset($ticket[0]))
                                <img height="25" width="25"
                                     src="{{ $ticket[0]->status != "available" ? 'https://static.thenounproject.com/png/629421-200.png' : asset('available-seat.png') }}"
                                />
                                {{ $ticket[0]->seat_no }}
                            @endif
                            @if(isset($ticket[1]))
                                <img height="25" width="25"
                                     src="{{ $ticket[1]->status != "available" ? 'https://static.thenounproject.com/png/629421-200.png' : asset('available-seat.png') }}"
                                />
                                {{ $ticket[1]->seat_no }}
                            @endif
                        </div>
                        <div class="col-6 d-flex">
                            @if(isset($ticket[2]))
                                <img height="25" width="25"
                                     src="{{ $ticket[2]->status != "available" ? 'https://static.thenounproject.com/png/629421-200.png' : asset('available-seat.png') }}"
                                /> {{ $ticket[2]->seat_no }}
                            @endif
                            @if(isset($ticket[3]))
                                <div>
                                    <img height="25" width="25"
                                         src="{{ $ticket[2]->status != "available" ? 'https://static.thenounproject.com/png/629421-200.png' : asset('available-seat.png') }}"
                                    /> {{ $ticket[2]->seat_no }}
                                </div>
                            @endif
                        </div>
                    </div>
                    @endforeach
                    <br/>

                    <div>
                        <span class="fw-bold">Total Earn</span>:
                        ₱<span>
                        {{ ($schedule->tickets->where('status', "!=", 'available')->count()) * $schedule->terminal->ticket_cost }}
                    </span>
                    </div>
            </div>
            @endrole
        </div>
    </div>

    @section('javascript')
        <script>
            $(document).ready(function () {
                let subTotal = 0
                let numberOfTickets = 0
                let serviceFee = 0

                $('.ticket-input').change(function () {
                    const ticketCost = {{ $schedule->terminal->ticket_cost }}

                    if($(this).prop('checked'))
                    {
                        subTotal += ticketCost;
                        numberOfTickets++;
                        serviceFee = subTotal * 0.05;
                        $('#totalCal').text(subTotal + serviceFee);
                    }
                        else
                    {
                        subTotal -= ticketCost;
                        numberOfTickets--;
                        serviceFee = subTotal * 0.05;
                        $('#totalCal').text(subTotal + serviceFee);
                    }

                    $('#subTotalCost').text(subTotal.toFixed(2));
                    $('#quantity').text(numberOfTickets);
                    $('#serviceFee').text(serviceFee.toFixed(2));
                });
            });
        </script>
    @endsection
</x-app-layout>

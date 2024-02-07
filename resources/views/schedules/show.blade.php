<x-app-layout>
    <div class="container mt-4">
        <a href="{{ route('schedules.index')  }}" class="btn btn-primary">Back to list</a>

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
                        <strong>Departure Time:</strong> {{ $schedule->departure_time }}
                    </div>

                    <div class="mb-3">
                        <strong>Arrival Time</strong>: {{ $schedule->arrival_time }}
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
                <form method="post" action="{{ route('payment.book', [
                    'schedule_id' => $schedule->id,
    //                'ticket_id' => $ticket->id
                ])}}"
                >
                    @csrf
                    <button type="submit" class="btn btn-warning btn-sm mb-2"
                            onclick="return confirm('Are you sure?')"
                    >
                        Book Selected
                    </button>

                    <div class="fw-bold">Seat #:</div>
                    @foreach($schedule->tickets->chunk(4) as $ticket)
                       <div class="row">
                           @foreach ($ticket as $t)
                                   <div class="form-check col-3">
                                       <input class="form-check-input" type="checkbox"
                                              name="tickets[]"
                                              value="{{ $t->id }}"
                                              id="tsCheckBox"
                                           {{ $t->status != "available" ? "disabled" : "" }}
                                       >
                                       <label class="form-check-label" for="tsCheckBox">
                                           #{{ $t->seat_no }}
                                       </label>
                                       {{ $t->passenger_id == Auth::id() ? '(Yours)' : "" }}
                               </div>
                           @endforeach
                       </div>
                    @endforeach
                </form>
            </div>
        </div>
    </div>

</x-app-layout>


{{--                @if($ticket->status == "available")--}}
{{--                                    <form method="post" action="{{ route('payment.book', [--}}
{{--                            'schedule_id' => $schedule->id,--}}
{{--                                            'ticket_id'     => $ticket->id--}}
{{--                                        ])}}"--}}
{{--                          style="display:inline">--}}
{{--                        @csrf--}}
{{--                        <button type="submit" class="btn btn-info btn-sm"--}}
{{--                            onclick="return confirm('Are you sure?')"--}}
{{--                        >--}}
{{--                            Book--}}
{{--                        </button>--}}
{{--                    </form>--}}
{{--                @elseif(Auth::id() == $ticket->passenger_id)--}}
{{--                    Your ticket--}}
{{--                @endif--}}
{{--                @endif--}}

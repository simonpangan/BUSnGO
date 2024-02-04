<x-app-layout>
    <div class="container mt-4">
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

        <h2> Schedule</h2>

        <div class="mb-3">
            Bus: {{ $schedule->bus->no }}
        </div>

        <div class="mb-3">
            Departure Time: {{ $schedule->departure_time }}
        </div>

        <div class="mb-3">
            Arrival Time: {{ $schedule->arrival_time }}
        </div>

        <div class="mb-3">
            Status: {{ $schedule->status }}
        </div>

        <div>
            Driver: <a
                target="_blank"
                href="{{ route('drivers.show',
                $schedule->bus->driver->id
            )}}"> {{ $schedule->bus->driver->name }}</a>
        </div>
        <div>
            Conductor: <a
                target="_blank"
                href="{{ route('conductors.show',
                $schedule->bus->conductor->id
            )}}"> {{ $schedule->bus->conductor->name }}</a>
        </div>
        <form method="post" action="{{ route('payment.book', [
                'schedule_id' => $schedule->id,
//                'ticket_id' => $ticket->id
            ])}}"
        >
            @csrf
            <button type="submit" class="btn btn-warning btn-sm"
                onclick="return confirm('Are you sure?')"
            >
                Book Selected
            </button>

            @foreach($schedule->tickets as $ticket)
                <div class="form-check">
                    <input class="form-check-input" type="checkbox"
                           name="tickets[]"
                           value="{{ $ticket->seat_no }}"
                           id="ticketsCheckBox"
                        {{ $ticket->status != "available" ? "disabled" : "" }}
                    >
                    <label class="form-check-label" for="ticketsCheckBox">
                        Seat # {{ $ticket->seat_no }}
                        {{ $ticket->passenger_id == Auth::id() ? '(Your Ticket)' : "" }}
                    </label>
                </div>
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
            @endforeach
        </form>
        <a href="{{ route('schedules.index')  }}" class="btn btn-primary">Back to list</a>
    </div>

</x-app-layout>

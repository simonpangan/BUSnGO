<x-app-layout>
    <div class="container mt-4">
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

        <a href="{{ route('schedules.index')  }}" class="btn btn-primary">Back to list</a>
    </div>

</x-app-layout>

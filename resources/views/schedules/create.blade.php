@php use App\Models\Schedule @endphp

<x-app-layout>
    @section('css')
        <link rel="stylesheet"
              href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/css/bootstrap-select.min.css"/>
    @endsection

    <div class="container mt-4">

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <h2>Create Schedule</h2>
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="mx-auto" style="max-width: 500px;">
            <form
                x-data="{
                    departureTime: '{{ old('departure_time') }}',
                    submit(event) {
                        event.preventDefault();
                        // Parse the departure time and current time
                        const departureDateTime = new Date(this.departureTime);
                        const currentDateTime = new Date();

                        // Calculate the time difference in milliseconds
                        const timeDifference = departureDateTime - currentDateTime;

                        // Convert the time difference to hours
                        const hoursDifference = timeDifference / (1000 * 60 * 60);

                        // Check if the current time is within 3 hours before the departure time
                        if (hoursDifference <= 3 && hoursDifference > 0) {
                            if (!confirm('Your departure time is approaching. Do you want to proceed?')) {
                                return;
                            }
                        }
                        event.currentTarget.submit();
                    }
                }"
                id="scheduleCreate"
                @submit="submit"
                method="post" action="{{ route('admin.schedules.store') }}">
                @csrf
                <div class="mb-3">
                    <label for="bus_id" class="form-label">Bus: </label>
                    <select class="form-control @error('bus') is-invalid @enderror" aria-label="City select"
                            name="bus_id"
                            data-style="border border-1"
                            data-live-search="true"
                    >
                        <option>Select Bus</option>
                        @foreach($buses as $bus)
                            <option
                                {{ old('bus_id') == $bus->id ? "selected" : "" }}
                                value="{{ $bus->id }}"
                            >{{ $bus->no }}</option>
                        @endforeach
                    </select>
                    @error('bus')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="bus_id" class="form-label">Terminal: </label>
                    <select class="form-control @error('terminal_id') is-invalid @enderror" aria-label="City select"
                            name="terminal_id"
                            data-style="border border-1"
                            data-live-search="true"
                    >
                        <option>Select Terminal</option>
                        @foreach($terminals as $terminal)
                            <option
                                {{ old('terminal_id') == $terminal->id ? "selected" : "" }}
                                value="{{ $terminal->id }}"
                            >
                                From: {{ $terminal->from }} To: {{ $terminal->to }}
                            </option>
                        @endforeach
                    </select>
                    @error('terminal_id')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <span x-text="departureTime"></span>
                <div class="mb-3">
                    <label for="departure_time" class="form-label">Departure Time</label>
                    <input type="datetime-local"
                           x-model="departureTime"
                           class="form-control @error('departure_time') is-invalid @enderror" id="departure_time"
                           name="departure_time" required
                    >

                    @error('departure_time')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="arrival_time" class="form-label">Arrival Time</label>
                    <input type="datetime-local"
                           class="form-control @error('arrival_time') is-invalid @enderror" id="arrival_time"
                           name="arrival_time" value="{{ old('arrival_time') }}" required
                    >

                    @error('arrival_time')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="status" class="form-label">Status</label>
                    <select name="status"
                            class="form-select @error('status') is-invalid @enderror"
                            aria-label="Status Select"
                            id="status"
                    >
                        <option>Select Status</option>
                        @foreach(Schedule::STATUS as $status)
                            <option value="{{ $status }}"
                                {{ old('status') == $status ? "selected" : "" }}
                            >{{ $status }}</option>
                        @endforeach
                    </select>

                    @error('status')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="driver_id" class="form-label">Driver</label>
                    <select name="driver_id" class="form-select @error('driver_id') is-invalid @enderror"
                            aria-label="Driver Select">
                        <option>Select Driver</option>
                        @foreach($drivers as $driver)
                            <option value="{{ $driver->id }}"
                                {{ old('driver_id') == $driver->id ? "selected" : "" }}
                            >{{ $driver->name }}</option>
                        @endforeach
                    </select>

                    @error('driver_id')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="conductor_id" class="form-label">Conductor</label>
                    <select name="conductor_id"
                            class="form-select @error('conductor_id') is-invalid @enderror"
                            aria-label="Conductor Select">
                        <option>Select Conductor</option>
                        @foreach($conductors as $conductor)
                            <option value="{{ $conductor->id }}"
                                {{ old('conductor_id') == $conductor->id ? "selected" : "" }}
                            >{{ $conductor->name }}</option>
                        @endforeach
                    </select>

                    @error('conductor_id')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary">
                    Create Schedule
                </button>
            </form>
        </div>
    </div>

    @section('javascript')
        <script
            src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/js/bootstrap-select.min.js"></script>
        <script>
            $(document).ready(function () {
                $('select[name="bus_id"]').selectpicker();
            })
        </script>
    @endsection
</x-app-layout>

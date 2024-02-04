<x-app-layout>
    @section('css')
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/css/bootstrap-select.min.css" />
    @endsection

    <div class="container mt-4">

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <h2>Edit Schedule</h2>
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="post" action="{{ route('admin.schedules.update', $schedule) }}">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <select class="form-control @error('bus') is-invalid @enderror" aria-label="City select" name="bus_id"
                        data-style="border border-1"
                        data-live-search="true"
                >
                    <option>Select Bus</option>
                    @foreach($buses as $bus)
                        <option
                            {{ old('bus_id', $schedule->bus_id) == $bus->id ? "selected" : "" }}
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
                <label for="status" class="form-label">Departure Time</label>
                <input type="datetime-local"
                       class="form-control @error('departure_time') is-invalid @enderror" id="departure_time"
                       name="departure_time" value="{{ old('departure_time', $schedule->departure_time) }}" required
                >

                @error('departure_time')
                <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="mb-3">
                <label for="status" class="form-label">Arrival Time</label>
                <input type="datetime-local"
                       class="form-control @error('arrival_time') is-invalid @enderror" id="arrival_time"
                       name="arrival_time" value="{{ old('arrival_time', $schedule->arrival_time) }}" required
                >

                @error('arrival_time')
                <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="mb-3">
                <label for="status" class="form-label">Status</label>
                <input type="text"
                       class="form-control @error('status') is-invalid @enderror" id="status"
                       name="status" value="{{ old('status', $schedule->status) }}" required
                >

                @error('status')
                <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">Edit Schedule</button>
        </form>
    </div>

    @section('javascript')
        <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/js/bootstrap-select.min.js"></script>
        <script>
            $(document).ready(function() {
                $('select[name="bus_id"]').selectpicker();
            })
        </script>
    @endsection
</x-app-layout>

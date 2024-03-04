@php use App\Models\Schedule @endphp

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

        <h2>Create Service</h2>
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
            <form method="post" action="{{ route('admin.service.store') }}">
                @csrf
                <div class="mb-3">
                    <label for="bus_id" class="form-label">Bus: </label>
                    <select class="form-control @error('bus') is-invalid @enderror" aria-label="City select" name="bus_id"
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
                    <label for="to" class="form-label">Description</label>
                    <input type="text" class="form-control @error('description') is-invalid @enderror"
                           id="description" name="description" value="{{ old('description') }}" required>

                    @error('description')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="status" class="form-label">Status</label>
                    <input type="text" class="form-control @error('status') is-invalid @enderror"
                           id="status" name="status" value="{{ old('status') }}" required>

                    @error('status')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="duration" class="form-label">Duration</label>
                    <input type="text" class="form-control @error('duration') is-invalid @enderror"
                           id="duration" name="duration" value="{{ old('duration') }}" required>

                    @error('duration')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">
                    Create Service
                </button>
            </form>
        </div>
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

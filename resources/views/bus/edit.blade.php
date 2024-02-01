<x-app-layout>
    <div class="container mt-4">
        <h2>Edit Bus</h2>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session("success") }}
            </div>
        @endif

        <form
            method="post"
            action="{{ route('buses.update', $bus->id) }}"
            enctype="multipart/form-data"
        >
            @csrf @method('put')

            <div class="mb-3 row">
                <label for="no" class="col-md-4 col-form-label text-md-end"
                >No</label
                >
                <div class="col-md-6">
                    <input
                        type="text"
                        class="form-control @error('no') is-invalid @enderror"
                        id="no"
                        name="no"
                        value="{{ old('no', $bus->no) }}"
                        required
                    />

                    @error('no')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>

            <!-- Repeat the structure for other fields with their corresponding validation messages -->

            <div class="mb-3 row">
                <div class="col-md-6 offset-md-4">
                    <button type="submit" class="btn btn-primary">
                        Update Bus
                    </button>
                    <a
                        href="{{ route('buses.index') }}"
                        class="btn btn-secondary"
                    >Go Back</a
                    >
                </div>
            </div>
        </form>
    </div>
</x-app-layout>

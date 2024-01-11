<x-app-layout>
    <div class="container mt-4">
        <h2>Driver Details</h2>

        <div class="card mt-3">
            <div class="card-body">
                <div class="mb-3">
                    <label class="fw-bold">ID:</label>
                    {{ $driver->id }}
                </div>

                <!-- (Rest of the fields) -->

                <div class="mb-3">
                    <label class="fw-bold">Photo:</label>
                    <img src="{{ asset('storage/' . $driver->photo) }}" alt="Driver Photo" class="img-thumbnail">
                </div>

                <a href="{{ route('drivers.edit', $driver->id) }}" class="btn btn-warning">Edit</a>

                <form method="post" action="{{ route('drivers.destroy', $driver->id) }}" style="display:inline">
                    @csrf
                    @method('delete')
                    <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                </form>

                <a href="{{ route('drivers.index') }}" class="btn btn-secondary">Go Back</a>
            </div>
        </div>
    </div>
</x-app-layout>

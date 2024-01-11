<x-app-layout>
    <div class="container mt-4">
        <h2>Driver Details</h2>

        <div class="card mt-3">
            <div class="card-body">

                <div class="mb-3">
                    <label class="fw-bold">Name:</label>
                    {{ $driver->name }}
                </div>

                <div class="mb-3">
                    <label class="fw-bold">Gender:</label>
                    {{ $driver->gender == 'M' ? 'Male' : 'Female' }}
                </div>

                <div class="mb-3">
                    <label class="fw-bold">Address:</label>
                    {{ $driver->address }}
                </div>

                <div class="mb-3">
                    <label class="fw-bold">City:</label>
                    {{ $driver->city }}
                </div>

                <div class="mb-3">
                    <label class="fw-bold">Contact Number:</label>
                    {{ $driver->contact_no }}
                </div>
                <div class="mb-3">
                    <label class="fw-bold">Photo:</label>
                    <img src="{{ asset('storage/' . $driver->photo) }}" alt="Driver Photo" class="img-thumbnail">
                </div>

                <a href="{{ route('drivers.index') }}" class="btn btn-secondary">Go Back</a>
            </div>
        </div>
    </div>
</x-app-layout>

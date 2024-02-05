<x-app-layout>
    <div class="container mt-4">
        <a href="{{ route('admin.drivers.index') }}" class="btn btn-secondary">
            <- Go Back
        </a>

        <h2 class="text-center">Driver Details</h2>

        <div class="card mt-3 mx-auto rounded" style="max-width: 500px;">
            <img src="{{ asset('storage/uploads/' . $driver->photo) }}"
                 style="height: 350px"
                 class="card-img-top object-fit-cover"
                 alt="{{ $driver->name }}">
            <div class="card-body">
                <h5 class="card-title">
                    {{ $driver->name }}
                </h5>
                <div class="mb-3">
                    <span class="fw-bold">Gender:</span> {{ $driver->gender == 'M' ? 'Male' : 'Female' }}
                </div>
                <div class="mb-3">
                    <span class="fw-bold">Address:</span> {{ $driver->address }}
                </div>
                <div class="mb-3">
                    <span class="fw-bold">City/Municipality:</span> {{ $driver->city }}
                </div>
                <div class="mb-3">
                    <span class="fw-bold">Contact Number:</span> {{ $driver->contact_no }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

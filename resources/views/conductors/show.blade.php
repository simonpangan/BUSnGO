<x-app-layout>
    <div class="container mt-4">
        <a href="{{ route('admin.conductors.index') }}" class="btn btn-secondary">
            <- Go Back
        </a>

        <h2 class="text-center">Conductor Details</h2>

        <div class="card mt-3 mx-auto rounded" style="max-width: 500px;">
            <img src="{{ asset('storage/uploads/' . $conductor->photo) }}"
                 style="height: 350px"
                 class="card-img-top object-fit-cover"
                 alt="{{ $conductor->name }}">
            <div class="card-body">
                <h5 class="card-title">
                    {{ $conductor->name }}
                </h5>
                <div class="mb-3">
                    <span class="fw-bold">Gender:</span> {{ $conductor->gender == 'M' ? 'Male' : 'Female' }}
                </div>
                <div class="mb-3">
                    <span class="fw-bold">Address:</span> {{ $conductor->address }}
                </div>
                <div class="mb-3">
                    <span class="fw-bold">City/Municipality:</span> {{ $conductor->city }}
                </div>
                <div class="mb-3">
                    <span class="fw-bold">Contact Number:</span> {{ $conductor->contact_no }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

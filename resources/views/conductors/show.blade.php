<x-app-layout>
    <div class="container mt-4">
        <h2>Conductor Details</h2>

        <div class="card mt-3">
            <div class="card-body">

                <div class="mb-3">
                    <label class="fw-bold">Name:</label>
                    {{ $conductor->name }}
                </div>

                <div class="mb-3">
                    <label class="fw-bold">Gender:</label>
                    {{ $conductor->gender == 'M' ? 'Male' : 'Female' }}
                </div>

                <div class="mb-3">
                    <label class="fw-bold">Address:</label>
                    {{ $conductor->address }}
                </div>

                <div class="mb-3">
                    <label class="fw-bold">City:</label>
                    {{ $conductor->city }}
                </div>

                <div class="mb-3">
                    <label class="fw-bold">Contact Number:</label>
                    {{ $conductor->contact_no }}
                </div>
                <div class="mb-3">
                    <label class="fw-bold">Photo:</label>
                    <img src="{{ asset('storage/uploads/' . $conductor->photo) }}" alt="Driver Photo" class="img-thumbnail">
                </div>

{{--                <a href="{{ route('conductors.index') }}" class="btn btn-secondary">Go Back</a>--}}
            </div>
        </div>
    </div>
</x-app-layout>

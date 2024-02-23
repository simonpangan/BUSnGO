<x-app-layout>
    <div class="container mt-4">
        <a href="{{ route('admin.buses.index') }}" class="btn btn-info">
            <- Go Back To List
        </a>

        <div class="mx-auto border rounded p-3" style="width: 500px">
            <h2 class="text-center">Bus</h2>
            <br />
            <div class="mb-3 row">
                <p class="fw-bold col-md-4 text-md-end">No:</p>
                <div class="col-md-6">
                    {{ $bus->no }}
                </div>
            </div>
            <div class="mb-3 row">
                <p class="fw-bold col-md-4 text-md-end">Seat:</p>
                <div class="col-md-6">
                    {{ $bus->seat }}
                </div>
            </div>
            <div class="mb-3 row">
                <p class="fw-bold col-md-4 text-md-end">
                    Engine Model
                :</p>
                <div class="col-md-6">
                    {{ $bus->engine_model }}
                </div>
            </div>
            <div class="mb-3 row">
                <p class="fw-bold col-md-4 text-md-end">
                    Engine Model
                :</p>
                <div class="col-md-6">
                    {{ $bus->engine_model }}
                </div>
            </div>
            <div class="mb-3 row">
                <p class="fw-bold col-md-4 text-md-end">
                    Chassis No
                :</p>
                <div class="col-md-6">
                    {{ $bus->chassis_no }}
                </div>
            </div>

            <div class="mb-3 row">
                <p class="fw-bold col-md-4 text-md-end">Color:</p>
                <div class="col-md-6">
                    {{ $bus->color }}
                </div>
            </div>
            <div class="mb-3 row">
                <p class="fw-bold col-md-4 text-md-end">Register No:</p>
                <div class="col-md-6">
                    {{ $bus->register_no }}
                </div>
            </div>
            <div class="mb-3 row">
                <p class="fw-bold col-md-4 text-md-end">Made In:</p>
                <div class="col-md-6">
                    {{ $bus->made_in }}
                </div>
            </div>
            <div class="mb-3 row">
                <p class="fw-bold col-md-4 text-md-end">Make:</p>
                <div class="col-md-6">
                    {{ $bus->make }}
                </div>
            </div>
            <div class="mb-3 row">
                <p class="fw-bold col-md-4 text-md-end">Price:</p>
                <div class="col-md-6">
                    {{ $bus->price }}
                </div>
            </div>
            <div class="mb-3 row">
                <p class="fw-bold col-md-4 text-md-end">Fuel:</p>
                <div class="col-md-6">
                    {{ $bus->fuel }}
                </div>
            </div>
            <div class="mb-3 row">
                <p class="fw-bold col-md-4 text-md-end">Engine Capacity:</p>
                <div class="col-md-6">
                    {{ $bus->engine_capacity }}
                </div>
            </div>
            <div class="mb-3 row">
                <p class="fw-bold col-md-4 text-md-end">Purchase Year:</p>
                <div class="col-md-6">
                    {{ $bus->puchase_year }}
                </div>
            </div>
            <div class="mb-3 row">
                <p class="fw-bold col-md-4 text-md-end">Transmission Model:</p>
                <div class="col-md-6">
                    {{ $bus->transmission_model }}
                </div>
            </div>
            <div class="mb-3 row">
                <p class="fw-bold col-md-4 text-md-end">Status:</p>
                <div class="col-md-6">
                    {{ $bus->status }}
                </div>
            </div>
            <div class="mb-3 row">
                <div class="col-md-6 offset-md-4">
                    <a href="{{ route('admin.buses.index') }}" class="btn btn-secondary">Go Back</a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<x-app-layout>
    <div class="container mt-4">
        <a href="{{ route('admin.buses.index') }}" class="btn btn-info">
            <- Go Back To List
        </a>

        <div class="mx-auto border rounded p-3" style="width: 500px">
            <h2>Create Bus</h2>

            @if(session('success'))
                <div class="alert alert-success">
                    {{ session("success") }}
                </div>
            @endif

            <form method="post" action="{{ route('admin.buses.store') }}" enctype="multipart/form-data">
                @csrf

                <div class="mb-3 row">
                    <label for="no" class="col-md-4 col-form-label text-md-end">
                        Plate No
                    </label>
                    <div class="col-md-6">
                        <input type="text" class="form-control @error('no') is-invalid @enderror" id="no" name="no"
                               value="{{ old('no') }}" required />
                        <div id="passwordHelpBlock" class="form-text">
                          Format: ABC 123 or ABC 1234
                        </div>
                        @error('no')
                        <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                        @enderror
                    </div>
                </div>

                <div class="mb-3 row">
                    <label for="sesat" class="col-md-4 col-form-label text-md-end">Seat</label>
                    <div class="col-md-6">
                        <input type="text" class="form-control @error('seat') is-invalid @enderror" id="seat" name="seat"
                               value="{{ old('seat') }}" required />

                        @error('seat')
                        <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                        @enderror
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="engine_model" class="col-md-4 col-form-label text-md-end">
                        Engine Model
                    </label>
                    <div class="col-md-6">
                        <input type="text" class="form-control @error('engine_model') is-invalid @enderror"
                               id="engine_model" name="engine_model" value="{{ old('engine_model') }}"
                               required />

                        @error('engine_model')
                        <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                        @enderror
                    </div>
                </div>
                <div class="mb-3 row">
                    <labe for="chassis_no" class="col-md-4 col-form-label text-md-end">Chassis NO
                    </labe>
                    <div class="col-md-6">
                        <input type="text" class="form-control @error('chassis_no') is-invalid @enderror" id="chassis_no"
                               name="chassis_no" value="{{ old('chassis_no') }}" required />

                        @error('chassis_no')
                        <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                        @enderror
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="model" class="col-md-4 col-form-label text-md-end">Model</label>
                    <div class="col-md-6">
                        <input type="text" class="form-control @error('model') is-invalid @enderror" id="model" name="model"
                               value="{{ old('model') }}" required />

                        @error('model')
                        <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                        @enderror
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="color" class="col-md-4 col-form-label text-md-end">Color</label>
                    <div class="col-md-6">
                        <input type="text" class="form-control @error('color') is-invalid @enderror" id="color" name="color"
                               value="{{ old('color') }}" required />

                        @error('color')
                        <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                        @enderror
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="no" class="col-md-4 col-form-label text-md-end">Register No</label>
                    <div class="col-md-6">
                        <input type="text" class="form-control @error('register_no') is-invalid @enderror" id="register_no"
                               name="register_no" value="{{ old('register_no') }}" required />

                        @error('register_no')
                        <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                        @enderror
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="made_in" class="col-md-4 col-form-label text-md-end">Made In</label>
                    <div class="col-md-6">
                        <input type="text" class="form-control @error('made_in') is-invalid @enderror" id="made_in" name="made_in"
                               value="{{ old('made_in') }}" required />

                        @error('made_in')
                        <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                        @enderror
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="make" class="col-md-4 col-form-label text-md-end">Make</label>
                    <div class="col-md-6">
                        <input type="text" class="form-control @error('make') is-invalid @enderror" id="make" name="make"
                               value="{{ old('make') }}" required />

                        @error('make')
                        <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                        @enderror
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="price" class="col-md-4 col-form-label text-md-end">Price</label>
                    <div class="col-md-6">
                        <input type="text" class="form-control @error('price') is-invalid @enderror" id="price" name="price"
                               value="{{ old('price') }}" required />

                        @error('price')
                        <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                        @enderror
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="fuel" class="col-md-4 col-form-label text-md-end">Fuel</label>
                    <div class="col-md-6">
                        <input type="text" class="form-control @error('fuel') is-invalid @enderror" id="fuel" name="fuel"
                               value="{{ old('fuel') }}" required />

                        @error('fuel')
                        <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                        @enderror
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="engine_capacity" class="col-md-4 col-form-label text-md-end">Engine Capacity</label>
                    <div class="col-md-6">
                        <input type="text" class="form-control @error('engine_capacity') is-invalid @enderror" id="engine_capacity" name="engine_capacity"
                               value="{{ old('engine_capacity') }}" required />

                        @error('engine_capacity')
                        <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                        @enderror
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="puchase_year" class="col-md-4 col-form-label text-md-end">Purchase Year</label>
                    <div class="col-md-6">
                        <input type="text" class="form-control @error('puchase_year') is-invalid @enderror" id="puchase_year" name="puchase_year"
                               value="{{ old('puchase_year') }}" required />

                        @error('puchase_year')
                        <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                        @enderror
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="transmission_model" class="col-md-4 col-form-label text-md-end">Transmission Model</label>
                    <div class="col-md-6">
                        <input type="text" class="form-control @error('transmission_model') is-invalid @enderror" id="transmission_model" name="transmission_model"
                               value="{{ old('transmission_model') }}" required />

                        @error('transmission_model')
                        <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                        @enderror
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="status" class="col-md-4 col-form-label text-md-end">Status</label>
                    <div class="col-md-6">
                        <input type="text" class="form-control @error('status') is-invalid @enderror" id="status" name="status"
                               value="{{ old('status') }}" required />

                        @error('status')
                        <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                        @enderror
                    </div>
                </div>


                <div class="mb-3 row">
                    <div class="col-md-6 offset-md-4">
                        <button type="submit" class="btn btn-primary">
                            Store  Bus
                        </button>
                        <a href="{{ route('admin.buses.index') }}" class="btn btn-secondary">Go Back</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>

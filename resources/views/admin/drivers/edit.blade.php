<x-app-layout>
    @section('css')
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/css/bootstrap-select.min.css" />
    @endsection


    <div class="container mt-4">
        <h2>Edit Driver</h2>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="post" action="{{ route('admin.drivers.update', $driver->id) }}" enctype="multipart/form-data">
            @csrf
            @method('put')

            <!-- Name -->
            <div class="mb-3 row">
                <label for="name" class="col-md-4 col-form-label text-md-end">Name</label>
                <div class="col-md-6">
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name"
                           value="{{ old('name', $driver->name) }}" required>
                    @error('name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>

            <!-- Gender -->
            <div class="mb-3 row">
                <label for="gender" class="col-md-4 col-form-label text-md-end">Gender</label>
                <div class="col-md-6">
                    <select class="form-select @error('gender') is-invalid @enderror" id="gender" name="gender"
                            required>
                        <option value="M" {{ old('gender', $driver->gender) == 'M' ? 'selected' : '' }}>Male</option>
                        <option value="F" {{ old('gender', $driver->gender) == 'F' ? 'selected' : '' }}>Female</option>
                    </select>
                    @error('gender')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>

            <!-- Address -->
            <div class="mb-3 row">
                <label for="address" class="col-md-4 col-form-label text-md-end">Address</label>
                <div class="col-md-6">
                    <input type="text" class="form-control @error('address') is-invalid @enderror" id="address"
                           name="address" value="{{ old('address', $driver->address) }}" required>
                    @error('address')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>

            <!-- City (Assuming there is a 'city' field in your Driver model) -->
            <div class="mb-3 row">
                <label for="city" class="col-md-4 col-form-label text-md-end">City</label>
                <div class="col-md-6">
                    <select class="form-control @error('city') is-invalid @enderror" aria-label="City select" name="city"
                            data-style="border border-1"
                            data-live-search="true"
                    >
                        //TODO: maybe add this always margin-top: 0px; margin-bottom: 48205px; min-width: 218px;
                        <option selected>Select City/Municipality</option>
                        @foreach($LGUs as $lgu)
                            <option
                                {{ old('city', $driver->city) == $lgu->name ? "selected" : "" }}
                                value="{{ $lgu->name }}"
                            >{{ $lgu->name }}</option>
                        @endforeach
                    </select>

                    @error('city')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

            <!-- Contact Number -->
            <div class="mb-3 row">
                <label for="contact_no" class="col-md-4 col-form-label text-md-end">Contact Number</label>
                <div class="col-md-6">
                    <input type="text" class="form-control @error('contact_no') is-invalid @enderror" id="contact_no"
                           aria-describedby="contactHelp" name="contact_no" value="{{ old('contact_no', $driver->contact_no) }}" required>
                    @error('contact_no')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                    <div id="contactHelp" class="form-text">
                        Format: 09********* or +639*********
                    </div>
                </div>
            </div>

            <div class="mb-3 row">
                <label for="email" class="col-md-4 col-form-label text-md-end">Email</label>
                <div class="col-md-6">
                    <input type="email" class="form-control @error('email') is-invalid @enderror"
                           id="email" name="email" value="{{ old('email', $driver->user->email) }}" required>

                    @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>

            <div class="mb-3 row">
                <label for="photo" class="col-md-4 col-form-label text-md-end">Current Photo</label>
                <div class="col-md-6">
                    <img src="{{ asset('storage/uploads/'.$driver->photo) }}" alt="Driver Photo" class="img-thumbnail"
                         style="max-width: 200px;">
                </div>
            </div>

            <div class="mb-3 row">
                <label for="new_photo" class="col-md-4 col-form-label text-md-end">New Photo (Optional)</label>
                <div class="col-md-6">
                    <input type="file" class="form-control @error('new_photo') is-invalid @enderror" id="new_photo"
                           name="new_photo" accept="image/*">
                    @error('new_photo')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>

            <div class="mb-3 row">
                <div class="col-md-6 offset-md-4">
                    <button type="submit" class="btn btn-primary">Update Driver</button>
                    <a href="{{ route('admin.drivers.index') }}" class="btn btn-secondary">Go Back</a>
                </div>
            </div>
        </form>
    </div>

    @section('javascript')
            <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/js/bootstrap-select.min.js"></script>
            <script>
                $(document).ready(function() {
                    $('select[name="city"]').selectpicker();
                })
            </script>
    @endsection
</x-app-layout>

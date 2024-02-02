<x-app-layout>
    @section('css')
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/css/bootstrap-select.min.css" />
    @endsection

    <div class="container mt-4">
        <h2>Create Driver</h2>
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="post" action="{{ route('drivers.store') }}" enctype="multipart/form-data">
            @csrf

            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required>
                @error('name')
                <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="mb-3">
                <label for="gender" class="form-label">Gender</label>
                <select class="form-select @error('gender') is-invalid @enderror" id="gender" name="gender" required>
                    <option value="M">Male</option>
                    <option value="F">Female</option>
                </select>
                @error('gender')
                <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="mb-3">
                <label for="address" class="form-label">Address</label>
                <input type="text" class="form-control @error('address') is-invalid @enderror" id="address" name="address" value="{{ old('address') }}" required>
                @error('address')
                <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="mb-3">
                <select class="form-control @error('city') is-invalid @enderror" aria-label="City select" name="city"
                        data-style="border border-1"
                        data-live-search="true"
                >
                    <option>Select City/Municipality</option>
                    @foreach($LGUs as $lgu)
                        <option
                            {{ old('city') == $lgu->name ? "selected" : "" }}
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

            <div class="mb-3">
                <label for="contact_no" class="form-label">Contact Number</label>
                <input type="text"
                       class="form-control @error('contact_no') is-invalid @enderror" id="contact_no"
                       name="contact_no" value="{{ old('contact_no') }}" required
                       aria-describedby="contactHelp"
                >

                @error('contact_no')
                <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
                <div id="contactHelp" class="form-text">
                    Format: 09********* or +639*********
                </div>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" required>
                @error('password')
                <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required>
                @error('email')
                <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="mb-3">
                <label for="photo" class="form-label">Photo</label>
                <input type="file" class="form-control @error('photo') is-invalid @enderror" id="photo" name="photo" accept="image/*" required>
                @error('photo')
                <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">Create Driver</button>
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

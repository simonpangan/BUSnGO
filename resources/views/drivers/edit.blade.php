<x-app-layout>
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

        <form method="post" action="{{ route('drivers.update', $driver->id) }}" enctype="multipart/form-data">
            @csrf
            @method('put')

            <!-- Name -->
            <div class="mb-3 row">
                <label for="name" class="col-md-4 col-form-label text-md-end">Name</label>
                <div class="col-md-6">
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $driver->name) }}" required>
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
                    <select class="form-select @error('gender') is-invalid @enderror" id="gender" name="gender" required>
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
                    <input type="text" class="form-control @error('address') is-invalid @enderror" id="address" name="address" value="{{ old('address', $driver->address) }}" required>
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
                    <input type="text" class="form-control @error('city') is-invalid @enderror" id="city" name="city" value="{{ old('city', $driver->city) }}" required>
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
                    <input type="text" class="form-control @error('contact_no') is-invalid @enderror" id="contact_no" name="contact_no" value="{{ old('contact_no', $driver->contact_no) }}" required>
                    @error('contact_no')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>

{{--            <!-- Password -->--}}
{{--            <div class="mb-3 row">--}}
{{--                <label for="password" class="col-md-4 col-form-label text-md-end">Password</label>--}}
{{--                <div class="col-md-6">--}}
{{--                    <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password">--}}
{{--                    @error('password')--}}
{{--                    <span class="invalid-feedback" role="alert">--}}
{{--                        <strong>{{ $message }}</strong>--}}
{{--                    </span>--}}
{{--                    @enderror--}}
{{--                </div>--}}
{{--            </div>--}}

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
                    <img src="{{ asset('storage/uploads/' . $driver->photo) }}" alt="Driver Photo" class="img-thumbnail" style="max-width: 200px;">
                </div>
            </div>

            <div class="mb-3 row">
                <label for="new_photo" class="col-md-4 col-form-label text-md-end">New Photo (Optional)</label>
                <div class="col-md-6">
                    <input type="file" class="form-control @error('new_photo') is-invalid @enderror" id="new_photo" name="new_photo" accept="image/*">
                    @error('new_photo')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>

            <!-- Security Question and Answer (Uncomment if needed) -->
            <!--
            <div class="mb-3 row">
                <label for="question" class="col-md-4 col-form-label text-md-end">Security Question</label>
                <div class="col-md-6">
                    <input type="text" class="form-control @error('question') is-invalid @enderror" id="question" name="question" value="{{ old('question', $driver->question) }}" required>
                    @error('question')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
                    </span>
                    @enderror
            </div>
        </div>

        <div class="mb-3 row">
            <label for="answer" class="col-md-4 col-form-label text-md-end">Security Answer</label>
            <div class="col-md-6">
                <input type="text" class="form-control @error('answer') is-invalid @enderror" id="answer" name="answer" value="{{ old('answer', $driver->answer) }}" required>
                    @error('answer')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
                    </span>
                    @enderror
            </div>
        </div>
-->

            <!-- Buttons -->
            <div class="mb-3 row">
                <div class="col-md-6 offset-md-4">
                    <button type="submit" class="btn btn-primary">Update Driver</button>
                    <a href="{{ route('drivers.index') }}" class="btn btn-secondary">Go Back</a>
                </div>
            </div>
        </form>
    </div>
</x-app-layout>

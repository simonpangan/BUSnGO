<x-app-layout>
    <div class="container mt-4">
        <h2>Edit Driver</h2>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <form method="post" action="{{ route('drivers.update', $driver->id) }}" enctype="multipart/form-data">
            @csrf
            @method('put')

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

            <!-- Repeat the structure for other fields with their corresponding validation messages -->

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

            <div class="mb-3 row">
                <div class="col-md-6 offset-md-4">
                    <button type="submit" class="btn btn-primary">Update Driver</button>
                    <a href="{{ route('drivers.index') }}" class="btn btn-secondary">Go Back</a>
                </div>
            </div>
        </form>
    </div>
</x-app-layout>

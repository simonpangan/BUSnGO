<x-app-layout>
    <div class="container mt-4">
        <a href="{{ route('companies.index') }}" class="btn btn-info">
            <- Go Back To List
        </a>

        <div class="mx-auto border rounded p-3" style="width: 500px">
            <h2>Edit Company</h2>

            @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session("success") }}
                </div>
            @endif

            <form method="post" action="{{ route('companies.update', $company) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="mb-3 row">
                    <label for="name" class="col-md-4 col-form-label text-md-end">
                        Name
                    </label>
                    <div class="col-md-6">
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name"
                               value="{{ old('name', $company->name) }}" required />
                        @error('name')
                        <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                        @enderror
                    </div>
                </div>

                <div class="mb-3 row">
                    <label for="address" class="col-md-4 col-form-label text-md-end">Address</label>
                    <div class="col-md-6">
                        <input type="text" class="form-control @error('address') is-invalid @enderror" id="address" name="address"
                               value="{{ old('address', $company->address) }}" required />

                        @error('address')
                        <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                        @enderror
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="phone" class="col-md-4 col-form-label text-md-end">
                        Phone Number
                    </label>
                    <div class="col-md-6">
                        <input type="text" class="form-control @error('phone') is-invalid @enderror"
                               id="phone" name="phone" value="{{ old('phone', $company->phone_number) }}"
                               required />
                        <div id="contactHelp" class="form-text">
                            Format: 09********* or +639*********
                        </div>
                        @error('phone')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
                <div class="mb-3 row">
                    <labe for="email_address" class="col-md-4 col-form-label text-md-end">
                        Email Address
                    </labe>
                    <div class="col-md-6">
                        <input type="text" class="form-control @error('email_address') is-invalid @enderror" id="email_address"
                               name="email_address" value="{{ old('email_address', $company->email_address) }}" required />

                        @error('email_address')
                        <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                        @enderror
                    </div>
                </div>

                <div class="mb-3">
                    <button type="submit" class="btn btn-primary float-end">
                        Edit  Bus
                    </button>
                </div>

                <br />
                <br />
            </form>
        </div>
    </div>
</x-app-layout>

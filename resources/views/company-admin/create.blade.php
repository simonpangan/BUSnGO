<x-app-layout>
    <div class="container mt-4">
        <a href="{{ route('companies.index') }}" class="btn btn-info">
            <- Go Back To List
        </a>

        <div class="mx-auto border rounded p-3" style="width: 500px">
            <h2>Create Admin</h2>

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

            <form method="post" action="{{ route('company-admin.store') }}" enctype="multipart/form-data">
                @csrf

                <div class="mb-3 row">
                    <label for="company" class="col-md-4 col-form-label text-md-end">Company: </label>
                    <div class="col-md-6">
                        <select class="form-control @error('bus') is-invalid @enderror" aria-label="City select" name="company"
                                data-style="border border-1"
                                data-live-search="true"
                        >
                            <option>Select Company</option>
                            @foreach($companies as $company)
                                <option
                                    {{ old('company') }}
                                    value="{{ $company->id }}"
                                >{{ $company->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    @error('company')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="mb-3 row">
                    <label for="name" class="col-md-4 col-form-label text-md-end">
                        Name
                    </label>
                    <div class="col-md-6">
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name"
                               value="{{ old('name') }}" required />
                        @error('name')
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
                               id="phone" name="phone" value="{{ old('phone') }}"
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
                    <labe for="email" class="col-md-4 col-form-label text-md-end">
                        Email Address
                    </labe>
                    <div class="col-md-6">
                        <input type="text" class="form-control @error('email') is-invalid @enderror" id="email"
                               name="email" value="{{ old('email') }}" required />

                        @error('email')
                        <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>

                    <div class="col-md-6">
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                        @error('password')
                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="password-confirm" class="col-md-4 col-form-label text-md-end">{{ __('Confirm Password') }}</label>

                    <div class="col-md-6">
                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                    </div>
                </div>

                <div class="mb-3">
                    <button type="submit" class="btn btn-primary float-end">
                        Store  Admin
                    </button>
                </div>

                <br />
                <br />
            </form>
        </div>
    </div>
</x-app-layout>

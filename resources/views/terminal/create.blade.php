<x-app-layout>
    <div class="container mt-4">
        <h2>Create Terminal</h2>
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="post" action="{{ route('admin.terminals.store') }}" enctype="multipart/form-data">
            @csrf

            <div class="mb-3">
                <label for="from" class="form-label">From</label>
                <input type="text"
                       class="form-control @error('from') is-invalid @enderror" id="name" name="from" value="{{ old('from') }}" required>
                @error('from')
                <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="mb-3">
                <label for="to" class="form-label">To</label>
                <input type="text" class="form-control @error('to') is-invalid @enderror"
                       id="to" name="to" value="{{ old('to') }}" required>

                @error('to')
                <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">Create Terminal</button>
        </form>
    </div>

</x-app-layout>

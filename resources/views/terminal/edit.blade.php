<x-app-layout>
    <div class="container mt-4">
        <a href="{{ route('admin.terminals.index') }}" class="btn btn-info">
            <- Go Back
        </a>

        <h2 class="text-center">Edit Terminal</h2>
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="mx-auto" style="max-width: 500px">
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <form method="post" action="{{ route('admin.terminals.update', $terminal) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label for="from" class="form-label">From</label>
                    <input type="text"
                           class="form-control @error('from') is-invalid @enderror" id="name" name="from"
                           value="{{ old('from', $terminal->from) }}" required>
                    @error('from')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="to" class="form-label">To</label>
                    <input type="text" class="form-control @error('to') is-invalid @enderror"
                           id="to" name="to" value="{{ old('to', $terminal->to) }}" required>

                    @error('to')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div x-data='{
                    terminalPoints: @if($terminal->transit_points) @json($terminal->transit_points) @else [""] @endif,
                    addTerminalPoint() {
                        this.terminalPoints.push("")
                    },
                    removeTerminalPoint(index) {
                        if (
                            this.terminalPoints[index] != null &&
                            this.terminalPoints[index] != "" &&
                            ! confirm("Are you sure?")
                        ) {
                            return;
                        }
                        this.terminalPoints.splice(index, 1)
                    }
                 }'>
                    <label for="to" class="form-label">Terminal Points</label>
                    <button type="button" class="btn btn-info rounded-pill mb-2"
                            x-on:click="addTerminalPoint()">Add</button>

                    <template x-for="(terminalPoint, index) in terminalPoints">
                        <div class="d-flex">
                            <input type="text" class="form-control mb-2 @error('to') is-invalid @enderror"
                                   id="terminalPoints" name="transit_points[]"
{{--                                   value="{{ old('transit_points') }}"--}}
                                   required
                                   x-model="terminalPoint"
                            />
                            <template x-if="index != 0">
                                <button type="button" class="btn btn-danger mb-2"
                                        x-on:click="removeTerminalPoint(index)">
                                    <i class="bi bi-trash-fill"></i>
                                </button>
                            </template>
                        </div>
                    </template>
                </div>

                <button type="submit" class="btn btn-primary">Edit Terminal</button>
            </form>
        </div>
    </div>

</x-app-layout>

<x-app-layout>
    <div class="container mt-4">
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div class="d-flex justify-content-between align-items-center">
            <h2>Conductors List</h2>
            <a href="{{ route('conductors.create') }}" class="btn btn-success">Create conductor</a>
        </div>

        <table class="table mt-3">
            <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Gender</th>
                <th>Address</th>
                <th>City</th>
                <th>Contact Number</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @forelse($conductors as $conductor)
                <tr>
                    <td>{{ $conductor->id }}</td>
                    <td>{{ $conductor->name }}</td>
                    <td>{{ $conductor->gender }}</td>
                    <td>{{ $conductor->address }}</td>
                    <td>{{ $conductor->city }}</td>
                    <td>{{ $conductor->contact_no }}</td>
                    <td>
                        <a href="{{ route('conductors.show', $conductor->id) }}" class="btn btn-info btn-sm">View</a>
                        <a href="{{ route('conductors.edit', $conductor->id) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form method="post" action="{{ route('conductors.destroy', $conductor->id) }}"
                              style="display:inline">
                            @csrf
                            @method('delete')
                            <button type="submit" class="btn btn-danger btn-sm"
                                    onclick="return confirm('Are you sure?')">Delete
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="9">No conductors found.</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
</x-app-layout>
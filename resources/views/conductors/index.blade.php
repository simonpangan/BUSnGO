<x-app-layout>
    <div class="container mt-4">
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div class="d-flex justify-content-between align-items-center">
            <h2>Conductors List</h2>
            <a href="{{ route('admin.conductors.create') }}" class="btn btn-success">
                Create New Conductor Information
                <i class="bi bi-plus"></i>
            </a>
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
            @foreach($conductors as $conductor)
                <tr>
                    <td>{{ $conductor->id }}</td>
                    <td>{{ $conductor->name }}</td>
                    <td>{{ $conductor->gender }}</td>
                    <td>{{ $conductor->address }}</td>
                    <td>{{ $conductor->city }}</td>
                    <td>{{ $conductor->contact_no }}</td>
                    <td>
                        <a href="{{ route('conductors.show', $conductor->id) }}" class="btn btn-info btn-sm">
                            View
                        </a>
                        <a title="Edit Driver"
                            href="{{ route('admin.conductors.edit', $conductor->id) }}" class="btn btn-warning btn-sm">
                            <i class="bi bi-pencil-square"></i>
                        </a>
                        <form method="post" action="{{ route('admin.conductors.destroy', $conductor->id) }}"
                              style="display:inline">
                            @csrf
                            @method('delete')
                            <button title="Delete Driver" type="submit" class="btn btn-danger btn-sm"
                                    onclick="return confirm('Are you sure?')">
                                <i class="bi bi-trash-fill"></i>
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</x-app-layout>

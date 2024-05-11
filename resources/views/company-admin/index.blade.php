<x-app-layout>
    @section('css')
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.13.8/datatables.min.css"/>
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.dataTables.min.css"/>
    @endsection


    <div class="container mt-4">
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div class="d-flex justify-content-between align-items-center mb-2">
            <h2>Admins</h2>
            <a href="{{ route('company-admin.create') }}" class="btn btn-success">
                Create Bus Admin
                <i class="bi bi-plus"></i>
            </a>
        </div>

        <div>
            <table id="myBuses" class="display table mt-3">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Contact No</th>
                    <th>Email Address</th>
                    <th>Company</th>
                    <th>Created At</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($admins as $admin)
                    <tr>
                        <td>{{ $admin->id }}</td>
                        <td>{{ $admin->name }}</td>
                        <td>{{ $admin->contact_no }}</td>
                        <td>{{ $admin->user->email }}</td>
                        <td>{{ $admin->company->name }}</td>
                        <td>{{ $admin->created_at->format('F jS Y') }}</td>
                        <td>
                            <a href="{{ route('company-admin.edit', $admin) }}" class="btn btn-primary">
                                Edit
                            </a>
                            <form action="{{ route('company-admin.destroy', $admin) }}" method="post" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger" type="submit"
                                        onclick="return confirm('Are you sure you want to delete this Admin?')"
                                >
                                    Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
            </table>
        </div>
    </div>

    @section('javascript')
        <script src="https://cdn.datatables.net/v/dt/dt-1.13.8/datatables.min.js"></script>
        <script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
        <script>
            $(document).ready(function () {
                $('#myBuses').DataTable({
                    responsive: true,
                    "order": []
                })
            });
        </script>
    @endsection
</x-app-layout>

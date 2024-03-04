<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index()
    {
        return view('admin.service.index', [
            'drivers' => Service::latest()->get(),
        ]);
    }

    public function create()
    {
        return view('admin.service.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'bus_id'      => ['required', 'integer'],
            'description' => ['required'],
            'status'      => ['required'],
            'duration'    => ['required'],
        ]);

        Service::create($data);

        return to_route('admin.service.index')
            ->with('success', 'Service created successfully');
    }

    public function edit(Service $service)
    {
        return view('admin.service.edit', [
            'service' => $service,
        ]);
    }

    public function update(Request $request, Service $service)
    {
        $data = $request->validate([
            'bus_id'      => ['required', 'integer'],
            'description' => ['required'],
            'status'      => ['required'],
            'duration'    => ['required'],
        ]);

        $service->update($data);

        return to_route('admin.service.edit', [
            'id' => $service->id
        ])->with('success', 'Service updated successfully');;
    }

    public function destroy(Service $service)
    {
        $service->delete();

        return to_route('admin.service.index')
            ->with('success', 'Service deleted successfully');
    }
}

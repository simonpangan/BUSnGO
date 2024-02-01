<?php

namespace App\Http\Controllers;

use App\Http\Requests\BusRequest;
use App\Models\Bus;
use App\Models\Conductor;
use App\Models\Driver;
use Illuminate\Http\Request;

class BusController extends Controller
{
    public function index()
    {
        return view('bus.index', [
            'buses' => Bus::all()
        ]);
    }

    public function create()
    {
        return view('bus.create', [
            'drivers'    => Driver::all(),
            'conductors' => Conductor::all(),
        ]);
    }

    public function store(Request  $request)
    {
        $values = $request->validate([
            'no'                 => ['required', 'integer'],
            'seat'               => ['required', 'integer'],
            'engine_model'       => ['required', 'max:50'],
            'chassis_no'         => ['required', 'max:50'],
            'model'              => ['required', 'max:50'],
            'color'              => ['required', 'max:50'],
            'register_no'        => ['required', 'max:50'],
            'made_in'            => ['required', 'max:50'],
            'make'               => ['required', 'max:50'],
            'price'              => ['required', 'max:50'],
            'fuel'               => ['required', 'max:50'],
            'engine_capacity'    => ['required', 'max:50'],
            'puchase_year'       => ['required', 'integer'],
            'transmission_model' => ['required', 'max:50'],
            'status'             => ['required', 'max:50'],
            'driver_id'          => ['required', 'integer'],
            'conductor_id'       => ['required', 'integer'],
        ]);

        Bus::create($values);

        return to_route('buses.index')
            ->with('success', 'Bus created successfully.');
    }

    public function show($id)
    {
        return view('bus.show', [
            'bus' => Bus::findOrFail($id)
        ]);
    }

    public function edit(Bus $bus)
    {
        return view('bus.edit', [
            'bus' =>  $bus,
            'drivers'    => Driver::all(),
            'conductors' => Conductor::all(),
        ]);
    }

    public function update(Request $request, Bus $bus)
    {
        $values = $request->validate([
            'no'                 => ['required', 'integer'],
            'seat'               => ['required', 'integer'],
            'engine_model'       => ['required', 'max:50'],
            'chassis_no'         => ['required', 'max:50'],
            'model'              => ['required', 'max:50'],
            'color'              => ['required', 'max:50'],
            'register_no'        => ['required', 'max:50'],
            'made_in'            => ['required', 'max:50'],
            'make'               => ['required', 'max:50'],
            'price'              => ['required', 'max:50'],
            'fuel'               => ['required', 'max:50'],
            'engine_capacity'    => ['required', 'max:50'],
            'puchase_year'       => ['required', 'integer'],
            'transmission_model' => ['required', 'max:50'],
            'status'             => ['required', 'max:50'],
            'driver_id'          => ['required', 'integer'],
            'conductor_id'       => ['required', 'integer'],
        ]);

        $bus->update($values);

        return back()->with('success', 'Bus updated successfully.');
    }

    public function destroy(Bus $bus)
    {
        $bus->delete();

        return to_route('buses.index')
            ->with('success', 'Bus deleted successfully.')
        ;
    }
}

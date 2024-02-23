<?php

namespace App\Http\Controllers;

use App\Http\Requests\BusRequest;
use App\Models\Bus;
use App\Models\Conductor;
use App\Models\Driver;
use Carbon\Carbon;
use Illuminate\Http\Request;

class BusController extends Controller
{
    public function index()
    {
        return view('bus.index', [
            'buses' => Bus::query()
                ->latest()
                ->get()
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
            'seat'               => ['required',
                'integer', 'min: 10', 'max: 100'
            ],
            'engine_model'       => ['required', 'string', 'max:50'],
            'chassis_no'         => ['required', 'string', 'max:50'],
            'model'              => ['required', 'string', 'max:50'],
            'color'              => ['required', 'string', 'max:50'],
            'register_no'        => ['required', 'string', 'max:50'],
            'made_in'            => ['required', 'string', 'max:50'],
            'make'               => ['required', 'string', 'max:50'],
            'price'              => ['required', 'string', 'max:50'],
            'fuel'               => ['required', 'string', 'max:50'],
            'engine_capacity'    => ['required', 'string', 'max:50'],
            'puchase_year'       => [
                'required', 'digits:4',
                'integer', 'min:1990' ,
                'max:'.Carbon::now()->year
            ],
            'transmission_model' => ['required', 'string', 'max:50'],
            'status'             => ['required', 'string', 'max:50'],
        ]);

        Bus::create($values);

        return to_route('admin.buses.index')
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
            'seat'               => ['required',
                'integer', 'min: 10', 'max: 100'
            ],
            'engine_model'       => ['required', 'string', 'max:50'],
            'chassis_no'         => ['required', 'string', 'max:50'],
            'model'              => ['required', 'string', 'max:50'],
            'color'              => ['required', 'string', 'max:50'],
            'register_no'        => ['required', 'string', 'max:50'],
            'made_in'            => ['required', 'string', 'max:50'],
            'make'               => ['required', 'string', 'max:50'],
            'price'              => ['required', 'string', 'max:50'],
            'fuel'               => ['required', 'string', 'max:50'],
            'engine_capacity'    => ['required', 'string', 'max:50'],
            'puchase_year'       => [
                'required', 'digits:4',
                'integer', 'min:1990' ,
                'max:'.Carbon::now()->year
            ],
            'transmission_model' => ['required', 'string', 'max:50'],
            'status'             => ['required', 'string', 'max:50'],
        ]);

        $bus->update($values);

        return back()->with('success', 'Bus updated successfully.');
    }

    public function destroy(Bus $bus)
    {
        $bus->delete();

        return to_route('admin.buses.index')
            ->with('success', 'Bus deleted successfully.')
        ;
    }
}

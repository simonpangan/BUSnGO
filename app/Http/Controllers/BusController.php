<?php

namespace App\Http\Controllers;

use App\Http\Requests\BusRequest;
use App\Models\Bus;
use Illuminate\Http\Request;

class BusController extends Controller
{
    public function index()
    {
        return view('bus.index', [
            'buses' => Bus::all()
        ]);
    }

    public function create(BusRequest $request)
    {
        return Bus::create($request->validated());
    }

    public function edit(Bus $bus)
    {
        return view('bus.edit', compact('bus'));
    }

    public function update(Request $request, Bus $bus)
    {
//        $request->validate([
//            'no'                 => ['required'],
//            'seat'               => ['required', 'integer'],
//            'engine_model'       => ['required'],
//            'chassis_no'         => ['required'],
//            'model'              => ['required'],
//            'color'              => ['required'],
//            'register_no'        => ['required'],
//            'made_in'            => ['required'],
//            'make'               => ['required'],
//            'price'              => ['required'],
//            'fuel'               => ['required'],
//            'engine_capacity'    => ['required'],
//            'puchase_year'       => ['required', 'integer'],
//            'transmission_model' => ['required'],
//            'status'             => ['required'],
//            'driver_id'          => ['required', 'integer'],
//            'conductor_id'       => ['required', 'integer'],
//        ]);
//        $bus->update($request->validated());

//        dd('asd');
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

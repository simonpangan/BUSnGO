<?php

namespace App\Http\Controllers;

use App\Http\Requests\BusRequest;
use App\Models\Bus;

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

    public function show(Bus $bus)
    {
        return $bus;
    }

    public function update(BusRequest $request, Bus $bus)
    {
        $bus->update($request->validated());

        return $bus;
    }

    public function destroy(Bus $bus)
    {
        $bus->delete();

        return response()->json();
    }
}

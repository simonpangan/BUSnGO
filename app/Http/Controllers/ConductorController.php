<?php

namespace App\Http\Controllers;

use App\Models\Conductor;

class ConductorController extends Controller
{
    public function show(Conductor $conductor)
    {
        return view('conductors.show', compact('conductor'));
    }
}

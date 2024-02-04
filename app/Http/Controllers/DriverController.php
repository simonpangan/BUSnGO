<?php

namespace App\Http\Controllers;

use App\Models\Driver;
use Illuminate\Http\Request;

class DriverController extends Controller
{
    public function index()
    {

    }

    public function show(Driver $driver)
    {
        return view('drivers.show', compact('driver'));
    }
}

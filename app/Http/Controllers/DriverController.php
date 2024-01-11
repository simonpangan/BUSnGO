<?php

namespace App\Http\Controllers;

use App\Models\Driver;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class DriverController extends Controller
{
    public function index()
    {
        $drivers = Driver::all();
        return view('drivers.index', compact('drivers'));
    }

    public function create()
    {
        return view('drivers.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:45',
            'gender' => 'required|in:M,F',
            'address' => 'required|max:100',
            'city' => 'required|max:45',
            'contact_no' => 'required|max:45',
//            'question' => 'required|max:400',
//            'answer' => 'required|max:45',
//            'username' => 'required|max:45',
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif',
            // move to user table
            'password' => 'required',
            'email' => 'required|email|unique:users,email',
        ]);

        $user = User::create([
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
        ]);

        $photoPath = $request
            ->file('photo')
            ->store('photos', 'public');

        Driver::create([
            'user_id' => $user->id,
            'name' => $validatedData['name'],
            'gender' => $validatedData['gender'],
            'address' => $validatedData['address'],
            'city' => $validatedData['city'],
            'contact_no' => $validatedData['contact_no'],
            'photo' => $photoPath,
        ]);

        return to_route('drivers.index')
            ->with('success', 'Driver created successfully.');
    }

    public function show(Driver $driver)
    {
        return view('drivers.show', compact('driver'));
    }

    public function edit(Driver $driver)
    {
        return view('drivers.edit', compact('driver'));
    }

    public function update(Request $request, Driver $driver)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:45',
            'gender' => 'required|in:M,F',
            'address' => 'required|max:45',
            'city' => 'required|max:45',
            'contact_no' => 'required|max:45',
            'username' => 'required|max:45',
            'password' => 'required',
            'question' => 'required|max:400',
            'answer' => 'required|max:45',
            'email' => 'required|email|unique:drivers,email,' . $driver->id,
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif',
        ]);

        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('photos', 'public');
            $validatedData['photo'] = $photoPath;
        }

        $driver->update($validatedData);

        return redirect()->route('drivers.index')->with('success', 'Driver updated successfully.');
    }

    public function destroy(Driver $driver)
    {
        $driver->delete();

        return redirect()->route('drivers.index')->with('success', 'Driver deleted successfully.');
    }
}

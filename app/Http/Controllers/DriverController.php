<?php

namespace App\Http\Controllers;

use App\Models\Driver;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules;

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
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif',

            'email' => 'required|email|unique:users,email',
            'password' => ['required', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
        ]);

        //Store Photo in public folder
        $file = $request->file('photo');
        $photoFileName = uniqid() . '-' . now()->timestamp . $file->getClientOriginalName();

        $file->storeAs('public/uploads', $photoFileName);

        Driver::create([
            'user_id' => $user->id,
            'name' => $validatedData['name'],
            'gender' => $validatedData['gender'],
            'address' => $validatedData['address'],
            'city' => $validatedData['city'],
            'contact_no' => $validatedData['contact_no'],
            'photo' => $photoFileName,
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
            'name' => ['required', 'string', 'max:255'],
            'gender' => 'required|in:M,F',
            'address' => 'required|max:45',
            'city' => 'required|max:45',
            'contact_no' => 'required|max:45',
            'email' => ['required', 'email',
                    Rule::unique((new User)->getTable())->ignore($driver->user->id ?? null)
            ],
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif',
        ]);

        $driver->user->update([
            'email' => $validatedData['email'],
        ]);

        $driver->update([
            'name' => $validatedData['name'],
            'gender' => $validatedData['gender'],
            'address' => $validatedData['address'],
            'city' => $validatedData['city'],
            'contact_no' => $validatedData['contact_no'],
        ]);

        if ($request->hasFile('new_photo')) {
            $request->file('new_photo')
                ->storeAs('public/uploads', $driver->photo);
        }

        return redirect()
            ->route('drivers.index')
            ->with('success', 'Driver updated successfully.');
    }

    public function destroy(Driver $driver)
    {
        Storage::disk('public')->delete("/uploads/{$driver->photo}");
        $driver->delete();

        return redirect()->route('drivers.index')
            ->with('success', 'Driver deleted successfully.');
    }
}

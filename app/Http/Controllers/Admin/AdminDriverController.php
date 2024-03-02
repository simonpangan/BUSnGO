<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Driver;
use App\Models\LGU;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules;

class AdminDriverController extends Controller
{
    public function index()
    {
        return view('admin.drivers.index', [
            'drivers' => Driver::latest()->get(),
        ]);
    }

    public function create()
    {
        return view('admin.drivers.create', [
            'LGUs' => LGU::all(),
        ]);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:45',
            'gender' => 'required|in:M,F',
            'address' => 'required|max:100',
            'city' => 'required|max:45',
            'contact_no' => ['required', 'max:45', 'regex:/^(09|\+639)\d{9}$/'],
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif',

            'email' => 'required|email|unique:users,email',
            'password' => ['required', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
        ]);

        $user->assignRole('driver');


        //Store Photo in public folder
        $file = $request->file('photo');
        $photoFileName = uniqid().'-'.now()->timestamp.$file->getClientOriginalName();
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

        return to_route('admin.drivers.index')
            ->with('success', 'Driver created successfully.');
    }

    public function edit(Driver $driver)
    {
        return view('admin.drivers.edit', [
            'LGUs' => LGU::all(),
            'driver' => $driver
        ]);
    }

    public function update(Request $request, Driver $driver)
    {
        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'gender' => 'required|in:M,F',
            'address' => 'required|max:100',
            'city' => 'required|max:45',
            'contact_no' => ['required', 'max:45', 'regex:/^(09|\+639)\d{9}$/'],
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
            //Delete old photo
            Storage::disk('public')->delete("/uploads/{$driver->photo}");

            //Store new_photo in public folder
            $file = $request->file('new_photo');
            $photoFileName = uniqid().'-'.now()->timestamp.$file->getClientOriginalName();
            $file->storeAs('public/uploads', $photoFileName);

            $driver->update([
                'photo' => $photoFileName,
            ]);
        }

        return to_route('admin.drivers.edit', $driver)
            ->with('success', 'Driver updated successfully.');
    }

    public function destroy(Driver $driver)
    {
        Storage::disk('public')->delete("/uploads/{$driver->photo}");
        $driver->delete();

        return redirect()->route('admin.drivers.index')
            ->with('success', 'Driver deleted successfully.');
    }
}

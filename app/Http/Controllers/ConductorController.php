<?php

namespace App\Http\Controllers;

use App\Models\Conductor;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules;

class ConductorController extends Controller
{
    public function index()
    {
        $conductors = Conductor::all();
        return view('conductors.index', compact('conductors'));
    }

    public function create()
    {
        return view('conductors.create');
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

        Conductor::create([
            'user_id' => $user->id,
            'name' => $validatedData['name'],
            'gender' => $validatedData['gender'],
            'address' => $validatedData['address'],
            'city' => $validatedData['city'],
            'contact_no' => $validatedData['contact_no'],
            'photo' => $photoFileName,
        ]);

        return to_route('conductors.index')
            ->with('success', 'Conductor created successfully.');
    }

    public function show(Conductor $conductor)
    {
        return view('conductors.show', compact('conductor'));
    }

    public function edit(Conductor $conductor)
    {
        return view('conductors.edit', compact('conductor'));
    }

    public function update(Request $request, Conductor $conductor)
    {
        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'gender' => 'required|in:M,F',
            'address' => 'required|max:45',
            'city' => 'required|max:45',
            'contact_no' => 'required|max:45',
            'email' => ['required', 'email',
                    Rule::unique((new User)->getTable())->ignore($conductor->user->id ?? null)
            ],
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif',
        ]);

        $conductor->user->update([
            'email' => $validatedData['email'],
        ]);

        $conductor->update([
            'name' => $validatedData['name'],
            'gender' => $validatedData['gender'],
            'address' => $validatedData['address'],
            'city' => $validatedData['city'],
            'contact_no' => $validatedData['contact_no'],
        ]);

        if ($request->hasFile('new_photo')) {
            $request->file('new_photo')
                ->storeAs('public/uploads', $conductor->photo);
        }

        return redirect()
            ->route('conductors.index')
            ->with('success', 'Conductor updated successfully.');
    }

    public function destroy(Conductor $conductor)
    {
        Storage::disk('public')->delete("/uploads/{$conductor->photo}");
        $conductor->delete();

        return redirect()->route('conductors.index')
            ->with('success', 'Conductor deleted successfully.');
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Conductor;
use App\Models\LGU;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules;

class AdminConductorController extends Controller
{
    public function index()
    {
        return view('conductors.index', [
            'conductors' => Conductor::query()
                ->when(Auth::user()->hasRole('bus admin'), function ($query, $search) {
                    return $query->where('company_id', Auth::user()->companyAdmin->company_id);
                })
             ->latest()
             ->get()
        ]);
    }

    public function create()
    {
        return view('conductors.create', [
            'LGUs' => LGU::all(),
        ]);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name'       => 'required|max:45',
            'gender'     => 'required|in:M,F',
            'address'    => 'required|max:100',
            'city'       => 'required|max:45',
            'contact_no' => ['required', 'max:45', 'regex:/^(09|\+639)\d{9}$/'],
            'photo'      => 'required|image|mimes:jpeg,png,jpg,gif',

            'email'    => 'required|email|unique:users,email',
            'password' => ['required', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'email'    => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
        ]);

        $user->assignRole('conductor');

        //Store Photo in public folder
        $file          = $request->file('photo');
        $photoFileName = uniqid().'-'.now()->timestamp.$file->getClientOriginalName();
        $file->storeAs('public/uploads', $photoFileName);

        Conductor::create([
            'company_id' => Auth::user()->companyAdmin->company_id, //Add this line
            'user_id'    => $user->id,
            'name'       => $validatedData['name'],
            'gender'     => $validatedData['gender'],
            'address'    => $validatedData['address'],
            'city'       => $validatedData['city'],
            'contact_no' => $validatedData['contact_no'],
            'photo'      => $photoFileName,
        ]);

        return to_route('admin.conductors.index')
            ->with('success', 'Conductor created successfully.');
    }

    public function edit(Conductor $conductor)
    {
        return view('conductors.edit', [
            'LGUs'      => LGU::all(),
            'conductor' => $conductor,
        ]);
    }

    public function update(Request $request, Conductor $conductor)
    {
        $validatedData = $request->validate([
            'name'       => ['required', 'string', 'max:255'],
            'gender'     => 'required|in:M,F',
            'address'    => 'required|max:100',
            'city'       => 'required|max:45',
            'contact_no' => ['required', 'max:45', 'regex:/^(09|\+639)\d{9}$/'],
            'email'      => [
                'required', 'email',
                Rule::unique((new User)->getTable())->ignore($conductor->user->id ?? null)
            ],
            'photo'      => 'nullable|image|mimes:jpeg,png,jpg,gif',
        ]);

        $conductor->user->update([
            'email' => $validatedData['email'],
        ]);

        $conductor->update([
            'company_id' => Auth::user()->companyAdmin->company_id, //Add this line
            'name'       => $validatedData['name'],
            'gender'     => $validatedData['gender'],
            'address'    => $validatedData['address'],
            'city'       => $validatedData['city'],
            'contact_no' => $validatedData['contact_no'],
        ]);

        if ($request->hasFile('new_photo')) {
            //Delete old photo
            Storage::disk('public')->delete("/uploads/{$conductor->photo}");

            //Generate unique name
            $file          = $request->file('new_photo');
            $photoFileName = uniqid().'-'.now()->timestamp.$file->getClientOriginalName();

            //store the photo in public folder
            $file->storeAs('public/uploads', $photoFileName);

            //Store the path in database
            $conductor->update([
                'photo' => $photoFileName,
            ]);
        }

        return to_route('admin.conductors.edit', [
            'conductor' => $conductor->id,
        ])
            ->with('success', 'Conductor updated successfully.');
    }

    public function destroy(Conductor $conductor)
    {
        Storage::disk('public')->delete("/uploads/{$conductor->photo}");
        $conductor->delete();

        return to_route('admin.conductors.index')
            ->with('success', 'Conductor deleted successfully.');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules;

class PassengerController extends Controller
{
    public function edit()
    {
        return view('passenger.edit', [
            'user' => Auth::user()
        ]);
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255',
                Rule::unique((new User)->getTable())->ignore($user->id ?? null)
            ],
            'password' => [
                'nullable', 'confirmed', Rules\Password::defaults(),
            ],
            'contact_no' => ['required', 'max:45', 'regex:/^(09|\+639)\d{9}$/'],
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'contact_no' => $request->contact_no,
        ]);

        if ($request->password) {
            $user->update([
                'password' => Hash::make($request->password),
            ]);
        }

        return to_route('passenger.show', $user)
            ->with('success', 'Successfully update your profile');
    }
}

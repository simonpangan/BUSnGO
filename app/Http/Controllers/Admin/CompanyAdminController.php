<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\CompanyAdmin;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules;

class CompanyAdminController extends Controller
{
    public function index()
    {
        return view ('company-admin.index',[
            'admins' => CompanyAdmin::all(),
        ]);
    }

    public function create()
    {
        return view ('company-admin.create', [
            'companies' => Company::all(),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'max:45', 'regex:/^(09|\+639)\d{9}$/'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        $user->assignRole('bus admin');

        CompanyAdmin::create([
            'user_id' => $user->id,
            'name' => $request->name,
            'contact_no' => $request->phone,
            'company_id' => $request->company,
        ]);

        return redirect()->route('company-admin.index');
    }

    public function edit(CompanyAdmin $companyAdmin)
    {
        return view ('company-admin.edit', [
            'companies' => Company::all(),
            'admin' => $companyAdmin,
        ]);
    }

    public function update(Request $request, CompanyAdmin $companyAdmin)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'max:45', 'regex:/^(09|\+639)\d{9}$/'],
            'email' => [
                'required', 'string', 'lowercase', 'email', 'max:255',
                Rule::unique((new User)->getTable())->ignore($companyAdmin->user_id ?? null)
            ],
        ]);

        if ($request->password != null) {
            $request->validate([
                'password' => ['required', 'confirmed', Rules\Password::defaults()],
            ]);
        }

        $companyAdmin->update([
            'name' => $request->name,
            'contact_no' => $request->phone,
            'company_id' => $request->company,
        ]);

        $companyAdmin->user->update([
            'email' => $request->email,
        ]);

        if ($request->password != null) {
            $companyAdmin->user->update([
                'password' => bcrypt($request->password),
            ]);
        }

        return redirect()->route('company-admin.index');
    }

    public function destroy(CompanyAdmin $companyAdmin)
    {
        $companyAdmin->delete();

        return redirect()->route('company-admin.index');
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CompanyController extends Controller
{
    public function index()
    {
        return view('company.index', [
            'companies' => Company::all()
        ]);
    }

    public function create()
    {
        return view('company.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'address' => ['required', 'string'],
            'phone' => ['required', 'max:45', 'regex:/^(09|\+639)\d{9}$/'],
            'email_address' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.Company::class],
        ]);

        Company::create([
            'name' => $request->name,
            'address' => $request->address,
            'phone_number' => $request->phone,
            'email_address' => $request->email_address,
        ]);

        return redirect()->route('companies.index');
    }

    public function edit(Company $company)
    {
        return view('company.edit', [
            'company' => $company
        ]);
    }

    public function update(Request $request, Company $company)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'address' => ['required', 'string'],
            'phone' => ['required', 'max:45', 'regex:/^(09|\+639)\d{9}$/'],
            'email_address' => ['required', 'string', 'lowercase', 'email', 'max:255',
                Rule::unique((new Company)->getTable())->ignore($company->id ?? null)
            ],
        ]);

        $company->update([
            'name' => $request->name,
            'address' => $request->address,
            'phone_number' => $request->phone,
            'email_address' => $request->email_address,
        ]);

        return redirect()->route('companies.index');
    }

    public function destroy(Company $company)
    {
        $company->delete();

        return redirect()->route('companies.index');
    }
}

<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Models\Terminal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminTerminalController extends Controller
{
    public function index()
    {
        return view('terminal.index',[
            'terminals' => Terminal::query()
                ->when(Auth::user()->hasRole('bus admin'), function ($query, $search) {
                    return $query->where('company_id', Auth::user()->companyAdmin->company_id);
                })
                ->latest()
                ->get()
        ]);
    }

    public function create()
    {
        return view('terminal.create');
    }

    public function store(Request $request)
    {
        //https://paymongo.help/en/articles/4318573-what-are-the-minimum-and-maximum-transaction-amounts
        $validatedData = $request->validate([
            'from' => 'required|max:45',
            'to' => 'required|max:45',
            'ticket_cost' => 'required|integer|min:1|max:10000',
            'transit_points'  => 'required|array',
            'transit_points.*' => 'required|string|max:45',
        ]);

        Terminal::create($validatedData + ['company_id' => auth()->user()->companyAdmin->company_id]);

        return to_route('admin.terminals.index')
            ->with('success', 'Terminal created successfully.');
    }

    public function edit(Terminal $terminal)
    {
        return view('terminal.edit', compact('terminal'));
    }

    public function update(Request $request, Terminal $terminal)
    {
        $validatedData = $request->validate([
            'from' => 'required|max:45',
            'to' => 'required|max:45',
            'ticket_cost' => 'required|integer|min:1|max:10000',
            'transit_points'  => 'required|array',
            'transit_points.*' => 'required|string|:45',
        ]);

        $terminal->update($validatedData);

        return to_route('admin.terminals.edit', $terminal)
            ->with('success', 'Terminal created successfully.');
    }

    public function destroy(Terminal $terminal)
    {
        $terminal->delete();

        return to_route('admin.terminals.index')
            ->with('success', 'Terminal deleted successfully.');
    }
}

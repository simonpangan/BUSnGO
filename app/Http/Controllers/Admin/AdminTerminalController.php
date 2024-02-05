<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Models\Terminal;
use Illuminate\Http\Request;

class AdminTerminalController extends Controller
{
    public function index()
    {
        return view('terminal.index',[
            'terminals' => Terminal::query()
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
        $validatedData = $request->validate([
            'from' => 'required|max:45',
            'to' => 'required|max:45',
        ]);

        Terminal::create($validatedData);

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
        ]);

        $terminal->update([
            'from' => $validatedData['from'],
            'to' => $validatedData['to'],
        ]);

        return to_route('admin.terminals.index')
            ->with('success', 'Terminal created successfully.');
    }

    public function destroy(Terminal $terminal)
    {
        $terminal->delete();

        return to_route('admin.terminals.index')
            ->with('success', 'Terminal deleted successfully.');
    }
}

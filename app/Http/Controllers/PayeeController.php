<?php

namespace App\Http\Controllers;

use App\Models\Payee;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class PayeeController extends Controller
{
    public function index()
    {
        return view('payees.index', [
            'title'  => 'All Payees',
            'payees' => Payee::orderBy('name')->get(),
        ]);
    }

    public function create()
    {
        return view('payees.create', [
            'title' => 'Add Payee',
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        Payee::create($this->validatePayee($request));

        return redirect()->route('payees.index')->with('success', 'Payee added successfully.');
    }

    public function edit(Payee $payee)
    {
        return view('payees.edit', [
            'title' => 'Edit Payee',
            'payee' => $payee,
        ]);
    }

    public function update(Request $request, Payee $payee): RedirectResponse
    {
        $payee->update($this->validatePayee($request, $payee));

        return redirect()->route('payees.index')->with('success', 'Payee updated successfully.');
    }

    public function destroy(Payee $payee): RedirectResponse
    {
        if ($payee->cheques()->exists()) {
            return redirect()->route('payees.index')
                             ->with('error', 'This payee cannot be deleted because cheques have been issued to them.');
        }

        $payee->delete();

        return redirect()->route('payees.index')->with('success', 'Payee deleted successfully.');
    }

    private function validatePayee(Request $request, ?Payee $payee = null): array
    {
        return $request->validate([
            'name' => [
                'required', 'string', 'max:255',
                'unique:payees,name' . ($payee ? ',' . $payee->id : ''),
            ],
        ]);
    }
}

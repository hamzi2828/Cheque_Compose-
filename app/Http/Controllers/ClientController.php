<?php

namespace App\Http\Controllers;

use App\Models\Bank;
use App\Models\Client;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function index()
    {
        return view('clients.index', [
            'title'   => 'All Companies',
            'clients' => Client::with('banks')->orderBy('company_name')->get(),
        ]);
    }

    public function create()
    {
        return view('clients.create', [
            'title' => 'Add Company',
            'banks' => Bank::orderBy('bank_name')->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validateClient($request);

        $client = Client::create($data);
        $client->banks()->sync($data['bank_ids'] ?? []);

        return redirect()->route('clients.index')->with('success', 'Company added successfully.');
    }

    public function edit(Client $client)
    {
        return view('clients.edit', [
            'title'  => 'Edit Company',
            'client' => $client->load('banks'),
            'banks'  => Bank::orderBy('bank_name')->get(),
        ]);
    }

    public function update(Request $request, Client $client): RedirectResponse
    {
        $data = $this->validateClient($request);

        $client->update($data);
        $client->banks()->sync($data['bank_ids'] ?? []);

        return redirect()->route('clients.index')->with('success', 'Company updated successfully.');
    }

    public function destroy(Client $client): RedirectResponse
    {
        if ($client->cheques()->exists()) {
            return redirect()->route('clients.index')
                             ->with('error', 'This company cannot be deleted because cheques have been issued for it.');
        }

        $client->delete();

        return redirect()->route('clients.index')->with('success', 'Company deleted successfully.');
    }

    private function validateClient(Request $request): array
    {
        return $request->validate([
            'company_name' => ['required', 'string', 'max:255'],
            'contact_no'   => ['nullable', 'string', 'max:64'],
            'address_1'    => ['nullable', 'string', 'max:255'],
            'address_2'    => ['nullable', 'string', 'max:255'],
            'city'         => ['nullable', 'string', 'max:255'],
            'state'        => ['nullable', 'string', 'max:255'],
            'zip_code'     => ['nullable', 'string', 'max:32'],
            'phone'        => ['nullable', 'string', 'max:64'],
            'email'        => ['nullable', 'email', 'max:255'],
            'notes'        => ['nullable', 'string'],
            'bank_ids'     => ['nullable', 'array'],
            'bank_ids.*'   => ['exists:banks,id'],
        ]);
    }
}

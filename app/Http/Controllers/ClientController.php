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
            'title'   => 'All Clients',
            'clients' => Client::with('bank')->orderBy('company_name')->get(),
        ]);
    }

    public function create()
    {
        return view('clients.create', [
            'title' => 'Add Client',
            'banks' => Bank::orderBy('bank_name')->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        Client::create($this->validateClient($request));

        return redirect()->route('clients.index')->with('success', 'Client added successfully.');
    }

    public function edit(Client $client)
    {
        return view('clients.edit', [
            'title'  => 'Edit Client',
            'client' => $client,
            'banks'  => Bank::orderBy('bank_name')->get(),
        ]);
    }

    public function update(Request $request, Client $client): RedirectResponse
    {
        $client->update($this->validateClient($request));

        return redirect()->route('clients.index')->with('success', 'Client updated successfully.');
    }

    public function destroy(Client $client): RedirectResponse
    {
        if ($client->cheques()->exists()) {
            return redirect()->route('clients.index')
                             ->with('error', 'This client cannot be deleted because cheques have been issued for them.');
        }

        $client->delete();

        return redirect()->route('clients.index')->with('success', 'Client deleted successfully.');
    }

    private function validateClient(Request $request): array
    {
        return $request->validate([
            'company_name'        => ['required', 'string', 'max:255'],
            'contact_no'          => ['nullable', 'string', 'max:64'],
            'address_1'           => ['nullable', 'string', 'max:255'],
            'address_2'           => ['nullable', 'string', 'max:255'],
            'city'                => ['nullable', 'string', 'max:255'],
            'state'               => ['nullable', 'string', 'max:255'],
            'zip_code'            => ['nullable', 'string', 'max:32'],
            'phone'               => ['nullable', 'string', 'max:64'],
            'email'               => ['nullable', 'email', 'max:255'],
            'notes'               => ['nullable', 'string'],
            'payee_name'          => ['required', 'string', 'max:255'],
            'bank_id'             => ['nullable', 'exists:banks,id'],
            'bank_account_number' => ['nullable', 'string', 'max:64'],
        ]);
    }
}

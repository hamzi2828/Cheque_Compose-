<?php

namespace App\Http\Controllers;

use App\Models\Bank;
use App\Models\BankChequeSequence;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class BankController extends Controller
{
    public function index()
    {
        return view('banks.index', [
            'title' => 'All Banks',
            'banks' => Bank::with('sequences')->orderBy('bank_name')->get(),
        ]);
    }

    public function create()
    {
        return view('banks.create', [
            'title' => 'Add Bank',
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data      = $this->validateBank($request);
        $sequences = $this->validateSequences($request);

        DB::transaction(function () use ($data, $sequences) {
            $bank = Bank::create($data);

            foreach ($sequences as $row) {
                $bank->sequences()->create([
                    'start_number' => $row['start'],
                    'end_number'   => $row['end'],
                    'next_number'  => $row['start'],
                    'is_active'    => $row['active'],
                ]);
            }
        });

        return redirect()->route('banks.index')->with('success', 'Bank added successfully.');
    }

    public function edit(Bank $bank)
    {
        return view('banks.edit', [
            'title' => 'Edit Bank',
            'bank'  => $bank->load('sequences'),
        ]);
    }

    public function update(Request $request, Bank $bank): RedirectResponse
    {
        $data      = $this->validateBank($request);
        $sequences = $this->validateSequences($request);

        DB::transaction(function () use ($bank, $data, $sequences) {
            $bank->update($data);

            $keptIds = [];

            foreach ($sequences as $row) {
                $existing = $row['id'] ? $bank->sequences()->find($row['id']) : null;

                if ($existing) {
                    $issued = $existing->next_number > $existing->start_number;

                    $existing->update([
                        'start_number' => $row['start'],
                        'end_number'   => $row['end'],
                        'next_number'  => $issued ? max($existing->next_number, $row['start']) : $row['start'],
                        'is_active'    => $row['active'],
                    ]);

                    $keptIds[] = $existing->id;
                } else {
                    $keptIds[] = $bank->sequences()->create([
                        'start_number' => $row['start'],
                        'end_number'   => $row['end'],
                        'next_number'  => $row['start'],
                        'is_active'    => $row['active'],
                    ])->id;
                }
            }

            $bank->sequences()->whereNotIn('id', $keptIds)->delete();
        });

        return redirect()->route('banks.index')->with('success', 'Bank updated successfully.');
    }

    public function destroy(Bank $bank): RedirectResponse
    {
        if ($bank->cheques()->exists()) {
            return redirect()->route('banks.index')
                             ->with('error', 'This bank cannot be deleted because cheques have been issued from it.');
        }

        if ($bank->clients()->exists()) {
            return redirect()->route('banks.index')
                             ->with('error', 'This bank cannot be deleted because clients are linked to it.');
        }

        $bank->delete();

        return redirect()->route('banks.index')->with('success', 'Bank deleted successfully.');
    }

    /**
     * Next auto cheque number for a bank (used by the New Cheque form).
     */
    public function nextChequeNumber(Bank $bank)
    {
        return response()->json([
            'next_number' => $bank->nextChequeNumber(),
        ]);
    }

    private function validateBank(Request $request): array
    {
        return $request->validate([
            'bank_name'      => ['required', 'string', 'max:255'],
            'address_1'      => ['nullable', 'string', 'max:255'],
            'address_2'      => ['nullable', 'string', 'max:255'],
            'city'           => ['nullable', 'string', 'max:255'],
            'state'          => ['nullable', 'string', 'max:255'],
            'zip_code'       => ['nullable', 'string', 'max:32'],
            'phone'          => ['nullable', 'string', 'max:64'],
            'routing_number' => ['required', 'string', 'max:32'],
            'fraction'       => ['nullable', 'string', 'max:64'],
        ]);
    }

    /**
     * Validate the cheque sequence rows. Rules from the spec:
     *  - blank rows are ignored, but a half-filled row is an error
     *  - end must be >= start
     *  - only one row may be ticked active, and it must be a filled row
     */
    private function validateSequences(Request $request): array
    {
        $ids    = $request->input('seq_id', []);
        $starts = $request->input('seq_start', []);
        $ends   = $request->input('seq_end', []);
        $active = $request->input('active_sequence'); // row index (string) or null

        $rows = [];

        foreach ($starts as $i => $start) {
            $start = trim((string) $start);
            $end   = trim((string) ($ends[$i] ?? ''));

            if ($start === '' && $end === '') {
                if ((string) $active === (string) $i) {
                    throw ValidationException::withMessages([
                        'active_sequence' => 'A blank sequence row cannot be marked as active. Enter its start and end numbers first.',
                    ]);
                }
                continue;
            }

            if ($start === '' || $end === '') {
                throw ValidationException::withMessages([
                    'seq_start' => 'Sequence row ' . ($i + 1) . ' must have both a start and an end number.',
                ]);
            }

            if (! ctype_digit($start) || ! ctype_digit($end)) {
                throw ValidationException::withMessages([
                    'seq_start' => 'Sequence row ' . ($i + 1) . ': cheque numbers must be whole numbers.',
                ]);
            }

            if ((int) $end < (int) $start) {
                throw ValidationException::withMessages([
                    'seq_start' => 'Sequence row ' . ($i + 1) . ': the end number must be greater than or equal to the start number.',
                ]);
            }

            $rows[] = [
                'id'     => isset($ids[$i]) && $ids[$i] !== '' ? (int) $ids[$i] : null,
                'start'  => (int) $start,
                'end'    => (int) $end,
                'active' => (string) $active === (string) $i,
            ];
        }

        return $rows;
    }
}

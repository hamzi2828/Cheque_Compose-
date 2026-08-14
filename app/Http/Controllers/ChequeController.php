<?php

namespace App\Http\Controllers;

use App\Models\Bank;
use App\Models\BankChequeSequence;
use App\Models\Cheque;
use App\Models\Client;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Mpdf\Mpdf;

class ChequeController extends Controller
{
    public function index()
    {
        return view('cheques.index', [
            'title'   => 'All Cheques',
            'cheques' => Cheque::with(['client', 'bank'])->latest('id')->get(),
        ]);
    }

    public function create()
    {
        return view('cheques.create', [
            'title'   => 'New Cheque',
            'clients' => Client::orderBy('company_name')->get(),
            'banks'   => Bank::orderBy('bank_name')->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'client_id'   => ['required', 'exists:clients,id'],
            'bank_id'     => ['required', 'exists:banks,id'],
            'cheque_date' => ['required', 'date'],
            'memo'        => ['nullable', 'string', 'max:255'],
            'amount'      => ['required', 'numeric', 'min:0.01', 'max:999999999'],
        ]);

        $cheque = DB::transaction(function () use ($data) {
            $bank = Bank::lockForUpdate()->findOrFail($data['bank_id']);

            // Take the next number from the active sequence; roll over to the
            // next sequence with numbers remaining once it is consumed.
            $sequence = $bank->nextIssuableSequence();

            if (! $sequence) {
                throw ValidationException::withMessages([
                    'bank_id' => 'No cheque numbers are available for this bank. Add or activate a cheque sequence first.',
                ]);
            }

            $sequence = BankChequeSequence::lockForUpdate()->find($sequence->id);

            $number = $sequence->next_number;
            $sequence->next_number = $number + 1;

            if (! $sequence->is_active) {
                // We rolled over from an exhausted sequence — make this one the
                // active sequence and untick the rest.
                $bank->sequences()->where('id', '!=', $sequence->id)->update(['is_active' => false]);
                $sequence->is_active = true;
            }

            $sequence->save();

            return Cheque::create([
                'client_id'               => $data['client_id'],
                'bank_id'                 => $bank->id,
                'bank_cheque_sequence_id' => $sequence->id,
                'cheque_number'           => $number,
                'cheque_date'             => $data['cheque_date'],
                'memo'                    => $data['memo'] ?? null,
                'amount'                  => $data['amount'],
            ]);
        });

        return redirect()->route('cheques.index')
                         ->with('success', 'Cheque #' . $cheque->cheque_number . ' saved successfully.');
    }

    public function destroy(Cheque $cheque): RedirectResponse
    {
        $cheque->delete();

        return redirect()->route('cheques.index')->with('success', 'Cheque deleted successfully.');
    }

    public function pdf(Cheque $cheque)
    {
        $cheque->load(['client.bank', 'bank']);

        $html = view('cheques.pdf', ['cheque' => $cheque])->render();

        $fontDirs = (new \Mpdf\Config\ConfigVariables())->getDefaults()['fontDir'];
        $fontData = (new \Mpdf\Config\FontVariables())->getDefaults()['fontdata'];

        $mpdf = new Mpdf([
            'format'        => 'A4',
            'margin_top'    => 8,
            'margin_bottom' => 8,
            'margin_left'   => 10,
            'margin_right'  => 10,
            'tempDir'       => storage_path('app/mpdf'),
            'fontDir'       => array_merge($fontDirs, [resource_path('fonts')]),
            'fontdata'      => $fontData + [
                // MICR E-13B encoding: A = transit, B = amount, C = on-us, D = dash
                'micrenc' => ['R' => 'micrenc.ttf'],
            ],
        ]);

        $mpdf->WriteHTML($html);

        return response($mpdf->Output('', 'S'), 200, [
            'Content-Type'        => 'application/pdf',
            'Content-Disposition' => 'inline; filename="cheque-' . $cheque->cheque_number . '.pdf"',
        ]);
    }
}

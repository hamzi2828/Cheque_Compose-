<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Cheque extends Model
{
    protected $fillable = [
        'client_id',
        'payee_id',
        'bank_id',
        'bank_cheque_sequence_id',
        'cheque_number',
        'cheque_date',
        'memo',
        'amount',
    ];

    protected $casts = [
        'cheque_date' => 'date',
        'amount'      => 'decimal:2',
    ];

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function payee(): BelongsTo
    {
        return $this->belongsTo(Payee::class);
    }

    public function bank(): BelongsTo
    {
        return $this->belongsTo(Bank::class);
    }

    public function sequence(): BelongsTo
    {
        return $this->belongsTo(BankChequeSequence::class, 'bank_cheque_sequence_id');
    }

    /**
     * "One Hundred Forty Four and 76/100" style amount used on the cheque.
     */
    public function amountInWords(): string
    {
        $dollars = (int) floor((float) $this->amount);
        $cents   = (int) round(((float) $this->amount - $dollars) * 100);

        $formatter = new \NumberFormatter('en_US', \NumberFormatter::SPELLOUT);
        $words     = ucwords(str_replace('-', ' ', $formatter->format($dollars)));

        return sprintf('%s and %02d/100', $words, $cents);
    }
}

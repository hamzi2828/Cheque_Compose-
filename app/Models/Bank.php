<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Bank extends Model
{
    protected $fillable = [
        'bank_name',
        'address_1',
        'address_2',
        'city',
        'state',
        'zip_code',
        'phone',
        'routing_number',
        'fraction',
    ];

    public function sequences(): HasMany
    {
        return $this->hasMany(BankChequeSequence::class)->orderBy('id');
    }

    public function cheques(): HasMany
    {
        return $this->hasMany(Cheque::class);
    }

    public function clients(): HasMany
    {
        return $this->hasMany(Client::class);
    }

    public function activeSequence(): ?BankChequeSequence
    {
        return $this->sequences()->where('is_active', true)->first();
    }

    /**
     * The sequence the next cheque number will come from. If the active
     * sequence is exhausted, fall back to the next sequence (in row order)
     * that still has numbers left.
     */
    public function nextIssuableSequence(): ?BankChequeSequence
    {
        $active = $this->activeSequence();

        if ($active && ! $active->isExhausted()) {
            return $active;
        }

        $query = $this->sequences()->whereColumn('next_number', '<=', 'end_number');

        if ($active) {
            $query->where('id', '>', $active->id);
        }

        return $query->first();
    }

    public function nextChequeNumber(): ?int
    {
        return $this->nextIssuableSequence()?->next_number;
    }

    public function fullAddress(): string
    {
        $cityLine = trim(implode(', ', array_filter([$this->city, $this->state])) . ' ' . $this->zip_code);

        return implode("\n", array_filter([
            $this->address_1,
            $this->address_2,
            $cityLine,
        ]));
    }
}

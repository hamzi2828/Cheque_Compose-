<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BankChequeSequence extends Model
{
    protected $fillable = [
        'bank_id',
        'start_number',
        'end_number',
        'next_number',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function bank(): BelongsTo
    {
        return $this->belongsTo(Bank::class);
    }

    public function isExhausted(): bool
    {
        return $this->next_number > $this->end_number;
    }
}

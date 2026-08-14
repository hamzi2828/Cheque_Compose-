<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Client extends Model
{
    protected $fillable = [
        'company_name',
        'contact_no',
        'address_1',
        'address_2',
        'city',
        'state',
        'zip_code',
        'phone',
        'email',
        'notes',
        'payee_name',
        'bank_id',
        'bank_account_number',
    ];

    public function bank(): BelongsTo
    {
        return $this->belongsTo(Bank::class);
    }

    public function cheques(): HasMany
    {
        return $this->hasMany(Cheque::class);
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

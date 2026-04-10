<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\BelongsToTenant;
use App\Models\Traits\Auditable;
use App\Helpers\NumberToWords;

class Remittance extends Model
{
    use HasFactory, BelongsToTenant, Auditable;

    public function amountInWords()
    {
        return NumberToWords::convert($this->total_amount);
    }

    protected $fillable = [
        'company_id',
        'bank_account_id',
        'type',
        'remittance_date',
        'total_amount',
        'reference',
        'status'
    ];

    public function bankAccount()
    {
        return $this->belongsTo(BankAccount::class);
    }

    public function cheques()
    {
        return $this->hasMany(IncomingCheque::class);
    }
}

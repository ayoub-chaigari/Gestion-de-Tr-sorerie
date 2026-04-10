<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\BelongsToTenant;
use App\Models\Traits\Auditable;

class InvoicePayment extends Model
{
    use HasFactory, BelongsToTenant, Auditable;

    protected $fillable = [
        'invoice_id',
        'method',
        'amount',
        'payment_date',
        'payable_id',
        'payable_type',
        'notes',
    ];

    protected $casts = [
        'payment_date' => 'date',
        'amount' => 'decimal:2',
    ];

    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }

    /**
     * Get the associated Cheque or Effet.
     */
    public function payable()
    {
        return $this->morphTo();
    }
}

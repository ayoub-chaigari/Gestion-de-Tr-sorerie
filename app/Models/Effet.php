<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\BelongsToTenant;

class Effet extends Model
{
    use HasFactory, BelongsToTenant;

    protected $fillable = [
        'company_id',
        'supplier_id',
        'amount',
        'effet_number',
        'due_date',
        'status',
        'notes',
    ];

    protected $casts = [
        'due_date' => 'date',
        'amount' => 'decimal:2',
    ];

    public function supplier()
    {
        return $this->belongsTo(Contact::class, 'supplier_id');
    }

    public function payments()
    {
        return $this->morphMany(InvoicePayment::class, 'payable');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChequePayment extends Model
{
    use HasFactory;

    protected $fillable = ['incoming_cheque_id', 'invoice_id', 'amount'];

    public function cheque()
    {
        return $this->belongsTo(IncomingCheque::class, 'incoming_cheque_id');
    }

    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }
}

<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\BelongsToTenant;
use App\Models\Traits\Auditable;

class OutgoingCheque extends Model {
    use HasFactory, BelongsToTenant, Auditable;
    protected $fillable = ['company_id', 'contact_id', 'cheque_book_id', 'invoice_id', 'cheque_number', 'amount', 'due_date', 'status'];

    protected $casts = [
        'due_date' => 'date',
        'amount' => 'decimal:2',
    ];
    public function contact() { return $this->belongsTo(Contact::class); }
    public function chequeBook() { return $this->belongsTo(ChequeBook::class); }
    public function invoice() { return $this->belongsTo(Invoice::class); }
}
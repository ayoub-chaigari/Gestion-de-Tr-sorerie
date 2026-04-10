<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\BelongsToTenant;
use App\Models\Traits\Auditable;

class IncomingCheque extends Model {
    use HasFactory, BelongsToTenant, Auditable;
    protected $fillable = [
        'company_id', 'contact_id', 'amount', 'remaining_amount', 'cheque_number', 'bank_name',
        'is_effect', 'status', 'due_date', 'bank_account_id',
        'remittance_id', 'endorsed_to_contact_id', 'invoice_id'
    ];

    protected $casts = [
        'due_date' => 'date',
        'amount' => 'decimal:2',
        'remaining_amount' => 'decimal:2',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($cheque) {
            if ($cheque->remaining_amount === null) {
                $cheque->remaining_amount = $cheque->amount;
            }
        });
    }

    public function contact()          { return $this->belongsTo(Contact::class); }
    public function bankAccount()      { return $this->belongsTo(BankAccount::class); }
    public function remittance()       { return $this->belongsTo(Remittance::class); }
    public function endorsedTo()       { return $this->belongsTo(Contact::class, 'endorsed_to_contact_id'); }
    public function invoice()          { return $this->belongsTo(Invoice::class); }
    public function payments()         { return $this->hasMany(ChequePayment::class, 'incoming_cheque_id'); }
}
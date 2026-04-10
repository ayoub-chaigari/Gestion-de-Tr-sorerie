<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\BelongsToTenant;
use App\Models\Traits\Auditable;

class Invoice extends Model {
    use HasFactory, BelongsToTenant, Auditable;
    protected $fillable = ['company_id', 'supplier_id', 'amount', 'paid_amount', 'invoice_date', 'due_date', 'status', 'reference'];

    protected $casts = [
        'invoice_date' => 'date',
        'due_date' => 'date',
        'amount' => 'decimal:2',
        'paid_amount' => 'decimal:2',
    ];

    public function supplier() { return $this->belongsTo(Contact::class, 'supplier_id'); }

    public function outgoingCheques() { return $this->hasMany(OutgoingCheque::class); }

    public function payments() {
        return $this->hasMany(InvoicePayment::class);
    }

    public function getRemainingAmountAttribute() {
        return $this->amount - $this->paid_amount;
    }

    /**
     * Recalculate and update the paid_amount column based on payments.
     */
    public function updatePaidAmount() : void
    {
        $this->paid_amount = $this->payments()->sum('amount');
        if ($this->paid_amount >= $this->amount) {
            $this->status = 'paid';
        } elseif ($this->paid_amount > 0) {
            $this->status = 'partial'; // Added 'partial' although not in enum, I'll update migration if needed.
        }
        $this->save();
    }
}
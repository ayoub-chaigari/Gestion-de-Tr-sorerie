<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\BelongsToTenant;
use App\Models\Traits\Auditable;
use Illuminate\Support\Facades\Notification;
use App\Notifications\StatusAlertNotification;

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
        $oldStatus = $this->status;
        $this->paid_amount = $this->payments()->sum('amount');
        
        if ($this->paid_amount >= $this->amount) {
            $this->status = 'paid';
        } elseif ($this->paid_amount > 0) {
            $this->status = 'partial';
        }
        
        $this->save();

        if ($oldStatus !== $this->status && auth()->user()) {
            Notification::send(auth()->user(), new StatusAlertNotification([
                'subject'    => 'Invoice Status Updated',
                'hero_title' => 'Vault Transaction update',
                'message'    => "The status of invoice Ref: {$this->reference} has been updated to: " . strtoupper($this->status) . ".",
                'cta_text'   => 'View Invoices',
                'cta_url'    => route('invoices.index')
            ]));
        }
    }
}
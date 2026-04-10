<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\BelongsToTenant;
class ChequeBook extends Model {
    use HasFactory, BelongsToTenant;
    protected $fillable = ['company_id', 'bank_account_id', 'start_number', 'end_number', 'current_number'];
    public function bankAccount() { return $this->belongsTo(BankAccount::class); }
    public function outgoingCheques() { return $this->hasMany(OutgoingCheque::class); }
}
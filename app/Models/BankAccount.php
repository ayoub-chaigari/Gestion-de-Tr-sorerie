<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\BelongsToTenant;
class BankAccount extends Model {
    use HasFactory, BelongsToTenant;
    protected $fillable = ['company_id', 'bank_name', 'agency', 'rib', 'logo_path'];
    public function chequeBooks() { return $this->hasMany(ChequeBook::class); }
}
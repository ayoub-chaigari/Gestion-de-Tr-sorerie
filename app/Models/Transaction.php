<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\BelongsToTenant;
class Transaction extends Model {
    use HasFactory, BelongsToTenant;
    protected $fillable = ['company_id', 'type', 'amount', 'reference_id', 'reference_type'];
}
<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\BelongsToTenant;
class Rejection extends Model {
    use HasFactory, BelongsToTenant;
    protected $fillable = ['company_id', 'cheque_id', 'type', 'reason', 'resolved', 'sent_to_litigation'];

    public function cheque()
    {
        return $this->belongsTo(IncomingCheque::class, 'cheque_id');
    }
}
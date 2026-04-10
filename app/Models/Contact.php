<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\BelongsToTenant;
use App\Models\Traits\Auditable;

class Contact extends Model {
    use HasFactory, BelongsToTenant, Auditable;
    protected $fillable = ['company_id', 'type', 'name', 'phone', 'address', 'ice', 'if', 'rc'];
}
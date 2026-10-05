<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SupportTicket extends Model
{
    protected $fillable = ['company_id', 'user_id', 'subject', 'status'];

    public function company() { return $this->belongsTo(Company::class); }
    public function creator() { return $this->belongsTo(User::class, 'user_id'); }
    public function messages() { return $this->hasMany(SupportMessage::class); }
}

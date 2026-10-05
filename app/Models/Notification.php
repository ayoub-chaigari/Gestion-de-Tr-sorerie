<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $fillable = ['company_id', 'user_id', 'type', 'title', 'message', 'link', 'is_read'];

    protected $casts = [
        'is_read' => 'boolean',
    ];

    protected $appends = ['created_at_human'];

    public function getCreatedAtHumanAttribute()
    {
        return $this->created_at->diffForHumans();
    }

    public function company() { return $this->belongsTo(Company::class); }
    public function user() { return $this->belongsTo(User::class); }
}

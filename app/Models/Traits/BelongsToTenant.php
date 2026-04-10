<?php
namespace App\Models\Traits;
use App\Models\Scopes\TenantScope;
use App\Models\Company;
trait BelongsToTenant {
    protected static function booted() {
        static::addGlobalScope(new TenantScope);
        static::creating(function ($model) {
            if (auth()->check() && ! $model->company_id) {
                $model->company_id = auth()->user()->company_id;
            }
        });
    }
    public function company() {
        return $this->belongsTo(Company::class);
    }
}
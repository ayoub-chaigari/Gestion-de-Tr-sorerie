<?php

namespace App\Models\Traits;

use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;

trait Auditable
{
    /**
     * Boot the Auditable trait for a model.
     * Registers eloquent lifecycle hooks to capture changes transparently.
     */
    public static function bootAuditable()
    {
        static::created(function ($model) {
            $model->logActivity('created', null, $model->getAttributes());
        });

        static::updated(function ($model) {
            $oldValues = array_intersect_key($model->getOriginal(), $model->getDirty());
            $newValues = $model->getDirty();
            
            // Log only if there are actual changes
            if (!empty($newValues)) {
                $model->logActivity('updated', $oldValues, $newValues);
            }
        });

        static::deleted(function ($model) {
            $model->logActivity('deleted', $model->getAttributes(), null);
        });
    }

    /**
     * Log the activity to the database.
     */
    protected function logActivity($action, $oldValues = null, $newValues = null)
    {
        if (!Auth::check()) {
            return; // Only log authenticated actions
        }

        $user = Auth::user();

        ActivityLog::create([
            'company_id' => $this->company_id ?? $user->company_id, // Fallback if model doesn't have company_id
            'user_id'    => $user->id,
            'action'     => $action,
            'model_type' => get_class($this),
            'model_id'   => $this->id,
            'old_values' => $oldValues,
            'new_values' => $newValues,
            'ip_address' => request()->ip(),
        ]);
    }
}

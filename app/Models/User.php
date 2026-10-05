<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Traits\Auditable;
use Illuminate\Contracts\Auth\MustVerifyEmail;

class User extends Authenticatable implements MustVerifyEmail {
    use HasApiTokens, HasFactory, Notifiable, Auditable;
    protected $fillable = [
        'company_id', 
        'name', 
        'email', 
        'password', 
        'role', 
        'permissions', 
        'status',
        'first_name',
        'last_name',
        'gender',
        'phone_number',
        'date_of_birth',
        'address',
        'location',
        'postal_code',
        'profile_picture'
    ];
    protected $hidden = ['password', 'remember_token'];
    protected function casts(): array { return ['email_verified_at' => 'datetime', 'password' => 'hashed', 'permissions' => 'array']; }
    public function company() { return $this->belongsTo(Company::class); }
    
    public function sendEmailVerificationNotification()
    {
        $this->notify(new \App\Notifications\QueuedVerifyEmail);
    }

    public function hasPermission($module, $action): bool
    {
        if ($this->role === 'SUPER_ADMIN' || $this->role === 'ADMIN') {
            return true;
        }

        return isset($this->permissions[$module]) && in_array($action, $this->permissions[$module]);
    }

    /**
     * Determine the best landing page for the user based on their permissions.
     */
    public function getHomeRoute(): string
    {
        // If the company is suspended, always land on Support
        if ($this->role !== 'SUPER_ADMIN' && $this->company_id) {
            $company = $this->company;
            if ($company && $company->status !== 'active') {
                return 'support.index';
            }
        }

        if ($this->role === 'SUPER_ADMIN') {
            return 'superadmin.dashboard';
        }

        if ($this->hasPermission('dashboard', 'view')) {
            return 'dashboard';
        }

        $modules = [
            'contacts' => 'contacts.index',
            'invoices' => 'invoices.index',
            'cheques' => 'cheques.index',
            'remittances' => 'remittances.index',
            'rejections' => 'rejections.index',
        ];

        foreach ($modules as $module => $route) {
            if ($this->hasPermission($module, 'view')) {
                return $route;
            }
        }

        // Fallback for users with NO permissions (should not happen in practice)
        return 'login';
    }
}
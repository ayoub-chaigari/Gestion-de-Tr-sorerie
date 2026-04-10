<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
class User extends Authenticatable {
    use HasApiTokens, HasFactory, Notifiable;
    protected $fillable = ['company_id', 'name', 'email', 'password', 'role', 'permissions'];
    protected $hidden = ['password', 'remember_token'];
    protected function casts(): array { return ['email_verified_at' => 'datetime', 'password' => 'hashed', 'permissions' => 'array']; }
    public function company() { return $this->belongsTo(Company::class); }

    public function hasPermission($module, $action): bool
    {
        if ($this->role === 'SUPER_ADMIN' || $this->role === 'ADMIN') {
            return true;
        }

        return isset($this->permissions[$module]) && in_array($action, $this->permissions[$module]);
    }
}
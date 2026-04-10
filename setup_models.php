<?php

$dir = __DIR__ . '/app/Models';
if (!is_dir("$dir/Scopes")) mkdir("$dir/Scopes");
if (!is_dir("$dir/Traits")) mkdir("$dir/Traits");

file_put_contents("$dir/Scopes/TenantScope.php", <<<PHP
<?php
namespace App\Models\Scopes;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Support\Facades\Auth;
class TenantScope implements Scope {
    public function apply(Builder \$builder, Model \$model) {
        if (Auth::check() && Auth::user()->company_id) {
            \$builder->where(\$model->getTable() . '.company_id', Auth::user()->company_id);
        }
    }
}
PHP);

file_put_contents("$dir/Traits/BelongsToTenant.php", <<<PHP
<?php
namespace App\Models\Traits;
use App\Models\Scopes\TenantScope;
use App\Models\Company;
trait BelongsToTenant {
    protected static function booted() {
        static::addGlobalScope(new TenantScope);
        static::creating(function (\$model) {
            if (auth()->check() && ! \$model->company_id) {
                \$model->company_id = auth()->user()->company_id;
            }
        });
    }
    public function company() {
        return \$this->belongsTo(Company::class);
    }
}
PHP);

file_put_contents("$dir/Company.php", <<<PHP
<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Company extends Model {
    use HasFactory;
    protected \$fillable = ['name', 'status'];
    public function users() { return \$this->hasMany(User::class); }
}
PHP);

file_put_contents("$dir/User.php", <<<PHP
<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
class User extends Authenticatable {
    use HasApiTokens, HasFactory, Notifiable;
    protected \$fillable = ['company_id', 'name', 'email', 'password', 'role'];
    protected \$hidden = ['password', 'remember_token'];
    protected function casts(): array { return ['email_verified_at' => 'datetime', 'password' => 'hashed']; }
    public function company() { return \$this->belongsTo(Company::class); }
}
PHP);

file_put_contents("$dir/Contact.php", <<<PHP
<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\BelongsToTenant;
class Contact extends Model {
    use HasFactory, BelongsToTenant;
    protected \$fillable = ['company_id', 'type', 'name', 'phone', 'address', 'ice', 'if', 'rc'];
}
PHP);

file_put_contents("$dir/BankAccount.php", <<<PHP
<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\BelongsToTenant;
class BankAccount extends Model {
    use HasFactory, BelongsToTenant;
    protected \$fillable = ['company_id', 'bank_name', 'agency', 'rib'];
    public function chequeBooks() { return \$this->hasMany(ChequeBook::class); }
}
PHP);

file_put_contents("$dir/ChequeBook.php", <<<PHP
<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\BelongsToTenant;
class ChequeBook extends Model {
    use HasFactory, BelongsToTenant;
    protected \$fillable = ['company_id', 'bank_account_id', 'start_number', 'end_number', 'current_number'];
    public function bankAccount() { return \$this->belongsTo(BankAccount::class); }
    public function outgoingCheques() { return \$this->hasMany(OutgoingCheque::class); }
}
PHP);

file_put_contents("$dir/IncomingCheque.php", <<<PHP
<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\BelongsToTenant;
class IncomingCheque extends Model {
    use HasFactory, BelongsToTenant;
    protected \$fillable = ['company_id', 'contact_id', 'amount', 'cheque_number', 'status', 'due_date', 'bank_account_id'];
    public function contact() { return \$this->belongsTo(Contact::class); }
    public function bankAccount() { return \$this->belongsTo(BankAccount::class); }
}
PHP);

file_put_contents("$dir/OutgoingCheque.php", <<<PHP
<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\BelongsToTenant;
class OutgoingCheque extends Model {
    use HasFactory, BelongsToTenant;
    protected \$fillable = ['company_id', 'contact_id', 'cheque_book_id', 'cheque_number', 'amount', 'status'];
    public function contact() { return \$this->belongsTo(Contact::class); }
    public function chequeBook() { return \$this->belongsTo(ChequeBook::class); }
}
PHP);

file_put_contents("$dir/Invoice.php", <<<PHP
<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\BelongsToTenant;
class Invoice extends Model {
    use HasFactory, BelongsToTenant;
    protected \$fillable = ['company_id', 'supplier_id', 'amount', 'invoice_date', 'due_date', 'status'];
    public function supplier() { return \$this->belongsTo(Contact::class, 'supplier_id'); }
}
PHP);

file_put_contents("$dir/Rejection.php", <<<PHP
<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\BelongsToTenant;
class Rejection extends Model {
    use HasFactory, BelongsToTenant;
    protected \$fillable = ['company_id', 'cheque_id', 'type', 'reason', 'resolved', 'sent_to_litigation'];
}
PHP);

file_put_contents("$dir/Transaction.php", <<<PHP
<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\BelongsToTenant;
class Transaction extends Model {
    use HasFactory, BelongsToTenant;
    protected \$fillable = ['company_id', 'type', 'amount', 'reference_id', 'reference_type'];
}
PHP);

echo "Models generated.\n";

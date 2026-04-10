<?php

$migrationsDir = __DIR__ . '/database/migrations/';
$migrations = glob($migrationsDir . '*.php');

$mappings = [
    'users' => [
        'up' => <<<EOT
        Schema::create('users', function (Blueprint \$table) {
            \$table->id();
            \$table->foreignId('company_id')->nullable()->constrained('companies')->onDelete('cascade');
            \$table->string('name');
            \$table->string('email')->unique();
            \$table->timestamp('email_verified_at')->nullable();
            \$table->string('password');
            \$table->enum('role', ['SUPER_ADMIN', 'ADMIN', 'ACCOUNTANT'])->default('ADMIN');
            \$table->rememberToken();
            \$table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint \$table) {
            \$table->string('email')->primary();
            \$table->string('token');
            \$table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint \$table) {
            \$table->string('id')->primary();
            \$table->foreignId('user_id')->nullable()->index();
            \$table->string('ip_address', 45)->nullable();
            \$table->text('user_agent')->nullable();
            \$table->longText('payload');
            \$table->integer('last_activity')->index();
        });
EOT
    ],
    'companies' => [
        'up' => <<<EOT
        Schema::create('companies', function (Blueprint \$table) {
            \$table->id();
            \$table->string('name');
            \$table->enum('status', ['active', 'suspended'])->default('active');
            \$table->timestamps();
        });
EOT
    ],
    'contacts' => [
        'up' => <<<EOT
        Schema::create('contacts', function (Blueprint \$table) {
            \$table->id();
            \$table->foreignId('company_id')->constrained()->onDelete('cascade');
            \$table->enum('type', ['client', 'supplier']);
            \$table->string('name');
            \$table->string('phone')->nullable();
            \$table->string('address')->nullable();
            \$table->string('ice', 15)->nullable();
            \$table->string('if', 9)->nullable();
            \$table->string('rc')->nullable();
            \$table->timestamps();
        });
EOT
    ],
    'bank_accounts' => [
        'up' => <<<EOT
        Schema::create('bank_accounts', function (Blueprint \$table) {
            \$table->id();
            \$table->foreignId('company_id')->constrained()->onDelete('cascade');
            \$table->string('bank_name');
            \$table->string('agency')->nullable();
            \$table->string('rib', 24);
            \$table->timestamps();
        });
EOT
    ],
    'cheque_books' => [
        'up' => <<<EOT
        Schema::create('cheque_books', function (Blueprint \$table) {
            \$table->id();
            \$table->foreignId('company_id')->constrained()->onDelete('cascade');
            \$table->foreignId('bank_account_id')->constrained()->onDelete('cascade');
            \$table->integer('start_number');
            \$table->integer('end_number');
            \$table->integer('current_number');
            \$table->timestamps();
        });
EOT
    ],
    'incoming_cheques' => [
        'up' => <<<EOT
        Schema::create('incoming_cheques', function (Blueprint \$table) {
            \$table->id();
            \$table->foreignId('company_id')->constrained()->onDelete('cascade');
            \$table->foreignId('contact_id')->constrained('contacts')->onDelete('cascade');
            \$table->decimal('amount', 15, 2);
            \$table->string('cheque_number');
            \$table->enum('status', ['pending', 'deposited', 'paid', 'unpaid', 'endorsed'])->default('pending');
            \$table->date('due_date');
            \$table->foreignId('bank_account_id')->nullable()->constrained()->onDelete('set null');
            \$table->timestamps();
        });
EOT
    ],
    'outgoing_cheques' => [
        'up' => <<<EOT
        Schema::create('outgoing_cheques', function (Blueprint \$table) {
            \$table->id();
            \$table->foreignId('company_id')->constrained()->onDelete('cascade');
            \$table->foreignId('contact_id')->constrained('contacts')->onDelete('cascade');
            \$table->foreignId('cheque_book_id')->constrained()->onDelete('cascade');
            \$table->string('cheque_number');
            \$table->decimal('amount', 15, 2);
            \$table->enum('status', ['pending', 'paid', 'unpaid'])->default('pending');
            \$table->timestamps();
        });
EOT
    ],
    'invoices' => [
        'up' => <<<EOT
        Schema::create('invoices', function (Blueprint \$table) {
            \$table->id();
            \$table->foreignId('company_id')->constrained()->onDelete('cascade');
            \$table->foreignId('supplier_id')->constrained('contacts')->onDelete('cascade');
            \$table->decimal('amount', 15, 2);
            \$table->date('invoice_date');
            \$table->date('due_date');
            \$table->enum('status', ['pending', 'paid', 'overdue'])->default('pending');
            \$table->timestamps();
        });
EOT
    ],
    'rejections' => [
        'up' => <<<EOT
        Schema::create('rejections', function (Blueprint \$table) {
            \$table->id();
            \$table->foreignId('company_id')->constrained()->onDelete('cascade');
            \$table->unsignedBigInteger('cheque_id'); // Can be incoming or outgoing
            \$table->enum('type', ['incoming', 'outgoing']);
            \$table->string('reason');
            \$table->boolean('resolved')->default(false);
            \$table->boolean('sent_to_litigation')->default(false);
            \$table->timestamps();
        });
EOT
    ],
    'transactions' => [
        'up' => <<<EOT
        Schema::create('transactions', function (Blueprint \$table) {
            \$table->id();
            \$table->foreignId('company_id')->constrained()->onDelete('cascade');
            \$table->enum('type', ['income', 'expense']);
            \$table->decimal('amount', 15, 2);
            \$table->unsignedBigInteger('reference_id')->nullable();
            \$table->string('reference_type')->nullable(); // Polymorphic
            \$table->timestamps();
        });
EOT
    ],
];

foreach ($migrations as $migration) {
    foreach ($mappings as $table => $data) {
        if (str_contains(basename($migration), "create_{$table}_table")) {
            $content = file_get_contents($migration);
            
            // Overwrite up method block
            $upCode = "public function up(): void\n    {\n" . $data['up'] . "\n    }";
            // regex to match public function up() { ... } safely
            $content = preg_replace('/public function up\(\): void\s*\{(.*?)\n    \}/s', $upCode, $content);
            file_put_contents($migration, $content);
            echo "Updated {$table}\n";
        }
    }
}
echo "Migrations patched.\n";


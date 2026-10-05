<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Invoice;
use App\Models\User;
use App\Notifications\ComplianceAlertNotification;
use Illuminate\Support\Facades\Notification;
use Carbon\Carbon;

class SendComplianceAlerts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'invoices:send-compliance-alerts {--test-email= : Send a test email to this address}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send compliance alert emails for invoices due tomorrow';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        if ($this->option('test-email')) {
            $this->sendTestEmail();
            return;
        }

        $tomorrow = Carbon::tomorrow()->toDateString();
        
        $invoices = Invoice::where('status', '!=', 'paid')
            ->whereDate('due_date', $tomorrow)
            ->whereNull('compliance_alert_sent_at')
            ->get();

        if ($invoices->isEmpty()) {
            $this->info('No invoices found due tomorrow that require alerts.');
            return;
        }

        $this->info("Found {$invoices->count()} invoices due tomorrow. Sending alerts...");

        foreach ($invoices as $invoice) {
            // Usually, we notify the company admins. 
            // For this implementation, we will notify all active company users associated with the invoice.
            $users = User::where('company_id', $invoice->company_id)->get();

            if ($users->isNotEmpty()) {
                Notification::send($users, new ComplianceAlertNotification($invoice));
                
                $invoice->update([
                    'compliance_alert_sent_at' => now()
                ]);

                $this->line("Alert sent for Invoice #{$invoice->reference}");
            }
        }

        $this->info('Compliance alerts sent successfully.');
    }

    protected function sendTestEmail()
    {
        $email = $this->option('test-email');
        $this->info("Sending test compliance alert to {$email}...");

        // Create a dummy invoice for testing purposes
        $invoice = new Invoice([
            'reference' => 'TEST-001',
            'amount' => 2450000.00,
            'paid_amount' => 0,
            'due_date' => Carbon::tomorrow(),
        ]);
        $invoice->id = 999; // Mock ID

        $fakeUser = new User(['email' => $email, 'name' => 'Tester']);
        
        Notification::send($fakeUser, new ComplianceAlertNotification($invoice));
        
        $this->info('Test email dispatched.');
    }
}

<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Invoice;

class ComplianceAlertNotification extends Notification
{
    use Queueable;

    protected $invoice;

    /**
     * Create a new notification instance.
     */
    public function __construct(Invoice $invoice)
    {
        $this->invoice = $invoice;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $daysRemaining = round(now()->diffInDays($this->invoice->due_date, false));
        $maturityStatus = $daysRemaining < 0 
            ? "Overdue by " . abs($daysRemaining) . "d" 
            : "Expiring in " . ($daysRemaining == 0 ? "24h" : $daysRemaining . "d");

        return (new MailMessage)
            ->subject('Critical Compliance Alert: Invoice ' . $this->invoice->reference)
            ->view('emails.layouts.compliance', [
                'volume_label'    => 'Pending Invoice Amount',
                'volume_value'    => number_format($this->invoice->remaining_amount, 2, '.', ','),
                'maturity_status' => $maturityStatus,
                'cta_url'         => route('invoices.show', $this->invoice->id)
            ]);
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'invoice_id' => $this->invoice->id,
            'amount' => $this->invoice->remaining_amount,
            'reference' => $this->invoice->reference,
        ];
    }
}

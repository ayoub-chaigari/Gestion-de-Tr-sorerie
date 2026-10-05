<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class StatusAlertNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $details;

    /**
     * Create a new notification instance.
     */
    public function __construct(array $details)
    {
        $this->details = $details;
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
        return (new MailMessage)
            ->subject('Sovereign Alert: ' . $this->details['subject'])
            ->view('emails.status_alert', [
                'hero_title' => $this->details['hero_title'] ?? 'Elite Circle Alert',
                'email_body' => $this->details['message'],
                'cta_text'  => $this->details['cta_text'] ?? 'Open Vault',
                'cta_url'   => $this->details['cta_url'] ?? url('/'),
            ]);
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return $this->details;
    }
}

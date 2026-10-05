<?php

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

require __DIR__.'/../vendor/autoload.php';
$app = require __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

try {
    echo "Attempting to send test email...\n";
    Mail::raw('This is a test email from Sovereign Pay using Brevo SMTP.', function ($message) {
        $message->to('ayoubchaigari355@gmail.com')
                ->subject('Test Email');
    });
    echo "Test email sent successfully!\n";
} catch (\Exception $e) {
    echo "Failed to send email!\n";
    echo "Error: " . $e->getMessage() . "\n";
}

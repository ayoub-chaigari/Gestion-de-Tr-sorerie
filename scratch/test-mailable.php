<?php

use Illuminate\Support\Facades\Mail;
use App\Mail\ContactMessage;

require __DIR__.'/../vendor/autoload.php';
$app = require __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

try {
    echo "Attempting to send ContactMessage Mailable...\n";
    $data = [
        'name' => 'Ayoub',
        'email' => 'ayoubchaigari355@gmail.com',
        'company' => 'Sovereign Test',
        'message' => 'Hello, this is a test message from the mailable class.'
    ];
    
    Mail::to('ayoubchaigari355@gmail.com')->send(new ContactMessage($data));
    echo "Mailable sent successfully!\n";
} catch (\Exception $e) {
    echo "Failed to send mailable!\n";
    echo "Error: " . $e->getMessage() . "\n";
}

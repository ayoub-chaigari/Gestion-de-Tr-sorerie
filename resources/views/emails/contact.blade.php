<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #eee; border-radius: 10px; }
        .header { background: #006C4A; color: white; padding: 20px; text-align: center; border-radius: 10px 10px 0 0; }
        .content { padding: 20px; }
        .footer { font-size: 12px; color: #777; margin-top: 30px; border-top: 1px solid #eee; padding-top: 20px; }
        .compliance { font-weight: bold; color: #006C4A; margin-top: 20px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>New Contact Inquiry</h1>
        </div>
        <div class="content">
            <p><strong>Name:</strong> {{ $data['name'] }}</p>
            <p><strong>Email:</strong> {{ $data['email'] }}</p>
            <p><strong>Company:</strong> {{ $data['company'] ?? 'N/A' }}</p>
            <p><strong>Message:</strong></p>
            <p>{{ $data['message'] }}</p>
        </div>
        <div class="footer">
            <p>This message was sent from the Sovereign Pay contact form.</p>
            <p class="compliance">
                Compliance Updates: Stay informed on BAM regulations and Law 69-21 mandates.
            </p>
        </div>
    </div>
</body>
</html>

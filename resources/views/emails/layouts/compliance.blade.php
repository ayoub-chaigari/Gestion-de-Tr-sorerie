<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Sovereign Compliance' }}</title>
    <style>
        body { font-family: 'Inter', Helvetica, Arial, sans-serif; background-color: #F8FAFF; margin: 0; padding: 0; -webkit-text-size-adjust: none; text-size-adjust: none; }
        .wrapper { width: 100%; table-layout: fixed; background-color: #F8FAFF; padding-bottom: 60px; }
        .container { max-width: 600px; margin: 0 auto; background-color: #ffffff; border-radius: 24px; overflow: hidden; margin-top: 40px; box-shadow: 0 10px 30px rgba(0,0,0,0.05); }
        .header { background-color: #ffffff; padding: 30px; text-align: center; }
        .header-brand { font-size: 16px; font-weight: 800; color: #131B2E; margin-bottom: 4px; }
        .header-vault { font-size: 10px; font-weight: 700; color: #7C839B; text-transform: uppercase; letter-spacing: 2px; }
        .badge-enforcement { background-color: #C6F6D5; color: #22543D; padding: 4px 12px; border-radius: 9999px; font-size: 10px; font-weight: 800; text-transform: uppercase; display: inline-block; margin-bottom: 24px; }
        .main-heading { font-size: 28px; font-weight: 800; color: #131B2E; line-height: 1.2; margin-bottom: 16px; text-align: center; padding: 0 40px; }
        .sub-heading { font-size: 14px; color: #45464D; line-height: 1.6; text-align: center; padding: 0 50px; margin-bottom: 40px; }
        .metrics-block { background-color: #0B1120; border-radius: 24px; margin: 0 20px 20px 20px; padding: 30px; position: relative; color: #ffffff; overflow: hidden; }
        .metrics-icon { position: absolute; top: 24px; left: 24px; width: 24px; height: 24px; }
        .maturity-badge { position: absolute; top: 24px; right: 24px; text-align: right; }
        .maturity-label { font-size: 8px; font-weight: 700; color: #7C839B; text-transform: uppercase; margin-bottom: 4px; }
        .maturity-value { font-size: 14px; font-weight: 700; font-style: italic; }
        .volume-label { font-size: 16px; font-weight: 700; margin-bottom: 8px; margin-top: 40px; }
        .volume-value { font-size: 32px; font-weight: 800; color: #4ADE80; }
        .volume-currency { font-size: 16px; color: #7C839B; font-weight: 600; }
        .cards-grid { padding: 0 20px; margin-bottom: 40px; }
        .info-card { background-color: #F8FAFF; border-radius: 16px; padding: 20px; display: inline-block; width: 44%; vertical-align: top; margin: 0 2%; text-align: left; }
        .info-icon { width: 32px; height: 32px; margin-bottom: 12px; }
        .info-title { font-size: 14px; font-weight: 700; color: #131B2E; margin-bottom: 8px; }
        .info-desc { font-size: 11px; color: #7C839B; line-height: 1.5; }
        .cta-section { text-align: center; padding-bottom: 40px; }
        .cta-title { font-size: 16px; font-weight: 700; color: #131B2E; margin-bottom: 24px; }
        .cta-button { background-color: #D4AF37; color: #ffffff; padding: 16px 40px; border-radius: 9999px; font-size: 14px; font-weight: 700; text-decoration: none; display: inline-block; box-shadow: 0 10px 20px rgba(212, 175, 55, 0.3); }
        .cta-footer { font-size: 10px; color: #7C839B; margin-top: 16px; font-weight: 600; }
        .footer { padding-top: 20px; text-align: center; font-size: 10px; color: #94A3B8; padding-bottom: 40px; }
        .footer-logo { width: 32px; height: 32px; margin-bottom: 16px; }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container">
            <div class="header">
                <div class="header-brand">Sovereign Finance</div>
                <div class="header-vault">THE DIGITAL VAULT</div>
            </div>
            
            <div style="text-align: center;">
                <div class="badge-enforcement">✓ COMPLIANCE ENFORCEMENT</div>
            </div>

            <div class="main-heading">Critical Compliance Window Closing.</div>
            <p class="sub-heading">As part of our commitment to Law 69-21 standards, urgent attention is required for your upcoming invoice maturities.</p>

            <div class="metrics-block">
                <img src="{{ $message->embed(public_path('images/email/warning.png')) }}" class="metrics-icon" alt="Warning">
                <div class="maturity-badge">
                    <div class="maturity-label">MATURITY STATUS</div>
                    <div class="maturity-value">{{ $maturity_status ?? 'Expiring in 24h' }}</div>
                </div>
                <div class="volume-label">{{ $volume_label ?? 'Pending Invoice Volume' }}</div>
                <div class="volume-value">{{ $volume_value ?? '0.00' }} <span class="volume-currency">MAD</span></div>
            </div>

            <div class="cards-grid">
                <div class="info-card">
                    <img src="{{ $message->embed(public_path('images/email/law.png')) }}" class="info-icon" alt="Law">
                    <div class="info-title">Law 69–21 Protocol</div>
                    <div class="info-desc">Mandatory declaration of non-payment and systematic notification to Bank Al-Maghrib.</div>
                </div>
                <div class="info-card">
                    <img src="{{ $message->embed(public_path('images/email/penalties.png')) }}" class="info-icon" alt="Penalties">
                    <div class="info-title">Penalties Mitigation</div>
                    <div class="info-desc">Failure to clear pending instruments may result in immediate suspension of check issuance rights.</div>
                </div>
            </div>

            <div class="cta-section">
                <div class="cta-title">Protect Your Sovereign Standing</div>
                <a href="{{ $cta_url ?? url('/') }}" class="cta-button">Clear Pending Invoice →</a>
                <div class="cta-footer">🔒 SECURED BY SOVEREIGN PAY</div>
            </div>
        </div>

        <div class="footer">
            <img src="{{ $message->embed(public_path('favicon.ico')) }}" class="footer-logo" alt="Logo">
            <div style="margin-bottom: 12px;">
                <a href="#" style="color: #64748B; text-decoration: none; margin: 0 10px;">Security</a>
                <a href="#" style="color: #64748B; text-decoration: none; margin: 0 10px;">Privacy Policy</a>
                <a href="#" style="color: #64748B; text-decoration: none; margin: 0 10px;">Unsubscribe</a>
                <a href="#" style="color: #64748B; text-decoration: none; margin: 0 10px;">Help Center</a>
            </div>
            <p>© {{ date('Y') }} Sovereign Finance. Regulated by Bank Al-Maghrib.<br>
            This is a mandatory compliance notification as per Moroccan Financial Law.</p>
        </div>
    </div>
</body>
</html>

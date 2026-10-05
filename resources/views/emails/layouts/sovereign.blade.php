<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Sovereign Finance' }}</title>
    <style>
        body { font-family: 'Inter', Helvetica, Arial, sans-serif; background-color: #F8FAFF; margin: 0; padding: 0; -webkit-text-size-adjust: none; text-size-adjust: none; }
        .wrapper { width: 100%; table-layout: fixed; background-color: #F8FAFF; padding-bottom: 60px; }
        .container { max-width: 600px; margin: 0 auto; background-color: #ffffff; border-radius: 24px; overflow: hidden; margin-top: 40px; box-shadow: 0 10px 30px rgba(0,0,0,0.05); }
        .header { background-color: #ffffff; padding: 20px; text-align: center; }
        .header-top { font-size: 10px; font-weight: 700; color: #7C839B; text-transform: uppercase; letter-spacing: 2px; margin-bottom: 4px; }
        .header-brand { font-size: 18px; font-weight: 800; color: #131B2E; letter-spacing: -0.5px; }
        .hero { background-color: #131B2E; padding: 40px 20px; text-align: center; background-image: url('{{ $message->embed(public_path('images/email/hero.png')) }}'); background-size: cover; background-position: center; }
        .hero h1 { color: #ffffff; font-size: 32px; font-weight: 900; margin: 0; line-height: 1.1; letter-spacing: -1px; }
        .content { padding: 40px 30px; text-align: center; }
        .content p { font-size: 15px; line-height: 1.6; color: #45464D; margin-bottom: 30px; }
        .feature-card { background-color: #ffffff; border: 1px solid #EAEDFF; border-radius: 16px; padding: 20px; margin-bottom: 16px; text-align: left; }
        .feature-icon { width: 48px; height: 48px; margin-right: 16px; float: left; }
        .feature-text { overflow: hidden; }
        .feature-title { font-size: 14px; font-weight: 700; color: #131B2E; margin-bottom: 4px; }
        .feature-desc { font-size: 12px; color: #7C839B; line-height: 1.4; }
        .cta-container { padding: 40px 0; text-align: center; }
        .cta-button { background-color: #D4AF37; color: #ffffff; padding: 16px 40px; border-radius: 9999px; font-size: 14px; font-weight: 700; text-decoration: none; display: inline-block; box-shadow: 0 10px 20px rgba(212, 175, 55, 0.3); }
        .mission { font-style: italic; font-size: 13px; color: #7C839B; max-width: 400px; margin: 0 auto; line-height: 1.6; margin-bottom: 30px; }
        .status-badge { background-color: #E8F5E9; color: #2E7D32; padding: 6px 12px; border-radius: 9999px; font-size: 10px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; display: inline-block; margin-bottom: 40px; }
        .footer { padding: 40px 20px; text-align: center; font-size: 11px; color: #7C839B; }
        .footer-links { margin-bottom: 12px; }
        .footer-links a { color: #565E74; text-decoration: none; margin: 0 8px; font-weight: 600; }
        .footer-bottom { font-weight: 500; }
        @media screen and (max-width: 600px) {
            .container { margin-top: 0; border-radius: 0; }
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container">
            <div class="header">
                <div class="header-top">THE DIGITAL VAULT</div>
                <div class="header-brand">Sovereign Finance</div>
            </div>
            <div class="hero">
                <h1>{{ $hero_title ?? 'Welcome to the Elite Circle' }}</h1>
            </div>
            <div class="content">
                @yield('content')

                <div class="feature-card">
                    <img src="{{ $message->embed(public_path('images/email/shield.png')) }}" class="feature-icon" alt="Security">
                    <div class="feature-text">
                        <div class="feature-title">Institutional Security</div>
                        <div class="feature-desc">Military-grade protection for the Kingdom's most sensitive treasury assets.</div>
                    </div>
                </div>

                <div class="feature-card">
                    <img src="{{ $message->embed(public_path('images/email/law.png')) }}" class="feature-icon" alt="Compliance">
                    <div class="feature-text">
                        <div class="feature-title">Law 69–21 Automation</div>
                        <div class="feature-desc">Automated compliance with Morocco's late payment regulations effortlessly.</div>
                    </div>
                </div>

                <div class="feature-card">
                    <img src="{{ $message->embed(public_path('images/email/visibility.png')) }}" class="feature-icon" alt="Visibility">
                    <div class="feature-text">
                        <div class="feature-title">Real-Time Visibility</div>
                        <div class="feature-desc">Crystal-clear cash flow forecasting powered by Sovereign Pay analytics.</div>
                    </div>
                </div>

                <div class="cta-container">
                    <a href="{{ $cta_url ?? url('/') }}" class="cta-button">{{ $cta_text ?? 'Access Your Vault' }}</a>
                </div>

                <div class="mission">
                    "Our mission is to provide the architectural foundation for the future of Moroccan enterprise finance."
                </div>

                <div class="status-badge">
                    ✓ Verified Institution
                </div>
            </div>
        </div>
        <div class="footer">
            <p>© {{ date('Y') }} Sovereign Finance. Regulated by Bank Al-Maghrib.</p>
            <div class="footer-links">
                <a href="#">Security</a>
                <a href="#">Privacy Policy</a>
                <a href="#">Unsubscribe</a>
                <a href="#">Help Center</a>
            </div>
        </div>
    </div>
</body>
</html>

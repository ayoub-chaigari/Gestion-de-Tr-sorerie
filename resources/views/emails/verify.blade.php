@extends('emails.layouts.sovereign', [
    'hero_title' => 'Vault Activation',
    'cta_text' => 'Verify My Email',
    'cta_url' => $url
])

@section('content')
    Greetings, Sovereign Partner.
    <br><br>
    To finalize your access to the **Digital Vault**, please confirm your identity by verifying your email address. This ensures that only authorized partners can manage treasury operations.
    <br><br>
    If you did not initiate this request, no further action is required.
@endsection

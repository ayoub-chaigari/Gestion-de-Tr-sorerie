@extends('emails.layouts.sovereign', [
    'hero_title' => 'Welcome to the Elite Circle',
    'cta_text' => 'Access Your Vault',
    'cta_url' => url('/')
])

@section('content')
    Greetings, Sovereign Partner.
    <br><br>
    You have joined a select group of Moroccan treasury leaders who demand precision, security, and absolute clarity in their financial operations. 
    <br><br>
    Your account has been successfully provisioned within the Digital Vault ecosystem. You can now begin managing your liquidity with institutional-grade tools built for Law 69–21 compliance.
@endsection

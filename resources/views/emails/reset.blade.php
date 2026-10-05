@extends('emails.layouts.sovereign', [
    'hero_title' => 'Vault Restoration',
    'cta_text' => 'Reset My Passkey',
    'cta_url' => $url
])

@section('content')
    Greetings, Sovereign Partner.
    <br><br>
    We received a request to restore access to your **Digital Vault**. If you initiated this request, please click the button below to set a new secret passkey.
    <br><br>
    This secure link will expire in {{ $count }} minutes.
    <br><br>
    If you did not request a passkey restoration, you may safely ignore this transmission.
@endsection

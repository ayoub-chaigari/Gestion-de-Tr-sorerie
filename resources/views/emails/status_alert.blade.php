@extends('emails.layouts.sovereign', [
    'hero_title' => $hero_title ?? 'Status Update',
    'cta_text' => $cta_text ?? 'Access Your Vault',
    'cta_url' => $cta_url ?? url('/')
])

@section('content')
    {!! nl2br(e($email_body)) !!}
@endsection

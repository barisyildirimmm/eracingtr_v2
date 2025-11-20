@extends('mails.layout')

@section('content')
    <p>{{ __('common.mail_hello') }} {{ $userInfo['name'] . " " . $userInfo['surname'] }},</p>
    <p>
        <strong>{{ __('common.mail_thanks') }}</strong>
    </p>
    <p>
        {{ __('common.mail_ready') }}
    </p>
    <p>
        <a href="{{ route('DverifyMailGet', $userInfo['email_verification_token']) }}" class="button">{{ __('common.mail_verify_button') }}</a>
    </p>
    <p>
        <a href="https://chat.whatsapp.com/EVT53Wh8Ysj1lyeOtTkRvL" target="_blank"
           style="
            display:inline-block;
            background:#25D366;
            color:#ffffff !important;
            padding:10px 18px;
            border-radius:6px;
            text-decoration:none;
            font-weight:bold;
            font-size:14px;
            font-family:Arial, sans-serif;
            margin-right:10px;
       ">
            {{ __('common.mail_whatsapp_join') }}
        </a>
        <a href="https://discord.gg/M44SvA68QD" target="_blank"
           style="
            display:inline-block;
            background:#5865F2;
            color:#ffffff !important;
            padding:10px 18px;
            border-radius:6px;
            text-decoration:none;
            font-weight:bold;
            font-size:14px;
            font-family:Arial, sans-serif;
       ">
            {{ __('common.mail_discord_join') }}
        </a>
    </p>
    <p>
        {{ __('common.mail_see_you') }}
    </p>
    <p><strong>{{ __('common.mail_team') }}</strong></p>
@endsection
@extends('mails.layout')

@section('content')
    <p>{{ __('common.mail_hello') }} {{ $userInfo['name'] . " " . $userInfo['surname'] }},</p>
    <p>
        {{ __('common.password_reset_mail_message') }}
    </p>
    <p style="text-align: center; margin: 30px 0;">
        <span style="
            display: inline-block;
            background: #dc3545;
            color: #ffffff;
            padding: 20px 40px;
            border-radius: 8px;
            font-size: 32px;
            font-weight: bold;
            letter-spacing: 8px;
            font-family: 'Courier New', monospace;
        ">{{ $userInfo['reset_code'] }}</span>
    </p>
    <p>
        {{ __('common.password_reset_code_expires') }}
    </p>
    <p style="color: #666; font-size: 12px; margin-top: 15px; font-style: italic;">
        <i class="fas fa-info-circle" style="margin-right: 5px;"></i>{{ __('common.mail_delivery_time') }}
    </p>
    <p>
        {{ __('common.password_reset_security_notice') }}
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


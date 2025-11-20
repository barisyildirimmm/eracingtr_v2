@extends('mails.layout')

@section('content')
    <p style="font-size: 16px; color: #333; margin-bottom: 20px;">
        {{ __('common.mail_hello') }} <strong>{{ $userInfo['name'] . " " . $userInfo['surname'] }}</strong>,
    </p>
    
    <p style="font-size: 16px; color: #333; margin-bottom: 20px; line-height: 1.6;">
        <strong style="color: #dc3545; font-size: 18px;">{{ __('common.mail_thanks') }}</strong>
    </p>
    
    <p style="font-size: 15px; color: #555; margin-bottom: 30px; line-height: 1.6;">
        {{ __('common.mail_ready') }}
    </p>
    
    <div style="text-align: center; margin: 30px 0;">
        <a href="{{ route('DverifyMailGet', $userInfo['email_verification_token']) }}" 
           style="
            display: inline-block;
            background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
            color: #ffffff !important;
            padding: 15px 35px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: bold;
            font-size: 16px;
            font-family: Arial, sans-serif;
            box-shadow: 0 4px 15px rgba(220, 53, 69, 0.3);
            transition: all 0.3s;
       ">
            {{ __('common.mail_verify_button') }}
        </a>
    </div>
    
    <div style="background: #f8f9fa; padding: 20px; border-radius: 8px; margin: 30px 0; border-left: 4px solid #dc3545;">
        <p style="font-size: 14px; color: #666; margin: 0 0 15px 0; font-weight: 600;">
            {{ __('common.mail_join_communities') }}:
        </p>
        <div style="text-align: center;">
            <a href="https://chat.whatsapp.com/EVT53Wh8Ysj1lyeOtTkRvL" target="_blank"
               style="
                display: inline-block;
                background: #25D366;
                color: #ffffff !important;
                padding: 12px 24px;
                border-radius: 6px;
                text-decoration: none;
                font-weight: bold;
                font-size: 14px;
                font-family: Arial, sans-serif;
                margin-right: 10px;
                margin-bottom: 10px;
                box-shadow: 0 2px 8px rgba(37, 211, 102, 0.3);
           ">
                <i class="fab fa-whatsapp" style="margin-right: 5px;"></i>{{ __('common.mail_whatsapp_join') }}
            </a>
            <a href="https://discord.gg/M44SvA68QD" target="_blank"
               style="
                display: inline-block;
                background: #5865F2;
                color: #ffffff !important;
                padding: 12px 24px;
                border-radius: 6px;
                text-decoration: none;
                font-weight: bold;
                font-size: 14px;
                font-family: Arial, sans-serif;
                margin-bottom: 10px;
                box-shadow: 0 2px 8px rgba(88, 101, 242, 0.3);
           ">
                <i class="fab fa-discord" style="margin-right: 5px;"></i>{{ __('common.mail_discord_join') }}
            </a>
        </div>
    </div>
    
    <p style="font-size: 15px; color: #555; margin-top: 30px; margin-bottom: 10px;">
        {{ __('common.mail_see_you') }}
    </p>
    <p style="font-size: 16px; color: #dc3545; font-weight: bold; margin: 0;">
        {{ __('common.mail_team') }}
    </p>
@endsection
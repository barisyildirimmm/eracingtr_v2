@extends('mails.layout')

@section('content')
    <p style="font-size: 16px; color: #333333; margin-bottom: 20px; font-family: Arial, Helvetica, sans-serif;">
        {{ __('common.mail_hello') }} <strong>{{ $userInfo['name'] . " " . $userInfo['surname'] }}</strong>,
    </p>
    
    <p style="font-size: 16px; color: #333333; margin-bottom: 20px; line-height: 1.6; font-family: Arial, Helvetica, sans-serif;">
        <strong style="color: #dc3545; font-size: 18px;">{{ __('common.mail_thanks') }}</strong>
    </p>
    
    <p style="font-size: 15px; color: #555555; margin-bottom: 30px; line-height: 1.6; font-family: Arial, Helvetica, sans-serif;">
        {{ __('common.mail_ready') }}
    </p>
    
    <!-- Hesap Onaylama Bölümü -->
    <div style="background-color: #ffffff; border: 2px solid #dc3545; border-radius: 8px; padding: 25px; margin: 30px 0; text-align: center;">
        <div style="margin-bottom: 20px;">
            <div style="width: 70px; height: 70px; background-color: #dc3545; border-radius: 50%; margin: 0 auto 15px; text-align: center; line-height: 70px;">
                <span style="font-size: 36px; color: #ffffff; font-family: Arial, Helvetica, sans-serif;">&#10004;</span>
            </div>
            <h3 style="color: #dc3545; font-size: 20px; font-weight: bold; margin: 0 0 10px 0; font-family: Arial, Helvetica, sans-serif;">
                {{ __('common.mail_verify_account') }}
            </h3>
            <p style="font-size: 14px; color: #666666; margin: 0 0 25px 0; line-height: 1.5; font-family: Arial, Helvetica, sans-serif;">
                {{ __('common.mail_verify_description') }}
            </p>
        </div>
        
        <div style="text-align: center; margin: 20px 0;">
            <a href="{{ route('DverifyMailGet', $userInfo['email_verification_token']) }}" 
               style="
                display: inline-block;
                background-color: #dc3545;
                color: #ffffff !important;
                padding: 14px 35px;
                border-radius: 6px;
                text-decoration: none;
                font-weight: bold;
                font-size: 16px;
                font-family: Arial, Helvetica, sans-serif;
                border: none;
                line-height: 1.5;
           ">
                {{ __('common.mail_verify_button') }}
            </a>
        </div>
        
        <p style="font-size: 12px; color: #999999; margin: 20px 0 0 0; line-height: 1.4; font-family: Arial, Helvetica, sans-serif;">
            {{ __('common.mail_verify_link_expires') }}
        </p>
    </div>
    
    <div style="background-color: #f8f9fa; padding: 20px; border-radius: 6px; margin: 30px 0; border-left: 4px solid #dc3545;">
        <p style="font-size: 14px; color: #666666; margin: 0 0 15px 0; font-weight: bold; font-family: Arial, Helvetica, sans-serif;">
            {{ __('common.mail_join_communities') }}:
        </p>
        <div style="text-align: center;">
            <a href="https://chat.whatsapp.com/EVT53Wh8Ysj1lyeOtTkRvL" target="_blank"
               style="
                display: inline-block;
                background-color: #25D366;
                color: #ffffff !important;
                padding: 10px 20px;
                border-radius: 5px;
                text-decoration: none;
                font-weight: bold;
                font-size: 14px;
                font-family: Arial, Helvetica, sans-serif;
                margin-right: 10px;
                margin-bottom: 10px;
                border: none;
                line-height: 1.5;
           ">
                {{ __('common.mail_whatsapp_join') }}
            </a>
            <a href="https://discord.gg/M44SvA68QD" target="_blank"
               style="
                display: inline-block;
                background-color: #5865F2;
                color: #ffffff !important;
                padding: 10px 20px;
                border-radius: 5px;
                text-decoration: none;
                font-weight: bold;
                font-size: 14px;
                font-family: Arial, Helvetica, sans-serif;
                margin-bottom: 10px;
                border: none;
                line-height: 1.5;
           ">
                {{ __('common.mail_discord_join') }}
            </a>
        </div>
    </div>
    
    <p style="font-size: 15px; color: #555555; margin-top: 30px; margin-bottom: 10px; font-family: Arial, Helvetica, sans-serif;">
        {{ __('common.mail_see_you') }}
    </p>
    <p style="font-size: 16px; color: #dc3545; font-weight: bold; margin: 0; font-family: Arial, Helvetica, sans-serif;">
        {{ __('common.mail_team') }}
    </p>
@endsection
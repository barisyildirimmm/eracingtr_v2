@extends('mails.layout')

@section('content')
    <p style="font-size: 16px; color: #333; margin-bottom: 20px;">
        {{ __('common.mail_hello') }} <strong>{{ $userInfo['name'] . " " . $userInfo['surname'] }}</strong>,
    </p>
    
    <p style="font-size: 15px; color: #555; margin-bottom: 30px; line-height: 1.6;">
        {{ __('common.password_reset_mail_message') }}
    </p>
    
    <!-- Şifre Sıfırlama Kodu Bölümü -->
    <div style="background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%); border: 2px solid #dc3545; border-radius: 12px; padding: 30px; margin: 30px 0; text-align: center; box-shadow: 0 4px 20px rgba(220, 53, 69, 0.15);">
        <div style="margin-bottom: 20px;">
            <div style="display: inline-block; width: 80px; height: 80px; background: linear-gradient(135deg, #dc3545 0%, #c82333 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 15px; box-shadow: 0 4px 15px rgba(220, 53, 69, 0.3);">
                <span style="font-size: 40px; color: #ffffff;">🔑</span>
            </div>
            <h3 style="color: #dc3545; font-size: 22px; font-weight: bold; margin: 0 0 10px 0; font-family: Arial, sans-serif;">
                {{ __('common.password_reset_code_title') }}
            </h3>
            <p style="font-size: 14px; color: #666; margin: 0 0 25px 0; line-height: 1.5;">
                {{ __('common.password_reset_code_description') }}
            </p>
        </div>
        
        <div style="text-align: center; margin: 25px 0;">
            <div style="display: inline-block; background: #ffffff; border: 3px solid #dc3545; border-radius: 12px; padding: 25px 50px; box-shadow: 0 4px 15px rgba(220, 53, 69, 0.2);">
                <span style="
                    display: inline-block;
                    color: #dc3545;
                    font-size: 42px;
                    font-weight: bold;
                    letter-spacing: 12px;
                    font-family: 'Courier New', monospace;
                    text-shadow: 0 2px 4px rgba(220, 53, 69, 0.2);
                ">{{ $userInfo['reset_code'] }}</span>
            </div>
        </div>
        
        <p style="font-size: 13px; color: #dc3545; margin: 20px 0 10px 0; font-weight: 600;">
            ⏰ {{ __('common.password_reset_code_expires') }}
        </p>
        <p style="font-size: 12px; color: #999; margin: 0; line-height: 1.4;">
            {{ __('common.password_reset_security_notice') }}
        </p>
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


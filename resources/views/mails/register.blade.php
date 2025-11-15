@extends('mails.layout')

@section('content')
    <p>Merhaba {{ $userInfo['name'] . " " . $userInfo['surname'] }},</p>
    <p>
        <strong>eRacing Türkiye</strong> ailesine katıldığın için teşekkür ederiz!
    </p>
    <p>
        İlk yarışına hazır mısın? Aşağıdaki butona tıklayarak hesabını tamamlayabilir ve pistte yerini alabilirsin:
    </p>
    <p>
        <a href="{{ route('DverifyMailGet', $userInfo['email_verification_token']) }}" class="button">Mail Adresini Onayla, Hesabını Tamamla</a>
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
       ">
            WhatsApp Grubuna Katıl
        </a>
    </p>
    <p>
        Pistte görüşmek üzere,
    </p>
    <p><strong>eRacing Türkiye Ekibi</strong></p>
@endsection
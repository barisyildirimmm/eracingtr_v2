<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ __('common.site_title_full') }}</title>
    <link rel="shortcut icon" href="{{ asset('assets/img/logo/logo_fav.png?v=2') }}">
    
    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&family=Source+Sans+Pro:wght@400;700&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/20.1.0/css/intlTelInput.css" />
    
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Source Sans Pro', sans-serif;
            background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 50%, #1a1a1a 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            overflow-x: hidden;
            position: relative;
            padding: 20px 0;
        }
        
        body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: 
                radial-gradient(circle at 20% 50%, rgba(220, 53, 69, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 80% 80%, rgba(220, 53, 69, 0.1) 0%, transparent 50%);
            pointer-events: none;
        }
        
        .maintenance-container {
            text-align: center;
            padding: 40px 20px;
            max-width: 1000px;
            width: 100%;
            position: relative;
            z-index: 1;
        }
        
        .logo-container {
            margin-bottom: 40px;
            animation: fadeInDown 1s ease-out;
        }
        
        .logo-container img {
            max-width: 300px;
            width: 100%;
            height: auto;
            filter: drop-shadow(0 10px 30px rgba(220, 53, 69, 0.3));
        }
        
        .maintenance-title {
            font-family: 'Montserrat', sans-serif;
            font-size: 2.5rem;
            font-weight: 700;
            color: #fff;
            margin-bottom: 15px;
            text-shadow: 0 4px 20px rgba(0, 0, 0, 0.5);
            animation: fadeInUp 1s ease-out 0.3s both;
        }
        
        .maintenance-subtitle {
            font-size: 1.3rem;
            color: #ccc;
            margin-bottom: 40px;
            line-height: 1.6;
            animation: fadeInUp 1s ease-out 0.5s both;
        }
        
        .countdown-container {
            background: linear-gradient(135deg, rgba(220, 53, 69, 0.2) 0%, rgba(200, 35, 51, 0.2) 100%);
            border: 2px solid rgba(220, 53, 69, 0.3);
            border-radius: 20px;
            padding: 40px 30px;
            margin: 40px 0;
            backdrop-filter: blur(10px);
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.3);
            animation: fadeInUp 1s ease-out 0.7s both;
        }
        
        .countdown-title {
            font-family: 'Montserrat', sans-serif;
            font-size: 1.5rem;
            font-weight: 600;
            color: #dc3545;
            margin-bottom: 30px;
            text-transform: uppercase;
            letter-spacing: 2px;
        }
        
        .countdown-display {
            display: flex;
            justify-content: center;
            gap: 20px;
            flex-wrap: wrap;
            margin-bottom: 20px;
        }
        
        .countdown-item {
            background: linear-gradient(135deg, #2d2d2d 0%, #1a1a1a 100%);
            border: 2px solid rgba(220, 53, 69, 0.5);
            border-radius: 15px;
            padding: 25px 20px;
            min-width: 120px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.4);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        
        .countdown-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 30px rgba(220, 53, 69, 0.5);
        }
        
        .countdown-number {
            font-family: 'Montserrat', sans-serif;
            font-size: 3rem;
            font-weight: 700;
            color: #dc3545;
            line-height: 1;
            margin-bottom: 10px;
            text-shadow: 0 2px 10px rgba(220, 53, 69, 0.5);
        }
        
        .countdown-label {
            font-size: 0.9rem;
            color: #999;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-weight: 600;
        }
        
        .opening-date {
            font-size: 1.1rem;
            color: #fff;
            margin-top: 20px;
            font-weight: 600;
        }
        
        .register-section {
            margin-top: 50px;
            padding: 40px 30px;
            background: rgba(0, 0, 0, 0.4);
            border-radius: 20px;
            border: 2px solid rgba(220, 53, 69, 0.3);
            animation: fadeInUp 1s ease-out 0.9s both;
        }
        
        .register-title {
            font-family: 'Montserrat', sans-serif;
            font-size: 1.8rem;
            font-weight: 600;
            color: #dc3545;
            margin-bottom: 10px;
        }
        
        .register-subtitle {
            font-size: 1rem;
            color: #ccc;
            margin-bottom: 30px;
        }
        
        .register-form {
            text-align: left;
            max-width: 600px;
            margin: 0 auto;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        .form-label {
            color: #fff;
            font-weight: 500;
            margin-bottom: 8px;
            display: block;
            font-size: 0.95rem;
        }
        
        .form-control {
            width: 100%;
            background: #333;
            border: 2px solid #444;
            color: #fff;
            border-radius: 8px;
            padding: 12px 15px;
            transition: all 0.3s;
            font-size: 1rem;
        }
        
        .form-control:focus {
            outline: none;
            border-color: #dc3545;
            box-shadow: 0 0 0 3px rgba(220, 53, 69, 0.2);
            background: #3a3a3a;
        }
        
        .form-row {
            display: flex;
            gap: 15px;
        }
        
        .form-row .form-group {
            flex: 1;
        }
        
        .btn-register {
            width: 100%;
            background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
            color: white;
            border: none;
            border-radius: 8px;
            padding: 16px;
            font-weight: 600;
            font-size: 16px;
            transition: all 0.3s;
            box-shadow: 0 4px 15px rgba(220, 53, 69, 0.4);
            cursor: pointer;
            margin-top: 10px;
        }
        
        .btn-register:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(220, 53, 69, 0.6);
            background: linear-gradient(135deg, #c82333 0%, #bd2130 100%);
        }
        
        .form-note {
            text-align: center;
            color: #999;
            font-size: 0.9rem;
            margin-top: 15px;
        }
        
        .iti {
            width: 100%;
        }
        
        .iti__flag-container {
            background: #333;
            border-right: 2px solid #444;
        }
        
        .iti__selected-flag {
            background: #333;
            border-radius: 8px 0 0 8px;
            padding: 12px 10px;
        }
        
        .iti__selected-flag:hover {
            background: #3a3a3a;
        }
        
        .iti__arrow {
            border-top-color: #fff;
        }
        
        .iti__country-list {
            background: #333 !important;
            border: 2px solid #444 !important;
            color: #fff !important;
        }
        
        .iti__country {
            color: #fff !important;
        }
        
        .iti__country:hover,
        .iti__country.iti__highlight {
            background: #dc3545 !important;
        }
        
        .iti__dial-code {
            color: #999;
        }
        
        #gsm {
            padding-left: 80px !important;
        }
        
        @keyframes fadeInDown {
            from {
                opacity: 0;
                transform: translateY(-30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        @media (max-width: 768px) {
            .maintenance-title {
                font-size: 1.8rem;
            }
            
            .maintenance-subtitle {
                font-size: 1.1rem;
            }
            
            .countdown-item {
                min-width: 100px;
                padding: 20px 15px;
            }
            
            .countdown-number {
                font-size: 2.5rem;
            }
            
            .countdown-display {
                gap: 15px;
            }
            
            .form-row {
                flex-direction: column;
                gap: 0;
            }
            
            .register-section {
                padding: 30px 20px;
            }
        }
    </style>
</head>
<body>
    <div class="maintenance-container">
        <div class="logo-container">
            <img src="{{ asset('assets/img/logo/logo.png?v=2') }}" alt="eRacingTR Logo">
        </div>
        
        <h1 class="maintenance-title">
            <i class="fas fa-sparkles"></i> {{ __('common.maintenance_title') }}
        </h1>
        
        <p class="maintenance-subtitle">
            {!! __('common.maintenance_subtitle') !!}
        </p>
        
        <div class="countdown-container">
            <h2 class="countdown-title">{{ __('common.countdown_title') }}</h2>
            <div class="countdown-display" id="countdown">
                <div class="countdown-item">
                    <div class="countdown-number" id="days">00</div>
                    <div class="countdown-label">{{ __('common.countdown_days') }}</div>
                </div>
                <div class="countdown-item">
                    <div class="countdown-number" id="hours">00</div>
                    <div class="countdown-label">{{ __('common.countdown_hours') }}</div>
                </div>
                <div class="countdown-item">
                    <div class="countdown-number" id="minutes">00</div>
                    <div class="countdown-label">{{ __('common.countdown_minutes') }}</div>
                </div>
                <div class="countdown-item">
                    <div class="countdown-number" id="seconds">00</div>
                    <div class="countdown-label">{{ __('common.countdown_seconds') }}</div>
                </div>
            </div>
            <div class="opening-date" id="openingDate"></div>
        </div>
        
        @if (!session('driverInfo'))
        <div class="register-section">
            <h3 class="register-title">
                <i class="fas fa-user-plus"></i> {{ __('common.register_section_title') }}
            </h3>
            <p class="register-subtitle">
                {{ __('common.register_section_subtitle') }}
            </p>
            
            <form id="registerForm" class="register-form">
                @csrf
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">
                            <i class="fas fa-user" style="color: #dc3545; margin-right: 5px;"></i>{{ __('common.name_placeholder') }}
                        </label>
                        <input type="text" class="form-control" name="name" placeholder="{{ __('common.name_placeholder') }}" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">
                            <i class="fas fa-user" style="color: #dc3545; margin-right: 5px;"></i>{{ __('common.surname_placeholder') }}
                        </label>
                        <input type="text" class="form-control" name="surname" placeholder="{{ __('common.surname_placeholder') }}" required>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="form-label">
                        <i class="fas fa-phone" style="color: #dc3545; margin-right: 5px;"></i>{{ __('common.phone_placeholder_form') }}
                    </label>
                    <input type="tel" class="form-control" id="gsm" name="gsm" placeholder="{{ __('common.phone_placeholder_form') }}" required>
                    <input type="hidden" id="gsm_country_code" name="country_code" value="">
                </div>
                
                <div class="form-group">
                    <label class="form-label">
                        <i class="fas fa-envelope" style="color: #dc3545; margin-right: 5px;"></i>{{ __('common.email_placeholder') }}
                    </label>
                    <input type="email" class="form-control" name="email" placeholder="{{ __('common.email_placeholder') }}" required>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">
                            <i class="fas fa-lock" style="color: #dc3545; margin-right: 5px;"></i>{{ __('common.password_placeholder') }}
                        </label>
                        <input type="password" class="form-control" name="password" placeholder="{{ __('common.password_placeholder') }}" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">
                            <i class="fas fa-lock" style="color: #dc3545; margin-right: 5px;"></i>{{ __('common.password_confirmation_placeholder') }}
                        </label>
                        <input type="password" class="form-control" name="password_confirmation" placeholder="{{ __('common.password_confirmation_placeholder') }}" required>
                    </div>
                </div>
                
                <button type="button" onclick="registerUser()" class="btn-register">
                    <i class="fas fa-user-plus" style="margin-right: 8px;"></i>{{ __('common.create_account') }}
                </button>
                
                <div class="form-note">
                    <i class="fas fa-info-circle" style="color: #dc3545; margin-right: 5px;"></i>{{ __('common.register_note') }}
                </div>
            </form>
        </div>
        @else
        <div class="register-section" style="background: rgba(16, 185, 129, 0.1); border-color: rgba(16, 185, 129, 0.3);">
            <h3 class="register-title" style="color: #10b981;">
                <i class="fas fa-check-circle"></i> {{ __('common.register_success') }}
            </h3>
            <p class="register-subtitle">
                {{ __('common.register_success_text') }}
            </p>
            <p style="text-align: center; color: #ccc; margin-top: 20px;">
                <i class="fas fa-info-circle" style="color: #10b981; margin-right: 5px;"></i>
                {{ __('common.register_note') }}
            </p>
        </div>
        @endif
    </div>
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/20.1.0/js/intlTelInput.min.js"></script>
    <script src="https://unpkg.com/imask"></script>
    
    <script>
        // CSRF Token Setup
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        
        // Telefon numarası için ülke bazlı mask
        let iti = null;
        let gsmInput = null;
        let phoneMask = null;
        
        function initPhoneInput() {
            gsmInput = document.querySelector('#gsm');
            if (gsmInput && !iti) {
                iti = window.intlTelInput(gsmInput, {
                    initialCountry: "tr",
                    preferredCountries: ["tr", "us", "gb", "de", "fr", "it", "es", "pt"],
                    separateDialCode: true,
                    nationalMode: false,
                    autoFormat: true,
                    autoPlaceholder: "aggressive",
                    utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/20.1.0/js/utils.js"
                });
                
                function updatePhoneMask() {
                    if (phoneMask) {
                        phoneMask.destroy();
                    }
                    
                    const countryData = iti.getSelectedCountryData();
                    const countryCode = countryData.iso2;
                    
                    const masks = {
                        'tr': '(000) 000 00 00',
                        'us': '(000) 000-0000',
                        'gb': '0000 000000',
                        'de': '000 00000000',
                        'fr': '0 00 00 00 00',
                        'it': '000 000 0000',
                        'es': '000 000 000',
                        'pt': '000 000 000'
                    };
                    
                    let maskPattern = masks[countryCode] || '000000000000';
                    
                    phoneMask = IMask(gsmInput, {
                        mask: maskPattern,
                        lazy: false
                    });
                }
                
                updatePhoneMask();
                
                gsmInput.addEventListener('countrychange', function() {
                    const countryData = iti.getSelectedCountryData();
                    document.getElementById('gsm_country_code').value = '+' + countryData.dialCode;
                    updatePhoneMask();
                    gsmInput.value = '';
                });
                
                const initialCountryData = iti.getSelectedCountryData();
                document.getElementById('gsm_country_code').value = '+' + initialCountryData.dialCode;
            }
        }
        
        // Telefon numarası doğrulama
        window.validatePhoneNumber = function() {
            if (!iti || !gsmInput || !iti.isValidNumber()) {
                Swal.fire({
                    title: '{{ __('common.error') }}',
                    text: 'Lütfen geçerli bir telefon numarası girin.',
                    icon: 'error',
                    confirmButtonText: '{{ __('common.ok') }}'
                });
                return false;
            }
            const fullNumber = iti.getNumber();
            gsmInput.value = fullNumber;
            return true;
        };
        
        // Sayfa yüklendiğinde telefon input'unu initialize et
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', initPhoneInput);
        } else {
            initPhoneInput();
        }
        
        // Kayıt fonksiyonu
        function registerUser() {
            if (typeof window.validatePhoneNumber === 'function' && !window.validatePhoneNumber()) {
                return;
            }
            
            $.ajax({
                url: '{{ route('DregisterPost') }}',
                type: 'POST',
                data: $('#registerForm').serialize(),
                success: function(response) {
                    if (response.hata === 1) {
                        Swal.fire({
                            title: '{{ __('common.error') }}',
                            text: response.aciklama,
                            icon: 'error',
                            confirmButtonText: '{{ __('common.ok') }}'
                        });
                    } else {
                        Swal.fire({
                            title: '{{ __('common.register_success') }}',
                            text: '{{ __('common.register_success_text') }}',
                            icon: 'success',
                            confirmButtonText: '{{ __('common.ok') }}'
                        }).then(() => {
                            // Formu temizle
                            document.getElementById('registerForm').reset();
                            if (iti) {
                                iti.setCountry('tr');
                                gsmInput.value = '';
                            }
                        });
                    }
                },
                error: function() {
                    Swal.fire({
                        title: '{{ __('common.error') }}',
                        text: '{{ __('common.unexpected_error') }}',
                        icon: 'error',
                        confirmButtonText: '{{ __('common.ok') }}'
                    });
                }
            });
        }
        
        // Pazar 21:00 için tarih hesaplama (bugünden itibaren 5 gün sonraki Pazar)
        function getNextSunday() {
            const now = new Date();
            
            // 5 gün sonraki tarihi al
            let targetDate = new Date(now);
            
            // 5 gün sonraki günün haftanın hangi günü olduğunu bul (0 = Pazar, 6 = Cumartesi)
            const dayOfWeek = targetDate.getDay();
            
            // Eğer 5 gün sonra Pazar değilse, en yakın Pazar'a git
            let daysToSunday = 0;
            if (dayOfWeek !== 0) {
                // Pazar'a kadar kaç gün var? (7 - dayOfWeek)
                daysToSunday = 7 - dayOfWeek;
                targetDate.setDate(targetDate.getDate() + daysToSunday);
            }
            // Eğer 5 gün sonra zaten Pazar ise, o günü kullan (daysToSunday = 0)
            
            targetDate.setHours(21, 0, 0, 0);
            
            return targetDate;
        }
        
        const targetDate = getNextSunday();
        
        // Tarih formatını göster
        const options = { 
            weekday: 'long', 
            year: 'numeric', 
            month: 'long', 
            day: 'numeric',
            hour: '2-digit',
            minute: '2-digit'
        };
        document.getElementById('openingDate').textContent = 
            '{{ __('common.opening_date') }}: ' + targetDate.toLocaleDateString('{{ app()->getLocale() === 'tr' ? 'tr-TR' : 'en-US' }}', options);
        
        function updateCountdown() {
            const now = new Date().getTime();
            const distance = targetDate.getTime() - now;
            
            if (distance < 0) {
                document.getElementById('days').textContent = '00';
                document.getElementById('hours').textContent = '00';
                document.getElementById('minutes').textContent = '00';
                document.getElementById('seconds').textContent = '00';
                return;
            }
            
            const days = Math.floor(distance / (1000 * 60 * 60 * 24));
            const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((distance % (1000 * 60)) / 1000);
            
            document.getElementById('days').textContent = String(days).padStart(2, '0');
            document.getElementById('hours').textContent = String(hours).padStart(2, '0');
            document.getElementById('minutes').textContent = String(minutes).padStart(2, '0');
            document.getElementById('seconds').textContent = String(seconds).padStart(2, '0');
        }
        
        // İlk güncelleme
        updateCountdown();
        
        // Her saniye güncelle
        setInterval(updateCountdown, 1000);
    </script>
</body>
</html>

@extends('driverPanel.layouts.main')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/20.1.0/css/intlTelInput.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/20.1.0/js/intlTelInput.min.js"></script>
<script src="https://unpkg.com/imask"></script>
<style>
    .profile-page {
        background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
        min-height: 100vh;
        padding: 2rem 0;
    }
    .page-header-card {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 1rem;
        padding: 2rem;
        margin-bottom: 2rem;
        box-shadow: 0 10px 30px rgba(102, 126, 234, 0.3);
        color: white;
    }
    .profile-card {
        background: white;
        border-radius: 1rem;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        padding: 2rem;
        margin-bottom: 2rem;
    }
    .form-group {
        margin-bottom: 1.5rem;
    }
    .form-label {
        font-weight: 600;
        color: #374151;
        margin-bottom: 0.5rem;
        display: block;
    }
    .form-control {
        border: 2px solid #e5e7eb;
        border-radius: 0.5rem;
        padding: 0.75rem 1rem;
        width: 100%;
        transition: all 0.3s ease;
        background: white;
    }
    .form-control:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        outline: none;
    }
    .form-control:disabled {
        background-color: #f3f4f6;
        cursor: not-allowed;
    }
    .alert {
        padding: 1rem;
        border-radius: 0.5rem;
        margin-bottom: 1.5rem;
    }
    .alert-warning {
        background-color: #fef3c7;
        border-left: 4px solid #f59e0b;
        color: #92400e;
    }
    .alert-info {
        background-color: #dbeafe;
        border-left: 4px solid #3b82f6;
        color: #1e40af;
    }
    .alert-success {
        background-color: #d1fae5;
        border-left: 4px solid #10b981;
        color: #065f46;
    }
    .alert-danger {
        background-color: #fee2e2;
        border-left: 4px solid #ef4444;
        color: #991b1b;
    }
    .btn {
        padding: 0.75rem 1.5rem;
        border-radius: 0.5rem;
        font-weight: 600;
        transition: all 0.3s ease;
        border: none;
        cursor: pointer;
    }
    .btn-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
    }
    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(102, 126, 234, 0.5);
    }
    .btn-success {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        color: white;
        box-shadow: 0 4px 15px rgba(16, 185, 129, 0.4);
    }
    .btn-success:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(16, 185, 129, 0.5);
    }
    .btn-secondary {
        background: #6b7280;
        color: white;
    }
    .btn-secondary:hover {
        background: #4b5563;
    }
    .email-verification-section {
        background: linear-gradient(to bottom, #fef3c7 0%, #ffffff 100%);
        border-left: 4px solid #f59e0b;
        border-radius: 0.75rem;
        padding: 1.5rem;
        margin-bottom: 2rem;
    }
    .info-text {
        color: #6b7280;
        font-size: 0.875rem;
        margin-top: 0.5rem;
    }
    .required-badge {
        background: #ef4444;
        color: white;
        padding: 0.25rem 0.5rem;
        border-radius: 0.25rem;
        font-size: 0.75rem;
        margin-left: 0.5rem;
    }
</style>

<div class="profile-page">
    <div class="container-fluid">
        <!-- Page Header -->
        <div class="page-header-card">
            <h2 class="mb-2 fw-bold">
                <i class="fas fa-user-circle me-2"></i>{{ __('common.profile') }}
            </h2>
            <p class="mb-0 opacity-90">
                <i class="fas fa-info-circle me-2"></i>
                {{ __('common.profile_description') }}
            </p>
        </div>

        <!-- Name Format Warning -->
        @if(!$nameFormatCorrect)
        <div class="alert alert-warning">
            <i class="fas fa-exclamation-triangle me-2"></i>
            <strong>{{ __('common.name_format_warning') }}</strong>
            <p class="mb-0 mt-2">{{ __('common.name_format_should_be') }}: <strong>{{ __('common.first_letter_uppercase_rest_lowercase') }}</strong></p>
            <p class="mb-0 mt-1">{{ __('common.current_format') }}: <strong>{{ $driver->name }} {{ $driver->surname }}</strong></p>
            <p class="mb-0 mt-1">{{ __('common.please_correct_surname') }}</p>
        </div>
        @endif

        <!-- Profile Form -->
        <div class="profile-card">
            <form id="profileForm">
                @csrf
                <div class="row">
                    <!-- Name -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label">
                                {{ __('common.name') }}
                                @if(!$canEditName)
                                <span class="required-badge">{{ __('common.cannot_be_changed') }}</span>
                                @endif
                            </label>
                            <input 
                                type="text" 
                                class="form-control" 
                                name="name" 
                                value="{{ $driver->name }}"
                                @if(!$canEditName) disabled @endif
                                @if($canEditName) required @endif
                            >
                            @if(!$canEditName)
                            <small class="info-text">{{ __('common.name_format_correct_cannot_change') }}</small>
                            @endif
                        </div>
                    </div>

                    <!-- Surname -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label">
                                {{ __('common.surname') }}
                                @if(!$canEditSurname)
                                <span class="required-badge">{{ __('common.cannot_be_changed') }}</span>
                                @elseif(!$nameFormatCorrect)
                                <span class="required-badge">{{ __('common.must_be_changed') }}</span>
                                @endif
                            </label>
                            <input 
                                type="text" 
                                class="form-control" 
                                name="surname" 
                                value="{{ $driver->surname }}"
                                @if(!$canEditSurname) disabled @endif
                                required
                            >
                            @if(!$canEditSurname)
                            <small class="info-text">{{ __('common.surname_format_correct_cannot_change') }}</small>
                            @elseif(!$nameFormatCorrect)
                            <small class="info-text text-danger">
                                <i class="fas fa-exclamation-circle me-1"></i>
                                {{ __('common.surname_format_must_be_corrected') }}
                            </small>
                            @endif
                        </div>
                    </div>

                    <!-- Email -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label">
                                {{ __('common.email') }}
                                @if($driver->email_verified_at != null)
                                <span class="required-badge">{{ __('common.cannot_be_changed') }}</span>
                                @endif
                            </label>
                            <input 
                                type="email" 
                                class="form-control" 
                                name="email" 
                                value="{{ $driver->email }}"
                                @if($driver->email_verified_at != null) disabled @endif
                                required
                            >
                            @if($driver->email_verified_at != null)
                            <small class="info-text text-success">
                                <i class="fas fa-check-circle me-1"></i>
                                {{ __('common.email_verified') }} - {{ __('common.verified_at') }}: {{ $driver->email_verified_at ? \Carbon\Carbon::parse($driver->email_verified_at)->format('d.m.Y H:i') : '-' }}
                            </small>
                            @else
                            <small class="info-text">{{ __('common.email_change_will_require_verification') }}</small>
                            <div class="mt-2">
                                <button type="button" class="btn btn-success btn-sm" id="resendVerificationBtn">
                                    <i class="fas fa-paper-plane me-2"></i>
                                    {{ __('common.resend_verification_email') }}
                                </button>
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- Phone -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label">{{ __('common.phone') }}</label>
                            <input 
                                type="tel" 
                                class="form-control" 
                                id="phone" 
                                name="phone" 
                                value="{{ $driver->phone ?? '' }}"
                                style="padding-left: 80px !important;"
                            >
                            <small class="info-text">{{ __('common.phone_format_info') }}</small>
                        </div>
                    </div>

                    <!-- Birth Date -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label">{{ __('common.birth_date') }}</label>
                            <input 
                                type="date" 
                                class="form-control" 
                                name="birth_date" 
                                value="{{ $driver->birth_date ?? '' }}"
                            >
                        </div>
                    </div>

                    <!-- Country -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label">{{ __('common.country') }}</label>
                            <input 
                                type="text" 
                                class="form-control" 
                                name="country" 
                                value="{{ getCountryNameFromCode($driver->country ?? '') }}"
                                disabled
                            >
                            <small class="info-text">{{ __('common.country_auto_detected_from_phone') }}</small>
                        </div>
                    </div>

                    <!-- PSN ID -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label">{{ __('common.psn_id') }}</label>
                            <input 
                                type="text" 
                                class="form-control" 
                                name="psn_id" 
                                value="{{ $driver->psn_id ?? '' }}"
                                maxlength="50"
                            >
                        </div>
                    </div>

                    <!-- Steam ID -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label">{{ __('common.steam_id') }}</label>
                            <input 
                                type="text" 
                                class="form-control" 
                                name="steam_id" 
                                value="{{ $driver->steam_id ?? '' }}"
                                maxlength="50"
                            >
                        </div>
                    </div>

                    <!-- Registration Date (Read-only) -->
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="form-label">{{ __('common.registration_date') }}</label>
                            <input 
                                type="text" 
                                class="form-control" 
                                value="{{ $driver->registration_date ? \Carbon\Carbon::parse($driver->registration_date)->format('d.m.Y H:i') : '-' }}"
                                disabled
                            >
                        </div>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="mt-4">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>
                        {{ __('common.save_changes') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script>
$(document).ready(function() {
    // Telefon numarası için intl-tel-input başlatma
    let phoneIti = null;
    let phoneInput = document.querySelector('#phone');
    
    if (phoneInput) {
        // Mevcut telefon numarasından ülke kodunu belirle
        let initialCountry = 'tr';
        let phoneValue = phoneInput.value; // Veritabanından gelen: +90 (543) 619 27 73
        
        // Input'un value'sunu temizle (intl-tel-input zaten dial code'u ayrı gösteriyor)
        phoneInput.value = '';
        
        // Telefon numarasını temizle ve ülke kodunu belirle
        if (phoneValue) {
            // +90 (543) 619 27 73 formatındaki numarayı +905436192773 formatına çevir
            let cleanedPhone = phoneValue.replace(/\s/g, '').replace(/[()]/g, '');
            
            // Eğer + ile başlamıyorsa düzelt
            if (!cleanedPhone.startsWith('+')) {
                if (cleanedPhone.startsWith('0')) {
                    cleanedPhone = '+90' + cleanedPhone.substring(1);
                } else if (cleanedPhone.startsWith('90')) {
                    cleanedPhone = '+' + cleanedPhone;
                }
            }
            
            // Ülke kodunu belirle
            if (cleanedPhone.startsWith('+90')) {
                initialCountry = 'tr';
            } else if (cleanedPhone.startsWith('+49')) {
                initialCountry = 'de';
            } else if (cleanedPhone.startsWith('+44')) {
                initialCountry = 'gb';
            } else if (cleanedPhone.startsWith('+1')) {
                initialCountry = 'us';
            } else if (cleanedPhone.startsWith('+33')) {
                initialCountry = 'fr';
            } else if (cleanedPhone.startsWith('+39')) {
                initialCountry = 'it';
            } else if (cleanedPhone.startsWith('+34')) {
                initialCountry = 'es';
            } else if (cleanedPhone.startsWith('+351')) {
                initialCountry = 'pt';
            }
        }
        
        // intl-tel-input'u başlat (dial code ayrı gösterilecek)
        phoneIti = window.intlTelInput(phoneInput, {
            initialCountry: initialCountry,
            preferredCountries: ["tr", "us", "gb", "de", "fr", "it", "es", "pt"],
            separateDialCode: true,
            nationalMode: false,
            autoFormat: false,
            autoPlaceholder: "aggressive",
            utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/20.1.0/js/utils.js"
        });
        
        // IMask ile telefon numarası formatlama (sadece ulusal numara kısmı için)
        let phoneMask = null;
        
        function updatePhoneMask() {
            if (phoneMask) {
                phoneMask.destroy();
            }
            
            const countryData = phoneIti.getSelectedCountryData();
            const countryCode = countryData.iso2;
            
            // Ülkeye göre maske tanımlamaları (sadece ulusal numara için)
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
            
            // separateDialCode: true olduğu için input sadece ulusal numarayı içerir
            phoneMask = IMask(phoneInput, {
                mask: maskPattern,
                lazy: false
            });
        }
        
        // Mevcut telefon numarasını set et (temizlenmiş format ile)
        if (phoneValue) {
            let cleanedPhone = phoneValue.replace(/\s/g, '').replace(/[()]/g, '');
            
            // Eğer + ile başlamıyorsa düzelt
            if (!cleanedPhone.startsWith('+')) {
                if (cleanedPhone.startsWith('0')) {
                    cleanedPhone = '+90' + cleanedPhone.substring(1);
                } else if (cleanedPhone.startsWith('90')) {
                    cleanedPhone = '+' + cleanedPhone;
                }
            }
            
            // intl-tel-input'a tam numarayı ver (o ulusal numarayı çıkaracak)
            phoneIti.setNumber(cleanedPhone);
            
            // intl-tel-input'un numarayı ayarlamasını bekle, sonra maskeyi uygula
            setTimeout(function() {
                updatePhoneMask();
            }, 150);
        } else {
            // İlk maske oluşturma
            updatePhoneMask();
        }
        
        // Ülke değiştiğinde maske'yi güncelle
        phoneInput.addEventListener('countrychange', function() {
            updatePhoneMask();
        });
    }
    
    // Form submit
    $('#profileForm').on('submit', function(e) {
        e.preventDefault();
        
        // Form submit edilmeden önce telefon numarasını formatla
        let formattedPhone = '';
        if (phoneIti) {
            const countryData = phoneIti.getSelectedCountryData();
            const dialCode = countryData.dialCode;
            const countryCode = countryData.iso2;
            
            // Mask'ten ulusal numarayı al (sadece rakamlar)
            let nationalNumber = phoneInput.value.replace(/\D/g, '');
            
            // Eğer ulusal numara varsa formatla
            if (nationalNumber) {
                if (dialCode === '90' && countryCode === 'tr') {
                    // Türkiye formatı: +90 (543) 619 27 73
                    if (nationalNumber.length === 10) {
                        formattedPhone = '+' + dialCode + ' (' + nationalNumber.substring(0, 3) + ') ' + 
                                         nationalNumber.substring(3, 6) + ' ' + 
                                         nationalNumber.substring(6, 8) + ' ' + 
                                         nationalNumber.substring(8, 10);
                    } else {
                        formattedPhone = '+' + dialCode + ' ' + nationalNumber;
                    }
                } else if (dialCode === '49' && countryCode === 'de') {
                    // Almanya formatı: +49 123 4567890
                    formattedPhone = '+' + dialCode + ' ' + nationalNumber;
                } else if (dialCode === '44' && countryCode === 'gb') {
                    // İngiltere formatı: +44 1234 567890
                    formattedPhone = '+' + dialCode + ' ' + nationalNumber;
                } else if (dialCode === '1' && countryCode === 'us') {
                    // ABD formatı: +1 (123) 456-7890
                    if (nationalNumber.length === 10) {
                        formattedPhone = '+' + dialCode + ' (' + nationalNumber.substring(0, 3) + ') ' + 
                                         nationalNumber.substring(3, 6) + '-' + 
                                         nationalNumber.substring(6, 10);
                    } else {
                        formattedPhone = '+' + dialCode + ' ' + nationalNumber;
                    }
                } else if (dialCode === '33' && countryCode === 'fr') {
                    // Fransa formatı: +33 1 23 45 67 89
                    formattedPhone = '+' + dialCode + ' ' + nationalNumber;
                } else if (dialCode === '39' && countryCode === 'it') {
                    // İtalya formatı: +39 123 456 7890
                    formattedPhone = '+' + dialCode + ' ' + nationalNumber;
                } else if (dialCode === '34' && countryCode === 'es') {
                    // İspanya formatı: +34 123 456 789
                    formattedPhone = '+' + dialCode + ' ' + nationalNumber;
                } else if (dialCode === '351' && countryCode === 'pt') {
                    // Portekiz formatı: +351 123 456 789
                    formattedPhone = '+' + dialCode + ' ' + nationalNumber;
                } else {
                    // Diğer ülkeler için basit format: +XX 1234567890
                    formattedPhone = '+' + dialCode + ' ' + nationalNumber;
                }
            }
            
            // Formatlanmış telefon numarasını input'a yaz (gönderim için)
            phoneInput.value = formattedPhone;
        }
        
        const formData = $(this).serialize();
        const submitBtn = $(this).find('button[type="submit"]');
        const originalText = submitBtn.html();
        
        submitBtn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin me-2"></i>{{ __('common.saving') }}...');
        
        $.ajax({
            url: '{{ route("driver.profile.update") }}',
            method: 'POST',
            data: formData,
            success: function(response) {
                if (response.hata == 0) {
                    // Success message
                    const alert = $('<div class="alert alert-success"><i class="fas fa-check-circle me-2"></i>' + response.aciklama + '</div>');
                    $('.profile-card').prepend(alert);
                    
                    // Scroll to top
                    $('html, body').animate({ scrollTop: 0 }, 500);
                    
                    // Remove alert after 5 seconds
                    setTimeout(function() {
                        alert.fadeOut(500, function() {
                            $(this).remove();
                        });
                    }, 5000);
                    
                    // Reload page after 2 seconds to update session
                    setTimeout(function() {
                        window.location.reload();
                    }, 2000);
                } else {
                    // Error message
                    const alert = $('<div class="alert alert-danger"><i class="fas fa-exclamation-circle me-2"></i>' + response.aciklama + '</div>');
                    $('.profile-card').prepend(alert);
                    
                    // Scroll to top
                    $('html, body').animate({ scrollTop: 0 }, 500);
                    
                    // Remove alert after 5 seconds
                    setTimeout(function() {
                        alert.fadeOut(500, function() {
                            $(this).remove();
                        });
                    }, 5000);
                }
            },
            error: function(xhr) {
                let errorMessage = '{{ __('common.an_error_occurred') }}';
                if (xhr.responseJSON && xhr.responseJSON.aciklama) {
                    errorMessage = xhr.responseJSON.aciklama;
                }
                
                const alert = $('<div class="alert alert-danger"><i class="fas fa-exclamation-circle me-2"></i>' + errorMessage + '</div>');
                $('.profile-card').prepend(alert);
                
                // Scroll to top
                $('html, body').animate({ scrollTop: 0 }, 500);
                
                // Remove alert after 5 seconds
                setTimeout(function() {
                    alert.fadeOut(500, function() {
                        $(this).remove();
                    });
                }, 5000);
            },
            complete: function() {
                submitBtn.prop('disabled', false).html(originalText);
            }
        });
    });

    // Resend verification email (e-posta alanının altındaki buton)
    $(document).on('click', '#resendVerificationBtn', function() {
        const btn = $(this);
        const originalText = btn.html();
        
        btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin me-2"></i>{{ __('common.sending') }}...');
        
        $.ajax({
            url: '{{ route("driver.profile.resendVerification") }}',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                if (response.hata == 0) {
                    const alert = $('<div class="alert alert-success mt-2"><i class="fas fa-check-circle me-2"></i>' + response.aciklama + '</div>');
                    $('#resendVerificationBtn').closest('.form-group').find('small, .alert').last().after(alert);
                    
                    // Scroll to email field
                    $('html, body').animate({ scrollTop: $('input[name="email"]').offset().top - 100 }, 500);
                    
                    // Remove alert after 5 seconds
                    setTimeout(function() {
                        alert.fadeOut(500, function() {
                            $(this).remove();
                        });
                    }, 5000);
                } else {
                    const alert = $('<div class="alert alert-danger mt-2"><i class="fas fa-exclamation-circle me-2"></i>' + response.aciklama + '</div>');
                    $('#resendVerificationBtn').closest('.form-group').find('small, .alert').last().after(alert);
                    
                    // Scroll to email field
                    $('html, body').animate({ scrollTop: $('input[name="email"]').offset().top - 100 }, 500);
                    
                    // Remove alert after 5 seconds
                    setTimeout(function() {
                        alert.fadeOut(500, function() {
                            $(this).remove();
                        });
                    }, 5000);
                }
            },
            error: function(xhr) {
                let errorMessage = '{{ __('common.an_error_occurred') }}';
                if (xhr.responseJSON && xhr.responseJSON.aciklama) {
                    errorMessage = xhr.responseJSON.aciklama;
                }
                
                const alert = $('<div class="alert alert-danger mt-2"><i class="fas fa-exclamation-circle me-2"></i>' + errorMessage + '</div>');
                $('#resendVerificationBtn').closest('.form-group').find('small, .alert').last().after(alert);
                    
                    // Scroll to email field
                    $('html, body').animate({ scrollTop: $('input[name="email"]').offset().top - 100 }, 500);
                    
                    // Remove alert after 5 seconds
                    setTimeout(function() {
                        alert.fadeOut(500, function() {
                            $(this).remove();
                        });
                    }, 5000);
            },
            complete: function() {
                btn.prop('disabled', false).html(originalText);
            }
        });
    });
});
</script>
<style>
    /* intl-tel-input stilleri */
    .iti {
        width: 100%;
    }
    .iti__flag-container {
        background: white;
        border-right: 2px solid #e5e7eb;
    }
    .iti__selected-flag {
        background: white;
        border-radius: 0.5rem 0 0 0.5rem;
        padding: 0.75rem 10px;
    }
    .iti__selected-flag:hover {
        background: #f9fafb;
    }
    .iti__arrow {
        border-top-color: #6b7280;
    }
    .iti__country-list {
        background: white !important;
        border: 2px solid #e5e7eb !important;
        color: #374151 !important;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1) !important;
    }
    .iti__country {
        color: #374151 !important;
    }
    .iti__country:hover,
    .iti__country.iti__highlight {
        background: #f3f4f6 !important;
    }
    .iti__dial-code {
        color: #6b7280;
    }
    #phone {
        padding-left: 80px !important;
    }
</style>
@endsection


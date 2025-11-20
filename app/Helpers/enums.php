<?php

if (!function_exists('enums')) {
    function enums()
    {
        static $enums = null;
        
        if ($enums === null) {
            $enums = [
                // Şikayet Ayarları
                'complaint_max_count' => 10, // Sezon başına maksimum şikayet hakkı
                'complaint_time_limit_minutes' => 240, // Yarıştan sonra şikayet yapılabilir süre (dakika) - 4 saat
                'complaint_delete_time_seconds' => 600, // Şikayet yapıldıktan sonra silinebilir süre (saniye) - 10 dakika

                // Savunma Ayarları
                'defense_time_limit_minutes' => 1440, // Şikayetten sonra savunma yapılabilir süre (dakika) - 24 saat

                // İtiraz Ayarları
                'appeal_max_count' => 3, // Sezon başına maksimum itiraz hakkı
                'appeal_time_limit_days' => 3, // Yarıştan sonra itiraz yapılabilir süre (gün)

                // Ülke Kodları ve İsimleri
                'countries' => [
                    'tr' => 'Türkiye',
                    'de' => 'Almanya',
                    'en' => 'İngiltere',
                    'us' => 'Amerika Birleşik Devletleri',
                    'fr' => 'Fransa',
                    'it' => 'İtalya',
                    'es' => 'İspanya',
                    'pt' => 'Portekiz',
                    'nl' => 'Hollanda',
                    'be' => 'Belçika',
                    'at' => 'Avusturya',
                    'ch' => 'İsviçre',
                    'pl' => 'Polonya',
                    'cz' => 'Çek Cumhuriyeti',
                    'gr' => 'Yunanistan',
                    'ro' => 'Romanya',
                    'hu' => 'Macaristan',
                    'se' => 'İsveç',
                    'no' => 'Norveç',
                    'dk' => 'Danimarka',
                    'fi' => 'Finlandiya',
                    'ie' => 'İrlanda',
                    'ru' => 'Rusya',
                    'ua' => 'Ukrayna',
                    'bg' => 'Bulgaristan',
                    'hr' => 'Hırvatistan',
                    'sk' => 'Slovakya',
                    'si' => 'Slovenya',
                    'ee' => 'Estonya',
                    'lv' => 'Letonya',
                    'lt' => 'Litvanya',
                    'az' => 'Azerbaycan',
                    'ge' => 'Gürcistan',
                    'sa' => 'Suudi Arabistan',
                    'ae' => 'Birleşik Arap Emirlikleri',
                    'eg' => 'Mısır',
                    'ma' => 'Fas',
                    'tn' => 'Tunus',
                    'dz' => 'Cezayir',
                    'jo' => 'Ürdün',
                    'lb' => 'Lübnan',
                    'iq' => 'Irak',
                    'ir' => 'İran',
                    'il' => 'İsrail',
                    'jp' => 'Japonya',
                    'kr' => 'Güney Kore',
                    'cn' => 'Çin',
                    'in' => 'Hindistan',
                    'au' => 'Avustralya',
                    'nz' => 'Yeni Zelanda',
                    'br' => 'Brezilya',
                    'ar' => 'Arjantin',
                    'mx' => 'Meksika',
                    'ca' => 'Kanada',
                ],

                // Telefon Ülke Kodları (dial code -> country code)
                'phone_country_codes' => [
                    '+90' => 'tr',
                    '+49' => 'de',
                    '+44' => 'en',
                    '+1' => 'us',
                    '+33' => 'fr',
                    '+39' => 'it',
                    '+34' => 'es',
                    '+351' => 'pt',
                    '+31' => 'nl',
                    '+32' => 'be',
                    '+43' => 'at',
                    '+41' => 'ch',
                    '+48' => 'pl',
                    '+420' => 'cz',
                    '+30' => 'gr',
                    '+40' => 'ro',
                    '+36' => 'hu',
                    '+46' => 'se',
                    '+47' => 'no',
                    '+45' => 'dk',
                    '+358' => 'fi',
                    '+353' => 'ie',
                    '+7' => 'ru',
                    '+380' => 'ua',
                    '+359' => 'bg',
                    '+385' => 'hr',
                    '+421' => 'sk',
                    '+386' => 'si',
                    '+372' => 'ee',
                    '+371' => 'lv',
                    '+370' => 'lt',
                    '+994' => 'az',
                    '+995' => 'ge',
                    '+966' => 'sa',
                    '+971' => 'ae',
                    '+20' => 'eg',
                    '+212' => 'ma',
                    '+216' => 'tn',
                    '+213' => 'dz',
                    '+962' => 'jo',
                    '+961' => 'lb',
                    '+964' => 'iq',
                    '+98' => 'ir',
                    '+972' => 'il',
                    '+81' => 'jp',
                    '+82' => 'kr',
                    '+86' => 'cn',
                    '+91' => 'in',
                    '+61' => 'au',
                    '+64' => 'nz',
                    '+55' => 'br',
                    '+54' => 'ar',
                    '+52' => 'mx',
                    '+1' => 'ca',
                ],
            ];
        }
        
        return $enums;
    }
}

// Telefon numarasından ülke kodunu çıkaran fonksiyon
if (!function_exists('getCountryCodeFromPhone')) {
    function getCountryCodeFromPhone($phone)
    {
        if (empty($phone)) {
            return 'tr'; // Varsayılan olarak Türkiye
        }

        // Telefon numarasından + işaretini ve başındaki boşlukları temizle
        $phone = trim($phone);
        
        // + ile başlamıyorsa ekle
        if (substr($phone, 0, 1) !== '+') {
            $phone = '+' . $phone;
        }

        $enums = enums();
        $phoneCountryCodes = $enums['phone_country_codes'] ?? [];

        // En uzun kodlardan başlayarak kontrol et (örn: +351 önce +3'ten önce kontrol edilmeli)
        $sortedCodes = array_keys($phoneCountryCodes);
        usort($sortedCodes, function($a, $b) {
            return strlen($b) - strlen($a);
        });

        foreach ($sortedCodes as $dialCode) {
            if (strpos($phone, $dialCode) === 0) {
                return $phoneCountryCodes[$dialCode];
            }
        }

        // Eşleşme bulunamazsa varsayılan olarak Türkiye
        return 'tr';
    }
}

// Ülke kodundan ülke adını döndüren fonksiyon
if (!function_exists('getCountryNameFromCode')) {
    function getCountryNameFromCode($countryCode)
    {
        if (empty($countryCode)) {
            return '-';
        }

        $enums = enums();
        $countries = $enums['countries'] ?? [];

        return $countries[$countryCode] ?? $countryCode;
    }
}


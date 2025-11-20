<?php

if (!function_exists('tarihBicimi')) {
    function tarihBicimi($datetime, $format = null)
    {
        $date = date_create($datetime);

        $months = [
            '01' => 'Ocak',
            '02' => 'Şubat',
            '03' => 'Mart',
            '04' => 'Nisan',
            '05' => 'Mayıs',
            '06' => 'Haziran',
            '07' => 'Temmuz',
            '08' => 'Ağustos',
            '09' => 'Eylül',
            '10' => 'Ekim',
            '11' => 'Kasım',
            '12' => 'Aralık'
        ];

        $day = date_format($date, 'j');
        $month = $months[date_format($date, 'm')];
        $year = date_format($date, 'Y');
        $time = date_format($date, 'H:i');

        if($format == 1){
            return "$day $month $year";
        }
        if($format == 4){
            return "$day $month $year $time";
        }
        return "$day $month $year $time";
    }
}

if (!function_exists('driverSlug')) {
    function driverSlug($name, $surname, $id)
    {
        // Türkçe karakterleri dönüştür
        $turkish = ['ç', 'Ç', 'ğ', 'Ğ', 'ı', 'İ', 'ö', 'Ö', 'ş', 'Ş', 'ü', 'Ü'];
        $english = ['c', 'C', 'g', 'G', 'i', 'I', 'o', 'O', 's', 'S', 'u', 'U'];
        
        $name = str_replace($turkish, $english, mb_strtolower($name, 'UTF-8'));
        $surname = str_replace($turkish, $english, mb_strtolower($surname, 'UTF-8'));
        
        // Özel karakterleri temizle ve boşlukları tire ile değiştir
        $name = preg_replace('/[^a-z0-9]+/', '-', $name);
        $surname = preg_replace('/[^a-z0-9]+/', '-', $surname);
        
        // Başta ve sonda tire varsa temizle
        $name = trim($name, '-');
        $surname = trim($surname, '-');
        
        return $name . '-' . $surname . '-' . $id;
    }
}

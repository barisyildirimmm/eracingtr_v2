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
        return "$day $month $year $time";
    }
}

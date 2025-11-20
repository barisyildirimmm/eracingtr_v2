<?php

namespace App\Http\Controllers\driverPanel;

use App\Http\Controllers\Controller;
use App\Mail\Mailler;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class profileController extends Controller
{
    function index()
    {
        $driverId = session('driverInfo')->id;
        $driver = DB::table('drivers')->where('id', $driverId)->first();

        // İsim soyisim format kontrolü
        $nameFormatCorrect = $this->checkNameFormat($driver->name, $driver->surname);
        $canEditName = !$nameFormatCorrect;
        // Soyadı formatı doğruysa değiştirilemez, yanlışsa değiştirilebilir
        $canEditSurname = !$nameFormatCorrect;

        return view('driverPanel.profile.index', compact(
            'driver',
            'nameFormatCorrect',
            'canEditName',
            'canEditSurname'
        ));
    }

    function update(Request $request)
    {
        $driverId = session('driverInfo')->id;
        $driver = DB::table('drivers')->where('id', $driverId)->first();

        // İsim soyisim format kontrolü
        $nameFormatCorrect = $this->checkNameFormat($driver->name, $driver->surname);
        $canEditName = !$nameFormatCorrect;
        $canEditSurname = !$nameFormatCorrect;

        $rules = [];
        $messages = [];

        // İsim kontrolü
        if ($canEditName) {
            $rules['name'] = 'required|string|max:60';
            $messages['name.required'] = __('common.name_enter');
        } else {
            // İsim formatı doğruysa ve değiştirilmeye çalışılıyorsa engelle
            if ($request->name && $request->name != $driver->name) {
                return response()->json([
                    'hata' => 1,
                    'aciklama' => __('common.name_format_correct_cannot_change')
                ]);
            }
        }

        // Soyisim kontrolü
        if ($canEditSurname) {
            $rules['surname'] = 'required|string|max:60';
            $messages['surname.required'] = __('common.surname_enter');
        } else {
            // Soyad formatı doğruysa ve değiştirilmeye çalışılıyorsa engelle
            if ($request->surname && $request->surname != $driver->surname) {
                return response()->json([
                    'hata' => 1,
                    'aciklama' => __('common.surname_format_correct_cannot_change')
                ]);
            }
            // Soyad değiştirilemezse de validation için ekle
            $rules['surname'] = 'required|string|max:60';
            $messages['surname.required'] = __('common.surname_enter');
        }

        // Diğer alanlar
        $rules['psn_id'] = 'nullable|string|max:50';
        $rules['steam_id'] = 'nullable|string|max:50';
        // Ülke alanı telefon numarasından otomatik belirlenir, manuel değiştirilemez
        $rules['phone'] = 'nullable|string|max:50';
        $rules['birth_date'] = 'nullable|date';

        // Email kontrolü (eğer değiştiriliyorsa ve email doğrulanmamışsa)
        if ($request->email && $request->email != $driver->email) {
            // Email doğrulanmışsa değiştirilemez
            if ($driver->email_verified_at != null) {
                return response()->json([
                    'hata' => 1,
                    'aciklama' => __('common.email_verified_cannot_change')
                ]);
            }
            $rules['email'] = 'required|email|unique:drivers,email';
            $messages['email.required'] = __('common.email_enter');
            $messages['email.email'] = __('common.email_valid');
            $messages['email.unique'] = __('common.email_unique_in_use');
        }

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return response()->json([
                'hata' => 1,
                'aciklama' => $validator->errors()->first()
            ]);
        }

        // Güncelleme verileri
        $updateData = [];

        if ($canEditName && $request->name) {
            $updateData['name'] = $request->name;
        }

        if ($canEditSurname && $request->surname) {
            $updateData['surname'] = $request->surname;
        }

        if ($request->has('psn_id')) {
            $updateData['psn_id'] = $request->psn_id;
        }

        if ($request->has('steam_id')) {
            $updateData['steam_id'] = $request->steam_id;
        }

        // Telefon numarası değiştirilirse, ülke kodunu otomatik güncelle
        if ($request->has('phone') && $request->phone != $driver->phone) {
            $updateData['phone'] = $request->phone;
            $updateData['country'] = getCountryCodeFromPhone($request->phone);
        }

        if ($request->has('birth_date')) {
            $updateData['birth_date'] = $request->birth_date;
        }

        // Email değişikliği
        if ($request->email && $request->email != $driver->email) {
            $updateData['email'] = $request->email;
            $updateData['email_verified_at'] = null;
            $updateData['is_email_verified'] = 0;
            $updateData['email_verification_token'] = Str::random(40);
        }

        // Veritabanını güncelle
        if (!empty($updateData)) {
            DB::table('drivers')->where('id', $driverId)->update($updateData);

            // Session'ı güncelle
            $updatedDriver = DB::table('drivers')->where('id', $driverId)->first();
            session(['driverInfo' => $updatedDriver]);

            // Eğer email değiştirildiyse doğrulama maili gönder
            if (isset($updateData['email']) && $updateData['email'] != $driver->email) {
                $userInfo = [
                    'name' => $updatedDriver->name,
                    'surname' => $updatedDriver->surname,
                    'email' => $updatedDriver->email,
                    'email_verification_token' => $updatedDriver->email_verification_token,
                ];
                // Driver'ın ülke kodundan dil kodunu belirle
                $locale = getLocaleFromCountryCode($updatedDriver->country);
                // Mail'i queue'ya al (asenkron gönderim)
                Mail::to($updatedDriver->email)->queue(new Mailler($userInfo, 'mails.register', __('common.mail_welcome_title'), $locale, 'common.mail_welcome_title'));
            }
        }

        return response()->json([
            'hata' => 0,
            'aciklama' => __('common.profile_updated_success')
        ]);
    }

    function resendVerificationEmail()
    {
        $driverId = session('driverInfo')->id;
        $driver = DB::table('drivers')->where('id', $driverId)->first();

        if ($driver->email_verified_at != null) {
            return response()->json([
                'hata' => 1,
                'aciklama' => __('common.account_already_verified')
            ]);
        }

        // Yeni token oluştur
        $newToken = Str::random(40);
        DB::table('drivers')->where('id', $driverId)->update([
            'email_verification_token' => $newToken
        ]);

        // Mail gönder (queue'ya al - asenkron gönderim)
        $userInfo = [
            'name' => $driver->name,
            'surname' => $driver->surname,
            'email' => $driver->email,
            'email_verification_token' => $newToken,
        ];
        // Driver'ın ülke kodundan dil kodunu belirle
        $locale = getLocaleFromCountryCode($driver->country);
        Mail::to($driver->email)->queue(new Mailler($userInfo, 'mails.register', __('common.mail_welcome_title'), $locale, 'common.mail_welcome_title'));

        return response()->json([
            'hata' => 0,
            'aciklama' => __('common.verification_email_sent')
        ]);
    }

    /**
     * İsim ve soyisim formatını kontrol eder
     * Doğru format: İlk harf büyük, geri kalanı küçük (örn: "İsim Soyisim")
     */
    private function checkNameFormat($name, $surname)
    {
        if (empty($name) || empty($surname)) {
            return false;
        }

        // İsim kontrolü: İlk harf büyük, geri kalanı küçük olmalı
        $nameLower = mb_strtolower($name, 'UTF-8');
        $nameFirstChar = mb_substr($nameLower, 0, 1, 'UTF-8');
        $nameRest = mb_substr($nameLower, 1, null, 'UTF-8');
        $nameExpected = mb_strtoupper($nameFirstChar, 'UTF-8') . $nameRest;
        $nameCorrect = $name === $nameExpected;
        
        // Soyisim kontrolü: İlk harf büyük, geri kalanı küçük olmalı
        $surnameLower = mb_strtolower($surname, 'UTF-8');
        $surnameFirstChar = mb_substr($surnameLower, 0, 1, 'UTF-8');
        $surnameRest = mb_substr($surnameLower, 1, null, 'UTF-8');
        $surnameExpected = mb_strtoupper($surnameFirstChar, 'UTF-8') . $surnameRest;
        $surnameCorrect = $surname === $surnameExpected;

        return $nameCorrect && $surnameCorrect;
    }
}


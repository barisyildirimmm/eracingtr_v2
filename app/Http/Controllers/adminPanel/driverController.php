<?php

namespace App\Http\Controllers\adminPanel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class driverController extends Controller
{
    public function listDrivers()
    {
        $drivers = DB::table('drivers')->get();
        
        // Ülke kodlarını ülke adlarına çevir
        foreach ($drivers as $driver) {
            if ($driver->country) {
                $driver->country_display = getCountryNameFromCode($driver->country);
            } else {
                $driver->country_display = '-';
            }
        }
        
        return view('adminPanel.drivers.list', ['drivers' => $drivers]);
    }

    public function createDriver(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'surname' => 'required|string|max:255',
            'email' => 'required|email|unique:drivers,email',
            'password' => 'required|string|min:6',
            'steam_id' => 'required|string|max:255',
            'country' => 'required|string|max:255',
            'phone' => 'required|string|max:50|unique:drivers,phone',
            'birth_date' => 'required|date',
            'status' => 'required|string|max:50',
        ], [
            'name.required' => __('common.name_required'),
            'surname.required' => __('common.surname_required'),
            'email.required' => __('common.email_required'),
            'email.email' => __('common.email_email'),
            'email.unique' => __('common.email_unique'),
            'password.required' => __('common.password_required'),
            'password.min' => __('common.password_min'),
            'steam_id.required' => __('common.steam_id_required'),
            'country.required' => __('common.country_required'),
            'phone.required' => __('common.phone_required'),
            'phone.unique' => __('common.phone_unique'),
            'birth_date.required' => __('common.birth_date_required'),
            'status.required' => __('common.status_required')
        ]);

        if ($validator->fails()) {
            return response()->json([
                'hata' => 1,
                'aciklama' => $validator->errors()->first()
            ]);
        }

        DB::table('drivers')->insert([
            'name' => $request->name,
            'surname' => $request->surname,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'steam_id' => $request->steam_id,
            'country' => $request->country,
            'phone' => $request->phone,
            'birth_date' => $request->birth_date,
            'status' => $request->status,
        ]);

        return response()->json([
            'hata' => 0,
            'aciklama' => __('common.driver_created')
        ]);
    }
    public function editDriver(Request $request, $id)
    {
        $driver = DB::table('drivers')->where('id', $id)->first();
        
        if (!$driver) {
            return response()->json([
                'hata' => 1,
                'aciklama' => __('common.driver_not_found')
            ]);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|required|string|max:255',
            'surname' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|email|unique:drivers,email,' . $id,
            'steam_id' => 'sometimes|nullable|string|max:255',
            'psn_id' => 'sometimes|nullable|string|max:50',
            'phone' => 'sometimes|required|string|max:50|unique:drivers,phone,' . $id,
            'birth_date' => 'sometimes|required|date',
            'status' => 'sometimes|required|string|max:50',
        ], [
            'name.required' => __('common.name_required'),
            'surname.required' => __('common.surname_required'),
            'email.required' => __('common.email_required'),
            'email.email' => __('common.email_email'),
            'email.unique' => __('common.email_unique'),
            'steam_id.required' => __('common.steam_id_required'),
            'country.required' => __('common.country_required'),
            'phone.required' => __('common.phone_required'),
            'phone.unique' => __('common.phone_unique'),
            'birth_date.required' => __('common.birth_date_required'),
            'status.required' => __('common.status_required')
        ]);

        if ($validator->fails()) {
            return response()->json([
                'hata' => 1,
                'aciklama' => $validator->errors()->first()
            ]);
        }

        $updateData = array_filter([
            'name' => $request->name,
            'surname' => $request->surname,
            'email' => $request->email,
            'password' => $request->password ? Hash::make($request->password) : null,
            'steam_id' => $request->steam_id,
            'psn_id' => $request->psn_id,
            'phone' => $request->phone,
            'birth_date' => $request->birth_date,
            'status' => $request->status
        ]);

        // Telefon numarası değiştirilirse, ülke kodunu otomatik güncelle
        if (isset($updateData['phone']) && $updateData['phone'] != $driver->phone) {
            $updateData['country'] = getCountryCodeFromPhone($updateData['phone']);
        }

        DB::table('drivers')->where('id', $id)->update($updateData);

        return response()->json([
            'hata' => 0,
            'aciklama' => __('common.driver_updated')
        ]);
    }
    public function deleteDriver($id)
    {
        $driver = DB::table('drivers')->where('id', $id)->first();

        if (!$driver) {
            return response()->json([
                'hata' => 1,
                'aciklama' => __('common.driver_not_found')
            ]);
        }

        DB::table('drivers')->where('id', $id)->delete();

        return response()->json([
            'hata' => 0,
            'aciklama' => __('common.driver_deleted')
        ]);
    }
    
    public function listDriversLeagues($id)
    {
        $drivers = DB::table('drivers')->get();
        return view('adminPanel.drivers.list', ['drivers' => $drivers]);
    }

    public function verifyEmail($id)
    {
        $driver = DB::table('drivers')->where('id', $id)->first();

        if (!$driver) {
            return response()->json([
                'hata' => 1,
                'aciklama' => __('common.driver_not_found')
            ]);
        }

        // E-posta onayla
        DB::table('drivers')->where('id', $id)->update([
            'email_verified_at' => now(),
            'is_email_verified' => 1
        ]);

        // Otomatik status kontrolü
        $this->checkAndUpdateStatus($id);

        return response()->json([
            'hata' => 0,
            'aciklama' => __('common.email_verified_success')
        ]);
    }

    public function verifyPhone($id)
    {
        $driver = DB::table('drivers')->where('id', $id)->first();

        if (!$driver) {
            return response()->json([
                'hata' => 1,
                'aciklama' => __('common.driver_not_found')
            ]);
        }

        // Telefon onayla
        DB::table('drivers')->where('id', $id)->update([
            'phone_verified_at' => now(),
            'is_phone_verified' => 1
        ]);

        // Otomatik status kontrolü
        $this->checkAndUpdateStatus($id);

        return response()->json([
            'hata' => 0,
            'aciklama' => __('common.phone_verified_success')
        ]);
    }

    /**
     * İsim ve soyisim formatını kontrol eder ve gerekirse status'u günceller
     */
    private function checkAndUpdateStatus($driverId)
    {
        $driver = DB::table('drivers')->where('id', $driverId)->first();

        if (!$driver) {
            return;
        }

        // E-posta ve telefon onaylı mı kontrol et
        $emailVerified = $driver->is_email_verified == 1 && $driver->email_verified_at != null;
        $phoneVerified = $driver->is_phone_verified == 1 && $driver->phone_verified_at != null;

        if (!$emailVerified || !$phoneVerified) {
            return; // İkisi de onaylı değilse status güncelleme
        }

        // İsim soyisim format kontrolü
        $nameFormatCorrect = $this->checkNameFormat($driver->name, $driver->surname);

        if ($nameFormatCorrect) {
            // İkisi de onaylı ve isim formatı doğruysa status'u 1 (aktif) yap
            DB::table('drivers')->where('id', $driverId)->update([
                'status' => 1,
            ]);
        }
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

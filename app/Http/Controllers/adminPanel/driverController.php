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
            'phone' => 'required|string|max:15',
            'birth_date' => 'required|date',
            'status' => 'required|string|max:50',
        ], [
            'name.required' => 'İsim alanı zorunludur.',
            'surname.required' => 'Soyisim alanı zorunludur.',
            'email.required' => 'E-posta alanı zorunludur.',
            'email.email' => 'E-posta adresi geçerli bir formatta olmalıdır.',
            'email.unique' => 'Bu e-posta adresi zaten kayıtlı.',
            'password.required' => 'Şifre alanı zorunludur.',
            'password.min' => 'Şifre en az 6 karakter olmalıdır.',
            'steam_id.required' => 'Steam ID alanı zorunludur.',
            'country.required' => 'Ülke alanı zorunludur.',
            'phone.required' => 'Telefon numarası alanı zorunludur.',
            'birth_date.required' => 'Doğum tarihi alanı zorunludur.',
            'status.required' => 'Durum alanı zorunludur.'
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
            'created_at' => now(),
            'updated_at' => now()
        ]);

        return response()->json([
            'hata' => 0,
            'aciklama' => 'Sürücü başarıyla oluşturuldu.'
        ]);
    }
    public function editDriver(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|required|string|max:255',
            'surname' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|email|unique:drivers,email,' . $id,
            'password' => 'sometimes|required|string|min:6',
            'steam_id' => 'sometimes|required|string|max:255',
            'country' => 'sometimes|required|string|max:255',
            'phone' => 'sometimes|required|string|max:15',
            'birth_date' => 'sometimes|required|date',
            'status' => 'sometimes|required|string|max:50',
        ], [
            'name.required' => 'İsim alanı zorunludur.',
            'surname.required' => 'Soyisim alanı zorunludur.',
            'email.required' => 'E-posta alanı zorunludur.',
            'email.email' => 'E-posta adresi geçerli bir formatta olmalıdır.',
            'email.unique' => 'Bu e-posta adresi zaten kayıtlı.',
            'password.min' => 'Şifre en az 6 karakter olmalıdır.',
            'steam_id.required' => 'Steam ID alanı zorunludur.',
            'country.required' => 'Ülke alanı zorunludur.',
            'phone.required' => 'Telefon numarası alanı zorunludur.',
            'birth_date.required' => 'Doğum tarihi alanı zorunludur.',
            'status.required' => 'Durum alanı zorunludur.'
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
            'country' => $request->country,
            'phone' => $request->phone,
            'birth_date' => $request->birth_date,
            'status' => $request->status,
            'updated_at' => now()
        ]);

        DB::table('drivers')->where('id', $id)->update($updateData);

        return response()->json([
            'hata' => 0,
            'aciklama' => 'Sürücü başarıyla güncellendi.'
        ]);
    }
    public function deleteDriver($id)
    {
        $driver = DB::table('drivers')->where('id', $id)->first();

        if (!$driver) {
            return response()->json([
                'hata' => 1,
                'aciklama' => 'Sürücü bulunamadı.'
            ]);
        }

        DB::table('drivers')->where('id', $id)->delete();

        return response()->json([
            'hata' => 0,
            'aciklama' => 'Sürücü başarıyla silindi.'
        ]);
    }
}

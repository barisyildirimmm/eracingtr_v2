<?php

namespace App\Http\Controllers\adminPanel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class adminController extends Controller
{
    public function listAdmins()
    {
        $admins = DB::table('admins')->select('id', 'name', 'surname', 'user_name')->get();
        return view('adminPanel.admins.list', ['admins' => $admins]);
    }

    public function createAdmin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:100',
            'surname' => 'required|string|max:100',
            'user_name' => 'required|string|max:100|unique:admins,user_name',
            'password' => 'required|string|min:6|max:100',
        ], [
            'name.required' => 'Adı alanı zorunludur.',
            'surname.required' => 'Soyadı alanı zorunludur.',
            'user_name.required' => 'Kullanıcı adı alanı zorunludur.',
            'user_name.unique' => 'Bu kullanıcı adı zaten alınmış.',
            'password.required' => 'Şifre alanı zorunludur.',
            'password.min' => 'Şifre en az 6 karakter olmalıdır.',
        ]);


        if ($validator->fails()) {
            return response()->json([
                'hata' => 1,
                'aciklama' => $validator->errors()->first()
            ]);
        }

        DB::table('admins')->insert([
            'name' => $request->name,
            'surname' => $request->surname,
            'user_name' => $request->user_name,
            'password' => bcrypt($request->password)
        ]);

        return response()->json([
            'hata' => 0,
            'aciklama' => 'Yönetici başarıyla oluşturuldu.'
        ]);
    }

    public function editAdmin(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|required|string|max:100',
            'surname' => 'sometimes|required|string|max:100',
            'user_name' => 'sometimes|required|string|max:100|unique:admins,user_name,' . $id,
            'password' => 'sometimes|nullable|string|min:6|max:100',
        ], [
            'name.required' => 'Adı alanı zorunludur.',
            'surname.required' => 'Soyadı alanı zorunludur.',
            'user_name.required' => 'Kullanıcı adı alanı zorunludur.',
            'password.min' => 'Şifre en az 6 karakter olmalıdır.',
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
            'user_name' => $request->user_name,
            'password' => $request->password ? bcrypt($request->password) : null
        ]);

        DB::table('admins')->where('id', $id)->update($updateData);

        return response()->json([
            'hata' => 0,
            'aciklama' => 'Yönetici başarıyla güncellendi.'
        ]);
    }

    public function deleteAdmin($id)
    {
        $admin = DB::table('admins')->where('id', $id)->first();

        if (!$admin) {
            return response()->json([
                'hata' => 1,
                'aciklama' => 'Yönetici bulunamadı.'
            ]);
        }

        DB::table('admins')->where('id', $id)->delete();

        return response()->json([
            'hata' => 0,
            'aciklama' => 'Yönetici başarıyla silindi.'
        ]);
    }
}
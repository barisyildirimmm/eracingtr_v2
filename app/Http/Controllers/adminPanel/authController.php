<?php

namespace App\Http\Controllers\adminPanel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

use Illuminate\Support\Facades\DB;

class authController extends Controller
{
    function loginGet()
    {
        return view('adminPanel.auth.login');
    }
    function loginPost(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        $admin = DB::table('admins')->where('user_name', $request->username)->first();

        if (!$admin) {
            $sonuc = [
                'hata' => 1,
                'aciklama' => 'Kullanıcı bulunamadı. Giriş başarısız'
            ];
            return $sonuc;
        }
        if (Hash::check($request->password, $admin->password)) {
            session(['adminInfo' => $admin]);
            $sonuc = [
                'hata' => 0,
                'aciklama' => 'Giriş Başarılı'
            ];
            return $sonuc;
        }
        $sonuc = [
            'hata' => 1,
            'aciklama' => 'Şifre hatalı. Tekrar deneyin.'
        ];
        return $sonuc;
    }

    function logout(Request $request)
    {
        $request->session()->forget('adminInfo');
        $request->session()->regenerateToken();

        $sonuc = [
            'hata' => 0,
            'aciklama' => 'Çıkış yapıldı'
        ];
        return $sonuc;
    }
}

<?php

namespace App\Http\Controllers\driverPanel;

use App\Http\Controllers\Controller;
use App\Mail\Mailler;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class authController extends Controller
{
    function auth()
    {
        // return view('auth');
    }

    function registerPost(Request $request)
    {
        $messages = [
            'name.required' => 'Adınızı girmelisiniz.',
            'surname.required' => 'Soyadınızı girmelisiniz.',
            'email.required' => 'E-posta adresinizi girmelisiniz.',
            'email.email' => 'Geçerli bir e-posta adresi girin.',
            'email.unique' => 'Bu e-posta adresi zaten kullanılıyor.',
            'password.required' => 'Şifrenizi girmeniz gerekiyor.',
            'password.confirmed' => 'Şifreler eşleşmiyor.',
            'password.min' => 'Şifreniz en az 6 karakter uzunluğunda olmalıdır.',
            'password_confirmation.required' => 'Şifre onayını girmelisiniz.',
            'gsm.required' => 'Telefon numaranızı girmelisiniz.',
        ];

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'surname' => 'required|string|max:255',
            'email' => 'required|email|unique:drivers,email',
            'password' => 'required|confirmed|min:6',
            'password_confirmation' => 'required|min:6',
//            'gsm' => 'required|regex:/^\+90\d{10}$/', // +90 ile başlayan ve 10 rakam içeren format
            'gsm' => 'required',
        ], $messages);

        if ($validator->fails()) {
            return [
                'hata' => 1,
                'aciklama' => $validator->errors()->first()
            ];
        }

        DB::table('drivers')->insert([
            'name' => $request->name,
            'surname' => $request->surname,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'registration_date' => now(),
            'email_verification_token' => Str::random(40),
            'phone' => $request->gsm,
        ]);

        $driver = DB::table('drivers')
            ->where('email', $request->email)
            ->first();

        session(['driverInfo' => $driver]);

        $userInfo = [
            'name' => $driver->name,
            'surname' => $driver->surname,
            'email' => $driver->email,
            'email_verification_token' => $driver->email_verification_token,
        ];

        Mail::to($driver->email)->send(new Mailler($userInfo, 'mails.register', 'eRacing Türkiye Ailesine Hoşgeldin !'));
        $sonuc = [
            'hata' => 0,
            'aciklama' => 'Hesabınız başarıyla oluşturuldu! Yönlendiriliyorsunuz..'
        ];

        return $sonuc;
    }
    function loginPost(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ], [
            'email.required' => 'E-posta alanı zorunludur.',
            'email.email' => 'E-posta adresi geçerli bir formatta olmalıdır.',
            'password.required' => 'Şifre alanı zorunludur.'
        ]);

        if ($validator->fails()) {
            $sonuc = [
                'hata' => 1,
                'aciklama' => $validator->errors()->first()
            ];
            return $sonuc;
        }

        $driver = DB::table('drivers')->where('email', $request->email)->first();

        if (!$driver) {
            $sonuc = [
                'hata' => 1,
                'aciklama' => 'Kullanıcı bulunamadı. Giriş başarısız'
            ];
            return $sonuc;
        }
        if (Hash::check($request->password, $driver->password)) {
            session(['driverInfo' => $driver]);
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

    function logout()
    {
        session()->forget('driverInfo');
        return redirect()->route('home')->with('success', 'Çıkış yapıldı');
    }

    function verifyMailGet($token = null){
        if($token == null){
            return route('home');
        }
        $user = DB::table('drivers')->where('email_verification_token', $token)->first();

        if($user->email_verified_at != null){
            return redirect()->route('home')->with('success', 'Hesap zaten onaylı.');
        }

        if (!$user) {
            return redirect()->route('home')->with('error', 'Geçersiz veya süresi dolmuş doğrulama bağlantısı.');
        }

        DB::table('drivers')->where('id', $user->id)->update([
            'email_verified_at' => now(),
//            'email_verification_token' => null,
        ]);

        return redirect()->route('home')->with('success', 'Hesabınız Onaylandı');
    }
}

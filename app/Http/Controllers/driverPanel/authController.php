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
            'name.required' => __('common.name_enter'),
            'surname.required' => __('common.surname_enter'),
            'email.required' => __('common.email_enter'),
            'email.email' => __('common.email_valid'),
            'email.unique' => __('common.email_unique_in_use'),
            'password.required' => __('common.password_enter'),
            'password.confirmed' => __('common.password_confirmed'),
            'password.min' => __('common.password_min_length'),
            'password_confirmation.required' => __('common.password_confirmation_required'),
            'gsm.required' => __('common.phone_enter'),
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

        // Telefon numarasından ülke kodunu belirle
        $countryCode = getCountryCodeFromPhone($request->gsm);

        DB::table('drivers')->insert([
            'name' => $request->name,
            'surname' => $request->surname,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'registration_date' => now(),
            'email_verification_token' => Str::random(40),
            'phone' => $request->gsm,
            'country' => $countryCode,
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

        // Driver'ın ülke kodundan dil kodunu belirle
        $locale = getLocaleFromCountryCode($driver->country);
        
        // Mail'i queue'ya al (asenkron gönderim - kullanıcı beklemez)
        // Locale'i ve subject key'ini geçirerek mail'in doğru dilde gönderilmesini sağla
        Mail::to($driver->email)->queue(new Mailler($userInfo, 'mails.register', __('common.mail_welcome_title'), $locale, 'common.mail_welcome_title'));
        
        $sonuc = [
            'hata' => 0,
            'aciklama' => __('common.account_created_success')
        ];

        return $sonuc;
    }
    function loginPost(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ], [
            'email.required' => __('common.email_required'),
            'email.email' => __('common.email_email'),
            'password.required' => __('common.password_required')
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
                'aciklama' => __('common.user_not_found')
            ];
            return $sonuc;
        }
        if (Hash::check($request->password, $driver->password)) {
            session(['driverInfo' => $driver]);
            $sonuc = [
                'hata' => 0,
                'aciklama' => __('common.login_success_auth')
            ];
            return $sonuc;
        }

        $sonuc = [
            'hata' => 1,
            'aciklama' => __('common.password_incorrect')
        ];
        return $sonuc;
    }

    function logout()
    {
        session()->forget('driverInfo');
        return redirect()->route('home')->with('success', __('common.logout_success_driver'));
    }

    function verifyMailGet($token = null){
        if($token == null){
            return route('home');
        }
        $user = DB::table('drivers')->where('email_verification_token', $token)->first();

        if($user->email_verified_at != null){
            return redirect()->route('home')->with('success', __('common.account_already_verified'));
        }

        if (!$user) {
            return redirect()->route('home')->with('error', __('common.invalid_verification_link'));
        }

        DB::table('drivers')->where('id', $user->id)->update([
            'email_verified_at' => now(),
//            'email_verification_token' => null,
        ]);

        return redirect()->route('home')->with('success', __('common.account_verified'));
    }
}

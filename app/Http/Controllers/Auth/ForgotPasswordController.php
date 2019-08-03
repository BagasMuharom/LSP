<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Mahasiswa;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\ResetKataSandi;
use Illuminate\Http\Request;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Menampilkan halaman reset kata sandi untuk mahasiswa
     *
     * @return void
     */
    public function halamanResetKataSandi()
    {
        return view('auth.passwords.reset');
    }

    /**
     * Melakukan reset kata sandi oleh mahasiswa itu sendiri
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function kirimKataSandi(Request $request)
    {
        $request->validate([
            'email' => 'required'
        ]);

        $user = Mahasiswa::where('email', $request->email)->first();

        if (is_null($user))
            $user = User::where('email', $request->email)->first();

        if (is_null($user)) {
            return back()->withErrors([
                'email' => 'Email tidak ditemukan !'
            ]);
        }

        try {
            $password = strtoupper(str_random(8));
            $hash = bcrypt(($password));

            Mail::to($user->email)->send(new ResetKataSandi($password));

            $user->update([
                'password' => $hash
            ]);
        }
        catch (\Exception $e) {
            return back()->with([
                'error' => 'Gagal mengirim kata sandi melalui email. Coba beberapa saat lagi. Jika masalah ini tetap terjadi, mohon hubungi admin untuk mereset secara manual'
            ]);
        }

        return back()->with([
            'success' => 'Berhasil mereset kata sandi, mohon cek email anda.'
        ]);
    }

}

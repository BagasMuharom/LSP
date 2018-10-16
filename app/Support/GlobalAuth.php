<?php

namespace App\Support;

use App\Models\Mahasiswa;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Access\AuthorizationException;

class GlobalAuth
{

    /**
     * Melakukan proses login
     *
     * @param array $credentials
     * @return boolean
     */
    public function login($credentials)
    {
        $guard = 'user';

        if ($this->isUser($credentials['email'])) {
            $guard = 'user';
        } else if ($this->isMahasiswa($credentials['email'])) {
            $guard = 'mhs';
        } else {
            return false;
        }

        if (Auth::guard($guard)->attempt($credentials)) {
            return true;
        }

        return false;
    }

    /**
     * Melakukan proses logout
     *
     * @return void
     */
    public function logout()
    {
        Auth::guard($this->getAttemptedGuard())->logout();
    }

    /**
     * Mengecek apakah salah satu guard sedang login
     *
     * @return boolean
     */
    public function check()
    {
        $guard = $this->getAttemptedGuard();

        return !is_null($guard);
    }

    /**
     * Mendapatkan user yang sedang login dari salah satu guard
     *
     * @return \App\Models\Mahasiswa|\App\Models\User
     */
    public function user()
    {
        if ($this->getAttemptedGuard() === 'mhs')
            return Auth::guard('mhs')->user();

        return Auth::guard('user')->user();
    }

    /**
     * Mendapatkan guard yang sedang login berupa string
     *
     * @return string|null
     */
    public function getAttemptedGuard()
    {
        if (Auth::guard('user')->check()) {
            return 'user';
        }

        if (Auth::guard('mhs')->check()) {
            return 'mhs';
        }

        return null;
    }

    /**
     * Mengecek apakah email terkait terdapat pada tabel user
     *
     * @param string $email
     * @return boolean
     */
    private function isUser($email)
    {
        return !is_null(User::where('email', $email)->first());
    }

    /**
     * Mengecek apakah email terkait terdapat pada tabel mahasiswa
     *
     * @param [type] $email
     * @return boolean
     */
    private function isMahasiswa($email)
    {
        return !is_null(Mahasiswa::where('email', $email)->first());
    }

    /**
     * Mengubah profil pengguna
     *
     * @param array $data
     * @return void
     */
    public function update(array $data)
    {
        $this->user()->update($data);
    }

    /**
     * Melakukan otorisasi
     *
     * @param string $action
     * @param mixed $model
     * @return void
     * @throws AuthorizationException
     */
    public function authorize($action, $model = null)
    {
        if (!$this->user()->can($action, $model))
            throw new AuthorizationException();
    }

}

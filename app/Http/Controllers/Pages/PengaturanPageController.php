<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Support\Facades\GlobalAuth;

class PengaturanPageController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:user,mhs');
    }

    public function __invoke()
    {
        $daftarBerkas = [];

        if (GlobalAuth::getAttemptedGuard() == 'user') {
            $daftarBerkas = Storage::files('data/user/' . GlobalAuth::user()->id);
        }

        return view('pengaturan_akun', [
            'daftarBerkas' => $daftarBerkas
        ]);
    }

}

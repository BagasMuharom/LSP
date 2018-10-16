<?php

namespace App\Http\Controllers\Pages;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PengaturanPageController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:user,mhs');
    }

    public function __invoke()
    {
        return view('pengaturan_akun');
    }

}

<?php

namespace App\Http\Controllers\Pages;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardPageController extends Controller
{

    public function __construct()
    {
        $this->middleware([
            'auth:user,mhs', 'verifikasi', 'terblokir'
        ]);
    }
    
    /**
     * Menampilkan halaman dashboard
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke()
    {
        return view('dashboard');    
    }

}

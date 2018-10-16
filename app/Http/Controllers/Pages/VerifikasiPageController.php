<?php

namespace App\Http\Controllers\Pages;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Support\Filter\UjiFilter;
use App\Models\Menu;
use App\Models\Uji;
use App\Models\Role;
use Auth;

class VerifikasiPageController extends Controller
{
    
    use UjiFilter;
    
    public function __construct()
    {
        $this->middleware('auth:user');
        $this->middleware('menu:verifikasi');
    }
    
    /**
     * Menampilkan daftar uji untuk verifikasi
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {   
        $uji = Uji::getPendaftaran()->orderBy('updated_at', 'desc');

        $uji = $this->simplifyFilter($request, $uji, 0);

        return view('menu.verifikasi.index', [
            'daftaruji' => $uji->paginate(20)->appends([
                'skema' => $request->has('skema') ? $request->skema : null,
                'keyword' => $request->has('keyword') ? $request->keyword : null,
                'status' => $request->has('status') ? $request->status : null
            ]),
            'total' => $uji->count()
        ]);
    }

}

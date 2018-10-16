<?php

namespace App\Http\Controllers\Pages;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Support\Filter\UjiFilter;
use App\Models\Role;
use App\Models\User;


class AsesorPageController extends Controller
{

    use UjiFilter;

    public function __construct()
    {
        $this->middleware('auth:user');
        $this->middleware('menu:asesor');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $daftarAsesor = Role::where('nama', Role::ASESOR)->first()->getUserRole();
        $daftarAsesor = $daftarAsesor->when($request->has('keyword'), function ($query) use ($request) {
            $query->where('nama', 'ILIKE', '%' . $request->keyword . '%')
                ->orWhere('nip', $request->keyword);
        });

        return view('menu.asesor.index', [
            'daftarAsesor' => $daftarAsesor->paginate(20),
            'total' => $daftarAsesor->count()
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $asesor)
    {
        return view('menu.asesor.edit', [
            'asesor' => $asesor,
            'daftarAsesorSkema' => $asesor->getAsesorSkema(false)
        ]);
    }

    /**
     * Menampilkan halaman daftar uji dari asesor tertentu
     *
     * @param User $asesor
     * @return \Illuminate\Http\Response
     */
    public function daftarUji(Request $request, User $asesor)
    {
        $daftaruji = $asesor->getUjiAsAsesor();
        $daftaruji = $this->simplifyFilter($request, $daftaruji, 7);

        return view('menu.uji.index', [
            'daftaruji' => $daftaruji->paginate(20),
            'total' => $daftaruji->count()
        ]);
    }

}

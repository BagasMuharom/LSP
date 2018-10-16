<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Fakultas;

class FakultasController extends Controller
{
    
    /**
     * Mendapatkan daftar jurusan
     *
     * @param Fakultas $fakultas
     * @return \Illuminate\Http\Response
     */
    public function getDaftarJurusan(Fakultas $fakultas)
    {   
        return response()->json(
            $fakultas->getJurusan(false)
        );
    }

}

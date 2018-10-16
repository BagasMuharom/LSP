<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Jurusan;

class JurusanController extends Controller
{
    
    /**
     * Mendapatkan daftar jurusan
     *
     * @param Jurusan $jurusan
     * @return \Illuminate\Http\Response
     */
    public function getDaftarProdi(Jurusan $jurusan)
    {
        return response()->json(
            $jurusan->getProdi(false)
        );
    }

}

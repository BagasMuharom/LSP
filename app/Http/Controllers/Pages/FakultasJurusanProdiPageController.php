<?php

namespace App\Http\Controllers\Pages;

use App\Models\Fakultas;
use App\Models\Jurusan;
use App\Models\Menu;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FakultasJurusanProdiPageController extends Controller
{
    public function __construct()
    {
        $this->middleware([
            'auth:user',
            'menu:fjp'
        ]);
    }

    public function index()
    {
        return view('menu.fjp.index', [
            'menu' => Menu::findByRoute(Menu::FAKULTAS_JURUSAN_PRODI),
            'listFakultas' => Fakultas::orderBy('id')->get(),
            'listJurusan' => Jurusan::all(),
        ]);
    }
}

<?php

namespace App\Http\Controllers\Pages;

use App\Models\Kustomisasi;
use App\Models\Menu;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class KustomisasiPageController extends Controller
{
    public function __construct()
    {
        $this->middleware([
            'auth:user',
            'menu:kustomisasi'
        ]);
    }

    public function index()
    {
        return view('menu.kustomisasi.index', [
            'menu' => Menu::findByRoute(Menu::SKEMA),
            'nama' => Kustomisasi::find(Kustomisasi::NAMA),
            'logo' => Kustomisasi::find(Kustomisasi::LOGO),
            'profil' => Kustomisasi::find(Kustomisasi::PROFIL),
            'visi' => Kustomisasi::find(Kustomisasi::VISI),
            'misi' => Kustomisasi::find(Kustomisasi::MISI),
            'sasaranMutu' => Kustomisasi::find(Kustomisasi::SASARAN_MUTU),
            'susunanOrganisasi' => Kustomisasi::find(Kustomisasi::SUSUNAN_ORGANISASI),
            'email' => Kustomisasi::find(Kustomisasi::EMAIL),
            'noTelp' => Kustomisasi::find(Kustomisasi::NO_TELP),
            'alamat' => Kustomisasi::find(Kustomisasi::ALAMAT),
            'pengumuman' => Kustomisasi::find(Kustomisasi::PENGUMUMAN),
            'maps' => Kustomisasi::find(Kustomisasi::MAPS),
            'mapsUrl' => Kustomisasi::find(Kustomisasi::MAPS_URL)
        ]);
    }
}
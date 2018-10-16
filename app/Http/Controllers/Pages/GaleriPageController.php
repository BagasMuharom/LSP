<?php

namespace App\Http\Controllers\Pages;

use App\Models\Galeri;
use App\Models\Menu;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GaleriPageController extends Controller
{
    public function __construct()
    {
        $this->middleware([
            'auth:user',
            'menu:galeri'
        ]);
    }

    public function index(Request $request)
    {
        $data = Galeri::when($request->q, function ($query) use ($request) {
            $query->where('nama', 'ILIKE', "%{$request->q}%")
                ->orWhere('keterangan', 'ILIKE', "%{$request->q}%");
        })->orderByDesc('created_at')->paginate(10)->appends($request->only('q'));

        return view('menu.galeri.index', [
            'data' => $data,
            'no' => 0,
            'q' => $request->q,
            'menu' => Menu::findByRoute(Menu::GALERI)
        ]);
    }

    public function foto(Galeri $galeri)
    {
        return view('menu.galeri.foto', [
            'data' => $galeri->getFoto()->paginate(10),
            'galeri' => $galeri,
            'menu' => Menu::findByRoute(Menu::GALERI)
        ]);
    }
}

<?php

namespace App\Http\Controllers\Pages;

use App\Models\Menu;
use App\Models\UnitKompetensi;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UnitPageController extends Controller
{
    public function __construct()
    {
        $this->middleware([
            'auth:user',
            'menu:unit'
        ]);
    }

    public function index(Request $request)
    {
        $data = UnitKompetensi::withTrashed()->orderByDesc('deleted_at')->orderBy('kode')->orderBy('nama')->when($request->q, function ($query) use ($request){
            return $query->where('nama', 'ILIKE', "%{$request->q}%")
                ->orWhere('kode', 'ILIKE', "%{$request->q}%");
        })->paginate(10)->appends($request->only('q'));
        return view('menu.unit.index',[
            'data' => $data,
            'no' => 0,
            'q' => $request->q,
            'menu' => Menu::findByRoute(Menu::UNIT)
        ]);
    }

    public function elemen(Request $request)
    {
        try{
            $unit = UnitKompetensi::findOrFail(decrypt($request->id));
            $data = $unit->getElemenKompetensi()->orderBy('id')->get();
            return view('menu.unit.elemen', [
                'data' => $data,
                'unit' => $unit,
                'no' => 0,
                'menu' => Menu::findByRoute(Menu::UNIT)
            ]);
        }
        catch (ModelNotFoundException $exception){
            return back()->with('error', 'Data tidak ditemukan');
        }
    }
}

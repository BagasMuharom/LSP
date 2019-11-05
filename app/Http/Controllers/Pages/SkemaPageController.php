<?php

namespace App\Http\Controllers\Pages;

use App\Models\Jenis;
use App\Models\Jurusan;
use App\Models\Menu;
use App\Models\Skema;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Prophecy\Exception\Doubler\MethodNotFoundException;

class SkemaPageController extends Controller
{
    public function __construct()
    {
        $this->middleware([
            'auth:user',
            'menu:skema'
        ]);
    }

    public function index(Request $request)
    {
        $request->j = empty($request->j) ? 'SEMUA JENIS' : ((Jenis::check($request->j)) ? Jenis::findLike($request->j)->nama : 'SEMUA JENIS');
        $data = ($request->j == 'SEMUA JENIS') ? Skema::withTrashed() : Skema::withTrashed()->where('jenis_id', Jenis::findLike($request->j)->id);
        $data = $data->orderByDesc('deleted_at')
            ->orderBy(
                'kode'
            )->orderBy(
                'nama'
            )->when($request->q, function ($query) use ($request) {
                return $query->where('nama', 'ILIKE', "%{$request->q}%")
                    ->orWhere('kode', 'ILIKE', "%{$request->q}%");
            })->when($request->jrs, function ($query) use ($request) {
                return $query->whereHas('getJurusan', function ($query) use ($request) {
                    return $query->where('nama', $request->jrs);
                });
            })->paginate(
                10
            )->appends($request->only(['q', 'j']));
        $request->jrs = empty($request->jrs) ? 'SEMUA JURUSAN' : $request->jrs;
        return view('menu.skema.index', [
            'data' => $data,
            'no' => 0,
            'q' => $request->q,
            'daftarjenis' => Jenis::all(),
            'daftarjurusan' => Jurusan::orderBy('fakultas_id')->get(),
            'jrs' => $request->jrs,
            'j' => $request->j,
            'menu' => Menu::findByRoute(Menu::SKEMA)
        ]);
    }

    public function tambah(Request $request)
    {
        return view('menu.skema.tambah', [
            'daftarjenis' => Jenis::all(),
            'daftarjurusan' => Jurusan::all(),
            'menu' => Menu::findByRoute(Menu::SKEMA),
            'admintuk' => User::query()->whereHas('getUserRole', function ($query) {
                return $query->where('nama', 'ADMIN TUK');
            })->get(),
        ]);
    }

    public function detail(Request $request)
    {
        try {
            return view('menu.skema.edit', [
                'skema' => Skema::findOrFail(decrypt($request->id)),
                'daftarjenis' => Jenis::all(),
                'daftarjurusan' => Jurusan::all(),
                'admintuk' => User::query()->whereHas('getUserRole', function ($query) {
                    return $query->where('nama', 'ADMIN TUK');
                })->get(),
                'menu' => Menu::findByRoute(Menu::SKEMA)
            ]);
        } catch (ModelNotFoundException $exception) {
            return back()->with('error', 'Data tidak ditemukan!');
        }
    }

    public function jenis(Request $request)
    {
        return view('menu.skema.jenis', [
            'data' => Jenis::orderBy('nama')->paginate(10),
            'menu' => Menu::findByRoute(Menu::SKEMA)
        ]);
    }
}

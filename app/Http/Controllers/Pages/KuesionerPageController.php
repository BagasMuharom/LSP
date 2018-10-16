<?php

namespace App\Http\Controllers\Pages;

use App\Models\Event;
use App\Models\Kuesioner;
use App\Models\Menu;
use App\Models\Skema;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use PDF;

class KuesionerPageController extends Controller
{
    public function index(Request $request)
    {
        $request->skema = empty($request->skema) ? [] : $request->skema;

        $data = Kuesioner::when($request->skema, function ($query) use ($request) {
            $query->whereHas('getSertifikat.getSkema', function ($query) use ($request) {
                $query->whereIn('kode', $request->skema);
            });
        })->when($request->search, function ($query) use ($request) {
            $query->whereHas('getSertifikat.getUji.getMahasiswa', function ($query) use ($request) {
                $query->where('nama', 'ILIKE', "%{$request->search}%")
                    ->orWhere('nim', 'ILIKE', "%{$request->search}%");
            });
        })->orderByDesc('created_at')
            ->paginate(10)
            ->appends($request->all());

        return view('menu.kuesioner.index', [
            'data' => $data,
            'menu' => Menu::findByRoute(Menu::KUESIONER),
            'no' => 0,
            'listSkema' => Skema::all(),
            'skema' => $request->skema,
            'search' => $request->search
        ]);
    }

    public function detail(Kuesioner $kuesioner)
    {
        return view('form.kuesioner', [
            'sertifikat' => $sertifikat = $kuesioner->getSertifikat(false),
            'mahasiswa' => $sertifikat->getUji(false)->getMahasiswa(false),
            'skema' => $sertifikat->getSkema(false),
            'kuesioner' => $kuesioner
        ]);
    }

    public function print(Kuesioner $kuesioner)
    {
        $pdf = PDF::loadView('form.kuesioner', [
            'sertifikat' => $sertifikat = $kuesioner->getSertifikat(false),
            'mahasiswa' => $sertifikat->getUji(false)->getMahasiswa(false),
            'skema' => $sertifikat->getSkema(false),
            'kuesioner' => $kuesioner
        ]);

        return $pdf->stream();
    }
}

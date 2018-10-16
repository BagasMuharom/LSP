<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Support\Filter\SertifikatFilter;
use App\Models\Sertifikat;
use App\Models\Uji;
use App\Models\Fakultas;
use App\Models\Jurusan;
use App\Models\Prodi;
use PDF;

class SertifikatPageController extends Controller
{

    use SertifikatFilter;

    public function __construct()
    {
        $this->middleware(['auth:user', 'menu:sertifikat'])->except('formKuesioner');
        $this->middleware('auth:mhs')->only('formKuesioner');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $daftarSertifikat = Sertifikat::query();
        $daftarSertifikat = $this->simplifyFilter($request, $daftarSertifikat);
        $daftarJurusan = [];
        $daftarProdi = [];

        if ($request->has('fakultas')) {
            try {
                $daftarJurusan = Fakultas::findorFail($request->fakultas)->getJurusan(false);
            } catch (ModelNotFoundException $e) {}
        }

        if ($request->has('jurusan')) {
            try {
                $daftarJurusan = Jurusan::findorFail($request->jurusan)->getFakultas(false)->getJurusan(false);
                $daftarProdi = Jurusan::findorFail($request->jurusan)->getProdi(false);
            } catch (ModelNotFoundException $e) {}
        }
        
        if ($request->has('prodi')) {
            try {
                $daftarProdi = Prodi::findorFail($request->prodi)->getJurusan(false)->getProdi(false);
            } catch (ModelNotFoundException $e) {}
        }

        return view('menu.sertifikat.index', [
            'daftarSertifikat' => $daftarSertifikat->paginate(20)->appends($request->all()),
            'daftarFakultas' => Fakultas::all(),
            'daftarJurusan' => $daftarJurusan,
            'daftarProdi' => $daftarProdi,
            'total' => $daftarSertifikat->count()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param Uji $uji
     * @return \Illuminate\Http\Response
     */
    public function create(Uji $uji)
    {
        return view('menu.sertifikat.create', [
            'uji' => $uji
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  Sertifikat $sertifikat
     * @return \Illuminate\Http\Response
     */
    public function show(Sertifikat $sertifikat)
    {
        return view('menu.sertifikat.detail', [
            'sertifikat' => $sertifikat
        ]);
    }

    /**
     * Menampilkan form untuk mengisi kuesioner
     *
     * @param Sertifikat $sertifikat
     * @return \Illuminate\Http\Response
     */
    public function formKuesioner(Sertifikat $sertifikat)
    {
        return view('menu.sertifikat.form_kuesioner', [
            'sertifikat' => $sertifikat,
            'skema' => $sertifikat->getSkema(false),
            'mahasiswa' => $sertifikat->getMahasiswa(false)
        ]);
    }

    /**
     * Menyetak kuesioner
     *
     * @param Sertifikat $sertifikat
     * @return \Illuminate\Http\Response
     */
    public function cetakKuesioner(Sertifikat $sertifikat)
    {
        $pdf = PDF::loadView('form.kuesioner', [
            'sertifikat' => $sertifikat,
            'mahasiswa' => $sertifikat->getUji(false)->getMahasiswa(false),
            'skema' => $sertifikat->getSkema(false),
            'kuesioner' => $sertifikat->getKuesioner(false)
        ]);

        // return view('form.kuesioner', [
        //     'sertifikat' => $sertifikat,
        //     'mahasiswa' => $sertifikat->getUji(false)->getMahasiswa(false),
        //     'skema' => $sertifikat->getSkema(false),
        //     'kuesioner' => $sertifikat->getKuesioner(false)
        // ]);

        return $pdf->stream();
    }

}

<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use App\Models\{Fakultas, Jurusan, Prodi, Mahasiswa, Dana};
use App\Support\ApiUnesa;
use App\Support\Filter\MahasiswaFilter;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use GlobalAuth;

class MahasiswaPageController extends Controller
{

    use MahasiswaFilter;

    public function __construct()
    {
        $this->middleware(['auth:user', 'menu:mahasiswa'])->except('terverifikasi', 'resetKataSandi');
    }

    /**
     * Menampilkan halaman daftar mahasiswa
     *
     * @param Request $request
     * @return void
     */
    public function index(Request $request)
    {
        $daftarMahasiswa = Mahasiswa::orderBy('created_at', 'desc');
        $daftarMahasiswa = $this->simplifyFilter($request, $daftarMahasiswa);
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

        return view('menu.mahasiswa.index', [
            'daftarMahasiswa' => $daftarMahasiswa->paginate(20)->appends($request->all()),
            'daftarFakultas' => Fakultas::all(),
            'daftarJurusan' => $daftarJurusan,
            'daftarProdi' => $daftarProdi,
            'total' => $daftarMahasiswa->count()
        ]);
    }

    /**
     * Menampilkan halaman detail mahasiswa
     *
     * @param Mahasiswa $mahasiswa
     * @return \Illuminate\Http\Response
     */
    public function show(Mahasiswa $mahasiswa)
    {
        $fakultas = $mahasiswa->getFakultas(false);
        $jurusan = $mahasiswa->getJurusan(false);
        $prodi = $mahasiswa->getProdi(false);
        $daftarFakultas = Fakultas::all();
        $daftarJurusan = $fakultas->getJurusan(false);
        $daftarProdi = $jurusan->getProdi(false);
        $daftarMandiriEvent = $mahasiswa->getMahasiswaMandiriEvent(false);
        $daftarEventMandiri = is_null(Dana::where('nama', 'Mandiri')->first()) ? collect([]) : Dana::where('nama', 'Mandiri')->first()->getEvent(false)->whereNotIn('id', $daftarMandiriEvent->pluck('id')->toArray());

        return view('menu.mahasiswa.detail', [
            'mahasiswa' => $mahasiswa,
            'fakultas' => $fakultas,
            'jurusan' => $jurusan,
            'prodi' => $prodi,
            'daftarFakultas' => $daftarFakultas,
            'daftarJurusan' => $daftarJurusan,
            'daftarProdi' => $daftarProdi,
            'daftarMandiriEvent' => $daftarMandiriEvent,
            'daftarEventMandiri' => $daftarEventMandiri
        ]);
    }

    /**
     * Menampilkan daftar sertifikat dari mahasiswa tertentu
     *
     * @param Request $request
     * @param Mahasiswa $mahasiswa
     * @return \Illuminate\Http\Response
     */
    public function sertifikat(Request $request, Mahasiswa $mahasiswa)
    {
        $daftarSertifikat = $mahasiswa->getSertifikat();

        return view('menu.sertifikat.index', [
            'daftarSertifikat' => $daftarSertifikat->paginate(20),
            'filter' => false  ,
            'total' => $daftarSertifikat->count()
        ]);
    }

    /**
     * Menampilkan daftar uji dari mahasiswa tersebut
     *
     * @param Request $request
     * @param Mahasiswa $mahasiswa
     * @return \Illuminate\Http\Response
     */
    public function uji(Request $request, Mahasiswa $mahasiswa)
    {
        $daftaruji = $mahasiswa->getUji();
        
        return view('menu.uji.index', [
            'daftaruji' => $daftaruji->paginate(20),
            'total' => $daftaruji->count()
        ]);
    }

    /**
     * Menampilkan halaman bahwa akun telah terverifikasi
     *
     * @param string $token
     * @return \Illuminate\Http\Response
     */
    public function terverifikasi($token)
    {
        if (GlobalAuth::check()) {
            if ((GlobalAuth::getAttemptedGuard() == 'mhs' && GlobalAuth::user()->nim != decrypt($token)) || GlobalAuth::getAttemptedGuard() == 'user')
                return abort(403, 'Harap logout untuk melakukan verifikasi');
        }

        try {
            $mahasiswa = Mahasiswa::where('nim', decrypt($token))->firstOrFail();

            if ($mahasiswa->terverifikasi)
                return redirect()->route('login');
            
            $mahasiswa->update([
                'terverifikasi' => true
            ]);

        } catch (ModelNotFoundException $e) {
            return abort(404);
        }

        return view('auth.terverifikasi', [
            'mahasiswa' => $mahasiswa
        ]);
    }

    /**
     * Menampilkan halaman tambah mahasiswa
     *
     * @return \Illuminate\Http\Response
     */
    public function tambah()
    {
        return view('menu.mahasiswa.tambah');
    }

    public function cek(Request $request)
    {
        $listmhs = collect([]);

        if (!empty($request->nims)){
            $nims = str_replace(' ', '', $request->nims);
            $nims_ = [];
            foreach (explode(PHP_EOL, $nims) as $nim){
                $split = explode('-', $nim);
                if (count($split) == 1){
                    $nims_[] = $nim;
                } else{
                    $nims_[] = range((int)$split[0], (int)$split[1]);
                }
            }
            $nims_ = array_flatten($nims_);
            $nims_ = array_unique($nims_);
            $listmhs = ApiUnesa::getMahasiswaIn($nims_);
            if ($request->ipk == 'desc'){
                $listmhs = $listmhs->sortByDesc(function ($value, $key){
                    return $value->aktivitas_kuliah->ipk;
                });
            } elseif ($request->ipk == 'asc'){
                $listmhs = $listmhs->sortBy(function ($value, $key){
                    return $value->aktivitas_kuliah->ipk;
                });
            }
        }

        return view('menu.mahasiswa.cek', [
            'listmhs' => $listmhs,
            'nims' => $request->nims,
            'ipk' => $request->ipk
        ]);
    }

}

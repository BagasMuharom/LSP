<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use App\Models\TempatUji;
use App\Models\Uji;
use App\Support\Filter\UjiFilter;
use Auth;
use GlobalAuth;
use Illuminate\Http\Request;

class UjiPageController extends Controller
{

    use UjiFilter;

    protected $mahasiswaPage = [
        'create', 'riwayatSertifikasi'
    ];

    protected $userPage = [
        'index', 'troubleshoot'
    ];

    protected $bothPage = [
        'show',
    ];

    public function __construct()
    {
        $this->middleware(['auth:mhs', 'verifikasi', 'terblokir', 'syaratlengkap'])
            ->only($this->mahasiswaPage);
        $this->middleware(['auth:user', 'menu:uji'])
            ->only($this->userPage);
        $this->middleware('auth:mhs,user')
            ->only($this->bothPage);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $daftaruji = Uji::getLolosVerifikasi()->orderBy('updated_at', 'desc');

        $daftaruji = $this->simplifyFilter($request, $daftaruji, 7);

        return view('menu.uji.index', [
            'daftaruji' => $daftaruji->paginate(20)->appends($request->except('page')),
            'total' => $daftaruji->count()
        ]);
    }

    /**
     * Melakukan pendaftaran sertifikasi
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $daftarEvent = GlobalAuth::user()->getEventTersedia(false);

        return view('menu.daftar.form', [
            'daftarEvent' => $daftarEvent,
            'daftaruji' => GlobalAuth::user()->getUji()->getPendaftaran()->getProtect(),
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Uji $uji)
    {
        GlobalAuth::authorize('view', $uji);

        $daftarAsesorUji = $uji->getAsesorUji(false);
        $daftarAsesor = $uji->getSkema(false)->getAsesorSkema()->whereNotIn('id', $daftarAsesorUji->pluck('id')->toArray())->get();

        return view('menu.uji.detail', [
            'uji' => $uji,
            'mahasiswa' => $uji->getMahasiswa(false),
            'skema' => $uji->getSkema(false),
            'daftarSyarat' => $uji->getSyaratUji(false)->makeHidden(['pivot.uji_id', 'pivot.syarat_id' , 'skema_id']),
            'daftarAsesor' => $daftarAsesor,
            'daftarAsesorUji' => $daftarAsesorUji
        ]);
    }

    /**
     * Menampilkan halaman riwayat sertifikasi dari mahasiswa tertentu
     *
     * @return \Illuminate\Http\Response
     */
    public function riwayatSertifikasi()
    {
        $daftarUji = GlobalAuth::user()->getUji()->getLolosVerifikasi();

        return view('mahasiswa.riwayat_sertifikasi', [
            'daftarUji' => $daftarUji->getProtect(),
        ]);
    }

    /**
     * Menampilkan halaman untuk asesmen diri
     *
     * @param Uji $uji
     * @return \Illuminate\Http\Response
     */
    public function asesmenDiri(Uji $uji)
    {
        GlobalAuth::authorize('asesmenDiri', $uji);

        return view('menu.daftar.asesmen_diri', [
            'uji' => $uji,
            'skema' => $uji->getSkema(false),
            'daftarUnit' => $uji->getSkema(false)->getSkemaUnit()->with(['getElemenKompetensi', 'getElemenKompetensi.getKriteria'])->get()
        ]);
    }

    /**
     * Menampilkan halaman asesmen diri untuk uji tertentu
     * yang akan diisi oleh asesor
     *
     * @param \App\Models\TempatUji $uji
     * @return \Illuminate\Http\Response
     */
    public function asesmenDiriAsesor(Uji $uji)
    {
        GlobalAuth::authorize('asesmenDiriAsesor', $uji);

        return view('menu.penilaian.asesmen_diri_asesor', [
            'uji' => $uji,
            'skema' => $uji->getSkema(false),
            'daftarUnit' => $uji->getSkema(false)->getSkemaUnit()->with(['getElemenKompetensi', 'getElemenKompetensi.getKriteria'])->get(),
            'daftarNilai' => $uji->getPenilaianDiri(false)->pluck('pivot')->keyBy('kriteria_id')
        ]);
    }

    /**
     * Menampilkan halaman untuk troubleshooting
     *
     * @param \App\Models\TempatUji $uji
     * @return \Illuminate\Http\Response
     */
    public function troubleshoot(Uji $uji)
    {
        return view('menu.uji.troubleshoot', [
            'uji' => $uji
        ]);
    }

}

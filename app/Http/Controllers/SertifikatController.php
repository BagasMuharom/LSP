<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Uji, Sertifikat, Kuesioner};
use Carbon\Carbon;
use App\Support\Filter\SertifikatFilter;
use App\Support\{EksporSertifikat, EksporSertifikatBnsp};

class SertifikatController extends Controller
{

    use SertifikatFilter;

    public function __construct()
    {
        $this->middleware(['auth:user', 'menu:sertifikat'])->except('isiKuesioner');
        $this->middleware(['auth:mhs'])->only('isiKuesioner');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Uji $uji)
    {
        $request->validate([
            'issue_date' => 'required|date',
            'masa_berlaku' => 'required|numeric|min:1',
            'tanggal_cetak' => 'required|date',
            'no_urut_cetak' => 'required|numeric',
            'no_urut_skema' => 'required|numeric',
            'tahun' => 'required|numeric'
        ]);

        $uji->getSertifikat()->save(new Sertifikat([
            'issue_date' => $request->issue_date,
            'expire_date' => Carbon::parse($request->issue_date)->addYears($request->masa_berlaku),
            'no_urut_cetak' => $request->no_urut_cetak,
            'tahun' => $request->tahun,
            'no_urut_skema' => $request->no_urut_skema,
            'tanggal_cetak' => $request->tanggal_cetak
        ]));

        return response()->json([
            'success' => true,
            'message' => 'Berhasil menambahkan sertifikat baru !',
            'redirect' => route('sertifikat')
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Sertifikat $sertifikat
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(Request $request, Sertifikat $sertifikat)
    {
        $this->authorize('update', $sertifikat);

        $request->validate([
            'issue_date' => 'required|date',
            'masa_berlaku' => 'required|numeric|min:1',
            'tanggal_cetak' => 'required|date',
            'no_urut_cetak' => 'required|numeric',
            'no_urut_skema' => 'required|numeric',
            'tahun' => 'required|numeric'
        ]);

        $sertifikat->update([
            'issue_date' => $request->issue_date,
            'expire_date' => Carbon::parse($request->issue_date)->addYears($request->masa_berlaku),
            'tanggal_cetak' => Carbon::parse($request->tanggal_cetak),
            'no_urut_cetak' => $request->no_urut_cetak,
            'no_urut_skema' => $request->no_urut_skema,
            'tahun' => $request->tahun
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Berhasil menyimpan perubahan !'
        ]);
    }

    /**
     * Melakukan impor sertifikat
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function import(Request $request)
    {
        $reader = app('ImportSertifikat');
        $reader->read($request->file('file')->getRealPath());
        $reader->import();

        return response()->json([
            'success' => true,
            'message' => 'Berhasil mengimpor sertifikat !'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Sertifikat $sertifikat
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(Sertifikat $sertifikat)
    {
        $sertifikat->delete();

        return response()->json([
            'success' => true,
            'url' => route('sertifikat')
        ]);
    }

    /**
     * Melakukan ekspor sertifikat dalam bentuk excel
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function ekspor(Request $request)
    {
        $daftarSertifikat = Sertifikat::query();
        $daftarSertifikat = $this->simplifyFilter($request, $daftarSertifikat)->get();

        $file = new EksporSertifikat($daftarSertifikat);
        return $file->export();
    }

    /**
     * Proses input kuesioner
     *
     * @param Request $request
     * @param Sertifikat $sertifikat
     * @return \Illuminate\Http\Response
     */
    public function isiKuesioner(Request $request, Sertifikat $sertifikat)
    {
        $request->validate([
            'kegiatan' => 'required',
            'wirausaha' => 'required_if:kegiatan,Wirausaha',
            'nama_perusahaan' => 'required_if:kegiatan,Bekerja',
            'alamat_perusahaan' => 'required_if:kegiatan,Bekerja',
            'jenis_perusahaan' => 'required_if:kegiatan,Bekerja',
            'tahun_memulai_kerja' => 'required_if:kegiatan,Bekerja',
            'relevansi' => 'required_if:kegiatan,Bekerja',
            'mempermudah_mencari_pekerjaan' => 'required',
            'membedakan_jenis_pekerjaan' => 'required',
            'menaikkan_gaji' => 'required'
        ]);

        if ($request->kegiatan == 'Wirausaha')
            $request->kegiatan .= ':' . $request->wirausaha;

        $manfaat = [];
        $manfaat['mempermudah_mencari_pekerjaan'] = $request->mempermudah_mencari_pekerjaan;
        $manfaat['membedakan_jenis_pekerjaan'] = $request->membedakan_jenis_pekerjaan;
        $manfaat['menaikkan_gaji'] = $request->menaikkan_gaji;

        $sertifikat->getKuesioner()->save(new Kuesioner([
            'kegiatan_setelah_mendapatkan_sertifikasi' => $request->kegiatan,
            'nama_perusahaan' => ($request->kegiatan == 'Bekerja' ? $request->nama_perusahaan : null),
            'alamat_perusahaan' => ($request->kegiatan == 'Bekerja' ? $request->alamat_perusahaan : null),
            'jenis_perusahaan' => ($request->kegiatan == 'Bekerja' ? $request->jenis_perusahaan : null),
            'tahun_memulai_kerja' => ($request->kegiatan == 'Bekerja' ? $request->tahun_memulai_kerja : null),
            'relevansi_sertifikasi_kompetensi_bidang_dengan_pekerjaan' => ($request->kegiatan == 'Bekerja' ? $request->relevansi : null),
            'manfaat_sertifikasi_kompetensi' => json_encode($manfaat),
            'saran_perbaikan_untuk_lsp_unesa' => $request->saran
        ]));

        return redirect()->route('sertifikasi.riwayat')->with([
            'success' => 'Berhasil mengisi kuesioner !'
        ]);
    }

}

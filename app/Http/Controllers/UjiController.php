<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Support\EksporUji;
use App\Support\Filter\UjiFilter;
use App\Models\{Uji, Syarat, Event};
use Storage;
use GlobalAuth;

class UjiController extends Controller
{

    use UjiFilter;

    public function __construct()
    {
        $this->middleware([
            'auth:mhs', 'verifikasi', 'terblokir', 'syaratlengkap'
        ])->only(['store']);
        $this->middleware('can:create,' . Uji::class)->only('store');
        // $this->middleware('menu:uji')->except(['store', 'lihatSyarat', 'updateNilaiAsesmenDiri']);
    }

    /**
     * Melakukan pendaftaran sertifikasi
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'event' => 'required|numeric|exists:event,id',
            'syarat.*' => 'nullableimage',
            'bukti_kompetensi_file.*' => 'nullable|mimes:pdf,jpg,jpeg,png,gif|max:1024',
            'portofolio_file.*' => 'nullable|mimes:pdf,jpg,jpeg,png,gif|max:1024'
        ]);
        
        $event = Event::find($request->event);

        $uji = new Uji([
            'nim' => GlobalAuth::user()->nim,
        ]);

        // update event_id pada tabel uji
        $event->getUji()->save($uji);

        // jika event yang dipilih adalah mandiri
        // maka menghapus relasi pada tabel mahasiswa_mandiri_event
        if ($event->getDana(false)->nama === 'Mandiri') {
            $event->getMahasiswaMandiriEvent()->detach(GlobalAuth::user()->nim);
        }

        $skema = $event->getSkema(false);

        // Mengunggah tiap syarat yang diunggah
        foreach ($skema->getSyarat(false) as $syarat) {
            $filename = null;
            $id = $syarat->id;
            if ($request->has('syarat.' . $id)) {
                $filename = $id . '.' . $request->file('syarat.' . $id)->getClientOriginalExtension();
                $request->file('syarat.' . $id)->storeAs('public/syarat/' . $uji->id, $filename);
            }
            $uji->getSyaratUji()->attach($id, [
                'filename' => $filename
            ]);
        }

        // Mengunggah bukti kompetensi
        if ($request->has('bukti_kompetensi_nama')) {
            foreach ($request->bukti_kompetensi_nama as $index => $namaBukti) {
                $filename = ucwords($namaBukti) . '.' . $request->file('bukti_kompetensi_file')[$index]->getClientOriginalExtension();
                $request->file('bukti_kompetensi_file')[$index]->storeAs('public/bukti_kompetensi/' . $uji->id, $filename);
            }
        }
        
        // Mengunggah portofolio
        if ($request->has('portofolio_nama')) {
            foreach ($request->portofolio_nama as $index => $namaPortofolio) {
                $filename = ucwords($namaPortofolio) . '.' . $request->file('portofolio_file')[$index]->getClientOriginalExtension();
                $request->file('portofolio_file')[$index]->storeAs('public/portofolio/' . $uji->id, $filename);
            }
        }

        return response()->json([
            'success' => true
        ]);
    }

    /**
     * Update the specified resource in storage.
     *  
     * @param  \Illuminate\Http\Request  $request
     * @param  Uji  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Uji $uji)
    {
        $request->validate([
            'asesor' => [
                'required',
                // Rule::exists('asesor_skema', 'user_id')->where(function ($query) use ($uji) {
                //     $query->where('skema_id', $uji->getSkema(false)->id);
                // })
            ],
            'tanggal_uji' => 'nullable|date'
        ]);

        $uji->update([
            'tidak_melanjutkan_asesmen' => $request->tidak_lanjut
        ]);

        if (!is_null($request->tanggal_uji)) {
            $uji->update([
                'tanggal_uji' => $request->tanggal_uji
            ]);
        }

        foreach ($request->input('asesor') as $asesor) {
            if ($uji->getAsesorUji()->where('id', $asesor)->count() == 0)
                $uji->getAsesorUji()->attach($asesor);
        }

        foreach ($uji->getAsesorUji(false) as $asesor) {
            if (!in_array($asesor->id, $request->input('asesor')))
                $uji->getAsesorUji()->detach($asesor->id);
        }

        if ($uji->getAsesorUji()->count() > 0) {
            if ($uji->getPenilaian()->count() == 0)
                $uji->initPenilaian();
        }

        return response()->json([
            'success' => true,
            'message' => 'Berhasil mengedit data uji !'
        ]);
    }

    /**
     * Melihat file persyaratan
     *
     * @param Request $request
     * @param Uji $uji
     * @param Syarat $syarat
     * @return \Illuminate\Http\Response
     */
    public function lihatSyarat(Request $request, Uji $uji, Syarat $syarat)
    {
        GlobalAuth::authorize('view', $uji);

        $dir = $uji->getSyaratUji()->where('id', $syarat->id)->first();

        return response()->file(
            storage_path('app/public/syarat/' . $uji->id . '/' . $dir->pivot->filename)
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Uji $id
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(Uji $uji)
    {
        $uji->delete();

        return response()->json([
            'success' => true,
            'message' => 'Berhasil menghapus !'
        ]);
    }

    /**
     * Melakukan update nilai dari uji tertentu
     *
     * @param Request $request
     * @param Uji $uji
     * @return \Illuminate\Http\Response
     */
    public function updateNilaiAsesmenDiri(Request $request, Uji $uji)
    {
        $input = collect($request->all());

        foreach ($input->keys() as $idKriteria) {
            $uji->getPenilaianDiri()->updateExistingPivot($idKriteria, [
                'nilai' => $request->input($idKriteria)['nilai']
            ]);
        }

        $uji->update([
            'tanggal_uji' => $uji->getEvent(false)->tanggal_uji
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Berhasil melakukan asesmen diri !',
            'redirect' => GlobalAuth::getAttemptedGuard() == 'mhs' ? route('sertifikasi.daftar') : url()->previous()
        ]);
    }

    /**
     * Melakukan update asesmen diri oleh asesor
     *
     * @param Request $request
     * @param Uji $uji
     * @return \Illuminate\Http\Response
     */
    public function updateAsesmenDiriAsesor(Request $request, Uji $uji)
    {
        $input = collect($request->nilai);

        foreach ($input->keys() as $idKriteria) {
            $uji->getPenilaianDiri()->updateExistingPivot($idKriteria, [
                'v' => $request->input('nilai.' . $idKriteria)['v'] == true ? true : null,
                'a' => $request->input('nilai.' . $idKriteria)['a'] == true ? true : null,
                't' => $request->input('nilai.' . $idKriteria)['t'] == true ? true : null,
                'm' => $request->input('nilai.' . $idKriteria)['m'] == true ? true : null,
                'bukti' => $request->input('nilai.' . $idKriteria)['bukti']
            ]);
        }

        $uji->update([
            'catatan_asesmen_diri' => $request->catatan,
            'proses_asesmen' => $request->proses_asesmen
        ]);

        if ($request->konfirmasi == true) {
            $uji->update([
                'konfirmasi_asesmen_diri' => true
            ]);

            if ($uji->isTidakLulusPenilaianDiri()) {
                $uji->update([
                    'rekomendasi_asesor_asesmen_diri' => 'Asesmen tidak dapat dilanjutkan dan perlu dilakukan kaji ulang.'
                ]);
            }
            else {
                $uji->update([
                    'rekomendasi_asesor_asesmen_diri' => 'Asesmen dapat dilanjutkan'
                ]);
                
                if ($uji->getPenilaian()->count() == 0)
                    $uji->initPenilaian();
            }

        }

        return response()->json([
            'success' => true,
            'message' => 'Berhasil memperbarui data !',
            'redirect' => route('penilaian')
        ]);
    }

    /**
     * Melakukan ekspor uji dalam bentuk excel sesuai format untuk bnsp
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function ekspor(Request $request)
    {
        $daftarUji = Uji::query();
        $daftarUji = $this->simplifyFilter($request, $daftarUji, 0)->get();

        $file = new EksporUji($daftarUji);
        return $file->export();
    }

    /**
     * Melakukan reset penilaian
     *
     * @param \App\Support\EksporUji $uji
     * @return \Illuminate\Http\Response
     */
    public function resetPenilaian(Uji $uji)
    {
        GlobalAuth::authorize('resetPenilaian', $uji);

        $uji->resetPenilaian();

        $uji->update([
            'rekomendasi_asesor' => null,
            'saran_tindak_lanjut' => null,
            'umpan_balik' => null,
            'identifikasi_kesenjangan' => null
        ]);

        return response()->json([
            'success' => true
        ]);
    }
    
    /**
     * Melakukan reset penilaian diri
     *
     * @param \App\Support\EksporUji $uji
     * @return \Illuminate\Http\Response
     */
    public function resetPenilaianDiri(Uji $uji)
    {
        GlobalAuth::authorize('resetPenilaianDiri', $uji);

        $uji->resetPenilaianDiri();

        return response()->json([
            'success' => true
        ]);
    }

    /**
     * Melihat file bukti kompetensi
     *
     * @param \App\Support\EksporUji $uji
     * @param string $bukti
     * @return mixed
     */
    public function lihatBuktiKomepetensi(Uji $uji, $bukti)
    {
        GlobalAuth::authorize('view', $uji);

        if (Storage::exists('bukti_kompetensi/' . $uji->id . '/' . $bukti))
            return abort(404);

        return response()->file(
            storage_path('app/public/bukti_kompetensi/' . $uji->id . '/' . $bukti)
        );
    }
    
    /**
     * Melihat file portofolio
     *
     * @param \App\Support\EksporUji $uji
     * @param string $bukti
     * @return mixed
     */
    public function lihatPortofolio(Uji $uji, $portofolio)
    {
        GlobalAuth::authorize('view', $uji);

        if (Storage::exists('portofolio/' . $uji->id . '/' . $portofolio))
            return abort(404);

        return response()->file(
            storage_path('app/public/portofolio/' . $uji->id . '/' . $portofolio)
        );
    }

    /**
     * Melakukan inisialisasi penilaian diri pada tabel 
     * penilaian_diri untuk uji tertentu
     *
     * @param \App\Support\EksporUji $uji
     * @return \Illuminate\Http\Response
     */
    public function inisialisasiPenilaianDiri(Uji $uji)
    {
        // mendapatkan daftar kriteria
        $daftarKriteria = $uji->getPenilaianDiri(false)->pluck('id')->toArray();
        
        // Menghapus data
        $uji->getPenilaianDiri()->detach($daftarKriteria);

        // Inisialisasi
        $uji->initPenilaianDiri();

        return response()->json([
            'success' => true,
            'message' => 'Berhasil menginisialisasi ulang data penilaian diri !'
        ]);
    }

    /**
     * Menghapus data penilaian
     *
     * @param \App\Support\EksporUji $uji
     * @return \Illuminate\Http\Response
     */
    public function hapusPenilaian(Uji $uji)
    {
        $daftarKriteria = $uji->getPenilaian(false)->pluck('id')->toArray();

        $uji->getPenilaian()->detach($daftarKriteria);

        $uji->update([
            'rekomendasi_asesor' => null,
            'saran_tindak_lanjut' => null,
            'umpan_balik' => null,
            'identifikasi_kesenjangan' => null
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Berhasil menghapus data !'
        ]);
    }

    /**
     * Melakukan inisialisasi data penilaian pada tabel penilaian
     * untuk uji tertentu
     *
     * @param \App\Support\EksporUji $uji
     * @return \Illuminate\Http\Response
     */
    public function inisialisasiPenilaian(Uji $uji)
    {
        if ($uji->getPenilaian()->count() == 0)
            $uji->initPenilaian();

        $uji->update([
            'rekomendasi_asesor' => null,
            'saran_tindak_lanjut' => null,
            'umpan_balik' => null,
            'identifikasi_kesenjangan' => null
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Berhasil menginisialisasi data penilaian !'
        ]);
    }

    /**
     * mengubah status kelulusan dari uji tertentu
     *
     * @param \App\Support\EksporUji $uji
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function ubahStatusKelulusan(Uji $uji, Request $request)
    {
        $status = [
            true, false, null
        ];

        $uji->update([
            'lulus' => $status[$request->status]
        ]);

        return back()->with([
            'success' => 'Berhasil mengubah status kelulusan !'
        ]);
    }

    /**
     * Melakukan pengisian form MAK 04
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Uji $uji
     * @return \Illuminate\Http\Response
     */
    public function isimak4(Request $request, Uji $uji)
    {
        $request->validate([
            'hasil.*' => 'required'
        ]);

        $temp = $uji->helper;

        $temp['mak4']['jawaban'] = $request->hasil;
        $temp['mak4']['catatan'] = $request->catatan;

        $uji->helper = $temp;
        $uji->save();

        if (GlobalAuth::getAttemptedGuard() == 'mhs') {
            return redirect()->route('sertifikasi.riwayat');
        }

        return redirect()->route('uji.troubleshoot', [
            'uji' => encrypt($uji->id)
        ]);
    }

    /**
     * Menghapus key "mak4" pada kolom "helper" di tabel "uji" untuk uji tertentu
     *
     * @param \App\Support\EksporUji $uji
     * @return \Illuminate\Http\Response
     */
    public function resetMak4(Uji $uji)
    {
        $temp = $uji->helper;

        unset($temp['mak4']);

        $uji->helper = $temp;
        $uji->save();

        return response()->json([
            'success' => 'Berhasil mereset MAK 04 !'
        ]);
    }

    /**
     * Melakukan verifikasi persyaratan
     *
     * @param Request $request
     * @param Uji $uji
     * @return \Illuminate\Http\Response
     */
    public function verifikasiPersyaratan(Request $request, Uji $uji)
    {
        $verifikasi_bukti = $request->input('verifikasi_bukti');
        $verifikasi_syarat = $request->input('verifikasi_syarat');
        $helper = $uji->helper;

        // verifikasi syarat
        $arr_verifikasi_syarat = [];

        foreach ($verifikasi_syarat as $item) {

        }
        
        // verifikasi bukti
        $arr_verifikasi_bukti = [];

        foreach ($verifikasi_bukti as $item) {

        }

        $helper['verifikasi_syarat'] = $arr_verifikasi_syarat;
        $helper['verifikasi_bukti'] = $arr_verifikasi_bukti;

        $uji->helper = $helper;
        $uji->save();

        return back()->with([
            'success' => 'Berhasil menyimpan verifikasi persyaratan !'
        ]);
    }

}

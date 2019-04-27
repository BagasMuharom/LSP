<?php

namespace App\Http\Controllers;

use App\Models\Kustomisasi;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Support\Form\FormAsesmenDiri;
use App\Support\EksporUji;
use App\Support\Filter\UjiFilter;
use App\Models\{Uji, Syarat, Skema, Menu, Event};
use Auth;
use Storage;
use GlobalAuth;
use PDF;
use function Symfony\Component\Debug\header;

class UjiController extends Controller
{

    use UjiFilter;

    public function __construct()
    {
        $this->middleware([
            'auth:mhs', 'verifikasi', 'terblokir', 'syaratlengkap'
        ])->only(['store', 'updateNilaiAsesmenDiri']);
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
            'bukti_kompetensi_file.*' => 'nullable|mimes:pdf,jpg,jpeg,png,gif|max:1024'
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

        if ($request->has('bukti_kompetensi_nama')) {
            foreach ($request->bukti_kompetensi_nama as $index => $namaBukti) {
                $filename = ucwords($namaBukti) . '.' . $request->file('bukti_kompetensi_file')[$index]->getClientOriginalExtension();
                $request->file('bukti_kompetensi_file')[$index]->storeAs('public/bukti_kompetensi/' . $uji->id, $filename);
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
            'redirect' => route('sertifikasi.daftar')
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
            'catatan_asesmen_diri' => $request->catatan
        ]);

        if ($request->konfirmasi == true) {
            $uji->update([
                'konfirmasi_asesmen_diri' => true
            ]);

            if ($uji->isTidakLulusPenilaianDiri()) {
                $uji->update([
                    'rekomendasi_asesor_asesmen_diri' => 'Proses uji kompetensi tidak dapat dilanjutkan dan perlu dilakukan kaji ulang.'
                ]);
            }
            else {
                $uji->update([
                    'rekomendasi_asesor_asesmen_diri' => 'Proses uji kompetensi dapat dilanjutkan'
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
     * Mencetak asesmen diri
     *
     * @param Uji $uji  
     * @return \Illuminate\Http\Response
     */
    public function cetakAsesmenDiri(Uji $uji)
    {
        $pdf = PDF::loadView('form.apl_02', [
            'uji' => $uji,
            'skema' => $uji->getSkema(false),
            'mahasiswa' => $uji->getMahasiswa(false),
            'asesmendiri' => $uji->getPenilaianDiri()
        ]);

        // return view('form.apl_02', [
        //     'uji' => $uji,
        //     'skema' => $uji->getSkema(false),
        //     'mahasiswa' => $uji->getMahasiswa(false),
        //     'asesmendiri' => $uji->getPenilaianDiri()
        // ]);

        return $pdf->stream();
    }

    /**
     * Menyetak form pendaftaran
     *
     * @param Uji $uji
     * @return void
     */
    public function cetakFormPendaftaran(Uji $uji)
    {
        // return view('form.pendaftaran');
        $mahasiswa = $uji->getMahasiswa(false);
        $daftarSyarat = $uji->getSyaratUji(false);
        $persyaratan = $uji->getSkema(false)->getSyarat(false);
        $pdf = PDF::loadView('form.pendaftaran', [
            'mahasiswa' => $mahasiswa,
            'daftarSyarat' => $daftarSyarat,
            'skema' => $uji->getSkema(false),
            'persyaratan' => $persyaratan
        ]);
        $pdf->setPaper('A4');

        return $pdf->stream();
        return view('form.pendaftaran', [
            'mahasiswa' => $mahasiswa,
            'daftarSyarat' => $daftarSyarat,
            'persyaratan' => $persyaratan,
            'skema' => $uji->getSkema(false)
        ]);
    }

    /**
     * Menyetak form mak
     *
     * @param \App\Support\EksporUji $uji
     * @return mixed
     */
    public function cetakMpa02(Uji $uji)
    {
        $pdf = PDF::loadView('form.mpa02', [
            'uji' => $uji,
            'skema' => $uji->getSkema(false)
        ]);
        $pdf->setPaper('A4');

        return view('form.mpa02', [
            'uji' => $uji,
            'skema' => $uji->getSkema(false)
        ]);

        return $pdf->stream();
    }

    /**
     * menyetak form MAK 02
     *
     * @return mixed
     */
    public function cetakMak02(Uji $uji)
    {
        $pdf = PDF::loadView('form.mak_02', [
            'uji' => $uji,
            'skema' => $uji->getSkema(false)
        ]);

        // return view('form.mak_02', [
        //     'uji' => $uji,
        //     'skema' => $uji->getSkema(false)
        // ]);

        return $pdf->stream();
    }
    
    /**
     * menyetak form APL 01
     *
     * @return mixed
     */
    public function cetakApl01(Uji $uji)
    {
        $persyaratan = $uji->getSkema(false)->getSyarat(false);

        $pdf = PDF::loadView('form.apl_01', [
            'uji' => $uji,
            'mahasiswa' => $uji->getMahasiswa(false),
            'skema' => $uji->getSkema(false),
            'persyaratan' => $persyaratan
        ]);

        // return view('form.apl_01', [
        //     'uji' => $uji,
        //     'mahasiswa' => $uji->getMahasiswa(false),
        //     'skema' => $uji->getSkema(false),
        //     'persyaratan' => $persyaratan
        // ]);

        return $pdf->stream();
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

}

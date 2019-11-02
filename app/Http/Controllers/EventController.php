<?php

namespace App\Http\Controllers;

use App\Models\{Dana, Event, Role, Skema};
use CzProject\PdfRotate\PdfRotate;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use PDF;
use Illuminate\Support\Facades\File;

class EventController extends Controller
{
    public function __construct()
    {
        $this->middleware([
            'auth:user',
            'menu:event'
        ]);
    }

    /**
     * Mendapatkan daftar event untuk ditampilkan pada filter
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getDaftarEvent(Request $request)
    {
        $daftarEvent = Event::when($request->has('keyword'), function ($query) use ($request) {
            $query->wherehas('getSkema', function ($query) use ($request) {
                $query->where('nama', 'ILIKE', '%' . $request->keyword . '%');
            })->orWhereHas('getDana', function ($query) use ($request) {
                $query->where('nama', 'ILIKE', '%' . $request->keyword . '%');
            });
        })->with(['getSkema', 'getDana'])->get();

        $daftarEvent = $daftarEvent->map(function ($event) {
            $event->nama = $event->getSkema->nama . ' (' . $event->getDana->nama . ') ' . formatDate($event->tgl_uji, true, false);

            return $event;
        });

        return response()->json(
            $daftarEvent->toArray()
        );
    }

    public function update(Event $event, Request $request)
    {
        $this->validate($request, [
            'skema_id' => 'required',
            'dana_id' => 'required',
            'tgl_mulai_pendaftaran' => 'required',
            'tgl_akhir_pendaftaran' => 'required',
            'tgl_uji' => 'required'
        ]);

//        if ($event->isFinished())
//            return back()->with('error', 'Anda tidak bisa merubah data event yang telah selesai');

        $kolom = [];

//        if ($event->isAkanDatang()){
            $event->skema_id = $request->skema_id;
            $event->dana_id = $request->dana_id;
            array_push($kolom, 'skema', 'dana');
//        }

//        if (!$event->isOnGoing() && !$event->isFinished()){
            $event->tgl_mulai_pendaftaran = $request->tgl_mulai_pendaftaran;
            array_push($kolom, 'tanggal mulai pendaftaran');
//        }

        $event->tgl_akhir_pendaftaran = $request->tgl_akhir_pendaftaran;
        $event->tgl_uji = $request->tgl_uji;
        $event->save();

        array_push($kolom, 'tanggal akhir pendaftaran', 'tanggal uji');

        return back()->with('success', 'Berhasil memperbarui '.implode(', ', $kolom).' pada event ini');
    }

    public function add(Request $request)
    {
        $this->validate($request, [
            'skema' => 'required',
            'dana' => 'required',
            'tgl_mulai_pendaftaran' => 'required',
            'tgl_akhir_pendaftaran' => 'required',
            'tgl_uji' => 'required'
        ]);

        $tglMulaiPendaftaran = Carbon::parse($request->tgl_mulai_pendaftaran);
        $tglAkhirPendaftaran = Carbon::parse($request->tgl_akhir_pendaftaran)
            ->addHours(23)
            ->addMinutes(59)
            ->addSeconds(59);
        $tglUji = Carbon::parse($request->tgl_uji);

        $eventParams = [
            'skema' => $request->skema,
            'dana' => $request->dana,
            'tgl_mulai_pendaftaran' => $request->tgl_mulai_pendaftaran,
            'tgl_akhir_pendaftaran' => $request->tgl_akhir_pendaftaran,
            'tgl_uji' => $request->tgl_uji
        ];

        if ($tglMulaiPendaftaran->greaterThan($tglAkhirPendaftaran))
            return redirect(route('event', $eventParams))->with('error', 'Tanggal mulai pendaftaran tidak boleh mendahului tanggal akhir pendaftaran :)');

        if ($tglUji->lessThanOrEqualTo($tglAkhirPendaftaran))
            return redirect(route('event', $eventParams))->with('error', 'Tanggal uji tidak boleh didahului atau sama dengan tanggal akhir pendaftaran');

        if (Carbon::today()->greaterThan($tglAkhirPendaftaran))
            return redirect(route('event', $eventParams))->with('error', 'Tanggal akhir pendaftaran tidak boleh didahului oleh hari ini');

        $skema = Skema::findByKode($request->skema);
        $dana = Dana::findByNama($request->dana);

        if (Event::has($skema, $dana, $tglMulaiPendaftaran, $tglAkhirPendaftaran, $tglUji)){
            $eventParams['filter'] = 'on';
            return redirect(route('event', $eventParams))->with('error', 'Event ini telah ada');
        }

        Event::create([
            'skema_id' => $skema->id,
            'dana_id' => $dana->id,
            'tgl_mulai_pendaftaran' => $tglMulaiPendaftaran,
            'tgl_akhir_pendaftaran' => $tglAkhirPendaftaran,
            'tgl_uji' => $tglUji
        ]);

        $eventParams['filter'] = 'on';
        return redirect(route('event', $eventParams))->with('success', 'Event berhasil dibuat');
    }

    public function delete(Event $event)
    {
        if ($event->isAkanDatang()){
            $event->delete();

            return back()->with('success', 'Berhasil menghapus event');
        }

        return back()->with('error', 'Anda hanya dapat menghapus event yang akan datang');
    }

    public function print(Request $request, Event $event)
    {
        $this->validate($request, [
            'format' => 'required',
            'mahasiswa' => 'required'
        ]);

        if ($request->format == 'mak05') {
            return $this->cetakMak05($request, $event);
        }

        foreach (scandir(public_path($path = 'tmp')) as $fileName){
            if (file_exists(public_path($path.'/'.$fileName)) && $fileName != '.gitignore'){
                File::delete(public_path($path.'/'.$fileName));
                print "Menghapus ".$path.'/'.$fileName."<br>";
            }
        }

        $combinedFileName = 'Berita Acara '.$event->id.' '.$event->getSkema(false)->nama;
        $combinedFileName = str_replace(' ', '_', $combinedFileName);

        $uji = $event->getUji()->whereIn('nim', $request->mahasiswa)->get();
        $ujiLulus = $uji->filter(function ($value, $key) {
            return $value->isLulus();
        });
        $ujiTidakLulus = $uji->whereNotIn('nim', $ujiLulus->pluck('nim'));

        if ($request->format == 'P'){
            $pdfPotrait = PDF::loadView('form.berita_acara_potrait', [
                'event' => $event,
                'no' => 1,
                'uji' => $uji,
                'ujiLulus' => $ujiLulus,
                'ujiTidakLulus' => $ujiTidakLulus
            ])->setPaper('A4');
//            file_put_contents(public_path('tmp/'.$potraitFileName), $pdfPotrait->output());
            return $pdfPotrait->download($combinedFileName.'_part1.pdf');
        }

        $pdfLandscape = PDF::loadView('form.berita_acara_landscape', [
            'event' => $event,
            'no' => 1,
            'uji' => $uji
        ])->setPaper('A4', 'landscape');
        file_put_contents(public_path('tmp/'.$combinedFileName.'_part2.pdf'), $pdfLandscape->output());

        $pdfRotate = new PdfRotate;
        $pdfRotate->rotatePdf(public_path('tmp/'.$combinedFileName.'_part2.pdf'), public_path('tmp/'.$combinedFileName.'_part2.pdf'), $pdfRotate::DEGREES_90);

        return redirect(asset('tmp/'.$combinedFileName.'_part2.pdf'));
    }

    public function cetakMak05(Request $request, Event $event)
    {
        $daftarUji = $event->getUji()->whereIn('nim', $request->mahasiswa)->get();

        $pdf = PDF::loadView('form.mak_05', [
            'event' => $event,
            'skema' => $event->getSkema(false),
            'daftarUji' => $daftarUji,
            'asesor' => $daftarUji->first()->getAsesorUji(false),
            'ketua' => Role::where('nama', 'KETUA LSP')->first()->getUserRole()->first(),
            'daftarAsesorUji' => $daftarUji->first()->getAsesorUji(false)
        ]);

        return $pdf->stream();
    }
    
    public function cetakMak06(Event $event)
    {
        $daftarUji = $event->getUji(false);

        $pdf = PDF::loadView('form.mak_06', [
            'event' => $event,
            'skema' => $event->getSkema(false),
            'asesor' => $daftarUji->first()->getAsesorUji(false)
        ]);

        return $pdf->stream();
    }

}

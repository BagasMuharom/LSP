<?php

namespace App\Http\Controllers\Pages;

use App\Models\Dana;
use App\Models\Event;
use App\Models\Menu;
use App\Models\Skema;
use App\Models\Uji;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Support\Filter\UjiFilter;

class EventPageController extends Controller
{

    use UjiFilter;

    public function __construct()
    {
        $this->middleware([
            'auth:user',
            'menu:event'
        ]);
    }

    public function index(Request $request)
    {
        $data = Event::when($request->filter, function ($query) use ($request) {
            $query->when($request->skema, function ($query) use ($request){
                $query->whereHas('getSkema', function ($query) use ($request){
                    $query->where('kode', $request->skema);
                });
            })->when($request->dana, function ($query) use ($request){
                $query->whereHas('getDana', function ($query) use ($request){
                    $query->where('nama', $request->dana);
                });
            })->when($request->tgl_uji, function ($query) use ($request){
                $date = Carbon::parse($request->tgl_uji);

                $query->whereDate('tgl_uji', $date->toDateString());
            })->when($request->tgl_mulai_pendaftaran, function ($query) use ($request) {
                $query->when($request->tgl_akhir_pendaftaran, function ($query) use ($request) {
                    $from = Carbon::parse($request->tgl_mulai_pendaftaran);
                    $to = Carbon::parse($request->tgl_akhir_pendaftaran)
                        ->addHours(23)
                        ->addMinutes(59)
                        ->addSeconds(59);

                    $query->where(function ($query) use ($from, $to){
                        $query->where(function ($query) use ($from, $to) {
                            $query->whereBetween('tgl_mulai_pendaftaran', [
                                $from->toDateTimeString(),
                                $to->toDateTimeString()
                            ])->whereBetween('tgl_akhir_pendaftaran', [
                                $from->toDateTimeString(),
                                $to->toDateTimeString()
                            ]);
                        });
                    });
                });
            })->when($request->status, function ($query) use ($request) {
                $query->where(function ($query) use ($request) {
                    foreach ($request->status as $status){
                        if ($status == 'akan-datang'){
                            $query->orWhere('tgl_mulai_pendaftaran', '>', Carbon::now());
                        } elseif ($status == 'sedang-berlangsung'){
                            $query->orWhere(function ($query) {
                                $query->where('tgl_mulai_pendaftaran', '<=', Carbon::now())
                                    ->where('tgl_uji', '>=', Carbon::now());
                            });
                        } elseif ($status == 'selesai'){
                            $query->orWhere('tgl_uji', '<', Carbon::now());
                        }
                    }
                });
            });
        })->orderByDesc('created_at')
            ->orderByDesc('tgl_mulai_pendaftaran')
            ->orderByDesc('tgl_akhir_pendaftaran')
            ->orderByDesc('tgl_uji')
            ->paginate(10)
            ->appends($request->all());

        return view('menu.event.index', [
            'menu' => Menu::findByRoute(Menu::EVENT),
            'data' => $data,
            'no' => 0,
            'listSkema' => Skema::orderBy('kode')->get(),
            'listDana' => Dana::orderBy('created_at')->get(),
            'skema' => $request->skema,
            'dana' => $request->dana,
            'tgl_mulai_pendaftaran' => $request->tgl_mulai_pendaftaran,
            'tgl_akhir_pendaftaran' => $request->tgl_akhir_pendaftaran,
            'tgl_uji' => $request->tgl_uji,
            'status' => $request->status
        ]);
    }

    public function detail(Event $event, Request $request)
    {
        return view('menu.event.edit', [
            'menu' => Menu::findByRoute(Menu::EVENT),
            'event' => $event,
            'listSkema' => Skema::orderBy('kode')->get(),
            'listDana' => Dana::orderBy('created_at')->get()
        ]);
    }

    /**
     * Menampilkan halaman daftar uji dari event tertentu
     *
     * @param \App\Models\Event $event
     * @return \Illuminate\Http\Response
     */
    public function daftarUji(Event $event, Request $request)
    {
        $daftaruji = Uji::where('event_id', $event->id)->getLolosVerifikasi()->orderBy('updated_at', 'desc');

        $daftaruji = $this->simplifyFilter($request, $daftaruji, 7);

        return view('menu.uji.index', [
            'daftaruji' => $daftaruji->paginate(20)->appends($request->except('page')),
            'total' => $daftaruji->count()
        ]);
    }

}

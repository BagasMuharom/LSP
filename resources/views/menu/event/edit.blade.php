@extends('layouts.carbon.app', [
    'sidebar' => true
])

@section('title', $menu->nama.' > Detail | '.kustomisasi('nama'))

@push('css')
    <link rel="stylesheet" href="{{ asset('tempusdominus/tempusdominus-bootstrap-4.css') }}">
@endpush

@section('content')
    @include('layouts.include.alert')

    @row

    @col(['size' => 8])
    @card(['title' => 'Detail event'])

    @if($event->isAkanDatang())
        @alert(['type' => 'info'])
        Event akan berlangsung {{ $event->tgl_mulai_pendaftaran->diffForHumans() }}
        @endalert
    @elseif($event->isOnGoing())
        @alert(['type' => 'warning'])
        Event ini sedang berlangsung (anda hanya dapat mengubah tanggal akhir pendaftaran dan tanggal uji)
        @endalert
    @else
        @alert(['type' => 'success'])
        Event ini telah selesai (anda tidak dapat mengubah apapun)
        @endalert
    @endif

    <form action="{{ route('event.update', ['event' => encrypt($event->id)]) }}" method="post">
        @csrf
        {{ method_field('patch') }}

        @row

        @col(['size' => 8])
        <div class="form-group">
            <label><b>Skema</b></label>
            <select class="form-control select2" name="skema_id">
                <option value="{{ $event->getSkema(false)->id }}">
                    {{ $event->getSkema(false)->kode }} ({{ $event->getSkema(false)->nama }})
                </option>
                @foreach($listSkema as $item)
                    @if($event->getSkema(false)->id != $item->id)
                        <option value="{{ $item->id }}">
                            {{ $item->kode }} ({{ $item->nama }})
                        </option>
                    @endif
                @endforeach
            </select>
        </div>
        @endcol

        @col(['size' => 4])
        <div class="form-group">
            <label><b>Dana</b></label>
            <select class="form-control select2" name="dana_id">
                <option value="{{ $event->getDana(false)->id }}">
                    {{ $event->getDana(false)->nama }}
                </option>
                @foreach($listDana as $item)
                    @if($event->getDana(false)->id != $item->id)
                        <option value="{{ $item->id }}">
                            {{ $item->nama }}
                        </option>
                    @endif
                @endforeach
            </select>
        </div>
        @endcol

        @endrow

        <div class="form-group">
            <label><b>Tanggal mulai pendaftaran</b></label>
            <input type="text" class="form-control dt" id="tmp" data-toggle="datetimepicker" data-target="#tmp" name="tgl_mulai_pendaftaran" style="display: none" value="{{ $event->tgl_mulai_pendaftaran }}">
        </div>

        <div class="form-group">
            <label><b>Tanggal akhir pendaftaran</b></label>
            <input type="text" class="form-control dt" id="tmp" data-toggle="datetimepicker" data-target="#tmp" name="tgl_akhir_pendaftaran" style="display: none" value="{{ $event->tgl_akhir_pendaftaran }}">
        </div>

        <div class="form-group">
            <label><b>Tanggal uji</b></label>
            <input type="text" class="form-control dt" id="tmp" data-toggle="datetimepicker" data-target="#tmp" name="tgl_uji" style="display: none" value="{{ $event->tgl_uji }}">
        </div>

        <button class="btn btn-success">Simpan</button>
    </form>
    @endcard
    @endcol

    @col(['size' => 4])
    @card(['title' => 'Pendaftar'])

    @alert(['type' => 'info'])
    Terdapat {{ $event->getUji()->count() }} pendaftar
    @endalert

    <a class="btn btn-primary" href="{{ route('event.daftaruji', ['event' => encrypt($event->id)]) }}">Lihat Daftar Uji</a>

    @slot('table')
        <table class="table">
            <thead>
            <tr>
                <th>Nim & Nama</th>
                <th>Prodi</th>
            </tr>
            </thead>
            <tbody>
            @foreach($event->getUji()->orderByDesc('created_at')->get() as $uji)
            <tr>
                <td>
                    {{ $uji->nim }}
                    <br>
                    {{ $uji->getMahasiswa(false)->nama }}
                </td>
                <td>
                    {{ $uji->getMahasiswa(false)->getProdi(false)->nama }}
                    <br>
                    @if($event->isFinished())
                        @if($uji->isLulus())
                            <span class="badge badge-success">Kompeten</span>
                        @elseif($uji->isTidakLulus())
                            <span class="badge badge-danger">Belum Kompeten</span>
                        @else
                            <span class="badge badge-info">Dalam proses penilaian</span>
                        @endif
                    @endif
                </td>
            </tr>
            @endforeach
            </tbody>
        </table>
    @endslot
    @endcard
    @endcol

    @endrow
@endsection

@push('js')
    <script src="{{ asset('tempusdominus/moment-with-locales.min.js') }}"></script>
    <script src="{{ asset('tempusdominus/tempusdominus-bootstrap-4.js') }}"></script>
    <script>
        $('.dt').datetimepicker({
            format: 'YYYY-MM-DD HH:mm:ss',
            inline: true,
            sideBySide: true
        })
        $('.select2').select2()
    </script>
@endpush
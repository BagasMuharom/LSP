@extends('layouts.carbon.app', [
    'sidebar' => true
])

@section('title', $menu->nama.' | '.kustomisasi('nama'))

@push('css')
    <link rel="stylesheet" href="{{ asset('tempusdominus/tempusdominus-bootstrap-4.css') }}">
@endpush

@section('content')
    @include('layouts.include.alert')

    @card(['title' => 'Daftar event'])

    <form action="{{ url()->current() }}" autocomplete="off">
        <input type="hidden" name="filter" value="on">

        @row

        @col(['size' => 6])
        <div class="form-group">
            <label>Skema</label>
            <select class="form-control select2" name="skema" id="skema-f">
                <option value="{{ $skema }}">{{ \App\Models\Skema::isAvailable($skema) ? \App\Models\Skema::findByKode($skema)->kode.' ('.\App\Models\Skema::findByKode($skema)->nama.')' : '' }}</option>
                @foreach($listSkema as $item)
                    @if($item->kode != $skema)
                        <option value="{{ $item->kode }}">
                            {{ $item->kode }} ({{ $item->nama }})
                        </option>
                    @endif
                @endforeach
            </select>
        </div>
        @endcol

        @col(['size' => 3])
        <div class="form-group">
            <label>Dana</label>
            <select class="form-control select2" name="dana" id="dana-f">
                <option value="{{ $dana }}">{{ \App\Models\Dana::has($dana) ? \App\Models\Dana::findByNama($dana)->nama : '' }}</option>
                @foreach($listDana as $item)
                    @if($item->nama != $dana)
                        <option value="{{ $item->nama }}">
                            {{ $item->nama }} ({{ $item->berulang ? 'berulang' : 'tidak berulang' }})
                        </option>
                    @endif
                @endforeach
            </select>
        </div>
        @endcol

        @col(['size' => 3])
        <div class="form-group">
            <label>Status <small><b>(hiraukan dalam membuat event)</b></small></label>
            <select class="form-control select2" name="status[]" multiple id="status">
                <option></option>
                <option value="akan-datang" {{ (!empty($status) && in_array('akan-datang', $status)) ? 'selected' : '' }}>Akan Datang</option>
                <option value="sedang-berlangsung" {{ (!empty($status) && in_array('sedang-berlangsung', $status)) ? 'selected' : '' }}>Sedang Berlangsung</option>
                <option value="selesai" {{ (!empty($status) && in_array('selesai', $status)) ? 'selected' : '' }}>Selesai</option>
            </select>
        </div>
        @endcol

        @col(['size' => 4])
        <div class="form-group">
            <label>Tanggal mulai pendaftaran</label>
            <input type="text" class="form-control dt" id="tmp-f" data-toggle="datetimepicker" data-target="#tmp-f" value="{{ $tgl_mulai_pendaftaran }}" name="tgl_mulai_pendaftaran">
        </div>
        @endcol

        @col(['size' => 4])
        <div class="form-group">
            <label>Tanggal akhir pendaftaran</label>
            <input type="text" class="form-control dt" id="tap-f" data-toggle="datetimepicker" data-target="#tap-f" value="{{ $tgl_akhir_pendaftaran }}" name="tgl_akhir_pendaftaran">
        </div>
        @endcol

        @col(['size' => 4])
        <div class="form-group">
            <label>Tanggal uji <small><b>(hiraukan waktu untuk filter)</b></small></label>
            <input type="text" class="form-control" id="tu-f" data-toggle="datetimepicker" data-target="#tu-f" value="{{ $tgl_uji }}" name="tgl_uji">
        </div>
        @endcol

        @endrow

        <div class="btn-group">
            <button type="button" class="btn btn-success" onclick="add()">Buat event</button>
            <button type="button" class="btn btn-link">atau</button>
            <button type="submit" class="btn btn-info">Filter</button>
            <button type="button" class="btn btn-link">{{ $data->total() }} event sesuai filter</button>
        </div>
    </form>

    <form action="{{ route('event.add') }}" method="post" id="event">
        @csrf
        {{ method_field('put') }}
        <input type="hidden" name="skema" id="skema">
        <input type="hidden" name="dana" id="dana">
        <input type="hidden" name="tgl_mulai_pendaftaran" id="tmp">
        <input type="hidden" name="tgl_akhir_pendaftaran" id="tap">
        <input type="hidden" name="tgl_uji" id="tu">
    </form>

    @slot('table')
        <table class="table table-striped">
            <thead>
            <tr>
                <th>No</th>
                <th>Skema</th>
                <th>Dana</th>
                <th>Tgl. Mulai Daftar</th>
                <th>Tgl. Akhir Daftar</th>
                <th>Tgl. Uji</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
            </thead>
            <tbody>
            @foreach($data as $event)
                <tr>
                    <td>
                        {{ ($data->currentpage() * $data->perpage()) + (++$no) - $data->perpage()  }}
                    </td>
                    <td>
                        {{ $event->getSkema(false)->kode }}
                        <br>
                        {{ $event->getSkema(false)->nama }}
                    </td>
                    <td>{{ $event->getDana(false)->nama }}</td>
                    <td>{{ formatDate($event->tgl_mulai_pendaftaran, true) }}</td>
                    <td>{{ formatDate($event->tgl_akhir_pendaftaran, true) }}</td>
                    <td>{{ formatDate($event->tgl_uji, true) }}</td>
                    <td>
                        @if($event->isAkanDatang())
                            <span class="badge badge-primary">Akan Datang</span>
                        @elseif($event->isOnGoing())
                            <span class="badge badge-warning">Sedang Berlangsung</span>
                        @else
                            <span class="badge badge-success">Selesai</span>
                        @endif
                    </td>
                    <td>
                        <div class="btn-group">
                            <a class="btn btn-info btn-sm" href="{{ route('event.detail', ['event' => encrypt($event->id)]) }}" title="Detail atau Edit">
                                <i class="icon icon-eye"></i>
                            </a>
                            @if($event->isFinished())
                                {{--<a class="btn btn-primary btn-sm text-white" title="Print Berita Acara" href="{{ route('event.berita-acara.print', ['event' => encrypt($event->id)]) }}">--}}
                                    {{--<i class="icon icon-printer"></i>--}}
                                {{--</a>--}}
                                <button class="btn btn-primary btn-sm text-white" title="Print Berita Acara" onclick="event.preventDefault(); $('#peserta-{{ $event->id }}').toggle()">
                                    <i class="icon icon-printer"></i>
                                </button>
                            @endif
                            @if($event->isAkanDatang())
                                <button class="btn btn-danger btn-sm" title="Hapus" onclick="hapus('{{ route('event.delete', ['event' => encrypt($event->id)]) }}')">
                                    <i class="icon icon-trash"></i>
                                </button>
                            @endif
                        </div>
                    </td>
                </tr>
                <tr id="peserta-{{ $event->id }}" style="display: none">
                    <td colspan="8">
                        <form action="{{ route('event.berita-acara.print', ['event' => encrypt($event->id)]) }}" method="post" id="form-peserta-{{ $event->id }}" target="_blank">
                            @csrf
                            <input type="hidden" name="format" id="format-{{ $event->id }}">
                            <div class="btn btn-group">

                                <button type="button" class="btn btn-info btn-sm" onclick="event.preventDefault(); $('#format-{{ $event->id }}').val('P');$('#form-peserta-{{ $event->id }}').submit()">
                                    <i class="icon icon-printer"></i>
                                    Cetak mahasiswa yang dicentang - part 1
                                </button>

                                <button class="btn btn-info btn-sm" onclick="event.preventDefault(); $('#format-{{ $event->id }}').val('L');$('#form-peserta-{{ $event->id }}').submit()">
                                    <i class="icon icon-printer"></i>
                                    Cetak mahasiswa yang dicentang - part 2
                                </button>
                                
                                <button class="btn btn-info btn-sm" onclick="event.preventDefault(); $('#format-{{ $event->id }}').val('mak05');$('#form-peserta-{{ $event->id }}').submit()">
                                    Cetak MAK 05
                                </button>
                                
                                <a class="btn btn-primary" href="{{ route('event.cetak.mak06', ['event' => encrypt($event->id)]) }}" target="_blank">Cetak MAK 06</a>
                            </div>
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th>NIM</th>
                                        <th>Nama</th>
                                        <th>Prodi</th>
                                        <th>Tgl. Uji</th>
                                        <th><button type="button" class="btn btn-success btn-sm" onclick="checkAll($(this))">Check/Uncheck</button></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($event->getUji()->orderBy('tanggal_uji')->get() as $uji)
                                        <tr>
                                            <td>{{ $uji->nim }}</td>
                                            <td>{{ $uji->getMahasiswa(false)->nama }}</td>
                                            <td>{{ $uji->getMahasiswa(false)->getProdi(false)->nama }}</td>
                                            <td>{{ (empty($uji->tanggal_uji)) ? 'Tanggal uji belum diatur' : formatDate($uji->tanggal_uji, true, false) }}</td>
                                            <td><input name="mahasiswa[]" value="{{ $uji->nim }}" type="checkbox"></td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        {{ $data->links() }}
    @endslot
    @endcard

    <form method="post" id="hapus">
        @csrf
        {{ method_field('delete') }}
    </form>
@endsection

@push('js')
    <script src="{{ asset('tempusdominus/moment-with-locales.min.js') }}"></script>
    <script src="{{ asset('tempusdominus/tempusdominus-bootstrap-4.js') }}"></script>
    <script>
        function checkAll(b) {
            event.preventDefault()
            b.parent().parent().parent().next().children().each(function () {
                cetak = $(this).children().eq(3).children().eq(0)
                cetak.prop('checked', !cetak.is(":checked"))
            })
        }
    </script>
    <script>
        $('.dt').datetimepicker({
            format: 'YYYY-MM-DD'
        })

        $('#tu-f').datetimepicker({
            format: 'YYYY-MM-DD HH:mm:ss',
            sideBySide: true
        })

        $('.select2').select2()

        function add() {
            event.preventDefault()
            $('#skema').val($('#skema-f').val())
            $('#dana').val($('#dana-f').val())
            $('#tmp').val($('#tmp-f').val())
            $('#tap').val($('#tap-f').val())
            $('#tu').val($('#tu-f').val())
            $('#event').submit()
        }

        function hapus(id) {
            event.preventDefault()
            swal({
                title: "Anda yakin ingin menghapus event ini?",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            }).then((choice) => {
                if (choice) {
                    swal('Sedang memuat. . .', {
                        buttons: false,
                        closeOnClickOutside: false
                    })
                    var form = $('#hapus');
                    form.attr('action', id)
                    form.submit()
                }
            })
        }

        setTimeout(function () {
            $('.select2').select2()
        }, 500)
    </script>
@endpush
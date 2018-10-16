@extends('layouts.carbon.app', [
    'sidebar' => true
])

@section('title', $menu->nama.' | '.kustomisasi('nama'))

@section('content')
    @include('layouts.include.alert')

    @card(['title' => 'Daftar kuesioner'])
    <form action="{{ url()->current() }}">
        <div class="row">
            <div class="col-5">
                <div class="form-group">
                    <label>Skema</label>
                    <select class="form-control select2" name="skema[]" id="skema-f" multiple>
                        @foreach($listSkema as $item)
                            @if(in_array($item->kode, $skema))
                                <option value="{{ $item->kode }}" selected>
                                    {{ $item->kode }} ({{ $item->nama }})
                                </option>
                            @else
                                <option value="{{ $item->kode }}">
                                    {{ $item->kode }} ({{ $item->nama }})
                                </option>
                            @endif
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-5">
                <div class="form-group">
                    <label>Cari berdasarkan Nama/NIM</label>
                    <input type="text" class="form-control" name="search" value="{{ $search }}">
                </div>
            </div>
            <div class="col-2">
                <div class="form-group">
                    <label>&nbsp;</label>
                    <br>
                    <button class="btn btn-primary">
                        <i class="icon"></i> Filter
                    </button>
                </div>
            </div>
        </div>
    </form>
    @slot('table')
        <table class="table table-striped">
            <thead>
            <tr>
                <th>No</th>
                <th>NIM</th>
                <th>Nama</th>
                <th>Skema</th>
                <th>Aksi</th>
            </tr>
            </thead>
            <tbody>
            @foreach($data as $kuesioner)
                <tr>
                    <td>{{ ($data->currentpage() * $data->perpage()) + (++$no) - $data->perpage()  }}</td>
                    <td>{{ $kuesioner->getMahasiswa(false)->nim }}</td>
                    <td>{{ $kuesioner->getMahasiswa(false)->nama }}</td>
                    <td>{{ $kuesioner->getSkema(false)->nama }}</td>
                    <td>
                        <div class="btn-group">
                            <button class="btn btn-info btn-sm"
                                    onclick="event.preventDefault(); $('#frame').attr('src', '{{ route('kuesioner.detail', ['event' => encrypt($kuesioner->id)]) }}'); $('#card-frame').show()">
                                <i class="icon icon-eye"></i> Preview
                            </button>
                            <a href="{{ route('kuesioner.print', ['event' => encrypt($kuesioner->id)]) }}"
                               class="btn btn-primary btn-sm text-white">
                                <i class="icon icon-printer"></i> Print
                            </a>
                        </div>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        {{ $data->links() }}
    @endslot
    @endcard

    <div class="card card-body text-center" style="display: none" id="card-frame">
        <iframe id="frame" style="height: 297mm; width:210mm; float: none; margin: 0 auto"></iframe>
    </div>
@endsection

@push('js')
    <script>
        $('.select2').select2()
        setTimeout(function () {
            $('.select2').select2()
        }, 500)
    </script>
@endpush
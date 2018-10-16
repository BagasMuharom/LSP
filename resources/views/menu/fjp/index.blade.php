@extends('layouts.carbon.app', [
    'sidebar' => true
])

@section('title', $menu->nama.' | '.kustomisasi('nama'))

@section('content')
    @include('layouts.include.alert')

    <form action="{{ route('fjp.sinkron') }}" method="post">
        @csrf
        <button class="btn btn-primary">Sinkron Fakultas, Jurusan dan Program Studi</button>
    </form>

    @row

    @col(['size' => 4])
    <div class="list-group">
        @foreach($listFakultas as $fakultas)
            <button type="button" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center" onclick="event.preventDefault(); klikFakultas({{ $fakultas->id }}); $(this).parent().children().removeClass('active'); $(this).addClass('active')">
                {{ $fakultas->nama }}
                <span class="badge badge-light badge-pill">
                    {{ $fakultas->getJurusan()->count() }} jurusan
                </span>
            </button>
        @endforeach
    </div>
    @endcol

    @col(['size' => 4])
    @foreach($listFakultas as $fakultas)
        <div class="list-group" style="display: none" id="fakultas-{{ $fakultas->id }}">
            @foreach($fakultas->getJurusan(false) as $jurusan)
                <button type="button" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center" onclick="event.preventDefault(); klikJurusan({{ $jurusan->id }}); $(this).parent().children().removeClass('active'); $(this).addClass('active')">
                    {{ $jurusan->nama }}
                    <span class="badge badge-light badge-pill">
                        {{ $jurusan->getProdi()->count() }} prodi
                    </span>
                </button>
            @endforeach
        </div>
    @endforeach
    @endcol

    @col(['size' => 4])
    @foreach($listFakultas as $fakultas)
        @foreach($fakultas->getJurusan(false) as $jurusan)
            <ul class="list-group" style="display: none" id="jurusan-{{ $jurusan->id }}">
                @foreach($jurusan->getProdi(false) as $prodi)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        {{ $prodi->nama }}
                        <span class="badge badge-primary badge-pill">
                            {{ $prodi->getSertifikat()->count() }} sertifikat
                        </span>
                    </li>
                @endforeach
            </ul>
        @endforeach
    @endforeach
    @endcol

    @endrow

    {{--<br>--}}
    {{----}}
    {{--<div class="card card-body">--}}
        {{--<ul>--}}
            {{--@foreach($listFakultas as $fakultas)--}}
                {{--<li>{{ $fakultas->nama }}</li>--}}
                {{--<ul>--}}
                {{--@foreach($fakultas->getJurusan(false) as $jurusan)--}}
                    {{--<li>{{ $jurusan->nama }}</li>--}}
                    {{--<ul>--}}
                    {{--@foreach($jurusan->getProdi(false) as $prodi)--}}
                        {{--<li>{{ $prodi->nama }}</li>--}}
                    {{--@endforeach--}}
                    {{--</ul>--}}
                {{--@endforeach--}}
                {{--</ul>--}}
            {{--@endforeach--}}
        {{--</ul>--}}
    {{--</div>--}}
@endsection

@push('js')
    <script>
        var fakultas = {{ $listFakultas->pluck('id') }}
        var jurusan = {{ $listJurusan->pluck('id') }}
        // var fakultas = []
        // var jurusan = []
        
        function klikFakultas(id){
            for (var f of fakultas){
                $('#fakultas-' + f).hide()
                $('#fakultas-' + f).children().removeClass('active')
            }

            for (var j of jurusan){
                $('#jurusan-' + j).hide()
            }

            $('#fakultas-' + id).show()
        }

        function klikJurusan(id) {
            for (var j of jurusan){
                $('#jurusan-' + j).hide()
            }

            $('#jurusan-' + id).show()
        }
    </script>
@endpush
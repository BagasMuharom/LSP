@extends('layouts.profile.app', [
    'fullwidth' => true
])

@section('title', kustomisasi('nama'))

@push('css')
    <link rel="stylesheet" href="{{ asset('css/carouseller.css') }}">
@endpush

@section('pre-main')
@include('layouts.profile.slider')
@endsection

@section('content')

<div id="home-profil" class="jumbotron" style="margin: 0 -15px 40px -15px">
    <div class="row margin-right-0 margin-left-0">
        <div class="col-lg-5 text-center margin-bottom-20">
            <img src="{{ asset(kustomisasi('logo')) }}" alt="Logo" style="width: 50%;margin: 0 auto">
        </div>
        <div class="col-lg-7">
            <h2>Tentang Kami</h2>
            <p>{{ kustomisasi('profil_singkat') }} ...</p>
            <a href="{{ route('profil.profil') }}" class="btn btn-primary">Baca Selengkapnya</a>
        </div>
    </div>
</div>

<div class="container">
    <!-- BEGIN SERVICE BOX -->
    <div class="row service-box margin-bottom-40">
        <div class="col-md-4 col-sm-4">
            <div class="service-box-heading">
                <em>
                    <i class="fa fa-location-arrow blue"></i>
                </em>
                <span>Mudah</span>
            </div>
            <p>Menawarkan kemudahan dengan pendaftaran sertifikasi secara online tanpa harus datang ke tempat.</p>
        </div>
        <div class="col-md-4 col-sm-4">
            <div class="service-box-heading">
                <em>
                    <i class="fa fa-check red"></i>
                </em>
                <span>Transparan</span>
            </div>
            <p>Status dari pendaftaran hingga proses penilaian dapat dilihat secara langsung melalui web.</p>
        </div>
        <div class="col-md-4 col-sm-4">
            <div class="service-box-heading">
                <em>
                    <i class="fa fa-compress green"></i>
                </em>
                <span>Terpercaya</span>
            </div>
            <p>LSP Unesa merupakan Lembaga terpercaya yang telah mendapat lisensi resmi dari BNSP.</p>
        </div>
    </div>
    <!-- END SERVICE BOX -->

    <!-- BEGIN BLOCKQUOTE BLOCK -->
    <div class="row quote-v1 margin-bottom-30">
        <div class="col-md-9">
            <span>Ingin memulai sertifikasi ?</span>
        </div>
        <div class="col-md-3 text-right mr-3">
            <a class="btn-transparent" href="{{ route('sertifikasi.daftar') }}" target="_blank">
                <i class="fa fa-rocket"></i>Daftar Sertifikasi Sekarang</a>
        </div>
    </div>
    <!-- END BLOCKQUOTE BLOCK -->
</div>

<div class="jumbotron" style="margin: 0 -15px 0 -15px">
    <h2 class="text-center margin-bottom-40">Berita Terbaru</h2>
    <div id="berita-terbaru" class="carouseller"> 
        <a href="javascript:void(0)" class="carouseller__left">‹</a> 
        <div class="carouseller__wrap"> 
            <div class="carouseller__list"> 
                @foreach ($daftarPost as $post)
                    <div class="car__4 home-post">
                        <img src="{{ asset($post->thumbnail) }}"/>
                        <a href="#"><h5>{{ $post->judul }}</h5></a>
                        <a href="#" class="btn btn-primary btn-sm">Baca Selengkapnya</a>
                    </div>
                @endforeach
            </div>
        </div>
        <a href="javascript:void(0)" class="carouseller__right">›</a>
    </div>
</div>

@endsection

@push('js')
    <script src="{{ asset('js/carouseller.min.js') }}"></script>
    <script type="text/javascript">
        $(function() {
            $('#berita-terbaru').carouseller({
                scrollSpeed: 200,
                autoScrollDelay: 2000,
                easing: 'linear'
            });

            setInterval(function () {
                $('#controls-right').click()
            }, 3500)
        });
    </script>
@endpush
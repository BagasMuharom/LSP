@extends('layouts.profile.app')

@section('title', 'Berita | '.kustomisasi('nama'))

@section('content')
<ul class="breadcrumb">
    <li>
        <a href="{{ url('/') }}">Beranda</a>
    </li>
    <li class="active">Berita</li>
</ul>
<!-- BEGIN SIDEBAR & CONTENT -->
<div class="row margin-bottom-40">
    <!-- BEGIN CONTENT -->
    <div class="col-md-12 col-sm-12">
        <h1>Berita</h1>
        <div class="content-page">
            @if(request()->has('q'))
                <p class="alert alert-info">
                    Menampilkan hasil pencarian untuk {{ request('q') }}
                </p>
            @endif
            <div class="row">
                <!-- BEGIN LEFT SIDEBAR -->
                <div class="col-md-9 col-sm-9 blog-posts">
                    @foreach ($daftarPost as $post)
                    <div class="row">
                        <div class="col-md-4 col-sm-4">
                            <img class="img-responsive" src="{{ $post->thumbnail }}">
                        </div>
                        <div class="col-md-8 col-sm-8">
                            <h2>
                                <a href="{{ route('profil.post', ['permalink' => $post->permalink]) }}">{{ $post->judul }}</a>
                            </h2>
                            <ul class="blog-info">
                                <li>
                                    <i class="fa fa-calendar"></i>{{ formatDate($post->created_at) }}
                                </li>
                            </ul>
                            <p>{{ $post->summary }}...</p>
                            <a href="{{ route('profil.post', ['permalink' => $post->permalink]) }}" class="more">Baca Selengkapnya
                                <i class="icon-angle-right"></i>
                            </a>
                        </div>
                    </div>
                    <hr class="blog-post-sep">
                    @endforeach

                    {{ $daftarPost->links() }}

                </div>
                <!-- END LEFT SIDEBAR -->

                <!-- BEGIN RIGHT SIDEBAR -->
                <div class="col-md-3 col-sm-3 blog-sidebar">

                    <!-- BEGIN RECENT NEWS -->
                    <h2>Berita Terbaru</h2>
                    <div class="recent-news margin-bottom-10">
                        @foreach (getBeritaTerbaru() as $berita)
                        <div class="row margin-bottom-10">
                            <div class="col-md-3">
                                <img class="img-responsive" alt="" src="{{ asset($berita->thumbnail) }}">
                            </div>
                            <div class="col-md-9 recent-news-inner">
                                <h3>
                                    <a href="javascript:;">{{ $berita->judul }}</a>
                                </h3>
                                <p>{{ $berita->brief }}</p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <!-- END RECENT NEWS -->

                </div>
                <!-- END RIGHT SIDEBAR -->
            </div>
        </div>
    </div>
    <!-- END CONTENT -->
</div>
<!-- END SIDEBAR & CONTENT -->
@endsection
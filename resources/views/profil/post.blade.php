@extends('layouts.profile.app') 

@section('title', $post->judul.' | '.kustomisasi('nama'))

@section('content')

<ul class="breadcrumb">
    <li>
        <a href="{{ route('profil.home') }}">Home</a>
    </li>
    <li>
        <a href="{{ route('profil.berita') }}">Berita</a>
    </li>
    <li class="active">{{ $post->judul }}</li>
</ul>
<!-- BEGIN SIDEBAR & CONTENT -->
<div class="row margin-bottom-40">
    <!-- BEGIN CONTENT -->
    <div class="col-md-12 col-sm-12">
        <h1>{{ $post->judul }}</h1>
        <div class="content-page">
            <div class="row">
                <!-- BEGIN LEFT SIDEBAR -->
                <div class="col-md-9 col-sm-9 blog-item">
                    
                    {!! $post->isi !!}

                    <ul class="blog-info">
                        <li>
                            <i class="fa fa-user"></i> By admin</li>
                        <li>
                            <i class="fa fa-calendar"></i> {{ formatDate($post->created_at) }}</li>
                        <li>
                            <i class="fa fa-eye"></i> {{ $post->dilihat }}</li>
                    </ul>
                    
                </div>
                <!-- END LEFT SIDEBAR -->

                <!-- BEGIN RIGHT SIDEBAR -->
                <div class="col-md-3 col-sm-3 blog-sidebar">

                    <!-- BEGIN RECENT NEWS -->
                    <h2>Berita terbaru</h2>
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

                    <!-- BEGIN BLOG PHOTOS STREAM -->
                    {{-- <div class="blog-photo-stream margin-bottom-20">
                        <h2>Photos Stream</h2>
                        <ul class="list-unstyled">
                            <li>
                                <a href="javascript:;">
                                    <img alt="" src="assets/pages/img/people/img5-small.jpg">
                                </a>
                            </li>
                            <li>
                                <a href="javascript:;">
                                    <img alt="" src="assets/pages/img/works/img1.jpg">
                                </a>
                            </li>
                            <li>
                                <a href="javascript:;">
                                    <img alt="" src="assets/pages/img/people/img4-large.jpg">
                                </a>
                            </li>
                            <li>
                                <a href="javascript:;">
                                    <img alt="" src="assets/pages/img/works/img6.jpg">
                                </a>
                            </li>
                            <li>
                                <a href="javascript:;">
                                    <img alt="" src="assets/pages/img/pics/img1-large.jpg">
                                </a>
                            </li>
                            <li>
                                <a href="javascript:;">
                                    <img alt="" src="assets/pages/img/pics/img2-large.jpg">
                                </a>
                            </li>
                            <li>
                                <a href="javascript:;">
                                    <img alt="" src="assets/pages/img/works/img3.jpg">
                                </a>
                            </li>
                            <li>
                                <a href="javascript:;">
                                    <img alt="" src="assets/pages/img/people/img2-large.jpg">
                                </a>
                            </li>
                        </ul>
                    </div> --}}
                    <!-- END BLOG PHOTOS STREAM -->

                </div>
                <!-- END RIGHT SIDEBAR -->
            </div>
        </div>
    </div>
    <!-- END CONTENT -->
</div>
<!-- END SIDEBAR & CONTENT -->

@endsection
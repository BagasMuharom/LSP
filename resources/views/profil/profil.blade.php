@extends('layouts.profile.app')

@section('title', 'Profil | '.kustomisasi('nama'))

@section('content')
    <ul class="breadcrumb">
        <li>
            <a href="{{ url('/') }}">Beranda</a>
        </li>
        <li class="active">Profil</li>
    </ul>
    <!-- BEGIN SIDEBAR & CONTENT -->
    <div class="row margin-bottom-40">
        <!-- BEGIN CONTENT -->
        <div class="col-md-12 col-sm-12">
            <h1>Profil</h1>
            <div class="content-page">
                <div class="row margin-bottom-30">
                    <!-- BEGIN INFO BLOCK -->
                    <div class="col-md-12">
                        {!! kustomisasi('profil') !!}
                    </div>
                    <!-- END INFO BLOCK -->

                    <!-- BEGIN CAROUSEL -->
                {{-- <div class="col-md-5 front-carousel">
                    <div id="myCarousel" class="carousel slide">
                        <!-- Carousel items -->
                        <div class="carousel-inner">
                            <div class="item active">
                                <img src="assets/pages/img/pics/img2-medium.jpg" alt="">
                                <div class="carousel-caption">
                                    <p>Excepturi sint occaecati cupiditate non provident</p>
                                </div>
                            </div>
                            <div class="item">
                                <img src="assets/pages/img/pics/img1-medium.jpg" alt="">
                                <div class="carousel-caption">
                                    <p>Ducimus qui blanditiis praesentium voluptatum</p>
                                </div>
                            </div>
                            <div class="item">
                                <img src="assets/pages/img/pics/img2-medium.jpg" alt="">
                                <div class="carousel-caption">
                                    <p>Ut non libero consectetur adipiscing elit magna</p>
                                </div>
                            </div>
                        </div>
                        <!-- Carousel nav -->
                        <a class="carousel-control left" href="#myCarousel" data-slide="prev">
                            <i class="fa fa-angle-left"></i>
                        </a>
                        <a class="carousel-control right" href="#myCarousel" data-slide="next">
                            <i class="fa fa-angle-right"></i>
                        </a>
                    </div>
                </div> --}}
                <!-- END CAROUSEL -->
                </div>

                <div class="row margin-bottom-40">
                    <!-- BEGIN TESTIMONIALS -->
                    <div class="col-md-12 testimonials-v1">
                        @row
                        @col(['size' => 6])
                        <h2>Visi</h2>
                        <blockquote>
                            <b>{{ kustomisasi('visi') }}</b>
                        </blockquote>

                        <h2>Sasaran Mutu</h2>
                        <blockquote>
                            <ol type="a">
                                @php $ascii = 67 @endphp
                                @foreach(explode(PHP_EOL, kustomisasi('sasaran_mutu')) as $sm)
                                    <b><li>{{ $sm }}</li></b>
                                @endforeach
                            </ol>
                        </blockquote>
                        @endcol
                        @col(['size' => 6])
                        <h2>Misi</h2>
                        <blockquote>
                            <ol type="a">
                                @foreach(explode(PHP_EOL, kustomisasi('misi')) as $m)
                                    <b><li>{{ $m }}</li></b>
                                @endforeach
                            </ol>
                        </blockquote>
                        @endcol
                        @endrow
                    </div>
                    <!-- END TESTIMONIALS -->
                </div>

                <div class="row margin-bottom-30">
                    <div class="col-lg-12">
                        <h2>Struktur Organisasi</h2>
                        <img src="{{ asset(kustomisasi('susunan_organisasi')) }}" alt="Struktur Organisasi"/>
                    </div>
                </div>

            </div>
        </div>
        <!-- END CONTENT -->
    </div>
    <!-- END SIDEBAR & CONTENT -->
@endsection
@extends('layouts.profile.app')

@section('title', 'Kontak | '.kustomisasi('nama'))

@section('content')
<h1>Kontak Kami</h1>
<ul class="breadcrumb">
    <li>
        <a href="{{ url('/') }}">Beranda</a>
    </li>
    <li class="active">Kontak</li>
</ul>

<div class="row margin-bottom-40">
    <div class="col-lg-4">
        <img style="width: 70%;margin 0 auto" src="{{ asset(kustomisasi('logo')) }}" alt="Logo">
        <hr>
        <p>{{ kustomisasi('alamat') }}</p>
        <p>{{ kustomisasi('no_telepon') }}</p>
        <p>{{ kustomisasi('email') }}</p>
    </div>
    <div class="col-lg-8">
            <script src='https://maps.googleapis.com/maps/api/js?v=3.exp'></script><div style='overflow:hidden;width:100%'><div id='gmap_canvas' style='height:440px;width:700px;'></div><style>#gmap_canvas img{max-width:none!important;background:none!important}</style></div><script type='text/javascript'>function init_map(){var myOptions = {zoom:21,center:new google.maps.LatLng(-7.3172086,112.72578309999994),mapTypeId: google.maps.MapTypeId.ROADMAP};map = new google.maps.Map(document.getElementById('gmap_canvas'), myOptions);marker = new google.maps.Marker({map: map,position: new google.maps.LatLng(-7.3172086,112.72578309999994)});infowindow = new google.maps.InfoWindow({content:'<strong>LSP UNESA</strong><br>LSP UNESA<br>'});google.maps.event.addListener(marker, 'click', function(){infowindow.open(map,marker);});infowindow.open(map,marker);}google.maps.event.addDomListener(window, 'load', init_map);</script>
    </div>
</div>
@endsection
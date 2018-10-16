@extends('layouts.profile.app')

@section('title', 'Event | '.kustomisasi('nama'))

@section('content')
    <ul class="breadcrumb">
        <li>
            <a href="{{ url('/') }}">Beranda</a>
        </li>
        <li class="active">Event</li>
    </ul>

    <h1>Daftar Event</h1>

    <div class="row">
        <div class="col-lg-6">
            <div class="alert alert-warning">Event yang sedang berlangsung</div>
            <table class="table">
                <tbody>
                @foreach($onGoing as $event)
                    <tr style="background-color: #3bd3dd">
                        <td>Skema</td>
                        <td>:</td>
                        <td>{{ $event->getSkema(false)->kode }} ({{ $event->getSkema(false)->nama ?? '-' }})</td>
                    </tr>
                    <tr>
                        <td>Dana</td>
                        <td class="text-center">:</td>
                        <td>{{ $event->getDana(false)->nama }} ({{ $event->getDana(false)->keterangan }})</td>
                    </tr>
                    <tr>
                        <td>Tgl. mulai pendaftaran</td>
                        <td>:</td>
                        <td>{{ formatDate($event->tgl_mulai_pendaftaran, true, true) }}</td>
                    </tr>
                    <tr>
                        <td>Tgl. akhir pendaftaran</td>
                        <td>:</td>
                        <td>{{ formatDate($event->tgl_akhir_pendaftaran, true, true) }}</td>
                    </tr>
                    <tr>
                        <td>Tgl. uji</td>
                        <td>:</td>
                        <td>{{ formatDate($event->tgl_uji, true, true) }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <div class="col-lg-6">
            <div class="alert alert-info">Event yang akan datang</div>
            <table class="table">
                <tbody>
                @foreach($comingSoon as $event)
                    <tr style="background-color: #37cbdd">
                        <td>Skema</td>
                        <td>:</td>
                        <td>{{ $event->getSkema(false)->kode }} ({{ $event->getSkema(false)->nama ?? '-' }})</td>
                    </tr>
                    <tr>
                        <td>Dana</td>
                        <td class="text-center">:</td>
                        <td>{{ $event->getDana(false)->nama }} ({{ $event->getDana(false)->keterangan }})</td>
                    </tr>
                    <tr>
                        <td>Tgl. mulai pendaftaran</td>
                        <td>:</td>
                        <td>{{ formatDate($event->tgl_mulai_pendaftaran, true, true) }}</td>
                    </tr>
                    <tr>
                        <td>Tgl. akhir pendaftaran</td>
                        <td>:</td>
                        <td>{{ formatDate($event->tgl_akhir_pendaftaran, true, true) }}</td>
                    </tr>
                    <tr>
                        <td>Tgl. uji</td>
                        <td>:</td>
                        <td>{{ formatDate($event->tgl_uji, true, true) }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
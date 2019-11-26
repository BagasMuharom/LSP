<html>
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8"/>
    <style>
        * {
            box-sizing: border-box;
        }

        table {
            border-collapse: collapse;
            page-break-after: avoid;
            /* border-spacing: 0; */
        }

        .page-break {
            page-break-after: always;
        }

        .full {
            width: 100%;
        }

        .bold {
            font-weight: bold;
        }

        .text-center {
            text-align: center;
        }

        .text-left {
            text-align: left;
        }

        .text-blue {
            /* color: #0070c0; */
        }

        .text-justify {
            text-align: justify;
        }

        h3, td, ol, th, p {
            font-family: Calibri;
        }

        .unicode {
            font-family: DejaVu Sans;
        }

        th, td {
            padding: 5px;
            /* border: 1px solid #000; */
        }

        .f14 {
            font-size: 14pt;
        }

        .f12 {
            font-size: 12pt;
        }

        .f11 {
            font-size: 11pt;
        }

        .f10 {
            font-size: 10pt;
        }

        .f9 {
            font-size: 9pt;
        }

        .back-color-grey {
            background-color: #d9d9d9;
        }

        .header {
            position: fixed;
        }

        /*@page {*/
            /*!* margin-top: 1cm;*/
            /*margin-left: 1.54cm;*/
            /*margin-right: 1.54cm;*/
            /*margin-bottom: 1cm; *!*/
            /*margin: 1.54cm;*/
            /*size: A4;*/
        /*}*/

        body {
            /*width:297mm;*/
            /*!*height:210mm;*!*/
            /*!* to centre page on screen*!*/
            /*margin-left: auto;*/
            /*margin-right: auto;*/
        }

        .img-responsive {
            max-width: 100%;
            height: auto;
        }

        .bl {
            border-left: 1px solid #000;
        }

        .br {
            border-right: 1px solid #000;
        }

        .bt {
            border-top: 1px solid #000;
        }

        .bb {
            border-bottom: 1px solid #000;
        }

        .border {
            border: 1px solid #000;
        }

        .v-bottom {
            vertical-align: bottom;
        }

        .v-top {
            vertical-align: top;
        }

        .v-center {
            vertical-align: center;
        }
    </style>
</head>
<body>

<table class="full">
    <tr>
        <th width="20%" class="text-left">
            <img src="{{ asset('img/bnsp.jpg') }}" width="85px">
        </th>
        <th width="65%" class="text-center bl bb bt br v-center">
            <div style="font-size: 17px"><b>BERITA ACARA<br>ASESMEN KOMPETENSI</b></div>
        </th>
        <th width="15%"></th>
    </tr>
    <tr>
        <th></th>
        <th class="text-center">
            <br>
            <div style="font-size: 17px"><b>DAFTAR HADIR</b></div>
        </th>
        <th></th>
    </tr>
</table>

<table>
    <tr>
        <td>Hari/Tanggal</td>
        <td>:</td>
        <td>{{ formatDate($uji[0]->tanggal_uji, true, false, ' / ') }}</td>
    </tr>
    <tr>
        <td>Tempat</td>
        <td>:</td>
        <td>{{ $event->getTempatUji(false)->nama }} Gedung {{ $event->getTempatUji(false)->kode }} Fakultas {{ $event->getSkema(false)->getJurusan(false)->getFakultas(false)->nama }} UNESA</td>
    </tr>
</table>

<br>

<table class="full" border="1">
    <thead>
    <tr>
        <th class="text-center" width="5%">No.</th>
        <th class="text-center" width="15%">Nama Peserta</th>
        <th class="text-center" width="20%">Jurusan/prodi</th>
        <th class="text-center" width="15%">Alamat asesi</th>
        <th class="text-center" width="15%">Tempat Tanggal Lahir</th>
        <th class="text-center" width="15%">No. Telp/HP</th>
        <th class="text-center" width="15%">Tanda Tangan</th>
    </tr>
    </thead>
    <tbody>
    @foreach($uji as $u)
        <tr>
            <td class="text-center">{{ $no++ }}.</td>
            <td>{{ $u->getMahasiswa(false)->nama }}</td>
            <td>{{ $u->getMahasiswa(false)->getJurusan(false)->nama }}/{{ $u->getMahasiswa(false)->getProdi(false)->nama }}</td>
            <td>{{ $u->getMahasiswa(false)->alamat }}</td>
            <td>
                {{ $u->getMahasiswa(false)->tempat_lahir }}
                <br>
                {{ formatDate($u->getMahasiswa(false)->tgl_lahir, true, false) }}
            </td>
            <td>
                {{ $u->getMahasiswa(false)->no_telepon }}
            </td>
            <td class="v-top">
                {{--@if($no % 2 == 0)--}}
                    {{--{{ $no++ }}.--}}
                {{--@else--}}
                    {{--<div style="margin-left: 45%">{{ $no++ }}.</div>--}}
                {{--@endif--}}
                <img src="{{ $u->ttd_peserta }}" width="150px">
            </td>
        </tr>
    @endforeach
    </tbody>
</table>

</body>
</html>
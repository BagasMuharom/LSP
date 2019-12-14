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
            /*height:297mm;*/
            /*width:210mm;*/
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
</table>

<p class="text-justify">
    Pada hari ini, Hari/Tanggal : {{ formatDate($uji[0]->tanggal_uji, true, false, '/') }} Waktu
    : {{ $event->tgl_uji->toTimeString() }}-16:00 bertempat di: TUK {{ $event->getTempatUji(false)->nama }} Fakultas {{ $event->getSkema(false)->getJurusan(false)->getFakultas(false)->nama }} UNESA, telah dilaksanakan proses asesmen <b>terhadap peserta asesmen</b> sebagai berikut:
</p>

<table class="full">
    <tr>
        <td class="v-top" width="40%">Sektor/sub sektor/bidang profesi</td>
        <td class="text-center v-top" width="2%">:</td>
        <td class="v-top" width="58%">{{ $event->getSkema(false)->sektor }}</td>
    </tr>
    <tr>
        <td class="v-top">Jumlah Asesi/Peserta yang mengikuti</td>
        <td class="text-center v-top">:</td>
        <td class="v-top">{{ $uji->count() }} ({{ numberToWord($uji->count()) }}) orang</td>
    </tr>
    <tr>
        <td class="v-top">Jumlah Asesi/Peserta yang dinyatakan <br><b>Kompeten</b></td>
        <td class="text-center v-top">:</td>
        <td class="v-top">{{ $ujiLulus->count() }} ({{ numberToWord($ujiLulus->count()) }}) orang</td>
    </tr>
    <tr>
        <td class="v-top">Jumlah Asesi/Peserta yang dinyatakan <br><b>Belum Kompeten</b></td>
        <td class="text-center v-top">:</td>
        <td class="v-top">{{ $ujiTidakLulus->count() }} ({{ numberToWord($ujiTidakLulus->count()) }}) orang</td>
    </tr>
    <tr>
        <td colspan="3">dengan rician data sebagai berikut :</td>
    </tr>
</table>

<table class="full" border="1">
    <thead>
    <tr>
        <th width="5%" class="text-center">No.</th>
        <th width="37%" class="text-center">Nama Asesi/Peserta</th>
        <th width="13%" class="text-center">Hasil Asesmen*)</th>
        <th width="28%" class="text-center">Rekomendasi/Tindak Lanjut</th>
        <th width="17%" class="text-center">Keterangan</th>
    </tr>
    </thead>
    <tbody>
    @foreach($uji as $u)
        <tr>
            <td class="text-center">{{ $no++ }}</td>
            <td>{{ $u->getMahasiswa(false)->nama }}</td>
            <td class="text-center">{{ $u->isLulus() ? 'K' : 'BK' }}</td>
            <td>{{ $u->isLulus() ? 'Mohon dapat diterbitkan Sertifikat Kompetensi' : 'Diperlukan asesmen ulang' }}</td>
            <td></td>
        </tr>
    @endforeach
    </tbody>
</table>
<small>Keterangan : *) Diisi dengan <b>K</b> (Kompeten) atau <b>BK</b> (Belum Kompeten)</small>

<p>Demikian berita acara ini dibuat dengan sebenarnya, untuk digunakan sebagaimana mestinya</p>

<p>Surabaya, {{ formatDate($event->tgl_uji, false, false) }}</p>

@php
    $ketua = true;
    $no = 0;
    $asesors = $uji->first()->getAsesorUji(false);
@endphp

<table class="full">
    <tr>
        <td>Asesor Kompetensi :</td>
        <td></td>
        <td>Penanggungjawab kegiatan :</td>
    </tr>
    @for($c = 0; $c < ((int)($asesors->count() / 2)); $c++)
        <tr>
            <td>
                @if(!empty($asesors[$no]))
                    <br>
                    Nama : {{ $asesors[$no]->nama }}
                    <br><br>
                    No. Reg : {{ $asesors[$no]->nip }}
                    <br>
                    Tanda tangan :
                    <br>
                    @if($asesors[$no]->getTTD(false)->count() > 0)
                        <img src="{{ $asesors[$no++]->getTTD(false)->random()->ttd }}" width="200">
                    @else
                        <br><br><br><br><br>
                        @php $no++ @endphp
                    @endif
                @endif
            </td>
            <td>
                @if(!empty($asesors[$no]))
                    <br>
                    Nama : {{ $asesors[$no]->nama }}
                    <br><br>
                    No. Reg : {{ $asesors[$no]->nip }}
                    <br>
                    Tanda tangan :
                    <br>
                    @if($asesors[$no]->getTTD(false)->count() > 0)
                        <img src="{{ $asesors[$no++]->getTTD(false)->random()->ttd }}" width="200">
                    @else
                        <br><br><br><br><br>
                        @php $no++ @endphp
                    @endif
                @endif
            </td>
            <td>
                @if($ketua)
                    <br>
                    Nama : {{ $ketuaLsp->nama }}
                    <br><br>
                    Jabatan : Ketua LSP
                    <br>
                    Tanda tangan :
                    @if($ketuaLsp->getTTD(false)->count() > 0)
                        <img src="{{ $ketuaLsp->getTTD(false)->random()->ttd }}" width="200">
                    @else
                        <br><br><br><br><br>
                    @endif
                    @php $ketua = false @endphp
                @endif
            </td>
        </tr>
    @endfor
</table>

</body>
</html>
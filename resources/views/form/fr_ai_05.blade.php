<!doctype html>
<html lang="en">
<head>
    <style>
        .border tr td {
            border: 1px solid black;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
        }

        .bg-hijau {
            background-color: rgb(231, 241, 162);
        }

        .unicode {
            font-family: DejaVu Sans;
        }

        .center {
            text-align: center
        }

        html {
            font-size: 0.8em !important;
        }
    </style>
</head>
<body>
<h3><b>FR.AI.05.Formulir bukti pihak ketiga</b></h3>

<table class="table border">
    <tr>
        <td class="bg-hijau">Nama Asesi</td>
        <td>{{ $uji->getMahasiswa(false)->nama }}</td>
    </tr>
    <tr>
        <td class="bg-hijau">LSP</td>
        <td>{{ kustomisasi('nama') }}</td>
    </tr>
    <tr>
        <td class="bg-hijau">Skema</td>
        <td>{{ $uji->getSkema(false)->kode.' '.$uji->getSkema(false)->nama }}</td>
    </tr>
    <tr>
        <td class="bg-hijau">Unit Kompetensi</td>
        <td>{{ $data->unit }}</td>
    </tr>
</table>

<table class="table">
    <tr>
        <td>
            <small>
                Sebagai bagian dari asesmen untuk unit kompetensi, kami mencari bukti untuk mendukung asesmen tentang
                kompetensi asesi.
                <br>
                Sebagai bagian dari bukti kompetensi, kami mencari laporan dari penyelia dan orang lain yang bekerja sama
                dengan asesi.
            </small>
        </td>
    </tr>
</table>
<table class="table border">
    <tr>
        <td>Nama Pengawas : {{ $data->pengawas }}</td>
    </tr>
    <tr>
        <td>Tempat Kerja : {{ $data->tempat_kerja }}</td>
    </tr>
    <tr>
        <td>Alamat : {{ $data->alamat }}</td>
    </tr>
    <tr>
        <td>Telepon : {{ $data->telepon }}</td>
    </tr>
</table>
<br>
<table style="width: 100%">
    <tr>
        <td>-</td>
        <td>Apakah Anda memahami bukti / tugas yang telah disediakan / dilakukan kandidat yang harus Anda komentari?</td>
        <td>Yes</td>
        <td class="unicode" style="border: 1px solid black">
            @if($data->memahami_bukti == 'Ya') &#10003; @endif
        </td>
        <td>No</td>
        <td class="unicode" style="border: 1px solid black">
            @if($data->memahami_bukti == 'Tidak') &#10003; @endif
        </td>
    </tr>
    <tr>
        <td>-</td>
        <td>Sudahkah asesor menjelaskan tujuan dari asesmenasesi?</td>
        <td>Yes</td>
        <td class="unicode" style="border: 1px solid black">
            @if($data->tujuan_asesmen == 'Ya') &#10003; @endif
        </td>
        <td>No</td>
        <td class="unicode" style="border: 1px solid black">
            @if($data->tujuan_asesmen == 'Tidak') &#10003; @endif
        </td>
    </tr>
    <tr>
        <td>-</td>
        <td>Apakah Anda tahu bahwa asesi akan melihat salinan formulir?</td>
        <td>Yes</td>
        <td class="unicode" style="border: 1px solid black">
            @if($data->melihat_salinan == 'Ya') &#10003; @endif
        </td>
        <td>No</td>
        <td class="unicode" style="border: 1px solid black">
            @if($data->melihat_salinan == 'Tidak') &#10003; @endif
        </td>
    </tr>
    <tr>
        <td>-</td>
        <td>Apakah Anda bersedia dihubungi jika verifikasi lebih lanjut dari pernyataan ini diperlukan?</td>
        <td>Yes</td>
        <td class="unicode" style="border: 1px solid black">
            @if($data->verifikasi_lanjut == 'Ya') &#10003; @endif
        </td>
        <td>No</td>
        <td class="unicode" style="border: 1px solid black">
            @if($data->verifikasi_lanjut == 'Tidak') &#10003; @endif
        </td>
    </tr>
</table>
<br>
<table class="table border">
    <tr>
        <td width="30%" class="bg-hijau">Apa hubungan Anda dengan asesi?</td>
        <td>{{ $data->hubungan }}</td>
    </tr>
    <tr>
        <td class="bg-hijau">Berapa lama Anda bekerja dengan asesi?</td>
        <td>{{ $data->lama_bekerja_dengan_asesi }}</td>
    </tr>
    <tr>
        <td class="bg-hijau">Seberapa dekat Anda bekerja dengan asesi di area yang dinilai?</td>
        <td>{{ $data->kedekatan_dengan_asesi }}</td>
    </tr>
    <tr>
        <td class="bg-hijau">Apa pengalaman teknis dan / atau kualifikasi Anda di bidang yang dinilai? (termasuk asesmen atau kualifikasi pelatihan)</td>
        <td>{{ $data->pengalaman_teknis }}</td>
    </tr>
</table>
<br>
<table style="width: 100%">
    <tr>
        <td rowspan="7" style="vertical-align: text-top">Apakah asesi</td>
        <td>-</td>
        <td>melakukan tugas pekerjaan sesuai standar industri?</td>
        <td>Yes</td>
        <td class="unicode" style="border: 1px solid black">
            @if($data->sesuai_standar == 'Ya') &#10003; @endif
        </td>
        <td>No</td>
        <td class="unicode" style="border: 1px solid black">
            @if($data->sesuai_standar == 'Tidak') &#10003; @endif
        </td>
    </tr>
    <tr>
        <td>-</td>
        <td>mengelola tugas pekerjaan secara efektif?</td>
        <td>Yes</td>
        <td class="unicode" style="border: 1px solid black">
            @if($data->efektif == 'Ya') &#10003; @endif
        </td>
        <td>No</td>
        <td class="unicode" style="border: 1px solid black">
            @if($data->efektif == 'Tidak') &#10003; @endif
        </td>
    </tr>
    <tr>
        <td>-</td>
        <td>menerapkan praktik kerja yang aman?</td>
        <td>Yes</td>
        <td class="unicode" style="border: 1px solid black">
            @if($data->praktik_kerja_aman == 'Ya') &#10003; @endif
        </td>
        <td>No</td>
        <td class="unicode" style="border: 1px solid black">
            @if($data->praktik_kerja_aman == 'Tidak') &#10003; @endif
        </td>
    </tr>
    <tr>
        <td>-</td>
        <td>menyelesaikan masalah di tempat kerja?</td>
        <td>Yes</td>
        <td class="unicode" style="border: 1px solid black">
            @if($data->menyelesaikan_masalah == 'Ya') &#10003; @endif
        </td>
        <td>No</td>
        <td class="unicode" style="border: 1px solid black">
            @if($data->menyelesaikan_masalah == 'Tidak') &#10003; @endif
        </td>
    </tr>
    <tr>
        <td>-</td>
        <td>bekerja dengan baik dengan yang lain?</td>
        <td>Yes</td>
        <td class="unicode" style="border: 1px solid black">
            @if($data->bekerja_baik == 'Ya') &#10003; @endif
        </td>
        <td>No</td>
        <td class="unicode" style="border: 1px solid black">
            @if($data->bekerja_baik == 'Tidak') &#10003; @endif
        </td>
    </tr>
    <tr>
        <td>-</td>
        <td>beradaptasi dengan tugas baru?</td>
        <td>Yes</td>
        <td class="unicode" style="border: 1px solid black">
            @if($data->beradaptasi == 'Ya') &#10003; @endif
        </td>
        <td>No</td>
        <td class="unicode" style="border: 1px solid black">
            @if($data->beradaptasi == 'Tidak') &#10003; @endif
        </td>
    </tr>
    <tr>
        <td>-</td>
        <td>mengatasi situasi yang tidak biasa atau tidak rutin?</td>
        <td>Yes</td>
        <td class="unicode" style="border: 1px solid black">
            @if($data->mengatasi_situasi == 'Ya') &#10003; @endif
        </td>
        <td>No</td>
        <td class="unicode" style="border: 1px solid black">
            @if($data->mengatasi_situasi == 'Tidak') &#10003; @endif
        </td>
    </tr>
</table>
<br>
<table class="table border">
    <tr>
        <td>Secara keseluruhan, apakah Anda yakin asesi melakukan sesuai standar yang diminta oleh unit kompetensi secara konsisten?</td>
        <td>{{ $data->konsisten }}</td>
    </tr>
    <tr>
        <td colspan="2">Identifikasi kebutuhan pelatihan lebih lanjut untuk asesi:<br>{{ $data->identifikasi_kebutuhan }}</td>
    </tr>
    <tr>
        <td colspan="2">Ada komentar lain:<br>{{ $data->komentar }}</td>
    </tr>
    <tr>
        <td width="60%" style="border-right: 0px">
            Tanda tangan pengawas:<br>
            <div class="center">
                <img width="200" src="{{ $data->ttd }}">
            </div>
        </td>
        <td  style="border-left: 0px; vertical-align: text-top">
            Tanggal:<br>
            {{ $data->tanggal }}
        </td>
    </tr>
</table>
<i>Diadopsi dari templat yang disediakan di Departemen Pendidikan dan Pelatihan, Australia. Merancang alat asesmen untuk hasil yang berkualitas di VET. 2008</i>
</body>
</html>
<html>

<head>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }

        table, th, td {
            border: 2px solid black;
        }
    </style>
</head>

<body>
<h3><b>FR-APL-02 ASESMEN MANDIRI</b></h3>
<table>
    <tr>
        <td>Nama Asesi:</td>
        <td></td>
    </tr>
    <tr>
        <td>Nama Asesor:</td>
        <td></td>
    </tr>
    <tr>
        <td>Tempat kerja:</td>
        <td></td>
    </tr>
    <tr>
        <td>Nomor dan Judul Skema:</td>
        <td></td>
    </tr>
    <tr>
        <td>Jenis Portofolio:</td>
        <td></td>
    </tr>
</table>
<br>
<table>
    <tr>
        <td>Nomor dan Judul Unit Kompetensi:</td>
        <td></td>
    </tr>
</table>
<table>
    <tr>
        <td rowspan="2">Dokumen portofolio menunjukkan kepatuhan terhadap aturan bukti:</td>
        <td colspan="2">Valid</td>
        <td colspan="2">Memadai</td>
        <td colspan="2">Asli</td>
        <td colspan="2">Terkini</td>
    </tr>
    <tr>
        <td>Ya</td>
        <td>Tidak</td>

        <td>Ya</td>
        <td>Tidak</td>

        <td>Ya</td>
        <td>Tidak</td>

        <td>Ya</td>
        <td>Tidak</td>
    </tr>
    @foreach([1,2,3,4,5,6,7,8] as $c)
        <tr>
            <td>{{ $c }}</td>

            <td>&#10003;</td>
            <td>&#10003;</td>

            <td>&#10003;</td>
            <td>&#10003;</td>

            <td>&#10003;</td>
            <td>&#10003;</td>

            <td>&#10003;</td>
            <td>&#10003;</td>
        </tr>
    @endforeach
</table>
<br>
<table>
    <tr>
        <td>
            Sebagai tindak lanjut dari hasil verifikasi bukti, substansi materi di bawah ini harus diklarifikasi selama wawancara:
        </td>
    </tr>
</table>
<br>
<table>
    <tr>
        <td colspan="2">Bukti tambahan diperlukan pada unit / elemen kompetensi sebagai berikut:</td>
    </tr>
    <tr>
        <td>Tanda Tangan Asesi:</td>
        <td></td>
    </tr>
    <tr>
        <td>Tanda Tangan Asesor:</td>
        <td></td>
    </tr>
</table>
</body>

</html>
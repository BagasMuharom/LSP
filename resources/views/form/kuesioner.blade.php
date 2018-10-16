<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Kuesioner</title>
    <style>
        td {
            padding: 5px;
            vertical-align: text-top
        }
        ol {
            list-style-type: lower-alpha;
            padding: 0;
            margin: 0;
            margin-left: 20px;
        }
        h3 {
            margin: 0
        }
    </style>
</head>
<body>
    <header>
        <table>
            <tr>
                <td >
                    <img src="{{ asset(kustomisasi('logo')) }}" width="50"/>
                </td>
                <td>
                    <h3>KUESIONER - PEMEGANG SERTIFIKAT KOMPETENSI <br> LSP UNESA</h3>
                </td>
            </tr>
        </table>
    </header>

    <hr>

    <table>
        <tr>
            <td>1.</td>
            <td>Nama Pemegang Sertifikat Kompetensi</td>
            <td>:</td>
            <td>{{ $mahasiswa->nama }}</td>
        </tr>

        <tr>
            <td>2.</td>
            <td>Skema Kompetensi</td>
            <td>:</td>
            <td>{{ $skema->nama }}</td>
        </tr>

        <tr>
            <td>3.</td>
            <td>Berlakunya Sertifikat</td>
            <td>:</td>
            <td>{{ formatDate(Carbon\Carbon::parse($sertifikat->issue_date), false, false) }} sampai {{ formatDate(Carbon\Carbon::parse($sertifikat->expire_date), false, false) }}</td>
        </tr>

        <tr>
            <td>4.</td>
            <td>Alamat Tempat Tinggal</td>
            <td>:</td>
            <td>
                <b>Alamat : </b> {{ $mahasiswa->alamat }} <br>
                <b>Kota/Kabupaten : </b> {{ $mahasiswa->kabupaten }} <br>
                <b>Provinsi : </b> {{ $mahasiswa->provinsi }}
            </td>
        </tr>

        <tr>
            <td>5.</td>
            <td>Nomor HP</td>
            <td>:</td>
            <td>{{ $mahasiswa->no_telepon }}</td>
        </tr>

        <tr>
            <td>6.</td>
            <td>Alamat Email</td>
            <td>:</td>
            <td>{{ $mahasiswa->email }}</td>
        </tr>

        <tr>
            <td>7.</td>
            <td>Kegiatan Setelah Mendapat Sertifikasi</td>
            <td>:</td>
            <td>{{ str_replace(':', ' di bidang ', $kuesioner->kegiatan_setelah_mendapatkan_sertifikasi) }}</td>
        </tr>

        {{-- @if($kuesioner->kegiatan_setelah_mendapatkan_sertifikasi == 'Bekerja') --}}

        <tr>
            <td>8.</td>
            <td>Nama Perusahaan</td>
            <td>:</td>
            <td>{{ $kuesioner->nama_perusahaan ?? '-' }}</td>
        </tr>
        
        <tr>
            <td>9.</td>
            <td>Alamat Perusahaan</td>
            <td>:</td>
            <td>{{ $kuesioner->alamat_perusahaan ?? '-' }}</td>
        </tr>
        
        <tr>
            <td>10.</td>
            <td>Jenis Perusahaan</td>
            <td>:</td>
            <td>{{ $kuesioner->jenis_perusahaan ?? '-' }}</td>
        </tr>
        
        <tr>
            <td>11.</td>
            <td>Tahun Memulai Kerja</td>
            <td>:</td>
            <td>{{ $kuesioner->tahun_memulai_kerja ?? '-' }}</td>
        </tr>
        
        <tr>
            <td>12.</td>
            <td>Relevansi Sertifikasi Kompetensi dengan Bidang Pekerjaan</td>
            <td>:</td>
            <td>{{ $kuesioner->relevansi_sertifikasi_kompetensi_bidang_dengan_pekerjaan ?? '-' }}</td>
        </tr>

        <tr>
            <td>13.</td>
            <td>Manfaat Sertifikasi</td>
            <td>:</td>
            <td>
                <ol>
                    <li>Dapat Membedakan Jenis Bidang Pekerjaan (<b>{{ json_decode($kuesioner->manfaat_sertifikasi_kompetensi)->mempermudah_mencari_pekerjaan }}</b>)</li>
                    <li>Dapat Mempermudah Mencari Pekerjaan (<b>{{ json_decode($kuesioner->manfaat_sertifikasi_kompetensi)->membedakan_jenis_pekerjaan }}</b>)</li>
                    <li>Dapat Menaikkan Gaji/Penghasilan (<b>{{ json_decode($kuesioner->manfaat_sertifikasi_kompetensi)->menaikkan_gaji }}</b>)</li>
                </ol>
            </td>
        </tr>

        <tr>
            <td>14.</td>
            <td>Saran Perbaikan Untuk {{ kustomisasi('nama') }}</td>
            <td>:</td>
            <td>
                {{ $kuesioner->saran_perbaikan_untuk_lsp_unesa }}
            </td>
        </tr>

    </table>
</body>
</html>
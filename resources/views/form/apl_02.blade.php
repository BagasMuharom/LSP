<html>

<head>
    <title>Form Asesmen Diri</title>
    @include('form.layouts.style')
    <style>

        section {
            page-break-after: always;
        }

        table {
            border-collapse: collapse
        }

        td {
            padding: 5px;
        }

        .full {
            width: 100%;
        }

        footer .page-number:after { content: counter(page); }

        ol {
            padding: 0;
            margin-left: 20px;
            margin-top: 0;
        }

        .mt-3 {
            margin-top: 1rem;
        }

        .unicode {
            font-family: DejaVu Sans;
        }

        .bg-blue {
            background-color: rgb(198, 217, 241);
        }

        th {
            font-weight: normal;
            padding: 3px;
        }
    </style>
</head>

<body>
    <h4>FR-APL-02  ASESMEN MANDIRI</h4>
    <table border="1" class="full">
        <tr>
            <td rowspan="2">Skema Sertifikasi/ Klaster Asesmen</td>
            <td>Judul</td>
            <td width="5%">:</td>
            <td width="60%">{{ $skema->nama }}</td>
        </tr>
        <tr>
            <td>Nomor</td>
            <td>:</td>
            <td>{{ $skema->kode }}</td>
        </tr>
        <tr>
            <td colspan="2">TUK</td>
            <td>:</td>
            <td>Sewaktu/Tempat Kerja/Mandiri*</td>
        </tr>
        <tr>
            <td colspan="2">Nama Asesor</td>
            <td>:</td>
            <td>
                <ol style="margin: 0;padding-left: 20px;">
                    @foreach($uji->getAsesorUji(false) as $asesor)
                    <li>{{ $asesor->nama }}</li>
                    @endforeach
                </ol>
            </td>
        </tr>
        <tr>
            <td colspan="2">Nama Peserta</td>
            <td>:</td>
            <td>{{ $mahasiswa->nama }}</td>
        </tr>
        <tr>
            <td colspan="2">Tanggal</td>
            <td>:</td>
            <td></td>
        </tr>
    </table>
    <i style="font-size: 9pt">* Coret yang tidak perlu</i>
    <br><br>
    <b>
        Peserta diminta untuk : <br>
        <ol>
        <li>Mempelajari Kriteria Unjuk Kerja  (KUK), Batasan Variabel, Panduan Penilaian, dan Aspek Kritis seluruh Unit Kompetensi yang diminta untuk di Ases.</li>
        <li>Melaksanakan Penilaian Mandiri secara obyektif atas sejumlah pertanyaan yang diajukan, bilamana Anda menilai diri sudah kompeten atas pertanyaan tersebut, tuliskan tanda <b class="unicode">&#10003;</b> pada kolom (K), dan bilamana Anda menilai diri belum kompeten tuliskan tanda <b class="unicode">&#10003;</b> pada kolom (BK).</li>
        <li>Mengisi bukti-bukti kompetensi yang relevan atas sejumlah pertanyaan yang dinyatakan Kompeten (bila ada).</li>
        <li>Menandatangani form Asesmen Mandiri.</li>
        </ol>
    </b>

    @foreach($skema->getSkemaUnit(false) as $unit)
        <section>
            <table border="1" class="full">
                <tr>
                    <td rowspan="2" width="25%">Unit Kompetensi No. {{ $loop->iteration }}</td>
                    <td width="15%">Kode Unit</td>
                    <td width="1%">:</td>
                    <td>{{ $unit->kode }}</td>
                </tr>
                <tr>
                    <td>Judul Unit</td>
                    <td>:</td>
                    <td>{{ $unit->nama }}</td>
                </tr>
            </table>

            @foreach ($unit->getElemenKompetensi(false) as $elemen)
            <div style="page-break-inside: avoid">
                <table border="1" class="full mt-3">
                    <tr>
                        <td>Elemen Kompetensi</td>
                        <td>:</td>
                        <td>{{ $loop->iteration }}. {{ $elemen->nama }}</td>
                    </tr>
                </table>
                
                <table border="1" class="full" style="margin-top: -2px;page-break-inside: avoid;">
                    <tr style="text-align: center">
                        <th class="bg-blue" rowspan="2" width="10%">Nomor KUK</th>
                        <th class="bg-blue" rowspan="2" width="40%">Daftar Pertanyaan </th>
                        <th class="bg-blue" colspan="2" width="10%">Penilaian</th>
                        <th class="bg-blue" rowspan="2" width="20%">Bukti-bukti Pendukung</th>
                        <th class="bg-blue" colspan="4" width="20%">Diisi Asesor</th>
                    </tr>
                    <tr style="text-align: center">
                        <th class="bg-blue">K</th>
                        <th class="bg-blue">BK</th>
                        <th class="bg-blue">V</th>
                        <th class="bg-blue">A</th>
                        <th class="bg-blue">T</th>
                        <th class="bg-blue">M</th>
                    </tr>
                </table>

                <table border="1" class="full" style="margin-top: -2px">
                    @foreach ($elemen->getKriteria(false) as $kriteria)
                    @php $asesmendiri = $uji->getPenilaianDiri()->where('id', $kriteria->id)->first() @endphp
                    <tr style="text-align: center">
                        <td width="10%">{{ $loop->iteration }}</td>
                        <td style="text-align: left" width="40%">{{ $kriteria->pertanyaan }}</td>
                        <td width="5%">
                            <b class="unicode">{!! $asesmendiri->pivot->nilai == \App\Support\Penilaian::KOMPETEN ? '&#10003;' : '' !!}</b>
                        </td>
                        <td width="5%">
                            <b class="unicode">{!! $asesmendiri->pivot->nilai == \App\Support\Penilaian::BELUM_KOMPETEN ? '&#10003;' : '' !!}</b>
                        </td>
                        <td width="20%">
                            {{ $asesmendiri->pivot->bukti }}
                        </td>
                        <td width="5%">
                            <b class="unicode">{!! $asesmendiri->pivot->v ? '&#10003;' : '' !!}</b>
                        </td>
                        <td width="5%">
                            <b class="unicode">{!! $asesmendiri->pivot->a ? '&#10003;' : '' !!}</b>
                        </td>
                        <td width="5%">
                            <b class="unicode">{!! $asesmendiri->pivot->t ? '&#10003;' : '' !!}</b>
                        </td>
                        <td width="5%">
                            <b class="unicode">{!! $asesmendiri->pivot->m ? '&#10003;' : '' !!}</b>
                        </td>
                    </tr>
                    @endforeach
                </table>
            </div>
            @endforeach
        </section>
    @endforeach

    <section>
        <table border="1" class="full">
            <tr>
                <td rowspan="3" width="50%" class="top bold">
                    Rekomendasi Asesor : <br>
                    1. {{ $uji->rekomendasi_asesor_asesmen_diri }} <br>
                    2. Proses Asesmen dilanjutkan melalui : <br>
                    &nbsp;&nbsp;&nbsp;&nbsp;<b style="border: 1px solid #000;" class="unicode">{!! $uji->proses_asesmen == 'Asesmen Portofolio' ? '&#10003;' : '' !!}</b> Asesmen Portofolio <br/>
                    &nbsp;&nbsp;&nbsp;&nbsp;<b style="border: 1px solid #000;" class="unicode">{!! $uji->proses_asesmen == 'Uji Kompetensi' ? '&#10003;' : '&nbsp;&nbsp;' !!}</b> Uji Kompetensi
                </td>
                <td colspan="2" class="bold center">Peserta</td>
            </tr>
            <tr>
                <td>Nama</td>
                <td>{{ $mahasiswa->nama }}</td>
            </tr>
            <tr>
                <td>Tanda tangan/<br>Tanggal</td>
                <td>
                    @if($uji->getMahasiswa(false)->getTTD(false)->count() > 0)
                        <img width="200" src="{{ $uji->getMahasiswa(false)->getTTD(false)->random()->ttd }}" class="img-responsive">
                    @endif
                </td>
            </tr>
            
            {{-- Tanda tangan asesor --}}
            <tr>
                <td rowspan="{{ $uji->getAsesorUji()->count() * 4 }}" class="top bold">Catatan : </td>
                <td colspan="2" class="center bold">Asesor I</td>
            </tr>
            @foreach ($uji->getAsesorUji(false) as $asesor)
            @if($loop->index > 0)
            <tr>
                <td colspan="2" class="center bold">Asesor {{ numberToRoman($loop->iteration) }}</td>
            </tr>
            @endif
            <tr>
                <td>Nama</td>
                <td>{{ $asesor->nama }}</td>
            </tr>
            <tr>
                <td>No. Reg.</td>
                <td>{{ $asesor->nip }}</td>
            </tr>
            <tr>
                <td>Tanda tangan/<br>Tanggal</td>
                <td>
                    @if($asesor->getTTD(false)->count() > 0)
                        <img width="200" src="{{ $asesor->getTTD(false)->random()->ttd }}">
                    @endif
                </td>
            </tr>
            @endforeach
        </table>
    </section>
</body>

</html>
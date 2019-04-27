<html>
    <head>
        <title>MPA 02</title>
        @include('form.layouts.style')
    </head>
    <body>
        <h1 class="fs-14">FR-MPA-02.2.  CEKLIS OBSERVASI-DEMONSTRASI/PRAKTEK</h1>

        <table class="table-full table-pd-5 table-border" border="1">
            <tbody>
                <tr>
                    <td rowspan="2">Skema Sertifikasi/ Klaster Asesmen</td>
                    <td>Judul</td>
                    <td>:</td>
                    <td>{{ $skema->nama }}</td>
                </tr>
                <tr>
                    <td>Nomor</td>
                    <td>:</td>
                    <td></td>
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
                            @foreach ($uji->getAsesorUji(false) as $asesor)
                                <li>{{ $asesor->nama }}</li>
                            @endforeach
                        </ol>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">Nama Peserta</td>
                    <td>:</td>
                    <td>{{ $uji->getMahasiswa(false)->nama }}</td>
                </tr>
                <tr>
                    <td colspan="2">Tanggal</td>
                    <td>:</td>
                    <td></td>
                </tr>
            </tbody>
        </table>

        <span class="fs-11">* coret yang dianggap tidak perlu</span>

        @foreach ($skema->getSkemaUnit(false) as $unit)
            <table style="margin:10px 0" class="table-full table-border table-pd-5" border="1">
                <tbody>
                    <tr>
                        <td rowspan="2">Unit Kompetensi No. {{ $loop->iteration }}</td>
                        <td>Kode Unit</td>
                        <td>:</td>
                        <td>{{ $unit->kode }}</td>
                    </tr>
                    <tr>
                        <td>Judul Unit</td>
                        <td>:</td>
                        <td>{{ $unit->nama }}</td>
                    </tr>
                </tbody>
            </table>

            <table style="page-break-after: always" class="table-full table-border table-pd-5" border="1">
                <tbody>
                    <tr class="text-bold">
                        <td rowspan="2">No.</td>
                        <td rowspan="2">Langkah Kerja</td>
                        <td rowspan="2">Poin yang diobservasi</td>
                        <td colspan="2">Pencapaian</td>
                        <td colspan="2">Penilaian</td>
                    </tr>
                    <tr class="text-bold">
                        <td>Ya</td>
                        <td>Tidak</td>
                        <td>K</td>
                        <td>BK</td>
                    </tr>

                    @foreach ($unit->getElemenKompetensi(false) as $elemen)
                        <tr style="border-width: 1px">
                            <td class="bb-hide">{{ $loop->iteration }}</td>
                            <td class="bb-hide">{{ $elemen->nama }}</td>
                            <td>{{ $elemen->getKriteria()->first() }}</td>
                            <td>
                                @if ($uji->getPenilaian()->where('id', $elemen->getKriteria()->first()->id)->first()->pivot->nilai == App\Support\Penilaian::KOMPETEN)
                                    <b class="unicode">&#10003;</b>
                                @endif
                            </td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        @foreach ($elemen->getKriteria()->afterFirst(false) as $kriteria)
                            @php
                                $penilaian = $uji->getPenilaian()->where('id', $kriteria->id)->first();
                            @endphp
                            <tr>
                                <td class="bt-hide bb-hide"></td>
                                <td class="bt-hide bb-hide"></td>
                                <td>{{ $kriteria->unjuk_kerja }}</td>
                                <td>
                                    @if ($penilaian->pivot->nilai == App\Support\Penilaian::KOMPETEN)
                                    <b class="unicode">&#10003;</b>
                                    @endif
                                </td>
                                <td>
                                    @if ($penilaian->pivot->nilai == App\Support\Penilaian::BELUM_KOMPETEN)
                                    <b class="unicode">&#10003;</b>
                                    @endif
                                </td>
                                <td></td>
                                <td></td>
                            </tr>
                        @endforeach
                    @endforeach
                </tbody>
            </table>
        @endforeach

        <table class="table-full table-pd-5 table-border" border="1">
            <tr>
                <td width="50%" rowspan="{{ (($uji->getAsesorUji()->count() * 2) + 5) }}">
                    <b>Rekomendasi Asesor :</b><br>
                    {{ $uji->rekomendasi_asesor }}
                </td>
                <td colspan="2">Asesor :</td>
            </tr>
            @foreach($uji->getAsesorUji(false) as $asesor)
                <tr>
                    <td>Nama</td>
                    <td>{{ $asesor->nama }}</td>
                </tr>
                <tr>
                    <td>Tanda Tangan & Tanggal</td>
                    <td class="text-center">
                        <img width="200" src="{{ $asesor->pivot->ttd }}" class="img-responsive">
                        <br>
                        {{-- {{ formatDate($uji->updated_at) }} --}}
                    </td>
                </tr>
            @endforeach
            <tr>
                <td colspan="2" class="bold">Peserta</td>
            </tr>
            <tr>
                <td>Nama</td>
                <td>{{ $uji->getMahasiswa(false)->nama }}</td>
            </tr>
            <tr>
                <td>No. Reg.</td>
                <td>{{ $uji->nim }}</td>
            </tr>
            <tr>
                <td>Tanda Tangan & Tanggal</td>
                <td class="text-center">
                    <img width="200" src="{{ $uji->ttd_peserta }}" class="img-responsive">
                    <br>
                    {{-- {{ formatDate($uji->updated_at) }} --}}
                </td>
            </tr>
        </table>
    </body>
</html>
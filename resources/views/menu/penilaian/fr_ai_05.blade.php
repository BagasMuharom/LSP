@extends('layouts.carbon.app', [
    'sidebar' => true
])

@section('title', 'Penilaian | '.kustomisasi('nama'))

@section('content')
    @include('layouts.include.alert')

    <div class="card card-body">
        <h3><b>FR.AI.05.Formulir bukti pihak ketiga</b></h3>

        <table class="table table-bordered">
            <tr>
                <td>Nama Asesi</td>
                <td>{{ $uji->getMahasiswa(false)->nama }}</td>
            </tr>
            <tr>
                <td>LSP</td>
                <td>{{ kustomisasi('nama') }}</td>
            </tr>
            <tr>
                <td>Skema</td>
                <td>{{ $uji->getSkema(false)->kode.' '.$uji->getSkema(false)->nama }}</td>
            </tr>
        </table>

        <form id="form" action="{{ route('penilaian.eval.fr-ai-05', ['uji' => encrypt($uji->id)]) }}" method="post">
            @csrf
            <script src="{{ asset('js/signature_pad.min.js') }}"></script>
            @for($c = 0; $c < $n_form; $c++)
                <div class="card card-body">
                    <select class="form-control" name="unit[]" required>
                        @foreach($uji->getSkema(false)->getSkemaUnit(false) as $unit)
                            <option @if($unit->id == $form['unit'][$c]) selected @endif value="{{ $unit->id }}">{{ $unit->kode.' '.$unit->nama }}</option>
                        @endforeach
                    </select>
                    Sebagai bagian dari asesmen untuk unit kompetensi, kami mencari bukti untuk mendukung asesmen tentang
                    kompetensi asesi.
                    <br>
                    Sebagai bagian dari bukti kompetensi, kami mencari laporan dari penyelia dan orang lain yang bekerja sama
                    dengan asesi.
                    <table class="table table-bordered">
                        <tr>
                            <td>Nama Pengawas</td>
                            <td><input type="text" class="form-control" name="pengawas[]" required value="{{ $form['pengawas'][$c] }}"></td>
                        </tr>
                        <tr>
                            <td>Tempat Kerja</td>
                            <td><input type="text" class="form-control" name="tempat_kerja[]" required value="{{ $form['tempat_kerja'][$c] }}"></td>
                        </tr>
                        <tr>
                            <td>Alamat</td>
                            <td><input type="text" class="form-control" name="alamat[]" required value="{{ $form['alamat'][$c] }}"></td>
                        </tr>
                        <tr>
                            <td>Telepon</td>
                            <td><input type="text" class="form-control" name="telepon[]" required value="{{ $form['telepon'][$c] }}"></td>
                        </tr>
                    </table>
                    <br>
                    <table class="table">
                        <tr>
                            <td>-</td>
                            <td>Apakah Anda memahami bukti / tugas yang telah disediakan / dilakukan kandidat yang harus Anda
                                komentari?
                            </td>
                            <td>
                                <select class="form-control" name="memahami_bukti[]" required>
                                    <option value="{{ $form['memahami_bukti'][$c] }}">{{ $form['memahami_bukti'][$c] }}</option>
                                    <option value="Ya">Ya</option>
                                    <option value="Tidak">Tidak</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>-</td>
                            <td>Sudahkah asesor menjelaskan tujuan dari asesmenasesi?</td>
                            <td>
                                <select class="form-control" name="tujuan_asesmen[]" required>
                                    <option value="{{ $form['tujuan_asesmen'][$c] }}">{{ $form['tujuan_asesmen'][$c] }}</option>
                                    <option value="Ya">Ya</option>
                                    <option value="Tidak">Tidak</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>-</td>
                            <td>Apakah Anda tahu bahwa asesi akan melihat salinan formulir?</td>
                            <td>
                                <select class="form-control" name="melihat_salinan[]" required>
                                    <option value="{{ $form['tujuan_asesmen'][$c] }}">{{ $form['tujuan_asesmen'][$c] }}</option>
                                    <option value="Ya">Ya</option>
                                    <option value="Tidak">Tidak</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>-</td>
                            <td>Apakah Anda bersedia dihubungi jika verifikasi lebih lanjut dari pernyataan ini diperlukan?</td>
                            <td>
                                <select class="form-control" name="verifikasi_lanjut[]" required>
                                    <option value="{{ $form['verifikasi_lanjut'][$c] }}">{{ $form['verifikasi_lanjut'][$c] }}</option>
                                    <option value="Ya">Ya</option>
                                    <option value="Tidak">Tidak</option>
                                </select>
                            </td>
                        </tr>
                    </table>
                    <br>
                    <table class="table table-bordered">
                        <tr>
                            <td>Apa hubungan Anda dengan asesi?</td>
                            <td><input type="text" class="form-control" name="hubungan[]" required value="{{ $form['hubungan'][$c] }}"></td>
                        </tr>
                        <tr>
                            <td>Berapa lama Anda bekerja dengan asesi?</td>
                            <td><input type="text" class="form-control" name="lama_bekerja_dengan_asesi[]" required value="{{ $form['lama_bekerja_dengan_asesi'][$c] }}"></td>
                        </tr>
                        <tr>
                            <td>Seberapa dekat Anda bekerja dengan asesi di area yang dinilai?</td>
                            <td><input type="text" class="form-control" name="kedekatan_dengan_asesi[]" required value="{{ $form['kedekatan_dengan_asesi'][$c] }}"></td>
                        </tr>
                        <tr>
                            <td>Apa pengalaman teknis dan / atau kualifikasi Anda di bidang yang dinilai? (termasuk asesmen atau
                                kualifikasi pelatihan)
                            </td>
                            <td><input type="text" class="form-control" name="pengalaman_teknis[]" required value="{{ $form['pengalaman_teknis'][$c] }}"></td>
                        </tr>
                    </table>
                    <br>
                    <table class="table">
                        <tr>
                            <td rowspan="7">Apakah asesi</td>
                            <td>-</td>
                            <td>melakukan tugas pekerjaan sesuai standar industri?</td>
                            <td>
                                <select class="form-control" name="sesuai_standar[]" required>
                                    <option value="{{ $form['sesuai_standar'][$c] }}">{{ $form['sesuai_standar'][$c] }}</option>
                                    <option value="Ya">Ya</option>
                                    <option value="Tidak">Tidak</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>-</td>
                            <td>mengelola tugas pekerjaan secara efektif?</td>
                            <td>
                                <select class="form-control" name="efektif[]" required>
                                    <option value="{{ $form['efektif'][$c] }}">{{ $form['efektif'][$c] }}</option>
                                    <option value="Ya">Ya</option>
                                    <option value="Tidak">Tidak</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>-</td>
                            <td>menerapkan praktik kerja yang aman?</td>
                            <td>
                                <select class="form-control" name="praktik_kerja_aman[]" required>
                                    <option value="{{ $form['praktik_kerja_aman'][$c] }}">{{ $form['praktik_kerja_aman'][$c] }}</option>
                                    <option value="Ya">Ya</option>
                                    <option value="Tidak">Tidak</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>-</td>
                            <td>menyelesaikan masalah di tempat kerja?</td>
                            <td>
                                <select class="form-control" name="menyelesaikan_masalah[]" required>
                                    <option value="{{ $form['menyelesaikan_masalah'][$c] }}">{{ $form['menyelesaikan_masalah'][$c] }}</option>
                                    <option value="Ya">Ya</option>
                                    <option value="Tidak">Tidak</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>-</td>
                            <td>bekerja dengan baik dengan yang lain?</td>
                            <td>
                                <select class="form-control" name="bekerja_baik[]" required>
                                    <option value="{{ $form['bekerja_baik'][$c] }}">{{ $form['bekerja_baik'][$c] }}</option>
                                    <option value="Ya">Ya</option>
                                    <option value="Tidak">Tidak</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>-</td>
                            <td>beradaptasi dengan tugas baru?</td>
                            <td>
                                <select class="form-control" name="beradaptasi[]" required>
                                    <option value="{{ $form['beradaptasi'][$c] }}">{{ $form['beradaptasi'][$c] }}</option>
                                    <option value="Ya">Ya</option>
                                    <option value="Tidak">Tidak</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>-</td>
                            <td>mengatasi situasi yang tidak biasa atau tidak rutin?</td>
                            <td>
                                <select class="form-control" name="mengatasi_situasi[]" required>
                                    <option value="{{ $form['mengatasi_situasi'][$c] }}">{{ $form['mengatasi_situasi'][$c] }}</option>
                                    <option value="Ya">Ya</option>
                                    <option value="Tidak">Tidak</option>
                                </select>
                            </td>
                        </tr>
                    </table>
                    <br>
                    <table class="table table-bordered">
                        <tr>
                            <td>Secara keseluruhan, apakah Anda yakin asesi melakukan sesuai standar yang diminta oleh unit
                                kompetensi secara konsisten?
                            </td>
                            <td><input type="text" class="form-control" name="konsisten[]" required value="{{ $form['konsisten'][$c] }}"></td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                Identifikasi kebutuhan pelatihan lebih lanjut untuk asesi
                                <textarea class="form-control" name="identifikasi_kebutuhan[]">{{ $form['identifikasi_kebutuhan'][$c] }}</textarea>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                Ada komentar lain
                                <textarea class="form-control" name="komentar[]">{{ $form['komentar'][$c] }}</textarea>
                            </td>
                        </tr>
                        <tr>
                            <td width="40%">
                                Tanda tangan pengawas
                                <br>
                                <table style="border-collapse: collapse">
                                    <tr>
                                        <td style="border: 1px solid black; padding: 0px">
                                            <canvas width="300" height="150" id="tambah-ttd-{{ $c }}" class="signature-pad" style="border: 1px"></canvas>
                                        </td>
                                    </tr>
                                </table>
                                <br>
                                <button type="button" onclick="tambah_ttd_sp_{{ $c }}.clear()" class="btn btn-primary">Reset</button>
                                <script>
                                    let tambah_tdd_{{ $c }} = document.getElementById('tambah-ttd-{{ $c }}')
                                    tambah_ttd_sp_{{ $c }} = new SignaturePad(tambah_tdd_{{ $c }}, {
                                        backgroundColor: 'rgba(255, 255, 255, 0)',
                                        penColor: 'rgb(0, 0, 0)'
                                    })
                                    tambah_ttd_sp_{{ $c }}.fromDataURL("{{ $form['ttd'][$c] }}")
                                </script>
                            </td>
                            <td>
                                Tanggal
                                <textarea class="form-control" name="tanggal[]">{{ $form['tanggal'][$c] }}</textarea>
                            </td>
                        </tr>
                    </table>
                    <button class="btn btn-danger" onclick="if (confirm('Apakah anda yakin?')) { $(this).parent().remove() }">Hapus form</button>
                </div>
            @endfor
        </form>
        <div class="btn-group">
            <button class="btn btn-success" id="simpan">Simpan</button>
            <button class="btn btn-primary" id="tambah-form">Tambah Form Pihak Krtiga</button>
        </div>
        <br>
        <i>Diadopsi dari templat yang disediakan di Departemen Pendidikan dan Pelatihan, Australia. Merancang alat
            asesmen untuk hasil yang berkualitas di VET. 2008</i>
    </div>

    <div id="pihak-ketiga" style="display: none">
        <div class="card card-body">
            <select class="form-control" name="unit[]" required>
                @foreach($uji->getSkema(false)->getSkemaUnit(false) as $unit)
                    <option value="{{ $unit->id }}">{{ $unit->kode.' '.$unit->nama }}</option>
                @endforeach
            </select>
            Sebagai bagian dari asesmen untuk unit kompetensi, kami mencari bukti untuk mendukung asesmen tentang
            kompetensi asesi.
            <br>
            Sebagai bagian dari bukti kompetensi, kami mencari laporan dari penyelia dan orang lain yang bekerja sama
            dengan asesi.
            <table class="table table-bordered">
                <tr>
                    <td>Nama Pengawas</td>
                    <td><input type="text" class="form-control" name="pengawas[]" required></td>
                </tr>
                <tr>
                    <td>Tempat Kerja</td>
                    <td><input type="text" class="form-control" name="tempat_kerja[]" required></td>
                </tr>
                <tr>
                    <td>Alamat</td>
                    <td><input type="text" class="form-control" name="alamat[]" required></td>
                </tr>
                <tr>
                    <td>Telepon</td>
                    <td><input type="text" class="form-control" name="telepon[]" required></td>
                </tr>
            </table>
            <br>
            <table class="table">
                <tr>
                    <td>-</td>
                    <td>Apakah Anda memahami bukti / tugas yang telah disediakan / dilakukan kandidat yang harus Anda
                        komentari?
                    </td>
                    <td>
                        <select class="form-control" name="memahami_bukti[]" required>
                            <option value="Ya">Ya</option>
                            <option value="Tidak">Tidak</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>-</td>
                    <td>Sudahkah asesor menjelaskan tujuan dari asesmenasesi?</td>
                    <td>
                        <select class="form-control" name="tujuan_asesmen[]" required>
                            <option value="Ya">Ya</option>
                            <option value="Tidak">Tidak</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>-</td>
                    <td>Apakah Anda tahu bahwa asesi akan melihat salinan formulir?</td>
                    <td>
                        <select class="form-control" name="melihat_salinan[]" required>
                            <option value="Ya">Ya</option>
                            <option value="Tidak">Tidak</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>-</td>
                    <td>Apakah Anda bersedia dihubungi jika verifikasi lebih lanjut dari pernyataan ini diperlukan?</td>
                    <td>
                        <select class="form-control" name="verifikasi_lanjut[]" required>
                            <option value="Ya">Ya</option>
                            <option value="Tidak">Tidak</option>
                        </select>
                    </td>
                </tr>
            </table>
            <br>
            <table class="table table-bordered">
                <tr>
                    <td>Apa hubungan Anda dengan asesi?</td>
                    <td><input type="text" class="form-control" name="hubungan[]" required></td>
                </tr>
                <tr>
                    <td>Berapa lama Anda bekerja dengan asesi?</td>
                    <td><input type="text" class="form-control" name="lama_bekerja_dengan_asesi[]" required></td>
                </tr>
                <tr>
                    <td>Seberapa dekat Anda bekerja dengan asesi di area yang dinilai?</td>
                    <td><input type="text" class="form-control" name="kedekatan_dengan_asesi[]" required></td>
                </tr>
                <tr>
                    <td>Apa pengalaman teknis dan / atau kualifikasi Anda di bidang yang dinilai? (termasuk asesmen atau
                        kualifikasi pelatihan)
                    </td>
                    <td><input type="text" class="form-control" name="pengalaman_teknis[]" required></td>
                </tr>
            </table>
            <br>
            <table class="table">
                <tr>
                    <td rowspan="7">Apakah asesi</td>
                    <td>-</td>
                    <td>melakukan tugas pekerjaan sesuai standar industri?</td>
                    <td>
                        <select class="form-control" name="sesuai_standar[]" required>
                            <option value="Ya">Ya</option>
                            <option value="Tidak">Tidak</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>-</td>
                    <td>mengelola tugas pekerjaan secara efektif?</td>
                    <td>
                        <select class="form-control" name="efektif[]" required>
                            <option value="Ya">Ya</option>
                            <option value="Tidak">Tidak</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>-</td>
                    <td>menerapkan praktik kerja yang aman?</td>
                    <td>
                        <select class="form-control" name="praktik_kerja_aman[]" required>
                            <option value="Ya">Ya</option>
                            <option value="Tidak">Tidak</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>-</td>
                    <td>menyelesaikan masalah di tempat kerja?</td>
                    <td>
                        <select class="form-control" name="menyelesaikan_masalah[]" required>
                            <option value="Ya">Ya</option>
                            <option value="Tidak">Tidak</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>-</td>
                    <td>bekerja dengan baik dengan yang lain?</td>
                    <td>
                        <select class="form-control" name="bekerja_baik[]" required>
                            <option value="Ya">Ya</option>
                            <option value="Tidak">Tidak</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>-</td>
                    <td>beradaptasi dengan tugas baru?</td>
                    <td>
                        <select class="form-control" name="beradaptasi[]" required>
                            <option value="Ya">Ya</option>
                            <option value="Tidak">Tidak</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>-</td>
                    <td>mengatasi situasi yang tidak biasa atau tidak rutin?</td>
                    <td>
                        <select class="form-control" name="mengatasi_situasi[]" required>
                            <option value="Ya">Ya</option>
                            <option value="Tidak">Tidak</option>
                        </select>
                    </td>
                </tr>
            </table>
            <br>
            <table class="table table-bordered">
                <tr>
                    <td>Secara keseluruhan, apakah Anda yakin asesi melakukan sesuai standar yang diminta oleh unit
                        kompetensi secara konsisten?
                    </td>
                    <td><input type="text" class="form-control" name="konsisten[]" required></td>
                </tr>
                <tr>
                    <td colspan="2">
                        Identifikasi kebutuhan pelatihan lebih lanjut untuk asesi
                        <textarea class="form-control" name="identifikasi_kebutuhan[]"></textarea>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        Ada komentar lain
                        <textarea class="form-control" name="komentar[]"></textarea>
                    </td>
                </tr>
                <tr>
                    <td width="40%">
                        Tanda tangan pengawas
                        <br>
                        <table style="border-collapse: collapse">
                            <tr>
                                <td style="border: 1px solid black; padding: 0px">
                                    <canvas width="300" height="150" id="tambah-ttd-#" class="signature-pad" style="border: 1px"></canvas>
                                </td>
                            </tr>
                        </table>
                        <br>
                        <button type="button" onclick="tambah_ttd_sp_#.clear()" class="btn btn-primary">Reset</button>
                        <script>
                            let tambah_tdd_# = document.getElementById('tambah-ttd-#')
                            tambah_ttd_sp_# = new SignaturePad(tambah_tdd_#, {
                                backgroundColor: 'rgba(255, 255, 255, 0)',
                                penColor: 'rgb(0, 0, 0)'
                            })
                        </script>
                    </td>
                    <td>
                        Tanggal
                        <textarea class="form-control" name="tanggal[]">{{ formatDate(carbon(), false, false) }}</textarea>
                    </td>
                </tr>
            </table>
            <button class="btn btn-danger" onclick="if (confirm('Apakah anda yakin?')) { $(this).parent().remove() }">Hapus form</button>
        </div>
    </div>

    <div id="ttd-simpan" style="display: none">
        <textarea style="display: none" name="ttd[]" id="ttd-C"></textarea>
        <script>
            $('#ttd-C').html(tambah_ttd_sp_C.toDataURL())
        </script>
    </div>
@endsection

@push('js')
    <script>
        c = {{ $n_form }}
        $('#tambah-form').click(function () {
            subhtml = $('#pihak-ketiga').html()
            subhtml = subhtml.replace(/#/g, c)

            $('#form').append(subhtml)
            c++
        })

        $('#simpan').click(function () {
            for (i = 0; i < c; i++){
                if ($('#tambah-ttd-' + i).length != 0){
                    subhtml = $('#ttd-simpan').html()
                    subhtml = subhtml.replace(/C/g, i)
                    $('#form').append(subhtml)
                }
            }

            $('#form').submit()
        })
    </script>
@endpush
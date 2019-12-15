@php
    $kompeten = GlobalAuth::user()->getUjiAsAsesor()->filterByStatus(9)->count();
    $belum_kompeten = GlobalAuth::user()->getUjiAsAsesor()->filterByStatus(10)->count();
    $tidak_lolos_verifikasi = GlobalAuth::user()->getUjiAsAsesor()->filterByStatus(19)->count() + GlobalAuth::user()->getUjiAsAsesor()->filterByStatus(17)->count();
    $total = $kompeten + $belum_kompeten + $tidak_lolos_verifikasi;
    $persen_kompeten = number_format($kompeten / $total * 100, 2);
    $persen_belum_kompeten = number_format($belum_kompeten / $total * 100, 2);
    $persen_tidak_lolos_verifikasi = number_format($tidak_lolos_verifikasi / $total * 100, 2);
@endphp

@col(['size' => 4])
    <div class="card p-3">
        <div class="card-body d-flex justify-content-between align-items-center">
            <div>
                <span class="h4 d-block font-weight-normal mb-2">{{ GlobalAuth::user()->getUjiAsAsesor()->count() }}</span>
                <span class="font-weight-light">Jumlah Peserta Uji</span>
            </div>

            <div class="h2 text-muted">
                <i class="icon icon-people"></i>
            </div>
        </div>
    </div>
@endcol

@col(['size' => 4])
    <div class="card p-3">
        <div class="card-body d-flex justify-content-between align-items-center">
            <div>
                <span class="h4 d-block font-weight-normal mb-2">{{ GlobalAuth::user()->getJumlahHariUji() }}</span>
                <span class="font-weight-light">Jumlah Bukti Uji (Hari)</span>
            </div>

            <div class="h2 text-muted">
                <i class="icon icon-calendar"></i>
            </div>
        </div>
    </div>
@endcol

@col(['size' => 4])
    <div class="card p-3">
        <div class="card-body d-flex justify-content-between align-items-center">
            <div>
                <span class="h4 d-block font-weight-normal mb-2">{{ $kompeten }} ({{ $persen_kompeten }} %)</span>
                <span class="font-weight-light">Lulus Uji</span>
            </div>

            <div class="h2 text-muted">
                <i class="icon icon-graph"></i>
            </div>
        </div>
    </div>
@endcol

@col(['size' => 4])
    <div class="card p-3">
        <div class="card-body d-flex justify-content-between align-items-center">
            <div>
                <span class="h4 d-block font-weight-normal mb-2">{{ $belum_kompeten }} ({{ $persen_belum_kompeten }} %)</span>
                <span class="font-weight-light">Tidak Lulus Uji</span>
            </div>

            <div class="h2 text-muted">
                <i class="icon icon-graph"></i>
            </div>
        </div>
    </div>
@endcol

@col(['size' => 4])
    <div class="card p-3">
        <div class="card-body d-flex justify-content-between align-items-center">
            <div>
                <span class="h4 d-block font-weight-normal mb-2">{{ $tidak_lolos_verifikasi }} ({{ $persen_tidak_lolos_verifikasi }} %)</span>
                <span class="font-weight-light">Tidak Lolos Verifikasi</span>
            </div>

            <div class="h2 text-muted">
                <i class="icon icon-graph"></i>
            </div>
        </div>
    </div>
@endcol
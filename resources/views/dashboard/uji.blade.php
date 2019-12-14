@php
$kompeten = App\Models\Uji::filterByStatus(App\Models\Uji::LULUS)->count();
$belum_kompeten = App\Models\Uji::filterByStatus(App\Models\Uji::TIDAK_LULUS)->count();
$total = $kompeten + $belum_kompeten;
$persen_kompeten = number_format($kompeten / $total * 100, 2);
$persen_belum_kompeten = number_format($belum_kompeten / $total * 100, 2);
@endphp

@col(['size' => 4])
    <div class="card p-3">
        <div class="card-body d-flex justify-content-between align-items-center">
            <div>
                <span class="h4 d-block font-weight-normal mb-2">{{ App\Models\Uji::count() }}</span>
                <span class="font-weight-light">Total Uji Kompetensi</span>
            </div>

            <div class="h2 text-muted">
                <i class="icon icon-check"></i>
            </div>
        </div>
    </div>
@endcol

@col(['size' => 4])
    <div class="card p-3">
        <div class="card-body d-flex justify-content-between align-items-center">
            <div>
                <span class="h4 d-block font-weight-normal mb-2">{{ $kompeten }} ({{ $persen_kompeten }} %)</span>
                <span class="font-weight-light">Total Lulus Uji</span>
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
                <span class="font-weight-light">Total Tidak Lulus Uji</span>
            </div>

            <div class="h2 text-muted">
                <i class="icon icon-graph"></i>
            </div>
        </div>
    </div>
@endcol
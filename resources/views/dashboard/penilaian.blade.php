@col(['size' => 4])
    <div class="card p-3">
        <div class="card-body d-flex justify-content-between align-items-center">
            <div>
                <span class="h4 d-block font-weight-normal mb-2">{{ GlobalAuth::user()->getUjiAsAsesor()->count() }}</span>
                <span class="font-weight-light">Jumlah Total Pengujian</span>
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
                <span class="font-weight-light">Jumlah Pengujian (Hari)</span>
            </div>

            <div class="h2 text-muted">
                <i class="icon icon-calendar"></i>
            </div>
        </div>
    </div>
@endcol
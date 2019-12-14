@col(['size' => 4])
    <div class="card p-3">
        <div class="card-body d-flex justify-content-between align-items-center">
            <div>
                <span class="h4 d-block font-weight-normal mb-2">{{ App\Models\Skema::count() }}</span>
                <span class="font-weight-light">Jumlah Skema</span>
            </div>

            <div class="h2 text-muted">
                <i class="icon icon-list"></i>
            </div>
        </div>
    </div>
@endcol
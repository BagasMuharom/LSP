@col(['size' => 4])
    <div class="card p-3">
        <div class="card-body d-flex justify-content-between align-items-center">
            <div>
                <span class="h4 d-block font-weight-normal mb-2">{{ App\Models\User::getHasRole(App\Models\Role::ASESOR)->count() }}</span>
                <span class="font-weight-light">Jumlah Asesor</span>
            </div>

            <div class="h2 text-muted">
                <i class="icon icon-people"></i>
            </div>
        </div>
    </div>
@endcol
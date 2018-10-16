<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\Models\Skema;
use App\Models\Uji;
use App\Models\Menu;
use App\Models\Sertifikat;
use App\Models\Mahasiswa;
use App\Models\User;
use App\Policies\SkemaPolicy;
use App\Policies\UjiPolicy;
use App\Policies\MenuPolicy;
use App\Policies\UserPolicy;
use App\Policies\MahasiswaPolicy;
use App\Policies\SertifikatPolicy;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Menu::class => MenuPolicy::class,
        Uji::class => UjiPolicy::class,
        Sertifikat::class => SertifikatPolicy::class,
        User::class => UserPolicy::class,
        Mahasiswa::class => MahasiswaPolicy::class
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }
}

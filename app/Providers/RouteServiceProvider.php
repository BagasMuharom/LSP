<?php

namespace App\Providers;

use App\Models\Dana;
use App\Models\Event;
use App\Models\Galeri;
use App\Models\Kuesioner;
use App\Models\Kustomisasi;
use App\Models\Mahasiswa;
use App\Models\Post;
use App\Models\Sertifikat;
use App\Models\Syarat;
use App\Models\Uji;
use App\Models\User;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'App\Http\Controllers';

    protected $webRoutes = [
        'web',
        'profile',
        'menu/blog',
        'menu/pendaftaran',
        'menu/penilaian',
        'menu/skema',
        'menu/verifikasi',
        'menu/uji',
        'menu/unit',
        'menu/asesor',
        'menu/mahasiswa',
        'menu/sertifikat',
        'menu/user',
        'menu/role',
        'menu/menu',
        'menu/kustomisasi',
        'menu/galeri',
        'menu/fjp',
        'menu/event',
        'menu/dana',
        'menu/kuesioner'
    ];

    protected $bind = [
        'uji' => Uji::class,
        'syarat' => Syarat::class,
        'asesor' => User::class,
        'mahasiswa' => Mahasiswa::class,
        'sertifikat' => Sertifikat::class,
        'user' => User::class,
        'post' => Post::class,
        'kustomisasi' => Kustomisasi::class,
        'galeri' => Galeri::class,
        'dana' => Dana::class,
        'event' => Event::class,
        'kuesioner' => Kuesioner::class
    ];

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        // Explicit binding

        foreach ($this->bind as $param => $model) {
            Route::bind($param, function ($value) use ($model) {
                try {
                    return $model::findOrFail(decrypt($value));
                } catch (ModelNotFoundException $e) {
                    return abort(404);
                } catch (DecryptException $e) {
                    return abort(404);
                }
            });
        }
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        // $this->mapApiRoutes();

        $this->mapWebRoutes();

        //
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapWebRoutes()
    {
        foreach ($this->webRoutes as $route) {
            Route::middleware('web')
                ->namespace($this->namespace)
                ->group(base_path('routes/' . $route . '.php'));
        }
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiRoutes()
    {
        Route::prefix('api')
            ->middleware('api')
            ->namespace($this->namespace)
            ->group(base_path('routes/api.php'));
    }
}

<?php

namespace App\Providers;

use Carbon\Carbon;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use Validator;
use App\Models\{Mahasiswa, User};

class AppServiceProvider extends ServiceProvider
{

    private $customComponents = [
        'alert', 'card', 'row', 'col', 'error', 'formgroup'
    ];

    private $customComponentsPath = 'layouts.components.';

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        foreach($this->customComponents as $comp) {
            Blade::component($this->customComponentsPath . $comp);
        }

        Validator::extend('nullableimage', function ($attribute, $value, $parameters, $validator) {
            if ($value == null)
                return true;

            return in_array(
                request()->file($attribute)->getCLientOriginalExtension(), 
                ['png', 'jpg', 'jpeg']
            );
        });

        setlocale(LC_TIME, 'Indonesia');
        Carbon::setLocale('id');

        ini_set('max_execution_time', 1200);
        ini_set('post_max_size', '200M');
        ini_set('upload_max_filesize', '100M');

        // menambah custom helper
        require_once(__DIR__ . '/../Support/Helper.php');
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('GlobalAuth', 'App\Support\GlobalAuth');
        $this->app->bind('ImportSertifikat', 'App\Support\ImportSertifikat');
    }

}

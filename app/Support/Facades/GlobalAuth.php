<?php

namespace App\Support\Facades;

use Illuminate\Support\Facades\Facade;

class GlobalAuth extends Facade
{

    protected static function getFacadeAccessor()
    {
        return 'GlobalAuth';
    }

}

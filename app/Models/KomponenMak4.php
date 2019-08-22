<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KomponenMak4 extends Model
{
    
    protected $table = 'komponen_mak4';

    public $timestamps = false;

    protected $fillable = [
        'id', 'komponen'
    ];

}

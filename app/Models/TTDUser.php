<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TTDUser extends Model
{
    
    protected $table = 'user_ttd';

    protected $fillable = [
        'user_id', 'ttd'
    ];

    public $timestamps = false;

}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TTDMahasiswa extends Model
{

    protected $table = 'mahasiswa_ttd';

    protected $fillable = [
        'mahasiswa_nim', 'ttd'
    ];

    public $timestamps = false;

}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Event;

class Dana extends Model
{
    protected $table = 'dana';
    
    protected $fillable = [
        'nama', 'keterangan', 'berulang', 'created_at', 'updated_at'
    ];

    /**
     * mendapatkan event
     *
     * @param bool $queryReturn
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function getEvent($queryReturn = true)
    {
        $data = $this->hasMany(Event::class, 'dana_id');
        return $queryReturn ? $data : $data->get();
    }

    public static function has($nama)
    {
        return Dana::where('nama', $nama)->count() > 0;
    }

    public static function findByNama($nama)
    {
        return Dana::where('nama', $nama)->first();
    }
}

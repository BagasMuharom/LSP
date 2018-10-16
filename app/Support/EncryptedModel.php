<?php

namespace App\Support;

trait EncryptedModel {

    /**
     * Mendapatkan model dengan mengenkripsi primary key
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param boolean $showPrimaryKey
     * @return mixed
     */
    public function scopeGetProtect($query, $showPrimaryKey = true)
    {
        $results = $query->get();

        $pk = $this->primaryKey;

        $results->each(function ($item) use ($pk) {
            $item->pk = encrypt($item->{$pk});
        });

        if (!$showPrimaryKey)
            $results = $results->makeHidden('id');

        return $results;
    }

}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Post extends Model
{
    use Searchable;

    protected $table = 'posts';

    protected $fillable = [
        'judul', 'permalink', 'isi', 'penulis_id', 'created_at', 'updated_at'
    ];

    /**
     * @param bool $queryReturn
     * @return Model|\Illuminate\Database\Eloquent\Relations\BelongsTo|null|object
     */
    public function getPenulis($queryReturn = true)
    {
        $data = $this->belongsTo('App\Models\User', 'penulis_id');
        return $queryReturn ? $data : $data->first();
    }

    public function searchableAs()
    {
        return 'post_index';
    }

    public function toSearchableArray()
    {
        return [
            'id' => $this->id,
            'judul' => $this->judul,
            'permalink' => $this->permalink,
            'isi' => $this->isi,
            'penulis' => $this->getPenulis(false)->nama
        ];
    }

    /**
     * Get the value used to index the model.
     *
     * @return mixed
     */
    public function getScoutKey()
    {
        return $this->id;
    }

    /**
     * mengubah hasil pencarian menjadi eloquent
     *
     * @param $keyword
     * @return mixed
     */
    public static function searchToEloquent($keyword)
    {
        return Post::whereIn('id', Post::search($keyword)->raw()['ids']);
    }

    /**
     * Generate Permalink
     *
     * @return void
     */
    public static function generatePermalink($judul)
    {
        $title = $judul;
        $postfix = '';
        $symbol = '\' " , . / ? ! @ # $ % ^ & * ( ) _ + = { } [ ] ( )';

        $permalink = strtolower($title);
        $permalink = str_replace(' ', '-', $permalink);
        $permalink = str_replace(explode(' ', $symbol), '', $permalink);

        if (static::where('permalink', $permalink)->count() > 0)
            $postfix .= '-' . static::where('permalink', $permalink)->count() + 1;

        return $permalink . $postfix;
    }

}

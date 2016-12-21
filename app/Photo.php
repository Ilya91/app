<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    protected $fillable = ['file'];
    protected $uploads = '/images/';

    public function getFileAttribute($photo){ // перезапись значения в столбце file таблицы photos
        return $this->uploads . $photo;
    }
}

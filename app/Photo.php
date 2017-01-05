<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    protected $fillable = ['file'];
    protected $uploads = '/images/';
    protected $watermark;
    protected $path;

    public function getWatermark(){
        return $this->watermark = public_path() . '/images/watermark.png';
    }

    public function getPath(){
        return $this->path = public_path() . '/images/';
    }

    public function getFileAttribute($photo){ // перезапись значения в столбце file таблицы photos
        return $this->uploads . $photo;
    }

    public function post(){
        return $this->belongsTo('App\Post');
    }
}

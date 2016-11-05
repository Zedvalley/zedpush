<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    protected $table='gallery';
    public $timestamps = false;

    public function findByKey($id)
    {
        return $this->where('id','=',$id)->first();
    }
    public static function initializeHome()
    {
        $gallery= new Gallery();
        $gallery->save();
        return $gallery->id;
    }


}

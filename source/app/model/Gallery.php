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
    public static function initializeHome($userid)
    {
        $gallery= new Gallery();
        $gallery->created_by=$userid;
        $gallery->save();
        return $gallery->id;
    }


}

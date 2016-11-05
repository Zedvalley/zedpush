<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class Contacts extends Model
{

    public $timestamps = false;
    protected $table='contacts';

    public function findByKey($id)
    {
        return $this->where('id','=',$id)->first();
    }
}

<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class Countries extends Model
{
    protected $table='countries';
    public $timestamps = false;
    public function findByKey($id)
    {
        return $this->where('id','=',$id)->first();
    }
}

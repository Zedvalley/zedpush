<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class Home extends Model
{
    protected $table='home';
    public $timestamps = false;


    public function findByKey($id)
    {
        return $this->where('id','=',$id)->first();
    }
    public function findByUserId($id)
    {
        return $this->where('created_by','=',$id)->first();
    }
}

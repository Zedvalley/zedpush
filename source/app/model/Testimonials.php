<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class Testimonials extends Model
{
    protected $table='testimonials';
    public $timestamps = false;
    protected $primaryKey = 'id';

    public function findByKey($id)
    {
        return $this->where('id','=',$id)->first();
    }
    public function scopeIdentify($query,$id)
    {
        return $query->where('created_by',$id);

    }
}

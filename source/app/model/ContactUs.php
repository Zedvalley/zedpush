<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class ContactUs extends Model
{
    protected $table='contact_us';
    public $timestamps = false;
public function findByKey($id)
{
    return $this->where('id','=',$id)->first();
}
}
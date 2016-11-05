<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class Users extends Model
{
    protected $table='users';
    public $timestamps = false;

    public static  function checkApiKeyExist($value)
    {
        if (self::where('apikey', $value)->count() == 1)
        {
            return true;
        }
            return false;
        }
    public function validateCredentials($username,$password)
    {
        if ($this->where('username', $username)->where('password', $password)->count() == 1) {
            return true;
        } else {
            return false;
        }
    }
    public static function getCreatorFromKey($key)
    {
        if (self::where('apikey', $key)->count() == 1)
        {
            $model=self::where('apikey',$key)->first();
            return $model->id;
        }

    }
    public function findByKey($id)
    {
        return $this->where('id','=',$id)->first();
    }



}

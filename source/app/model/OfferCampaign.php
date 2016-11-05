<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class OfferCampaign extends Model
{
    protected $table='offer_campaign';
    public $timestamps = false;
    protected $primaryKey = 'id';

    public function findByKey($id)
    {

        return $this->where('id','=',$id)->first();

    }
    public static function checkSlug($userId,$content)
    {
        if(self::where('created_by',$userId)->where('slug',$content)->count()==0)
        {
            return true;
        }
        return false;
    }
}

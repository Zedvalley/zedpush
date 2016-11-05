<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class ProductCategory extends Model
{
    protected $table='product_category';
    public $timestamps = false;

    public function findByKey($id)
    {
        return $this->where('id','=',$id)->first();
    }
    public static function childExist($id)
    {
        return self::where('parent_id',$id)->count();
    }
    public static function allChild($id)
    {
        return self::where('parent_id',$id)->get();
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

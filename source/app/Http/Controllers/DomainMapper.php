<?php

namespace App\Http\Controllers;

use App\model\Domains;
use Illuminate\Support\Facades\DB;

use App\Http\Requests;

class DomainMapper extends Controller
{
    public function getUserIdFromDomain($dname)
    {
        $result=new Domains();
        $result=$result->where('name',$dname);
        if($result->count()==1)
        {
            $set=$result->first();
            echo $set->user_id;

        }
       echo null;
    }
    public function getUsernameFromDomain($dname)
    {

        $result= DB::table('domains')->leftJoin('users','users.id','=','domains.user_id')->wherer('domains.name',$dname)->select('users.username');
        if($result->count()==1)
            echo $result->first()->username;
        else
            echo null;

    }
}

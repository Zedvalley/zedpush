<?php

namespace App\Http\Controllers;

use App\model\Settings;
use Illuminate\Http\Request;

use App\Http\Requests;

class SettingsController extends Controller
{
    public function __construct()
    {
        $this->middleware('AuthApi');
    }

    public static function initialize($mobno,$creator)
    {
        $settings=new Settings();
        $settings->def_mob=$mobno;
        $settings->created_by=$creator;
        $settings->save();
        return $settings->id;
    }
    public static function getDefaultMobileNumber($userId)
    {
        $result=Settings::where('created_by',$userId);
        if($result->count()>0)
        return $result->get()->def_mob;
        return null;
    }

}

<?php

namespace App\Http\Controllers;

use App\model\Settings;
use Illuminate\Http\Request;

use App\Http\Requests;

class SettingsController extends Controller
{
    public static function initialize($mobno)
    {
        $settings=new Settings();
        $settings->def_mob=$mobno;
        $settings->save();
        return $settings->id;
    }
}

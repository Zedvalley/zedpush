<?php

namespace App\Http\Controllers;

use App\model\Home;
use App\model\Users;
use Illuminate\Http\Request;
use App\Http\Requests;

class UserController extends Controller
{
    public function create(Request $request)
    {
        $user=new Users();
        $user->fname=$request->input('fname');
        $user->lname=$request->input('lname');
        $user->email=$request->input('email');
        $user->mobno=$request->input('mobno');
        $user->username=$request->input('username');
        $user->password=$request->input('password');
        $user->apikey=$this->generateApiKey();
        $user->settings_id=SettingsController::initialize($user->mobno);
        $user->save();
        HomeController::initialize($user->id);

    }
    public function updateShopDetails(Request $request)
    {
        $user=new Users();
        $userId=Users::getCreatorFromKey($request->input('syskey'));
        $user=$user->findByKey($userId);
        $user->exist=true;
        $user->fname=$request->input('country_id');//update here
        $user->lname=$request->input('location_id');
        $home = new Home();
        $home=$home->findByUserId($user->id);
        $home->exist=true;
        $home->logo_title=$request->input('logo');
        $user->save();
        $home->save();

    }
    public function updatePersonalInfo(Request $request)
    {
        $user=new Users();
        $userId=Users::getCreatorFromKey($request->input('syskey'));
        $user=$user->findByKey($userId);
        $user->exist=true;
        $user->fname=$request->input('fname');
        $user->lname=$request->input('lname');
        $user->email=$request->input('email');
        $user->mobno=$request->input('mobno');
        $user->save();

    }
    public function updateUsername(Request $request)
    {
        if($this->checkUsernameExist($request))
        {
            $user=new Users();
            $userId=Users::getCreatorFromKey($request->input('syskey'));
            $user=$user->findByKey($userId);
            $user->exist=true;
            $user->username=$request->input('username');
            $user->save();
        }
        else
        {
            //return message
        }

    }
    public function updatePassword(Request $request)
    {
        if($request->input('pass1')==$request->input('pass2')) {
            $user = new Users();
            $userId = Users::getCreatorFromKey($request->input('syskey'));
            $user = $user->findByKey($userId);
            $user->exist=true;
            $user->password=$request->input('password');

        }
    }

    public function login(Request $request)
    {
        $username=$request->input('username');
        $password=$request->input('password');
        $page=new Users();
        if($page->validateCredentials($username,$password))
        {
            $result=$page->where('username',$username)->where('password',$password)->select('fname','mobno','apikey','smskey')->get();
            return response()->json([$result]);
        }
        else
        {
            //response
        }
    }
    public function checkUsernameExist(Request $request)
    {
        $username=$request->input('username');
        if(Users::where('username',$username)->count()==0)
        {
            return true;
        }
        return false;
    }
    public function checkEmailExist(Request $request)
    {
        $email=$request->input('email');
        if(Users::where('email',$email)->couunt()==0)
        {
            return true;
        }
        return false;
    }

    public function generateApiKey()
    {
        $key=sha1(uniqid());
        return $key;
    }


}

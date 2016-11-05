<?php

namespace App\Http\Controllers;

use App\model\Users;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;

class ApiHandler extends Controller
{

    public function createUser(Request $request)
    {

        $user=new Users();
        $user->fname="sdsdsd";
        $user->lname="ssd";
        $user->mobno="998";
        $user->password="sdsda";
        $user->syspass="sd";
        $user->syskey="sdasd";
        $user->act_stat=0;
        $user->save();
    }
    public function Index()
    {
        echo "hello";
    }
    public function paraTransfer(Request $request)
    {
        $username=$request->input('username');
        $password=$request->input('password');
        $user=new Users();
        if($user->validateCredentials($username,$password))
        {
            $model=Users::where('username',$username)->first();
            $data=[
                    'fname'=>$model->fname,
                    'email'=>$model->email,
                    'apikey'=>$model->apikey,
                    'syskey'=>$model->syskey,
                    'username'=>$model->username,
                    'id'=>$model->id
            ];
            return response()->json($data);
        }
        else
        {
            return response()->json(['message'=>'Credentials doesn\'t match']);
        }

    }
    public function checkStatus($id)
    {
        $model=Users::where('id',$id)->first();
        if($model->act_stat==1)
            return response()->json(['stat'=>1]);
        else
            return response()->json(['stat'=>0]);
    }


}

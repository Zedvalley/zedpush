<?php

namespace App\Http\Controllers;

use App\model\Countries;
use App\model\Home;
use App\model\Users;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Validator;



class UserController extends Controller
{

    public function __construct()
    {
        $this->middleware('AuthApi',['except' =>'create']);
    }

    public function getUserDetails(Request $request)
    {
        $userId=Users::getCreatorFromKey($request->input('syskey'));
        $result=Users::where('id',$userId)->get();
        return response()->json(['status'=>200,'result'=>['details'=>
            $result],
            'message'=>'Successfull']);
    }
    public function create(Request $request)
    {
        $validator= Validator::make($request->all(),
            [
                'fname'=>'required',
                'email'=>'email|unique:users,email',
                'mobno'=>'required|unique:users,mobno',
                'username'=>'required|unique:users,username',
                'password'=>'required',

            ]);
        if($validator->fails())
        {
            return response()->json(['status'=>102,'result'=>$validator->errors()]);
        }
        $user=new Users();
        $user->fname=$request->input('fname');
        $user->lname=$request->input('lname');
        $user->email=$request->input('email');
        $user->mobno=$request->input('mobno');
        $user->username=$request->input('username');
        $user->password=$request->input('password');
        $user->apikey=$this->generateApiKey();
        $user->save();
        SettingsController::initialize($user->mobno,$user->id);
        HomeController::initialize($user->id);
        return response()->json(['status'=>200,'result'=>[],
            'message'=>'Successfull']);

    }
    public function updateShopDetails(Request $request)
    {
        $validator= Validator::make($request->all(),
            [
                'country_id'=>'required',
                'location_id'=>'required',
                'logo'=>'required',

            ]);
        if($validator->fails())
        {
            return response()->json(['status'=>102,'result'=>$validator->errors()]);
        }

        $user=new Users();
        $userId=Users::getCreatorFromKey($request->input('syskey'));
        $user=$user->findByKey($userId);
        $user->exists=true;
        $user->country_id=$request->input('country_id');//update here
        $user->location_id=$request->input('location_id');
        $home = new Home();
        $home=$home->findByUserId($user->id);
        $home->exists=true;
        $home->logo_title=$request->input('logo');

        if($user->id==$userId) {
            $user->save();
            $home->save();
            return response()->json(['status' => 200, 'result' => [],
                'message' => 'Successfull']);
        }

        return response()->json(['status' => 201, 'result' => [],
            'message' => 'invalid']);

    }
    public function updatePersonalInfo(Request $request)
    {
        $validator= Validator::make($request->all(),
            [
                'fname'=>'required',
                'email'=>'email|unique:users,email',
                'mobno'=>'required|unique:users,mobno',
                'username'=>'required|unique:users,username',
                'password'=>'required',

            ]);
        if($validator->fails())
        {
            return response()->json(['status'=>102,'result'=>$validator->errors()]);
        }
        $user=new Users();
        $userId=Users::getCreatorFromKey($request->input('syskey'));
        $user=$user->findByKey($userId);
        $user->exists=true;
        $user->fname=$request->input('fname');
        $user->lname=$request->input('lname');
        $user->email=$request->input('email');
        $user->mobno=$request->input('mobno');
        if($user->id==$userId) {
            $user->save();
            return response()->json(['status' => 200, 'result' => [],
                'message' => 'Successfull']);
        }

        return response()->json(['status' => 201, 'result' => [],
            'message' => 'invalid']);


    }
    public function updateUsername(Request $request)
    {
        $validator= Validator::make($request->all(),
            [

                'username'=>'required|unique:users,username',


            ]);
        if($validator->fails())
        {
            return response()->json(['status'=>102,'result'=>$validator->errors()]);
        }
        if($this->checkUsernameExist($request))
        {
            $user=new Users();
            $userId=Users::getCreatorFromKey($request->input('syskey'));
            $user=$user->findByKey($userId);
            $user->exists=true;
            $user->username=$request->input('username');
            if($user->id==$userId) {
                $user->save();
                return response()->json(['status' => 200, 'result' => [],
                    'message' => 'Successfull']);
            }

            return response()->json(['status' => 201, 'result' => [],
                'message' => 'invalid']);
        }
        else
        {
            return response()->json(['status'=>102,'result'=>'invalid user id']);
        }

    }
    public function updatePassword(Request $request)
    {
        $validator= Validator::make($request->all(),
            [

                'pass1'=>'required',
                'pass2'=>'required'

            ]);
        if($validator->fails())
        {
            return response()->json(['status'=>102,'result'=>$validator->errors()]);
        }
        if($request->input('pass1')==$request->input('pass2')) {
            $user = new Users();
            $userId = Users::getCreatorFromKey($request->input('syskey'));
            $user = $user->findByKey($userId);
            $user->exists=true;
            $user->password=$request->input('pass1');
            if($user->id==$userId) {
                $user->save();
                return response()->json(['status' => 200, 'result' => [],
                    'message' => 'Successfull']);
            }

            return response()->json(['status' => 201, 'result' => [],
                'message' => 'invalid']);
        }
        else
        {
            return response()->json(['status' => 201, 'result' => [],
                'message' => 'password not match']);
        }
    }

    public function login(Request $request)
    {
        $validator= Validator::make($request->all(),
            [

                'username'=>'required|exists:users,username',
                'password'=>'required',

            ]);
        if($validator->fails())
        {
            return response()->json(['status'=>102,'result'=>$validator->errors()]);
        }
        $username=$request->input('username');
        $password=$request->input('password');
        $page=new Users();
        if($page->validateCredentials($username,$password))
        {
            $result=$page->where('username',$username)->where('password',$password)->select('fname','mobno','apikey','smskey')->get();
            return response()->json(['status'=>200,'result'=>[
                'data'=>$result
            ],
                'message'=>'Successfull']);
        }
        else
        {
            return response()->json(['status'=>202,'result'=>[
                'status'=>'false'
            ],
                'message'=>'Successfull']);
        }
    }
    public function checkUsernameExist(Request $request)
    {
        $validator= Validator::make($request->all(),
            [

                'username'=>'required|unique:users,username',


            ]);
        if($validator->fails())
        {
            return response()->json(['status'=>102,'result'=>$validator->errors()]);
        }
        $username=$request->input('username');
        if(Users::where('username',$username)->count()==0)
        {
            return response()->json(['status'=>200,'result'=>[
                'status'=>'true'
            ],
                'message'=>'Successfull']);
        }
        return response()->json(['status'=>202,'result'=>[
            'status'=>'false'
        ],
            'message'=>'Successfull']);
    }

    public function getCountriesList()
    {
        $result=Countries::all();
        return response()->json(['status'=>200,'result'=>['list'=>$result
        ],
            'message'=>'Successfull']);
    }

    public function checkEmailExist(Request $request)
    {
        $validator= Validator::make($request->all(),
            [

                'email'=>'email|unique:users,email'


            ]);
        if($validator->fails())
        {
            return response()->json(['status'=>102,'result'=>$validator->errors()]);
        }

        $email=$request->input('email');
        if(Users::where('email',$email)->count()==0)
        {
            return response()->json(['status'=>200,'result'=>[
                'status'=>'true'
            ],
                'message'=>'Successfull']);
        }
        return response()->json(['status'=>202,'result'=>[
            'status'=>'false'
        ],
            'message'=>'Successfull']);
    }

    public function generateApiKey()
    {
        $key=sha1(uniqid());
        return $key;
    }


}

<?php

namespace App\Http\Controllers;

use App\model\Gallery;
use App\model\Home;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\model\Users;

use App\Http\Requests;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('AuthApi');
    }


    public function setLogoTitle(Request $request)
    {
        $validator= Validator::make($request->all(),
            [
                'title'=>'required',
            ]);
        if($validator->fails())
        {
            return response()->json(['status'=>102,'result'=>$validator->errors()]);
        }
        $userId=Users::getCreatorFromKey($request->input('syskey'));
        $page= new Home();
        $page=$page->findByUserId($userId);
        if($page->created_by==$userId)
        {
            $page->logo_title=$request->input('title');
            $page->save();
            return response()->json(['status'=>200,'result'=>[],
                'message'=>'Successfull']);
        }
        return response()->json(['status'=>200,'result'=>[],
            'message'=>'Invalid ID']);
    }
    public static function initialize($userId)
    {
        $page=new Home();
        $page->created_by=$userId;
        $page->gallery_id=Gallery::initializeHome($userId);
        $page->save();
        return response()->json(['status'=>200,'result'=>[],
            'message'=>'Successfull']);
    }
    public function setGallery(Request $request)
    {
        $userId=Users::getCreatorFromKey($request->input('syskey'));
        $page= new Home();
        $page=$page->findByUserId($userId);
        if($page->created_by==$userId)
        {
            $gal=Commons::createGallery($request);
            if(is_object($gal))
            {
                return $gal;
            }
            $page->gallery_id=$gal;
            $page->save();
            return response()->json(['status'=>200,'result'=>[],
                'message'=>'Successfull']);
        }
        return response()->json(['status'=>200,'result'=>[],
            'message'=>'Invalid ID']);

    }
    public function updateTag(Request $request)
    {
        $validator= Validator::make($request->all(),
            [
                'tag'=>'required',
            ]);
        if($validator->fails())
        {
            return response()->json(['status'=>102,'result'=>$validator->errors()]);
        }
        $userId=Users::getCreatorFromKey($request->input('syskey'));
        $page= new Home();
        $tag=$request->input('tag');
        $page=$page->findByUserId($userId);
        if($page->created_by==$userId)
        {
            $page->sector_tag=Commons::checkForEmpty($tag);
            $page->save();
            return response()->json(['status'=>200,'result'=>[],
                'message'=>'Successfull']);
        }
        return response()->json(['status'=>200,'result'=>[],
            'message'=>'Invalid ID']);
    }
    public function getHomeDetails(Request $request)
    {

        $userId=Users::getCreatorFromKey($request->input('syskey'));
        $result=Home::where('created_by',$userId)->first();
        return response()->json(['status'=>200,'result'=>['details'=>
        $result],
            'message'=>'Successfull']);


    }
    public function updateAboutUs(Request $request)
    {
        $validator= Validator::make($request->all(),
            [
                'text'=>'required',
            ]);
        if($validator->fails())
        {
            return response()->json(['status'=>102,'result'=>$validator->errors()]);
        }
        $userId=Users::getCreatorFromKey($request->input('syskey'));
        $page= new Home();
        $text=$request->input('text');
        $page=$page->findByUserId($userId);
        if($page->created_by==$userId)
        {
            $page->about_us=Commons::checkForEmpty($text);
            $page->save();
            return response()->json(['status'=>200,'result'=>[],
                'message'=>'Successfull']);
        }
        return response()->json(['status'=>200,'result'=>[],
            'message'=>'Invalid ID']);
    }
    public function updateEmail(Request $request)
    {
        $validator= Validator::make($request->all(),
            [
                'text'=>'required',
            ]);
        if($validator->fails())
        {
            return response()->json(['status'=>102,'result'=>$validator->errors()]);
        }
        $userId=Users::getCreatorFromKey($request->input('syskey'));
        $page= new Home();
        $text=$request->input('text');
        $page=$page->findByUserId($userId);
        if($page->created_by==$userId)
        {
            $page->email=Commons::checkForEmpty($text);
            $page->save();
            return response()->json(['status'=>200,'result'=>[],
                'message'=>'Successfull']);
        }
        return response()->json(['status'=>200,'result'=>[],
            'message'=>'Invalid ID']);

    }
    public function updateAddress(Request $request)
    {
        $validator= Validator::make($request->all(),
            [
                'text'=>'required',
            ]);
        if($validator->fails())
        {
            return response()->json(['status'=>102,'result'=>$validator->errors()]);
        }
        $userId=Users::getCreatorFromKey($request->input('syskey'));
        $page= new Home();
        $text=$request->input('text');
        $page=$page->findByUserId($userId);
        if($page->created_by==$userId)
        {
            $page->address=Commons::checkForEmpty($text);
            $page->save();
            return response()->json(['status'=>200,'result'=>[],
                'message'=>'Successfull']);
        }
        return response()->json(['status'=>200,'result'=>[],
            'message'=>'Invalid ID']);

    }

    public function updateContact(Request $request)
    {
        $validator= Validator::make($request->all(),
            [
                'text'=>'required',
            ]);
        if($validator->fails())
        {
            return response()->json(['status'=>102,'result'=>$validator->errors()]);
        }
        $userId=Users::getCreatorFromKey($request->input('syskey'));
        $page= new Home();
        $text=$request->input('text');
        $page=$page->findByUserId($userId);
        if($page->created_by==$userId)
        {
            $page->contact=Commons::checkForEmpty($text);
            $page->save();
            return response()->json(['status'=>200,'result'=>[],
                'message'=>'Successfull']);
        }
        return response()->json(['status'=>200,'result'=>[],
            'message'=>'Invalid ID']);

    }

}

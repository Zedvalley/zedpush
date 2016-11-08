<?php

namespace App\Http\Controllers;

use App\model\ContactUs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\model\Users;

use App\Http\Requests;

class ContactUsController extends Controller
{
    public function __construct()
    {
        $this->middleware('AuthApi');
    }

    public function createContactRequest(Request $request)
    {
        $validator= Validator::make($request->all(),
            [
                'name'=>'required|max:150',
                'email'=>'required|email',
                'mobno'=>'required',
                'message'=>'required|max:500'
            ],
            [
                'mobno'=>'Mobile number doesnot match'
            ]
            );
        if($validator->fails())
        {
            return response()->json(['status'=>102,'result'=>$validator->errors()]);
        }

        $handler=new ContactUs();
        $userId=Users::getCreatorFromKey($request->input('syskey'));
        $handler->created_by=$userId;
        $handler->submitted_at=new \DateTime();
        $handler->name=$request->input('name');
        $handler->email=Commons::checkForEmpty($request->input('email'));
        $handler->mobile=Commons::checkForEmpty($request->input('mobno'));
        $handler->message=$request->input('message');
        $handler->save();
        return response()->json(['status'=>200,'result'=>[],
            'message'=>'Successfull']);
    }
    public function viewContactRequest(Request $request)
    {
        $validator= Validator::make($request->all(),
            [
                'id'=>'required|numeric|exists:contact_us,id',
            ]);
        if($validator->fails())
        {
            return response()->json(['status'=>102,'result'=>$validator->errors()]);
        }

        $userId=Users::getCreatorFromKey($request->input('syskey'));
        $id=$request->input('id');
        $handler=ContactUs::where('id',$id)->where('created_by',$userId);
        $result=$handler->get();
        $this->updateStatus($userId,$id);
        return response()->json(['status'=>200,'result'=>['list'=>$result],
            'message'=>'Successfull']);

    }
    public function updateStatus($userId,$id)
    {
        $handler=new ContactUs();
        $handler=$handler->findByKey($id);
        if($handler->created_by==$userId)
        {
            $handler->status=1;
            $handler->save();
            return response()->json(['status'=>200,'result'=>[],
                'message'=>'Successfull']);
        }
        return response()->json(['status'=>201,'result'=>[],
            'message'=>'Invalid ID']);
    }
    public function listContactRequest(Request $request)
    {
        $userId=Users::getCreatorFromKey($request->input('syskey'));
        $handler=ContactUs::where('created_by',$userId)->select('id','name','submitted_at');
        $count=$handler->count();
        $result=$handler->get();
        return response()->json(['status'=>200,'result'=>['count'=>$count,'result'=>$result],
            'message'=>'Successfull']);
    }
    public function listContactRequestByOffset(Request $request)
    {
        $validator= Validator::make($request->all(),
            [
                'offset'=>'required|numeric',
                'limit'=>'required|numeric'
            ]);
        if($validator->fails())
        {
            return response()->json(['status'=>102,'result'=>$validator->errors()]);
        }
        $userId=Users::getCreatorFromKey($request->input('syskey'));
        $offset=$request->input('offset');
        $limit=$request->input('limit');
        $handler=ContactUs::where('created_by',$userId)->select('id','name','submitted_at')->offset($offset)->limit($limit);
        $count=$handler->count();
        $result=$handler->get();
        return response()->json(['status'=>200,'result'=>['count'=>$count,'result'=>$result],
            'message'=>'Successfull']);

    }
    public function deleteContactRequest(Request $request)
    {
        $validator= Validator::make($request->all(),
            [
                'id'=>'required|numeric|exists:contact_us,id',
            ]);
        if($validator->fails())
        {
            return response()->json(['status'=>102,'result'=>$validator->errors()]);
        }

        $userId=Users::getCreatorFromKey($request->input('syskey'));
        $page= new ContactUs();
        $id=$request->input('id');
        $page=$page->findByKey($id);
        if($page->created_by==$userId)
            $page->delete();
        else
        {
            return response()->json(['status'=>200,'result'=>[],
                'message'=>'Invalid ID']);
        }
        return response()->json(['status'=>200,'result'=>[],
            'message'=>'Successfull']);
    }

}

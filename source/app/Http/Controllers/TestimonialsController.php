<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\model\Testimonials;
use App\Http\Requests;
use App\model\Users;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;


class TestimonialsController extends Controller
{
    public function createTestimonial(Request $request)
    {

            $validator= Validator::make($request->all(),
                [
                    'name'=>'required|max:200',
                    'message'=>'required|max:700',
                    'rating'=>'numeric|min:0,max:5',
                    'hidden'=>'numeric|min:0,max:1',
                    'image'=>'mimes:jpeg',

                ]);
            if($validator->fails())
            {
                return response()->json(['status'=>102,'result'=>$validator->errors()]);
            }

        $page = new Testimonials();
        $userId = Users::getCreatorFromKey($request->input('syskey'));
        $page->created_by = $userId;
        $page->name = $request->input('name');
        $page->message = $request->input('message');
        $page->hidden=$this->checkForHidden($request->input('hidden'));
        $page->rating = $request->input('rating');
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            if (Commons::checkMime($file)) {
                $page->image = $this->processFile($file);
            } else {
                return response()->json(['error' => [
                    'status' => 100,
                    'description' => 'Bad Image Mime Type'
                ]]);
            }
        } else {
            $page->image = null;
        }
        $page->created_at= new \DateTime();
    $page->save();

        return response()->json(['status'=>200,'result'=>[],
            'message'=>'Successfull']);


    }

    public function updateTestimonial(Request $request)
    {
        $validator= Validator::make($request->all(),
            [
                'name'=>'required|max:200',
                'message'=>'required|max:700',
                'rating'=>'required|numeric',
                'hidden'=>'required|numeric',
                'id'=>'required|numeric|exists:testimonials,id'

            ]);
        if($validator->fails())
        {
            return response()->json(['status'=>102,'result'=>$validator->errors()]);
        }

        $page = new Testimonials();
        $userId=Users::getCreatorFromKey($request->input('syskey'));
        $id=$request->input('id');
        $page= $page->findByKey($id);
        $page->exists=true;
        $page->name = $request->input('name');
        $page->message = $request->input('message');
        $page->rating = Commons::checkForEmpty($request->input('rating'));
        $page->hidden=$this->checkForHidden($request->input('hidden'));
        if($page->created_by==$userId) {
            $page->save();
            return response()->json(['status' => 200, 'result' => [],
                'message' => 'Successfull']);
        }
        return response()->json(['status' => 201, 'result' => [],
            'message' => 'Invalid User ID']);


    }
    public function updateImage(Request $request)
    {
        $validator= Validator::make($request->all(),
            [
              'id'=>'required|numeric|exists:testimonials,id',
                'image'=>'required|mimes:jpeg',

            ]);
        if($validator->fails())
        {
            return response()->json(['status'=>102,'result'=>$validator->errors()]);
        }
        $page= new Testimonials();
        $id=$request->input('id');
        $page=$page->findByKey($id);
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            if (Commons::checkMime($file)) {
                $page->image = $this->processFile($file);
            } else {
                return response()->json(['error' => [
                    'status' => 100,
                    'description' => 'Bad Image Mime Type'
                ]]);
            }
        }
        $page->save();
        return response()->json(['status'=>200,'result'=>[],
            'message'=>'Successfull']);

    }
    public function deleteTestimonial(Request $request)
    {
        $validator= Validator::make($request->all(),
            [
                'id'=>'required|numeric|exists:testimonials,id',

            ]);
        if($validator->fails())
        {
            return response()->json(['status'=>102,'result'=>$validator->errors()]);
        }
        $userId=Users::getCreatorFromKey($request->input('syskey'));
        $page= new Testimonials();
        $id=$request->input('id');
        $page=$page->findByKey($id);
        if($page->created_by==$userId)
        $page->delete();
        else
        {
            return response()->json(['status'=>201,'result'=>[],
                'message'=>'Nothing Exist']);
        }
        return response()->json(['status'=>200,'result'=>[],
            'message'=>'Successfull']);

    }
    public function viewTestimonial(Request $request)
    {
        $validator= Validator::make($request->all(),
            [
                'id'=>'required|numeric|exists:testimonials,id',


            ]);
        if($validator->fails())
        {
            return response()->json(['status'=>102,'result'=>$validator->errors()]);
        }
        $userId=Users::getCreatorFromKey($request->input('syskey'));
        $id=$request->input('id');
        $page=Testimonials::where('created_by',$userId)->where('id',$id);
        $result=$page->get();
        $count=$page->count();
        return response()->json(['status'=>200,'result'=>['list'=>$result,'count'=>$count],
            'message'=>'Successfull']);

    }
    public function listTestimonials(Request $request)
    {

        $userId=Users::getCreatorFromKey($request->input('syskey'));
        $page=Testimonials::where('created_by',$userId);
        $result=$page->get();
        $count=$page->count();
        return response()->json(['status'=>200,'result'=>['list'=>$result,'count'=>$count],
            'message'=>'Successfull']);

    }
    public function viewRecentTestimonials(Request $request)
    {
        $validator= Validator::make($request->all(),
            [
                'offset'=>'numeric',


            ]);
        if($validator->fails())
        {
            return response()->json(['status'=>102,'result'=>$validator->errors()]);
        }
        $userId=Users::getCreatorFromKey($request->input('syskey'));
        $page= new Testimonials();
        $offset=$request->input('offset');
        $page=$page->identify($userId);
        $result=$page->orderBy('created_at', 'desc')->limit($offset)->get();
        $count=$page->get()->count();
        return response()->json(['status'=>200,'result'=>['list'=>$result,'count'=>$count],
            'message'=>'Successfull']);
    }
    public static function processFile($file)
    {
        $path='public/testimonials/';
        $name=uniqid();
        Storage::disk('local')->put($path.$name.'.'.'jpg',File::get($file));
        return $name;
    }
    public function checkForHidden($id)
    {
        if($id==' ' || $id==null || $id==0)
        {
            return 0;
        }
        else {
            return 1;

        }
    }
}

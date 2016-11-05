<?php

namespace App\Http\Controllers;

use App\model\JobsCampaign;
use App\model\OfferCampaign;
use Illuminate\Http\Request;
use App\model\Gallery;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests;
use App\model\Users;
use Illuminate\Support\Facades\Validator;

class Commons extends Controller
{
    public static function checkForEmpty($value)
    {
        if($value==' ' || $value==null || $value=='none' || $value=='')
        {
            return null;
        }
        else
        {
            return $value;
        }
    }

    public static function createGallery(Request $request)
    {
        $validator= Validator::make($request->all(),
            [
                'image'=>'mimes:jpeg',
                'image1'=>'mimes:jpeg',
                'image2'=>'mimes:jpeg',
                'image3'=>'mimes:jpeg',

            ]);
        if($validator->fails())
        {
            return response()->json(['status'=>102,'result'=>$validator->errors()]);
        }
        $i=0;
        $gallery=new Gallery();
        $userId=Users::getCreatorFromKey($request->input('syskey'));
        $gallery->created_by=$userId;
        switch($i)
        {
            case 0: if(!$request->hasFile('image')) {break;} ++$i;
                if(!$request->hasFile('image1')){break;} ++$i;
                if(!$request->hasFile('image2')){break;} ++$i;
                if(!$request->hasFile('image3')){break;} ++$i;
        }
        for($j=0;$j<$i;$j++)
        {
            switch($j)
            {
                case 0: $file=$request->file('image');
                    if(self::checkMime($file)){
                        $gallery->pic_name1=self::processFile($file);}
                        else
                        {
                            return response()->json(['error'=>[
                                'status'=>100,
                                'description'=>'Bad Image Mime Type'
                            ]]);
                        }
                    break;
                case 1: $file=$request->file('image1');
                    if(self::checkMime($file)){
                        $gallery->pic_name2=self::processFile($file);}
                    else
                    {
                        return response()->json(['error'=>[
                            'status'=>100,
                            'description'=>'Bad Image Mime Type'
                        ]]);
                    }
                    break;
                case 2: $file=$request->file('image2');
                    if(self::checkMime($file)){
                        $gallery->pic_name3=self::processFile($file);}
                    else
                    {
                        return response()->json(['error'=>[
                            'status'=>100,
                            'description'=>'Bad Image Mime Type'
                        ]]);
                    }
                    break;
                case 3: $file=$request->file('image3');
                    if(self::checkMime($file)){
                        $gallery->pic_name4=self::processFile($file);}
                    else
                    {
                        return response()->json(['error'=>[
                            'status'=>100,
                            'description'=>'Bad Image Mime Type'
                        ]]);
                    }
                    break;


            }
        }
        $gallery->save();
        return $gallery->id;

    }
    public static function updateGalleryBulk(Request $request,$creatorId)
    {
        $i=0;
        $gallery=new Gallery();
        $gallery->exists=true;
        $gallery=$gallery->find($request->input('id'));
        $gallery->created_by=$creatorId;
        $gallery->pic_name1=null;
        $gallery->pic_name2=null;
        $gallery->pic_name3=null;
        $gallery->pic_name4=null;

        switch($i)
        {
            case 0: if(!$request->hasFile('image')) {break;} ++$i;
                if(!$request->hasFile('image1')){break;} ++$i;
                if(!$request->hasFile('image2')){break;} ++$i;
                if(!$request->hasFile('image3')){break;} ++$i;
        }
        for($j=0;$j<$i;$j++)
        {
            switch($j)
            {
                case 0:
                    $file=$request->file('image');
                    if(self::checkMime($file)){
                        $gallery->pic_name1=self::processFile($file);}
                    else
                    {
                        return response()->json(['error'=>[
                            'status'=>100,
                            'description'=>'Bad Image Mime Type'
                        ]]);
                    }
                    $gallery->pic_name1=self::processFile($file);
                    break;
                case 1:
                    $file=$request->file('image1');
                    if(self::checkMime($file)){
                        $gallery->pic_name1=self::processFile($file);}
                    else
                    {
                        return response()->json(['error'=>[
                            'status'=>100,
                            'description'=>'Bad Image Mime Type'
                        ]]);
                    }
                    $gallery->pic_name2=self::processFile($file);
                    break;
                case 2:
                    $file=$request->file('image2');
                    if(self::checkMime($file)){
                        $gallery->pic_name1=self::processFile($file);}
                    else
                    {
                        return response()->json(['error'=>[
                            'status'=>100,
                            'description'=>'Bad Image Mime Type'
                        ]]);
                    }
                    $gallery->pic_name1=self::processFile($file);
                    break;
                case 3:
                    $file=$request->file('image3');
                    if(self::checkMime($file)){
                        $gallery->pic_name1=self::processFile($file);}
                    else
                    {
                        return response()->json(['error'=>[
                            'status'=>100,
                            'description'=>'Bad Image Mime Type'
                        ]]);
                    }
                    $gallery->pic_name1=self::processFile($file);
                    break;
            }
        }
        $gallery->save();

    }


    public static function updateGallery(Request $request)
    {
        $validator= Validator::make($request->all(),
            [
                'image'=>'mimes:jpeg|required_if:column,1',
                'image1'=>'mimes:jpeg|required_if:column,2',
                'image2'=>'mimes:jpeg|required_if:column,3',
                'image3'=>'mimes:jpeg|required_if:column,4',
                'column'=>'required|numeric|min:1|max:4',
                'id'=>'required|numeric|exists:gallery,id'

            ]);
        if($validator->fails())
        {
            return response()->json(['status'=>102,'result'=>$validator->errors()]);
        }

        $userId=Users::getCreatorFromKey($request->input('syskey'));
        $column=$request->input('column');
        $id=$request->input('id');
        $gallery=new Gallery();
        $gallery=$gallery->findByKey($id);
        $gallery->exists=true;
        if($gallery->created_by==$userId) {
            switch ($column) {
                case 1:if($request->hasFile('image'))
                {
                    $file=$request->file('image');
                    if(!self::checkMime($file))
                    {
                        return response()->json(['error'=>[
                            'status'=>100,
                            'description'=>'Bad Image Mime Type'
                        ]]);
                    }
                    if($gallery->pic_name1!=null)
                    {
                        self::deleteGalleryFile($gallery->pic_name1);
                    }
                    $gallery->pic_name1=self::processFile($file);
                    break;
                }
                case 2:if($request->hasFile('image1'))
                {

                    $file=$request->file('image1');
                    if(!self::checkMime($file))
                    {
                        return response()->json(['error'=>[
                            'status'=>100,
                            'description'=>'Bad Image Mime Type'
                        ]]);
                    }
                    if($gallery->pic_name2!=null)
                    {
                        self::deleteGalleryFile($gallery->pic_name2);
                    }
                    $gallery->pic_name2=self::processFile($file);
                    break;
                }
                case 3:if($request->hasFile('image2'))
                {
                    $file=$request->file('image2');
                    if(!self::checkMime($file))
                    {
                        return response()->json(['error'=>[
                            'status'=>100,
                            'description'=>'Bad Image Mime Type'
                        ]]);
                    }
                    if($gallery->pic_name3!=null)
                    {
                        self::deleteGalleryFile($gallery->pic_name3);
                    }
                    $gallery->pic_name3=self::processFile($file);
                    break;
                }
                case 4:if($request->hasFile('image3'))
                {
                    $file=$request->file('image3');
                    if(!self::checkMime($file))
                    {
                        return response()->json(['error'=>[
                            'status'=>100,
                            'description'=>'Bad Image Mime Type'
                        ]]);
                    }
                    if($gallery->pic_name4!=null)
                    {
                        self::deleteGalleryFile($gallery->pic_name4);
                    }
                    $gallery->pic_name4=self::processFile($file);
                    break;
                }
                default:
                    {
                    $gallery->pic_name1=null;
                    $gallery->pic_name2=null;
                    $gallery->pic_name3=null;
                    $gallery->pic_name4=null;
                    }
            }

            $gallery->save();
        }

        return response()->json(['status'=>200,'result'=>[],'message'=>'updated successfully']);
    }

    public static function processFile($file)
    {
        $path='public/gallery/';
        $name=uniqid();
        Storage::disk('local')->put($path.$name.'.'.'jpg',File::get($file));
        return $name;
    }
    public static function checkMime($file)
    {
        $extension = $file->getClientOriginalExtension();
        if((strcmp($extension,"jpeg") || strcmp($extension,"jpg") || strcmp($extension,"JPEG") || strcmp($extension,"JPG"))) return true;
        return false;

    }

    public static function deleteGallery(Request $request)
    {

        $validator= Validator::make($request->all(),
            [
                'id'=>'required|numeric|exists:gallery,id'

            ]);
        if($validator->fails())
        {
            return response()->json(['status'=>102,'result'=>$validator->errors()]);
        }

        $gallery=new Gallery();
        $userId=Users::getCreatorFromKey($request->input('syskey'));
        $gallery=$gallery->where('id','=',$request->input('id'))->where('created_by','=',$userId);
        $result=$gallery->first();
        if($gallery->count()==1)
        {
            self::deleteGalleryFiles($result);
        }

        return response()->json(['status'=>200,'result'=>[],'message'=>'deleted successfully']);
    }

    public static function deleteGalleryFile($picname)
    {
        $path='public/gallery/';
        if(Storage::disk('local')->has($path.$picname.'.jpg'))
        {
            Storage::disk('local')->delete($path.$picname.'.jpg');
            echo "true";
        }
    }

    public static function deleteGalleryFiles(Gallery $gallery)
    {
        $path='public/gallery/';
        if($gallery->pic_name1!=null) {
            if(Storage::disk('local')->has($path.$gallery->pic_name1.'.jpg'))
            {
                Storage::disk('local')->delete($path.$gallery->pic_name1.'.jpg');
                echo "true";
            }
        }
        if($gallery->pic_name2!=null) {
            if(Storage::disk('local')->has($path.$gallery->pic_name2.'.jpg'))
            {
                Storage::disk('local')->delete($path.$gallery->pic_name2.'.jpg');
            }
        }
        if($gallery->pic_name3!=null) {
            if(Storage::disk('local')->has($path.$gallery->pic_name3.'.jpg'))
            {
                Storage::disk('local')->delete($path.$gallery->pic_name3.'.jpg');
            }
        }
        if($gallery->pic_name4!=null) {
            if(Storage::disk('local')->has($path.$gallery->pic_name4.'.jpg'))
            {
                Storage::disk('local')->delete($path.$gallery->pic_name4.'.jpg');
            }
        }
    }

}

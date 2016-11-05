<?php

namespace App\Http\Controllers;
use App\model\page;
use App\model\Users;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class MobileView extends Controller
{
    public function createView(Request $request)
    {
        $page= new page();
        $page->createdBy=Users::getCreatorFromKey($request->input('syskey'));
        $page->base_title=$request->input('maintitle');
        $page->offer_title=$request->input('offertitle');
        $page->offer_title=$request->input('offerdesc');
        $page->group_id=null;
        $page->gallery_id=$this->createGallery($request);
        $page->feature_id=$this->createFeatures($request);
        $page->date= new \DateTime();
        $page->save();
    }
    public function createGallery(Request $request)
    {

        $i=0;
            switch($i)
            {
                case 0: if(!$request->hasFile('image')){ break;} ++$i;
                        if(!$request->hasFile('image1')){break;}++$i;
                        if(!$request->hasFile('image2')){break;} ++$i;
                        if(!$request->hasFile('image3')){break;} ++$i;

            }
        for($j=0;$j<$i;$j++)
        {
            switch($j)
            {
                case 0: $file=$request->file('image');$this->processFile($file,$j);break;
                case 1: $file=$request->file('image1');$this->processFile($file,$j);break;
                case 2: $file=$request->file('image2');$this->processFile($file,$j);break;
                case 3: $file=$request->file('image3');$this->processFile($file,$j);break;
            }
        }

    }
    public function processFile($file,$count)
    {
        $extension = $file->getClientOriginalExtension();
        $path='public/gallery/';
        Storage::disk('local')->put($path.uniqid().'.'.$extension,File::get($file));
    }

    public function imageTransformer($actual_width,$actual_height,$width,$height)
    {
        $aspect_ratio=0.0;
        $target_width=0.0;$target_height=0.0;
        if($actual_width>$actual_height)
        {
            $target_width=$width;
            $aspect_ratio=$actual_height/$actual_width;
            $target_height=$actual_height*$aspect_ratio;
        }
        else
        {
            $target_height=$height;
            $aspect_ratio=$actual_width/$actual_height;
            $target_width=$aspect_ratio*$actual_width;
        }
        return [$target_width,$target_height];
    }
}

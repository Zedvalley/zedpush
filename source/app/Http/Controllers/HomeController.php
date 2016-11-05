<?php

namespace App\Http\Controllers;

use App\model\Gallery;
use App\model\Home;
use Illuminate\Http\Request;

use App\Http\Requests;

class HomeController extends Controller
{
    public function setLogoTitle(Request $request)
    {
        $userId=Users::getCreatorFromKey($request->input('syskey'));
        $page= new Home();
        $page=$page->findByUserId($userId);
        if($page->created_by==$userId)
        {
            $page->logo_title=Commons::createGallery($request);
            $page->save();
        }
    }
    public static function initialize($userId)
    {
        $page=new Home();
        $page->created_by=$userId;
        $page->gallery_id=Gallery::initializeHome();
        $page->save();
    }
    public function setGallery(Request $request)
    {
        $userId=Users::getCreatorFromKey($request->input('syskey'));
        $page= new Home();
        $page=$page->findByUserId($userId);
        if($page->created_by==$userId)
        {
            $page->galler_id=Commons::createGallery($request);
            $page->save();
        }

    }
    public function updateTag(Request $request)
    {
        $userId=Users::getCreatorFromKey($request->input('syskey'));
        $page= new Home();
        $tag=$request->input('tag');
        $page=$page->findByUserId($userId);
        if($page->created_by==$userId)
        {
            $page->sector_tag=Commons::checkForEmpty($tag);
            $page->save();
        }
    }
    public function updateAboutUs(Request $request)
    {
        $userId=Users::getCreatorFromKey($request->input('syskey'));
        $page= new Home();
        $text=$request->input('text');
        $page=$page->findByUserId($userId);
        if($page->created_by==$userId)
        {
            $page->about_us=Commons::checkForEmpty($text);
            $page->save();
        }
    }
    public function updateEmail(Request $request)
    {
        $userId=Users::getCreatorFromKey($request->input('syskey'));
        $page= new Home();
        $text=$request->input('text');
        $page=$page->findByUserId($userId);
        if($page->created_by==$userId)
        {
            $page->email=Commons::checkForEmpty($text);
            $page->save();
        }

    }
    public function updateAddress(Request $request)
    {
        $userId=Users::getCreatorFromKey($request->input('syskey'));
        $page= new Home();
        $text=$request->input('text');
        $page=$page->findByUserId($userId);
        if($page->created_by==$userId)
        {
            $page->address=Commons::checkForEmpty($text);
            $page->save();
        }

    }

    public function updateContact(Request $request)
    {
        $userId=Users::getCreatorFromKey($request->input('syskey'));
        $page= new Home();
        $text=$request->input('text');
        $page=$page->findByUserId($userId);
        if($page->created_by==$userId)
        {
            $page->contact=Commons::checkForEmpty($text);
            $page->save();
        }

    }

}

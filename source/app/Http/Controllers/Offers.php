<?php

namespace App\Http\Controllers;

use App\model\Gallery;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\model\OfferCampaign;
use App\model\Users;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;


class Offers extends Controller
{
    public $slug=null;

    public function __construct()
    {
        $this->middleware('AuthApi');
    }

    public function updateOffer(Request $request)
    {
        $validator= Validator::make($request->all(),
            [
                'offertitle'=>'required|max:700',
                'offerdesc'=>'max:5000',
                'offerprice'=>'max:100',
                'contact'=>'max:14',
                'expires_on'=>'date',
                'id'=>'exist:offer_campaign,id'
            ]);
        if($validator->fails())
        {
            return response()->json(['status'=>102,'result'=>$validator->errors()]);
        }

        $user_id=Users::getCreatorFromKey($request->input('syskey'));
        $page= new OfferCampaign();
        $page=$page->findByKey($request->input('id'));
        $page->exists=true;
        //$page->base_title=Commons::checkForEmpty($request->input('maintitle'));
        $page->offer_title=Commons::checkForEmpty($request->input('offertitle'));
        $page->offer_description=Commons::checkForEmpty($request->input('offerdesc'));
        $page->offer_price=Commons::checkForEmpty($request->input('offerprice'));
        $page->expires_on=new \DateTime();
        $page->contact_no='9947313547';
        $page->updated_at=new \DateTime();
        if($page->created_by==$user_id) {
            $page->save();
            return response()->json(['status' => 200, 'result' => [], 'message' => 'Offer Updated Successfully']);
        }
        else
        {
            return response()->json(['status' => 201, 'result' => [], 'message' => 'Nothing Exist']);
        }

    }
    public function processSlug($usedId,$content)
    {

        if(OfferCampaign::checkSlug($usedId,$content))
        {
            $this->slug=$content;
        }
        else{
            $random=rand(1,999);
            $content.='-'.strval($random);
            $this->processSlug($usedId,$content);
        }
    }

    public function createOffer(Request $request)
    {
        $validator= Validator::make($request->all(),
            [
                'maintitle'=>'required|max:200',
                'offertitle'=>'required|max:700',
                'offerdesc'=>'max:5000',
                'offerprice'=>'max:100',
                'contact'=>'max:14',
                'expires_on'=>'date'

            ]);
        if($validator->fails())
        {
            return response()->json(['status'=>102,'result'=>$validator->errors()]);
        }

        $page= new OfferCampaign();
        $page->created_by=Users::getCreatorFromKey($request->input('syskey'));
        $page->base_title=Commons::checkForEmpty($request->input('maintitle'));
        $page->offer_title=Commons::checkForEmpty($request->input('offertitle'));
        $page->offer_description=Commons::checkForEmpty($request->input('offerdesc'));
        $page->offer_price=Commons::checkForEmpty($request->input('offerprice'));
        $page->expires_on=new \DateTime();
        $page->contact_no='9947313547';
        $page->created_at=new \DateTime();
        $page->gallery_id=4;
        $this->processSlug($page->created_by,str_slug($page->offer_title,'-'));
        $page->slug=$this->slug;
        //$page->gallery_id=Commons::createGallery($request); update on deploymment
        $page->save();
        return response()->json(['status'=>200,'result'=>[],'message'=>'Offer Created Successfully',]);
    }
    public function updateView(Request $request)
    {
        $validator= Validator::make($request->all(),
            [
                'id'=>'required|numeric|exists:offer_campaign,id'
            ],
            [
                'exists'=>'Invalid ID Provided'
            ]);
        if($validator->fails())
        {
            return response()->json(['status'=>102,'result'=>$validator->errors()]);
        }
        $page= new OfferCampaign();
        $page=$page->findByKey($request->input('id'));
        $page->exists=true;
        $page->views+=1;
        $page->save();
        return response()->json(['status'=>200,'result'=>['message'=>'View Updated Successfully']]);
    }

    public function addGalleryId(Request $request)//used when gallery created late
    {
        $user_id=Users::getCreatorFromKey($request->input('syskey'));
        $validator= Validator::make($request->all(),
            [
                'id'=>'required|numeric|exists:offer_campaign,id'
            ],
            [
                'exists'=>'Invalid ID Provided'
            ]);
        if($validator->fails())
        {
            return response()->json(['status'=>102,'result'=>$validator->errors()]);
        }
        $page= new OfferCampaign();
        $page=$page->findByKey($request->input('id'));
        $page->exists=true;
        $gal=Commons::createGallery($request);
        if(is_object($gal))
        {
            return $gal;
        }
        $page->gallery_id = $gal;
        if($page->created_by==$user_id) {
            $page->save();
            return response()->json(['status' => 200, 'result' => [], 'message' => 'Gallery Updated Successfully']);
        }
        else
        {
            return response()->json(['status' => 201, 'result' => [], 'message' => 'Nothing Exist']);
        }
    }

    public function deleteOffer(Request $request)
    {
        $userId=Users::getCreatorFromKey($request->input('syskey'));
        $validator= Validator::make($request->all(),
            [
                'id'=>'required|numeric|exists:offer_campaign,id'
            ],
            [
                'exists'=>'Invalid ID Provided'
            ]);
        if($validator->fails())
        {
            return response()->json(['status'=>102,'result'=>$validator->errors()]);
        }
        $offerId=$request->input('id');
        $page=new OfferCampaign();
        $page->exists=true;
        $page = $page->where('id','=',$offerId)->where('created_by','=',$userId)->first();
        $page->delete();
        /*$gallery=new Gallery();
        $galleryId=$page->gallery_id;
        $gallery=$gallery->where('id','=',$galleryId)->first();
        $affectedRows+=$gallery->delete();
        echo $gallery->pic_name1;
        Commons::deleteGalleryFiles($gallery);*/
        return response()->json(['status'=>200,'result'=>['deleted_id'=>$page->id],'message'=>'Offer Deleted Successfully',]);

    }
    public function totalOffers(Request $request)
    {
        $userId=Users::getCreatorFromKey($request->input('syskey'));
        $count= OfferCampaign::where('created_by',$userId)->count();
        return response()->json(['status'=>200,'result'=>['count'=>$count],
            'message'=>'Successfull']);
    }

    public function getOfferDetails(Request $request)
    {
        $validator= Validator::make($request->all(),
            [
                'id'=>'required|numeric|exists:offer_campaign,id'
            ],
            [
                'exists'=>'Invalid ID Provided'
            ]);
        if($validator->fails())
        {
            return response()->json(['status'=>102,'result'=>$validator->errors()]);
        }
        $userId=Users::getCreatorFromKey($request->input('syskey'));
        $offers=DB::table('offer_campaign')->leftJoin('gallery','offer_campaign.gallery_id','=','gallery.id')
            ->where('offer_campaign.id', $request->input('id'))
            ->where('offer_campaign.created_by', $userId)
            ->select('offer_campaign.*','gallery.pic_name1','gallery.pic_name2','gallery.pic_name3','gallery.pic_name4')
            ->first();
        return response()->json(['status'=>200,'result'=>['details'=>$offers],
            'message'=>'Successfull']);
    }

    public function getAllOfferByUsersByLimit(Request $request)
    {
        $validator= Validator::make($request->all(),
            [
                'offset'=>'required|numeric',
                'limit'=>'required|numeric'
            ]
          );
        if($validator->fails())
        {
            return response()->json(['status'=>102,'result'=>$validator->errors()]);
        }

        $offset=$request->input('offset');
        $limit=$request->input('limit');
        $userId=Users::getCreatorFromKey($request->input('syskey'));
        $offerList=DB::table('offer_campaign')->leftJoin('gallery','offer_campaign.gallery_id','=','gallery.id')
            ->select('offer_campaign.id','offer_campaign.base_title','offer_campaign.views','gallery.pic_name1','offer_campaign.created_at','offer_campaign.updated_at')
            ->where('offer_campaign.created_by', '=', $userId)
            ->offset($offset)
            ->limit($limit)
            ->get();
        return response()->json(['status'=>200,'result'=>['list'=>$offerList],
            'message'=>'Successfull']);
    }
    public function getAllOfferByUser(Request $request)
    {
        $userId=Users::getCreatorFromKey($request->input('syskey'));
        $offerList=DB::table('offer_campaign')
            ->where('offer_campaign.created_by', '=',$userId)
            ->leftJoin('gallery','offer_campaign.gallery_id','=','gallery.id')
            ->select('offer_campaign.id','offer_campaign.base_title','offer_campaign.views','gallery.pic_name1','offer_campaign.created_at','offer_campaign.updated_at')
            ->get();
        return response()->json(['status'=>200,'result'=>['list'=>$offerList],
            'message'=>'Successfull']);

    }
    public function campaignStat(Request $request)
    {
        $userId=Users::getCreatorFromKey($request->input('syskey'));
        $campaignStat=DB::table('offer_campaign')->select('id','base_title','views','created_at','updated_at')
                        ->where('created_by', '=', $userId)->get();
        return response()->json(['status'=>200,'result'=>['status'=>$campaignStat],
            'message'=>'Successfull']);

    }

}

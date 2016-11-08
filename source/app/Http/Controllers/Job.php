<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\model\Users;
use Illuminate\Support\Facades\DB;
use App\model\Gallery;
use App\model\JobsCampaign;
use Illuminate\Support\Facades\Validator;

use App\Http\Requests;

class Job extends Controller
{
    public function __construct()
    {
        $this->middleware('AuthApi');
    }

    public $slug=null;
    public function updateJob(Request $request)
    {
        $validator= Validator::make($request->all(),
            [
                'jobtitle'=>'required|max:700',
                'jobdesc'=>'max:5000',
                'jobprice'=>'max:100',
                'contact'=>'max:14',
                'expires_on'=>'date',
                'id'=>'required|exists:jobs_campaign,id'
            ]);
        if($validator->fails())
        {
            return response()->json(['status'=>102,'result'=>$validator->errors()]);
        }

        $user_id=Users::getCreatorFromKey($request->input('syskey'));
        $page= new JobsCampaign();
        $page=$page->findByKey($request->input('id'));
        $page->exists=true;
        $page->job_title=$request->input('jobtitle');
        $page->job_description=Commons::checkForEmpty($request->input('jobdesc'));
        $page->salary=Commons::checkForEmpty($request->input('jobprice'));
        $page->contact_no='9947313547';
        $page->updated_at=new \DateTime();
        if($page->created_by==$user_id) {
            $page->save();
            return response()->json(['status' => 200, 'result' => [], 'message' => 'Job Updated Successfully']);
        }
        else
        {
            return response()->json(['status' => 201, 'result' => [], 'message' => 'Nothing Exist']);
        }
    }
    public function processSlug($usedId,$content)
    {

        if(JobsCampaign::checkSlug($usedId,$content))
        {
           $this->slug=$content;
        }
        else{
            $random=rand(1,999);
            $content.='-'.strval($random);
            $this->processSlug($usedId,$content);
        }
    }

    public function createJob(Request $request)
    {
        $validator= Validator::make($request->all(),
            [
                'jobtitle'=>'required|max:700',
                'maintitle'=>'required|max:300',
                'jobdesc'=>'max:5000',
                'jobprice'=>'max:100',
                'contact'=>'max:14',
                'expires_on'=>'date',
            ]);
        if($validator->fails())
        {
            return response()->json(['status'=>102,'result'=>$validator->errors()]);
        }

        $page= new JobsCampaign();
        $page->created_by=Users::getCreatorFromKey($request->input('syskey'));
        $page->base_title=$request->input('maintitle');
        $page->job_title=$request->input('jobtitle');
        $page->job_description=Commons::checkForEmpty($request->input('jobdesc'));
        $page->salary=Commons::checkForEmpty($request->input('jobprice'));
        $page->contact_no='9947313547';
        $page->created_at=new \DateTime();
        $page->gallery_id=4;
        $this->processSlug($page->created_by,str_slug($page->job_title,'-'));
        $page->slug=$this->slug;
        //$page->gallery_id=Commons::createGallery($request);
        $page->save();
        return response()->json(['status'=>200,'result'=>[],'message'=>'Job Created Successfully',]);
    }
    public function updateView(Request $request)
    {
        $validator= Validator::make($request->all(),
            [
                'id'=>'required|numeric|exists:jobs_campaign,id'
            ],
            [
                'exists'=>'Invalid ID Provided'
            ]);
        if($validator->fails())
        {
            return response()->json(['status'=>102,'result'=>$validator->errors()]);
        }

        $page= new JobsCampaign();
        $page=$page->findByKey($request->input('id'));
        $page->exists=true;
        $page->views+=1;
        $page->save();
        return response()->json(['status'=>200,'result'=>['message'=>'View Updated Successfully']]);
    }

    public function updateGalleryId(Request $request)
    {


        $user_id=Users::getCreatorFromKey($request->input('syskey'));
        $validator= Validator::make($request->all(),
            [
                'id'=>'required|numeric|exists:jobs_campaign,id'
            ],
            [
                'exists'=>'Invalid ID Provided'
            ]);
        if($validator->fails())
        {
            return response()->json(['status'=>102,'result'=>$validator->errors()]);
        }
        $page= new JobsCampaign();
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

    public function deleteJob(Request $request)
    {
        $validator= Validator::make($request->all(),
            [
                'id'=>'required|numeric|exists:jobs_campaign,id'
            ],
            [
                'exists'=>'Invalid ID Provided'
            ]);
        if($validator->fails())
        {
            return response()->json(['status'=>102,'result'=>$validator->errors()]);
        }
        $userId=Users::getCreatorFromKey($request->input('syskey'));
        $jobId=$request->input('id');
        $page=new JobsCampaign();
        $page->exists=true;
        $page = $page->where('id','=',$jobId)->where('created_by','=',$userId)->first();
        $affectedRows=$page->delete();
        /*$gallery=new Gallery();
        $galleryId=$page->gallery_id;
        $gallery=$gallery->where('id','=',$galleryId)->first();
        $affectedRows+=$gallery->delete();
        echo $gallery->pic_name1;
        Commons::deleteGalleryFiles($gallery);*/
        return response()->json(['status'=>200,'result'=>['deleted_id'=>$page->id],'message'=>'Jobs Deleted Successfully',]);

    }
    public function totalJob(Request $request)
    {
        $userId=Users::getCreatorFromKey($request->input('syskey'));
        $count= JobsCampaign::where('created_by',$userId)->count();
        return response()->json(['status'=>200,'result'=>['count'=>$count],
            'message'=>'Successfull']);
    }

    public function getJobDetails(Request $request)
    {
        $validator= Validator::make($request->all(),
            [
                'id'=>'required|numeric|exists:jobs_campaign,id'
            ],
            [
                'exists'=>'Invalid ID Provided'
            ]);
        if($validator->fails())
        {
            return response()->json(['status'=>102,'result'=>$validator->errors()]);
        }

        $jobs=DB::table('jobs_campaign')->leftJoin('gallery','jobs_campaign.gallery_id','=','gallery.id')
            ->where('jobs_campaign.id', $request->input('id'))
            ->select('jobs_campaign.*','gallery.pic_name1','gallery.pic_name2','gallery.pic_name3','gallery.pic_name4')
            ->first();
        return response()->json([$jobs]);
    }

    public function getAllJobByUsersByLimit(Request $request,$Offset=0)
    {
        $offset=$request->input('offset');
        $limit=$request->input('limit');
        $userId=Users::getCreatorFromKey($request->input('syskey'));
        $jobList=DB::table('jobs_campaign')->leftJoin('gallery','jobs_campaign.gallery_id','=','gallery.id')
            ->select('jobs_campaign.id','jobs_campaign.base_title','jobs_campaign.views','gallery.pic_name1','jobs_campaign.created_at','jobs_campaign.updated_at')
            ->where('jobs_campaign.created_by', '=', $userId)
            ->offset($offset)
            ->limit($limit)
            ->get();
        return response()->json(['status'=>200,'result'=>['list'=>$jobList],
            'message'=>'Successfull']);
    }
    public function getAllJobByUser(Request $request)
    {
        $userId=Users::getCreatorFromKey($request->input('syskey'));
        $jobList=DB::table('jobs_campaign')
            ->where('jobs_campaign.created_by', '=',$userId)
            ->leftJoin('gallery','jobs_campaign.gallery_id','=','gallery.id')
            ->select('jobs_campaign.id','jobs_campaign.base_title','jobs_campaign.views','gallery.pic_name1','jobs_campaign.created_at','jobs_campaign.updated_at')
            ->get();
        return response()->json(['status'=>200,'result'=>['list'=>$jobList],
            'message'=>'Successfull']);

    }
    public function campaignStat(Request $request)
    {
        $userId=Users::getCreatorFromKey($request->input('syskey'));
        $campaignStat=DB::table('jobs_campaign')->select('id','base_title','views','created_at','updated_at')
            ->where('created_by', '=', $userId)->get();
        return response()->json(['status'=>200,'result'=>['status'=>$campaignStat],
            'message'=>'Successfull']);

    }


}

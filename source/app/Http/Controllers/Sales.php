<?php

namespace App\Http\Controllers;

use App\model\ProductCategory;
use App\model\SalesCampaign;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\model\Users;
use Illuminate\Support\Facades\DB;
use App\model\Gallery;
use Illuminate\Support\Facades\Validator;


class Sales extends Controller
{
    public $slug=null;
    public function test(Request $request)
    {

    }
    public function createCategory(Request $request)
    {
        $validator= Validator::make($request->all(),[
            'catname'=>'required',
            'parent'=>'numeric'
        ]);
        if($validator->fails())
        {
            return response()->json(['status'=>102,'result'=>$validator->errors()]);
        }
        $catBuild=new ProductCategory();
        $catBuild->created_by=Users::getCreatorFromKey($request->input('syskey'));
        $catBuild->category_name=$request->input('catname');
        $catBuild->parent_id = Commons::checkForEmpty($request->input('parent'));
        $catBuild->created_on=new \DateTime();
        $this->processCategorySlug($catBuild->created_by,str_slug($catBuild->category_name,'-'));
        $catBuild->slug=$this->slug;
        $catBuild->save();
        return response()->json(['status'=>200,'result'=>[],'message'=>'Category Created Successfully',]);

    }
     public function processSlug($usedId,$content)
    {

        if(SalesCampaign::checkSlug($usedId,$content))
        {
            $this->slug=$content;
        }
        else{
            $random=rand(1,999);
            $content.='-'.strval($random);
            $this->processSlug($usedId,$content);
        }
    }
    public function processCategorySlug($usedId,$content)
    {

        if(ProductCategory::checkSlug($usedId,$content))
        {
            $this->slug=$content;
        }
        else{
            $random=rand(0,20);
            $content.='-'.strval($random);
            $this->processSlug($usedId,$content);
        }
    }

    public function updateCategory(Request $request)
    {
        $validator= Validator::make($request->all(),[
            'id'=>'bail|required|numeric|exists:product_category,id',
            'catname'=>'required',
            'parent'=>'required'
        ]);
        if($validator->fails())
        {
            return response()->json(['status'=>102,'result'=>$validator->errors()]);
        }
        $catBuild=new ProductCategory();
        $catId=$request->input('id');
        $userId=Users::getCreatorFromKey($request->input('syskey'));
        $catBuild=$catBuild->findByKey($catId);
        if($catBuild->created_by==$userId) {
            $catBuild->category_name = $request->input('catname');
            $catBuild->parent_id =Commons::checkForEmpty($request->input('parent'));
            $catBuild->save();
            return response()->json(['status'=>200,'result'=>[],'message'=>'Category Updated Successfully']);
        }

        return response()->json(['status'=>201,'result'=>[],'message'=>'Nothing Found',]);

    }
    public function deleteCategory(Request $request)
    {
        $validator= Validator::make($request->all(),[
            'id'=>'bail|required|numeric|exists:product_category,id',
        ]);
        if($validator->fails())
        {
            return response()->json(['status'=>102,'result'=>$validator->errors()]);
        }
        $catBuild=new ProductCategory();
        $affectedRows=0;
        $catId=$request->input('id');
        $userId=Users::getCreatorFromKey($request->input('syskey'));
        $catBuild=$catBuild->findByKey($catId);
        if($this->catDependencyCheck($catId) && ($catBuild->created_by==$userId))
        {
            $affectedRows=$catBuild->delete();
            return response()->json(
                ['status'=>'200','result'=>'','message'=>'Category Deleted Successfully']);

        }
        else
        {
            return response()->json(
                ['status'=>'200','result'=>'','message'=>'Link with products exist']);

        }
    }
    public function deepCatDelete(Request $request)
    {
        $validator= Validator::make($request->all(),[
            'id'=>'bail|required|numeric|exists:product_category,id',
        ]);
        if($validator->fails())
        {
            return response()->json(['status'=>102,'result'=>$validator->errors()]);
        }

        $catId=$request->input('id');
        $affectedResult=null;
        $userId=Users::getCreatorFromKey($request->input('syskey'));
        $this->recursiveDelete($catId,$userId);
        $salesSet=SalesCampaign::where('cat_id',$catId)->where('created_by',$userId);
        if($salesSet->count()>0)
        {
            $salesSet->delete();
        }
        ProductCategory::where('id',$catId)->where('created_by',$userId)->delete();
        return response()->json(['status'=>200,'result'=>[],'message'=>'Category Deleted Successfully',]);

    }
    public function recursiveDelete($catId,$userId) //do check after sales insert
    {
        $affectedCategories = 0;
        $affectedSales = 0;
        $resultList = ProductCategory::where('parent_id', $catId)->where('created_by', $userId);
        if ($resultList->count() > 0) {
            foreach ($resultList->cursor() as $result) {
                if (ProductCategory::where('parent_id', $result->id)->where('created_by', $userId)->count() > 0) {
                    $this->recursiveDelete($result->id, $userId);
                    $newResult = SalesCampaign::where('cat_id', $result->id)->where('created_by', $userId);
                    if ($newResult->count() > 0) {
                        $affectedSales += $newResult->delete();
                    }
                } else {
                    $affectedSales = DB::table('sales_campaign')->where('cat_id', $result->id)->delete();
                }
                $affectedCategories += $result->delete();
            }
        }
       // echo 'sdsdsds'.$affectedCategories.'sdsdsd';echo 'ydsdsds'.$affectedSales.'ydsdsd';
    }
    public function catDependencyCheck($id)
    {
        $catBuild=new ProductCategory();
        $flag=true;
        $catBuild=$catBuild->findByKey($id);
        if($catBuild->parent_id!=null)
        {
            $flag=false;
        }
        $catBuild=$catBuild->where('parent_id',$id)->get();
        if($catBuild->count()>0)
        {
            $flag=false;
        }
        return $flag;
    }
    public function listBaseCategory(Request $request)
    {

        $userId=Users::getCreatorFromKey($request->input('syskey'));
        if(ProductCategory::where('created_by',$userId)->count()>0) {
            $catList = DB::table('product_category')
                ->where('created_by', '=', $userId)
                ->where('parent_id', null)
                ->select('id', 'category_name', 'created_on')
                ->get();
            return response()->json(['status'=>200,'result'=>[
                'type'=>'categories',
                'list'=>$catList
            ],'message'=>'Listed Successfully',]);
        }
        else
        {
            $result=$this->getAllSalesByUser($userId,null);
            return response()->json(['status'=>200,'result'=>[
                'type'=>'products',
                'list'=>$result
            ],'message'=>'Listed Successfully',]);
        }
        }

    public function nextPage(Request $request)// check this after inserting sales
    {
        $validator= Validator::make($request->all(),[
            'id'=>'bail|required|numeric',
        ]);
        if($validator->fails())
        {
            return response()->json(['status'=>102,'result'=>$validator->errors()]);
        }
        $selectedId=$request->input('id');
        $userId=Users::getCreatorFromKey($request->input('syskey'));
        $resultSet=null;
        $flag=0;
        $productCategory=new ProductCategory();
        if($productCategory->childExist($selectedId)>0)//checking child count
        {
            $flag=1;
            $resultSet=$productCategory->allChild($selectedId);
        }
        if($flag==1)
        {

            return response()->json(['status'=>200,'result'=>[
                'type'=>'categories',
                'list'=>$resultSet
            ],'message'=>'Categories Listed Successully',]);

        }
        else
        {
            if(SalesCampaign::where('cat_id',$selectedId)->where('created_by',$userId)->count()>0)
            {
                $result=$this->getAllSalesByUser($userId,$selectedId);
                return response()->json(['status'=>200,'result'=>[
                    'type'=>'products',
                    'list'=>$result
                ],'message'=>'Products Listed Successfully',]);

            }
            return response()->json(['status'=>211,'result'=>[
            ],'message'=>'Nothing Found',]);

        }

    }
    public function totalProducts(Request $request)// check this after inserting sales
    {
        $userId=Users::getCreatorFromKey($request->input('syskey'));
        $count= SalesCampaign::where('created_by',$userId)->count();
        return response()->json(['status'=>200,'result'=>[
            'count'=>$count
        ],'message'=>'Successfull',]);
    }
    public function totalCategories(Request $request)
    {
        $userId=Users::getCreatorFromKey($request->input('syskey'));
        $count=ProductCategory::where('created_by',$userId)->where('parent_id',null)->count();
        return response()->json(['status'=>200,'result'=>[
            'count'=>$count
        ],'message'=>'Successfull',]);

    }
    /********************************************category ends here****************************************/
    public function updateSales(Request $request)
    {
        $validator= Validator::make($request->all(),
            [

                'salestitle'=>'required|max:700',
                'salesdesc'=>'max:5000',
                'salesprice'=>'max:100',
                'contact'=>'max:14',
                'id'=>'required|numeric|exists:sales_campaign,id'

            ]);
        if($validator->fails())
        {
            return response()->json(['status'=>102,'result'=>$validator->errors()]);
        }

        $page= new SalesCampaign();
        $userId=Users::getCreatorFromKey($request->input('syskey'));
        $page=$page->findByKey($request->input('id'));
        $page->exists=true;
        //$page->base_title=Commons::checkForEmpty($request->input('maintitle'));
        $page->sales_title=Commons::checkForEmpty($request->input('salestitle'));
        $page->sales_description=Commons::checkForEmpty($request->input('salesdesc'));
        $page->sales_price=Commons::checkForEmpty($request->input('salesprice'));
        $page->cat_id=null;//change after
        $page->contact_no='9947313547';//change after
        $page->updated_at=new \DateTime();
        if($page->created_by==$userId) {
            $page->save();
            return response()->json(['status' => 200, 'result' => [], 'message' => 'Sales Updated Successfully']);
        }
        else
        {
            return response()->json(['status' => 201, 'result' => [], 'message' => 'Nothing Exist']);
        }


    }

    public function createSales(Request $request)
    {

        $validator= Validator::make($request->all(),
            [
                'maintitle'=>'required|max:200',
                'salestitle'=>'required|max:700',
                'salesdesc'=>'max:5000',
                'salesprice'=>'max:100',
                'contact'=>'max:14',


            ]);
        if($validator->fails())
        {
            return response()->json(['status'=>102,'result'=>$validator->errors()]);
        }

        $page= new SalesCampaign();
        $page->created_by=Users::getCreatorFromKey($request->input('syskey'));
        $page->base_title=$request->input('maintitle');
        $page->sales_title=$request->input('salestitle');
        $page->sales_description=Commons::checkForEmpty($request->input('salesdesc'));
        $page->sales_price=Commons::checkForEmpty($request->input('salesprice'));
        $page->cat_id=32;
        $page->showonlist=1;
        $page->contact_no='9947313547';
        $page->created_at=new \DateTime();
        $page->gallery_id=4;
        $this->processSlug($page->created_by,str_slug($page->sales_title,'-'));
        $page->slug=$this->slug;
        //$page->gallery_id=Commons::createGallery($request);
        $page->save();
        return response()->json(['status' => 200, 'result' => [], 'message' => 'Successfull']);

    }
    public function updateView(Request $request)
    {
        $validator= Validator::make($request->all(),
            [
                'id'=>'required|numeric|exists:sales_campaign,id'
            ],
            [
                'exists'=>'Invalid ID Provided'
            ]);
        if($validator->fails())
        {
            return response()->json(['status'=>102,'result'=>$validator->errors()]);
        }

        $userId=Users::getCreatorFromKey($request->input('syskey'));
        $page= new SalesCampaign();
        $page=$page->findByKey($request->input('id'));
        if($userId==$page->created_by) {
            $page->exists = true;
            $page->views += 1;
            $page->save();
            return response()->json(['status' => 200, 'result' => [], 'message' => 'Views Updated Successfully']);
        }
        else
        {
            return response()->json(['status' => 201, 'result' => [], 'message' => 'Nothing Exist']);
        }
    }

    public function updateGalleryId(Request $request)//used when gallery setup on next page
    {
        $validator= Validator::make($request->all(),
            [
                'id'=>'required|numeric|exists:sales_campaign,id'
            ],
            [
                'exists'=>'Invalid ID Provided'
            ]);
        if($validator->fails())
        {
            return response()->json(['status'=>102,'result'=>$validator->errors()]);
        }

        $userId=Users::getCreatorFromKey($request->input('syskey'));
        $page= new SalesCampaign();
        $page=$page->findByKey($request->input('id'));
        if($userId==$page->created_by) {
            $page->exists = true;
            $gal=Commons::createGallery($request);
                if(is_object($gal))
                {
                    return $gal;
                }
            $page->gallery_id = Commons::createGallery($request);
            $page->save();
            return response()->json(['status' => 200, 'result' => [], 'message' => 'Gallery Updated Successfully']);
        }
        return response()->json(['status' => 201, 'result' => [], 'message' => 'Nothing Exist']);
    }

    public function deleteSales(Request $request)
    {
        $validator= Validator::make($request->all(),
            [
                'id'=>'required|numeric|exists:sales_campaign,id'
            ],
            [
                'exists'=>'Invalid ID Provided'
            ]);
        if($validator->fails())
        {
            return response()->json(['status'=>102,'result'=>$validator->errors()]);
        }
        $userId=Users::getCreatorFromKey($request->input('syskey'));
        $salesId=$request->input('id');
        $page=new SalesCampaign();
        $page->exists=true;
        $page = $page->where('id','=',$salesId)->where('created_by','=',$userId);
        if($page->count()>0) {
            $affectedRows = $page->delete();
            /*$gallery=new Gallery();
            $galleryId=$page->gallery_id;
            $gallery=$gallery->where('id','=',$galleryId)->first();
            $affectedRows+=$gallery->delete();
            echo $gallery->pic_name1;
            Commons::deleteGalleryFiles($gallery);*/
            return response()->json(['status' => 200, 'result' => [], 'message' => 'Deleted Successfully']);
        }

        return response()->json(['status' => 201, 'result' => [], 'message' => 'No such records exist']);
    }

    public function getSalesDetails(Request $request)
    {
        $validator= Validator::make($request->all(),
            [
                'id'=>'required|numeric|exists:sales_campaign,id'
            ],
            [
                'exists'=>'Invalid ID Provided'
            ]);
        if($validator->fails())
        {
            return response()->json(['status'=>102,'result'=>$validator->errors()]);
        }

        $sales=DB::table('sales_campaign')->leftJoin('gallery','sales_campaign.gallery_id','=','gallery.id')
        ->where('sales_campaign.id', $request->input('id'))
            ->select('sales_campaign.*','gallery.pic_name1','gallery.pic_name2','gallery.pic_name3','gallery.pic_name4')
            ->first();
        return response()->json(['status' => 200, 'result' => ['list'=>$sales], 'message' => 'Successfull']);
    }

    public function getAllSalesByUsersByLimit(Request $request)
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
        $userId=Users::getCreatorFromKey($request->input('syskey'));
        $offset=$request->input('offset');
        $limit=$request->input('limit');
        //update from here
        $salesList=DB::table('sales_campaign')->leftJoin('gallery','sales_campaign.gallery_id','=','gallery.id')
            ->select('sales_campaign.id','sales_campaign.base_title','sales_campaign.views','gallery.pic_name1','sales_campaign.created_at','sales_campaign.updated_at')
            ->where('sales_campaign.created_by', '=', $userId)
            ->offset($offset)
            ->limit($limit)
            ->get();
        return response()->json(['status' => 200, 'result' => ['list'=>$salesList], 'message' => 'Successfull']);
    }
    public function changeShowStatus(Request $request)//to change visibility on page
    {
        $validator= Validator::make($request->all(),
            [
                'id'=>'required|numeric|exists:sales_campaign,id',
                'status'=>'required|numeric'
            ],
            [
                'exists'=>'Invalid ID Provided'
            ]);
        if($validator->fails())
        {
            return response()->json(['status'=>102,'result'=>$validator->errors()]);
        }

        $salesId=$request->input('id');
        $status=$request->input('status');
        $userId=Users::getCreatorFromKey($request->input('syskey'));
        $salesCampaign=new SalesCampaign();
        $salesCampaign=$salesCampaign->findByKey($salesId);
        $salesCampaign->exists=true;
        if($salesCampaign->created_by==$userId) {
            $salesCampaign->showonlist = $status;
            $salesCampaign->save();
            return response()->json(['status' => 200, 'result' => [], 'message' => 'Status Changed']);
        }

        return response()->json(['status' => 201, 'result' => [], 'message' => 'Nothing Exist']);
    }

    public function getAllSalesByUser($uid,$catid)//not valid
    {

        $salesList=DB::table('sales_campaign')
            ->where('sales_campaign.created_by', '=',$uid)
            ->where('sales_campaign.cat_id','=',$catid)
            ->leftJoin('gallery','sales_campaign.gallery_id','=','gallery.id')
            ->select('sales_campaign.id','sales_campaign.base_title','sales_campaign.views','gallery.pic_name1','sales_campaign.created_at','sales_campaign.updated_at')
            ->get();
        return response()->json(['status'=>200,'result'=>['list'=>$salesList],
            'message'=>'Successfull']);

    }
    public function campaignStat(Request $request)
    {
        $userId=Users::getCreatorFromKey($request->input('syskey'));
        $campaignStat=DB::table('sales_campaign')->select('id','base_title','views','created_at','updated_at')
            ->where('created_by', '=', $userId)->get();
        return response()->json(['status'=>200,'result'=>['status'=>$campaignStat],
            'message'=>'Successfull']);

    }
}

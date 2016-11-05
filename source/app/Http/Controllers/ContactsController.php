<?php

namespace App\Http\Controllers;


use App\model\Users;
use Illuminate\Http\Request;
use App\model\Contacts;
use App\Http\Requests;
use Illuminate\Support\Facades\DB;



class ContactsController extends Controller
{
    public function insertAContact(Request $request)
    {
        $userId=Users::getCreatorFromKey($request->input('syskey'));
        $contacts=new Contacts();
        $contacts->created_by=$userId;
        $contacts->name=Commons::checkForEmpty($request->input('name'));
        $contacts->number=Commons::checkForEmpty($request->input('number'));
        $contacts->email=Commons::checkForEmpty($request->input('email'));
        $contacts->email=Commons::checkForEmpty($request->input('age'));
        $contacts->save();

    }
    public function insertBulkContacts(Request $request)
    {
        $userId=Users::getCreatorFromKey($request->input('syskey'));
        $string=rtrim($request->input('list'),';');
        $result=explode(';',$string);
        $final=array();
        $offset=0;
        foreach($result as $new)
        {
            $splitted=explode(':',$new);
            $finalSub=array();
            $count=count($splitted);
            for($i=0;$i<$count;$i++)
            {
               switch($i)
               {
                   case 0: $finalSub=array_add($finalSub,'number',$splitted[0]);break;
                   case 1: $finalSub=array_add($finalSub,'name',$splitted[1]);break;
                   case 2: $finalSub=array_add($finalSub,'email',$splitted[2]);break;
                   case 3: $finalSub=array_add($finalSub,'age',$splitted[3]);break;
               }
            }
                switch($i)
                {
                    case 0: $finalSub=array_add($finalSub,'number',null);
                    case 1: $finalSub=array_add($finalSub,'name',null);
                    case 2: $finalSub=array_add($finalSub,'email',null);
                    case 3: $finalSub=array_add($finalSub,'age',null);
                }
            $finalSub=array_add($finalSub,'created_by',$userId);
            $final=array_add($final,$offset,$finalSub);
            $offset++;


        }
        Contacts::insert($final);
        return response()->json([$final]);

    }
    public function updateContact(Request $request)
    {
        $id=$request->input('id');
        $userId=Users::getCreatorFromKey($request->input('syskey'));
        $contact= new Contacts();
        $contact=$contact->findByKey($id);
        if($contact->created_by==$userId)
        {
            $contact->name=Commons::checkForEmpty($request->input('name'));
            $contact->number=Commons::checkForEmpty($request->input('number'));
            $contact->email=Commons::checkForEmpty($request->input('email'));
            $contact->age=Commons::checkForEmpty($request->input('age'));
        }
        $contact->save();

    }
    public function viewContact(Request $request)
    {
        $userId=Users::getCreatorFromKey($request->input('syskey'));
        $id=$request->input('id');
        $result=Contacts::where('id',$id)->where('created_by',$userId);
        $set=$result->get;
        return response()->json([$set,$result->count()]);

    }
    public function listContacts(Request $request)
    {
        $userId=Users::getCreatorFromKey($request->input('syskey'));
        $result=Contacts::where('created_by',$userId);
        $set=$result->get();
        return response()->json([$set,$result->count()]);

    }
    public function listContactsByLimit(Request $request)
    {
        $userId=Users::getCreatorFromKey($request->input('syskey'));
        $result=Contacts::where('created_by',$userId);
        $offset=$request->input('offset');
        $set=$result->limit($offset)->get();
        return response()->json([$set,$result->count()]);

    }
    public function searchByNumber(Request $request)
    {
        $userId=Users::getCreatorFromKey($request->input('syskey'));
        $number=$request->input('number');
        $result=Contacts::where('created_by',$userId)->where('number','like','%'.$number.'%');
        $set=$result->first();
        return response()->json([$set,$result->count()]);

    }
    public function deleteContact(Request $request)
    {
        $userId=Users::getCreatorFromKey($request->input('syskey'));
        $contact=new Contacts();
        $id=$request->input('id');
        $contact=$contact->findByKey($id);
        if($contact->created_by==$userId)
        {
            $contact->delete();
        }

    }
    public function massDelete(Request $request)
    {
        $userId=Users::getCreatorFromKey($request->input('syskey'));
        $ids = explode(',',$request->input('list'));
        DB::table('contacts')->where('created_by',$userId)->whereIn('id', $ids)->delete();
    }
}

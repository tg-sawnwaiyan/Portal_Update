<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Customer;
use DB;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendMailComment;

class CommentController extends Controller
{
    protected $zipcode;
    public function index($type)
    {    
        if($type == 3)
        {
            $p = "nursing_profiles";  
            $t = 'nursing';
        }
        else{
            $p = "hospital_profiles";
            $t = 'hospital';
        }       
        $commentList = DB::table('comments')
                    ->join($p,'comments.profile_id','=',$p.'.id')
                    ->join('customers','customers.id','=',$p.'.customer_id')
                    ->select('comments.*',$p.'.name as pro_name','customers.name as cus_name')
                    ->where($p.'.recordstatus', 1)
                    ->where('comments.type',$t)
                    ->orderBy('comments.id','DESC')
                    ->paginate(20);
        $query = "select id,name from $p where recordstatus = 1 and name is not null and name != '' ";     
        $profilelist = DB::select($query);
        foreach ($commentList as $com) {
            $splitTimeStamp = explode(" ",$com->created_at);
            $com->created_date = $splitTimeStamp[0];
            $com->created_time = $splitTimeStamp[1];
        }
        return response()->json(array("commentlist"=>$commentList,"profilelist"=>$profilelist));
    }

    public function getCustomComment($type,$profileid)
    {    
        if($type == 3)
        {
            $p = "nursing_profiles";
            $t = "nursing";
        }
        else{
            $p = "hospital_profiles";
            $t = "hospital";
        }
        if($profileid == 0)
        {
            $commentList = DB::table('comments')
                            ->join($p,'comments.profile_id','=',$p.'.id')
                            ->join('customers','customers.id','=',$p.'.customer_id')
                            ->select('comments.*',$p.'.name as pro_name','customers.name as cus_name')
                            ->where($p.'.recordstatus', 1)
                            ->where('comments.type',$t)
                            ->orderBy('comments.id','DESC')
                            ->paginate(20);
        }
        else{
            $commentList = DB::table('comments')
                            ->join($p,'comments.profile_id','=',$p.'.id')
                            ->join('customers','customers.id','=',$p.'.customer_id')
                            ->select('comments.*',$p.'.name as pro_name','customers.name as cus_name')
                            ->where($p.'.recordstatus', 1)
                            ->where('comments.type',$t)
                            ->where('comments.profile_id',$profileid)
                            ->orderBy('comments.id','DESC')
                             ->paginate(20);
        } 
        foreach ($commentList as $com) {
            $splitTimeStamp     = explode(" ",$com->created_at);
            $com->created_date  = $splitTimeStamp[0];
            $com->created_time  = $splitTimeStamp[1];
        }        
        return $commentList;
    }

   
    public function add(Request $request)
    {
        
        $comment = new Comment();
        $comment->title     = $request->input('title');
        $comment->comment   = $request->input('comment');
        $comment->email     = $request->input('email');
        $comment->name      =  $request->input('name');
        $comment->year      = $request->input('year');
        $comment->gender    = $request->input('gender');
        $comment->zipcode   = $request->fields[0]['fzipcode'];
        $comment->profile_id = $request->profile_id;
        $comment->status    = 0;
        $comment->recordstatus = 1;
        $comment->type      = $request->types;
        $comment ->save();
        $getComment = Comment::findOrFail($comment->id);
        
        if($request->types == "nursing")
        {       
            $query = "SELECT np.id as cusid ,np.name as cusname,
            co.* , CONCAT((200000+np.id))  as cusnum 
            from nursing_profiles As np  Join comments As co on np.id = co.profile_id 
             where co.profile_id =" . $comment->profile_id . " and co.id =" .$comment->id;
        }
        else{        
            $query = "SELECT hp.id as cusid ,hp.name as cusname,
            co.* , CONCAT((500000+hp.id))  as cusnum 
            from hospital_profiles As hp  Join comments As co on hp.id = co.profile_id 
             where co.profile_id =" . $comment->profile_id . " and co.id =" .$comment->id;
        }
        $getComment = DB::select($query);    
        $admin_email = 'admin@t-i-s.jp';       
        \Mail::to($admin_email)->send(new SendMailComment($getComment));
    }

    public function delete($id,$type,$pro_id)
    {
        //
        $comment = Comment::find($id);
        $comment->delete();
        if($type == "nursing")
        {
            $p = 'nursing_profiles';
        }
        else{
            $p = 'hospital_profiles';
        }
        if($pro_id == 0)
        {
            $commentList = DB::table('comments')
                        ->join("$p",'comments.profile_id','=',"$p.id")
                        ->join('customers','customers.id','=',"$p.customer_id")
                        ->select('comments.*',"$p.name as pro_name",'customers.name as cus_name')
                        ->where("$p.recordstatus", 1)
                        ->where('comments.type',$type)
                        ->orderBy('comments.id','DESC')
                        ->paginate(20);
        }
        else{
            $commentList = DB::table('comments')
                        ->join("$p",'comments.profile_id','=',"$p.id")
                        ->join('customers','customers.id','=',"$p.customer_id")
                        ->select('comments.*',"$p.name as pro_name",'customers.name as cus_name')
                        ->where("$p.recordstatus", 1)
                        ->where('comments.type',$type)
                        ->where("$p.id",'=',$pro_id)
                        ->orderBy('comments.id','DESC')
                        ->paginate(20);
        }
        foreach ($commentList as $com) {
            $splitTimeStamp     = explode(" ",$com->created_at);
            $com->created_date  = $splitTimeStamp[0];
            $com->created_time  = $splitTimeStamp[1];
        }       
        return response()->json($commentList);
    }
    
    public function confirm($id,$type,$pro_id)
    {
        $comment = Comment::find($id);
        $comment->status =1;
        $comment->save();
        if($type == 'nursing')
        {
            $p = 'nursing_profiles';               
        }
        else{
            $p = 'hospital_profiles';
        }
        if($pro_id == 0)
        {
            $commentList = DB::table('comments')
                            ->join("$p","comments.profile_id",'=',"$p.id")
                            ->join("customers","customers.id","=","$p.customer_id")
                            ->select('comments.*',"$p.name as pro_name",'customers.name as cus_name')
                            ->where("$p.recordstatus", 1)
                            ->where('comments.type',$type)
                            ->orderBy('comments.id','DESC')
                            ->paginate(20);
        }
        else{
            $commentList = DB::table('comments')
                            ->join("$p","comments.profile_id",'=',"$p.id")
                            ->join("customers","customers.id","=","$p.customer_id")
                            ->select('comments.*',"$p.name as pro_name",'customers.name as cus_name')
                            ->where("$p.recordstatus", 1)
                            ->where('comments.type',$type)
                            ->where("$p.id","=",$pro_id)
                            ->orderBy('comments.id','DESC')
                            ->paginate(20);
        }
        foreach ($commentList as $com) {
            $splitTimeStamp     = explode(" ",$com->created_at);
            $com->created_date  = $splitTimeStamp[0];
            $com->created_time  = $splitTimeStamp[1];
        }  
        return response()->json(array("comments"=> $commentList, "success"=>"success", "comment"=>"Comment successfully confirmed"));
    }   

    public function list()
    {
        $comment_list = Comment::select('id','title')->get()->toArray();
        return response()->json($comment_list);
    }

    public function search(Request $request) 
    {    
        $request = $request->all();
        $profileid = $request['search_word'];
        $type =  $request['type'];
        if($type == 'nursing')
        {
            $p = "nursing_profiles";
            $t = "nursing";
        }
        else{
            $p = "hospital_profiles";
            $t = "hospital";
        }
        if($profileid == 0)
        {
            $commentList = DB::table('comments')
                            ->join($p,'comments.profile_id','=',$p.'.id')
                            ->join('customers','customers.id','=',$p.'.customer_id')
                            ->select('comments.*',$p.'.name as pro_name','customers.name as cus_name')
                            ->where($p.'.recordstatus', 1)
                            ->where('comments.type','nursing')
                            ->orderBy('comments.id','DESC')
                            ->paginate(20);
        }
        else{
            $commentList = DB::table('comments')
                            ->join($p,'comments.profile_id','=',$p.'.id')
                            ->join('customers','customers.id','=',$p.'.customer_id')
                            ->select('comments.*',$p.'.name as pro_name','customers.name as cus_name')
                            ->where($p.'.recordstatus', 1)
                            ->where('comments.type',$t)
                            ->where('comments.profile_id',$profileid)
                            ->orderBy('comments.id','DESC')
                            ->paginate(20);
        }
        foreach ($commentList as $com) {
            $splitTimeStamp     = explode(" ",$com->created_at);
            $com->created_date  = $splitTimeStamp[0];
            $com->created_time  = $splitTimeStamp[1];
        }       
        return response()->json($commentList);
    }
}

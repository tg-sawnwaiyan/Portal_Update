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
        // $comment =Comment::all()->toArray();
        // return array_reverse($comment);
        // $sql = "SELECT comments.*,customers.name from comments JOIN customers ON comments.customer_id= customers.id WHERE customers.type_id=$type AND customers.status=1 ORDER BY id DESC";
      
        // $commentList = DB::table('comments')
        //         ->join('customers','comments.customer_id','=','customers.id')
        //         ->where('customers.type_id', $type)
        //         ->where('customers.status', 1)
        //         ->orderBy('comments.id','DESC')
        //         ->paginate(12);

       
        if($type == 3)
        {
            $commentList = DB::table('comments')
            ->join('nursing_profiles','comments.profile_id','=','nursing_profiles.id')
            ->select('comments.*')
            ->where('nursing_profiles.recordstatus', 1)
            ->where('comments.type','nursing')
            ->orderBy('comments.id','DESC')
            ->paginate(12);

            $query = "select id,name from nursing_profiles where recordstatus = 1 and name is not null";
            $profilelist = DB::select($query);
        }
        else{
            $commentList = DB::table('comments')
            ->join('hospital_profiles','comments.profile_id','=','hospital_profiles.id')
            ->select('comments.*')
            ->where('hospital_profiles.recordstatus', 1)
            ->where('comments.type','hospital')
            ->orderBy('comments.id','DESC')
            ->paginate(12);

            $query = "select id,name from hospital_profiles where recordstatus = 1 and name is not null";
            $profilelist = DB::select($query);
        }


        // $commentList = DB::select($sql)->paginate(12);
        foreach ($commentList as $com) {
            $splitTimeStamp = explode(" ",$com->created_at);
            $com->created_date = $splitTimeStamp[0];
            $com->created_time = $splitTimeStamp[1];
        }

     
        // return $comments;
        return response()->json(array("commentlist"=>$commentList,"profilelist"=>$profilelist));
    }

    public function getCustomComment($type,$profileid)
    {
        if($type == 3)
        {
            if($profileid == 0)
            {
                $commentList = DB::table('comments')
                ->join('nursing_profiles','comments.profile_id','=','nursing_profiles.id')
                ->select('comments.*')
                ->where('nursing_profiles.recordstatus', 1)
                ->where('comments.type','nursing')
                ->orderBy('comments.id','DESC')
                ->paginate(12);
            }
            else{
                $commentList = DB::table('comments')
                ->join('nursing_profiles','comments.profile_id','=','nursing_profiles.id')
                ->select('comments.*')
                ->where('nursing_profiles.recordstatus', 1)
                ->where('comments.type','nursing')
                ->where('comments.profile_id',$profileid)
                ->orderBy('comments.id','DESC')
                ->paginate(12);
            }
           
        }
        else{
            if($profileid == 0)
            {
                $commentList = DB::table('comments')
                ->join('hospital_profiles','comments.profile_id','=','hospital_profiles.id')
                ->select('comments.*')
                ->where('hospital_profiles.recordstatus', 1)
                ->where('comments.type','hospital')
                ->orderBy('comments.id','DESC')
                ->paginate(12);
            }
            else{
                $commentList = DB::table('comments')
                ->join('hospital_profiles','comments.profile_id','=','hospital_profiles.id')
                ->select('comments.*')
                ->where('hospital_profiles.recordstatus', 1)
                ->where('comments.type','hospital')
                ->where('comments.profile_id',$profileid)
                ->orderBy('comments.id','DESC')
                ->paginate(12);
            }
           
        
        }
        return $commentList;
    }


    public function create()
    {
        //
    }
    // public function getCommentList($cusid){

    //     // $sql = "SELECT comments.*,customers.id,customers.name from comments JOIN customers ON comments.customer_id= customers.id WHERE comments.customer_id=$cusid";
    //     // $commentList = DB::select($sql);
    //     // return $commentList;
    // }

    public function store(Request $request)
    {
    

        // $request->validate([
        //     'title' => 'required',
        //     'comment' =>'required',
        //     'email' => 'required|email',
            //  'fzipcode' => 'required',
            //  'lzipcode' => 'required',
        // ]
        // ,[
        //     'fzipcode.required' => 'First zipcode is required and must be three !',
        //     'lzipcode.required' => 'Second zipcode is required and  must be four'
        // ]
    // );

        // $request->validate([
        //     'title' => 'required',
        //     'comment' =>'required',
        //     'email' => 'required|email',

        // ]);

        $zipcode =  $request->fields[0]['fzipcode'] . '-' . $request->fields[0]['lzipcode'];


        $comment = new Comment();
        $comment->title = $request->input('title');
        $comment->comment = $request->input('comment');
        $comment->email = $request->input('email');
        $comment->name =  $request->input('name');
        $comment->year = $request->input('year');
        $comment->gender = $request->input('gender');
        $comment->zipcode = $zipcode;
        $comment->profile_id = $request->profile_id;
        $comment->status = 0;
        $comment->recordstatus = 1;
        $comment->type = $request->types;
        $comment ->save();


        $getComment = Comment::findOrFail($comment->id);
        // $query = "SELECT cu.id as cusid ,cu.name as cusname,
        // co.* ,(CASE cu.type_id WHEN '2' THEN CONCAT((200000+cu.id)) ELSE CONCAT((500000+cu.id)) END) as cusnum 
        // from customers As cu  Join comments As co on cu.id = co.customer_id 
        //  where co.customer_id =" . $comment->customer_id . " and co.id =" .$comment->id;
        // $getComment = DB::select($query);
      
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

    
        $admin_email = 'susandiaung565@gmail.com';
       
        \Mail::to($admin_email)->send(new SendMailComment($getComment));

     

    }

    public function show($id)
    {
        //
    }

    public function edit(Comment $comment)
    {

    }


    public function update(Request $request, Comment $comment)
    {
        //
    }


    public function destroy($id,$type)
    {
        //

        $comment = Comment::find($id);
        $comment->delete();
        if($type == 'nursing')
        {
            $commentList = DB::table('comments')
            ->join('nursing_profiles','comments.profile_id','=','nursing_profiles.id')
            ->select('comments.*')
            ->where('nursing_profiles.recordstatus', 1)
            ->where('comments.type','nursing')
            ->orderBy('comments.id','DESC')
            ->paginate(12);
        }
        else{
            $commentList = DB::table('comments')
            ->join('hospital_profiles','comments.profile_id','=','hospital_profiles.id')
            ->select('comments.*')
            ->where('hospital_profiles.recordstatus', 1)
            ->where('comments.type','hospital')
            ->orderBy('comments.id','DESC')
            ->paginate(12);
        }
        return response()->json($commentList);
    }
    public function confirm($id,$type)
     {
            $comment =Comment::find($id);
            $comment->status =1;
            $comment->save();

           
            if($type == 'nursing')
            {
                $commentList = DB::table('comments')
                ->join('nursing_profiles','comments.profile_id','=','nursing_profiles.id')
                ->select('comments.*')
                ->where('nursing_profiles.recordstatus', 1)
                ->where('comments.type','nursing')
                ->orderBy('comments.id','DESC')
                ->paginate(12);
            }
            else{
                $commentList = DB::table('comments')
                ->join('hospital_profiles','comments.profile_id','=','hospital_profiles.id')
                ->select('comments.*')
                ->where('hospital_profiles.recordstatus', 1)
                ->where('comments.type','hospital')
                ->orderBy('comments.id','DESC')
                ->paginate(12);
            }
    
  
            return response()->json(array("comments"=> $commentList, "success"=>"success", "comment"=>"Comment successfully confirmed"));

    }
   

    public function list()
    {

        $comment_list = Comment::select('id','title')->get()->toArray();
        return response()->json($comment_list);

    }

    public function search(Request $request) {
    
        $request = $request->all();
        $search_word = $request['search_word'];
        if($request['type'] == 'nursing')
        {
            $search_comment = DB::table('comments')
            ->join('nursing_profiles','comments.profile_id','=','nursing_profiles.id')
            ->where('nursing_profiles.name', 'LIKE', "%{$search_word}%")
            ->where('nursing_profiles.recordstatus',1)
            ->where('comments.type','nursing')
            ->orderBy('comments.id','DESC')
            ->paginate(12);
        }
        else{
            $search_comment = DB::table('comments')
            ->join('hospital_profiles','comments.profile_id','=','hospital_profiles.id')
            ->where('hospital_profiles.name', 'LIKE', "%{$search_word}%")
            ->where('hospital_profiles.recordstatus',1)
            ->where('comments.type','hospital')
            ->orderBy('comments.id','DESC')
            ->paginate(12);
        }

        // $search_comment = DB::table('comments')
        //                     ->join('customers','comments.customer_id','=','customers.id')
        //                     ->where('customers.name', 'LIKE', "%{$search_word}%")
        //                     ->orderBy('comments.id','DESC')
        //                     ->paginate(12);

       
        return response()->json($search_comment);

    }

}

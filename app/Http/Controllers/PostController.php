<?php

namespace App\Http\Controllers;

use App\Post;
use App\Category;
use App\PostView;
use Illuminate\Http\Request;
use DB;
use Carbon;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    // function __construct()
    // {
    //      $this->middleware('permission:role-list');
    //      $this->middleware('permission:role-create', ['only' => ['create','store']]);
    //      $this->middleware('permission:role-edit', ['only' => ['edit','update']]);
    //      $this->middleware('permission:role-delete', ['only' => ['destroy']]);
    // }

    public function index()
    {
       
    //    $news_list = Post::orderBy('id','DESC')->get()->toArray();
    //    $category_list = Category::select('id','name')->get()->toArray();
            $news_list = Post::join('categories','categories.id','=','posts.category_id')->select('posts.*','categories.name as cat_name')->orderBy('posts.id', 'desc')->paginate(20);
            $category_list = Category::select('id','name')->get()->toArray();

        
            foreach ($news_list as $com) {
                $splitTimeStamp = explode(" ",$com->from_date);
                $com->from_date = $splitTimeStamp[0];
                $splitTimeStamp1 = explode(" ",$com->to_date);
                $com->to_date = $splitTimeStamp1[0];
            }
    
            return response()->json(Array("news"=>$news_list,"category"=>$category_list));

    }
    // add news
    public function add(Request $request)
    {
       
        if(is_object($request->photo)){
            $imageName = uniqid().$request->photo->getClientOriginalName();
            $imageName = str_replace(' ', '', $imageName);
            $imageName = strtolower($imageName);
            $request->photo->move('upload/news/', $imageName);
        }else {
            $imageName = uniqid().$request->photo;
            $imageName = str_replace(' ', '', $imageName);
            $imageName = strtolower($imageName);
        }

        $post = new Post() ;
            $post->title = $request->input('title');
            $post->main_point = $request->input('main_point');
            $post->body=$request->input('body');
            $post->photo = $imageName;
            $post->category_id=$request->input('category_id');
            $post->block_id=$request->input('block_id');
            $post->related_news=$request->input('related_news');
            $post->user_id = 1;
            // $post->recordstatus=1;
            $post->created_by = $request->input('created_by');
            $post->created_by_company = $request->input('created_by_company');
            $post->from_date = $request->input('from_date');
            $post->to_date = $request->input('to_date');
        
            $post->save();

        return response()->json('The New successfully added');


        // $post = new Post([
        //             'title' => $request->input('title'),
        //             'main_point' => $request->input('main_point'),
        //             'body' => $request->input('body'),
        //             'photo' =>$imageName,
        //             'category_id' =>$request->input('category_id'),
        //             'related_news' =>$request->input('related_news'),
        //             'user_id' => 1,
        //             'recordstatus' => 1
        //         ]);

    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
      
        // return Post::findOrFail($id);
     

        $data = DB::table('posts')->join('categories', 'categories.id', '=', 'posts.category_id')
                                  ->select('posts.*', 'categories.name as cat_name', 'categories.id as cat_id')
                                  ->where('posts.id',$id)->get();
     
       return response()->json(array('news'=> $data));
    
    }

    public function getNewsByCategory($id)
    {
        $cat_name = Category::where('id',$id)->select('name')->value('name');

        $newslist = Post::where('block_id','!=',0)->where('category_id',$id)->where('recordstatus',1)->orderBy('created_at', 'DESC')->get()->toArray();

        $lenght = $tmp = $newarray1 = $newarray2 = $newarray3 = $newarray4 = $aryPush = $aryEmpty = $More = [];

        //divide array new list by block
        foreach ($newslist as $value) {
            $tmp[$value['block_id']][] = $value;
        }

        //separted divied block array
        foreach ($tmp as $key => $value) {
            if($key == 1){
                $newarray1 = array_chunk($value, 2);
            }elseif($key == 2){
                $newarray2 = array_chunk($value, 3);
            }elseif($key == 3){
                $newarray3 = array_chunk($value, 13);
            }/*elseif($key == 4){
                $newarray4 = array_chunk($value, 1);
            }*/
        }
        $one = $two = $three = 0; 
        $moreNews  = $moreNews_concat = [];

        $lenght[] = count($newarray1);
        $lenght[] = count($newarray2);
        $lenght[] = count($newarray3);
        //$lenght[] = count($newarray4); 
                
        for ($i=0; $i <= max($lenght); $i++) { 
            /***for block id one***/      
            if(isset($newarray1[$i]) && $one < 2){
                array_push($aryPush, $newarray1[$i]);                
                $one++;
            }else if(isset($newarray1[$i]) && $one >= 2){
                array_push($More, $newarray1[$i]);
            }
            else if(!isset($newarray1[$i])){
                array_push($aryPush, $aryEmpty);
            }
            /***for block id two***/      
            if(isset($newarray2[$i]) && $two < 2){
                array_push($aryPush, $newarray2[$i]);                
                $two++;
            }else if(isset($newarray2[$i]) && $two >= 2){
                array_push($More, $newarray2[$i]);
            }
            else if(!isset($newarray2[$i])){
                array_push($aryPush, $aryEmpty);
            }
            /***for block id three***/      
            if(isset($newarray3[$i]) && $three < 2){
                array_push($aryPush, $newarray3[$i]);                
                $three++;
            }else if(isset($newarray3[$i]) && $three >= 2){
                array_push($More, $newarray3[$i]);
            }
            else if(!isset($newarray3[$i])){
                array_push($aryPush, $aryEmpty);
            }
        } 

        foreach ($More as $key => $value) { 
            if (is_array($value)) { 
              $moreNews = array_merge($moreNews, $value); 
            } 
            $moreNews_concat = array_chunk($moreNews, 4);
        } 

        if(array_filter($aryPush)){            
            $aryResults = array_chunk($aryPush, 3);
        }else{
            $aryResults = [];
        }

        return response()->json(array('cat_name'=> $cat_name,'cat_id' => $id,'newslist'=>$aryResults,'moreNews'=>$moreNews_concat));
    }

     public function getNewsByCategoryForMobile($id)
    {
        $cat_name = Category::where('id',$id)->select('name')->value('name');
        $newslist = Post::where('block_id','!=',0)->where('category_id',$id)->where('recordstatus',1)->orderBy('block_id', 'ASC')->orderBy('created_at', 'DESC')->get()->toArray();
        return response()->json(array('cat_name'=> $cat_name,'newslist'=>$newslist));
    }

    public function show_related($id) {
    
        $related_news = Post::select('related_news','category_id')->where('id',$id)->get();
        if($related_news[0]["related_news"] != null) {
            $sql = "select * from posts where id in(".$related_news[0]["related_news"].")";
            $news = DB::select($sql);
            }
        else{
            $news = null;
        }

        $latest = Post::select('*')->where('category_id',$related_news[0]["category_id"])->orderBy('created_at','DESC')->limit('5')->get();

        $data = array("related_news"=>$news, "latest_news" => $latest);
        return $data;

        return response()->json($data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $posts = Post::find($id);
      
     
        return response()->json($posts);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update($id, Request $request)
    {
        $post = Post::find($id);
        if($request->old_photo == ' ' || $request->old_photo == null ){
            if(is_object($request->photo)) {
                $file= $post->photo;
                $filename = './upload/news/'.$file;
                \File::delete($filename);
                $imageName = uniqid().$request->photo->getClientOriginalName();
                $imageName = str_replace(' ', '', $imageName);
                $imageName = strtolower($imageName);
                $request->photo->move('upload/news/', $imageName);
            }
            else {
                $file = $post->photo;
                $imageName = $file;
            }
        }
        else {
            if(is_object($request->photo)) {
                $file= $post->photo;
                $filename ='./upload/news/'.$file;
                \File::delete($filename);
                $imageName = uniqid().$request->photo->getClientOriginalName();
                $imageName = str_replace(' ', '', $imageName);
                $imageName = strtolower($imageName);
                $request->photo->move('upload/news/', $imageName);
            }

            else {
                $file= $post->photo;
                $filename ='./upload/news/'.$file;
                \File::delete($filename);
                $imageName = '';
            }
        }

        
        // $formData = array(
        //     'title' => $request->input('title'),
        //     'main_point' => $request->input('main_point'),
        //     'body' => $request->input('body'),
        //     'photo' => $imageName,
        //     'category_id' =>$request->input('category_id'),
        //     'related_news' =>$request->input('related_news'),
        //     'user_id' => 1,
        //     'recordstatus' => 1
        // );
            $post->title = $request->input('title');
            $post->main_point = $request->input('main_point');
            $post->body=$request->input('body');
            $post->photo = $imageName;
            $post->category_id=$request->input('category_id');
            $post->block_id=$request->input('block_id');
            $post->related_news=$request->input('related_news');
            $post->from_date = $request->input('from_date');
            $post->to_date = $request->input('to_date');

            if (is_null($request->input('created_by_company')) || $request->input('created_by_company') == 'null' ) {
                $post->created_by_company = '';
            }
            else {
                $post->created_by_company = $request->input('created_by_company');
            }
            if (is_null($request->input('created_by')) || $request->input('created_by') == 'null' ) {
                $post->created_by = '';
            }
            else {
                $post->created_by = $request->input('created_by');
            }
            //$post->created_by_company = $request->input('created_by_company');
            $post->user_id = 1;
            // $post->recordstatus=1;
            $post->save();


        //$post->update($formData);
        return response()->json('The news successfully updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function delete($id,$cat_id)
    {
     
        $post = Post::find($id);
        $file= $post->photo;
        $filename = './upload/news/'.$file;
        \File::delete($filename);
        $post->delete();
       
        
        if($cat_id == 0)
        {
        //    $posts = Post::orderBy('id', 'desc')->paginate(20);
        $posts = Post::join('categories','categories.id','=','posts.category_id')->select('posts.*','categories.name as cat_name')->orderBy('posts.id', 'desc')->paginate(20);
        }
        else{
            // $posts = Post::where('category_id',$cat_id)->orderBy('id','desc')->paginate(20);
            $posts = Post::join('categories','categories.id','=','posts.category_id')->select('posts.*','categories.name as cat_name')->where('category_id',$cat_id)->orderBy('posts.id', 'desc')->paginate(20);
        }

        foreach ($posts as $com) {
            $splitTimeStamp = explode(" ",$com->from_date);
            $com->from_date = $splitTimeStamp[0];
            $splitTimeStamp1 = explode(" ",$com->to_date);
            $com->to_date = $splitTimeStamp1[0];
        }

        return response()->json($posts);
    }

    public function search(Request $request)
    {
        $request = $request->all();

        $query = Post::join('categories','categories.id','=','posts.category_id')->select('posts.*','categories.name as cat_name');
     
        if(isset($request['selected_category'])) {
            $category_id = $request['selected_category'];
            if($request['postid'] != null){
                $query = $query->where('posts.category_id', $category_id)->where('posts.id','<>',$request['postid']);
            }
            else{
                $query = $query->where('posts.category_id', $category_id);
            }
           
        }
        if(isset($request['selected_date'])) {
            $selected_date = $request['selected_date'];
            $from = Carbon\Carbon::parse($request['selected_date'])->startOfDay();
            $to = Carbon\Carbon::parse($request['selected_date'])->endOfDay();
             $query = $query->where(function($qu) use ($from, $to){
                $qu->whereBetween('posts.created_at', [$from, $to]);
            });
        }
        if(isset($request['search_word'])) {
            $search_word = $request['search_word'];

            $query = $query->where(function($qu) use ($search_word){
                            $qu->where('posts.title', 'LIKE', "%{$search_word}%")
                                ->orWhere('posts.main_point', 'LIKE', "%{$search_word}%"); 
                        });
        }
        
        $query = $query->orderBy('posts.created_at','DESC')
                        ->paginate(20);
        $postCount = $query->count();
        foreach ($query as $com) {
            $splitTimeStamp = explode(" ",$com->from_date);
            $com->from_date = $splitTimeStamp[0];
            $splitTimeStamp1 = explode(" ",$com->to_date);
            $com->to_date = $splitTimeStamp1[0];
        }
        return  response()->json(array('query'=>$query, 'postCount'=>$postCount));

        
    }

    public function getPostById(Request $request,$page,$postid) {

        // $request = $request->all();
        // $posts = Post::where('id','<>',$postid)->where("category_id",$request['cat_id'])->orderBy('created_at','DESC')->paginate(20);
        // return response()->json($posts);
        $request = $request->all();
        $posts = Post::where('id','<>',$postid)->where("category_id",$request['cat_id']);

        
        if(isset($request['search_word'])) {
            $search_word = $request['search_word'];

            $posts = $posts->where(function($qu) use ($search_word){
                            $qu->where('title', 'LIKE', "%{$search_word}%")
                                ->orWhere('main_point', 'LIKE', "%{$search_word}%"); 
                        });
        }

        $posts = $posts->orderBy('created_at','DESC')->paginate(20);
        return response()->json($posts);
    }

    public function changeRecordstatus($id)
    {
        $changeActivate =  Post::find($id);

       if($changeActivate->recordstatus == 0 ) {

            $changeActivate->recordstatus =1;
       }
       else {

            $changeActivate->recordstatus =0;
       }

       $changeActivate->save();
       
       $data = array("changeActivate"=> $changeActivate, "success");
       return response()->json($data);
    }

    // public function searchPost($search_word) {
    //     // $sql = "SELECT GROUP_CONCAT(post.id) as id , GROUP_CONCAT(post.title) as title, GROUP_CONCAT(post.photo) as photo, cate.name as name, post.category_id as cat_id from posts post join categories cate on cate.id = post.category_id where post.title LIKe '%{$search_word}%' group by post.category_id";
    //     $sql = "SELECT categories.name, posts.title, posts.id as pid, posts.photo
    //     FROM posts INNER JOIN categories ON categories.id = posts.category_id
    //     WHERE posts.title LIKe '%{$search_word}%'";
    //     $posts = DB::select($sql);
    //     return $posts;
    // }

}   

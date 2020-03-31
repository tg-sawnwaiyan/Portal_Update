<?php

namespace App\Http\Controllers;

use App\Post;
use App\Category;
use App\PostView;
use Illuminate\Http\Request;
use DB;

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
            $news_list = Post::orderBy('id', 'desc')->paginate(20);
            $category_list = Category::select('id','name')->get()->toArray();
    
            return response()->json(Array("news"=>$news_list,"category"=>$category_list));

    }
    // add news
    public function add(Request $request)
    {
       
        if(is_object($request->photo)){
            $imageName = $request->photo->getClientOriginalName();
            $imageName = str_replace(' ', '', $imageName);
            $imageName = strtolower($imageName);
            $request->photo->move('upload/news/', $imageName);
        }else {
            $imageName =$request->photo;
            $imageName = str_replace(' ', '', $imageName);
            $imageName = strtolower($imageName);
        }
        $post = new Post() ;
            $post->title = $request->input('title');
            $post->main_point = $request->input('main_point');
            $post->body=$request->input('body');
            $post->photo = $imageName;
            $post->category_id=$request->input('category_id');
            $post->related_news=$request->input('related_news');
            $post->user_id = 1;
            $post->recordstatus=1;
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
        $newslist = Post::where('category_id',$id)->get();
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
                $imageName = $request->photo->getClientOriginalName();
                $imageName = str_replace(' ', '', $imageName);
                $imageName = strtolower($imageName);
                $request->photo->move('upload/news/', $imageName);
            }
            else {
                $file= $post->photo;
                $imageName = $file;
            }
        }
        else {
            if(is_object($request->photo)) {
                $file= $post->photo;
                $filename ='./upload/news/'.$file;
                \File::delete($filename);
                $imageName = $request->photo->getClientOriginalName();
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
            $post->related_news=$request->input('related_news');
            $post->from_date = $request->input('from_date');
            $post->to_date = $request->input('to_date');
            $post->user_id = 1;
            $post->recordstatus=1;
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
           $posts = Post::orderBy('id', 'desc')->paginate(20);
        }
        else{
            $posts = Post::where('category_id',$cat_id)->orderBy('id','desc')->paginate(20);
        }
        return response()->json($posts);
    }

    public function search(Request $request)
    {
      
        $request = $request->all();

        $query = Post::query();

        if(isset($request['selected_category'])) {
            $category_id = $request['selected_category'];
            if($request['postid'] != null){
                $query = $query->where('category_id', $category_id)->where('id','<>',$request['postid']);
            }
            else{
                $query = $query->where('category_id', $category_id);
            }
           
        }

        if(isset($request['search_word'])) {
            $search_word = $request['search_word'];

            $query = $query->where(function($qu) use ($search_word){
                            $qu->where('title', 'LIKE', "%{$search_word}%")
                                ->orWhere('main_point', 'LIKE', "%{$search_word}%"); 
                        });
        }
        $query = $query->orderBy('created_at','DESC')
                        ->paginate(20);
        return  response()->json($query);
        
    }

    public function getPostById(Request $request,$page,$postid) {

        $request = $request->all();
        $posts = Post::where('id','<>',$postid)->where("category_id",$request['cat_id'])->orderBy('created_at','DESC')->paginate(20);
        return response()->json($posts);
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

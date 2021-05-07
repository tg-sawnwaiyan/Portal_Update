<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use App\Post;
use DB;
use Carbon;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $catList = array();

        $topic[0] = DB::table('categories')->where('name', 'トップ')
                    //->where('recordstatus', '=', 1)
                    ->first();
        $cats = DB::table('categories')
                    ->join('posts', 'categories.id', '=', 'posts.category_id')
                    ->where('categories.id', '!=', 26)
                    ->where('posts.recordstatus', '=', 1)
                    ->groupBy('categories.id')
                    ->orderByDesc('categories.order_number')
                    ->select('categories.*')
                    ->get()->toArray();

       if(isset($topic[0]))
        $catList = array_merge_recursive($topic , $cats);
        else
        $catList = $cats;

        
        return response()->json($catList);
    }

    public function home()
    {
        return view("home");
    }

    public function getPosts(Request $request)
    {
        $request = $request->all();
        $cat_id = $request['category_id'];

        $posts = Post::where(["category_id"=>$cat_id, 'recordstatus'=>1])->orderBy('created_at', 'desc')->limit(11)->get();
        // if(isset($request['search_word'])) {
        //     $search_word = $request['search_word'];
        //     $posts = $posts->where(function($qu) use ($search_word){
        //         $qu->where('title', 'LIKE', "%{$search_word}%");
        //     });
        // }
        // $posts = $posts->orderBy('created_at', 'desc')->get();
        return response()->json($posts);
    }

    public function getLatestPost(Request $request)
    {
        $request = $request->all();
        $cat_id = $request['category_id'];
        $cat = DB::table('categories')->where('id', $cat_id)
                    ->first('name');
        $latest_post = Post::where("category_id",$cat_id,"and")->where('recordstatus',1);
        $latest_post = $latest_post->orderBy('created_at', 'desc')->first();
        return response()->json(["cat" => $cat, "latest_post" => $latest_post]);
    }

    public function getLatestPostFromAllCat()
    {
        $to_date = [];$from_date=[];
        $getTime = Carbon\Carbon::now()->toDateString();
        // toDateTimeString
        $query = "SELECT *,'' as cname from posts 
        where category_id = 26 and recordstatus=1 and from_date <= '".$getTime."' and 
        (CASE WHEN to_date is NULL THEN from_date <= '".$getTime."' and to_date is null ELSE from_date <= '".$getTime."' and to_date >= '".$getTime."' END) limit 16";
        $break_news = DB::select($query);
  
        $limit = 16 - count($break_news);
        $latestpost = Post::join('categories', 'posts.category_id', '=', 'categories.id' )->select('posts.*','categories.name as cname','categories.color_code')->where('category_id','!=',26)->where('posts.recordstatus',1)->orderBy('posts.created_at', 'desc')->limit("$limit")->get()->toArray();

        $merge_arr = array_merge($break_news,$latestpost);
        shuffle($merge_arr);
        return response()->json($merge_arr);
    }

    public function get_news_by_catId($search_word,$id)
    {
        if($search_word == 'all_news_search')
        {
            $query = "SELECT * from posts where category_id = $id ";
        }
        else{
            $query = "SELECT * from posts where category_id = $id and (title like '%".$search_word."%' or body like '%".$search_word."%')";
        }
        $newslist = DB::select($query);
        return $newslist;
    }

    public function getLatestPostsByAllCatId($search_word) 
    {
        
        $sql = "";
        if($search_word == 'all_news_search'){
            $wh = '';
        }
        else{
            $wh = " AND (posts.title LIKe '%{$search_word}%' OR posts.main_point LIKe '%{$search_word}%' OR posts.body LIKe '%{$search_word}%')";
        }
        $cat = Category::where('id','!=',26)->select('id')->orderBy('order_number','desc')->get();
        if(count($cat) == 0){
            $posts = [];

            return response()->json($posts);
        }else{
            for($i = 0; $i < count($cat); $i++) {
                $sql.= "(SELECT categories.name,categories.pattern,categories.id,categories.color_code,posts.id as pid,posts.title,posts.created_at, posts.photo, posts.main_point, posts.block_id FROM categories INNER JOIN posts ON categories.id = posts.category_id WHERE posts.recordstatus=1 and posts.block_id != 0 and categories.id = ".$cat[$i]['id']." ".$wh." order by posts.created_at desc  LIMIT 50) UNION ";
            }
            $sql = trim($sql,' UNION ');
            $posts = DB::select($sql);
            $tmp = array();
            foreach($posts as $aryPosts){
                $color = $aryPosts->color_code ? $aryPosts->color_code : "#287db4";
                $todayDate = Carbon\Carbon::now();
                $createdDate = str_replace('-', '/', $aryPosts->created_at);
                $hourInterval = $todayDate->diffInHours($createdDate);
                $carbonCreated_dt = Carbon\Carbon::parse($createdDate);
                if($hourInterval <= 36)
                {
                $aryPosts->new_news = 1;
                $aryPosts->date_only = $carbonCreated_dt->month.'/'.$carbonCreated_dt->day;
                }
                
                $hour = $carbonCreated_dt->hour;
                $hour = $hour < 10 ? '0'.$hour : $hour;
                $minute = $carbonCreated_dt->minute;
                $minute = $minute < 10 ? '0'.$minute : $minute;
                $aryPosts->created_at = $carbonCreated_dt->month.'/'.$carbonCreated_dt->day.' '.$hour.':'.$minute;
                $tmp[$aryPosts->id.",".$aryPosts->name.",".$color][] = $aryPosts;
            }
            $aryResults = array();
            foreach ($tmp as $key => $item) {
                foreach($item as $item){
                    $aryResults[$key][$item->block_id][] = $item;
                }
            }
            return response()->json($aryResults);
        }
    }

    public function getLatestPostsByAllCatIdForMobile($search_word) 
    {
        $sql = "";
        if($search_word == 'all_news_search'){
            $wh = '';
        }
        else{
            $wh = " AND (posts.title LIKe '%{$search_word}%' OR posts.main_point LIKe '%{$search_word}%' OR posts.body LIKe '%{$search_word}%')";
        }
        $cat = Category::where('id','!=',26)->select('id')->orderBy('order_number','desc')->get();
        if(count($cat) == 0){
            $posts = [];
            return response()->json($posts);
        }else{
            for($i = 0; $i < count($cat); $i++) {

                $sql.= "(SELECT categories.name,categories.pattern,categories.id,categories.color_code,posts.id as pid,posts.title,posts.created_at, posts.photo, posts.main_point, posts.block_id FROM categories INNER JOIN posts ON categories.id = posts.category_id WHERE posts.recordstatus=1 and posts.block_id != 0 and categories.id = ".$cat[$i]['id']." ".$wh." order by posts.created_at desc LIMIT 11) UNION ";

            }
            $sql = trim($sql,' UNION '); 
            $posts = DB::select($sql);
            $tmp = array();

            foreach($posts as $aryPosts){ 
                $todayDate = Carbon\Carbon::now();
                $createdDate = str_replace('-', '/', $aryPosts->created_at);
                $hourInterval = $todayDate->diffInHours($createdDate);

                $carbonCreated_dt = Carbon\Carbon::parse($createdDate);
                if($hourInterval <= 36)
                {
                $aryPosts->new_news = 1;
                $aryPosts->date_only = $carbonCreated_dt->month.'/'.$carbonCreated_dt->day;
                }
                $hour = $carbonCreated_dt->hour;
                $hour = $hour < 10 ? '0'.$hour : $hour;
                $minute = $carbonCreated_dt->minute;
                $minute = $minute < 10 ? '0'.$minute : $minute;

                $aryPosts->created_at = $carbonCreated_dt->month.'/'.$carbonCreated_dt->day.' '.$hour.':'.$minute;


                $color = $aryPosts->color_code ? $aryPosts->color_code : "#287db4";
                $aryNewsMobile[$aryPosts->id.",".$aryPosts->name.",".$color][] = $aryPosts;
            }
           
        return response()->json($aryNewsMobile);
        }
    }
}
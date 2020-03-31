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
        
        $cats = DB::select("SELECT categories.* FROM categories INNER JOIN posts ON categories.id = posts.category_id WHERE categories.id != 26  GROUP BY categories.id");
        return response()->json($cats);
    }

    public function home()
    {
        // $cats = Category::all()->toArray();
        return view("home");
    }

    public function getPosts(Request $request)
    {




        $request = $request->all();
        $cat_id = $request['category_id'];

        $posts = Post::where("category_id",$cat_id)->orderBy('created_at', 'desc')->limit(9)->get();
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




        // $latest_post = Post::where("category_id",$cat_id)->orderBy('created_at', 'desc')->first();
        $request = $request->all();
        $cat_id = $request['category_id'];

        $latest_post = Post::where("category_id",$cat_id);
        // $search_word = $request['search_word'];

        // if(isset($request['search_word'])) {
        //     $search_word = $request['search_word'];
        //     $latest_post = $latest_post->where(function($qu) use ($search_word){
        //         $qu->where('title', 'LIKE', "%{$search_word}%");
        //     });
        // }
        $latest_post = $latest_post->orderBy('created_at', 'desc')->first();
        return response()->json($latest_post);
    }

    public function getCategoryRandom()
    {
        // $pattern_arr = [1,2,3,1,2];

        // $random = "SELECT  id, pattern from categories order by rand() limit 5 ";
        // $cat_random = DB::select($random);
        // for($i=0;$i<count($cat_random);$i++)
        // {


        //    $cat_random[$i]->pattern = $pattern_arr[$i];

        // }
        // return response()->json($cat_random);


        $pattern_arr = [1,2,3];
        $random = "SELECT  id, pattern from categories order by rand()";
        $cat_random = DB::select($random);
        $k = count($cat_random);
        for($i=0;$i<count($cat_random);$i++)
        {

           for($j=0; $j<count($pattern_arr);$j++)
           {
               if($i < $k)
               {
                    $cat_random[$i]->pattern = $pattern_arr[$j];
                    $id = $cat_random[$i]->id;
                    $category = Category::find($id);
                    $category->pattern =  $pattern_arr[$j];
                    $category->save();
                    $i++;
               }
           }

           $i--;
        }


        return response()->json('success');
    }


        public function getLatestPostFromAllCat()
    {
        $to_date = [];$from_date=[];
        $getTime = Carbon\Carbon::now()->toDateString();
  
        $list = Post::where('category_id',26)->get();
        foreach ($list as $li) {
            if($li->to_date == '0000-00-00 00:00:00' || $li->to_date == null)
            {
                $query = "SELECT * from posts where (category_id = 26 and (from_date <= '".$getTime."' and (to_date = '0000-00-00 00:00:00' or to_date=null))) limit 16 ";
                $from_date = DB::select($query);
            }
            if($li->to_date != '0000-00-00 00:00:00' && $li->to_date != null){
             
                $query1 = "SELECT * from posts where (category_id = 26 and ((to_date != '0000-00-00 00:00:00') and (from_date <= '".$getTime."' and to_date >= '".$getTime."'))) limit 16";
                $to_date = DB::select($query1);
            }
          
        }
        $break_news =array_merge($from_date,$to_date);
      
       
        // $query = "SELECT * from posts where (category_id = 26 and (from_date <= '".$getTime."' and to_date <= '".$getTime."')) limit 16";
        // $break_news = DB::select($query);
        $limit = 16 - count($break_news);
        $latestpost = Post::where('category_id','!=',26)->orderBy('created_at', 'desc')->limit("$limit")->get()->toArray();

        $merge_arr = array_merge($break_news,$latestpost);
        shuffle($merge_arr);

        return response()->json($merge_arr);
    }


    public function search(Request $request)
    {
        $request = $request->all();
        $category_id = $request['selected_category'];

        $query = Post::query()
                    ->where('category_id', $category_id);

        if(isset($request['search_word'])) {
            $search_word = $request['search_word'];

            $query = $query->where(function($qu) use ($search_word){
                            $qu->where('title', 'LIKE', "%{$search_word}%");
                        });
        }
        $query = $query->orderBy('created_at','DESC')
                        ->get()
                        ->toArray();
        return $query;
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

    public function getLatestPostsByAllCatId($search_word) {
        // $posts = Category::join('posts', 'categories.id', '=', 'posts.category_id')
        //                 ->selectRaw('GROUP_CONCAT(posts.title order by posts.created_at desc limit 6) as title')
        //                 ->selectRaw('GROUP_CONCAT(posts.photo order by posts.created_at desc limit 6) as photo')
        //                 ->selectRaw('GROUP_CONCAT(posts.id order by posts.created_at desc limit 6) as post_id')
        //                 ->groupBy('categories.id')
        //                 ->get()
        //                 ->toArray();
        // $posts = Post::selectRaw('GROUP_CONCAT(title) as title')->groupBy('posts.category_id') ->get();
        // $posts = Post::select('postid')->get();

        // $sql = "SELECT id, GROUP_CONCAT(name SEPARATOR ',') FROM customers GROUP BY id";
        // $sql = "SELECT id, GROUP_CONCAT(name SEPARATOR ',') FROM customers GROUP BY id";

        // $sql = "select c.name , c.id, group_concat(p.title  order by p.created_at desc limit 6) as title, group_concat(p.photo order by p.created_at desc limit 4) as photo ,group_concat(p.id order by p.created_at desc limit 6) as post_id from categories AS c INNER join posts AS p on c.id = p.category_id group by c.id";
        // $sql = "SELECT categories.name,categories.id,posts.id as pid,posts.title,posts.created_at, posts.photo, posts.main_point FROM categories INNER JOIN posts ON categories.id = posts.category_id order by posts.created_at desc LIMIT 100";
        // $sql = "SELECT categories.name,categories.id,posts.id as pid,posts.title,posts.created_at, posts.photo, posts.main_point FROM categories INNER JOIN posts ON categories.id = posts.category_id WHERE posts.created_at > date_sub(now(), interval 1 month) order by posts.created_at desc";

        $sql = "";
        if($search_word == 'all_news_search'){
            $wh = '';
        }
        else{
            $wh = " AND (posts.title LIKe '%{$search_word}%' OR posts.main_point LIKe '%{$search_word}%' OR posts.body LIKe '%{$search_word}%')";
        }

        $cat = Category::where('id','!=',26)->select('id')->get();
        if(count($cat) == 0)
        {
            $posts = [];
            return response()->json($posts);
        }
        else{
            for($i = 0; $i < count($cat); $i++) {
                $sql.= "(SELECT categories.name,categories.pattern,categories.id,posts.id as pid,posts.title,posts.created_at, posts.photo, posts.main_point FROM categories INNER JOIN posts ON categories.id = posts.category_id WHERE categories.id = ".$cat[$i]['id']." ".$wh." order by posts.created_at desc LIMIT 25) UNION ";
            }
            $sql = trim($sql,' UNION ');

            $posts = DB::select($sql);
    
            return response()->json($posts);
        }
       

      
    }
}


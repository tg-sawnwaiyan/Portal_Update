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
    public function index()
    {
        $news_list = Post::join('categories','categories.id','=','posts.category_id')
                            ->select('posts.*','categories.name as cat_name')
                            ->orderBy('posts.created_at','DESC')
                            ->paginate(20);
        $category_list = Category::select('id','name')->get()->toArray();

        return response()->json(Array("news"=>$news_list,"category"=>$category_list));
    }

    // add news
    public function add(Request $request)
    {
        if(empty($request->photo)){
            $imageName = "";
        }else{
            $image = str_replace('data:image/png;base64,', '', $request->photo);
            $image = str_replace(' ', '+', $image);
            $imageName = str_random(10).'.'.'png';
            \File::put('upload/news/' . $imageName, base64_decode($image));
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
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = DB::table('posts')
                    ->join('categories', 'categories.id', '=', 'posts.category_id')
                    ->select('posts.*', 'categories.name as cat_name', 'categories.id as cat_id','categories.color_code')
                    ->where('posts.id',$id)->get();

        if($data[0]->photo == "")
        $data[0]->photo = null;
        return response()->json(array('news'=> $data));    
    }

    public function getNewsByCategory($id)
    {
        $cat = Category::where('id',$id)->select('name','color_code')->first();

        $newslist = Post::join('categories', 'posts.category_id', '=', 'categories.id' )
                        ->select('posts.*','categories.color_code')
                        ->where('posts.block_id','!=',0)
                        ->where('posts.category_id',$id)
                        ->where('posts.recordstatus',1)
                        ->orderBy('posts.created_at', 'DESC')
                        ->get()->toArray();
        $lenght = $tmp = $newarray1 = $newarray2 = $newarray3 = $aryPush = $aryEmpty = $More = [];

        //divide array new list by block
        foreach ($newslist as $value) {
            //find time difference
            $todayDate = Carbon\Carbon::now();
            $createdDate = $value['created_at'];
            $hourInterval = $todayDate->diffInHours($createdDate);
            
            $carbonCreated_dt = Carbon\Carbon::parse($createdDate);
            if($hourInterval <= 36)
            {
            $value['date_only'] = $carbonCreated_dt->month.'/'.$carbonCreated_dt->day;
            $value['new_news'] = 1;
            }
            $hour = $carbonCreated_dt->hour;
            $hour = $hour < 10 ? '0'.$hour : $hour;
            $minute = $carbonCreated_dt->minute;
            $minute = $minute < 10 ? '0'.$minute : $minute;
            $value['created_at'] = $carbonCreated_dt->month.'/'.$carbonCreated_dt->day.' '.$hour.':'.$minute;
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
            } 
        }
        $one = $two = $three = 0; 
        $moreNews  = $moreNews_concat = [];
        $lenght[] = count($newarray1);
        $lenght[] = count($newarray2);
        $lenght[] = count($newarray3);
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
            $moreNews_concat = array_chunk($moreNews, 36);
        } 
        if(array_filter($aryPush)){            
            $aryResults = array_chunk($aryPush, 3);
        }else{
            $aryResults = [];
        }
        return response()->json(array('cat'=> $cat,'cat_id' => $id,'newslist'=>$aryResults,'moreNews'=>$moreNews_concat));
    }

    public function getNewsByCategoryForMobile($id)
    {
        $cat = Category::where('id',$id)->select('name','color_code')->first();

        $newslist = Post::join('categories', 'posts.category_id', '=', 'categories.id' )->select('posts.*','categories.color_code')->where('posts.block_id','!=',0)->where('posts.category_id',$id)->where('posts.recordstatus',1)->orderBy('posts.created_at', 'DESC')->get()->toArray();

        $lenght = $tmp = $newarray1 = $newarray2 = $newarray3 = $aryPush = $aryEmpty = $More = $aryNews = [];

        foreach ($newslist as $value) {
            //find time difference
            $todayDate = Carbon\Carbon::now();
            $createdDate = $value['created_at'];
            $hourInterval = $todayDate->diffInHours($createdDate);
            
            $carbonCreated_dt = Carbon\Carbon::parse($createdDate);
            $hour = $carbonCreated_dt->hour;
                $hour = $hour < 10 ? '0'.$hour : $hour;
            $minute = $carbonCreated_dt->minute;
            $minute = $minute < 10 ? '0'.$minute : $minute;
            $value['created_at'] = $carbonCreated_dt->month.'/'.$carbonCreated_dt->day.' '.$hour.':'.$minute;
            if($hourInterval <= 36)
            {
            $value['new_news'] = 1;
            $value['date_only'] = $carbonCreated_dt->month.'/'.$carbonCreated_dt->day;
            }
            $tmp[$value['block_id']][] = $value;
        }

        //separted divied block array
        foreach ($tmp as $key => $value) {
            if($key == 1){
                $newarray1 = $value;
            }elseif($key == 2){
                $newarray2 = array_chunk($value, 2);
            }elseif($key == 3){
                $newarray3 = array_chunk($value, 5);
            } 
        }
 
        $two = $three = 0; 
        $moreNews  = $moreNews_concat = [];

        $lenght[] = count($newarray2);
        $lenght[] = count($newarray3);
                 
        for ($i=0; $i <= max($lenght); $i++) { 
            /***for block id two***/       
            if(isset($newarray2[$i]) && $two < 1){
                array_push($aryPush, $newarray2[$i]);                
                $two++;
            }else if(isset($newarray2[$i]) && $two >= 1){
                array_push($More, $newarray2[$i]);
            }
            else if(!isset($newarray2[$i])){
                array_push($aryPush, $aryEmpty);
            }
            /***for block id three***/      
            if(isset($newarray3[$i]) && $three < 1){
                array_push($aryPush, $newarray3[$i]);                
                $three++;
            }else if(isset($newarray3[$i]) && $three >= 1){
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
        } 
        if(array_filter($moreNews)){            
            $moreNews = array_chunk($moreNews, 12);
        }else{
            $moreNews = [];
        }
        
        if(array_filter($aryPush)){            
            $aryResults = array_chunk($aryPush, 2);
        }else{
            $aryResults = [];
        }
        $result = array('cat'=> $cat,
                        'cat_id' => $id,
                        'newslist'=>$aryResults,
                        'moreNews'=>$moreNews,
                        'bigNews'=>$newarray1
                    );
        return response()->json($result);
    }

    public function show_related($id)
    {
        $related_news = Post::select('related_news','category_id')->where('id',$id)->get();

        $post_id = explode(",",$related_news[0]["related_news"]);

        if($related_news[0]["related_news"] != null) {
            $news = Post::join('categories','categories.id','=','posts.category_id')
                            ->select('posts.*','categories.name as cat_name')
                            ->whereIn('posts.id', $post_id)->get();
        }
        else{
            $news = null;
        }
        $latest = Post::select('*')
                    ->where('category_id',$related_news[0]["category_id"])
                    ->orderBy('created_at','DESC')
                    ->limit('5')->get();
        $data = array("related_news"=>$news, "latest_news" => $latest);
        return $data;
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
        if(!empty($request->photo)){
            if(strpos($request->photo,"data:image/png;base64") !== false ){

                $file       = $post->photo;
                $filename   = './upload/news/'.$file;
                \File::delete($filename);

                $image = str_replace('data:image/png;base64,', '', $request->photo);
                $image = str_replace(' ', '+', $image);
                $imageName = str_random(10).'.'.'png';
                \File::put('upload/news/' . $imageName, base64_decode($image));

            }else{
                $imageName = $post->photo;
            }
        }else{
            $file       = $post->photo;
            $filename   = './upload/news/'.$file;
            \File::delete($filename);

            $imageName = "";
        }

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
        $post->user_id = 1;
        $post->save();
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
        // if($cat_id == 0)
        // {
        //     $posts = Post::join('categories','categories.id','=','posts.category_id')->select('posts.*','categories.name as cat_name')->orderBy('posts.created_at','DESC')->paginate(20);
        // }else{
        //     $posts = Post::join('categories','categories.id','=','posts.category_id')->select('posts.*','categories.name as cat_name')->where('category_id',$cat_id)->orderBy('posts.created_at','DESC')->paginate(20);
        // }

        //return response()->json($posts);
        return response()->json('The news successfully deleted');
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
            if(isset($request['contents']))
            {                
                $content = explode(",", $request['contents']);
                $query = $query->where(function($qu) use ($search_word,$content){
                        foreach($content as $k => $v){
                            $qu->orWhere('posts.'.$v, 'LIKE', "%{$search_word}%");
                        }      
                });
            }else{
                $query = $query->where(function($qu) use ($search_word){
                    $qu->where('posts.title', 'LIKE', "%{$search_word}%")
                        ->orWhere('posts.body', 'LIKE', "%{$search_word}%")
                        ->orWhere('posts.main_point', 'LIKE', "%{$search_word}%")
                        ->orWhere('posts.created_by_company', 'LIKE', "%{$search_word}%"); 
                });
            }
        }
        
        $query = $query->orderBy('posts.created_at','DESC')
                        ->paginate(20);
        $postCount = $query->count();
        
        return  response()->json(array('query'=>$query, 'postCount'=>$postCount));
    }

    public function getPostById(Request $request) 
    {
        $request = $request->all();
        $posts = Post::where('id','<>',$request['post_id'])->where("category_id",$request['cat_id']);

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
}   
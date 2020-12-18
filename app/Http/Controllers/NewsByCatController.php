<?php

namespace App\Http\Controllers;
 
use App\NewsByCat;
use Auth;
use DB;
use Illuminate\Http\Request;
 
class NewsByCatController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $news = NewsByCat::orderBy('id', 'DESC')->paginate(20);
        return response()->json($news);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function add(Request $request)
    {        
        $news = new NewsByCat();
        $news->post_date    = $request->input('post_date');
        $news->type         = $request->input('type');
        $news->status       = $request->input('status');
        $news->description  = $request->input('description');

        $news ->save();

        return response()->json('Success ');

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
         $news = NewsByCat::find($id);

         return response()->json($news);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($id,Request $request)
    {
        $news = NewsByCat::find($id);

        $news->post_date    = $request->input('post_date');
        $news->type         = $request->input('type');
        $news->status       = $request->input('status');
        $news->description  =$request->input('description');
        $news->save();
        return response()->json('successfully updated');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    { 

        $news = NewsByCat::find($id);
        $news->delete();
        $linked_news_list = NewsByCat::orderBy('id', 'DESC')->paginate(20);
        return response()->json($linked_news_list);
    }

    public function search(Request $request)
    {
        $request = $request->all();
        if(isset($request['search_word'])) {
            $search_word = $request['search_word'];
        }else{
            $search_word = null;
        }
        $news = NewsByCat::query()
                            ->where('description', 'LIKE', "%{$search_word}%")
                            ->orderBy('id','DESC')
                            ->paginate(20);
        return response()->json($news);

    }

}

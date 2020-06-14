<?php

namespace App\Http\Controllers;

// use Illuminate\Http\Request;
// use App\NewsByCat;
// use Carbon\Carbon;

use App\NewsByCat;
use Auth;
use DB;
use Illuminate\Http\Request;
// use File;
// use Illuminate\Http\File;
// use Illuminate\Support\Facades\Storage;

class NewsByCatController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $news =NewsByCat::orderBy('id', 'DESC')->paginate(20);
        return response()->json($news);
    }
    public function slider()
    {

        $ads =Advertisement::where('recordstatus',1)->orderBy('id', 'DESC')->get();
        return response()->json($ads);
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
    public function add(Request $request)
    {        
        $news = new NewsByCat();
        $news->post_date = $request->input('post_date');
        $news->type = $request->input('type');
        $news->status=$request->input('status');
        $news->description=$request->input('description');

        $news ->save();

        // $newsByCat = new NewsByCat();
        // $newsByCat->post_date = $request->input('post_date');
        // $newsByCat->type = $request->input('type');
        // $newsByCat->status= $request->input('status');
        // $newsByCat->description= $request->input('description');
        // // return($request->input('type'));exit;
        // $newsByCat ->save();
        return response()->json('Success ');

    }

    public function getLogoImage(Request $request) 
    { 
        $logofile = new File();
        $logofile = public_path().'\images\logo.png';
        return response('logofile')->json('Success ');
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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

            $news->post_date = $request->input('post_date');
            $news->type = $request->input('type');
            $news->status = $request->input('status');
            $news->description=$request->input('description');
            $news->save();
            return response()->json('successfully updated');
        //return response()->json($ads);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    { 
        //
        $ads = Advertisement::find($id);
        $file= $ads->photo;
        $filename = './upload/advertisement/'.$file;
        //$filename = public_path().'/upload/advertisement/'.$file;
        \File::delete($filename);

        $pdffile= $ads->pdf;
        $pdffilename = './upload/static/'.$pdffile;
        //$filename = public_path().'/upload/advertisement/'.$file;
        \File::delete($pdffilename);

        $ads->delete();
        $advertisements = Advertisement::orderBy('id', 'DESC')->paginate(20);
        return response()->json($advertisements);
        // return response()->json('The successfully deleted');
    }

    public function search(Request $request)
    {
        $request = $request->all();
        if(isset($request['search_word'])) {
            $search_word = $request['search_word'];
        }else{
            $search_word = null;
        }
        $advertisement = Advertisement::query()
                            ->where('title', 'LIKE', "%{$search_word}%")
                            ->orderBy('id','DESC')
                            ->paginate(20);
        return response()->json($advertisement);

    }

    public function activate($id)
    {
        $ads = Advertisement::find($id);

        if($ads->recordstatus == 0 ) {
            $ads->recordstatus =1;
        }
        else {
            $ads->recordstatus =0;
        }
        $ads->save();
       return response()->json('success');
    }
}

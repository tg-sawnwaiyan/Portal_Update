<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Advertisement;
use Carbon\Carbon;
use File;
// use Illuminate\Http\File;
// use Illuminate\Support\Facades\Storage;

class AdvertisementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ads =  Advertisement::orderBy('id', 'DESC')->paginate(20);
        return response()->json($ads);
    }
    
    public function slider()
    {
        $ads =  Advertisement::where('recordstatus',1)->orderBy('id', 'DESC')->get();
        return response()->json($ads);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function add(Request $request)
    {
        $logo_imgname = '';
        $pdfname = '';

        if(is_object($request->photo)){
            $imageName = $request->photo->getClientOriginalName();
            $imgname = str_replace(' ', '', $imageName);
            $imgname = strtolower($imgname);
        }
        else{
            $logo_imgname = $request->photo;
            $string = str_replace(' ', '-', Carbon::now());
            $string = preg_replace('/[^A-Za-z0-9\-]/', '', $string);
            $imgname = 'logo_'.$string.'.png';
        }

        if(is_object($request->pdf)){
            $pdfName = $request->pdf->getClientOriginalName();
            $pdfname = str_replace(' ', '', $pdfName);
            $pdfname = strtolower($pdfname);
        }
                
        $ads = new Advertisement();
        $ads->title = $request->input('title');
        $ads->description = $request->input('description');
        $ads->link=$request->input('link');
        $ads->location=$request->input('location');
        $ads->pdf = $pdfname;
        $ads->show_flag = $request->input('show_flag');
        $ads->photo = $imgname;
        $ads->user_id = 1;

        $ads ->save();

        if($logo_imgname != 'tis_advertisement_logo.png') {
            $request->photo->move('./upload/advertisement/', $imgname);
        }
        else{
            $old_path = 'images/tis_advertisement_logo.png';
            $new_path = 'upload/advertisement/logo_'.$string.'.png';
            $move = File::copy($old_path, $new_path);
        }

        if($pdfname != ''){
            $request->pdf->move('./upload/static/', $pdfname);
        }
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
        $ads = Advertisement::find($id);
        return response()->json($ads);
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
         
        if(is_object($request->photo)) {
            $imageName = $request->photo->getClientOriginalName();
            $imageName = str_replace(' ', '', $imageName);
            $imageName = strtolower($imageName);
            $request->photo->move('./upload/advertisement/', $imageName);
        }else {
            $logo_imgname = $request->photo;
            $string    = str_replace(' ', '-', Carbon::now());
            $string    = preg_replace('/[^A-Za-z0-9\-]/', '', $string);
            $imageName = 'logo_'.$string.'.png';
            $old_path  = 'images/tis_advertisement_logo.png';
            $new_path  = 'upload/advertisement/logo_'.$string.'.png';
            $move      = File::copy($old_path, $new_path);
        }
        
        if(is_object($request->pdf)) {
            $pdfName = $request->pdf->getClientOriginalName();
            $pdfName = str_replace(' ', '', $pdfName);
            $pdfName = strtolower($pdfName);
            $request->pdf->move('./upload/static/', $pdfName);
        } else {
            $pdfName = $request->pdf;
        }
       
        $ads = Advertisement::find($id);
        if(is_object($request->photo)) {
            $file       = $ads->photo;
            $filename   = './upload/advertisement/'.$file;
            \File::delete($filename);
        }

        if(is_object($request->pdf)) {
            $file       = $ads->pdf;
            $filename   = './upload/static/'.$file;
            \File::delete($filename);
        }

        $ads->title     = $request->input('title');
        $ads->description = $request->input('description');
        $ads->link      = $request->input('link');
        $ads->location  =$request->input('location');
        $ads->photo     = $imageName;
        $ads->pdf       = $pdfName;
        $ads->show_flag = $request->input('show_flag');
        $ads->user_id   = 1;
        $ads->save();
        return response()->json('successfully updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    { 
        //
        $ads = Advertisement::find($id);
        $file= $ads->photo;
        $filename = './upload/advertisement/'.$file;
        \File::delete($filename);

        $pdffile= $ads->pdf;
        $pdffilename = './upload/static/'.$pdffile;
        \File::delete($pdffilename);

        $ads->delete();
        $advertisements = Advertisement::orderBy('id', 'DESC')->paginate(20);
        return response()->json($advertisements);
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

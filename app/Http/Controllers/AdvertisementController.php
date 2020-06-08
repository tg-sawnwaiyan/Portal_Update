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

        $ads =Advertisement::orderBy('id', 'DESC')->paginate(20);
        return response()->json($ads);
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
    public function store(Request $request)
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
            // $current_time = Carbon::now();
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
        $ads->photo = $imgname;
        $ads->user_id = 1;

        $ads ->save();

        if($logo_imgname != 'logo.png') {
            $request->photo->move('./upload/advertisement/', $imgname);
        }
        else{
            $old_path = public_path().'\images\logo.png';
            $new_path = public_path().'\upload\advertisement\logo_'.$string.'.png';
            $move = File::copy($old_path, $new_path);
        }

        if($pdfname != ''){
            $request->pdf->move('./upload/static/', $pdfname);
        }
        //return $ads;
        return response()->json('Success ');

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
        // $request->validate([
        //     'title' => 'required',
        //     'location'=>'required',
        // ]);
        // if($request->photo != 'logo.png') {
        if(is_object($request->photo)) {
            $imageName = $request->photo->getClientOriginalName();
            $imageName = str_replace(' ', '', $imageName);
            $imageName = strtolower($imageName);
            // $request->photo->move(public_path('/upload/advertisement'), $imageName);
            $request->photo->move('./upload/advertisement/', $imageName);
        } 
        // }
        else {
            $logo_imgname = $request->photo;
            // $current_time = Carbon::now();
            $string = str_replace(' ', '-', Carbon::now());
            $string = preg_replace('/[^A-Za-z0-9\-]/', '', $string);
            $imageName = 'logo_'.$string.'.png';
            $old_path = public_path().'\images\logo.png';
            $new_path = public_path().'\upload\advertisement\logo_'.$string.'.png';
            $move = File::copy($old_path, $new_path);
        }
        
        if(is_object($request->pdf)) {
            $pdfName = $request->pdf->getClientOriginalName();
            $pdfName = str_replace(' ', '', $pdfName);
            $pdfName = strtolower($pdfName);
            // $request->pdf->move(public_path('/upload/advertisement'), $imageName);
            $request->pdf->move('./upload/static/', $pdfName);
        } else {
            $pdfName = $request->pdf;
        }
        //   $uploadData = array(
        //       'title' => $request->input('title'),
        //       'description' => $request->input('description'),
        //       'link'=>$request->input('link'),
        //       'location'=>$request->input('location'),
        //       'photo' => $imageName,
        //       'user_id' => 1,
        //       'recordstatus' => 1
        //  );
            $ads = Advertisement::find($id);
            if(is_object($request->photo)) {
                     $file= $ads->photo;
                     $filename = './upload/advertisement/'.$file;
                   \File::delete($filename);
                }

            if(is_object($request->pdf)) {
                $file= $ads->pdf;
                $filename = './upload/static/'.$file;
                \File::delete($filename);
            }

            $ads->title = $request->input('title');
            $ads->description = $request->input('description');
            $ads->link=$request->input('link');
            $ads->location=$request->input('location');
            $ads->photo = $imageName;
            $ads->pdf = $pdfName;
            $ads->user_id = 1;
            $ads->save();
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

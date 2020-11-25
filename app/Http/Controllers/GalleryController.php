<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Gallery;
use DB;
use File;

class GalleryController extends Controller
{
    public function getPhotobyCustomerId($profile_id,$type) {
        if($type == 'hospital')
        {
            $photo_list = DB::select("SELECT g.id,g.title,g.photo,g.description,  CONCAT('/upload/hospital_profile/',g.photo)  as src 
                                    FROM galleries as g INNER JOIN hospital_profiles as h ON g.profile_id = h.id WHERE g.type='photo' AND g.profile_id = ".$profile_id);
        }
        else{
            $photo_list = DB::select("SELECT g.id,g.title,g.photo,g.description,  CONCAT('/upload/nursing_profile/',g.photo)  as src 
                                FROM galleries as g INNER JOIN nursing_profiles as n ON g.profile_id = n.id WHERE g.type='photo' AND g.profile_id = ".$profile_id);
        }
        return $photo_list;        
    }

    public function getVideobyCustomerId($customer_id,$type) {
        if($type == 'hospital')
        {
            $video_list = Gallery::where("galleries.profile_id",$customer_id)
                        ->where('type','=', 'video')->select('galleries.id','galleries.title','galleries.photo','galleries.description')
                        ->join('hospital_profiles','hospital_profiles.id','=','galleries.profile_id')
                        ->get()
                        ->toArray();
        }
        else{
            $video_list = Gallery::where("galleries.profile_id",$customer_id)
                            ->where('type','=', 'video')->select('galleries.id','galleries.title','galleries.photo','galleries.description')
                            ->join('nursing_profiles','nursing_profiles.id','=','galleries.profile_id')
                            ->get()
                            ->toArray();
        }        
        return $video_list;
    }

    public function getPanoramabyCustomerId($customer_id) {
        $sql = "SELECT id,photo,title,description,type,'' as path, '' as file FROM galleries WHERE type='panorama' and profile_id=$customer_id";
        $panorama_list = DB::select($sql);
        return $panorama_list;
    }

    public function deleteGallery(Request $request) {
        $request = $request->all();
        if($request['custype'] == 'nursing') {
            if($request['type'] == 'photo') {
                $file = 'upload/nursing_profile/'.$request['photo'];
            } 
            if($request['type'] == 'panorama') {
                $file = 'upload/nursing_profile/Imagepanorama/'.$request['photo'];
            } 
        }
        else{
            $file = 'upload/hospital_profile/'.$request['photo'];
        }        
        File::delete($file);
        Gallery::where(['id'=> $request['id']])->delete(); 
    }
}
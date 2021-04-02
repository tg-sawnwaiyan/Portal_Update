<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\Job;
use App\NursingProfile;
use App\HospitalProfile;

//サイトマップを追加 20210402 ここから
class SitemapController extends Controller
{
    public function index()
    {
        $xml = "<urlset xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\">\n";
        
        $url = config('app.url');

        $siteMaplists = [$url, 
                         $url."/startpage",$url."/aboutus",
                         $url."/sitepolicy",$url."/privacyPolicy",
                         $url."/contract",$url."/nursingSearch",
                         $url."/hospital_search",$url."/jobSearch",
                        ];

        $news = Post::select('posts.id','posts.updated_at')
                ->where('posts.recordstatus', '=', 1)
                ->orderBy('posts.created_at', 'desc')->get()->toArray();

        $jobs = Job::select('jobs.id','jobs.updated_at')
                ->where('jobs.recordstatus', '=', 1)
                ->orderBy('jobs.created_at', 'desc')->get()->toArray();

        $nursings = NursingProfile::select('id','updated_at')
                ->where('activate', '=', 1)
                ->orderBy('created_at', 'desc')->get()->toArray();

        $hospitalprofiles = HospitalProfile::select('id','updated_at')
                ->where('activate', '=', 1)
                ->orderBy('created_at', 'desc')->get()->toArray();

        $newsdetail = $url."/newsdetails"."/";
        $nursingdetail = $url."/profile/nursing"."/";
        $hospitaldetail = $url."/profile/hospital"."/";
        $jobdetail = $url."/job_details"."/";
        
        foreach($news as $new){
            $newlist = ['id'=> $newsdetail.$new['id'],'updated_at'=>$new['updated_at']];
            array_push($siteMaplists,$newlist);
        }

        foreach($jobs as $job){
            $jobist = ['id'=> $jobdetail.$job['id'],'updated_at'=>$job['updated_at']];
            array_push($siteMaplists,$jobist);
        }

        foreach($nursings as $nursing){
            $nursinglist = ['id'=> $nursingdetail.$nursing['id'],'updated_at'=>$nursing['updated_at']];
            array_push($siteMaplists,$nursinglist);
        }

        foreach($hospitalprofiles as $hospitalprofile){
            $hospitallist = ['id'=> $hospitaldetail.$hospitalprofile['id'],'updated_at'=>$hospitalprofile['updated_at']];
            array_push($siteMaplists,$hospitallist);
        }
        //dump($siteMaplists);die();
        foreach ($siteMaplists as $list) {
            $xml .= $this->create_item($list,$url);
        }
        
        $xml .= "</urlset>\n";
        $filename = "sitemap.xml";
        \File::put($filename, $xml);
        return response($xml,200)->header("Content-type","text/xml");
        
    }

    private function create_item($data,$url)
    {
        
        $item = "<url>\n";
        if(!is_array($data)){
            if($data == $url){
                $item .= "<loc>" . $data . "</loc>\n";
                $item .= "<priority>1.0</priority>\n";
            }else{
                $item .= "<loc>" . $data . "</loc>\n";
            }  
        }else{
           // dump($data);die();
            $item .= "<loc>" . $data['id'] . "</loc>\n";
            $item .= "<lastmod>" . $data['updated_at'] . "</lastmod>\n";
            $item .= "<changefreq>daily</changefreq>\n";
            $item .= "<priority>0.9</priority>\n";
        }
        $item .= "</url>\n";

        return $item;
    }
}
 //20210402 ここまで
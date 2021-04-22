<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\Advertisement;

use App\Http\Controllers\SmartFeed\Channel;
use App\Http\Controllers\SmartFeed\Feed;
use App\Http\Controllers\SmartFeed\Item;

class SmartFeedController extends Controller
{
    public function update_xml(){
        
        $feed = $this->create_xml();
        $feed->save_xml();
    }
    public function get_xml(){

        $feed = $this->create_xml();
        $feed->render_xml();
        return response($feed, 200)->header('Content-Type', 'application/xml');
    }
    public function create_xml()
    {
        $url = "https://t-i-s.jp/";
        $title = "TIS（ティーズ）";
        $description = "介護医療福祉の総合サイト";
        $today_date = date('Y-m-d H:i:s');
        $language = 'ja';
        $copyright = '(c) TRUST-ESTATE Co,Ltd.';
        $logo = $url."images/logo.png";
        $darklogo = $url."images/logo.png";
        
        $news = Post::join('categories','categories.id','=','posts.category_id')
                ->select('posts.*','categories.name as cat_name')
                ->where('categories.name', '!=', 'PR')
                //->where('posts.recordstatus', '=', 1)
                ->where('posts.smartnew', '=', 1)
                ->orderBy('posts.created_at', 'desc')->skip(0)->take(150)->get()->toArray();

        $ads =  Advertisement::where('recordstatus',1)->orderBy('id', 'DESC')->skip(0)->take(2)->get()->toArray();

        $feed = new Feed();

        $channel = new Channel();

        $channel->title($title)
                ->url($url)
                ->description($description)
                ->pubDate(strtotime($today_date))
                ->language($language)
                ->copyright($copyright)
                ->ttl(1)
                ->logo($logo)
                ->darklogo($darklogo)
                ->appendTo($feed);
               
        foreach ($news as $news) {
            $this->create_item($news,$ads,$url,$channel);
        }
        return $feed;
    }

    private function create_item($data,$ads,$url,$channel)
    {
        $link = $url."newsdetails/".$data["id"];
        $content = $media = $google = "";
        if(!empty($data["photo"])){
            $content .= "<figure>\n";
            $content .= "<img src=\"".$url."upload/news/".$data["photo"]."\" />\n";
            $content .= "<figcaption>".$data["cat_name"]."ニュース画像</figcaption>\n";
            $content .= "</figure>\n";
        }
        $body = str_replace('&nbsp;','',$data["body"]);
        $content .=  $body;
        if(!empty($data["photo"])){
            $media = $url."upload/news/".$data["photo"];
        }
        $pagview = "/"."newsdetails/".$data["id"];
        $google = "<script>\n";
        $google .= "(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
            (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
            m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
            })(window,document,'script','//www.google-analytics.com/analytics.js','ga');\n";
        $google .= "ga('create', 'UA-161193570-2', 't-i-s.jp');\n";
        $google .= "ga('require', 'displayfeatures');\n";
        $google .= "ga('set', 'referrer', $url);\n";
        $google .= "ga('send', 'pageview', '$pagview');\n";
        $google .= " </script>\n";
        $item = new Item();
        $item->title($data['title'])
             ->language('ja')
             ->url($link)
             ->creator($data["created_by_company"])
             ->category($data["cat_name"])
             ->status("active")
             ->media($media)
             ->description($data["main_point"])
             ->pubDate(strtotime($data["created_at"]))
             ->contentEncoded($content)
             ->guid($link, false)
             ->preferCdata(true) // By this, title and description become CDATA wrapped HTML.
             ->advertisements($ads)
             ->googleanalytics($google)
             ->appendTo($channel);
    }

}

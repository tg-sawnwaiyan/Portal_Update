<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\Advertisement;

class SmartFeedController extends Controller
{
    public function index()
    {
        $url = "https://t-i-s.jp/";
        $news = Post::join('categories','categories.id','=','posts.category_id')
                ->select('posts.*','categories.name as cat_name')
                ->where('categories.name', '!=', 'PR')
                ->where('posts.recordstatus', '=', 1)
                ->where('posts.smartnew', '=', 1)
                ->orderBy('posts.created_at', 'desc')->get()->toArray();

        $ads =  Advertisement::where('recordstatus',1)->orderBy('id', 'DESC')->skip(0)->take(2)->get()->toArray();
        
        $xml = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
        $xml = "<rss version=\"2.0\"
        xmlns:content=\"http://purl.org/rss/1.0/modules/content/\"
        xmlns:dc=\"http://purl.org/dc/elements/1.1/\"
        xmlns:media=\"http://search.yahoo.com/mrss/\"
        xmlns:snf=\"http://www.smartnews.be/snf\">";

        $xml .= "<channel>\n";
        $xml .= "<title>TIS（ティーズ）</title>
                 <link>$url</link>
                 <description>介護医療福祉の総合サイト</description>
                 <copyright>(c) TRUST-ESTATE Co,Ltd.</copyright>
	             <ttl>1</ttl>
                 <snf:logo><url>https://t-i-s.jp/images/logo.png</url></snf:logo>
                 <snf:darkModeLogo><url>https://t-i-s.jp/images/logo.png</url></snf:darkModeLogo>
                 <language>ja</language>";
        foreach ($news as $news) {
            $xml .= $this->create_item($news,$ads,$url);
        }
        $xml .= "</channel>\n";
        $xml .= "</rss>\n";

        return response($xml,200)->header("Content-type","text/xml");
    }

    private function create_item($data,$ads,$url)
    {
        $item = "<item>\n";
        $item .= "<title>" . $data['title'] . "</title>\n";
        $item .= "<link>".$url."newsdetails/".$data["id"]."</link>\n";
        $item .= "<dc:creator><![CDATA[" . $data["created_by_company"] . "]]></dc:creator>\n";
        $item .= "<category><![CDATA[" . $data["cat_name"] . "]]></category>\n";
        $item .= "<media:status>active</media:status>\n";
        $item .= "<guid isPermaLink='false'>".$url."newsdetails/".$data["id"]."</guid>\n";
        $item .= "<dc:language>ja</dc:language>";
        if(!empty($data["photo"])){
        $item .= "<media:thumbnail>".$url."upload/news/".$data["photo"]."</media:thumbnail>";
        }
        $item .= "<description><![CDATA[" . $data["main_point"] . "]]></description>\n";
        $item .= "<pubDate><![CDATA[" .date(DATE_RSS,strtotime($data["created_at"])) . "]]></pubDate>\n";
        $item .= "<content:encoded><![CDATA[";
        if(!empty($data["photo"])){
            $item .= "<figure>\n";
            $item .= "<img src=\"".$url."upload/news/".$data["photo"]."\" />\n";
            $item .= "<figcaption>".$data["cat_name"]."ニュース画像</figcaption>\n";
            $item .= "</figure>\n";
        }
        $item .=  $data["body"]."]]></content:encoded>\n";
        $item .= "<snf:advertisement>\n";
        foreach ($ads as $ads) {
            $item .= $this->create_ads($ads,$url);
        }
        $pagview = "/"."newsdetails/".$data["id"];
        $item .= "</snf:advertisement>\n";
        $item .= "<snf:analytics><![CDATA[";
        $item .= "<script>\n";
        $item .= "(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
            (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
            m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
            })(window,document,'script','//www.google-analytics.com/analytics.js','ga');\n";
        $item .= "ga('create', 'UA-161193570-2', 't-i-s.jp');\n";
        $item .= "ga('require', 'displayfeatures');\n";
        $item .= "ga('set', 'referrer', 'https://t-i-s.jp/');\n";
        $item .= "ga('send', 'pageview', '$pagview');\n";
        $item .= " </script>\n]]>\n</snf:analytics> \n";
        $item .= "</item>\n";
        return $item;
    }

    private function create_ads($ads,$url)
    {
        $link = $ads["link"] ? $ads["link"] : $url."upload/static/".$ads["pdf"];
        $advertiser = $ads["description"] ? strtok($ads["description"], " \n\t") : $ads["title"];
        $thumbnail = "".$url."upload/advertisement/".$ads["photo"];
        
        $advertisement = "<snf:sponsoredLink link=\"".htmlspecialchars($link)."\" title=\"".$ads["title"]."\"  thumbnail=\"".htmlspecialchars($thumbnail)."\" advertiser =\"".$advertiser."\"/>\n";
        
        return $advertisement;
    }
}

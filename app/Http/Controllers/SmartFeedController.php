<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;

class SmartFeedController extends Controller
{
    public function index()
    {
        $news = Post::join('categories','categories.id','=','posts.category_id')
                ->select('posts.*','categories.name as cat_name')
                ->where('categories.name', '!=', 'PR')
                ->where('posts.smartnew', '=', 1)
                ->orderBy('posts.created_at', 'desc')->skip(0)->take(30)->get()->toArray();
        
        $xml = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
        $xml = "<rss version=\"2.0\"
        xmlns:content=\"http://purl.org/rss/1.0/modules/content/\"
        xmlns:dc=\"http://purl.org/dc/elements/1.1/\"
        xmlns:media=\"http://search.yahoo.com/mrss/\"
        xmlns:snf=\"http://www.smartnews.be/snf\">";

        $xml .= "<channel>\n";
        $xml .= "<title>TIS（ティーズ）</title>
                 <link>https://test.t-i-s.jp/</link>
                 <description>介護医療福祉の総合サイト</description>
                 <copyright>(c) TRUST-ESTATE Co,Ltd.</copyright>
	             <ttl>1</ttl>
                 <snf:logo><url>https://test.t-i-s.jp/images/logo.png</url></snf:logo>
                 <snf:darkModeLogo><url>https://test.t-i-s.jp/images/logo.png</url></snf:darkModeLogo>
                 <language>ja</language>";
        foreach ($news as $news) {
            $xml .= $this->create_item($news);
        }
        $xml .= "</channel>\n";
        $xml .= "</rss>\n";
        
        //echo $xml;

        return response($xml,200)->header("Content-type","text/xml");
    }

    private function create_item($data)
    {
        $item = "<item>\n";
        $item .= "<title>" . $data['title'] . "</title>\n";
        $item .= "<link>https://test.t-i-s.jp/newsdetails/".$data["id"]."</link>\n";
        $item .= "<dc:creator><![CDATA[" . $data["created_by_company"] . "]]></dc:creator>\n";
        $item .= "<category><![CDATA[" . $data["cat_name"] . "]]></category>\n";
        $item .= "<guid isPermaLink='false'>https://test.t-i-s.jp/newsdetails/".$data["id"]."</guid>\n";
        $item .= "<dc:language>ja</dc:language>";
        $item .= "<media:thumbnail>https://test.t-i-s.jp/upload/news/".$data["photo"]."</media:thumbnail>";
        $item .= "<description><![CDATA[" . $data["main_point"] . "]]></description>\n";
        $item .= "<pubDate><![CDATA[" .date(DATE_RSS,strtotime($data["created_at"])) . "]]></pubDate>\n";
        $item .= "<content:encoded><![CDATA[" . $data["body"] . "]]></content:encoded>\n";
        $item .= "</item>\n";
        return $item;
    }
}
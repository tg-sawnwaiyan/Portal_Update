<?php

namespace App\Http\ViewTwitter;

use Illuminate\View\View;
use DB;

class Twitter
{
    public $newsId;

    public $tweetData;
    /**
     * Create a movie composer.
     *
     * @return void
     */
    public function __construct()
    {
        $url = url()->current();
        $pos = strrpos($url, '/');
        $this->newsId = $pos === false ? $url : substr($url, $pos + 1);
    }

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        
        $tweetData = DB::table('posts')->where('posts.id',$this->newsId)->first();
        $view->with('tweetData', $tweetData);
    }
}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">

<!-- CSRF Token -->
<meta name="csrf-token" content="{{ csrf_token() }}">
<meta name="user" content="{{ Auth::user() }}">
<?php 
header("Cache-Control:no-cache,no-store,must-revalidate,max-age=0");
header("Cache-Control:pre-check=0,post-check=0,false");
header("Pragma:no-cache");
?>
@if(isset($tweetData))
<meta name="twitter:card" content="summary" />
<meta property="og:url" content="{{ Config::get('app.url') }}{{ '/newsdetails/'.$tweetData->id }}" />
<meta property="og:title" content="{{ $tweetData->title }}" />
<meta property="og:description" content="{{ $tweetData->body }}" />
@if(!empty($tweetData->photo))
<meta property="og:image" content="{{ Config::get('app.url') }}{{ '/upload/news/'.$tweetData->photo }}" />
@endif
@endif
<meta http-equiv="cache-control" content="no-cache">
<meta http-equiv="expires" content="0">
<meta http-equiv="pragma" content="no-cache">
<meta http-equiv="Cache-Control" content="no-cache" />
<meta http-equiv="Pragma" content="no-cache" />
<meta http-equiv="Expires" content="0" />
<!-- <title>{{ config('app.name', 'Healthcare Portal') }}</title> -->
<title>ティーズ（TIS）｜介護医療福祉の総合サイト</title>
<meta name="description" content="ティーズ（TIS）は介護医療福祉の総合サイトです。病院・医療、特養・介護、有料老人ホーム、訪問介護・看護、デイサービス、グループホーム、新型コロナなど、
様々なカテゴリのニュースの掲載をしております。また、介護施設や病院の検索も行うことができます。さらに老人ホームや病院の求人も掲載しております。">
<link rel="shortcut icon" href="{{ asset('/images/icon1.ico') }}">
<script src="{{ asset('js/manifest.js') }}" defer></script> 
<script src="{{ asset('js/vendor.js') }}" defer></script>
<script src="{{ asset('js/app.js') }}?{{ Config::get('version.date') }}" defer></script>
<script src="https://unpkg.com/delayed-scroll-restoration-polyfill@0.1.1/index.js"></script>
<!-- <script src="https://cse.google.com/cse.js?cx=8f501e7f8a9c94ad7" defer></script> -->

<!-- <script src="/js/manifest.js"></script> -->
<!-- <script src="/js/vendor.js"></script> -->
<script src="{{ asset('js/jquery-3.4.1.min.js') }}"></script>
<script src="{{ asset('js/myJs.js') }}" defer></script>
<script src="{{ asset('js/vue-clazy-load.js') }}"></script>
<!-- Fonts -->
<!--mailbox-->
<!-- Styles -->
<link href="{{ asset('css/app.css') }}?{{ Config::get('version.date') }}" rel="stylesheet">
<!-- <link href="{{ asset('css/mystyle_kathy.css') }}?{{ Config::get('version.date') }}" rel="stylesheet"> -->
<link href="{{ asset('css/admin.css') }}?{{ Config::get('version.date') }}" rel="stylesheet">
<link href="{{ asset('css/user.css') }}?{{ Config::get('version.date') }}" rel="stylesheet">
<!-- <link href="{{ asset('css/mystyle_yatanar.css') }}?{{ Config::get('version.date') }}" rel="stylesheet"> -->
<!-- <link href="{{ asset('css/categorymenu.css') }}?{{ Config::get('version.date') }}" rel="stylesheet"> -->
<link href="{{ asset('css/all.css') }}" rel="stylesheet">
<link href="{{ asset('css/jquery.scrolling-tabs.min.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/fullpage.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/pannellum.css') }}"/>
<link rel="stylesheet" href="{{asset('css/nprogress.css')}}">
<script src="{{asset('js/nprogress.js')}}"></script>
<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-161193570-2"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-161193570-2');
</script>

<style>

   .loader {
        border: 3px solid #F3F3F3;
        border-radius: 50%;
        border-top: 3px solid #999;
        width: 25px;
        height: 25px;
        -webkit-animation: spin 2s linear infinite; /* Safari */
        animation: spin 2s linear infinite;
      }
      .no-js #loader { display: none;  }
    .js #loader { display: block; position: absolute; left: 100px; top: 0; }
    .se-pre-con {
        position: fixed;
        left: 0px;
        top: 0px;
        width: 100%;
        height: 100%;
        z-index: 9999;
        /* background: url("./images/loading1.gif") center no-repeat #fff; */
         background: url("./images/pageloading.gif") center no-repeat #fff; 
    }
      /* Safari */
      @-webkit-keyframes spin {
        0% { -webkit-transform: rotate(0deg); }
        100% { -webkit-transform: rotate(360deg); }
      }
      @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
      }
    .bg-light {
        background-color: #eae9e9 !important;
    }
    
    #panorama {
        width: 100%;
        height: 400px;
    }
    #homeBtn{
        display:none;
        position: fixed;
        top: 177px;
        left: -1px;
        z-index: 99;
        font-size: 14px;
        border: none;
        outline: none;
        background-color: #ff6117;
        color: #fff!important;
        cursor: pointer;
        border: 1px solid #e66527;
        border-radius: 30px !important;
        border-top-left-radius: 0px !important;
        border-bottom-left-radius: 0px !important;
        box-sizing: border-box;
        padding: 10px 20px;
        /* background: url(../images/home-24.png) no-repeat center; */
        /* box-shadow: 0 9px 10px -10px #d2571c; */
        box-shadow:0 1px 3px rgba(0,0,0,0.12), 0 1px 2px rgba(0,0,0,0.24);
        text-decoration: none;
    }
    #homeBtn i.fa {
        color: white!important;
    }
    #homeBtn:hover {
        background: #fbaa84;
        border-color: #fbaa84;
    }
  
</style>

</head>
<body class="c-app flex-row align-items-center all-bg" >

<div id="app">
    @browser('isIE')
    <div>
        <nav class="navbar navbar-expand-lg  main-header">
            <div class="container nav-warp d-flex">
            <div class="d-flex align-items-center">
                <a class="navbar-brand logo-text">               
                <h4 class="logo_subtitle">介護医療福祉の総合サイト</h4>
                <img src="/images/fixed_logo.png" style="width:215px;height:auto;" />
                </a>
            </div>
            </div>
        </nav>
        <div class="unauth-page">
            <div class="content">
                <div class="unauth-title">
                <div class="col-12" style="margin:0 auto;margin-bottom: 30px;">
                    <img src="/images/error-100.png" style="width: 8%;">               
                </div>
                <p class="unauth-title m-b-20">本サイトはお使いのブラウザには対応しておりません。</p>               
                </div>
            </div>
        </div>
    </div>
    @else
        <div class="se-pre-con"></div>
        <index ></index>
    @endbrowser
    
</div>

<!-- <script src="/js/app.js" type="text/javascript"></script> -->
<!-- <script src="{{ asset('js/map-api.js') }}"></script> -->

<!-- Real map -->
<!-- <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key="></script> -->
<!-- Test map -->
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=&callback=initMap"></script>

<!-- <script src="http://maps.google.com/maps/api/js"></script> -->
<!-- <script src="{{ asset('js/vue2-5-13.js') }}"></script>
<script src="{{ asset('js/vue-scrollto.js') }}"></script> -->
<!-- <script src="https://cdn.jsdelivr.net/npm/vue"></script> -->
<script src="{{ asset('js/vue.min.js') }}"></script>
<!-- <script src="https://cdn.jsdelivr.net/npm/vue-scrollto"></script> -->
<script src="{{ asset('js/vue-scrollto.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/pannellum.js') }}"></script>
<!-- Include after Vue (before closing body) -->
<script src="{{ asset('js/vue-fullpage.min.js') }}"></script>
<script src="{{ asset('js/sweetalert2.all.js') }}"></script>
<!-- script for editor -->    
<script src="{{ asset('js/popper.min.js') }}"></script>
<!-- end script for editor -->
<script src="{{ asset('js/jquery.scrolling-tabs.min.js') }}" type="text/javascript"></script>
<!-- <script src="{{ asset('js/custom.js') }}" type="text/javascript"></script> -->
<!-- <script src="{{ asset('js/adsslider.js') }}" type="text/javascript"></script>      -->


<script type="text/javascript">
 $(document).ready(function() {   
    
    $(".se-pre-con").fadeOut("slow");//for loading

    /*added for back to top*/
    //  var mybutton = document.getElementById("myBtn");
    //  console.log(mybutton);
    //     // When the user scrolls down 20px from the top of the document, show the button
    //     window.onscroll = function() {scrollFunction()};
    //         function scrollFunction() {
    //         if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
    //             mybutton.style.display = "block";
    //         } else {
    //             mybutton.style.display = "none";
    //         }
    //     }
    // When the user clicks on the button, scroll to the top of the document
    // topFunction = function () {
    //     // document.body.scrollTop = 0;
    //     // document.documentElement.scrollTop = 0;
    //     $("html, body").animate({ scrollTop: 0 }, "slow");
    //         return false;
    // }      
     
});


</script>

</body>
</html>

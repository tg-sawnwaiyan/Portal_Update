<template>
    <div id="app">
        <div v-if="type == 'nursing'" id="nursingView">         
            <!--panorama-->     
            <div v-if="$auth.user().role == 2">
                <div @click="$router.go(-1);" class="pc-2000" style="cursor:pointer;right:0;top:0;text-align:right;">
                    <span class="btn btn-danger all-btn submit">
                        <i class="fas fa-arrow-left"></i> 
                        <span>戻る</span> 
                    </span>                    
                </div>          
                <div class="pc-991-1880">
                    <span @click="$router.go(-1);" class="backbtn" style="cursor:pointer;right:0;top:1%;;position:relative;">
                        <span class="btn btn-danger all-btn submit">
                            <i class="fas fa-arrow-left"></i> 
                            <span>戻る</span> 
                        </span> 
                    </span>               
                </div>
                <div class="sp-9-180">             
                    <p class="job_id3">
                        <span>施設番号:{{profilenumber}}</span>
                    </p>
                </div>
            </div>
            <div v-else> 
                <div @click="$router.go(-1);" class="pc-2000" style="cursor:pointer;right:0;top:0;text-align:right;">
                        <span class="btn btn-danger all-btn submit">
                        <i class="fas fa-arrow-left"></i> 
                        <span>戻る</span> 
                    </span>  
                </div>          
                <div class="pc-991-1880">
                    <span @click="$router.go(-1);" class="backbtn" style="cursor:pointer;right:0;top:1%;;position:relative;">
                        <span class="btn btn-danger all-btn submit">
                            <i class="fas fa-arrow-left"></i> 
                            <span>戻る</span> 
                        </span> 
                    </span>               
                </div>
                <div class="sp-9-180">             
                    <p class="job_id3">
                        <span>施設番号:{{profilenumber}}</span>
                    </p>
                </div>              
            </div>
            <h4 class="profile-tit" v-if="!currentPanoImage && nus_pro[0]">
                <span>{{nus_pro[0].name}}</span>
                <span class="customer-id pc-991-1880">施設番号:{{profilenumber}}</span>
            </h4>
            <div class="col-12 detail_profile_left pad-free"  v-if="currentPanoImage">
                <h4 class="profile-tit" v-if="nus_pro[0]">{{nus_pro[0].name}}</h4>
                <div class="thumbnail-img pc-414" style="padding:0px;border:none;">
                    <div class="card-carousel" style="background:#fff;">
                        <div class="card-img">
                            <Pannellum :src="'/upload/nursing_profile/Imagepanorama/' + currentPanoImage" class="pannellum" :auto-load="true" :show-zoom="true" :show-fullscreen="true" :auto-rotate="isAutoRotationOn" :orientation="isOrientationOn" :compass="true" :hfov= "120" :draggable="true"></Pannellum>
                        </div>
                        <div class="col-12" id="pano-slider-page">
                            <div class="card-carousel-wrapper">
                                <div class="nav-box" @click="moveCarousel(-1)" :disabled="atHeadOfList">
                                    <div class="nav-content mr-2">
                                        <div class="card-carousel--nav__left"></div>
                                    </div>
                                </div>
                                <div class="card-carousel">
                                    <div class="card-carousel--overflow-container">
                                        <div class="card-carousel-cards" :style="{ transform: 'translateX' + '(' + panocurrentOffset + 'px' + ')'}">
                                            <div class="card-carousel--card">                                           
                                                <div  class="thumbnails-pano">
                                                    <div v-for="(image,index) in  panoimages" :key="image.id" :class="['thumbnail-image-panorama', (activePanoImage == index) ? 'active' : '']" @click="activatePanoImage(index)" >
                                                        <img  :src ="'/upload/nursing_profile/Imagepanorama/' + image.photo" @error="imgUrlAlt">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="nav-box"  @click="moveCarousel(1)" :disabled="atEndOfList">
                                    <div class="nav-content ml-2">
                                        <div class="card-carousel--nav__right"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>            
            </div>
            <!--end panorama-->
            <div class="row">
                <div class="col-12">
                    <div class="tab typelabel nav-link fixed-nav btn-group el">            
                        <button v-scroll-to="{ el: '#element1'}" class="top-fixed-btn"  @click="activate(1)" :class="{ active : active_el == 1 }">
                            介護情報
                        </button>
                        <button v-scroll-to="{ el: '#element2' }" class="top-fixed-btn"  @click="activate(2)" :class="{ active : active_el == 2 }">
                            特長
                        </button>
                        <button v-scroll-to="{ el: '#element3' }" class="top-fixed-btn"  @click="activate(3)" :class="{ active : active_el == 3 }">
                            費用
                        </button>
                        <button v-scroll-to="{ el: '#element4' }" class="top-fixed-btn"  @click="activate(4)" :class="{ active : active_el == 4 }">
                            施設概要
                        </button>
                        <button v-scroll-to="{ el: '#element5' }" class="top-fixed-btn"  @click="activate(5)" :class="{ active : active_el == 5 }">
                            地図
                        </button>
                        <button v-scroll-to="{ el: '#element6' }" class="top-fixed-btn" @click="activate(6)" :class="{ active : active_el == 6 }">
                            口コミ
                        </button>
                    </div>
                </div>
            </div>
            <div class="row m-lr-0 ele pt-2"  id="element1">
                    <div class="row col-12 list-wrap m-lr-0 white-bg-color" v-for="cust in nus_pro" :key="cust.id">
                    <!--for slideimage-->
                    <div class="col-md-5 detail_profile_left col-slg-12 pad-free-750">
                        <div class="col-12 pad-free sp-1024">
                            <h5 class="profile_header">
                            <span class="span-height">介護情報</span>
                            <!--fav and mail btn-->
                            <div class="d-block float-right pc-414" v-if="loginuser=='false'">
                                <div class="m-r-10 float-left">
                                    <span class="bottom-fav-btn" v-if="!view_pro_id && loginuser=='false'" @click="favAddFun('add');view_pro_id = !view_pro_id"><i class="fas fa-plus-square" style="color:#c40000!important;"></i>&nbsp; お気に入りに追加</span>
                                    <span class="bottom-fav-btn" style="color:#aaa;" v-if="view_pro_id && loginuser=='false'" @click="favAddFun('remove');view_pro_id = !view_pro_id"><i class="fas fa-check-double" style="color:#c40000!important;"></i>&nbsp; 追加済み</span>
                                </div>
                                <div class="float-right">
                                    <span class="" v-if="loginuser=='false' && !$auth.check() && type == 'nursing'">       
                                        <span class="bottom-mail-btn" @click="documentPost()"><i data-v-b65423c6="" class="far fa-envelope" style="color: #fff  !important;font-size: 15px;"></i>&nbsp;資料請求</span>
                                    </span>
                                </div>
                            </div>
                            <!--end fav and mail btn-->
                            </h5>
                            <!--fav and mail btn-->
                            <section class="row col-12 m-0 p-0">
                                <div class="d-block float-right ml-0 m-b-20 sp-414" v-if="loginuser=='false'">
                                    <div class="m-r-10 float-left">
                                        <span class="bottom-fav-btn" v-if="!view_pro_id && loginuser=='false'" @click="favAddFun('add');view_pro_id = !view_pro_id"><i class="fas fa-plus-square" style="color:#c40000!important;"></i>&nbsp; お気に入りに追加</span>
                                        <span class="bottom-fav-btn" style="color:#aaa;" v-if="view_pro_id && loginuser=='false'" @click="favAddFun('remove');view_pro_id = !view_pro_id"><i class="fas fa-check-double" style="color:#c40000!important;"></i>&nbsp; 追加済み</span>
                                    </div>
                                    <div class="float-right">
                                        <span class="" v-if="loginuser=='false' && !$auth.check() && type == 'nursing'">       
                                            <span class="bottom-mail-btn" @click="documentPost()"><i data-v-b65423c6="" class="far fa-envelope" style="color: #fff  !important;font-size: 15px;"></i>&nbsp;資料請求</span>
                                        </span>
                                    </div>
                                </div>
                            </section>
                            <!--end fav and mail btn-->
                        </div>
                        <div class="thumbnail-img pc-414">
                            <div class="card-carousel">
                                <div class="card-img photocard-carousel-wrapper">
                                    <img :src="'/upload/nursing_profile/' +currentImage" alt="" @error="imgUrlAlt">
                                    <div class="actions">
                                        <span @click="prevImage" class="prev">
                                            <i class="fas fa-chevron-left"></i>
                                        </span>
                                        <span @click="nextImage" class="next">
                                            <i class="fas fa-chevron-right"></i>
                                        </span>
                                    </div>
                                </div>
                                <div class="row col-12 photocard-title">
                                    <h5><strong class="img_2">  {{activeImageTitle}} </strong></h5>
                                    <div class="row col-12 m-b-10">
                                        <p class="text-left">{{activeImageDescription}}</p>
                                    </div>
                                </div>
                                <ul class="thumbnails">
                                    <li v-for="(image,index) in  images" :key="image.id" :class="['thumbnail-image', (activeImage == index) ? 'active' : '']" @click="activateImage(index)" >
                                        <img  :src ="'/upload/nursing_profile/' + image.photo" @error="imgUrlAlt">
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <!--responsive with gallery and panorama -->
                        <div class="sp-414 res-pano m-b-10"  v-if="images.length > 0">
                            <slick :options="slickOptions" ref="slickSetting1">
                                <div><h2><img :src="'/upload/nursing_profile/' +currentImage" alt="" @error="imgUrlAlt" class="img-fluid"></h2></div>
                            </slick>
                            <slick>
                                <p class="res-title"><strong>  {{activeImageTitle}} </strong></p>
                            </slick>
                            <slick>
                                <p class="res-descr">{{activeImageDescription}}</p>
                            </slick>
                            <slick :options="slickOptions2" ref="slickSetting2" id="res-pano">
                                <div v-for="(image,index) in  images" :key="image.id" :class="[(activeImage == index) ? 'active' : '']" @click="activateImage(index)">
                                    <h3>
                                        <span>
                                            <img  :src ="'/upload/nursing_profile/' + image.photo" @error="imgUrlAlt" class="img-fluid">
                                        </span>
                                    </h3>
                                </div>
                            </slick>
                            <div class="see-pano" v-if="panoimages.length > 0">
                                <span @click='isPano = !isPano'>
                                    <li class="first-submenu">
                                        <p><svg x="0px" y="0px"
                                            width="48" height="48"
                                            viewBox="0 0 172 172"
                                            style=" fill:#000000;">
                                            <g fill="none" fill-rule="nonzero" stroke="none" stroke-width="1" stroke-linecap="butt" stroke-linejoin="miter" stroke-miterlimit="10" stroke-dasharray="" stroke-dashoffset="0" font-family="none" font-weight="none" font-size="none" text-anchor="none" style="mix-blend-mode: normal"><path d="M0,172v-172h172v172z" fill="none"></path><g><path d="M150.5,25.08333c-5.93758,0 -10.75,4.81242 -10.75,10.75c0,5.93758 4.81242,10.75 10.75,10.75c5.93758,0 10.75,-4.81242 10.75,-10.75c0,-5.93758 -4.81242,-10.75 -10.75,-10.75zM150.5,39.41667c-1.978,0 -3.58333,-1.60533 -3.58333,-3.58333c0,-1.978 1.60533,-3.58333 3.58333,-3.58333c1.978,0 3.58333,1.60533 3.58333,3.58333c0,1.978 -1.60533,3.58333 -3.58333,3.58333z" fill="#333333"></path><path d="M86,154.08333c-48.2245,0 -86,-19.50408 -86,-44.40467c0,-9.28442 5.28542,-18.11017 15.27933,-25.52408c1.59458,-1.17892 3.83417,-0.84208 5.01308,0.74533c1.17892,1.58742 0.84567,3.83417 -0.74533,5.0095c-5.64733,4.1925 -12.38042,11.02233 -12.38042,19.76925c0,20.1885 36.10208,37.238 78.83333,37.238c42.73125,0 78.83333,-17.05308 78.83333,-37.24158c0,-8.18792 -6.11675,-16.35075 -17.2215,-22.97633c-1.6985,-1.01408 -2.25392,-3.21425 -1.23983,-4.91633c1.0105,-1.70208 3.21067,-2.25392 4.91275,-1.23983c13.35867,7.97292 20.71167,18.318 20.71167,29.1325c0.00358,24.90417 -37.77192,44.40825 -85.99642,44.40825z" fill="#ff9800"></path><path d="M42.12567,65.91542h4.83392c1.83467,0 3.182,-0.64142 4.03842,-1.92067c0.86,-1.28283 1.28642,-2.99208 1.28642,-5.13133c0,-2.04608 -0.44075,-3.63708 -1.32225,-4.78017c-0.8815,-1.1395 -2.064,-1.70925 -3.54392,-1.70925c-1.38675,0 -2.52267,0.54108 -3.40417,1.62325c-0.8815,1.08217 -1.32225,2.44742 -1.32225,4.09217h-9.98317c0,-2.68033 0.61633,-5.08475 1.85258,-7.21325c1.23625,-2.1285 2.96342,-3.79117 5.18508,-4.99158c2.22167,-1.19683 4.68342,-1.79883 7.38883,-1.79883c4.72642,0 8.43158,1.30433 11.11192,3.91658c2.68033,2.61225 4.0205,6.18483 4.0205,10.72133c0,2.32917 -0.60558,4.48633 -1.81675,6.4715c-1.21117,1.98517 -2.80575,3.51167 -4.78017,4.56875c2.42233,1.03558 4.22833,2.58717 5.41442,4.65475c1.18608,2.07117 1.78092,4.515 1.78092,7.33867c0,4.56158 -1.45125,8.22017 -4.35733,10.96858c-2.90608,2.752 -6.71875,4.128 -11.44517,4.128c-4.39675,0 -7.96933,-1.35808 -10.707,-4.07425c-2.73767,-2.71617 -4.1065,-6.28517 -4.1065,-10.707h9.98317c0,1.83467 0.48017,3.3755 1.44767,4.61892c0.96392,1.247 2.18583,1.8705 3.66933,1.8705c1.71642,0 3.0745,-0.63425 4.07425,-1.90275c0.99975,-1.2685 1.50142,-2.96342 1.50142,-5.07758c0,-5.05608 -1.96367,-7.59667 -5.891,-7.61817h-4.902v-8.04817z" fill="#333333"></path><path d="M93.5895,44.25775v8.46742h-0.559c-3.73742,0.0215 -6.71158,1.14667 -8.90817,3.36833c-2.20017,2.22167 -3.53317,5.332 -4.00617,9.331c2.14283,-2.44742 4.82317,-3.66933 8.04458,-3.66933c3.71592,0 6.67933,1.58742 8.90458,4.76225c2.22525,3.17483 3.33608,7.40675 3.33608,12.69575c0,3.36475 -0.63425,6.39625 -1.90275,9.10167c-1.27567,2.70183 -3.05658,4.80167 -5.34633,6.29592c-2.29692,1.49425 -4.88767,2.23958 -7.77942,2.23958c-4.65475,0 -8.38858,-1.8705 -11.19792,-5.60792c-2.80933,-3.73742 -4.21758,-8.772 -4.21758,-15.09658v-3.70517c0,-5.66883 0.88867,-10.63175 2.666,-14.88517c1.77375,-4.257 4.33942,-7.53217 7.68983,-9.82192c3.35042,-2.29333 7.25983,-3.45075 11.72825,-3.47583zM85.01817,69.97175c-1.27208,0 -2.33633,0.39775 -3.19275,1.20042c-0.86,0.80267 -1.49783,1.79167 -1.92067,2.97058v3.60483c0,3.62992 0.48017,6.33892 1.44408,8.127c0.96392,1.79167 2.23242,2.68392 3.80908,2.68392c1.59817,0 2.881,-0.86358 3.84492,-2.59792c0.96392,-1.73075 1.44408,-3.95242 1.44408,-6.66142c0,-2.75558 -0.50167,-5.00233 -1.49783,-6.73308c-0.99617,-1.72717 -2.30767,-2.59433 -3.93092,-2.59433z" fill="#333333"></path><path d="M136.16667,74.90958c0,7.10217 -1.29,12.5345 -3.86283,16.297c-2.57283,3.7625 -6.24933,5.64375 -11.02233,5.64375c-4.72642,0 -8.38142,-1.8275 -10.95425,-5.48608c-2.57283,-3.655 -3.90942,-8.89742 -4.00258,-15.7165v-9.70008c0,-7.07708 1.27925,-12.49508 3.84492,-16.24325c2.56208,-3.75175 6.24217,-5.62583 11.04025,-5.62583c4.79808,0 8.47458,1.85975 11.04025,5.57208c2.56208,3.71592 3.86642,9.01925 3.91658,15.91zM126.14767,64.50358c0,-4.042 -0.39775,-7.07708 -1.19683,-9.10167c-0.79908,-2.021 -2.04608,-3.03508 -3.73742,-3.03508c-3.17483,0 -4.82317,3.70517 -4.94142,11.11192v12.80325c0,4.13875 0.4085,7.22042 1.21833,9.24142c0.80983,2.02458 2.07475,3.0315 3.79117,3.0315c1.62325,0 2.82725,-0.946 3.61558,-2.838c0.78475,-1.892 1.20758,-4.79092 1.25058,-8.69317z" fill="#333333"></path></g></g></svg>
                                            360°画像をパノラマで見る</p>
                                    </li>
                                </span>
                                <transition name="slide">
                                    <div class="sp_panonav" id="sp_panonav" v-if="isPano">
                                        <div>
                                            <span @click='isPano = !isPano'>
                                                <li class="first-submenu backwrapper">
                                                    <i class="fa fa-arrow-left" aria-hidden="true"></i> 戻る
                                                </li>
                                            </span>
                                            <!--pano show res-->
                                            <slick :options="slickOptions" ref="slickSetting1">
                                                <div>
                                                    <h2>
                                                        <Pannellum :src="'/upload/nursing_profile/Imagepanorama/' + currentPanoImage" class="pannellum" :auto-load="true" :show-zoom="true" :show-fullscreen="true" :auto-rotate="isAutoRotationOn" :orientation="isOrientationOn" :compass="true" :hfov= "120" :draggable="true"></Pannellum>
                                                    </h2>
                                                </div>
                                            </slick>
                                            <slick :options="slickOptions2" ref="slickSetting2" id="res-pano">
                                                    <div v-for="(image,index) in  panoimages" :key="image.id" :class="[(activePanoImage == index) ? 'active' : '']" @click="activatePanoImage(index)">
                                                    <h3>
                                                        <span>
                                                            <img  :src ="'/upload/nursing_profile/Imagepanorama/' + image.photo" @error="imgUrlAlt" class="img-fluid">
                                                        </span>
                                                    </h3>
                                                </div>
                                            </slick>
                                            <!--end pano show res-->
                                        </div>
                                    </div>
                                </transition>
                            </div>
                        </div>
                        <!--end responsive with gallery and panorama -->
                    </div>
                    <!--end for slide image-->
                    <!--for address-->
                    <div class="col-md-7 detail_profile_right col-slg-12 pad-free-750">
                        <div class="m-lr-0 pro-heading">
                            <div class="col-12 pad-free pc-1024">
                                <h5 class="profile_header">
                                    <span class="span-height">介護情報</span>
                                    <!--fav and mail btn-->
                                    <div class="d-block float-right" v-if="loginuser=='false'">
                                        <div class="m-r-10 float-left">
                                            <span class="bottom-fav-btn" v-if="!view_pro_id && loginuser=='false'" @click="favAddFun('add');view_pro_id = !view_pro_id"><i class="fas fa-plus-square" style="color:#c40000!important;"></i>&nbsp; お気に入りに追加</span>
                                            <span class="bottom-fav-btn" style="color:#aaa;" v-if="view_pro_id && loginuser=='false'" @click="favAddFun('remove');view_pro_id = !view_pro_id"><i class="fas fa-check-double" style="color:#c40000!important;"></i>&nbsp; 追加済み</span>
                                        </div>
                                        <div class="float-right">
                                            <span class="" v-if="loginuser=='false' && !$auth.check() && type == 'nursing'">       
                                                <span class="bottom-mail-btn" @click="documentPost()"><i data-v-b65423c6="" class="far fa-envelope" style="color: #fff  !important;font-size: 15px;"></i>&nbsp;資料請求</span>
                                            </span>
                                        </div>
                                    </div>
                                    <!--end fav and mail btn-->
                                </h5>
                            </div>                             
                            <table class="table table-bordered info_tbl">
                                <tbody>
                                    <tr>
                                        <th  class="custom-bg-color">
                                            <font>入居時費用</font>
                                        </th>
                                        <td>                                                
                                            <font class="cash-lbl">
                                                <span v-if="Number(cust.moving_in_from) == 0">0円</span>
                                                <span v-else>
                                                    {{(Math.floor(Number(cust.moving_in_from)/10000))==0? '' : (Math.floor(Number(cust.moving_in_from)/10000)).toLocaleString()+'万' }}{{(Number(cust.moving_in_from)%10000)==0 ? '' : (Number(cust.moving_in_from)%10000).toLocaleString()}}円
                                                </span>
                                                    ~
                                                <span v-if="Number(cust.moving_in_to) == 0">0円</span>
                                                <span v-else>
                                                    {{(Math.floor(Number(cust.moving_in_to)/10000))==0? '' : (Math.floor(Number(cust.moving_in_to)/10000)).toLocaleString()+'万' }}{{(Number(cust.moving_in_to)%10000)==0 ? '' : (Number(cust.moving_in_to)%10000).toLocaleString()}}円
                                                </span>                                                    
                                            </font>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th  class="custom-bg-color">
                                            <font>月額費用</font>
                                        </th>
                                        <td>
                                            <font class="cash-lbl">
                                                <span v-if="Number(cust.per_month_from) == 0">0円</span>
                                                <span v-else>
                                                {{(Math.floor(Number(cust.per_month_from)/10000))==0? '' : (Math.floor(Number(cust.per_month_from)/10000)).toLocaleString()+'万' }}{{(Number(cust.per_month_from)%10000)==0 ? '' : (Number(cust.per_month_from)%10000).toLocaleString()}}円
                                                </span>
                                                    ~
                                                    <span v-if="Number(cust.per_month_to) == 0">0円</span>
                                                    <span v-else>
                                                {{(Math.floor(Number(cust.per_month_to)/10000))==0? '' : (Math.floor(Number(cust.per_month_to)/10000)).toLocaleString()+'万' }}{{(Number(cust.per_month_to)%10000)==0 ? '' : (Number(cust.per_month_to)%10000).toLocaleString()}}円
                                                </span>
                                            </font>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th  class="custom-bg-color">
                                            <font>住所 </font>
                                        </th>
                                        <td>
                                            <font>{{(cust.address == '')?'-':cust.address}}</font>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th  class="custom-bg-color">
                                            <font>電話番号</font>
                                        </th>
                                        <td>
                                            <font>{{cust.phone}}</font>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th  class="custom-bg-color">
                                            <font>アクセス　</font>
                                        </th>
                                        <td v-if="cust.access">
                                            <p v-html=cust.access></p>
                                        </td>
                                        <td v-else> - </td>
                                    </tr>
                                    <tr>
                                        <th  class="custom-bg-color">
                                            <font>運営事業者</font>
                                        </th>
                                        <td v-if="cust.operator">
                                            <font>{{cust.operator}}</font>
                                        </td>
                                        <td v-else> - </td>
                                    </tr>                                        
                                </tbody>
                            </table>
                        </div>
                        <h5 class="header m-t-10">こだわりの特長</h5>
                        <div class="row m-lr-0" v-if="specialfeature">
                            <ul class="fac_container" v-for="special in specialfeature" :key="special.id">
                                <li>{{special.short_name}}</li>
                            </ul>
                        </div>
                        <div class="row m-lr-0" v-else>
                            <p class="no-data-color">データがありません。</p>
                        </div>
                    </div>
                    <!--end for address-->
                </div>
            </div>
            <div class="ele m-lr-0" id="element2">
                <h5 class="profile_header">
                    <span class="span-height">特長</span>
                    <!--fav and mail btn-->
                    <div class="d-block float-right pc-414" v-if="loginuser=='false'">
                        <div class="m-r-10 float-left">
                            <span class="bottom-fav-btn" v-if="!view_pro_id && loginuser=='false'" @click="favAddFun('add');view_pro_id = !view_pro_id"><i class="fas fa-plus-square" style="color:#c40000!important;"></i>&nbsp; お気に入りに追加</span>
                            <span class="bottom-fav-btn" style="color:#aaa;" v-if="view_pro_id && loginuser=='false'" @click="favAddFun('remove');view_pro_id = !view_pro_id"><i class="fas fa-check-double" style="color:#c40000!important;"></i>&nbsp; 追加済み</span>
                        </div>
                        <div class="float-right">
                            <span class="" v-if="loginuser=='false' && !$auth.check() && type == 'nursing'">       
                                <span class="bottom-mail-btn" @click="documentPost()"><i data-v-b65423c6="" class="far fa-envelope" style="color: #fff  !important;font-size: 15px;"></i>&nbsp;資料請求</span>
                            </span>
                        </div>
                    </div>
                    <!--end fav and mail btn-->
                </h5>
                <!--fav and mail btn-->
                <section class="row col-12 m-0 p-0">
                    <div class="d-block float-right ml-0 m-b-20 sp-414" v-if="loginuser=='false'">
                        <div class="m-r-10 float-left">
                            <span class="bottom-fav-btn" v-if="!view_pro_id && loginuser=='false'" @click="favAddFun('add');view_pro_id = !view_pro_id"><i class="fas fa-plus-square" style="color:#c40000!important;"></i>&nbsp; お気に入りに追加</span>
                            <span class="bottom-fav-btn" style="color:#aaa;" v-if="view_pro_id && loginuser=='false'" @click="favAddFun('remove');view_pro_id = !view_pro_id"><i class="fas fa-check-double" style="color:#c40000!important;"></i>&nbsp; 追加済み</span>
                        </div>
                        <div class="float-right">
                            <span class="" v-if="loginuser=='false' && !$auth.check() && type == 'nursing'">       
                                <span class="bottom-mail-btn" @click="documentPost()"><i data-v-b65423c6="" class="far fa-envelope" style="color: #fff  !important;font-size: 15px;"></i>&nbsp;資料請求</span>
                            </span>
                        </div>
                    </div>
                </section>
                <!--end fav and mail btn-->                
                <div class="col-md-12 d-flex m-b-768">
                    <span v-if="nursing_profiles != null">
                        <p v-html="nursing_profiles"></p>
                    </span>
                    <span v-else>
                        <p class="no-data-color">データがありません。</p>
                    </span>
                </div>
            </div>
            <div class="ele m-lr-0" id="element3">
                <h5 class="profile_header">
                    <span class="span-height">費用</span>
                    <!--fav and mail btn-->
                    <div class="d-block float-right pc-414" v-if="loginuser=='false'">
                        <div class="m-r-10 float-left">
                            <span class="bottom-fav-btn" v-if="!view_pro_id && loginuser=='false'" @click="favAddFun('add');view_pro_id = !view_pro_id"><i class="fas fa-plus-square" style="color:#c40000!important;"></i>&nbsp; お気に入りに追加</span>
                            <span class="bottom-fav-btn" style="color:#aaa;" v-if="view_pro_id && loginuser=='false'" @click="favAddFun('remove');view_pro_id = !view_pro_id"><i class="fas fa-check-double" style="color:#c40000!important;"></i>&nbsp; 追加済み</span>
                        </div>
                        <div class="float-right">
                            <span class="" v-if="loginuser=='false' && !$auth.check() && type == 'nursing'">       
                                <span class="bottom-mail-btn" @click="documentPost()"><i data-v-b65423c6="" class="far fa-envelope" style="color: #fff  !important;font-size: 15px;"></i>&nbsp;資料請求</span>
                            </span>
                        </div>
                    </div>
                    <!--end fav and mail btn-->
                </h5>
                <!--fav and mail btn-->
                <section class="row col-12 m-0 p-0">
                    <div class="d-block float-right ml-0 m-b-20 sp-414" v-if="loginuser=='false'">
                        <div class="m-r-10 float-left">
                            <span class="bottom-fav-btn" v-if="!view_pro_id && loginuser=='false'" @click="favAddFun('add');view_pro_id = !view_pro_id"><i class="fas fa-plus-square" style="color:#c40000!important;"></i>&nbsp; お気に入りに追加</span>
                            <span class="bottom-fav-btn" style="color:#aaa;" v-if="view_pro_id && loginuser=='false'" @click="favAddFun('remove');view_pro_id = !view_pro_id"><i class="fas fa-check-double" style="color:#c40000!important;"></i>&nbsp; 追加済み</span>
                        </div>
                        <div class="float-right">
                            <span class="" v-if="loginuser=='false' && !$auth.check() && type == 'nursing'">       
                                <span class="bottom-mail-btn" @click="documentPost()"><i data-v-b65423c6="" class="far fa-envelope" style="color: #fff  !important;font-size: 15px;"></i>&nbsp;資料請求</span>
                            </span>
                        </div>
                    </div>
                </section>
                <!--end fav and mail btn-->
                <div v-if="method_payment.length > 0" class="pc-414">
                    <div class="row col-12 m-0 p-0 cost_tb" >
                        <div class="col-md-12 main-cost-wrap pad-free-750">
                            <table class="table table-bordered cost_table main-cost-table">
                                <thead>
                                    <tr>
                                        <th>プラン名 / 居室詳細</th>
                                        <th>入居時費用</th>
                                        <th>月額費用</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                <tr v-for="(cost,index) in method_payment" :key="cost.id" :class="'cost'+index">
                                    <td>
                                        <h5 class="method-name">{{cost.payment_name}}</h5>
                                        <span class="room-type"> {{cost.living_room_type}} </span>
                                        {{cost.area}}
                                    </td>
                                    <td><span class="cash-lbl-mini">{{cost.expense_moving}}</span></td>
                                    <td><span class="cash-lbl-mini">{{cost.monthly_fees}}</span></td>
                                    <td>
                                        <span :class="'changeLink changeLink'+cost.id" @click="costConfirm(cost.id,index)" >詳細はこちら</span>
                                        <span :class="'closeLink closeLink'+cost.id" @click="closeDetail(cost.id,index)" class="hideCloseBtn float-right">詳細を閉じる</span>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>                                
                        <div class="col-md-12 collapse closeChangeLink" :id="'changeLink' + cost.id" v-for="cost in method_payment" :key="cost.id">
                            <label class="cost_heading_lbl m-b-15">{{cost.payment_name}}</label>
                            <div class="col-md-12">
                                <label class="cost_heading_lbl_mini"><i class="fas fa-yen-sign"></i> 入居にかかる費用</label>
                                <table id="costDetails" class="table table-condensed table-bordered cost_table moving-in_tbl">
                                    <tbody>
                                        <tr>
                                            <th>入居一時金または</th>
                                            <td><span class="cash-lbl-mini">{{cost.deposit}}</span></td>
                                            <th>その他（使途）</th>
                                            <td>{{cost.other_use}}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-md-12">
                                <label class="cost_heading_lbl_mini"><i class="fas fa-yen-sign"></i> 月額費用</label>
                                <table class="table table-condensed table-bordered cost_table">
                                    <tbody>
                                        <tr>
                                            <th>賃料</th>
                                            <td><span class="cash-lbl-mini">{{cost.rent}}</span></td>
                                        </tr>
                                        <tr>
                                            <th>管理費</th>
                                            <td><span class="cash-lbl-mini">{{cost.admin_expense}}</span></td>
                                        </tr>
                                        <tr>
                                            <th>食費 </th>
                                            <td><span class="cash-lbl-mini">{{cost.food_expense}}</span></td>
                                        </tr>
                                        <tr>
                                            <th>介護上乗せ金（生活サービス費</th>
                                            <td><span class="cash-lbl-mini">{{cost.nurse_care_surcharge}}</span></td>
                                        </tr>
                                        <tr>
                                            <th>その他 </th>
                                            <td>{{cost.other_monthly_cost}}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-md-12">
                                <label class="cost_heading_lbl_mini"><i class="fas fa-yen-sign"></i> 返還金について</label>
                                <table class="table table-condensed table-bordered cost_table">
                                    <tbody>
                                        <tr>
                                            <th>返還制度</th>
                                            <td>{{cost.refund_system}}</td>
                                        </tr>
                                        <tr>
                                            <th>償却期間</th>
                                            <td>{{cost.depreciation_period}}</td>
                                        </tr>
                                        <tr>
                                            <th>初期償却</th>
                                            <td>{{cost.initial_deprecration}}</td>
                                        </tr>
                                        <tr>
                                            <th>その他メッセージ</th>
                                            <td>{{cost.other_message_refund}}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>                        
                </div>
                <div v-else class="row col-12 m-0 m-b-768"> <p class="no-data-color">データがありません。</p> </div>
                <!--Table responsive-->
                <div class=" col-12 p-0 card sp-414 mb-3" v-for="(cost) in method_payment" :key="cost.id">
                    <div class="card-header font-weight-bold">{{cost.payment_name}}</div>
                    <div class="card-body payment-body">                                
                        <p class="mb-2"><span>初期</span> {{cost.expense_moving}}</p>
                        <p><span>月額</span> {{cost.monthly_fees}}</p>
                    </div>
                    <div class="payment-footer">
                        <span class="detail-btn" :class="'changeLink changeLink'+cost.id" @click="costConfirmMini(cost.id,index)" >詳細はこちら</span>
                        <div class="col-md-12 collapse miniChangeLink" :id="'changeLinkMini' + cost.id">
                            <label class="cost_heading_lbl_respon m-b-15">{{cost.payment_name}}</label>
                            <div class="col-md-12">
                                <label class="cost_heading_lbl_mini_res"><i class="fas fa-yen-sign"></i> 入居にかかる費用</label>
                                <table id="costDetails" class="table table-condensed table-bordered cost_table moving-in_tbl">
                                    <tbody>
                                        <tr>
                                            <th class="method-name-respon">入居一時金または</th>
                                            <td><span class="cash-lbl-respon">{{cost.deposit}}</span></td>
                                            <th class="method-name-respon">その他（使途）</th>
                                            <td>{{cost.other_use}}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-md-12">
                                <label class="cost_heading_lbl_mini_res"><i class="fas fa-yen-sign"></i> 月額費用</label>
                                <table class="table table-condensed table-bordered cost_table">
                                    <tbody>
                                        <tr>
                                            <th class="method-name-respon">賃料</th>
                                            <td><span class="cash-lbl-respon">{{cost.rent}}</span></td>
                                        </tr>
                                        <tr>
                                            <th class="method-name-respon">管理費</th>
                                            <td><span class="cash-lbl-respon">{{cost.admin_expense}}</span></td>
                                        </tr>
                                        <tr>
                                            <th class="method-name-respon">食費 </th>
                                            <td><span class="cash-lbl-respon">{{cost.food_expense}}</span></td>
                                        </tr>
                                        <tr>
                                            <th class="method-name-respon">介護上乗せ金（生活サービス費</th>
                                            <td><span class="cash-lbl-respon">{{cost.nurse_care_surcharge}}</span></td>
                                        </tr>
                                        <tr>
                                            <th class="method-name-respon">その他 </th>
                                            <td>{{cost.other_monthly_cost}}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-md-12">
                                <label class="cost_heading_lbl_mini_res"><i class="fas fa-yen-sign"></i> 返還金について</label>
                                <table class="table table-condensed table-bordered cost_table">
                                    <tbody>
                                        <tr>
                                            <th class="method-name-respon">返還制度</th>
                                            <td>{{cost.refund_system}}</td>
                                        </tr>
                                        <tr>
                                            <th class="method-name-respon">償却期間</th>
                                            <td>{{cost.depreciation_period}}</td>
                                        </tr>
                                        <tr>
                                            <th class="method-name-respon">初期償却</th>
                                            <td>{{cost.initial_deprecration}}</td>
                                        </tr>
                                        <tr>
                                            <th class="method-name-respon">その他メッセージ</th>
                                            <td>{{cost.other_message_refund}}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <!--End table responsive-->
            </div>
            <div class="ele m-lr-0" id="element4">
                <h5 class="profile_header">
                    <span class="span-height">施設の概要</span>
                    <!--fav and mail btn-->
                    <div class="d-block float-right pc-414" v-if="loginuser=='false'">
                        <div class="m-r-10 float-left">
                            <span class="bottom-fav-btn" v-if="!view_pro_id && loginuser=='false'" @click="favAddFun('add');view_pro_id = !view_pro_id"><i class="fas fa-plus-square" style="color:#c40000!important;"></i>&nbsp; お気に入りに追加</span>
                            <span class="bottom-fav-btn" style="color:#aaa;" v-if="view_pro_id && loginuser=='false'" @click="favAddFun('remove');view_pro_id = !view_pro_id"><i class="fas fa-check-double" style="color:#c40000!important;"></i>&nbsp; 追加済み</span>
                        </div>
                        <div class="float-right">
                            <span class="" v-if="loginuser=='false' && !$auth.check() && type == 'nursing'">       
                                <span class="bottom-mail-btn" @click="documentPost()"><i data-v-b65423c6="" class="far fa-envelope" style="color: #fff  !important;font-size: 15px;"></i>&nbsp;資料請求</span>
                            </span>
                        </div>
                    </div>
                    <!--end fav and mail btn-->
                </h5>
                <!--fav and mail btn-->
                <section class="row col-12 m-0 p-0">
                    <div class="d-block float-right ml-0 m-b-20 sp-414" v-if="loginuser=='false'">
                        <div class="m-r-10 float-left">
                            <span class="bottom-fav-btn" v-if="!view_pro_id && loginuser=='false'" @click="favAddFun('add');view_pro_id = !view_pro_id"><i class="fas fa-plus-square" style="color:#c40000!important;"></i>&nbsp; お気に入りに追加</span>
                            <span class="bottom-fav-btn" style="color:#aaa;" v-if="view_pro_id && loginuser=='false'" @click="favAddFun('remove');view_pro_id = !view_pro_id"><i class="fas fa-check-double" style="color:#c40000!important;"></i>&nbsp; 追加済み</span>
                        </div>
                        <div class="float-right">
                            <span class="" v-if="loginuser=='false' && !$auth.check() && type == 'nursing'">       
                                <span class="bottom-mail-btn" @click="documentPost()"><i data-v-b65423c6="" class="far fa-envelope" style="color: #fff  !important;font-size: 15px;"></i>&nbsp;資料請求</span>
                            </span>
                        </div>
                    </div>
                </section>
                <!--end fav and mail btn-->                
                <div class="row col-12 m-0 p-0">
                    <div v-for="nus in nusfacilities" :key="nus.id" class="col-md-12 pad-free-750" >
                        <table border="1" class="table table-bordered cost_table facility_tbl">
                            <tbody>
                                <tr>
                                    <th custom-bg-color> 事業主体</th>
                                    <td v-if="nus.business_entity">{{nus.business_entity}}</td>
                                    <td v-else>-</td>
                                </tr>
                                <tr>
                                    <th custom-bg-color>開設年月日</th>
                                    <td v-if="nus.date_of_establishment">{{nus.date_of_establishment}}</td>
                                    <td v-else>-</td>
                                </tr>
                                <tr>
                                    <th custom-bg-color> 土地の権利形態 </th>
                                    <td v-if="nus.land_right_form">{{nus.land_right_form}}</td>
                                    <td v-else>-</td>
                                </tr>
                                <tr>
                                    <th custom-bg-color>建物の権利形態</th>
                                    <td v-if="nus.building_right_form">{{nus.building_right_form}}</td>
                                    <td v-else>-</td>
                                </tr>
                                <tr>
                                    <th custom-bg-color>敷地面積</th>
                                    <td v-if="nus.site_area">{{nus.site_area}}</td>
                                    <td v-else>-</td>
                                </tr>
                                <tr>
                                    <th custom-bg-color>延床面積</th>
                                    <td v-if="nus.floor_area">{{nus.floor_area}}</td>
                                    <td v-else>-</td>
                                </tr>
                                <tr>
                                    <th custom-bg-color>構造</th>
                                    <td v-if="nus.construction">{{nus.construction}}</td>
                                    <td v-else>-</td>
                                </tr>
                                <tr>
                                    <th custom-bg-color>定員</th>
                                    <td v-if="nus.capacity">{{nus.capacity}}</td>
                                    <td v-else>-</td>
                                </tr>
                                <tr>
                                    <th custom-bg-color>総居室・戸数 </th>
                                    <td v-if="nus.num_rooms">{{nus.num_rooms}}</td>
                                    <td v-else>-</td>
                                </tr>
                                <tr>
                                    <th custom-bg-color>居住の権利形態 </th>
                                    <td v-if="nus.residence_form"><p v-html="nus.residence_form"></p></td>
                                    <td v-else>-</td>
                                </tr>
                                <tr>
                                    <th custom-bg-color>類型 </th>
                                    <td v-if="nus.fac_type">{{nus.fac_type}}</td>
                                    <td v-else>-</td>
                                </tr>
                                <tr>
                                    <th custom-bg-color>入居条件</th>
                                    <td v-if="nus.occupancy_condition">{{nus.occupancy_condition}}</td>
                                    <td v-else>-</td>
                                </tr>
                                <tr>
                                    <th custom-bg-color>居室区分・間取り等 </th>
                                    <td v-if="nus.room_floor">{{nus.room_floor}}</td>
                                    <td v-else>-</td>
                                </tr>
                                <tr>
                                    <th custom-bg-color> 居室設備</th>
                                    <td v-if="nus.living_room_facilities">{{nus.living_room_facilities}}</td>
                                    <td v-else>-</td>
                                </tr>
                                <tr>
                                    <th custom-bg-color>共用施設・設備 </th>
                                    <td v-if="nus.equipment">{{nus.equipment}}</td>
                                    <td v-else>-</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-md-12 pad-free-750">
                        <h5 class="profile_subtit">フォトアルバム</h5>
                        <div class="row m-0 m-b-768" v-if="light_images == '' || light_images.length == 0">
                            <div class="col-12 pad-free-750"> <p class="no-data-color">データがありません。</p> </div>
                        </div>
                        <div class="row gallery-list m-0" v-else>
                            <div v-for="(image,index) in  light_images" :key="index" class="col-6 col-md-4 col-sm-4 col-lg-3 m-b-10 ">
                                <div class="gallery-item">
                                    <img :src ="'/upload/nursing_profile/' + image.name"  class="img-fluid" @click="showLightbox(image.name)"  @error="imgUrlAlt">
                                </div>
                                <span class="img_txt">{{image.title}}</span>
                            </div>
                            <lightbox id="mylightbox" ref="lightbox" :images="light_images" :directory="thumbnailDir+'nursing_profile/'" :timeoutDuration="5000" />
                        </div>
                    </div>
                    <div class="col-md-12 pad-free-750">
                        <h5 class="profile_subtit">動画</h5>
                        <div class="row m-0 m-b-768" v-if="videos == '' || videos.length == 0">
                            <div class="col-12 pad-free-750"> <p class="no-data-color">データがありません。</p> </div>
                        </div>
                        <div class="row gallery-list m-0 pad-free-750" v-else>
                            <div v-for="(video) in  videos" :key="video.id" class="col-6  col-sm-4 col-md-4 col-lg-3 m-b-10" style="width:100%">
                                <div class="gallery-item" style="height:135px;">
                                    <iframe :src="'https://www.youtube.com/embed/'+video.photo" controls width="100%"></iframe>
                                </div>
                                <span class="video_txt">{{video.title}}</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 pad-free-750">
                        <h5 class="profile_subtit">協力医療機関</h5>
                        <div v-if="cooperate_medical.length>0" class="col-md-12 pad-free-750">
                            <div v-for="comedical in cooperate_medical" :key="comedical.id" class="col-md-12 pad-free" >
                                <label class="cost_heading_lbl_mini"><i class="fas fa-university"></i> {{comedical.name}}</label>
                                <table border="1" class="table table-bordered cost_table facility_tbl">
                                    <tbody>
                                        <tr>
                                            <th class="custom-bg-color" > 診療科目</th>
                                            <td>{{comedical.clinical_subject}}</td>
                                        </tr>
                                        <tr>
                                            <th class="custom-bg-color">協力内容</th>
                                            <td >{{comedical.details}}</td>
                                        </tr>
                                        <tr>
                                            <th class="custom-bg-color">診療費用</th>
                                            <td >{{comedical.medical_expense}}</td>
                                        </tr>
                                        <tr>
                                            <th class="custom-bg-color">備考</th>
                                            <td >{{comedical.remark}}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="col-12 m-b-768" v-else> <p class="no-data-color">データがありません。</p> </div>
                    </div>
                    <div class="col-12 pad-free-750">
                        <h5 class="profile_subtit"> 医療面の受入れ</h5>
                        <div class="row  m-0">
                            <div v-for="maccept in medical_acceptance" :key="maccept.id" class="col-md-4 col-sm-6  accept-wrap" >
                                <div class="accept-box">
                                    <div class="float-left" v-for="(ma,index) in medical" :key="index">
                                        <i v-if="ma.name === maccept.name && ma.accept_type === 'accept'" class="fas fa-check green"></i>
                                        <i v-if="ma.name === maccept.name && ma.accept_type === 'unaccept'" class="fas fa-times red"></i>
                                        <i v-if="ma.name === maccept.name && ma.accept_type === 'negotiate'" class="fas fa-adjust blue"></i>
                                    </div>
                                    &nbsp;
                                    {{maccept.name}}
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-end pad-free-750">
                            <label for="" class="m-r-15"><i class="fas fa-check green"></i> 受入れ可</label>
                            <label for="" class="m-r-15"><i class="fas fa-times red"></i> 受入れ不可</label>
                            <label for="" class="m-r-15"><i class="fas fa-adjust blue"></i> 応相談</label>
                        </div>
                        <div class="form-group">
                            <p v-html="nus_pro.acceptance_remark"></p>
                        </div>
                    </div>
                    <div class=" col-12 pad-free-750">
                        <h5  class="profile_subtit"> 職員体制</h5>
                        <div v-if="staff.length>0">
                            <div v-for="st in staff" :key="st.id" class="col-md-12 pad-free-750">
                                <table border="1" class="table table-bordered staff_tbl">
                                    <tbody>
                                        <tr>
                                            <th class="custom-bg-color"> 介護に関わる職員体制（入居者：職員）</th>
                                            <td>{{st.staff}}</td>
                                            <th class="custom-bg-color"> 介護職員    </th>
                                            <td>{{st.nursing_staff}}</td>
                                        </tr>
                                        <tr>
                                            <th class="custom-bg-color"> 夜間の最少職員数   </th>
                                            <td>{{st.min_num_staff}}</td>
                                            <th class="custom-bg-color">     看護職員数     </th>
                                            <td>{{st.num_staff}}</td>
                                        </tr>
                                    </tbody>
                                </table>
                                <div class="form-group">
                                    <p v-html="st.remarks"></p>
                                </div>
                            </div>
                        </div>
                        <div v-else class="col-12 m-b-768"> <p class="no-data-color">データがありません。</p> </div>
                    </div>
                </div>
            </div>
            <div class="ele m-lr-0" id="element5">
                <h5 class="profile_header">
                    <span class="span-height">地図</span>
                    <!--fav and mail btn-->
                    <div class="d-block float-right pc-414" v-if="loginuser=='false'">
                        <div class="m-r-10 float-left">
                            <span class="bottom-fav-btn" v-if="!view_pro_id && loginuser=='false'" @click="favAddFun('add');view_pro_id = !view_pro_id"><i class="fas fa-plus-square" style="color:#c40000!important;"></i>&nbsp; お気に入りに追加</span>
                            <span class="bottom-fav-btn" style="color:#aaa;" v-if="view_pro_id && loginuser=='false'" @click="favAddFun('remove');view_pro_id = !view_pro_id"><i class="fas fa-check-double" style="color:#c40000!important;"></i>&nbsp; 追加済み</span>
                        </div>
                        <div class="float-right">
                            <span class="" v-if="loginuser=='false' && !$auth.check() && type == 'nursing'">       
                                <span class="bottom-mail-btn" @click="documentPost()"><i data-v-b65423c6="" class="far fa-envelope" style="color: #fff  !important;font-size: 15px;"></i>&nbsp;資料請求</span>
                            </span>
                        </div>
                    </div>
                    <!--end fav and mail btn-->
                </h5>
                <!--fav and mail btn-->
                <section class="row col-12 m-0 p-0">
                    <div class="d-block float-right ml-0 m-b-20 sp-414" v-if="loginuser=='false'">
                        <div class="m-r-10 float-left">
                            <span class="bottom-fav-btn" v-if="!view_pro_id && loginuser=='false'" @click="favAddFun('add');view_pro_id = !view_pro_id"><i class="fas fa-plus-square" style="color:#c40000!important;"></i>&nbsp; お気に入りに追加</span>
                            <span class="bottom-fav-btn" style="color:#aaa;" v-if="view_pro_id && loginuser=='false'" @click="favAddFun('remove');view_pro_id = !view_pro_id"><i class="fas fa-check-double" style="color:#c40000!important;"></i>&nbsp; 追加済み</span>
                        </div>
                        <div class="float-right">
                            <span class="" v-if="loginuser=='false' && !$auth.check() && type == 'nursing'">       
                                <span class="bottom-mail-btn" @click="documentPost()"><i data-v-b65423c6="" class="far fa-envelope" style="color: #fff  !important;font-size: 15px;"></i>&nbsp;資料請求</span>
                            </span>
                        </div>
                    </div>
                </section>
                <!--end fav and mail btn-->                 
                <div class="row col-lg-12 col-md-12 col-sm-12 pad-0-res m-0 p-0">
                    <GmapMap class="col-12" id="googlemap" ref="map" :center="center" :zoom="10" >
                        <GmapMarker v-for="(m, index) in markers" :key="index" :position="m.position" :clickable="true" :draggable="false" @click="center=m.position" />
                    </GmapMap>
                    <div class="col-md-12 m-t-20 pad-free-750"  v-for="m in nus_pro" :key="m.id" >
                        <table border="1" class="table table-bordered map_tbl">
                            <tbody>
                            <tr>
                                <th class="custom-bg-color"> 公式サイト</th>
                                <td v-if="m.website">{{m.website}}</td> <td v-else> - </td>
                            </tr>
                            <tr>
                                <th class="custom-bg-color"> メールアドレス</th>
                                <td v-if="m.website">{{m.email}}</td>
                                <td v-else> - </td>
                            </tr>
                            <tr>
                                <th class="custom-bg-color"> アクセス</th>
                                <td v-if="m.access"><p v-html="m.access"></p></td> <td v-else> - </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="ele m-lr-0" id="element6">
                <h5 class="profile_header col-12">口コミ</h5>
                <div class="col-lg-12 col-md-12 col-sm-12 pad-0-res m-0"  v-if="displayItems.length>0">
                    <div class="card mb-4 col-12 p-0" v-for="comment in displayItems" :key="comment.id">
                        <div class="card-body">
                            <div class="comment-title">
                                <i class="fas fa-comment"></i>{{comment.title}}
                            </div>
                            <div class="d-flex d-block">
                                <p class="comment-date"><i class="fa fa-calendar-alt" aria-hidden="true"></i> {{comment.created_date | moment("YYYY年MM月DD日") }}投稿 <span class="ml-2"><i class="fa fa-clock" aria-hidden="true"></i> {{comment.created_time}}</span></p>
                            </div>
                            <read-more more-str="もっと見る" :text="comment.comment" :max-chars="160" class="m-t-comment"></read-more><br>
                            <div>{{comment.customer}}</div>
                        </div>
                    </div>
                    <div class="m-b-20 text-right">
                        <router-link :to="{ path:'/comment/nursing/'+ pro_id}" class="comment-btn" v-if="show_comment"> <i class="far fa-comment"></i>
                            <span>口コミを投稿する</span>
                        </router-link>
                    </div>
                </div>
                <div v-else class="row col-12 m-0 p-0">
                    <div class="col-12 m-b-768">
                        <p class="no-data-color pb-3">口コミはありません。</p>
                    </div>                  
                    <div class="col-12 m-b-20 text-right p-0">
                        <router-link :to="{ path:'/comment/nursing/'+ pro_id}" class="comment-btn" v-if="show_comment"> <i class="far fa-comment"></i>
                            <span>口コミを投稿する</span>
                        </router-link>
                    </div>
                </div>
                <div class="col-12" v-if="pagination">
                    <nav aria-label="Page navigation example">
                        <ul class="pagination">
                            <li class="page-item">
                                <span class="spanclass" @click="first"><i class='fas fa-angle-double-left'></i> 最初</span>
                            </li>
                            <li class="page-item">
                                <span class="spanclass" @click="prev"><i class='fas fa-angle-left'></i> 前へ</span>
                            </li>
                            <li class="page-item" v-for="(i,index) in displayPageRange" :key="index" :class="{active_page: i-1 === currentPage}">
                                <span class="spanclass" @click="pageSelect(i)">{{i}}</span>
                            </li>
                            <li class="page-item">
                                <span class="spanclass" @click="next">次へ <i class='fas fa-angle-right'></i></span>
                            </li>
                            <li class="page-item">
                                <span class="spanclass" @click="last">最後 <i class='fas fa-angle-double-right'></i></span>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
        <div v-if="type == 'hospital'" id="hospitalView">
            <p class="job_id3" v-if="$auth.user().role == 2"><span>施設番号:{{profilenumber}}</span></p>
            <div v-else>
                <div class="pc-9-180">
                    <span class="customer-id ">施設番号:{{profilenumber}}</span>
                </div>
                <p class="job_id3 sp-9-180"><span>施設番号:{{profilenumber}}</span></p>
            </div>
            <h5 class="profile-tit" v-if="hospitals[0]"> {{hospitals[0].name}}</h5>
            <div class="tab typelabel nav-link fixed-nav el el2">               
                <button v-scroll-to="{ el: '#element7'}" class="top-fixed-btn" @click="activate(7)" :class="{ active : active_el == 7 }">
                    病院情報
                </button>
                <button v-scroll-to="{ el: '#element8' }" class="top-fixed-btn" @click="activate(8)" :class="{ active : active_el == 8 }">
                    地図
                </button>
                <button v-scroll-to="{ el: '#element9' }" class="top-fixed-btn" @click="activate(9)" :class="{ active : active_el == 9 }">
                    口コミ
                </button>
            </div>
            <div class="ele m-lr-0 pt-2" id="element7">
                <!-- ee-->
                <div class="row col-12 list-wrap m-lr-0 white-bg-color" v-for="cust in hospitals" :key="cust.id">
                    <!--for slideimage-->
                    <div class="col-md-5 col-slg-12 col-sm-12 detail_profile_left pad-free-750">
                        <div class="col-12 pad-free sp-1024">
                            <h5 class="profile_header">
                                <span class="span-height">病院情報</span>
                                <!--fav and mail btn-->
                                <div class="d-block float-right pc-414" v-if="loginuser=='false'">
                                    <div class="m-r-10 float-left">
                                        <span class="bottom-fav-btn" v-if="!view_pro_id && loginuser=='false'" @click="favAddFun('add');view_pro_id = !view_pro_id"><i class="fas fa-plus-square" style="color:#c40000!important;"></i>&nbsp; お気に入りに追加</span>
                                        <span class="bottom-fav-btn" style="color:#aaa;" v-if="view_pro_id && loginuser=='false'" @click="favAddFun('remove');view_pro_id = !view_pro_id"><i class="fas fa-check-double" style="color:#c40000!important;"></i>&nbsp; 追加済み</span>
                                    </div>
                                    <div class="float-right">
                                        <span class="" v-if="loginuser=='false' && !$auth.check() && type == 'nursing'">       
                                            <span class="bottom-mail-btn" @click="documentPost()"><i data-v-b65423c6="" class="far fa-envelope" style="color: #fff  !important;font-size: 15px;"></i>&nbsp;資料請求</span>
                                        </span>
                                    </div>
                                </div>
                                <!--end fav and mail btn-->
                            </h5>
                            <!--fav and mail btn-->
                            <section class="row col-12 m-0 p-0">
                                <div class="d-block float-right ml-0 m-b-20 sp-414" v-if="loginuser=='false'">
                                    <div class="m-r-10 float-left">
                                        <span class="bottom-fav-btn" v-if="!view_pro_id && loginuser=='false'" @click="favAddFun('add');view_pro_id = !view_pro_id"><i class="fas fa-plus-square" style="color:#c40000!important;"></i>&nbsp; お気に入りに追加</span>
                                        <span class="bottom-fav-btn" style="color:#aaa;" v-if="view_pro_id && loginuser=='false'" @click="favAddFun('remove');view_pro_id = !view_pro_id"><i class="fas fa-check-double" style="color:#c40000!important;"></i>&nbsp; 追加済み</span>
                                    </div>
                                    <div class="float-right">
                                        <span class="" v-if="loginuser=='false' && !$auth.check() && type == 'nursing'">       
                                            <span class="bottom-mail-btn" @click="documentPost()"><i data-v-b65423c6="" class="far fa-envelope" style="color: #fff  !important;font-size: 15px;"></i>&nbsp;資料請求</span>
                                        </span>
                                    </div>
                                </div>
                            </section>
                            <!--end fav and mail btn-->                                                               
                        </div>
                        <div class="thumbnail-img pc-414">
                            <div class="card-carousel">
                                <div class="card-img photocard-carousel-wrapper">
                                    <img :src="'/upload/hospital_profile/' +currentImage" alt="" @error="imgUrlAlt">
                                    <div class="actions">
                                        <span @click="prevImage" class="prev">
                                            <i class="fas fa-chevron-left"></i>
                                        </span>
                                        <span @click="nextImage" class="next">
                                            <i class="fas fa-chevron-right"></i>
                                        </span>
                                    </div>
                                </div>
                                <div class="row col-12 photocard-title">
                                    <h5><strong class="img_2">  {{activeImageTitle}} </strong></h5>
                                    <div class="row col-12 m-b-10">
                                        <p class="text-left">{{activeImageDescription}}</p>
                                    </div>
                                </div>
                                <div class="thumbnails">
                                    <div
                                        v-for="(image,index) in  images"
                                        :key="image.id"
                                        :class="['thumbnail-image', (activeImage == index) ? 'active' : '']"
                                        @click="activateImage(index)" >
                                        <img  :src ="'/upload/hospital_profile/' + image.photo" @error="imgUrlAlt">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--responsive with gallery-->
                        <div class="sp-414 res-pano m-b-10"  v-if="images.length > 0">
                            <slick :options="slickOptions" ref="slickSetting1">
                                <div><h2><img :src="'/upload/hospital_profile/' +currentImage" alt="" @error="imgUrlAlt" class="img-fluid"></h2></div>
                            </slick>
                            <slick>
                                <p><strong>  {{activeImageTitle}} </strong></p>
                            </slick>
                            <slick>
                                <p>{{activeImageDescription}}</p>
                            </slick>
                            <slick :options="slickOptions2" ref="slickSetting2" id="res-pano">
                                <div v-for="(image,index) in  images" :key="image.id" :class="[(activeImage == index) ? 'active' : '']" @click="activateImage(index)">
                                    <h3>
                                        <span>
                                            <img  :src ="'/upload/hospital_profile/' + image.photo" @error="imgUrlAlt" class="img-fluid">
                                        </span>
                                    </h3>
                                </div>
                            </slick>
                        </div>
                        <!--end responsive with gallery -->
                    </div>
                    <!--end for slide image-->
                    <!--for address-->
                    <div class="col-md-7 col-sm-12 detail_profile_right col-slg-12 pad-free-750">
                        <div class="row m-lr-0">
                            <div class="col-12 pro-heading pad-free">
                                <div class="col-12 pad-free pc-1024">
                                    <h5 class="profile_header">
                                        <span class="span-height">病院情報</span>
                                        <!--fav and mail btn-->
                                        <div class="d-block float-right" v-if="loginuser=='false'">
                                            <div class="m-r-10 float-left">
                                                <span class="bottom-fav-btn" v-if="!view_pro_id && loginuser=='false'" @click="favAddFun('add');view_pro_id = !view_pro_id"><i class="fas fa-plus-square" style="color:#c40000!important;"></i>&nbsp; お気に入りに追加</span>
                                                <span class="bottom-fav-btn" style="color:#aaa;" v-if="view_pro_id && loginuser=='false'" @click="favAddFun('remove');view_pro_id = !view_pro_id"><i class="fas fa-check-double" style="color:#c40000!important;"></i>&nbsp; 追加済み</span>
                                            </div>
                                            <div class="float-right">
                                                <span class="" v-if="loginuser=='false' && !$auth.check() && type == 'nursing'">       
                                                    <span class="bottom-mail-btn" @click="documentPost()"><i data-v-b65423c6="" class="far fa-envelope" style="color: #fff  !important;font-size: 15px;"></i>&nbsp;資料請求</span>
                                                </span>
                                            </div>
                                        </div>
                                        <!--end fav and mail btn-->
                                    </h5>                                   
                                </div>                                 
                                <table class="table table-bordered info_tbl">
                                    <tr>
                                        <th class="custom-bg-color">
                                            <font>住所 </font>
                                        </th>
                                        <td v-if="cust.address">
                                            <font>{{cust.address}}</font>
                                        </td>
                                        <td v-else> - </td>
                                    </tr>
                                    <tr>
                                        <th class="custom-bg-color">
                                            <font>電話番号</font>
                                        </th>
                                        <td v-if="cust.phone">
                                            <font>{{cust.phone}}</font>
                                        </td>
                                        <td v-else> - </td>
                                    </tr>
                                        <tr>
                                        <th class="custom-bg-color">
                                            <font>アクセス</font>
                                        </th>
                                        <td v-if="cust.access">
                                            <p v-html="cust.access"></p>
                                        </td>
                                        <td v-else> - </td>
                                    </tr>
                                        <tr>
                                        <th class="custom-bg-color">
                                            <font>件名 </font>
                                        </th>
                                        <td v-if="subject">
                                            <label >
                                                {{subject}}
                                            </label>
                                        </td>
                                        <td v-else> - </td>
                                    </tr>
                                </table>
                            </div>                            
                        </div>
                            <h5 class="header m-t-10">こだわりの特長</h5>
                        <div class="row m-lr-0" v-if="specialfeature">
                            <ul class="hos_fac_container" v-for="special in specialfeature" :key="special.id">
                                <li>{{special.short_name}}</li>
                            </ul>
                        </div>
                        <div class="row m-lr-0 m-b-768" v-else> <p class="no-data-color">データがありません。</p> </div>                       
                    </div>
                    <!--end for address-->
                </div>
                <div class="col-12 m-b-20 pad-free-750">
                    <h5 class="profile_subtit">診療科目 </h5>
                    <div class="row col-md-12" v-if="subjects">
                        <ul class="sub_container" v-for="sub in subjects" :key="sub.id">
                            <li>{{sub.name}}</li>
                        </ul>
                    </div>
                    <div class="col-12 m-b-768" v-else>
                        <p class="no-data-color">データがありません。</p>
                    </div>
                </div>             
                <!--end ee-->
                <div class="col-12 m-b-20 pad-free-750">
                    <h5 class="profile_subtit">医院からのお知らせ </h5>
                    <p class="col-12">
                        <span v-if="hospitals[0]"><p v-html="hospitals[0].details_info"></p></span>
                        <span v-else><p class="no-data-color">データがありません。</p></span>
                    </p>
                </div>
                <div class="col-12 m-b-20 pad-free-750">
                    <h5 class="profile_subtit">診療時間 </h5>
                    <div class="row m-0">
                        <div class="col-md-9 col-sm-12 pad-free-750">
                            <table class="table table-bordered timeTable">
                                <tbody>
                                    <tr class="first-row">
                                        <th> 日付 </th>
                                        <th> 月 </th>
                                        <th> 火 </th>
                                        <th> 水 </th>
                                        <th> 木 </th>
                                        <th> 金 </th>
                                        <th> 土 </th>
                                        <th> 日 </th>
                                    </tr>
                                    <tr class="last" v-if="am_arr[0]">
                                        <th class="second-row text-center">午前</th>
                                        <td v-for="(amval,index) in am_arr[0]" :key="index" class="text-center">
                                            <span v-if="amval"> {{amval}} </span>
                                            <span v-else> - </span>
                                        </td>
                                    </tr>
                                    <tr class="last" v-else>
                                        <th class="second-row text-center">午前</th>
                                        <td v-for="indx in 7" :key="indx" class="text-center"> - </td>
                                    </tr>
                                    <tr class="last" v-if="pm_arr[0]">
                                        <th class="second-row text-center">午後</th>
                                        <td v-for="(amval,index) in pm_arr[0]" :key="index" class="text-center">
                                            <span v-if="amval"> {{amval}} </span>
                                            <span v-else> - </span>
                                        </td>
                                    </tr>
                                    <tr class="last" v-else>
                                        <th class="second-row text-center">午後</th>
                                        <td v-for="indx in 7" :key="indx" class="text-center"> - </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-md-3 col-sm-12 pad-free-750">
                            <p><strong class="font-weight-bold">休診日: </strong>
                                <span v-if="hospitals[0]"><font>{{hospitals[0].closed_day}}</font></span>
                                <span v-else> <p class="no-data-color">データがありません。</p> </span>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-12 pad-free-750">
                    <h5 class="profile_subtit">院内施設情報 </h5>
                    <div class="row col-md-12 m-0">
                        <div class="col-md-2 fac-name-box" v-for="hosfacility in hosfacilities " :key="hosfacility.id">
                            <h4>{{hosfacility.description}}</h4>
                            <div class="fac-check-box" v-if="fac_list">
                                <span v-if="fac_list.length>0">
                                    <p v-for="fac in fac_list" :key="fac.id">
                                        <i v-if="fac.id === hosfacility.id"><p class="circle_t"></p></i>
                                    </p>
                                </span>
                                <span v-else>
                                    <p> - </p>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12 pad-free-750">
                <h5 class="profile_subtit">フォトアルバム</h5>
                <div class="row m-0" v-if="light_images == '' || light_images.length == 0">
                    <div class="col-12 pad-free-750"> <p class="no-data-color">データがありません。</p> </div>
                </div>
                <div class="row m-0 gallery-list" v-else>
                    <div v-for="(image,index) in  light_images" :key="index" class="col-6 col-lg-3 col-md-4 col-sm-4 m-b-10">
                        <div class=" gallery-item">
                            <img :src ="'/upload/hospital_profile/' + image.name" class="img-fluid" @click="showLightbox(image.name)" @error="imgUrlAlt" >
                        </div>
                        <span class="img_txt">{{image.title}}</span><br>
                    </div>
                    <lightbox id="mylightbox" ref="lightbox" :images="light_images" :directory="thumbnailDir+'hospital_profile/'" :timeoutDuration="5000" />
                </div>
            </div>
            <!-- Hospital Video -->
            <div class="col-md-12 pad-free-750">
                <h5 class="profile_subtit">動画</h5>
                <div class="row m-0 gallery-list" v-if="videos.length>0" style="width:100%;">
                    <div v-for="(video) in  videos" :key="video.id" class="col-12 col-lg-3 col-md-4 col-sm-4 m-b-10">
                        <div class="gallery-item" style="height:135px;">
                            <iframe :src="'https://www.youtube.com/embed/'+video.photo" controls width="100%"></iframe>
                        </div>
                        <span class="video_txt">{{video.title}}</span><br>
                    </div>
                </div>
                <div class="row m-0" v-else>
                    <div class="col-12">
                        <span> <p class="no-data-color">データがありません。</p> </span>
                    </div>
                </div>
            </div>
            <!-- End -->
            <div class="m-lr-0" id="element8">
                <h5 class="profile_header">
                    <span class="span-height">地図</span>
                    <!--fav and mail btn-->
                    <div class="d-block float-right pc-414" v-if="loginuser=='false'">
                        <div class="m-r-10 float-left">
                            <span class="bottom-fav-btn" v-if="!view_pro_id && loginuser=='false'" @click="favAddFun('add');view_pro_id = !view_pro_id"><i class="fas fa-plus-square" style="color:#c40000!important;"></i>&nbsp; お気に入りに追加</span>
                            <span class="bottom-fav-btn" style="color:#aaa;" v-if="view_pro_id && loginuser=='false'" @click="favAddFun('remove');view_pro_id = !view_pro_id"><i class="fas fa-check-double" style="color:#c40000!important;"></i>&nbsp; 追加済み</span>
                        </div>
                        <div class="float-right">
                            <span class="" v-if="loginuser=='false' && !$auth.check() && type == 'nursing'">       
                                <span class="bottom-mail-btn" @click="documentPost()"><i data-v-b65423c6="" class="far fa-envelope" style="color: #fff  !important;font-size: 15px;"></i>&nbsp;資料請求</span>
                            </span>
                        </div>
                    </div>
                    <!--end fav and mail btn-->
                </h5>
                <!--fav and mail btn-->
                <section class="row col-12 m-0 p-0">
                    <div class="d-block float-right ml-0 m-b-20 sp-414" v-if="loginuser=='false'">
                        <div class="m-r-10 float-left">
                            <span class="bottom-fav-btn" v-if="!view_pro_id && loginuser=='false'" @click="favAddFun('add');view_pro_id = !view_pro_id"><i class="fas fa-plus-square" style="color:#c40000!important;"></i>&nbsp; お気に入りに追加</span>
                            <span class="bottom-fav-btn" style="color:#aaa;" v-if="view_pro_id && loginuser=='false'" @click="favAddFun('remove');view_pro_id = !view_pro_id"><i class="fas fa-check-double" style="color:#c40000!important;"></i>&nbsp; 追加済み</span>
                        </div>
                        <div class="float-right">
                            <span class="" v-if="loginuser=='false' && !$auth.check() && type == 'nursing'">       
                                <span class="bottom-mail-btn" @click="documentPost()"><i data-v-b65423c6="" class="far fa-envelope" style="color: #fff  !important;font-size: 15px;"></i>&nbsp;資料請求</span>
                            </span>
                        </div>
                    </div>
                </section>
                <!--end fav and mail btn--> 
                <div class="row col-lg-12 col-md-12 col-sm-12 pad-free-750 m-0 p-0">
                    <GmapMap id="googlemap" class="col-12" ref="map" :center="center" :zoom="10" >
                        <GmapMarker v-for="(m, index) in markers" :key="index" :position="m.position" :clickable="true" :draggable="false" @click="center=m.position" />
                    </GmapMap>
                </div>              
                <div  class="col-12 m-t-20 pad-free-750" v-for="m in hospitals" :key="m.id" >
                    <table border="1" class="table table-bordered map_tbl" >
                        <tbody>
                            <tr>
                                <th class="custom-bg-color"> 公式サイト</th>
                                <td v-if="m.website">{{m.website}}</td>
                                <td v-else> - </td>
                            </tr>
                            <tr>
                                <th class="custom-bg-color"> メールアドレス</th>
                                <td>{{m.email}}</td>
                            </tr>
                            <tr>
                                <th class="custom-bg-color"> アクセス</th>
                                <td v-if="m.access"><p v-html="m.access"></p></td>
                                <td v-else> - </td>
                            </tr>
                            <tr>
                                <th class="custom-bg-color"> 混雑状況</th>
                                <td v-if="m.congestion">{{m.congestion}}</td>
                                <td v-else> - </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="row ele m-lr-0" id="element9">
                <h5 class="profile_header col-12 m-t-20">口コミ</h5>
                <div class="col-lg-12 col-md-12 col-sm-12 pad-free-750"  v-if="displayItems.length>0">
                    <div class="card mb-4" v-for="comment in displayItems" :key="comment.id">
                        <div class="card-body">
                            <div class="comment-title">
                                <i class="fas fa-comment"></i>{{comment.title}}
                            </div>
                            <div class="d-flex">
                                <p class="comment-date"><i class="fa fa-calendar-alt" aria-hidden="true"></i> {{comment.created_date | moment("YYYY年MM月DD日") }}投稿 <span class="ml-2"><i class="fa fa-clock" aria-hidden="true"></i> {{comment.created_time}}</span></p>
                            </div>
                            <read-more more-str="もっと見る" :text="comment.comment" :max-chars="160" class="m-t-comment"></read-more><br>
                            <div>{{comment.customer}}</div>
                        </div>
                    </div>                    
                    <div class="m-b-20 text-right">
                        <router-link :to="{ path:'/comment/hospital/'+ pro_id}" class="comment-btn" v-if="show_comment"> <i class="far fa-comment"></i>
                            <span>口コミを投稿する</span>
                        </router-link>
                    </div>
                </div>
                <div v-else class="row col-12 m-0 p-0">
                    <div class="col-12">
                        <p class="no-data-color pb-3">口コミはありません。</p>
                    </div>                    
                    <div class="col-12 m-b-20 text-right p-0">
                        <router-link :to="{ path:'/comment/hospital/'+ pro_id}" class="comment-btn" v-if="show_comment"> <i class="far fa-comment"></i>
                            <span>口コミを投稿する</span>
                        </router-link>
                    </div>
                </div>
                <div class="offset-md-4 col-md-8 mt-3" v-if="pagination">
                    <nav aria-label="Page navigation example">
                        <ul class="pagination">
                            <li class="page-item">
                                <span class="spanclass" @click="first"><i class='fas fa-angle-double-left'></i><span class="aa">最初</span></span>
                            </li>
                            <li class="page-item">
                                <span class="spanclass" @click="prev"><i class='fas fa-angle-left'></i> <span>前へ</span></span>
                            </li>
                            <li class="page-item" v-for="(i,index) in displayPageRange" :key="index" :class="{active_page: i-1 === currentPage}">
                                <span class="spanclass" @click="pageSelect(i)">{{i}}</span>
                            </li>
                            <li class="page-item">
                                <span class="spanclass" @click="next"><span>次へ</span> <i class='fas fa-angle-right'></i></span>
                            </li>
                            <li class="page-item">
                                <span class="spanclass" @click="last"><span>最後</span><i class='fas fa-angle-double-right'></i></span>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Slick from 'vue-slick'
import Pannellum from '../../js/components/vue-pannellum.vue'
import Lightbox from 'vue-my-photos'
export default {
    components:{
        Pannellum,
        Lightbox,
        Slick
    },
    data() {
        var that = this;
        return {
            nus_pro:[],
            ads_list: [],
            profile_id: "",
            url: '/upload/nursing_profile/Imagepanorama/',
            isAutoRotationOn: true,
            isOrientationOn: true,
            markers: [
                {  position: { lat: 0, lng: 0 }  },
            ],
            am_arr:[],
            images:[],
            videos:[],
            pm_arr:[],
            active_el:0,
            width: '',
            center: { lat: 0, lng: 0 },
            address: '',
            hosfacilities:[],
            specialfeature:[],
            nusfacilities:[],
            nus_method:[],
            cooperate_medical:[],
            medical_acceptance:[],
            medical:[],
            fac_list:[],
            staff:[],
            subject:'',
            subjects:[],
            hospitals:[],
            address:[],
            nursing_profiles:[],
            method_payment:[],
            comments:[],
            activeImage: 0,
            activePanoImage: 0,
            activeImageTitle:'',
            activeImageDescription:'',
            index: 0,
            light_images:[],
            thumbnailDir: '/upload/',
            opts: {
                start: 0,
                dir: 'v',
                loop: false,
                duration:500,
                beforeChange: function(ele, current, next) {
                    that.index = next;
                },
                afterChange: function(ele, current) {
                    that.index = current;
                }
            },
            panoimages:[],
            panocurrentOffset: 0,
            windowSize: 10,
            paginationFactor:103,
            fav_email : [],
            currentPage: 0,
            size: 5,
            pageRange: 10,
            pagination: false,
            data: {
                str:"Welcome to Canada!",
                substr: ""
            },
            window: {
                width: 0,
                height: 0
            },
            isPano: false,
            show_comment: false,
            view_pro_id: false,
            profilenumber:'',           
        };
    },
    props:{
        pro_id:Number,
        type:String,
        loginuser:Boolean,       
    },
    created(){     
        window.addEventListener('scroll', this.handleScroll);
        this.pro_id = Number(this.$route.params.id);
        this.type = this.$route.params.type;
        if(this.type == 'hospital'){
            if(localStorage.getItem("hospital_history")) {
                var hos_his_arr = JSON.parse("[" + localStorage.getItem("hospital_history") + "]");
                hos_his_arr.push(this.pro_id);
                hos_his_arr = [...new Set(hos_his_arr)];
                localStorage.setItem("hospital_history", hos_his_arr);
                this.hosHis = hos_his_arr.length;
            }
            else{
                var hos_his_arr = [this.pro_id];
                localStorage.setItem("hospital_history", hos_his_arr);
                this.hosHis = hos_his_arr.length;
                $('.his-hospital-link-box>a').css({'cursor':'pointer','pointer-events':'auto'});
            }
            if(localStorage.getItem("hospital_fav")){
                var nus_fav_arr = JSON.parse("[" + localStorage.getItem("hospital_fav") + "]");
                this.view_pro_id = nus_fav_arr.includes(this.pro_id);
            }
        }
        else{
            if(localStorage.getItem("nursing_history")) {
                var nus_his_arr = JSON.parse("[" + localStorage.getItem("nursing_history") + "]");
                nus_his_arr.push(this.pro_id);
                nus_his_arr = [...new Set(nus_his_arr)];
                localStorage.setItem("nursing_history", nus_his_arr);
                this.nusHis = nus_his_arr.length;
            }
            else{
                var nus_his_arr = [this.pro_id];
                localStorage.setItem("nursing_history", nus_his_arr);
                this.nusHis = nus_his_arr.length;
                $('.his-nursing-link-box>a').css({'cursor':'pointer','pointer-events':'auto'});
            }
            if(localStorage.getItem("nursing_fav")){
                var nus_fav_arr = JSON.parse("[" + localStorage.getItem("nursing_fav") + "]");
                this.view_pro_id = nus_fav_arr.includes(this.pro_id);
            }
        }        
        //
        this.axios.get("/api/advertisement/ads").then(response => {
            this.ads_list = response.data;
        });
        //end
        window.addEventListener('resize', this.handleResize);
        this.handleResize();
        if(this.window.width >= 320 && this.window.width < 450) {
            this.windowSize = 1;
        }
        else if(this.window.width >= 450 && this.window.width < 768) {
            this.windowSize = 2;
        }
        else if(this.window.width >= 768 && this.window.width < 992) {
            this.windowSize = 4;
        }
        else if(this.window.width >= 992 && this.window.width < 1024) {
            this.windowSize = 7;
        }
        else if (this.window.width >= 1024 && this.window.width < 1280) {
            this.windowSize = 8;
        }
        else if (this.window.width >= 1280 && this.window.width < 1440) {
            this.windowSize = 9;
        }
        else if (this.window.width >= 1440 && this.window.width < 1880) {
            this.windowSize = 9;
        }
        this.profile_id = this.pro_id;
        this.activePanoImage = 0;
        //for responsive
        if(this.window.width > 768) {
            //greater than 768
            if(this.loginuser == 'true') {
                $(document).scroll(function() {
                    var cur_pos = $(this).scrollTop();
                    $('.ele').each(function(active_el){
                        if($(this).position().top <= (cur_pos+71)){
                            $('.top-fixed-btn.active').removeClass('active');
                            $('.top-fixed-btn').eq(active_el).addClass('active');
                        }
                    });
                });
            } else {
                // public                    
                $(document).scroll(function() {
                    var cur_pos = $(this).scrollTop();
                    $('.ele').each(function(active_el){
                        if($(this).position().top <= (cur_pos+71)){
                            $('.top-fixed-btn.active').removeClass('active');
                            $('.top-fixed-btn').eq(active_el).addClass('active');
                        }
                    });
                });
            }
            //greater than 768
        }
        else {
            //less than 768
            if(this.loginuser == 'true') {
            $(document).scroll(function() {
                var cur_pos = $(this).scrollTop();
                $('.ele').each(function(active_el){
                    if($(this).position().top <= (cur_pos+71)){
                        $('.top-fixed-btn.active').removeClass('active');
                        $('.top-fixed-btn').eq(active_el).addClass('active');
                    }
                });
            });
            } else {               
                $(document).scroll(function() {
                    var cur_pos = $(this).scrollTop();
                    $('.ele').each(function(active_el){
                        if($(this).position().top <= (cur_pos+71)){
                            $('.top-fixed-btn.active').removeClass('active');
                            $('.top-fixed-btn').eq(active_el).addClass('active');
                        }
                    });
                });
            }
            //end less than 768
        }
        //for end responsive
        if(this.type == "nursing")
        {
            this.axios.get('/api/profile/nursing/'+this.pro_id) .then(response => {
                this.profilenumber = response.data.profilenumber[0]['profilenumber'];
                this.nus_pro = response.data.nurselatlong;             
                if(!this.$auth.check()){
                    this.show_comment = true;
                }else{
                    if(this.$auth.user().role == 2){
                        this.show_comment = false;
                    }else{
                        if(this.$auth.user().customer_id == this.nus_pro[0].customer_id){
                            this.show_comment = false;
                        }else{
                            this.show_comment = true;
                        }
                    }
                }
                if(this.nus_pro[0]['address'] == null){
                    this.nus_pro[0]['address'] = '';
                }
                this.address = response.data.address;
                this.nus_pro[0]['address'] = this.address[0]['city_name'] + this.address[0]['township_name'] +this.nus_pro[0]['address'];
                this.nusfacilities = response.data.facility;
                this.nursing_profiles = response.data.nurselatlong[0]['feature'];
                this.nus_method= response.data.nurselatlong[0]['method'];
                this.method_payment = response.data.cost;
                this.cooperate_medical = response.data.comedical;
                this.medical_acceptance = response.data.medicalacceptance;
                this.medical = response.data.medical;
                this.staff = response.data.staff;
                this.markers[0]['position']['lat']  = response.data.nurselatlong[0]['latitude'];
                this.markers[0]['position']['lng']  = response.data.nurselatlong[0]['longitude'];
                this.center['lat'] = response.data.nurselatlong[0]['latitude'];
                this.center['lng'] = response.data.nurselatlong[0]['longitude'];
                this.images = response.data.images;
                if(this.images.length == 1){
                    if(this.images[0]['photo'] != null){
                        for(var i=0; i<this.images.length; i++){
                            this.light_images.push({
                                'name': this.images[i]['photo'],
                                'description': this.images[i]['description'],
                                'id': this.images[i]['id'],
                                'title': this.images[i]['title']
                            })
                        }
                    }
                }
                else{
                    for(var i=0; i<this.images.length; i++){
                        this.light_images.push({
                            'name': this.images[i]['photo'],
                            'description': this.images[i]['description'],
                            'id': this.images[i]['id'],
                            'title': this.images[i]['title']
                        })
                    }
                }
                this.panoimages = response.data.panoimages;
                this.videos = response.data.videos;
                if(response.data.nurselatlong[0]['latitude'] == 0 && response.data.nurselatlong[0]['longitude'] == 0)
                {
                    this.center['lat'] = 35.6803997;
                    this.center['lng'] = 139.76901739;
                    this.markers[0]['position']['lat']  = 35.6803997;
                    this.markers[0]['position']['lng']  = 139.76901739;
                }
                var catname = '介護';
                this.$ga.event({
                    eventCategory: '施設',
                    eventAction: catname+' / '+this.profilenumber+' / '+this.nus_pro[0].name,
                })
            });
            this.axios.get(`/api/profile/specialfeature/${this.type}/${this.pro_id}`) .then(response => {
                this.specialfeature = response.data;
            });
            this.axios.get('/api/profile/comment/'+this.pro_id+'/'+this.type) .then(response => {
                this.comments = response.data;
                if(this.comments.length > this.size){
                    this.pagination = true;
                }else{
                    this.pagination = false;
                }
            });
        }
        else{
            this.axios.get('/api/profile/hospital/'+this.pro_id).then(response => {    
                this.profilenumber = response.data.profilenumber[0]['profilenumber'];                  
                this.address = response.data.address;
                this.hospitals = response.data.hospital;                
                if(!this.$auth.check()){
                    this.show_comment = true;
                }else{
                    if(this.$auth.user().role == 2){
                        this.show_comment = false;
                    }else{
                        if(this.$auth.user().customer_id == this.hospitals[0].customer_id){
                            this.show_comment = false;
                        }else{
                            this.show_comment = true;
                        }
                    }
                }
                if(this.hospitals[0]['address'] == null){
                    this.hospitals[0]['address'] = '';
                }
                this.hospitals[0]['address'] = this.address[0]['city_name'] + this.address[0]['township_name'] +this.hospitals[0]['address'];
                this.hosfacilities=response.data.facility_list;
                this.fac_list = response.data.facility;
                this.markers[0]['position']['lat']  = response.data.hospital[0]['latitude'];
                this.markers[0]['position']['lng']  = response.data.hospital[0]['longitude'];
                this.center['lat'] = response.data.hospital[0]['latitude'];
                this.center['lng'] = response.data.hospital[0]['longitude'];
                this.images = response.data.images;
                if(this.images.length == 1){
                    if(this.images[0]['photo'] != null){
                        for(var i=0; i<this.images.length; i++){
                            this.light_images.push({
                                'name': this.images[i]['photo'],
                                'description': this.images[i]['description'],
                                'id': this.images[i]['id'],
                                'title': this.images[i]['title']
                            })
                        }
                    }
                }
                else{
                    for(var i=0; i<this.images.length; i++){
                        this.light_images.push({
                            'name': this.images[i]['photo'],
                            'description': this.images[i]['description'],
                            'id': this.images[i]['id'],
                            'title': this.images[i]['title']
                        })
                    }
                }
                this.videos = response.data.videos;
                if(response.data.hospital[0]['latitude'] == 0 && response.data.hospital[0]['longitude'] == 0)
                {
                    this.center['lat'] = 35.6803997;
                    this.center['lng'] = 139.76901739;
                    this.markers[0]['position']['lat']  = 35.6803997;
                    this.markers[0]['position']['lng']  = 139.76901739;
                }
                var catname = '病院';
                this.$ga.event({
                    eventCategory: '施設',
                    eventAction: catname+' / '+this.profilenumber+' / '+this.hospitals[0].name,
                })
            });
            this.axios.get(`/api/profile/specialfeature/${this.type}/${this.pro_id}`).then(response => {
                this.specialfeature = response.data;
            });
            this.axios.get('/api/profile/comment/'+this.pro_id+'/'+this.type).then(response => {
                this.comments = response.data;
                if(this.comments.length > this.size){
                    this.pagination = true;
                }else{
                    this.pagination = false;
                }
            });
            this.axios.get('/api/profile/subject/'+this.pro_id).then(response => {
                this.subjects = response.data;
                for(var i=0; i< response.data.length; i++) {
                    this.subject += response.data[i]['name'] + " , ";
                }
            });
            this.axios.get('/api/profile/schedule/'+this.pro_id) .then(response => {
                this.am_arr = response.data.am;
                this.pm_arr = response.data.pm;
            });            
        }                
        var new_width = document.querySelector("#content-all").offsetWidth;
        var fixed_width = new_width - 80;
        this.width = fixed_width + "px";
        var main_header = $(".main-header").height();
        var main_top =  main_header  + "px" ;
        var admin_header = $(".admin-header").height();
        var admin_top = admin_header  + "px" ;
    },
    destroyed () {
        window.removeEventListener('scroll', this.handleScroll);
    },
    computed: {
        atEndOfList() {
            return this.panocurrentOffset <= (this.paginationFactor * -1) * (this.panoimages.length - this.windowSize);
        },
        atHeadOfList() {
            return this.panocurrentOffset === 0;
        },
        currentPanoImage() {
            if(this.panoimages.length > 0) {
                return this.panoimages[this.activePanoImage].photo;
            }
        },
        currentImage() {
            if(this.images) {
                if(this.images.length > 0) {
                    this.activeImageTitle = this.images[this.activeImage].title;
                    this.activeImageDescription = this.images[this.activeImage].description;
                    return this.images[this.activeImage].photo;
                }
                else{
                    return 'no-image-big.jpg';
                }
            }
            else{
                return 'no-image-big.jpg';
            }
        },
        pages() {
            return Math.ceil(this.comments.length / this.size);
        },
        displayPageRange() {
            const half = Math.ceil(this.pageRange / 2);
            const isEven = this.pageRange / 2 == 0;
            const offset = isEven ? 1 : 2;
            let start, end;
            if (this.pages < this.pageRange) {
                start = 1;
                end = this.pages;
            } else if (this.currentPage < half) {
                start = 1;
                end = start + this.pageRange - 1;
            } else if (this.pages - half < this.currentPage) {
                end = this.pages;
                start = end - this.pageRange + 1;
            } else {
                start = this.currentPage - half + offset;
                end = this.currentPage + half;
            }
            let indexes = [];
            for (let i = start; i <= end; i++) {
                indexes.push(i);
            }
            return indexes;
        },
        displayItems() {
            const head = this.currentPage * this.size;
            return this.comments.slice(head, head + this.size);
        },
        isSelected(page) {
            return page - 1 == this.currentPage;
        },
        slickOptions() {
            return {
            slidesToShow: 1,
            slidesToScroll: 1,
            arrows: false,
            fade: false,
            adaptiveHeight: true,           
            }
        },
        slickOptions2() {
            return {
                slidesToShow: 7,
                slidesToScroll: 1,
                arrows:false,
                dots: false,
                focusOnSelect: true,
                responsive: [{
                    breakpoint: 411,
                        settings: {
                            slidesToShow: 8.5,
                            slidesToScroll: 1,
                            focusOnSelect: true,
                        }
                    }, {
                    breakpoint: 360,
                        settings: {
                            slidesToShow: 8,
                            slidesToScroll: 1,
                            focusOnSelect: true,
                        }
                }]
            }
        }
    },
    methods: {
        handleScroll (event) {                
            if(this.window.width > 768) {
                //greater than 768
                if(this.loginuser == 'true') {
                    var el = document.querySelectorAll('.el');
                    var el2 = document.querySelectorAll('.el2');                       
                    var index = 0, length = el.length;                    
                    for ( ; index < length; index++) {
                        el[index].style.position = "fixed";
                        el[index].style.top = "85px";
                        el[index].style.display = "block";
                        el[index].style.margin = "0px 0px 0px 175px";                           
                    }   
                    for (let i = 0; i < el2.length; i++) {
                        el2[i].style.margin = "";
                    }
                    var cur_pos = window.scrollY;
                    if (cur_pos < 100) {
                        var el = document.querySelectorAll('.el');
                        var index = 0, length = el.length;
                        for ( ; index < length; index++) {
                            el[index].style.position = "unset";
                            el[index].style.top = "unset";
                            el[index].style.width = "";
                            el[index].style.margin = "0px";
                        }     
                    } 
                } else {
                    // public
                    var el = document.querySelectorAll('.el');                        
                    var index = 0, length = el.length;
                    for ( ; index < length; index++) {
                        el[index].style.position = "fixed";
                        el[index].style.top = "85px";
                        el[index].style.display = "block";
                    }   
                    var cur_pos = window.scrollY;
                    if (cur_pos < 100) {
                        var el = document.querySelectorAll('.el');
                        var index = 0, length = el.length;
                        for ( ; index < length; index++) {
                            el[index].style.position = "unset";
                            el[index].style.top = "unset";
                        }     
                    }           
                }
                //greater than 768
            }
            else {
                //less than 768
                if(this.loginuser == 'true') {
                    var el = document.querySelectorAll('.el');
                    var el2 = document.querySelectorAll('.el2');
                    var index = 0, length = el.length;
                    for ( ; index < length; index++) {
                        el[index].style.width = "";
                        el[index].style.position = "fixed";
                        el[index].style.top = "60px";
                        el[index].style.display = "inline-flex";
                        el[index].style.margin = "0px";
                    }
                    if(this.window.width > 436 && this.window.width <= 1024){
                        for (let i = 0; i < el2.length; i++) {
                        el2[i].style.display = "flow-root list-item";
                        el[index].style.top = "40px";
                        } 
                    }else{
                        for (let i = 0; i < el2.length; i++) {
                        el2[i].style.display = "inline-flex";
                        } 
                    }                          
                    var cur_pos = window.scrollY;
                    if (cur_pos < 100) {
                        var el = document.querySelectorAll('.el');
                        var index = 0, length = el.length;
                        for ( ; index < length; index++) {
                            el[index].style.position = "unset";
                            el[index].style.top = "unset";
                            el[index].style.display = "none";
                        }     
                    }                
                } else {
                    var el = document.querySelectorAll('.el');
                    var el2 = document.querySelectorAll('.el2');
                    var index = 0, length = el.length;
                    for ( ; index < length; index++) {                           
                        el[index].style.position = "fixed";
                        el[index].style.top = "42px";
                        el[index].style.display = "inline-flex";
                    }   
                    var cur_pos = window.scrollY;
                    if(this.window.width > 436 && this.window.width <= 1024){
                        for (let i = 0; i < el2.length; i++) {
                        el2[i].style.display = "flow-root list-item";
                        el[index].style.top = "40px";
                        } 
                    }else{
                        for (let i = 0; i < el2.length; i++) {
                        el2[i].style.display = "inline-flex";
                        } 
                    } 
                    if (cur_pos <= 100) {
                        var el = document.querySelectorAll('.el');
                        var index = 0, length = el.length;
                        for ( ; index < length; index++) {
                            el[index].style.position = "unset";
                            el[index].style.display = "none";
                            el[index].style.top = "unset";
                        }     
                    }                 
                }
                //end less than 768
            }        
        },
        next() {
            this.$refs.slick.next();
        },
        prev() {
            this.$refs.slick.prev();
        },
        reInit() {
            // Helpful if you have to deal with v-for to update dynamic lists
            this.$nextTick(() => {
                this.$refs.slick.reSlick();
            });
        },
        handleResize() {
            this.window.width = window.innerWidth;
            this.window.height = window.innerHeight;
        },
        showLightbox: function(imageName) {
            this.$refs.lightbox.show(imageName);
        },
        moveCarousel(direction) {
            // Find a more elegant way to express the :style. consider using props to make it truly generic
            if (direction === 1 && !this.atEndOfList) {
                this.panocurrentOffset -= this.paginationFactor;
            } else if (direction === -1 && !this.atHeadOfList) {
                this.panocurrentOffset += this.paginationFactor;
            }
        },
        activatePanoImage(imageIndex) {
            this.activePanoImage = imageIndex;
        },
        moveTo: function(index) {
            this.$refs.fullpage.$fullpage.moveTo(index, true);
        },
        nextImage() {
            var active = this.activeImage + 1;
            if(active >= this.images.length) {
                active = 0;
            }
            this.activateImage(active);
        },
        prevImage() {
            var active = this.activeImage - 1;
            if(active < 0) {
                active = this.images.length - 1;
            }
            this.activateImage(active);
        },
        activateImage(imageIndex) {
            this.activeImage = imageIndex;
            this.activeImageTitle = this.images[imageIndex].title;
            this.activeImageDescription = this.images[imageIndex].description;
        },
        activate:function(el){
        },
        costConfirm(id,inx){
            $('.changeLink').text("詳細はこちら");
            $('.changeLink').removeClass("CloseBtn");
            $('.changeLink'+id).text("選択中");
            $('.changeLink'+id).addClass("CloseBtn");
            $('.closeChangeLink').hide('medium');
            $('#changeLink'+id).show('medium');
            $('.closeLink').css({'display':'none'});
            $('.closeLink'+id).css({'display':'inline'});
            $('.main-cost-table td').css({'background':'transparent'});
            $('.cost'+inx+' td').css({'background':'#ecf8ff'});
        },
        costConfirmMini(id){
            $('#changeLinkMini'+id).toggle('medium');
        },
        closeDetail(id,inx) {
            $('.changeLink').text("詳細はこちら");
            $('.changeLink').removeClass("CloseBtn");
            $('.closeLink'+id).css({'display':'none'});
            $('.closeChangeLink').hide('medium');    
            $('.main-cost-table td').css({'background':'transparent'});
            $('.cost'+inx+' td').css({'background':'transparent'});    
        },
        documentPost() {
            localStorage.removeItem("item");
            this.fav_email = [];
            this.fav_email.push({
                'id': this.pro_id,
                'email': this.nus_pro[0]['email'],
                'name': this.nus_pro[0]['name'],
            });
            var document_status=[];
            document_status[this.pro_id] = true;
            localStorage.setItem("document", JSON.stringify(document_status));
            localStorage.setItem("item", JSON.stringify(this.fav_email));
            let routeData = this.$router.resolve({name: 'nursingFavouriteMail',});
            window.open(routeData.href, '_blank');
        },
        imgUrlAlt(event) {
            event.target.src = "/images/noimage.jpg"
        },
        imgUrlAlthide(index) {
            this['gallery-img-'+index] = null;
        },
        first() {
            this.currentPage = 0;
        },
        last() {
            this.currentPage = this.pages - 1;
        },
        prev() {
            if (0 < this.currentPage) {
                this.currentPage--;
            }
        },
        next() {
            if (this.currentPage < this.pages - 1) {
                this.currentPage++;
            }
        },
        pageSelect(index) {
            if(0 < this.currentPage) {
                this.currentPage = index - 1;
            }
            else {
                this.currentPage++;
            }
        },
        favAddFun(status) {
            if(this.type == 'nursing'){
                var locReplace = "nursing_fav";
                var varReplace = "#nus-fav-local";
                var linkBox = ".fav-nursing-link-box>a";
            }
            else {
                var locReplace = "hospital_fav";
                var varReplace = "#hos-fav-local";
                var linkBox = ".fav-hospital-link-box>a";
            }
            if(status == 'add') {
                if(localStorage.getItem(locReplace)){
                    var fav_arr = JSON.parse("[" + localStorage.getItem(locReplace) + "]");
                    fav_arr.push(this.pro_id);
                    fav_arr = [...new Set(fav_arr)];
                    localStorage.setItem(locReplace, fav_arr);
                    if(this.type == 'nursing'){
                        this.nusFav = fav_arr.length;
                    }
                    else{
                        this.hosFav = fav_arr.length;
                    }
                }
                else{
                    var fav_arr = [this.pro_id];
                    localStorage.setItem(locReplace, fav_arr);
                    if(this.type == 'nursing'){
                        this.nusFav = fav_arr.length;
                    }
                    else{
                        this.hosFav = fav_arr.length;
                    }
                }
                $(linkBox).css({'cursor':'pointer','pointer-events':'auto'});
            }
            else{
                var fav_arr = JSON.parse("[" + localStorage.getItem(locReplace) + "]");
                var index = fav_arr.indexOf(this.pro_id);
                if (index > -1) {
                    fav_arr.splice(index, 1);
                    localStorage.setItem(locReplace, fav_arr);
                }
                if(this.type == 'nursing'){
                    this.nusFav = fav_arr.length;
                }
                else{
                    this.hosFav = fav_arr.length;
                }
                if(fav_arr.length == 0){
                    $(linkBox).css({'cursor':'not-allowed','pointer-events':'none'})
                }
                else{
                    $(linkBox).css({'cursor':'pointer','pointer-events':'auto'})
                }
            }
        },
    }
}
</script>

<style scoped>
.res-title{
    height: 35px;
    overflow: hidden;
    padding: 0px 5px;
}
.res-descr{
    height: 70px;
    overflow: hidden;
    padding: 0px 5px;
}
.slick-list .draggable{
    min-height: 200px !important;
}
#profilePublish > div.footer {
    padding-bottom: 13%;
}
.active > h3{
    border: 2px solid #3498db;
}
h2{
    background: #f0f0f0;
    padding: 5px;
}
h3 {
	background: #f0f0f0;
    color: #3498db;
    font-size: 2.25rem;
    margin: .1rem;
    position: relative;
    text-align: left;   
    overflow: hidden;
    margin-bottom: 0px;
    width: 44px!important;
    max-width: 44px!important;
    height: 33px!important;
}
h3 img{
    height: 33px;
}
.res-pano{
    background: #eee;
}
.see-pano{
    border-top: 1px dashed #907b7b;
    padding: 0px 10px;
    box-shadow: 0 4px 5px rgba(0, 0, 0, 0.12);
}
.see-pano li{
    list-style: none;
}
/*end test*/
/*slider*/
#pano-slider-page .card-carousel {
    display: flex;
    justify-content: left;
    width: 1033px !important;
    overflow: hidden;
}
/*slick carousel*/
#pano-slider-page .card-carousel-wrapper {
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 20px 0 40px;
    color: #666a73;
}
#pano-slider-page .card-carousel-comment {
    display: flex;
    justify-content: center;
}
#pano-slider-page .card-carousel-comment .card {
    margin: 0px 10px 0px 0px;
}
#pano-slider-page .card-carousel--overflow-container {
    color: #000;
    text-align: left;
    overflow: hidden;
}
#pano-slider-page .card-carousel--nav__left,
#pano-slider-page .card-carousel--nav__right {
    display: inline-block;
    width: 15px;
    height: 15px;
    padding: 5px;
    box-sizing: border-box;
     border-top: 5px solid #3498db;
    border-right: 5px solid #3498db;
    cursor: pointer;
    margin: 10px;
    transition: transform 150ms linear;
}
#pano-slider-page .card-carousel--nav__left[disabled],
#pano-slider-page .card-carousel--nav__right[disabled] {
    opacity: 0.2;
    border-color: black;
}
.nav-box[disabled] {
    opacity: 0.2;
}
#pano-slider-page .nav-box[disabled] .card-carousel--nav__left,
#pano-slider-page .nav-box[disabled] .card-carousel--nav__right {
    border-top: 5px solid #000;
    border-right: 5px solid #000;
}
#pano-slider-page .nav-box[disabled] .nav-content {
    border: 2px solid #000;
    background: #fff
}
.nav-content {
    width: 40px;
    height: 40px;
    line-height: 35px;
    vertical-align: middle;
    background: #fffff4;
    border: 2px solid #3498db;
    border-radius: 50%;
    text-align: center;
}
#pano-slider-page .card-carousel--nav__left {
    transform: rotate(-135deg);
}
#pano-slider-page .card-carousel--nav__left:active {
    transform: rotate(-135deg) scale(0.9);
}
#pano-slider-page .card-carousel--nav__right {
    transform: rotate(45deg);
}
#pano-slider-page .card-carousel--nav__right:active {
    transform: rotate(45deg) scale(0.9);
}
#pano-slider-page .card-carousel-cards {
    display: flex;
    transition: transform 150ms ease-out;
    transform: translatex(0px);
}
#pano-slider-page .card-carousel-cards .card-carousel--card {
    margin: 0 10px;
    cursor: pointer;
    background-color: #fff;
    border-radius: 4px;
    z-index: 3;
    margin-bottom: 2px;
}
#pano-slider-page .card-carousel-cards .card-carousel--card:first-child {
    margin-left: 0;
}
#pano-slider-page .card-carousel-cards .card-carousel--card:last-child {
    margin-right: 0;
}
#pano-slider-page .card-carousel-cards .card-carousel--card img {
    vertical-align: bottom;
    border-top-left-radius: 4px;
    border-top-right-radius: 4px;
    transition: opacity 150ms linear;
    user-select: none;
}
#pano-slider-page .card-carousel-cards .card-carousel--card img:hover {
    opacity: 0.5;
}
.pannellum{
    height: 500px;
}
.cost_tb{
    border-left: 0px;
    border-bottom: 0px;
    padding-bottom: 1px;
}
.cost_table{
    width: 100%;
    float: left;
    border-bottom: 1px solid #ccc;
}
.cost_heading_lbl{
    border-left: 5px solid #2980b9;
    padding: 0 5px;
    font-weight: bold;
    font-size: 1.14em;
}
.cost_heading_lbl_respon{
    border-left: 5px solid #2980b9;
    padding: 0 5px;
    font-weight: bold;
    font-size: 0.9rem;
}
.cost_heading_lbl_mini{
    line-height: 1;
    font-weight: bold;
    font-size: 1.2em;
}
.cost_heading_lbl_mini_res{
    line-height: 1;
    font-weight: bold;
    font-size: 0.8rem;
}
.cost_heading_lbl_mini i{
    border-radius: 3px;   
    color: #3498db;
    font-size: 1em;
}
.cost_table th{
    border: 1px solid #ccc;
    padding: 8px 10px;
    background: #f0f0f0;
    color: #000;
    line-height: 1.7;
    vertical-align: top;
    min-width: 100px;
}
.cost_table td{
    padding: 8px 10px;
    line-height: 1.7;
    background: #fff;
}
.main-cost-table td{
    padding: 10px !important;
    vertical-align: middle;
}
.cost_btnwrapper{
    float: right;
    width: 158px;
    text-align: center;
    align-self: center;
}
.aa th:last-child, .aa td:last-child {
    width: 108px;
    font-size: 88.2%;
    white-space: nowrap;
}
.comment-wrapper{
    background-color: #fff;
    padding: 5px;
}
.comment-title{
    background-size: 29px;
    color: #2980b9;
    display: block;
    font-size: 16px;
    font-weight: 700;
    padding-bottom: 10px;
}
.card-text{
    color: #777;
}
.comment-ico {
    margin: 0 0 10px 0;
}
.comment-ico a {
    display: inline-block;
    float: right;
    font-size: 13px;
    color: #111;
    border: 1px solid #111;
    padding: 5px 20px;
    border-radius: 20px;
}
.comment-ico i {
    display: block;
    float: left;
    margin: 3px 5px 0 0;
    font-size: 15px;
}
.comment-ico a:hover {
    text-decoration: none;
    border: 1px solid #ff9563;
    color: #ff9563;
}
.comment-age {
    margin: 0 20px;
    font-weight: bold;
}
.comment-date {
    margin-left: auto;
    font-size: 12px;
    color: #777;
}
.thumbnail-img{
    width: 100%;
    padding: 20px;
    vertical-align: middle;
    border: 1px solid #b7dad2;
    border-bottom: 1px solid #b7dad2;
    background-color: #f5f5f2;
    margin: 0 auto 20px;
    text-align: center;
}
.thumbnail-img img {
    width: 100%;
}
.card-carousel {
    user-select: none;
    position: relative;
}
.photocard-carousel-wrapper{
    height: 300px;
    min-height: 300px;
    max-height: 300px;
    overflow: hidden;
}
.photocard-title{
    height: 79px;
    overflow: hidden;
}
.progressbar {
    display: block;
    width: 100%;
    height: 5px;
    position: absolute;
    background-color: rgba(221, 221, 221, 0.25);
    z-index: 1;
}
.progressbar > div {
    background-color: rgba(255, 255, 255, 0.52);
    height: 100%;
}
.thumbnails {
    text-align: left;
}
.thumbnail-image {
    display: inline-block;
    cursor: pointer;
    margin-bottom: -1px;
}
.thumbnails-pano{
    display: flex;
    text-align: left;
}
.thumbnail-image-panorama {
    display: inline-block;
    cursor: pointer;
    margin-bottom: -1px;
}
.thumbnail-image > img {
    vertical-align: bottom;
    width: 51px;
    height: 36px;
    max-width: 55px;
    border: 3px solid transparent;
}
.thumbnail-image-panorama >img{
    vertical-align: bottom;
    width: 103px;
    height: 70px;
    max-width: 103px;
    border: 3px solid transparent;
}
.thumbnail-image:hover > img,
.thumbnail-image.active > img {
    opacity: 0.6;
    box-shadow: 2px 2px 6px 1px rgba(0,0,0, 0.5);
}
.card-img {
    position: relative;
    margin-bottom: 10px;
}
.card-img > img {
    display: block;
    margin: 0 auto;
    width: 100%;
    height: 290px;
}
.actions {
    font-size: 1.5em;
    height: 40px;
    position: absolute;
    top: 50%;
    margin-top: -20px;
    width: 100%;
    display: flex;
    align-items: center;
    justify-content: space-between;
    color: #585858;
}
.actions > span {
    cursor: pointer;
    transition: all 250ms;
}
.actions > span.prev {
    margin-left: 5px;
}
.actions > span.next {
    margin-right: 5px;
}
.actions > span:hover {
    color: #eee;
}
.changeLink {
    color: #000;
    font-weight: bold;
    cursor: pointer;
    border:1px solid #2981cc;
    padding: 5px;
    border-radius: 5px;
    background-color: #ecf8ff;
}
.changeLink:hover {
    color: #2981cc;
    border: 1px solid #2981cc;
}
.closeLink {
    color: #fff;
    font-weight: bold;
    cursor: pointer;    
    padding: 5px;
    border-radius: 5px;
    border: 1px solid #97cae8;  
    background-color: #2980b9;
}
.hideCloseBtn {
    display: none;
}
.payment-footer{
    display: inline-block;
    width: 100%;    
}
.payment-footer .changeLink{
    padding: 8px 5px;
    border: 0px;
    border-radius: 0;
    border-top: 1px solid #cbe1f5;
    border-bottom: 1px solid #eeeeee;   
    background: linear-gradient(to bottom,#c0e5fd 0,#8ebeda 100%);
}
.CloseBtn {
    border: none !important;
    color: #2c3e50 !important;
    cursor: not-allowed!important;
    pointer-events: none;
    background: none !important;
}
.miniChangeLink {
    padding: 0px;
    height: 100vh;
}
.payment-footer .miniChangeLink {
    padding: 10px;
}
.room-type {
    background: #93c2e0;
    color: #333333;
    padding: 3px 5px 3px 7px;
    border-radius: 3px;
    margin-right: 7px;
    font-weight: bold;
}
.method-name {
    font-weight: bold;
    font-size: 1em;
    margin-bottom: 10px;
}
.method-name-respon {
    font-weight: bold;
    font-size: 0.8em;
}
.cash-lbl-mini {
    font-size: 1.4em !important;
    color: #fd0e0e;
    font-weight: bold;
}
.cash-lbl-respon {
    font-size: 1.1em !important;
    color: #fd0e0e;
    font-weight: bold;
}
.detail-btn {
    display: flex;
    justify-content: center;
}
.cash-unit {
    color: #333;
    font-size: 0.8em;
}
.top-mail-btn {
    position: absolute;
    right: 175px;
    top: -12px;
    cursor: pointer;
    background-color: #0cc72c !important;
    color: #fff;
    width: 160px;
    padding: 6px;
    border-radius: 5px;
    text-align: center;
    text-decoration: none;
    -webkit-box-shadow: 3px 5px 3px #ccc!important;
    box-shadow: 3px 5px 3px #ccc!important;
    font-size: 14.4px;
    border: 1px solid #53c000;
    z-index: 4;
}
.phone-color {
    width: 40px;
    height: 38px;
    margin-right: 5px;
    font-size: 21px;
    color: #c91616;
    text-align: center;
    line-height: 35px;
    background: #ccc;
    border-radius: 50%;
    vertical-align: text-bottom;
    position: relative;
    bottom: 5px;
}
.nocomment-phone{
    font-size: 30px;
    position: relative;
    top: 17px;
    line-height: 62px;
    color: #883914;
    font-weight: bold;
}
.fz12{
    font-size: 17px;
    position: relative;
    bottom: 4px;
}
.dotted{
    border-top: 1px dotted #883914;
    width: 60%;
    height: 1px;
    margin-bottom:30px;
}
.no-comment-web {
    font-size: 30px;
    line-height: 62px;
    color: #883914;
    font-weight: bold;
}
.no-data-size{
    font-size: 25px;
    text-align: center;
}
.payment-body p {
    font-size: 18px;
    color: #fd0e0e;
    font-weight: bold;
}
.payment-body p span {
    display: inline-block;
    padding: 0px 5px;
    margin-right: 3px;
    font-size: 14px;
    color: #333333;
    background: #93c2e0;
    border: 1px solid #93c2e0;
    border-radius: 5px;
}
 .circle_t{
    border: 7px solid #346e90 ;
    width: 0%;
    border-radius: 62%;
    margin: 0 auto;
    text-align: center;
}
@media only screen and (max-width: 375px) and (min-width: 320px) {
    #pano-slider-page .card-carousel {
        width: 200px!important;
    }
    .thumbnails-pano
    {
        width: 827px;
    }
    #pano-slider-page{
        margin-left: 3px;
    }
    .nav-content
    {
       margin-right: 16px;
    }
}
@media only screen and (max-width:750px) {
    .comment-age {
        margin: 0px;
    }
    .cost_table th{
        border: none !important;
    }
    table.timeTable tr > * {
        display: block;
    }
    table.timeTable tr {
        display: table-cell;
        vertical-align: top;
    }
    .first-row{
        border: none;
        padding: 0px;
    }
    table.timeTable th, table.timeTable td{
        width: 100% !important;
    }
    tr.first-row th{
        width: auto !important;
    }
    tr.last th{
        width: auto !important;
    }
}
@media only screen and (max-width: 450px) and (min-width: 320px) {
    .comment-age {
        margin-top: 24px;    
        float: left !important;
        position: absolute;
    }
    .comment-date{
        font-size: 12px;
        float: left !important;
        position: absolute;
    }
    .m-t-comment
    {
        margin-top: 34px;
    }   
}

@media only screen and (max-width: 450px) and (min-width: 376px) {
    #pano-slider-page .card-carousel {
        width: 207px !important;
    }
     .thumbnails-pano
    {
    width: 827px;
    }
    #pano-slider-page{
        margin-left: -17px;
    }
    .nav-content
    {
       margin-right: -35px;
    }
}

@media only screen and (max-width: 768px) and (min-width: 451px) {
    #pano-slider-page .card-carousel {
        width: 415px!important;
    }
    .changeLink {
        font-size: 10px;
    }
}

@media only screen and (max-width: 992px) and (min-width: 769px) {
    #pano-slider-page .card-carousel {
        width: 720px!important;
    }
    .thumbnails-pano
    {
    width: 827px;
    }
    #pano-slider-page{
        margin-left: 15px;
    }
    .nav-content
    {
       margin-right: 30px;
    }
    .changeLink {
        font-size: 10px;
    }
}
/* Large devices (laptops/desktops, 992px and up) */
@media only screen and (max-width: 1024px) and (min-width: 993px) {
    #pano-slider-page .card-carousel {
        width: 823px!important;
    }
}
@media only screen and (max-width: 1200px) and (min-width: 1025px) {
    #pano-slider-page .card-carousel {
        width: 930px!important;
    }
}

/* Extra large devices (large laptops and desktops, 1200px and up) */
@media only screen and (max-width: 1440px) and (min-width: 1201px) {
    #pano-slider-page .card-carousel {
        width: 930px!important;
    }
    .thumbnails-pano
    {
        width: 1000px;
    }
}

@media only screen and (max-width: 1880px) and (min-width: 1440px) {
    #pano-slider-page .card-carousel {
        width: 1033px!important;
    }
    .thumbnails-pano
    {
        width: 1022px;
    }
    #pano-slider-page{
        margin-left: 15px;
    }
}
.hideimg{
    display: none!important;
}
</style>

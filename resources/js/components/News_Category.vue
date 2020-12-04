<template>
<layout>   
<div class="category_margin">    
    <div class="row col-md-12 m-lr-0 p-0" v-if="!latest_post_null" style="display: none;">
        <div class="col-sm-12 pad-new col-lg-8 m-b-15 newssearch-width">
            <!--search input-->
            <div class="search-input">
                <span class="btn btn col-md-12 my-sm-0 danger-bg-color btn-danger cross-btn" v-if="status == 1" @click="clearSearch()">X</span>
                <input type="text" class="searchNews" placeholder="ニュース検索" id="search-free-word" v-bind:value="search_word">
                <button type="submit" class="searchButtonNews" @click="searchCategory()">
                    <i class="fas fa-search"></i> 検索
                </button>
            </div>                                    
        </div>
    </div>
    <div class="col-12">
        <h4 class="profile-tit">{{cat_name}}
        </h4>
    </div>       
    <div v-if="norecord_msg">
        <div class="container-fuid no_search_data">
            <p class="nosearch-icon">
                <svg x="0px" y="0px" width="30" height="30" viewBox="0 0 172 172" style=" fill:red;"><g transform=""><g fill="none" fill-rule="nonzero" stroke="none" stroke-width="1" stroke-linecap="butt" stroke-linejoin="miter" stroke-miterlimit="10" stroke-dasharray="" stroke-dashoffset="0" font-family="none" font-weight="none" font-size="none" text-anchor="none" style="mix-blend-mode: normal"><path d="M0,172v-172h172v172z" fill="none"></path><path d="M86,172c-47.49649,0 -86,-38.50351 -86,-86v0c0,-47.49649 38.50351,-86 86,-86v0c47.49649,0 86,38.50351 86,86v0c0,47.49649 -38.50351,86 -86,86z" fill="none"></path><path d="M86,168.56c-45.59663,0 -82.56,-36.96337 -82.56,-82.56v0c0,-45.59663 36.96337,-82.56 82.56,-82.56v0c45.59663,0 82.56,36.96337 82.56,82.56v0c0,45.59663 -36.96337,82.56 -82.56,82.56z" fill="none"></path><path d="M0,172v-172h172v172z" fill="none"></path><path d="M3.44,168.56v-165.12h165.12v165.12z" fill="none"></path><path d="M86,172c-47.49649,0 -86,-38.50351 -86,-86v0c0,-47.49649 38.50351,-86 86,-86v0c47.49649,0 86,38.50351 86,86v0c0,47.49649 -38.50351,86 -86,86z" fill="none"></path><path d="M86,168.56c-45.59663,0 -82.56,-36.96337 -82.56,-82.56v0c0,-45.59663 36.96337,-82.56 82.56,-82.56v0c45.59663,0 82.56,36.96337 82.56,82.56v0c0,45.59663 -36.96337,82.56 -82.56,82.56z" fill="none"></path><path d="M0,172v-172h172v172z" fill="none"></path><path d="M3.44,168.56v-165.12h165.12v165.12z" fill="none"></path><path d="M86,172c-47.49649,0 -86,-38.50351 -86,-86v0c0,-47.49649 38.50351,-86 86,-86v0c47.49649,0 86,38.50351 86,86v0c0,47.49649 -38.50351,86 -86,86z" fill="none"></path><path d="M86,168.56c-45.59663,0 -82.56,-36.96337 -82.56,-82.56v0c0,-45.59663 36.96337,-82.56 82.56,-82.56v0c45.59663,0 82.56,36.96337 82.56,82.56v0c0,45.59663 -36.96337,82.56 -82.56,82.56z" fill="none"></path><g fill="#666666"><path d="M74.53333,17.2c-31.59643,0 -57.33333,25.73692 -57.33333,57.33333c0,31.59641 25.7369,57.33333 57.33333,57.33333c13.73998,0 26.35834,-4.87915 36.24766,-12.97839l34.23203,34.23203c1.43802,1.49778 3.5734,2.10113 5.5826,1.57735c2.0092,-0.52378 3.57826,-2.09284 4.10204,-4.10204c0.52378,-2.0092 -0.07957,-4.14458 -1.57735,-5.5826l-34.23203,-34.23203c8.09923,-9.88932 12.97839,-22.50768 12.97839,-36.24766c0,-31.59641 -25.7369,-57.33333 -57.33333,-57.33333zM74.53333,28.66667c25.39939,0 45.86667,20.46729 45.86667,45.86667c0,25.39937 -20.46728,45.86667 -45.86667,45.86667c-25.39939,0 -45.86667,-20.46729 -45.86667,-45.86667c0,-25.39937 20.46728,-45.86667 45.86667,-45.86667zM91.67734,51.52161c-1.51229,0.03575 -2.94918,0.66766 -3.99765,1.75807l-13.14636,13.14636l-13.14636,-13.14636c-1.07942,-1.10959 -2.56162,-1.73559 -4.10963,-1.73568c-2.33303,0.00061 -4.43306,1.41473 -5.31096,3.57628c-0.8779,2.16155 -0.3586,4.6395 1.31331,6.26669l13.14636,13.14636l-13.14636,13.14636c-1.49777,1.43802 -2.10111,3.5734 -1.57733,5.58259c0.52378,2.0092 2.09283,3.57825 4.10203,4.10203c2.0092,0.52378 4.14457,-0.07956 5.58259,-1.57733l13.14636,-13.14636l13.14636,13.14636c1.43802,1.49778 3.5734,2.10113 5.5826,1.57735c2.0092,-0.52378 3.57826,-2.09284 4.10204,-4.10204c0.52378,-2.0092 -0.07957,-4.14458 -1.57735,-5.5826l-13.14636,-13.14636l13.14636,-13.14636c1.70419,-1.63875 2.22781,-4.1555 1.31865,-6.33798c-0.90916,-2.18248 -3.06468,-3.58317 -5.42829,-3.52739z"></path></g></g></g></svg>
            </p>
            <p class="nosearch-data">お探しの条件に合うニュースは見つかりませんでした。</p>
             <!-- <p class="nosearch"> 申し訳ありませんが、検索結果がありませんでした。</p> -->
        </div>
    </div>
    <!-- news layout design change (@author:pzo) -->
    <div v-else-if="block && w_width > 480" class="head-news" >  
        <div v-for="(group,index) in news" :key="index" class="slick-news row m-lr-0" :class="'bordertop-color'+(5-(Math.floor(cat_id%5)))">
                
            <slick :options="slickOptions" class="news-slider-width" v-if="index === 0" >             
                <div class="pad-new pattern-child group-0">

                    <div class="large" v-for="(value,index) in group[0]" :key="index" >
                        <div class="large-b0 m-b-5" v-if="index === 0">
                            <router-link :to="'/newsdetails/'+value.id" >
                                <div class="col-12 single-news-box">

                                    <clazy-load class="wrapper-3" @load="log" src="/images/noimage.jpg" :key="index" >

                                        <transition name="fade">

                                            <img v-bind:src="'/upload/news/' + value.photo" class="fit-image-0" @error="imgUrlAlt">

                                        </transition>                                

                                        <transition name="fade" slot="placeholder">

                                            <div class="preloader">

                                                <div class="circle">

                                                <div class="circle-inner"></div>

                                                </div>

                                            </div>

                                        </transition>
                                    </clazy-load>
                                    <p>  {{value.main_point}} </p>
                                </div>
                            </router-link>
                        </div>
                    </div>
                    <div class="small" v-for="(value,index) in group[2]" :key="index">
                        <div class="small-b0" v-if="index === 0">
                            <router-link  :to="'/newsdetails/'+value.id" style="color:#333;">  
                            <p class="text-truncate news-list-display">

                                <i class="fas fa-building"></i> {{value.main_point}}
                            </p>
                            </router-link>
                        </div>
                    </div>
                </div>

                <div class="pad-new pattern-child group-1"   >
     
                    <div class="medium-b1" v-for="(value,index) in group[1]" :key="index" >
                        <router-link :to="'/newsdetails/'+value.id" v-if="index === 0"> 
                            <div class="col-12 row m-b-5 adslist-card m-lr-0 news-3-card">

                                <div class="col-4 img-box">

                                    <clazy-load class="wrapper-4" @load="log" src="/images/noimage.jpg" :key="inx" >
                                        <transition name="fade">

                                            <img v-bind:src="'/upload/news/' + value.photo" class="fit-image-0" @error="imgUrlAlt">

                                        </transition>

                                        <transition name="fade" slot="placeholder">

                                            <div class="preloader">

                                                <div class="circle">

                                                <div class="circle-inner"></div>

                                                </div>

                                            </div>

                                        </transition>
                                    </clazy-load>

                                </div>
                                <div class="col-8 pattern-txt-box">
                                  

                                    <p>{{value.main_point}}</p>

                                </div>

                            </div>
                        </router-link>
                    </div>
                    <div class="small" v-for="(value,index) in group[2]" :key="index">
                        <div class="small-b1"  v-if="index === 1">
                            <router-link  :to="'/newsdetails/'+value.id" style="color:#333;">  
                            <p class="text-truncate news-list-display">

                                <i class="fas fa-building"></i> {{value.main_point}}
                            </p>
                            </router-link>
                        </div>
                        <div class="small-b1"  v-if="index === 2">
                            <router-link  :to="'/newsdetails/'+value.id" style="color:#333;">  
                            <p class="text-truncate news-list-display">

                                <i class="fas fa-building"></i> {{value.main_point}}
                            </p>
                            </router-link>
                        </div>
                        <div class="small-b1"  v-if="index === 3">
                            <router-link  :to="'/newsdetails/'+value.id" style="color:#333;">  
                            <p class="text-truncate news-list-display">

                                <i class="fas fa-building"></i> {{value.main_point}}
                            </p>
                            </router-link>
                        </div>
                        <div class="small-b1"  v-if="index === 4">
                            <router-link  :to="'/newsdetails/'+value.id" style="color:#333;">  
                            <p class="text-truncate news-list-display">

                                <i class="fas fa-building"></i> {{value.main_point}}
                            </p>
                            </router-link>
                        </div>
                        <div class="small-b1"  v-if="index === 5">
                            <router-link  :to="'/newsdetails/'+value.id" style="color:#333;">  
                            <p class="text-truncate news-list-display">

                                <i class="fas fa-building"></i> {{value.main_point}}
                            </p>
                            </router-link>
                        </div>
                        <div class="small-b1"  v-if="index === 6">
                            <router-link  :to="'/newsdetails/'+value.id" style="color:#333;">  
                            <p class="text-truncate news-list-display">

                                <i class="fas fa-building"></i> {{value.main_point}}
                            </p>
                            </router-link>
                        </div>
                        <div class="small-b1"  v-if="index === 7">
                            <router-link  :to="'/newsdetails/'+value.id" style="color:#333;">  
                            <p class="text-truncate news-list-display">

                                <i class="fas fa-building"></i> {{value.main_point}}
                            </p>
                            </router-link>
                        </div>
                    </div>                                
                </div>

                <div class="pad-new pattern-child group-2"  >
                    <div class="large"  v-for="(value,index) in group[0]" :key="index">
                        <div class="large-b0 m-b-5" v-if="index === 1">
                            <router-link :to="'/newsdetails/'+value.id" >
                                <div class="col-12 single-news-box">

                                    <clazy-load class="wrapper-3" @load="log" src="/images/noimage.jpg" :key="index" >

                                        <transition name="fade">

                                            <img v-bind:src="'/upload/news/' + value.photo" class="fit-image-0" @error="imgUrlAlt">

                                        </transition>                                

                                        <transition name="fade" slot="placeholder">

                                            <div class="preloader">

                                                <div class="circle">

                                                <div class="circle-inner"></div>

                                                </div>

                                            </div>

                                        </transition>
                                    </clazy-load>
                                    <p>  {{value.main_point}} </p>
                                </div>
                            </router-link>
                        </div>
                    </div>       
                    <div class="small" v-for="(value,index) in group[2]" :key="index">        
                        <div class="small-b2" v-if="index === 8">
                            <router-link  :to="'/newsdetails/'+value.id" style="color:#333;">  
                            <p class="text-truncate news-list-display">

                                <i class="fas fa-building"></i> {{value.main_point}}
                            </p>
                            </router-link>
                        </div>
                    </div> 
                </div>

                <div class="pad-new pattern-child group-3"  >    
                     
                    <div class="medium" v-for="(value,index) in group[1]" :key="index" >
                        <div class="medium-b3" v-if="index === 1">
                            <router-link :to="'/newsdetails/'+value.id"> 
                            <div class="col-12 row m-b-5 adslist-card m-lr-0 news-3-card">

                                <div class="col-4 img-box">

                                    <clazy-load class="wrapper-4" @load="log" src="/images/noimage.jpg" :key="inx" >
                                        <transition name="fade">

                                            <img v-bind:src="'/upload/news/' + value.photo" class="fit-image-0" @error="imgUrlAlt">

                                        </transition>

                                        <transition name="fade" slot="placeholder">

                                            <div class="preloader">

                                                <div class="circle">

                                                <div class="circle-inner"></div>

                                                </div>

                                            </div>

                                        </transition>
                                    </clazy-load>

                                </div>
                                <div class="col-8 pattern-txt-box">
                                  

                                    <p>{{value.main_point}}</p>

                                </div>

                            </div>
                            </router-link>
                        </div>
                        <div class="medium-b3" v-if="index === 2">
                            <router-link :to="'/newsdetails/'+value.id"> 
                            <div class="col-12 row m-b-5 adslist-card m-lr-0 news-3-card">

                                <div class="col-4 img-box">

                                    <clazy-load class="wrapper-4" @load="log" src="/images/noimage.jpg" :key="inx" >
                                        <transition name="fade">

                                            <img v-bind:src="'/upload/news/' + value.photo" class="fit-image-0" @error="imgUrlAlt">

                                        </transition>

                                        <transition name="fade" slot="placeholder">

                                            <div class="preloader">

                                                <div class="circle">

                                                <div class="circle-inner"></div>

                                                </div>

                                            </div>

                                        </transition>
                                    </clazy-load>

                                </div>
                                <div class="col-8 pattern-txt-box">
                                  

                                    <p>{{value.main_point}}</p>

                                </div>

                            </div>
                            </router-link>
                        </div>
                    </div>
                    <div class="small" v-for="(value,index) in group[2]" :key="index" >                  
                        <div class="small-b3"  v-if="index === 9">
                            <router-link  :to="'/newsdetails/'+value.id" style="color:#333;">  
                            <p class="text-truncate news-list-display news-list-display03">

                                <i class="fas fa-building"></i> {{value.main_point}}
                            </p>
                            </router-link>
                        </div>
                        <div class="small-b3"  v-if="index === 10">
                            <router-link  :to="'/newsdetails/'+value.id" style="color:#333;">  
                            <p class="text-truncate news-list-display news-list-display03">

                                <i class="fas fa-building"></i> {{value.main_point}}
                            </p>
                            </router-link>
                        </div>
                        <div class="small-b3"  v-if="index === 11">
                            <router-link  :to="'/newsdetails/'+value.id" style="color:#333;">  
                            <p class="text-truncate news-list-display news-list-display03">

                                <i class="fas fa-building"></i> {{value.main_point}}
                            </p>
                            </router-link>
                        </div>
                        <div class="small-b3"  v-if="index === 12">
                            <router-link  :to="'/newsdetails/'+value.id" style="color:#333;">  
                            <p class="text-truncate news-list-display news-list-display03">

                                <i class="fas fa-building"></i> {{value.main_point}}
                            </p>
                            </router-link>
                        </div>
                    </div>
                </div>                    
            </slick>
            <slick :options="slickOptions" class="news-slider-width" v-if="index === 1" >     
                <div class="pad-new pattern-child group-1"   >
     
                    <div class="medium-b1" v-for="(value,index) in group[1]" :key="index" >
                        <router-link :to="'/newsdetails/'+value.id" v-if="index === 0"> 
                            <div class="col-12 row m-b-5 adslist-card m-lr-0 news-3-card">

                                <div class="col-4 img-box">

                                    <clazy-load class="wrapper-4" @load="log" src="/images/noimage.jpg" :key="inx" >
                                        <transition name="fade">

                                            <img v-bind:src="'/upload/news/' + value.photo" class="fit-image-0" @error="imgUrlAlt">

                                        </transition>

                                        <transition name="fade" slot="placeholder">

                                            <div class="preloader">

                                                <div class="circle">

                                                <div class="circle-inner"></div>

                                                </div>

                                            </div>

                                        </transition>
                                    </clazy-load>

                                </div>
                                <div class="col-8 pattern-txt-box">
                                  

                                    <p>{{value.main_point}}</p>

                                </div>

                            </div>
                        </router-link>
                    </div>
                    <div class="small" v-for="(value,index) in group[2]" :key="index">
                        <div class="small-b1"  v-if="index === 1">
                            <router-link  :to="'/newsdetails/'+value.id" style="color:#333;">  
                            <p class="text-truncate news-list-display">

                                <i class="fas fa-building"></i> {{value.main_point}}
                            </p>
                            </router-link>
                        </div>
                        <div class="small-b1"  v-if="index === 2">
                            <router-link  :to="'/newsdetails/'+value.id" style="color:#333;">  
                            <p class="text-truncate news-list-display">

                                <i class="fas fa-building"></i> {{value.main_point}}
                            </p>
                            </router-link>
                        </div>
                        <div class="small-b1"  v-if="index === 3">
                            <router-link  :to="'/newsdetails/'+value.id" style="color:#333;">  
                            <p class="text-truncate news-list-display">

                                <i class="fas fa-building"></i> {{value.main_point}}
                            </p>
                            </router-link>
                        </div>
                        <div class="small-b1"  v-if="index === 4">
                            <router-link  :to="'/newsdetails/'+value.id" style="color:#333;">  
                            <p class="text-truncate news-list-display">

                                <i class="fas fa-building"></i> {{value.main_point}}
                            </p>
                            </router-link>
                        </div>
                        <div class="small-b1"  v-if="index === 5">
                            <router-link  :to="'/newsdetails/'+value.id" style="color:#333;">  
                            <p class="text-truncate news-list-display">

                                <i class="fas fa-building"></i> {{value.main_point}}
                            </p>
                            </router-link>
                        </div>
                        <div class="small-b1"  v-if="index === 6">
                            <router-link  :to="'/newsdetails/'+value.id" style="color:#333;">  
                            <p class="text-truncate news-list-display">

                                <i class="fas fa-building"></i> {{value.main_point}}
                            </p>
                            </router-link>
                        </div>
                        <div class="small-b1"  v-if="index === 7">
                            <router-link  :to="'/newsdetails/'+value.id" style="color:#333;">  
                            <p class="text-truncate news-list-display">

                                <i class="fas fa-building"></i> {{value.main_point}}
                            </p>
                            </router-link>
                        </div>
                    </div>                                
                </div>
                <div class="pad-new pattern-child group-0">

                    <div class="large" v-for="(value,index) in group[0]" :key="index" >
                        <div class="large-b0 m-b-5" v-if="index === 0">
                            <router-link :to="'/newsdetails/'+value.id" >
                                <div class="col-12 single-news-box">

                                    <clazy-load class="wrapper-3" @load="log" src="/images/noimage.jpg" :key="index" >

                                        <transition name="fade">

                                            <img v-bind:src="'/upload/news/' + value.photo" class="fit-image-0" @error="imgUrlAlt">

                                        </transition>                                

                                        <transition name="fade" slot="placeholder">

                                            <div class="preloader">

                                                <div class="circle">

                                                <div class="circle-inner"></div>

                                                </div>

                                            </div>

                                        </transition>
                                    </clazy-load>
                                    <p>  {{value.main_point}} </p>
                                </div>
                            </router-link>
                        </div>
                    </div>
                    <div class="small" v-for="(value,index) in group[2]" :key="index">
                        <div class="small-b0" v-if="index === 0">
                            <router-link  :to="'/newsdetails/'+value.id" style="color:#333;">  
                            <p class="text-truncate news-list-display">

                                <i class="fas fa-building"></i> {{value.main_point}}
                            </p>
                            </router-link>
                        </div>
                    </div>
                </div>
                <div class="pad-new pattern-child group-3"  >    
                     
                    <div class="medium" v-for="(value,index) in group[1]" :key="index" >
                        <div class="medium-b3" v-if="index === 1">
                            <router-link :to="'/newsdetails/'+value.id"> 
                            <div class="col-12 row m-b-5 adslist-card m-lr-0 news-3-card">

                                <div class="col-4 img-box">

                                    <clazy-load class="wrapper-4" @load="log" src="/images/noimage.jpg" :key="inx" >
                                        <transition name="fade">

                                            <img v-bind:src="'/upload/news/' + value.photo" class="fit-image-0" @error="imgUrlAlt">

                                        </transition>

                                        <transition name="fade" slot="placeholder">

                                            <div class="preloader">

                                                <div class="circle">

                                                <div class="circle-inner"></div>

                                                </div>

                                            </div>

                                        </transition>
                                    </clazy-load>

                                </div>
                                <div class="col-8 pattern-txt-box">
                                  

                                    <p>{{value.main_point}}</p>

                                </div>

                            </div>
                            </router-link>
                        </div>
                        <div class="medium-b3" v-if="index === 2">
                            <router-link :to="'/newsdetails/'+value.id"> 
                            <div class="col-12 row m-b-5 adslist-card m-lr-0 news-3-card">

                                <div class="col-4 img-box">

                                    <clazy-load class="wrapper-4" @load="log" src="/images/noimage.jpg" :key="inx" >
                                        <transition name="fade">

                                            <img v-bind:src="'/upload/news/' + value.photo" class="fit-image-0" @error="imgUrlAlt">

                                        </transition>

                                        <transition name="fade" slot="placeholder">

                                            <div class="preloader">

                                                <div class="circle">

                                                <div class="circle-inner"></div>

                                                </div>

                                            </div>

                                        </transition>
                                    </clazy-load>

                                </div>
                                <div class="col-8 pattern-txt-box">
                                  

                                    <p>{{value.main_point}}</p>

                                </div>

                            </div>
                            </router-link>
                        </div>
                    </div>
                    <div class="small" v-for="(value,index) in group[2]" :key="index" >                  
                        <div class="small-b3"  v-if="index === 9">
                            <router-link  :to="'/newsdetails/'+value.id" style="color:#333;">  
                            <p class="text-truncate news-list-display news-list-display03">

                                <i class="fas fa-building"></i> {{value.main_point}}
                            </p>
                            </router-link>
                        </div>
                        <div class="small-b3"  v-if="index === 10">
                            <router-link  :to="'/newsdetails/'+value.id" style="color:#333;">  
                            <p class="text-truncate news-list-display news-list-display03">

                                <i class="fas fa-building"></i> {{value.main_point}}
                            </p>
                            </router-link>
                        </div>
                        <div class="small-b3"  v-if="index === 11">
                            <router-link  :to="'/newsdetails/'+value.id" style="color:#333;">  
                            <p class="text-truncate news-list-display news-list-display03">

                                <i class="fas fa-building"></i> {{value.main_point}}
                            </p>
                            </router-link>
                        </div>
                        <div class="small-b3"  v-if="index === 12">
                            <router-link  :to="'/newsdetails/'+value.id" style="color:#333;">  
                            <p class="text-truncate news-list-display news-list-display03">

                                <i class="fas fa-building"></i> {{value.main_point}}
                            </p>
                            </router-link>
                        </div>
                    </div>
                </div>            
                <div class="pad-new pattern-child group-2"  >
                    <div class="large"  v-for="(value,index) in group[0]" :key="index">
                        <div class="large-b0 m-b-5" v-if="index === 1">
                            <router-link :to="'/newsdetails/'+value.id" >
                                <div class="col-12 single-news-box">

                                    <clazy-load class="wrapper-3" @load="log" src="/images/noimage.jpg" :key="index" >

                                        <transition name="fade">

                                            <img v-bind:src="'/upload/news/' + value.photo" class="fit-image-0" @error="imgUrlAlt">

                                        </transition>                                

                                        <transition name="fade" slot="placeholder">

                                            <div class="preloader">

                                                <div class="circle">

                                                <div class="circle-inner"></div>

                                                </div>

                                            </div>

                                        </transition>
                                    </clazy-load>
                                    <p>  {{value.main_point}} </p>
                                </div>
                            </router-link>
                        </div>
                    </div>       
                    <div class="small" v-for="(value,index) in group[2]" :key="index">        
                        <div class="small-b2" v-if="index === 8">
                            <router-link  :to="'/newsdetails/'+value.id" style="color:#333;">  
                            <p class="text-truncate news-list-display">

                                <i class="fas fa-building"></i> {{value.main_point}}
                            </p>
                            </router-link>
                        </div>
                    </div> 
                </div>
            </slick>            
        </div>
        <div v-if="seen" >
            <div id="more"  class="row m-lr-0" v-for="(group,index) in more_news" :key="index">  
                    <div class="pad-new pattern-child group-0" v-for="(value,index) in group" :key="index"  :class="'bordertop-color'+(5-(Math.floor(cat_id%5)))">
                        <div class="medium">
                            <div class="medium-b3">
                                <router-link :to="'/newsdetails/'+value.id"> 
                                <div class="col-12 row m-b-5 adslist-card m-lr-0 news-3-card">

                                    <div class="col-4 img-box">

                                        <clazy-load class="wrapper-4" @load="log" src="/images/noimage.jpg" :key="inx" >
                                            <transition name="fade">

                                                <img v-bind:src="'/upload/news/' + value.photo" class="fit-image-0" @error="imgUrlAlt">

                                            </transition>

                                            <transition name="fade" slot="placeholder">

                                                <div class="preloader">

                                                    <div class="circle">

                                                    <div class="circle-inner"></div>

                                                    </div>

                                                </div>

                                            </transition>
                                        </clazy-load>

                                    </div>
                                    <div class="col-8 pattern-txt-box">
                                      

                                        <p>{{value.main_point}}</p>

                                    </div>

                                </div>
                                </router-link>
                            </div>
                        </div>
                    </div>
            </div> 
        </div>
        <div v-if="more_news.length >2" class="form-group text-center head-btn">
            <button type="submit" v-if="!seen" v-on:click="showMoreClick" class="btn_more">もっと見る  <i class='fas fa-chevron-down'></i></button>
            <button type="submit" v-if="seen" v-on:click="showLessClick" class="btn_more"><i class='fas fas fa-chevron-up'></i></button>
        </div> 
    </div>    
    <!-- end layout design -->
   
    <div v-else-if="block && w_width <= 480" class="row col-12 m-lr-0 p-0">
            <router-link v-for="(item,index) in news" :key="index" :to="'/newsdetails/'+item.id" class="col-md-6 col-sm-6 col-lg-3 m-b-8 pad-new">
                <div class="col-md-12 row adslist-card news-3-card m-0">

                    <div class="col-4 img-box">

                        <clazy-load class="wrapper-4" @load="log" src="/images/noimage.jpg" :key="index" >

                            <!-- <img v-bind:src="'/upload/news/' + item.photo" class="fit-image" style="height:5rem;width:6rem" @error="imgUrlAlt"> -->

                            <transition name="fade">

                                <img :src="'/upload/news/' + item.photo" class="fit-image-0 img-fluid"  @error="imgUrlAlt">

                            </transition>

                            <transition name="fade" slot="placeholder">

                            <div class="preloader">

                                <div class="circle">

                                <div class="circle-inner"></div>

                                </div>

                            </div>
                            </transition>
                        </clazy-load>
                    </div>
                    <div class="col-8 pattern-txt-box">
                        <p> {{item.main_point}} </p>
                    </div>
                </div>
            </router-link>
    </div>
    <div v-else-if="nonblock" class="row col-12 m-lr-0 p-0">
        <router-link v-for="(item,index) in searchnews" :key="index" :to="'/newsdetails/'+item.id" class="col-md-6 col-sm-6 col-lg-3 m-b-8 pad-new">
            <div class="col-md-12 row adslist-card news-3-card m-0">

                <div class="col-4 img-box">

                    <clazy-load class="wrapper-4" @load="log" src="/images/noimage.jpg" :key="index" >
                        <transition name="fade">

                            <img :src="'/upload/news/' + item.photo" class="fit-image-0 img-fluid"  @error="imgUrlAlt">

                        </transition>

                        <transition name="fade" slot="placeholder">

                        <div class="preloader">

                            <div class="circle">

                            <div class="circle-inner"></div>

                            </div>

                        </div>
                        </transition>
                    </clazy-load>
                </div>
                <div class="col-8 pattern-txt-box">
                    <p> {{item.main_point}} </p>
                </div>
            </div>
        </router-link>
    </div>
</div>
</layout>
</template>

<script>
    import layout from '../components/home.vue'
    import Slick from 'vue-slick'
export default {

    components: {
        layout,
        Slick
    },
    el:"#more",
    data() {

        return {
            news:[],
            more_news:[],
            cats: [],
            searchnews:[],
            cat_name:'',
            cat_id:'',
            search_word:null,
            norecord_msg:false,
            block:false,
            nonblock:false,
            w_width: $(window).width(),
            is_cat_overflow: false,
            is_cat_slided: false,
            computed_width: '100%',
            w_width: $(window).width(),
            norecord_msg: false,
            cat_box_width: null,
            seen: false,
        }
    },
    mounted() {
        //this.getAllCat();
    },
    created(){
        if($(window).width() > 480){
             this.axios.get(`/api/newscategory/${this.$route.params.id}`).then(response => {
                this.news = response.data.newslist;
                this.more_news = response.data.moreNews;
                if(response.data.newslist.length == 0)
                {
                     this.norecord_msg = true;
                }
                else{
                     this.block = true;
                     this.norecord_msg = false;
                }
                this.cat_id = response.data.cat_id;
                this.cat_name = response.data.cat_name;
              
          });
        }else{
            this.axios.get(`/api/newscategorymobile/${this.$route.params.id}`).then(response => {
                this.news = response.data.newslist;
                if(response.data.newslist.length == 0)
                {
                     this.norecord_msg = true;
                }
                else{
                     this.block = true;
                     this.norecord_msg = false;
                }
                this.cat_name = response.data.cat_name;              
          });
        }
    },
    updated:function(){
        $(".gNav .router-link-active").addClass("router-link-exact-active");
    },
    beforeDestroy:function(){
        $(".gNav .router-link-active").removeClass("router-link-exact-active");
    },
    computed:{  
        slickOptions() {
                return {
                slidesToShow: 4,
                infinite: false,
                accessibility: true,
                adaptiveHeight: false,
                arrows: true,
                dots: true,
                draggable: true,
                edgeFriction: 0.30,
                swipe: true,
                responsive: [{
                    breakpoint: 1280,
                        settings: {
                            slidesToShow: 3,                           
                            slidesToScroll: 1,  
                            infinite:false 
                        }
                    }, {
                    breakpoint: 1024,
                        settings: {
                            slidesToShow: 3,
                            slidesToScroll: 1, 
                            infinite: false                           
                        }
                    },{
                    breakpoint: 770,
                        settings: {
                            slidesToShow: 2,
                            slidesToScroll: 1, 
                            infinite: false                           
                        }
                    },{
                        breakpoint: 420,
                            settings:{
                                slidesToShow: 1,
                                slidesToScroll:1,
                                infinite: false
                            }
                    },{
                    breakpoint: 481,
                    settings: {
                        slidesToShow: 2,
                    }
                }]                    
                }
        }
    },
    methods:{
            getAllCat: function() {
                this.axios.get('/api/home') 
                .then(response => {
                        this.cats = response.data;

                        this.getPostByCatID();

                        this.getLatestPostByCatID();

                    });

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
            imgUrlAlt(event) {
                            event.target.src = "/images/noimage.jpg"
                },
            searchCategory(){

                    if ($('#search-free-word').val() == null || $('#search-free-word').val() == '' || $('#search-free-word').val() == 'null') {
                        this.clearSearch();
                    } else {
                        this.status = 1;
                        this.search_word = $('#search-free-word').val();          
                    }
                    this.getlatestpost();

            },
            getPostByCatID: function(catId = this.cats[0].id) {
                if ($('#search-free-word').val() != null) {
                    var search_word = $('#search-free-word').val();
                } else {
                    var search_word = null;
                }

                if (catId !== undefined) {
                    var cat_id = catId;
                } else {
                    var cat_id = this.cats[0].id;
                }
                let fd = new FormData();
                fd.append('search_word', search_word);
                fd.append('category_id', cat_id);
                $('.search-item').css('display', 'none');
                this.categoryId = cat_id;
                this.axios.post("/api/posts", fd)
                    .then(response => {
                        this.posts = response.data;
                    });
            },
            getLatestPostByCatID: function(catId) {

                if ($('#search-free-word').val()) {

                    var search_word = $('#search-free-word').val();
                } else {

                    var search_word = null;

                }

                if (catId) {

                    var cat_id = catId;

                } else {

                    var cat_id = this.cats[0].id;

                }

                let fd = new FormData();

                fd.append('search_word', search_word)

                fd.append('category_id', cat_id)

                $('.search-item').css('display', 'none');

                this.categoryId = cat_id;

                this.axios.post("/api/get_latest_post" , fd)

                .then(response => {

                    this.latest_post = response.data;
                    if(Object.keys(this.latest_post).length == 0){
                        this.latest_post_null = true;
                    }
                    else{
                        this.latest_post_null = false;
                    }
                });

            },
            getlatestpost()
            {
                  if (this.search_word == null || this.search_word == '' || this.search_word == 'null') {
                        this.nonblock = false;
                        this.block = true;
                        var searchword = 'all_news_search';                
                    } else {                        
                        this.block = false;
                        this.nonblock = true;
                        var searchword = this.search_word;
                        this.searchnews = [];
                    }
                    this.axios.get('/api/get_news_by_catId/'+searchword+'/'+this.$route.params.id).then(response => {
                    this.$loading(false);
                    this.searchnews = response.data;
                    if(response.data.length == 0)
                    {
                        this.norecord_msg = true;
                    }
                    else{
                        this.norecord_msg = false;
                    }
                
                });
            },
             clearSearch() {

                this.search_word = '';
                this.getlatestpost();

            },
            showMoreClick(){
                this.seen = true;
            },
            showLessClick(){
                this.seen = false;
            },
   }
}
</script>

<style scoped>
.profile-tit{
    margin-top: 0;
}
.pad-new{
    padding-left: 5px !important;
    padding-right: 5px !important;
}
.clearfix:after { 
   content: "."; 
   visibility: hidden; 
   display: block; 
   height: 0; 
   clear: both;
}
.bordertop-color1 {
    border-top: 0px solid #a3774a !important;
}
.bordertop-color2 {
    border-top: 0px solid #9579ef !important;
}
.bordertop-color3 {
    border-top: 0px solid #21d1de !important;
}
.bordertop-color4 {
    border-top: 0px solid #d1291d !important;
}
.bordertop-color5 {
    border-top: 0px solid #63b7ff !important;
}
.news-slider-width{
    width: 100%;
}
.news-list-display{
    padding: 5px 10px;
    margin-bottom: 5px;
    background: #f7f7f7;
    border:solid #f3efef;
    border-width: 0 1px 1px 0;
    box-sizing: border-box;
    max-height: 30px;
}
.news-list-display03{
    padding: 5.7px 10px;
}
.news-3-card {
    background-color: #f7f7f7;
    border:solid #f3efef;
    border-width: 0 1px 1px 0;
    box-sizing: border-box;
}
.news-3-card .img-box{
    padding-left: 10px;
}
.single-news-box {
    background: #f7f7f7;
    height: 310px;
    padding: 10px;
    border:solid #f3efef;
    border-width: 0 1px 1px 0;
    overflow: hidden;
    box-sizing: border-box;
}
.arr-btn {
    cursor: pointer;
    display: inline-flex;
    display: -webkit-inline-flex;
    display: -ms-inline-flex;
    background:transparent;
    padding: 5px 1px 4px;
    font-size: 25px;
}
.left-arr-btn {
    position: relative;     
    left: -20px;
    width: 2%;
}
.right-arr-btn {
    position: relative;      
    right: -47px;
    width: 2%;
}
#myTab ul li {
    display: -ms-inline-flexbox;
    display: inline-flex;
    display: -webkit-inline-flex;
}
.nav {
    flex-wrap: nowrap;
}
.center{
    overflow: hidden;
    white-space: nowrap;
    display: inline-block;
}
.card-header-tabs {
    margin-right: -1.65rem;
    margin-left: -1.65rem;
    border-bottom: 0;
}
.cat-nav {
    padding-bottom: 0;
    height: 36px;
    display: flex;
    padding-left: 1.65rem !important;
}
.left-arr-btn {
    position: relative;     
    left: -20px;
    width: 2%;
}
.right-arr-btn {
    position: relative;      
    right: -40px;
    width: 2%;
}
#top {
    border-left: 1px solid #fff;
}
.nav-tabs{
    border-bottom: none;
}
#myTab .router-link-exact-active {
    height: 36px;
    color: #fff !important;
    background-color: #828282;
    border: none !important;
}
.wrapper-4{
    padding-bottom: 79px;
}
.btn_more{
    background-color: #287db4; 
    padding: 5px 30px; 
    border-radius: 0;
    border: none;
    min-width: 150px;
    color: white;
}
.btn_more .fas{
    font-size: 20px;
    vertical-align: middle;
}
#more .pad-new{
    width: 25%;
}
.head-news .slick-news:last-child{ 
    display: none;
}
.head-btn{
    margin-top: 8px;
}

@media only screen and (max-width:767px)  {
    .cat-nav {
        padding-left: 0 !important;
        height: auto !important;
    }
}

@media only screen and (min-width:768px) and (max-width:1024px) {
    #more .pad-new{
    width: 50%;
    }
}
</style>
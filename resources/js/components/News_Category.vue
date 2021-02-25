<template>
<layout>   
<div class="category_margin">    
   
    <div class="col-12 cat_title">
        <h4 class="profile-tit" :style="useStyle">{{cat_name}}
        </h4>
    </div>       
    <div v-if="norecord_msg">
        <div class="container-fuid no_search_data">
            <p class="nosearch-data">お探しの条件に合うニュースは見つかりませんでした。</p>
        </div>
    </div>
    <!-- news layout design change (@author:pzo) -->
    <div v-else-if="block && w_width > 480" class="head-news" >  
        <div v-for="(group,index) in news" :key="index" class="slick-news row m-lr-0 bordertop-color">
                
            <slick :options="slickOptions" class="news-slider-width" v-if="index === 0" >             
                <div class="pad-new pattern-child group-0">

                    <div class="large" v-for="(value,index) in group[0]" :key="index" >
                        <div class="large-b0 m-b-5" v-if="index === 0">
                            <router-link :to="'/newsdetails/'+value.id" >
                                <div class="col-12 single-news-box">

                                    <clazy-load class="wrapper-3" @load="log" src="/images/noimage.jpg" :key="index" >

                                        <transition name="fade">

                                            <img v-bind:src="'/upload/news/' + value.photo" class="fit-image img-fluid" @error="imgUrlAlt" :alt="cat_name+'ニュース画像'">

                                        </transition>

                                        <transition name="fade" slot="placeholder">

                                            <div class="preloader">

                                                <div class="circle">

                                                <div class="circle-inner"></div>

                                                </div>

                                            </div>

                                        </transition>
                                    </clazy-load>
                                    <p> {{value.title}} </p>
                                </div>
                            </router-link>
                            <!-- <div class="txt_date">{{value.created_at}}</div> -->
                            <div class="txt_date">
                                <p v-if="value.new_news == '1'" class="second_para">{{value.date_only}}<span class="small_new">New</span></p>
                                <p v-else class="second_para">{{value.created_at}}</p>
                            </div>
                        </div>
                    </div>
                    <div class="small" v-for="(value,index) in group[2]" :key="index">
                        <div class="small-b0" v-if="index === 0" :style="{'--color': value.color_code ? value.color_code : '#287db4'}">
                            <router-link  :to="'/newsdetails/'+value.id" >  
                            <p class="text-truncate news-list-display news-list-display03">
                                <span class="sm_news_fa"><i class="fas fa-building"></i></span> 
                                <span class="sm_news_mp">
                                   {{value.title}}
                                </span>
                                <span v-if="value.new_news == '1'" class="second_para">{{value.date_only}}<span class="sm_news_new">New</span></span>
                                <span class="sm_news_date" v-else>{{value.created_at}}</span>
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

                                            <img v-bind:src="'/upload/news/' + value.photo" class="fit-image img-fluid" @error="imgUrlAlt" :alt="cat_name+'ニュース画像'">

                                        </transition>
                                        <!-- <div v-if="value.new_news == '1'" class="m_top_left"><span>New</span></div> -->

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
                                  

                                    <p class="med_news_title">{{value.title}}</p>

                                </div>

                            </div>
                        </router-link>
                        <div v-if="index === 0" class="txt_date">
                            <p v-if="value.new_news == '1'" class="second_para">{{value.date_only}}<span class="small_new">New</span></p>
                            <p v-else class="second_para">{{value.created_at}}</p>
                        </div>
                    </div>
                    <div class="small" v-for="(value,index) in group[2].slice(1, 8)" :key="index">
                        <div class="small-b1" :style="{'--color': value.color_code ? value.color_code : '#287db4'}">
                            <router-link  :to="'/newsdetails/'+value.id" >  
                            <p class="text-truncate news-list-display news-list-display03">

                                <span class="sm_news_fa"><i class="fas fa-building"></i></span> 
                                <span class="sm_news_mp">
                                   {{value.title}}
                                </span>
                                <span v-if="value.new_news == '1'" class="second_para">{{value.date_only}}<span class="sm_news_new">New</span></span>
                                <span class="sm_news_date" v-else>{{value.created_at}}</span>
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

                                            <img v-bind:src="'/upload/news/' + value.photo" class="fit-image img-fluid" @error="imgUrlAlt" :alt="cat_name+'ニュース画像'">

                                        </transition>

                                        <transition name="fade" slot="placeholder">

                                            <div class="preloader">

                                                <div class="circle">

                                                <div class="circle-inner"></div>

                                                </div>

                                            </div>

                                        </transition>
                                    </clazy-load>
                                    <p> {{value.title}} </p>
                                </div>
                            </router-link>
                            <div class="txt_date">
                                <p v-if="value.new_news == '1'" class="second_para">{{value.date_only}}<span class="small_new">New</span></p>
                                <p v-else class="second_para">{{value.created_at}}</p>
                            </div>
                        </div>
                    </div>       
                    <div class="small" v-for="(value,index) in group[2]" :key="index">        
                        <div class="small-b2" v-if="index === 8" :style="{'--color': value.color_code ? value.color_code : '#287db4'}">
                            <router-link  :to="'/newsdetails/'+value.id" >  
                            <p class="text-truncate news-list-display news-list-display03">

                                <span class="sm_news_fa"><i class="fas fa-building"></i></span> 
                                <span class="sm_news_mp">
                                   {{value.title}}
                                </span>
                                <span v-if="value.new_news == '1'" class="second_para">{{value.date_only}}<span class="sm_news_new">New</span></span>
                                <span class="sm_news_date" v-else>{{value.created_at}}</span>
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

                                            <img v-bind:src="'/upload/news/' + value.photo" class="fit-image img-fluid" @error="imgUrlAlt" :alt="cat_name+'ニュース画像'">

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
                                  

                                    <p>{{value.title}}</p>

                                </div>

                            </div>
                            </router-link>
                            <div class="txt_date">
                                <p v-if="value.new_news == '1'" class="second_para">{{value.date_only}}<span class="small_new">New</span></p>
                                <p v-else class="second_para">{{value.created_at}}</p>
                            </div>
                        </div>
                        <div class="medium-b3" v-if="index === 2">
                            <router-link :to="'/newsdetails/'+value.id"> 
                            <div class="col-12 row m-b-5 adslist-card m-lr-0 news-3-card">

                                <div class="col-4 img-box">

                                    <clazy-load class="wrapper-4" @load="log" src="/images/noimage.jpg" :key="inx" >
                                        <transition name="fade">

                                            <img v-bind:src="'/upload/news/' + value.photo" class="fit-image img-fluid" @error="imgUrlAlt" :alt="cat_name+'ニュース画像'">

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
                                  

                                    <p>{{value.title}}</p>

                                </div>

                            </div>
                            </router-link>
                            <div class="txt_date" v-if="index === 2">
                                <p v-if="value.new_news == '1'" class="second_para">{{value.date_only}}<span class="small_new">New</span></p>
                                <p v-else class="second_para">{{value.created_at}}</p>
                            </div>
                        </div>
                    </div>
                    <div class="small" v-for="(value,index) in group[2].slice(9, 13)" :key="index" >                  
                        <div class="small-b3"    :style="{'--color': value.color_code ? value.color_code : '#287db4'}">
                            <router-link  :to="'/newsdetails/'+value.id" >  
                            
                            <p class="text-truncate news-list-display news-list-display03">
                                <span class="sm_news_fa"><i class="fas fa-building"></i></span> 
                                <span class="sm_news_mp">
                                   {{value.title}}
                                </span>
                                <span v-if="value.new_news == '1'" class="second_para">{{value.date_only}}<span class="sm_news_new">New</span></span>
                                <span class="sm_news_date" v-else>{{value.created_at}}</span>
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

                                            <img v-bind:src="'/upload/news/' + value.photo" class="fit-image img-fluid" @error="imgUrlAlt" :alt="cat_name+'ニュース画像'">

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
                                  

                                    <p>{{value.title}}</p>

                                </div>

                            </div>
                        </router-link>
                        <div v-if="index === 0" class="txt_date">
                            <p v-if="value.new_news == '1'" class="second_para">{{value.date_only}}<span class="small_new">New</span></p>
                            <p v-else class="second_para">{{value.created_at}}</p>
                        </div>
                    </div>
                    <div class="small" v-for="(value,index) in group[2].slice(0, 7)" :key="index">
                        <div class="small-b1" :style="{'--color': value.color_code ? value.color_code : '#287db4'}">
                            <router-link  :to="'/newsdetails/'+value.id" >  
                            <p class="text-truncate news-list-display news-list-display03">

                                <span class="sm_news_fa"><i class="fas fa-building"></i></span> 
                                <span class="sm_news_mp">
                                   {{value.title}}
                                </span>
                                <span v-if="value.new_news == '1'" class="second_para">{{value.date_only}}<span class="sm_news_new">New</span></span>
                                <span class="sm_news_date" v-else>{{value.created_at}}</span>
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

                                            <img v-bind:src="'/upload/news/' + value.photo" class="fit-image img-fluid" @error="imgUrlAlt" :alt="cat_name+'ニュース画像'">

                                        </transition>

                                        <transition name="fade" slot="placeholder">

                                            <div class="preloader">

                                                <div class="circle">

                                                <div class="circle-inner"></div>

                                                </div>

                                            </div>

                                        </transition>
                                    </clazy-load>
                                    <p> {{value.title}} </p>
                                </div>
                            </router-link>
                            <div class="txt_date">
                                <p v-if="value.new_news == '1'" class="second_para">{{value.date_only}}<span class="small_new">New</span></p>
                                <p v-else class="second_para">{{value.created_at}}</p>
                            </div>
                        </div>
                    </div>
                    <div class="small" v-for="(value,index) in group[2]" :key="index">
                        <div class="small-b0" v-if="index === 7" :style="{'--color': value.color_code ? value.color_code : '#287db4'}">
                            <router-link  :to="'/newsdetails/'+value.id" >  
                            <p class="text-truncate news-list-display news-list-display03">

                                <span class="sm_news_fa"><i class="fas fa-building"></i></span> 
                                <span class="sm_news_mp">
                                   {{value.title}}
                                </span>
                                <span v-if="value.new_news == '1'" class="second_para">{{value.date_only}}<span class="sm_news_new">New</span></span>
                                <span class="sm_news_date" v-else>{{value.created_at}}</span>
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

                                            <img v-bind:src="'/upload/news/' + value.photo" class="fit-image img-fluid" @error="imgUrlAlt" :alt="cat_name+'ニュース画像'">

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
                                  

                                    <p>{{value.title}}</p>

                                </div>

                            </div>
                            </router-link>
                            <div class="txt_date">
                                <p v-if="value.new_news == '1'" class="second_para">{{value.date_only}}<span class="small_new">New</span></p>
                                <p v-else class="second_para">{{value.created_at}}</p>
                            </div>
                        </div>
                        <div class="medium-b3" v-if="index === 2">
                            <router-link :to="'/newsdetails/'+value.id"> 
                            <div class="col-12 row m-b-5 adslist-card m-lr-0 news-3-card">

                                <div class="col-4 img-box">

                                    <clazy-load class="wrapper-4" @load="log" src="/images/noimage.jpg" :key="inx" >
                                        <transition name="fade">

                                            <img v-bind:src="'/upload/news/' + value.photo" class="fit-image img-fluid" @error="imgUrlAlt" :alt="cat_name+'ニュース画像'">

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
                                  

                                    <p>{{value.title}}</p>

                                </div>

                            </div>
                            </router-link>
                            <div class="txt_date">
                                <p v-if="value.new_news == '1'" class="second_para">{{value.date_only}}<span class="small_new">New</span></p>
                                <p v-else class="second_para">{{value.created_at}}</p>
                            </div>
                        </div>
                    </div>
                    <div class="small" v-for="(value,index) in group[2].slice(8, 12)" :key="index" >                  
                        <div class="small-b3"  :style="{'--color': value.color_code ? value.color_code : '#287db4'}">
                            <router-link  :to="'/newsdetails/'+value.id" >  
                            <p class="text-truncate news-list-display news-list-display03">

                                <span class="sm_news_fa"><i class="fas fa-building"></i></span> 
                                <span class="sm_news_mp">
                                   {{value.title}}
                                </span>
                                <span v-if="value.new_news == '1'" class="second_para">{{value.date_only}}<span class="sm_news_new">New</span></span>
                                <span class="sm_news_date" v-else>{{value.created_at}}</span>
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

                                            <img v-bind:src="'/upload/news/' + value.photo" class="fit-image img-fluid" @error="imgUrlAlt" :alt="cat_name+'ニュース画像'">

                                        </transition>  

                                        <transition name="fade" slot="placeholder">

                                            <div class="preloader">

                                                <div class="circle">

                                                <div class="circle-inner"></div>

                                                </div>

                                            </div>

                                        </transition>
                                    </clazy-load>
                                    <p> {{value.title}} </p>
                                </div>
                            </router-link>
                            <div class="txt_date">
                                <p v-if="value.new_news == '1'" class="second_para">{{value.date_only}}<span class="small_new">New</span></p>
                                <p v-else class="second_para">{{value.created_at}}</p>
                            </div>
                        </div>
                    </div>       
                    <div class="small" v-for="(value,index) in group[2]" :key="index">        
                        <div class="small-b2" v-if="index === 12" :style="{'--color': value.color_code ? value.color_code : '#287db4'}">
                            <router-link  :to="'/newsdetails/'+value.id" >  
                            <p class="text-truncate news-list-display news-list-display03">

                                <span class="sm_news_fa"><i class="fas fa-building"></i></span> 
                                <span class="sm_news_mp">
                                   {{value.title}}
                                </span>
                                <span v-if="value.new_news == '1'" class="second_para">{{value.date_only}}<span class="sm_news_new">New</span></span>
                                <span class="sm_news_date" v-else>{{value.created_at}}</span>
                            </p>
                            </router-link>
                        </div>
                    </div> 
                </div>
            </slick>            
        </div>
        <div v-for="(group,ind) in more_news" :key="ind" class="slick-news row m-lr-0 bordertop-color more_news">
            <slick :options="slickOptions" class="news-slider-width" >             
                <div class="pad-new pattern-child group-0">
                    <div class="small" v-for="(value,index) in group.slice(0, 2)" :key="index" >
                        <div class="large-b0 m-b-5" v-if="index === 0">
                            <router-link :to="'/newsdetails/'+value.id" >
                                <div class="col-12 single-news-box">

                                    <clazy-load class="wrapper-3" @load="log" src="/images/noimage.jpg" :key="index" >

                                        <transition name="fade">

                                            <img v-bind:src="'/upload/news/' + value.photo" class="fit-image img-fluid" @error="imgUrlAlt" :alt="cat_name+'ニュース画像'">

                                        </transition>

                                        <transition name="fade" slot="placeholder">

                                            <div class="preloader">

                                                <div class="circle">

                                                <div class="circle-inner"></div>

                                                </div>

                                            </div>

                                        </transition>
                                    </clazy-load>
                                    <p> {{value.title}} </p>
                                </div>
                            </router-link>
                            <div class="txt_date">{{value.created_at}}</div>
                        </div>
                        <div class="small-b0" v-if="index === 1" :style="{'--color': value.color_code ? value.color_code : '#287db4'}">
                            <router-link  :to="'/newsdetails/'+value.id" >  
                            <p class="text-truncate news-list-display news-list-display03">
                                <span class="sm_news_fa"><i class="fas fa-building"></i></span> 
                                <span class="sm_news_mp">
                                   {{value.title}}
                                </span>
                                <span class="sm_news_date">{{value.created_at}}</span>
                            </p>
                            </router-link>
                        </div>
                    </div>
                </div>

                <div class="pad-new pattern-child group-1"   >
                    <div class="small" v-for="(value,index) in group.slice(2, 10)" :key="index" >
                        <div class="medium-b1">
                            <router-link :to="'/newsdetails/'+value.id" v-if="index === 0"> 
                                <div class="col-12 row m-b-5 adslist-card m-lr-0 news-3-card">

                                    <div class="col-4 img-box">

                                        <clazy-load class="wrapper-4" @load="log" src="/images/noimage.jpg" :key="inx" >
                                            <transition name="fade">

                                                <img v-bind:src="'/upload/news/' + value.photo" class="fit-image img-fluid" @error="imgUrlAlt" :alt="cat_name+'ニュース画像'">

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
                                      

                                        <p>{{value.title}}</p>

                                    </div>

                                </div>
                            </router-link>
                            <div v-if="index === 0" class="txt_date">{{value.created_at}}</div>
                        </div>

                        <div class="small-b1" v-if="index !== 0" :style="{'--color': value.color_code ? value.color_code : '#287db4'}">
                            <router-link  :to="'/newsdetails/'+value.id" >  
                            <p class="text-truncate news-list-display news-list-display03">

                                <span class="sm_news_fa"><i class="fas fa-building"></i></span> 
                                <span class="sm_news_mp">
                                   {{value.title}}
                                </span>
                                <span class="sm_news_date">{{value.created_at}}</span>
                            </p>
                            </router-link>
                        </div>
                    </div>                                
                </div>

                <div class="pad-new pattern-child group-2"  >
                    <div class="small" v-for="(value,index) in group.slice(10, 12)" :key="index" >
                        <div class="large-b0 m-b-5" v-if="index === 0">
                            <router-link :to="'/newsdetails/'+value.id" >
                                <div class="col-12 single-news-box">

                                    <clazy-load class="wrapper-3" @load="log" src="/images/noimage.jpg" :key="index" >

                                        <transition name="fade">

                                            <img v-bind:src="'/upload/news/' + value.photo" class="fit-image img-fluid" @error="imgUrlAlt" :alt="cat_name+'ニュース画像'">

                                        </transition>

                                        <transition name="fade" slot="placeholder">

                                            <div class="preloader">

                                                <div class="circle">

                                                <div class="circle-inner"></div>

                                                </div>

                                            </div>

                                        </transition>
                                    </clazy-load>
                                    <p> {{value.title}} </p>
                                </div>
                            </router-link>
                            <div class="txt_date">{{value.created_at}}</div>
                        </div>
                        <div class="small-b0" v-if="index === 1" :style="{'--color': value.color_code ? value.color_code : '#287db4'}">
                            <router-link  :to="'/newsdetails/'+value.id" >  
                            <p class="text-truncate news-list-display news-list-display03">

                                <span class="sm_news_fa"><i class="fas fa-building"></i></span> 
                                <span class="sm_news_mp">
                                   {{value.title}}
                                </span>
                                <span class="sm_news_date">{{value.created_at}}</span>
                            </p>
                            </router-link>
                        </div>
                    </div> 
                </div>

                <div class="pad-new pattern-child group-3"  >    
                     
                    <div class="medium" v-for="(value,index) in group.slice(12, 14)" :key="index" >
                        <div class="medium-b3">
                            <router-link :to="'/newsdetails/'+value.id"> 
                            <div class="col-12 row m-b-5 adslist-card m-lr-0 news-3-card">

                                <div class="col-4 img-box">

                                    <clazy-load class="wrapper-4" @load="log" src="/images/noimage.jpg" :key="inx" >
                                        <transition name="fade">

                                            <img v-bind:src="'/upload/news/' + value.photo" class="fit-image img-fluid" @error="imgUrlAlt" :alt="cat_name+'ニュース画像'">

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
                                  

                                    <p>{{value.title}}</p>

                                </div>

                            </div>
                            </router-link>
                            <div  class="txt_date">{{value.created_at}}</div>
                        </div>
                        
                    </div>
                    <div class="small" v-for="(value,index) in group.slice(14, 18)" :key="index" >                  
                        <div class="small-b3"    :style="{'--color': value.color_code ? value.color_code : '#287db4'}">
                            <router-link  :to="'/newsdetails/'+value.id" >  
                            
                            <p class="text-truncate news-list-display news-list-display03">
                                <span class="sm_news_fa"><i class="fas fa-building"></i></span> 
                                <span class="sm_news_mp">
                                   {{value.title}}
                                </span>
                                <span class="sm_news_date">{{value.created_at}}</span>
                            </p>
                            </router-link>
                        </div>
                    </div>
                </div>                    
            </slick>
            <slick :options="slickOptions" class="news-slider-width"  >             
                
                <div class="pad-new pattern-child group-1"   >
                    <div class="small" v-for="(value,index) in group.slice(18, 26)" :key="index" >
                        <div class="medium-b1">
                            <router-link :to="'/newsdetails/'+value.id" v-if="index === 0"> 
                                <div class="col-12 row m-b-5 adslist-card m-lr-0 news-3-card">

                                    <div class="col-4 img-box">

                                        <clazy-load class="wrapper-4" @load="log" src="/images/noimage.jpg" :key="inx" >
                                            <transition name="fade">

                                                <img v-bind:src="'/upload/news/' + value.photo" class="fit-image img-fluid" @error="imgUrlAlt" :alt="cat_name+'ニュース画像'">

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
                                      

                                        <p>{{value.title}}</p>

                                    </div>

                                </div>
                            </router-link>
                            <div v-if="index === 0"  class="txt_date">{{value.created_at}}</div>
                        </div>

                        <div class="small-b1" v-if="index !== 0" :style="{'--color': value.color_code ? value.color_code : '#287db4'}">
                            <router-link  :to="'/newsdetails/'+value.id" >  
                            <p class="text-truncate news-list-display news-list-display03">

                                <span class="sm_news_fa"><i class="fas fa-building"></i></span> 
                                <span class="sm_news_mp">
                                   {{value.title}}
                                </span>
                                <span class="sm_news_date">{{value.created_at}}</span>
                            </p>
                            </router-link>
                        </div>
                    </div>                                
                </div>

                <div class="pad-new pattern-child group-0">
                    <div class="small" v-for="(value,index) in group.slice(26, 28)" :key="index" >
                        <div class="large-b0 m-b-5" v-if="index === 0">
                            <router-link :to="'/newsdetails/'+value.id" >
                                <div class="col-12 single-news-box">

                                    <clazy-load class="wrapper-3" @load="log" src="/images/noimage.jpg" :key="index" >

                                        <transition name="fade">

                                            <img v-bind:src="'/upload/news/' + value.photo" class="fit-image img-fluid" @error="imgUrlAlt" :alt="cat_name+'ニュース画像'">

                                        </transition>

                                        <transition name="fade" slot="placeholder">

                                            <div class="preloader">

                                                <div class="circle">

                                                <div class="circle-inner"></div>

                                                </div>

                                            </div>

                                        </transition>
                                    </clazy-load>
                                    <p> {{value.title}} </p>
                                </div>
                            </router-link>
                            <div class="txt_date">{{value.created_at}}</div>
                        </div>
                        <div class="small-b0" v-if="index === 1" :style="{'--color': value.color_code ? value.color_code : '#287db4'}">
                            <router-link  :to="'/newsdetails/'+value.id" >  
                            <p class="text-truncate news-list-display news-list-display03">

                                <span class="sm_news_fa"><i class="fas fa-building"></i></span> 
                                <span class="sm_news_mp">
                                   {{value.title}}
                                </span>
                                <span class="sm_news_date">{{value.created_at}}</span>
                            </p>
                            </router-link>
                        </div>
                    </div>
                </div>

                <div class="pad-new pattern-child group-3"  >    
                     
                    <div class="medium" v-for="(value,index) in group.slice(28, 30)" :key="index" >
                        <div class="medium-b3">
                            <router-link :to="'/newsdetails/'+value.id"> 
                            <div class="col-12 row m-b-5 adslist-card m-lr-0 news-3-card">

                                <div class="col-4 img-box">

                                    <clazy-load class="wrapper-4" @load="log" src="/images/noimage.jpg" :key="inx" >
                                        <transition name="fade">

                                            <img v-bind:src="'/upload/news/' + value.photo" class="fit-image img-fluid" @error="imgUrlAlt" :alt="cat_name+'ニュース画像'">

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
                                  

                                    <p>{{value.title}}</p>

                                </div>

                            </div>
                            </router-link>
                            <div class="txt_date">{{value.created_at}}</div>
                        </div>
                        
                    </div>
                    <div class="small" v-for="(value,index) in group.slice(30, 34)" :key="index" >                  
                        <div class="small-b3"    :style="{'--color': value.color_code ? value.color_code : '#287db4'}">
                            <router-link  :to="'/newsdetails/'+value.id" >  
                            
                            <p class="text-truncate news-list-display news-list-display03">
                                <span class="sm_news_fa"><i class="fas fa-building"></i></span> 
                                <span class="sm_news_mp">
                                   {{value.title}}
                                </span>
                                <span class="sm_news_date">{{value.created_at}}</span>
                            </p>
                            </router-link>
                        </div>
                    </div>
                </div> 

                <div class="pad-new pattern-child group-2"  >
                    <div class="small" v-for="(value,index) in group.slice(34, 36)" :key="index" >
                        <div class="large-b0 m-b-5" v-if="index === 0">
                            <router-link :to="'/newsdetails/'+value.id" >
                                <div class="col-12 single-news-box">

                                    <clazy-load class="wrapper-3" @load="log" src="/images/noimage.jpg" :key="index" >

                                        <transition name="fade">

                                            <img v-bind:src="'/upload/news/' + value.photo" class="fit-image img-fluid" @error="imgUrlAlt" :alt="cat_name+'ニュース画像'">

                                        </transition>

                                        <transition name="fade" slot="placeholder">

                                            <div class="preloader">

                                                <div class="circle">

                                                <div class="circle-inner"></div>

                                                </div>

                                            </div>

                                        </transition>
                                    </clazy-load>
                                    <p> {{value.title}} </p>
                                </div>
                            </router-link>
                            <div class="txt_date">{{value.created_at}}</div>
                        </div>
                        <div class="small-b0" v-if="index === 1" :style="{'--color': value.color_code ? value.color_code : '#287db4'}">
                            <router-link  :to="'/newsdetails/'+value.id" >  
                            <p class="text-truncate news-list-display news-list-display03">

                                <span class="sm_news_fa"><i class="fas fa-building"></i></span> 
                                <span class="sm_news_mp">
                                   {{value.title}}
                                </span>
                                <span class="sm_news_date">{{value.created_at}}</span>
                            </p>
                            </router-link>
                        </div>
                    </div> 
                </div>                   
            </slick>
        </div>
    </div>  
    <!-- end layout design -->

    <div v-else-if="block && w_width <= 480" class="col-12 m-lr-0 p-0 moblie">
        <div  class="slick-news m-lr-0 bordertop-color">
            <slick  :options="slickOptions" class="news-slider-width" >
                <div v-for="(value,index) in big_news" :key="index" class="txt_align news-3-card">
                    <router-link :to="'/newsdetails/'+value.id" >
                        <div class="col-6  single-news-box single-news-slide">
                            <clazy-load class="wrapper-3" @load="log" src="/images/noimage.jpg" :key="index" >

                                <transition name="fade">

                                    <img v-bind:src="'/upload/news/' + value.photo" class="fit-image img-fluid" @error="imgUrlAlt" :alt="cat_name+'ニュース画像'">

                                </transition>   

                                <transition name="fade" slot="placeholder">

                                    <div class="preloader">

                                        <div class="circle">

                                        <div class="circle-inner"></div>

                                        </div>

                                    </div>

                                </transition>
                            </clazy-load>
                            <p> {{value.title}} </p>
                            
                        </div>
                    </router-link>
                    <div class="txt_date01">
                        <p v-if="value.new_news == '1'" class="second_para">{{value.date_only}}<span class="small_new">New</span></p>
                        <p v-else class="second_para">{{value.created_at}}</p>
                    </div>
                </div>
            </slick>
        </div>
        <div v-for="(group,index) in news" :key="index" class="slick-news row m-lr-0 bordertop-color tp_small_5">
            <!-- small block -->
            <router-link v-for="(value,index) in group[1]" :key="index" :to="'/newsdetails/'+value.id"  class="col-md-6 col-sm-6 col-lg-3 pad-new pad-new01"> 
                <p class="first_para">{{value.title}}</p>
                <p v-if="value.new_news == '1'" class="second_para">{{value.date_only}}<span class="small_new">New</span></p>
                <p v-else class="second_para">{{value.created_at}}</p>

            </router-link>
            <!-- medium block -->
            <div v-for="(value,index) in group[0]" :key="index" class="rectangle-medium01 m-b-8">
            <router-link :to="'/newsdetails/'+value.id" class="col-md-6 col-sm-6 col-lg-3 ">
                <div class="col-md-12 row adslist-card news-3-card m-0">

                    <div class="col-4 img-box">

                        <clazy-load class="wrapper-4" @load="log" src="/images/noimage.jpg" :key="index" >

                            <transition name="fade">

                                <img :src="'/upload/news/' + value.photo" class="fit-image img-fluid"  @error="imgUrlAlt" :alt="cat_name+'ニュース画像'">

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
                        <p>{{value.title}} </p>
                    </div>                   
                    <div class="txt_date">
                        <p v-if="value.new_news == '1'" class="second_para">{{value.date_only}}<span class="small_new">New</span></p>
                        <p v-else class="second_para">{{value.created_at}}</p>
                    </div>
                </div>
            </router-link>
            </div>
        </div> 
        <div id="more" class="slick-news m-lr-0 bordertop-color" >
            <div class="one" v-for="(more_value) in more_news">
                <div class="two" v-for="(value,index) in more_value" :key="index">
                    <div class="square-medium news-3-card m-b-5" v-if="index === 0"  >
                        <router-link :to="'/newsdetails/'+value.id" >
                            <div class="col-6  single-news-box single-news-slide">
                                <clazy-load class="wrapper-3" @load="log" src="/images/noimage.jpg" :key="index" >

                                    <transition name="fade">

                                        <img v-bind:src="'/upload/news/' + value.photo" class="fit-image img-fluid" @error="imgUrlAlt" :alt="cat_name+'ニュース画像'">

                                    </transition>   
                                   
                                    <transition name="fade" slot="placeholder">

                                        <div class="preloader">

                                            <div class="circle">

                                            <div class="circle-inner"></div>

                                            </div>

                                        </div>

                                    </transition>
                                </clazy-load>
                                <p>{{value.title}} </p>
                            </div>
                            <div class="txt_date01"><span>{{value.created_at}}</span></div>
                        </router-link>
                    </div>
                    <div class="square-small news-3-card m-b-5" v-if="index === 1">
                        <router-link :to="'/newsdetails/'+value.id"  class="col-md-6 col-sm-6 col-lg-3 pad-new"> 
                        <p class="text-truncate">
                           {{value.title}}
                        </p>
                        <div class="txt_date01"><span>{{value.created_at}}</span></div>
                        </router-link>
                    </div>
                    <div class="square-small news-3-card m-b-5" v-if="index === 2">
                        <router-link :to="'/newsdetails/'+value.id"  class="col-md-6 col-sm-6 col-lg-3 pad-new"> 
                        <p class="text-truncate ">
                           {{value.title}}
                        </p>
                        <div class="txt_date01"><span>{{value.created_at}}</span></div>
                        </router-link>
                    </div>
                    <div class="square-small news-3-card m-b-5" v-if="index === 3">
                        <router-link :to="'/newsdetails/'+value.id"  class="col-md-6 col-sm-6 col-lg-3 pad-new"> 
                        <p class="text-truncate ">
                           {{value.title}}
                        </p>
                        <div class="txt_date01"><span>{{value.created_at}}</span></div>
                        </router-link>
                    </div> 
                    <div class="rectangle-small news-3-card m-b-8" v-if="index === 4">
                        <router-link  :to="'/newsdetails/'+value.id"  class="col-md-6 col-sm-6 col-lg-3 pad-new "> 
                            <p class="first_para">{{value.title}}</p>
                            <p v-if="value.new_news == '1'" class="second_para">{{value.date_only}}<span class="small_new">New</span></p>
                            <p v-else class="second_para">{{value.created_at}}</p>
                        </router-link>
                    </div>
                    <div class="rectangle-small news-3-card m-b-8" v-if="index === 5">
                        <router-link  :to="'/newsdetails/'+value.id"  class="col-md-6 col-sm-6 col-lg-3 pad-new"> 
                            <p class="first_para">{{value.title}}</p>
                            <p v-if="value.new_news == '1'" class="second_para">{{value.date_only}}<span class="small_new">New</span></p>
                            <p v-else class="second_para">{{value.created_at}}</p>
                        </router-link>
                    </div>                    
                    <div class="square-small news-3-card m-b-5 square-small-left" v-if="index === 6">
                        <router-link :to="'/newsdetails/'+value.id"  class="col-md-6 col-sm-6 col-lg-3 pad-new"> 
                        <p class="text-truncate">
                           {{value.title}}
                        </p>
                        <div class="txt_date01"><span>{{value.created_at}}</span></div>
                        </router-link>
                    </div>
                    <div class="square-small news-3-card m-b-5 square-small-left" v-if="index === 8">
                        <router-link :to="'/newsdetails/'+value.id"  class="col-md-6 col-sm-6 col-lg-3 pad-new"> 
                        <p class="text-truncate ">
                           {{value.title}}
                        </p>
                        <div class="txt_date01"><span>{{value.created_at}}</span></div>
                        </router-link>
                    </div>
                    <div class="square-small news-3-card m-b-5 square-small-left" v-if="index === 9">
                        <router-link :to="'/newsdetails/'+value.id"  class="col-md-6 col-sm-6 col-lg-3 pad-new"> 
                        <p class="text-truncate ">
                           {{value.title}}
                        </p>
                        <div class="txt_date01"><span>{{value.created_at}}</span></div>
                        </router-link>
                    </div>
                    <div class="square-medium news-3-card square-medium-right m-b-5" v-if="index === 7"  >
                        <router-link :to="'/newsdetails/'+value.id" >
                            <div class="col-6  single-news-box single-news-slide">
                                <clazy-load class="wrapper-3" @load="log" src="/images/noimage.jpg" :key="index" >

                                    <transition name="fade">

                                        <img v-bind:src="'/upload/news/' + value.photo" class="fit-image img-fluid" @error="imgUrlAlt" :alt="cat_name+'ニュース画像'">

                                    </transition>   
                                   
                                    <transition name="fade" slot="placeholder">

                                        <div class="preloader">

                                            <div class="circle">

                                            <div class="circle-inner"></div>

                                            </div>

                                        </div>

                                    </transition>
                                </clazy-load>
                                <p>{{value.title}} </p>
                            </div>
                            <div class="txt_date01"><span>{{value.created_at}}</span></div>
                        </router-link>
                    </div>
                    <div class="rectangle-medium" v-if="index === 10"  >
                        <router-link  :to="'/newsdetails/'+value.id" class="col-md-6 col-sm-6 col-lg-3 m-b-8 pad-new">
                            <div class="col-md-12 row adslist-card news-3-card m-0">
                             
                                <div class="col-4 img-box">

                                    <clazy-load class="wrapper-4" @load="log" src="/images/noimage.jpg" :key="index" >

                                        <transition name="fade">
                                            <img :src="'/upload/news/' + value.photo" class="fit-image img-fluid"  @error="imgUrlAlt" :alt="cat_name+'ニュース画像'">
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
                                    <p>{{value.title}} </p>
                                </div>                   
                                    <div class="txt_date01">{{value.created_at}}</div>
                            </div> 
                        </router-link>
                    </div>
                    <div class="rectangle-medium" v-if="index === 11"  >
                        <router-link  :to="'/newsdetails/'+value.id" class="col-md-6 col-sm-6 col-lg-3 m-b-8 pad-new">
                            <div class="col-md-12 row adslist-card news-3-card m-0">

                                <div class="col-4 img-box">

                                    <clazy-load class="wrapper-4" @load="log" src="/images/noimage.jpg" :key="index" >

                                        <transition name="fade">
                                            <img :src="'/upload/news/' + value.photo" class="fit-image img-fluid"  @error="imgUrlAlt" :alt="cat_name+'ニュース画像'">
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
                                    <p>{{value.title}} </p>
                                </div>                   
                                    <div class="txt_date01">{{value.created_at}}</div>
                            </div>
                        </router-link>
                    </div>
                </div>
            </div>             
        </div>
    </div>
</div>
</layout>
</template>

<script>
    import layout from '../components/home.vue'
    import Slick from 'vue-slick'
    import{ eventBus } from '../event-bus.js';
export default{

 components:{
    layout,
    Slick
  },
  el:"#more",
   data(){

        return{
            news:[],
            more_news:[],
            big_news:[], 
            cat_name:'',
            color_code: '#287db4',
            cat_id:'',  
            block:false, 
            w_width: $(window).width(),   
            norecord_msg: false, 
        }
    },
    mounted(){ },
    created(){
        if($(window).width() > 480){
             this.axios.get(`/api/newscategory/${this.$route.params.id}`).then(response =>{
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
                this.cat_name = response.data.cat.name;
                if(response.data.cat.color_code){
                this.color_code = response.data.cat.color_code;
                }
                eventBus.$emit('gotColor', this.color_code);
              
          });
        }else{
            this.axios.get(`/api/newscategorymobile/${this.$route.params.id}`).then(response =>{
                this.news = response.data.newslist;
                this.big_news = response.data.bigNews;
                this.more_news = response.data.moreNews;
                if(response.data.newslist.length == 0 && response.data.bigNews.length == 0)
               {
                     this.norecord_msg = true;
                }
                else{
                     this.block = true;
                     this.norecord_msg = false;
                } 
                this.cat_name = response.data.cat.name;
                if(response.data.cat.color_code){
                this.color_code = response.data.cat.color_code;
                }
                eventBus.$emit('gotColor', this.color_code);
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
        useStyle (){
            return{
            '--title-color': this.color_code
            }
        },
        slickOptions(){
                return{
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
                        settings:{
                            slidesToShow: 3,                           
                            slidesToScroll: 1,  
                            infinite:false 
                        }
                    },{
                    breakpoint: 1024,
                        settings:{
                            slidesToShow: 3,
                            slidesToScroll: 1, 
                            infinite: false                           
                        }
                    },{
                    breakpoint: 770,
                        settings:{
                            slidesToShow: 2,
                            slidesToScroll: 1, 
                            infinite: false                           
                        }
                    },{
                        breakpoint: 420,
                            settings:{
                                slidesToShow: 2,
                                slidesToScroll:1,
                                infinite: false
                            }
                    },{
                    breakpoint: 481,
                    settings:{
                        slidesToShow: 2,
                    }
                }]                    
                }
        }
    },
   methods:{
            next(){
                this.$refs.slick.next();
            },
            prev(){
                this.$refs.slick.prev();
            },
            reInit(){
                // Helpful if you have to deal with v-for to update dynamic lists
                this.$nextTick(() =>{
                    this.$refs.slick.reSlick();
                });
            },
            imgUrlAlt(event){
                            event.target.src = "/images/noimage.jpg"
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
.clearfix:after{ 
   content: "."; 
   visibility: hidden; 
   display: block; 
   height: 0; 
   clear: both;
}
.bordertop-color{
    border-top: 0px !important;
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
}
.news-list-display03{
    padding: 5.7px 10px;
}
.news-3-card .img-box{
    padding-left: 10px;
}
.single-news-box{
    background: #f7f7f7;
    height: 310px;
    padding: 10px;
    border:solid #f3efef;
    border-width: 0 1px 1px 0;
    overflow: hidden;
    box-sizing: border-box;
}
.single-news-slide{
    max-width: 100%;
}
.single-news-large{
    float: left;
}
 #slick-slide10{
    width: 170px !important;
}
.arr-btn{
    cursor: pointer;
    display: inline-flex;
    display: -webkit-inline-flex;
    display: -ms-inline-flex;
    background:transparent;
    padding: 5px 1px 4px;
    font-size: 25px;
}
.left-arr-btn{
    position: relative;     
    left: -20px;
    width: 2%;
}
.right-arr-btn{
    position: relative;      
    right: -47px;
    width: 2%;
}
#myTab ul li{
    display: -ms-inline-flexbox;
    display: inline-flex;
    display: -webkit-inline-flex;
}
.nav{
    flex-wrap: nowrap;
}
.center{
    overflow: hidden;
    white-space: nowrap;
    display: inline-block;
}
.card-header-tabs{
    margin-right: -1.65rem;
    margin-left: -1.65rem;
    border-bottom: 0;
}
.cat_slider{
    width: 99%;
    margin: 0 auto 1.65rem;
    padding-left: 0!important;
}

.cat_slider #myTab{
    margin: 0 auto;
}

.cat-nav{
    padding-bottom: 0;
    height: 36px;
    display: flex;
}

.cat_slider .nav-tabs .nav-item .nav-link{
     padding: 0.3rem 1rem;
}
.left-arr-btn{
    width: 1.5%;
    position: relative;
    left: 4px;
    bottom: 10px;
   
}
.right-arr-btn{
    position: relative;      
    width: 1.5%;
    left: 10px;
    bottom: 10px;
}
#top{
    border-left: 1px solid #fff;
}
.nav-tabs{
    border-bottom: none;
}
#myTab .router-link-exact-active{
    height: 36px;
    color: #fff !important;
    background-color: #828282;
    border: none !important;
}
.head-news .adslist-card{
    background: #f7f7f7;
    height: 100px;
}
.wrapper-4{
    padding-bottom: 79px;
}
.wrapper-4 img{
    width: 100%;
}
.btn_more{
    background-color: #287db4; 
    padding: 5px 30px; 
    border-radius: 0;
    border: none;
    min-width: 150px;
    color: white;
}
.btn_more:hover{
    background-color: #56a4d6; 
}
.btn_more .fas{
    font-size: 20px;
    vertical-align: middle;
}
#more .pad-new{
    width: 25%;
}
.head-btn{
    margin-top: 8px;
}
.slick-next, .slick-prev{
    border: 1px solid #807777;
    outline: none;
    background: #f7f7f7;
    border-radius: 50%;
    box-shadow: 0 0 0 1px rgba(0,0,0,0.04), 0 4px 8px 0 rgba(0,0,0,0.20);
}  
.slick-next::before{
    border-width: .2rem .2rem 0 0;
    height: 9px;
    width: 9px;  
}
.slick-prev::before{
    border-width: .2rem .2rem 0 0;
    height: 9px;
    width: 9px;
}
.medium-b3{
    height: 100px;
    margin-bottom: 5px;
}
.large-b0 .single-news-box .wrapper-3{
    height: 73%;
}
.large-b0 .single-news-box p{
    line-height: 1.3rem;
    -webkit-line-clamp: 3;
    height: 60px;
    margin-top: 6px;
}
.large-b0 .txt_date .second_para .small_new,.medium-b1 .txt_date .second_para .small_new,
.medium-b3 .txt_date .second_para .small_new {
    margin-left: 5px;
    float: right;
    border-radius: 1px;
    padding: 0px 6px 0px 6px;
    height: 18px;
    font-size: 10px;
    background-color: red;
    color: white;
}
.medium-b1 .second_para{
    height: auto;
}
.medium-b1 .pattern-txt-box p, .medium-b3 .pattern-txt-box p{
    line-height: 1.5em!important;
    -webkit-line-clamp: 3;
    height: 70px;
}
.bordertop-color i{
    color: var(--color);
}
.profile-tit{
    color: var(--title-color);
    border-bottom: 1px dashed var(--title-color);
}
.large-b0, .medium-b1, .medium-b3{
    position: relative;
}
.txt_date{
    font-size: 12px;
    text-align:right;
    position: absolute;
    bottom: 0; 
    right: 10px;
    color:#969798;
}
.single-news-box > p,
.pattern-txt-box p{
    line-height: 1.9em;
    overflow: hidden;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
    text-overflow: ellipsis;
}
.txt_align{
    position: relative;
}
.sm_news_new{
    border-radius: 1px;
    padding: 0 6px 0px 6px;
    font-size: 10px;
    background-color: red;
    color: white;
    float: right; 
}
.second_para{
    font-size: 12px;
    float: right;
    color: #969798;
    font-weight: normal!important;;
}
.second_para .sm_news_new{
    margin-left: 5px;
}
.sm_news_fa{
    float: left;
}
.sm_news_mp{
    width: 70%;
    float: left;
    max-height: 20px;
    overflow: hidden;
    padding: 0 0 0 5px;
    display: -webkit-box;
    -webkit-line-clamp: 1;
    -webkit-box-orient: vertical;
    overflow: hidden;
    text-overflow: ellipsis;
}
.sm_news_date{
    color: #969798;
    float: right;
}
.text-truncate{
    white-space: unset;
}
 .more_news p{ 
    height: 51px; 
}
.medium-b1 p,.medium-b3 p{
    max-height: 41px;
}
.medium p{
    height: auto;
}
.moblie p{
    font-weight: bold;
}
@media only screen and (max-width:767px) {
    .txt_align{
        margin-top: 10px;
    }
    .cat_title{ 
        padding: 0 5px;
    }
    .cat-nav{
        padding-left: 0 !important;
        height: auto !important;
    }
    .single-news-box{
        height: 200px;
        border: none;
        background: none;
        padding: 0px;
    }
    .single-news-box .wrapper-3 img{
        width: 100%;
        height: 100%;
        object-fit: contain;
    }
    .txt_align .single-news-box .wrapper-3{
        max-height: 140px;
    }
    .txt_align .single-news-box p{
        padding: 5px;
        background: #f7f7f7;
    }
    .txt_align .single-news-box .wrapper-3 img{
        max-height: 140px;
        min-height: 140px;
        background: #fff;
    }
    .txt_align a 
    .m_top_left{
        left: 8px;
    }
    .small_new{
        margin-left: 5px;
        float: right;
        border-radius: 1px;
        padding: 0px 6px 0px 6px;
        font-size: 10px;
        background-color: red;
        color: white;
    }
    .txt_align .txt_date01{
        background: #f7f7f7;
    }
    #more .pad-new{
        width: 100%;
        display: inline-block;
    }
    .pad-new{
        width: 100%;
        display: inline-block;
        margin-bottom: 5px;
    }
    .news-3-card{
        background: #f7f7f7;
        border: solid #f3efef;
        border-width: 0 1px 1px 0;
    }
    .txt_align.news-3-card{
        margin-bottom: 5px;
        width: 96% !important;
        border: 1px solid #f3efef;
    }
    .slick-active .txt_align.news-3-card:first-child{
        width: 96% !important;
    }
    .txt_date_bg{
        padding-left: 3px;
        background: white;
    }
    .txt_date{
        bottom: -2px !important;
    }
    .text-truncate{
        line-height: 1.5em;
        white-space: normal;
        background: none;
        border: none;
    }
    .news-list-display{
        padding:0;
        padding-left: 33px;
        margin-top: 5px;
    }
    .pad-new01{
        height: 35px;
        background: #f7f7f7;
        border: solid #f3efef;
        border-width: 0 1px 1px 0;
    }
    .rectangle-medium01{
        width: 100%;
        margin-bottom: 10px;
    }
    .rectangle-medium a,
    .rectangle-medium01 a{
        display: inline-block;
        padding: 0 !important;
    }
    .rectangle-medium01 .news-3-card .pattern-txt-box p{
        -webkit-line-clamp: 3;
    }
    .square-medium{
        float: left;
        width: 49%;
        margin-bottom: 10px;
    }
    .square-medium .single-news-box .wrapper-3{
        border: 1px solid #f3efef;
        background-color: #fff;
        max-height: 150px;
    }
    .square-medium .single-news-box .wrapper-3 img{
        max-height: 150px;
        min-height: 150px;
    }
    .square-medium .single-news-box p{
        padding: 0 5px;
        line-height: 1.7em;
        max-height: 50px;
    }
    .square-small{
        float: right;
        width: 49%;
        height:70px;
    }
    .square-small p{
        overflow: hidden;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        text-overflow: ellipsis;
    }
     .square-small .text-truncate{margin-top: 7px;} 

    .rectangle-small{
        display: inline-block;
        width: 100%;
    }
    .text-truncate.news-list-display{
        overflow: hidden;
        display: -webkit-box;
        -webkit-line-clamp: 1;
        -webkit-box-orient: vertical;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .square-small-left{
        float: left;
    }
    .square-medium-right{
        float: right;
    }
    .rectangle-medium .txt_date01{
        position: absolute;
        right: 10px;
        bottom: 0;
    }
    .square-medium ‌a .txt_date01{
        position: relative;
        right: 8px;
    }
    .txt_date01{
        position: none !important;
        font-size: 12px;
        text-align: right;
        color: #969798;
    }
   
    .text-truncate.news-list-display{
        padding-left: 0;
    }
    .first_para{
        float: left;
        overflow: hidden;
        white-space: nowrap;
        text-overflow: ellipsis;
        max-width: 267px;
        margin-top: 2px;
    }
    .second_para{
        margin-top: 4px;
    }
    .rectangle-small{
        margin-bottom: 5px;
        height: 35px;
    }
    .rectangle-small  a{
        padding: 3px 2px;
        margin-bottom: 0;
    }
    .rectangle-small a .text-truncate{
        position: relative;
        top: 18px;
        margin: 0;
    }
    .rectangle-small a .txt_date01{
        position: relative;
        top: 19px;
    }
    .tp_small_5 a{
        height: 35px;
        padding: 4px 2px;
    }
    .single-news-box p, .tp_small_5 a p.first_para, .rectangle-medium01 a .pattern-txt-box p,.rectangle-medium p, .rectangle-small a p.first_para, .square-small p{
        font-weight: bold;
    }
    .txt_align a .single-news-box{
        height: 187px;
    }
    .txt_align .single-news-box p{
        max-height: 45px;
        line-height: 1.3rem;
    }
}

@media only screen and (min-width:768px) and (max-width:1024px){
    #more .pad-new{
        width: 50%;
    }
    .slick-slider{
        margin-bottom: 0;
    }
}
@media only screen and (min-width:767px){
    .news-list-display{
        max-height: 30px;
    }
}
</style> 
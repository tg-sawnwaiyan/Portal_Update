<template>
    <layout>
        <div class="m-lr-0 justify-content-md-center  category_margin">
            <div class="">
                <div class="row m-lr-0">
                    <div class="col-md-12 m-lr-0 p-0">
                        <!-- <form class="col-lg-12 mb-2 pad-free"> -->
                        <div style="display: none;" class="row col-md-12 m-lr-0 p-0" v-if="!latest_post_null">
                            <div class="col-sm-12 pad-new col-lg-8 m-b-15 newssearch-width">
                                <!--search input-->
                                <div class="search-input">
                                    <span class="btn btn col-md-12 my-sm-0 danger-bg-color btn-danger cross-btn" v-if="status == 1" @click="clearSearch()">X</span>
                                    <input typee="text" class="searchNews" placeholder="ニュース検索" id="search-free-word" v-bind:value="search_word">
                                    <button type="submit" class="searchButtonNews" @click="searchCategory()">
                                        <i class="fas fa-search"></i> 検索
                                    </button>
                                </div>                                    
                            </div>
                        </div>
                        <!-- </form> -->
                        <slick  v-if="latest_post_all_cats.length > 0 && status == '0'" ref="slick" :options="categoryslider" class="cat-slider d-block d-sm-none">  
                            <div class="list-group-item adslist-card m-b-10"  v-for="latest_post_all_cat in latest_post_all_cats" :key="latest_post_all_cat.id">
                                 <router-link :to="{path:'/newsdetails/'+latest_post_all_cat.id}">
                                    <div class="slide-img" style="border:1px solid #eee;">
                                       <div class="col-sm-6 pad-free" >

                                            <div class="col-md-12 row m-0 pad-free">

                                                <div class="hovereffect fit-image">

                                                <div class="wrapper-1" @load="log"  src="/images/noimage.jpg" :key="latest_post_all_cat.id">

                                                    <transition name="fade">

                                                        <img :src="'/upload/news/' + latest_post_all_cat.photo " :alt="latest_post_all_cat.cname+'ニュース画像'" class="img-responsive fit-image" @error="imgUrlAlt">

                                                    </transition>
                                                    <!-- <div v-if="latest_post_all_cat.new_news == '1'" class="m_top_left"><span>New</span></div> -->

                                                    <!-- <img class="img-responsive fit-image" :src="'/upload/news/' + latest_post_all_cat.photo " alt="" @error="imgUrlAlt"> -->

                                                    <!-- <transition name="fade" slot="placeholder">
                                                    <div class="preloader">
                                                        <div class="circle">
                                                        <div class="circle-inner"></div>
                                                        </div>
                                                    </div>
                                                    </transition> -->

                                                </div>

                                                    <!-- <div class="overlay">
                                                        <router-link class="btn btn-sm all-btn secondary-bg-color m-t-20" :to="'/newsdetails/'+ latest_post_all_cat.id">詳細</router-link>
                                                    </div> -->

                                                    <div class="info">

                                                        <div class="col-12" style="border:none;">

                                                            <p class=" p_3">
                                                                <span v-if="latest_post_all_cat.category_id == 26" class="breaking-tip">PR</span>

                                                                {{ latest_post_all_cat.title }}

                                                            </p>

                                                        </div>

                                                    </div>
                                                    <!-- <div class="txt_date txt_color">{{latest_post_all_cat.created_at}}
                                                        
                                                    </div> -->

                                                </div>

                                            </div>

                                        </div>
                                    </div>

                                 </router-link>   
                            </div>

                        </slick>
                       <!-- slider -->
                        
                        <div class="row col-12 m-lr-0 p-0" v-if="status == '0' && !latest_post_null" id="view-1024">
                            <!-- category box -->
                            <div class="card col-sm-6 col-lg-3 pad-new d-none d-sm-block first-child" style="border:0px!important;">
                                <div class="tab-content tab-content2 scroll2" id="myTabContent">
                                    <div class="tab-pane fade show active p-1" id="one" role="tabpanel" aria-labelledby="one-tab" style="height: 100%;">
                                        <div class="row" style="height: 100%;">
                                            <div class="active-users col-md-12 col-sm-12">
                                                <router-link :to="'/newsdetails/'+latest_post.id">
                                                 <clazy-load class="wrapper-0" @load="log"  src="/images/noimage.jpg" :key="latest_post.id">
                                                    <transition name="fade"> 
                                                        <img v-bind:src="'/upload/news/' + latest_post.photo" :alt="latest_catName+'ニュース画像'" class="source-img img-responsive"  @error="imgUrlAlt">
                                                    </transition>
                                                    <!-- <div v-if="latest_post.new_news == '1'" class="m_top_left"><span>New</span></div> -->
                                                    <transition name="fade" slot="placeholder">
                                                        <div class="preloader">
                                                            <div class="circle">
                                                            <div class="circle-inner"></div>
                                                            </div>
                                                        </div>
                                                    </transition>
                                                 </clazy-load>
                                                    <p class="source-title" v-if="latest_post.title" aria-label="">{{ latest_post.title }}</p>
                                                    <span class="source-subtitle" v-if="latest_post.created_at"> 
                                                        <p v-if="latest_post.new_news == '1'" class="second_para"><img v-if="latest_post.created_at" alt="" src="/images/5.png" class="source-img" @error="imgUrlAlt">{{latest_post.created_at}}<span class="small_new">New</span></p>
                                                        <p v-else class="second_para"><img v-if="latest_post.created_at" alt="" src="/images/5.png" class="source-img" @error="imgUrlAlt">{{latest_post.created_at}}</p>
                                                    </span>
                                                </router-link>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card col-sm-6 col-lg-3 pad-new d-none d-sm-block first-child" style="border:0px!important;">
                                <!-- <div class="tab-content tab-content2 scroll2" id="myTabContent2"> -->
                                   <!--  <div class="tab-pane fade show active p-1" id="one" role="tabpanel" aria-labelledby="one-tab"> -->
                                        <!-- <div class="row"> -->
                                            <!-- <div class="col-md-12 col-sm-12 news-wrapper" style="padding: 0 5px;"> -->
                                                <ul class="list-group list-group-flush all-item">
                                                    <li v-for="post in posts" :key="post.id" class="list-group-item" style="padding:1px 0px 1px 0px!important; border: none; background: none;"  v-if = "posts[0].id != post.id">
                                                        <router-link :to="{path:'/newsdetails/'+post.id}" class="display_align">
                                                            <p class="text-truncate news-list-display" style="height: 34.5px;">
                                                                <span class="sm_news_fa"><i class="fas fa-building" style="color: #d1281c;"></i></span> 
                                                                <span class="sm_news_mp" style="max-width: 65%;">
                                                                    {{ post.title }}
                                                                </span>
                                                                <span v-if="post.new_news == '1'" class="sm_news_date">{{post.created_at}}<em class="small_new">New</em></span>
                                                                <span v-else class="sm_news_date">{{post.created_at}}</span>
                                                            </p>
                                                            <!-- <span class="source-img-small d-inline-block text-truncate top_sm_news">
                                                                <span v-if="post.new_news == '1'" class="s_top_left">New</span>
                                                                {{ post.title }}
                                                            </span> -->
                                                        </router-link>
                                                    </li>
                                                </ul>
                                            <!-- </div> -->
                                        <!-- </div> -->
                                    <!-- </div> -->
                                <!-- </div> -->
                            </div>
                            <!-- end category box -->

                            <!-- category right side -->
                            <div class="col-md-12 col-lg-6 pad-free last-child  d-none d-sm-block">
                                <div class="" v-if="status =='0'">
                                    <!-- two show () aaaaaaaaa-->  
                                   
                                    <div v-if="(w_width >= 1280) || (w_width <= 768 && w_width >= 480)" class="row col-sm-12 p-lr-0 m-0">
                                        <!-- <div class="col-sm-6 m-b-8 pad-new" v-for="item in latest_post_all_cats.slice(0, 8)"  :key="item.id"> -->
                                        <div class="col-sm-6 m-b-8 pad-new" v-for="item in latest_post_all_cats.slice(0, 6)"  :key="item.id">
                                            <div class="col-md-12 row adslist-card news-3-card m-0" :class="item.category_id == 26?'break-news':''">
                                                

                                                <div class="col-md-4 col-sm-4 img-box">     

                                                    <router-link :to="'/newsdetails/'+item.id">

                                                        <clazy-load class="wrapper-4 medium-img" @load="log" src="/images/noimage.jpg" :key="item.id" :alt="item.cname+'ニュース画像'">

                                                            <transition name="fade">

                                                                <img :src="'/upload/news/' + item.photo"  class="fit-image-0"  @error="imgUrlAlt" :alt="item.cname+'ニュース画像'">


                                                            </transition>
                                                            <!-- <div v-if="item.new_news == '1'" class="m_top_left"><span>New</span></div> -->

                                                            <!-- <img v-bind:src="'/upload/news/' + item.photo" class="fit-image" style="height:5rem;width:6rem" @error="imgUrlAlt"> -->

                                                            <transition name="fade" slot="placeholder">

                                                                <div class="preloader">

                                                                    <div class="circle">

                                                                    <div class="circle-inner"></div>

                                                                    </div>

                                                                </div>

                                                            </transition>

                                                        </clazy-load>

                                                    </router-link>
                                                    <span v-if="item.category_id == 26" class="breaking-tip for-read-more" style="bottom:0px;">PR</span>
                                                    <span v-else :style="{'--bkgColor': item.color_code ? item.color_code : '#287db4'}" class="tab_title_color for-read-more black_color">
                                                        <span>{{item.cname}}</span>
                                                        
                                                    </span>
                                                </div>
                                                


                                                <div class="col-md-8 col-sm-8 txt-box">                                                   
                                                    
                                                    <router-link :to="'/newsdetails/'+item.id">
                                                        <!-- <span> {{item.title}} </span> -->
                                                        <!-- <read-more more-str="" less-str="read less"  :max-chars="37" :text="item.title"></read-more> -->
                                                        <p class="medium_text">{{item.title}}</p>
                                                    </router-link>
                                                    <span class="tab_title_date tab_title_d">
                                                        <p v-if="item.new_news == '1'" class="second_para"><span class="small_new">New</span>{{item.created_at}}<!-- {{item.date_only}} --></p>
                                                        <p v-else class="second_para">{{item.created_at}}</p>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- one show -->
                                    <div v-if="(w_width < 1280 && w_width > 768) || (w_width < 480)" class="row col-sm-12 p-lr-0 m-0">
                                        <div class="col-sm-12 m-b-8 pad-new" v-for="item in latest_post_all_cats.slice(0, 4)"  :key="item.id">
                                            <div class="col-md-12 row adslist-card news-3-card m-0" :class="item.category_id == 26?'break-news':''">
                                                

                                                <div class="col-md-4 img-box">

                                                    <router-link :to="'/newsdetails/'+item.id">

                                                        <clazy-load class="wrapper-4" @load="log" src="/images/noimage.jpg" :key="item.id" :alt="item.cname+'ニュース画像'">

                                                            <transition name="fade">

                                                                <img :src="'/upload/news/' + item.photo"  :alt="item.cname+'ニュース画像'" class="fit-image-0"  @error="imgUrlAlt">

                                                            </transition>
                                                            <div v-if="item.new_news == '1'" class="m_top_left"><span>New</span></div>

                                                            <!-- <img v-bind:src="'/upload/news/' + item.photo" class="fit-image" style="height:5rem;width:6rem" @error="imgUrlAlt"> -->

                                                            <transition name="fade" slot="placeholder">

                                                                <div class="preloader">

                                                                    <div class="circle">

                                                                    <div class="circle-inner"></div>

                                                                    </div>

                                                                </div>

                                                            </transition>

                                                        </clazy-load>

                                                    </router-link>

                                                </div>



                                                <div class="col-md-8 txt-box">
                                                    
                                                    <router-link :to="'/newsdetails/'+item.id">
                                                        <!-- <span> {{item.title}} </span> -->
                                                        <!-- <read-more more-str="" less-str="read less"  :max-chars="25" :text="item.title"></read-more> -->
                                                        <p class="medium_text">{{item.title}}</p>
                                                    </router-link>
                                                    <span v-if="item.category_id == 26" class="breaking-tip for-read-more" style="bottom:0px;">PR</span>
                                                    <span v-else :style="{'--bkgColor': item.color_code ? item.color_code : '#287db4'}" class="tab_title_color for-read-more black_color"><span>{{item.cname}}</span></span>                                                
                                                    <span class="tab_title_date tab_title_d">{{item.created_at}}
                                                    </span>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- end category right side -->
                        </div>
                    </div>

                    <!-- category bottom -->
                    <div class="col-md-12 m-lr-0 p-0 d-none d-sm-block" v-if="status == '0'">
                        <!-- two show -->
                        <div class="row col-12 m-lr-0 p-0" v-if="(w_width >= 1280) || (w_width <= 768 && w_width >= 480)">
                            <div class="col-md-6 col-sm-6 col-lg-3 m-b-8 pad-new" v-for="item in latest_post_all_cats.slice(8, 16)"  :key="item.id">
                                <div class="col-md-12 row adslist-card news-3-card m-0" :class="item.category_id == 26?'break-news':''">
                                     

                                    <div class="col-md-4 col-sm-4 img-box">

                                        <router-link :to="'/newsdetails/'+item.id">

                                            <clazy-load class="wrapper-4 medium-img" @load="log"  src="/images/noimage.jpg" :key="item.id">

                                                <!-- <img v-bind:src="'/upload/news/' + item.photo" class="fit-image" style="height:5rem;width:6rem" @error="imgUrlAlt"> -->

                                                <transition name="fade">

                                                    <img v-bind:src="'/upload/news/' + item.photo" class="fit-image-0" @error="imgUrlAlt" :alt="item.cname+'ニュース画像'">

                                                </transition>
                                                <!-- <div v-if="item.new_news == '1'" class="m_top_left"><span>New</span></div> -->

                                                <transition name="fade" slot="placeholder">

                                                    <div class="preloader">

                                                        <div class="circle">

                                                        <div class="circle-inner"></div>

                                                        </div>

                                                    </div>

                                                </transition>

                                            </clazy-load>

                                        </router-link>
                                        
                                        <span v-if="item.category_id == 26" class="breaking-tip for-read-more" style="bottom:0px;">PR</span>
                                        <span v-else :style="{'--bkgColor': item.color_code ? item.color_code : '#287db4'}" class="tab_title_color for-read-more black_color">
                                            <span>{{item.cname}}</span>
                                        </span>
                                    </div>



                                    <div class="col-md-8 col-sm-8 txt-box">                                        
                                        
                                        <router-link :to="'/newsdetails/'+item.id">
                                            <!-- <span> {{item.title}} </span> -->
                                            <!-- <read-more more-str="" less-str="read less"  :max-chars="37" :text="item.title"></read-more> -->
                                            <p class="medium_text">{{item.title}}</p>
                                        </router-link>
                                        <span class="tab_title_date tab_title_d">
                                            <p v-if="item.new_news == '1'" class="second_para"><span class="small_new">New</span>{{item.created_at}}<!-- {{item.date_only}} --></p>
                                            <p v-else class="second_para">{{item.created_at}}</p>
                                        </span>
                                    </div>

                                </div>
                            </div>
                        </div>
                        
                        <!-- one show -->
                        <div class="row col-md-12 pad-free m-0" v-if="(w_width < 1280 && w_width > 768) || (w_width < 480)">
                            <div class="col-md-4 m-b-8 pad-new" v-for="item in latest_post_all_cats.slice(4, 10)"  :key="item.id">
                                <div class="col-md-12 row adslist-card news-3-card m-0" :class="item.category_id == 26?'break-news':''">

                                    <div class="col-md-4 img-box">

                                        <router-link :to="'/newsdetails/'+item.id">

                                        <clazy-load class="wrapper-4" @load="log"  src="/images/noimage.jpg" :key="item.id">

                                            <!-- <img v-bind:src="'/upload/news/' + item.photo" class="fit-image" style="height:5rem;width:6rem" @error="imgUrlAlt"> -->

                                            <transition name="fade">

                                                <img v-bind:src="'/upload/news/' + item.photo" class="fit-image-0" @error="imgUrlAlt" :alt="item.cname+'ニュース画像'">

                                            </transition>
                                            <div v-if="item.new_news == '1'" class="m_top_left"><span>New</span></div>

                                            <transition name="fade" slot="placeholder">

                                                <div class="preloader">

                                                    <div class="circle">

                                                    <div class="circle-inner"></div>

                                                    </div>

                                                </div>

                                            </transition>

                                        </clazy-load>

                                        </router-link>

                                    </div>



                                    <div class="col-md-8 txt-box">
                                    
                                    <router-link :to="'/newsdetails/'+item.id">
                                        <!-- <span> {{item.title}} </span> -->
                                        <read-more more-str="" less-str="read less"  :max-chars="25" :text="item.title"></read-more>
                                    </router-link>
                                    <span v-if="item.category_id == 26" class="breaking-tip for-read-more" style="bottom:0px;">PR</span>
                                    <span v-else :style="{'--bkgColor': item.color_code ? item.color_code : '#287db4'}" class="tab_title_color for-read-more black_color"><span>{{item.cname}}</span></span>
                                    <span class="tab_title_date tab_title_d">
                                        {{item.created_at}}
                                    </span>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end category bottom -->
                </div>
            </div>
        </div>

        <!-- </div> -->
        <div>
            <span v-if="norecord_msg">
                <div class="container-fuid no_search_data">
                   <!-- <svg x="0px" y="0px" width="60" height="60" viewBox="0 0 172 172" style=" fill:#000000;"><g transform=""><g fill="none" fill-rule="nonzero" stroke="none" stroke-width="1" stroke-linecap="butt" stroke-linejoin="miter" stroke-miterlimit="10" stroke-dasharray="" stroke-dashoffset="0" font-family="none" font-weight="none" font-size="none" text-anchor="none" style="mix-blend-mode: normal"><path d="M0,172v-172h172v172z" fill="none"></path><path d="M86,172c-47.49649,0 -86,-38.50351 -86,-86v0c0,-47.49649 38.50351,-86 86,-86v0c47.49649,0 86,38.50351 86,86v0c0,47.49649 -38.50351,86 -86,86z" fill="none"></path><path d="M86,168.56c-45.59663,0 -82.56,-36.96337 -82.56,-82.56v0c0,-45.59663 36.96337,-82.56 82.56,-82.56v0c45.59663,0 82.56,36.96337 82.56,82.56v0c0,45.59663 -36.96337,82.56 -82.56,82.56z" fill="none"></path><path d="M0,172v-172h172v172z" fill="none"></path><path d="M3.44,168.56v-165.12h165.12v165.12z" fill="none"></path><path d="M86,172c-47.49649,0 -86,-38.50351 -86,-86v0c0,-47.49649 38.50351,-86 86,-86v0c47.49649,0 86,38.50351 86,86v0c0,47.49649 -38.50351,86 -86,86z" fill="none"></path><path d="M86,168.56c-45.59663,0 -82.56,-36.96337 -82.56,-82.56v0c0,-45.59663 36.96337,-82.56 82.56,-82.56v0c45.59663,0 82.56,36.96337 82.56,82.56v0c0,45.59663 -36.96337,82.56 -82.56,82.56z" fill="none"></path><path d="M0,172v-172h172v172z" fill="none"></path><path d="M3.44,168.56v-165.12h165.12v165.12z" fill="none"></path><path d="M86,172c-47.49649,0 -86,-38.50351 -86,-86v0c0,-47.49649 38.50351,-86 86,-86v0c47.49649,0 86,38.50351 86,86v0c0,47.49649 -38.50351,86 -86,86z" fill="none"></path><path d="M86,168.56c-45.59663,0 -82.56,-36.96337 -82.56,-82.56v0c0,-45.59663 36.96337,-82.56 82.56,-82.56v0c45.59663,0 82.56,36.96337 82.56,82.56v0c0,45.59663 -36.96337,82.56 -82.56,82.56z" fill="none"></path><g fill="#cccccc"><path d="M74.53333,17.2c-31.59643,0 -57.33333,25.73692 -57.33333,57.33333c0,31.59641 25.7369,57.33333 57.33333,57.33333c13.73998,0 26.35834,-4.87915 36.24766,-12.97839l34.23203,34.23203c1.43802,1.49778 3.5734,2.10113 5.5826,1.57735c2.0092,-0.52378 3.57826,-2.09284 4.10204,-4.10204c0.52378,-2.0092 -0.07957,-4.14458 -1.57735,-5.5826l-34.23203,-34.23203c8.09923,-9.88932 12.97839,-22.50768 12.97839,-36.24766c0,-31.59641 -25.7369,-57.33333 -57.33333,-57.33333zM74.53333,28.66667c25.39939,0 45.86667,20.46729 45.86667,45.86667c0,25.39937 -20.46728,45.86667 -45.86667,45.86667c-25.39939,0 -45.86667,-20.46729 -45.86667,-45.86667c0,-25.39937 20.46728,-45.86667 45.86667,-45.86667zM91.67734,51.52161c-1.51229,0.03575 -2.94918,0.66766 -3.99765,1.75807l-13.14636,13.14636l-13.14636,-13.14636c-1.07942,-1.10959 -2.56162,-1.73559 -4.10963,-1.73568c-2.33303,0.00061 -4.43306,1.41473 -5.31096,3.57628c-0.8779,2.16155 -0.3586,4.6395 1.31331,6.26669l13.14636,13.14636l-13.14636,13.14636c-1.49777,1.43802 -2.10111,3.5734 -1.57733,5.58259c0.52378,2.0092 2.09283,3.57825 4.10203,4.10203c2.0092,0.52378 4.14457,-0.07956 5.58259,-1.57733l13.14636,-13.14636l13.14636,13.14636c1.43802,1.49778 3.5734,2.10113 5.5826,1.57735c2.0092,-0.52378 3.57826,-2.09284 4.10204,-4.10204c0.52378,-2.0092 -0.07957,-4.14458 -1.57735,-5.5826l-13.14636,-13.14636l13.14636,-13.14636c1.70419,-1.63875 2.22781,-4.1555 1.31865,-6.33798c-0.90916,-2.18248 -3.06468,-3.58317 -5.42829,-3.52739z"></path></g></g></g></svg>
                    <br><br>
                    申し訳ありませんが、検索結果がありませんでした。 -->
                    <p class="nosearch-icon">
                        <svg x="0px" y="0px" width="30" height="30" viewBox="0 0 172 172" style=" fill:red;"><g transform=""><g fill="none" fill-rule="nonzero" stroke="none" stroke-width="1" stroke-linecap="butt" stroke-linejoin="miter" stroke-miterlimit="10" stroke-dasharray="" stroke-dashoffset="0" font-family="none" font-weight="none" font-size="none" text-anchor="none" style="mix-blend-mode: normal"><path d="M0,172v-172h172v172z" fill="none"></path><path d="M86,172c-47.49649,0 -86,-38.50351 -86,-86v0c0,-47.49649 38.50351,-86 86,-86v0c47.49649,0 86,38.50351 86,86v0c0,47.49649 -38.50351,86 -86,86z" fill="none"></path><path d="M86,168.56c-45.59663,0 -82.56,-36.96337 -82.56,-82.56v0c0,-45.59663 36.96337,-82.56 82.56,-82.56v0c45.59663,0 82.56,36.96337 82.56,82.56v0c0,45.59663 -36.96337,82.56 -82.56,82.56z" fill="none"></path><path d="M0,172v-172h172v172z" fill="none"></path><path d="M3.44,168.56v-165.12h165.12v165.12z" fill="none"></path><path d="M86,172c-47.49649,0 -86,-38.50351 -86,-86v0c0,-47.49649 38.50351,-86 86,-86v0c47.49649,0 86,38.50351 86,86v0c0,47.49649 -38.50351,86 -86,86z" fill="none"></path><path d="M86,168.56c-45.59663,0 -82.56,-36.96337 -82.56,-82.56v0c0,-45.59663 36.96337,-82.56 82.56,-82.56v0c45.59663,0 82.56,36.96337 82.56,82.56v0c0,45.59663 -36.96337,82.56 -82.56,82.56z" fill="none"></path><path d="M0,172v-172h172v172z" fill="none"></path><path d="M3.44,168.56v-165.12h165.12v165.12z" fill="none"></path><path d="M86,172c-47.49649,0 -86,-38.50351 -86,-86v0c0,-47.49649 38.50351,-86 86,-86v0c47.49649,0 86,38.50351 86,86v0c0,47.49649 -38.50351,86 -86,86z" fill="none"></path><path d="M86,168.56c-45.59663,0 -82.56,-36.96337 -82.56,-82.56v0c0,-45.59663 36.96337,-82.56 82.56,-82.56v0c45.59663,0 82.56,36.96337 82.56,82.56v0c0,45.59663 -36.96337,82.56 -82.56,82.56z" fill="none"></path><g fill="#666666"><path d="M74.53333,17.2c-31.59643,0 -57.33333,25.73692 -57.33333,57.33333c0,31.59641 25.7369,57.33333 57.33333,57.33333c13.73998,0 26.35834,-4.87915 36.24766,-12.97839l34.23203,34.23203c1.43802,1.49778 3.5734,2.10113 5.5826,1.57735c2.0092,-0.52378 3.57826,-2.09284 4.10204,-4.10204c0.52378,-2.0092 -0.07957,-4.14458 -1.57735,-5.5826l-34.23203,-34.23203c8.09923,-9.88932 12.97839,-22.50768 12.97839,-36.24766c0,-31.59641 -25.7369,-57.33333 -57.33333,-57.33333zM74.53333,28.66667c25.39939,0 45.86667,20.46729 45.86667,45.86667c0,25.39937 -20.46728,45.86667 -45.86667,45.86667c-25.39939,0 -45.86667,-20.46729 -45.86667,-45.86667c0,-25.39937 20.46728,-45.86667 45.86667,-45.86667zM91.67734,51.52161c-1.51229,0.03575 -2.94918,0.66766 -3.99765,1.75807l-13.14636,13.14636l-13.14636,-13.14636c-1.07942,-1.10959 -2.56162,-1.73559 -4.10963,-1.73568c-2.33303,0.00061 -4.43306,1.41473 -5.31096,3.57628c-0.8779,2.16155 -0.3586,4.6395 1.31331,6.26669l13.14636,13.14636l-13.14636,13.14636c-1.49777,1.43802 -2.10111,3.5734 -1.57733,5.58259c0.52378,2.0092 2.09283,3.57825 4.10203,4.10203c2.0092,0.52378 4.14457,-0.07956 5.58259,-1.57733l13.14636,-13.14636l13.14636,13.14636c1.43802,1.49778 3.5734,2.10113 5.5826,1.57735c2.0092,-0.52378 3.57826,-2.09284 4.10204,-4.10204c0.52378,-2.0092 -0.07957,-4.14458 -1.57735,-5.5826l-13.14636,-13.14636l13.14636,-13.14636c1.70419,-1.63875 2.22781,-4.1555 1.31865,-6.33798c-0.90916,-2.18248 -3.06468,-3.58317 -5.42829,-3.52739z"></path></g></g></g></svg>
                    </p>
                     <p class="nosearch-data">お探しの条件に合うニュースは見つかりませんでした。</p>
                     <!-- <p class="nosearch"> 申し訳ありませんが、検索結果がありませんでした。</p> -->
                </div>
            </span>
            <span v-else>
                <div v-if="w_width > 480">
                    <div v-for="(group,name,index) in post_groups" :key="index" class="bordertop-color col-md-12 category_box" id="view-1024-pattern" :style="{'--color': name.slice(name.lastIndexOf(',')+1)}">
                        <h4  class="category_news_title h-color" :style="{'--color': name.split(',')[2]}">
                            <router-link :to="'/newscategory/'+name.split(',')[0]"><span >{{name.split(',')[1]}} </span> </router-link>
                            <!-- <label class="list-label" for="">新着ニュース一覧</label> -->
                            <label class="list-label sp-414">                         
                                    <p :class="'newsChangeLink'+index" @click="newsToggle(index)" ><i :id="'newstogg' + index" class="fas fa-sort-down"></i></p>                      
                            </label>
                        </h4>   

                        <div  :id="'newsChangeLink' + index" class="row m-lr-0">
                            <slick :options="slickOptions" class="news-slider-width"> 
                                <div v-for="(value, block_id, i) in group" :key="i">                  
                                    <div class="pad-new pattern-child" v-if="block_id == 1 && value[0]">
                                        <router-link :to="'/newsdetails/'+value[0].pid">

                                            <div class="col-12 single-news-box top_lar_pc">

                                                <clazy-load class="wrapper-3" @load="log" src="/images/noimage.jpg" :key="index" >

                                                    <transition name="fade">

                                                        <img :src="'/upload/news/' + value[0].photo" class="fit-image img-fluid" @error="imgUrlAlt" :alt="name.split(',')[1]+'ニュース画像'">

                                                    </transition>
                                                    <!-- <div v-if="value[0].new_news == '1'" class="m_top_left"><span>New</span></div>                              -->

                                                    <transition name="fade" slot="placeholder">

                                                    <div class="preloader">

                                                        <div class="circle">

                                                        <div class="circle-inner"></div>

                                                        </div>

                                                    </div>

                                                    </transition>
                                                </clazy-load>
                                                <p class="news_title_large"> {{value[0].title}} </p>
                                            </div>
                                            <div class="txt_date txt_color_pc">
                                                <p v-if="value[0].new_news == '1'" class="second_para">{{value[0].created_at}}<span class="small_new">New</span></p>
                                                <p v-else class="second_para">{{value[0].created_at}}</p>
                                            </div>

                                        </router-link>
                                    </div>

                                    <div class="pad-new pattern-child" v-if="block_id == 2">
                                        <router-link v-for="(item,inx) in value.slice(0, 3)" :key="inx" :to="'/newsdetails/'+item.pid">

                                            <div class="col-12 row adslist-card m-lr-0 news-3-card top_med_pc">

                                                <div class="col-4 img-box">

                                                    <clazy-load class="wrapper-4" @load="log" src="/images/noimage.jpg" :key="inx" >

                                                        <!-- <img v-bind:src="'/upload/news/' + item.photo" class="fit-image" style="height:5rem;width:6rem" @error="imgUrlAlt"> -->

                                                        <transition name="fade">

                                                            <img :src="'/upload/news/' + item.photo" class="fit-image-0"  @error="imgUrlAlt" :alt="name.split(',')[1]+'ニュース画像'">

                                                        </transition>
                                                        <!-- <div v-if="item.new_news == '1'" class="m_top_left"><span>New</span></div> -->

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
                                                    <!-- <read-more more-str="" less-str=""  :max-chars="40" :text="item.title"></read-more> -->

                                                    <p class="medium_text">{{item.title}}</p>

                                                </div>
                                                <div class="txt_date txt_color_pc">
                                                    <p v-if="item.new_news == '1'" class="second_para">{{item.created_at}}<span class="small_new">New</span></p>
                                                    <p v-else class="second_para">{{item.created_at}}</p>
                                                </div>

                                            </div>
                                        </router-link>
                                    </div>

                                    <div class="pad-new pattern-child top_sm_pc" v-if="block_id == 3">
                                        <router-link v-for="(item,inx) in value.slice(0,8)" :key="inx" :to="'/newsdetails/'+item.pid" style="color:#333;">


                                            <p class="text-truncate news-list-display">
                                                <!-- <span class="sm_news_new_top" v-if="item.new_news == 1">New</span> -->
                                                <span class="sm_news_fa"><i class="fas fa-building"></i></span> 
                                                <span class="sm_news_mp">
                                                    {{item.title}}
                                                </span>
                                                <span v-if="item.new_news == '1'" class="sm_news_date">{{item.created_at}}<em class="small_new">New</em></span>
                                                <span v-else class="sm_news_date">{{item.created_at}}</span>
                                            </p>
                                        </router-link>
                                    </div>
                                </div>
                                <div v-for="(value, block_id, i) in group" :key="i" v-if="i == 0">    
                                    <div class="pad-new pattern-child" v-if="block_id == 1 && value[1]">

                                        <router-link :to="'/newsdetails/'+value[1].pid">

                                            <div class="col-12 single-news-box top_lar_pc">

                                                <clazy-load class="wrapper-3" @load="log" src="/images/noimage.jpg" :key="index" >

                                                    <transition name="fade">

                                                        <img :src="'/upload/news/' + value[1].photo" class="fit-image img-fluid" @error="imgUrlAlt" :alt="name.split(',')[1]+'ニュース画像'">

                                                    </transition>
                                                    <!-- <div v-if="value[1].new_news == '1'" class="m_top_left"><span>New</span></div>                              -->

                                                    <transition name="fade" slot="placeholder">

                                                    <div class="preloader">

                                                        <div class="circle">

                                                        <div class="circle-inner"></div>

                                                        </div>

                                                    </div>

                                                    </transition>
                                                </clazy-load>
                                                <p class="news_title_large"> {{value[1].title}} </p>
                                            </div>
                                            <div class="txt_date txt_color_pc">
                                                <p v-if="value[1].new_news == '1'" class="second_para">{{value[1].created_at}}<span class="small_new">New</span></p>
                                                <p v-else class="second_para">{{value[1].created_at}}</p>
                                            </div>

                                        </router-link>
                                    </div> 
                                </div>                 
                            </slick>
                        </div>
                        
                    </div>
                </div>
                <div v-else>
                    <div class="col-sm-6 col-lg-3 pad-new d-sm-block first-child">
                        <div class="scroll2" id="sm_tab">
                            <div class="sm_tab_pane fade show active p-1" id="one" role="tabpanel" aria-labelledby="one-tab" style="height: 100%;">
                                <div class="row" style="height: 100%;">
                                    <div class="active-users col-md-12 col-sm-12">
                                        <router-link :to="'/newsdetails/'+large_new.pid">
                                            <clazy-load class="sm_large_new" @load="log"  src="/images/noimage.jpg" :key="large_new.id">
                                                <transition name="fade"> 
                                                    <img v-bind:src="'/upload/news/' + large_new.photo" :alt="large_new.name+'ニュース画像'" class="img-responsive"  @error="imgUrlAlt">
                                                </transition>
                                                <transition name="fade" slot="placeholder">
                                                    <div class="preloader">
                                                        <div class="circle">
                                                        <div class="circle-inner"></div>
                                                        </div>
                                                    </div>
                                                </transition>
                                            </clazy-load>
                                            <p class="sm_source_title" v-if="large_new.title" aria-label="">{{ large_new.title }}</p>
                                            
                                        </router-link>
                                        <div class="sm_cat_date_large">
                                            <div class="sm_left_cat_large">
                                                <span :style="{'--bkgColor': large_new.color_code ? large_new.color_code : '#287db4'}" class="tab_title_color">
                                                <span>{{large_new.name}}</span>                                                        
                                                </span>
                                            </div>
                                            <div class="sm_right_date_large">
                                                <p v-if="large_new.new_news == '1'" class="">{{large_new.created_at}}<span class="small_new">New</span></p>
                                                <p v-else class="">{{large_new.created_at}}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="pad-new pattern-child">
                        <div v-for="(group,name,index) in post_groups" :key="index" class="txt_align">
                            <router-link  :to="'/newsdetails/'+group.pid">
                                <div class="col-12 row m-b-10 adslist-card m-lr-0 news-3-card">
                                    <div class="col-4 img-box">
                                        <clazy-load class="wrapper-4" @load="log" src="/images/noimage.jpg" :key="inx">
                                            <transition name="fade">
                                                <img v-bind:src="'/upload/news/' + group.photo" :alt="group.name+'ニュース画像'" class="fit-image-0" @error="imgUrlAlt">
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

                                    <div class="col-8 sm_txt_box">
                                        <p>{{group.title}}</p>
                                    </div>
                                </div>
                            </router-link>
                            <div class="sm_cat_date">
                                <div class="sm_left_cat">
                                    <span :style="{'--bkgColor': group.color_code ? group.color_code : '#287db4'}" class="tab_title_color">
                                        <span>{{group.name}}</span>                                                        
                                    </span>
                                </div>
                                <div class="sm_right_date">
                                <p v-if="group.new_news == '1'" class="">{{group.created_at}}<span class="small_new">New</span></p>
                                <p v-else class="">{{group.created_at}}</p>
                                </div>
                            </div>
                        </div>                                                    
                    </div>                                                               
                        
                </div>
           
            <adsslider class="d-block d-sm-none"></adsslider>
            </span>
        </div>
    </layout>

</template>



<script>

    import layout from '../components/home.vue'
    import News from './News.vue'
    import Slick from 'vue-slick'
    import adsslider from '../components/adsslider'
    import { eventBus } from '../event-bus.js';

    export default {

        components: {
            News,         
            layout,
            adsslider,
            Slick
        },

      async mounted() {
            this.visit = 'true';
            localStorage.setItem('visit', this.visit);
            $('#navtab').removeClass('news-tabColor hospital-tabColor nursing-tabColor job-tabColor');
            $('#navtab').addClass('news-tabColor');
            $('.tab-content').removeClass('news-borderColor job-borderColor nursing-borderColor hospital-borderColor');
            $('#upper-tab').addClass('news-borderColor');
            this.getAllCat();
            this.getLatestPostsByCatID();
            if($(window).width() > 480){
            this.getLatestPostFromAllCat();
            }
        },

    data() {

        return {
            cats: [],
            posts: [],
            latest_post: [],
            latest_post_null: false,
            latest_post_all_cats: [],
            categoryId: 1,
            post_groups : [],
            status:'0',
            search_word:null,
            computed_width: '100%',
            w_width: window.innerWidth,
            norecord_msg: false,
            latest_catId: 0,
            latest_catName: '',
            large_new: '',
            // w_width: $(window).width() + 16,
        }
    },

    created() {
        this.$ga.event({
            eventCategory: 'トップページ',
            eventAction: '-',
        })
        
        this.$nextTick(() => {
            $("#top_a").addClass("active");          
        })   
    },
    computed:{  

        categoryslider(){
            return {
                slidesToShow: 1,
                slidesToScroll: 1,
                infinite: true,
                accessibility: true,
                adaptiveHeight: false,
                edgeFriction: 0.30,
                swipe: true,
                autoplay: true,
                lazyLoad: 'ondemand',   
                arrows: false              
            }
        }    ,  
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
    methods: {
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
                  
            newsToggle(id)
                {

                    var class_by_id = $('#newstogg'+id).attr('class');
                    if(class_by_id == "fas fa-sort-down animate rotate")
                    {
                        $('#newstogg'+id).removeClass("fas fa-sort-down animate rotate");
                        $('.newsChangeLink'+id).addClass("fas fa-sort-down");
                        $('#newsChangeLink'+id).show('medium');
                    }
                    else {
                        $('#newstogg'+id).removeClass("fas fa-sort-down");
                        $('.newsChangeLink'+id).removeClass("fas fa-sort-down");
                        $('#newstogg'+id).addClass("fas fa-sort-down animate rotate");
                        $('#newsChangeLink'+id).hide('medium');
                    }

            },
            log() {
                // console.log()
            },
            getAllCat: function() {
                this.axios .get('/api/home') 
                .then(response => {
                        this.cats = response.data;

                        if(this.cats[0].name == "トップ"){
                            eventBus.$emit('gotColor', this.cats[0].color_code);
                            this.latest_catId = this.cats[1].id;
                        }else{
                            this.latest_catId = this.cats[0].id;
                            eventBus.$emit('gotColor', this.cats[1].color_code);
                        }
                        if($(window).width() > 480){
                        this.getPostByCatID();
                        this.getLatestPostByCatID();
                        }
                    });

            },

            getLatestPostsByCatID: function() {
                this.post_groups = [];
                if (this.search_word == null || this.search_word == '' || this.search_word == 'null') {
                    var searchword = 'all_news_search';                
                } else {
                    var searchword = this.search_word;
                }

                if($(window).width() > 480){

                    this.axios
                    .get('/api/get_latest_posts_by_catId/'+searchword)
                    .then(response => {
                        length = Object.keys(response.data).length;
                        this.$loading(false);
                        if(length>0) {
                            this.post_groups = response.data;
                        } else {
                            this.post_groups = [];                         
                        }                  
                        if(this.post_groups.length != 0){
                            this.norecord_msg = false;
                        }else{
                            this.norecord_msg = true;                        
                        }
                    });

                }else{
                    this.axios
                    .get('/api/get_latest_posts_by_catId_mobile/'+searchword)
                    .then(response => {
                        length = Object.keys(response.data).length;
                        this.$loading(false);
                        if(length>0) {
                            this.large_new = response.data.large;
                            this.post_groups = response.data.aryNewsMobile;
                            // console.log(response.data.aryNewsMobile.length);
                        } else {
                            this.post_groups = [];                         
                        }                  
                        if(this.post_groups.length != 0){
                            this.norecord_msg = false;
                        }else{
                            this.norecord_msg = true;                        
                        }
                    });
                }
            },


            getPostByCatID: function(catId = this.latest_catId) {
                if ($('#search-free-word').val() != null) {
                    var search_word = $('#search-free-word').val();
                } else {
                    var search_word = null;
                }

                if (catId !== undefined) {
                    var cat_id = catId;
                } else {
                    var cat_id = this.latest_catId;
                }
                let fd = new FormData();
                fd.append('search_word', search_word);
                fd.append('category_id', cat_id);
                $('.search-item').css('display', 'none');
                this.categoryId = cat_id;
                this.axios.post("/api/posts", fd)
                    .then(response => {
                        this.posts = this.findNewNews(response.data);
                    });
            },

            getCategoryRandomValue(){

            this.axios.get("/api/get_cat_random") .then(response => {

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

                    var cat_id = this.latest_catId;

                }

                let fd = new FormData();

                fd.append('search_word', search_word)

                fd.append('category_id', cat_id)

                $('.search-item').css('display', 'none');

                this.categoryId = cat_id;

                this.axios.post("/api/get_latest_post" , fd)

                .then(response => {

                    var posts =[]
                    posts.push(response.data.latest_post);
                    var latest_post = this.findNewNews(posts);
                    this.latest_post = latest_post[0];
                    this.latest_catName = response.data.cat.name;
                    
                    if(Object.keys(this.latest_post).length == 0) {
                        this.latest_post_null = true;
                    }else{
                        this.latest_post_null = false;
                    }
                });

            },

            getLatestPostFromAllCat: function() {
                // this.$loading(true);
                this.axios

                    .get('/api/get_latest_post_all_cat')

                    .then(response => {
                    
                        this.$loading(false);
                        this.latest_post_all_cats = this.findNewNews(response.data);
                    });
            },
            findNewNews: function(posts) {
                        var current = new Date();
                        var current_time = current.getTime();
                        var current_date = current.getDate();
                        var current_month = current.getMonth()+1;
                        posts.forEach(function(post){
                            const post_date = new Date(post.created_at.replace(/-/g,"/"));
                            var msec = (current_time - post_date.getTime());
                            var mins = Math.floor(msec / 60000);
                            var hrs = Math.floor(mins / 60);
                            var min = post_date.getMinutes();
                            var month = post_date.getMonth()+1;
                            var date = post_date.getDate();
                            min = min < 10 ? '0' + min : min;
                            post.new_news = "";
                            if(hrs <= 36) {     
                                //post.date_only = month + '/' +  post_date.getDate();
                                post.new_news = "1";
                            } 

                            if(current_month == month && current_date == date){
                                post.created_at = month + '/' +  date + ' ' + post_date.getHours () + ':' + min;
                            }else{
                                post.created_at = month + '/' +  date;
                            }                          
                            
                        });
                        return posts;
            },
            searchCategory() {
                this.$loading(true);
                if ($('#search-free-word').val() == null || $('#search-free-word').val() == '' || $('#search-free-word').val() == 'null') {
                    this.clearSearch();
                } else {

                    this.status = 1;

                    this.search_word = $('#search-free-word').val();
                    this.getLatestPostsByCatID();                 

                }
            },
            clearSearch() {

                this.status = 0;

                this.search_word = '';

                this.getLatestPostsByCatID();

            },

            imgUrlAlt(event) {
                event.target.src = "/images/noimage.jpg"
            },
        }
    }
 </script>

<style scoped>
.black_color{
    background: #ffffff !important;
    border: 1.5px solid var(--bkgColor);
    color: #000000;
    text-align: center;
    min-width: 80%;
    max-width: 80%;
}
.black_color span{
    color: #000000 !important;
}
.fit-image {
    padding: 0;
}
.list-label{
    float: right; 
    color: #999; 
    font-size: 14px;
}
.list-label > p{
    padding-left: 10px;
    font-weight: bold;
    line-height: 1.2px;
    position: absolute;
    right: 10px;
    top: 10px;
    font-size: 20px;
}
.pad-new{
    position: relative;
    padding-left: 5px !important;
    padding-right: 5px !important;
    background: none;
}
.news-list-display{
    /* border: 1px solid #f7f7f7; */
    padding: 5px 10px;
    margin-bottom: 5px;
    /*background: #f7f7f7;*/
    background: #fff;
    /* box-shadow: 0px 0px 1px #ddd; */
    border:.1rem solid #f3efef;
    /*border-width: 0 .1rem .1rem 0;*/
    border: none;
    box-shadow: 0 0.03rem 0.09rem rgb(0 0 0 / 11%), 0 0.16rem 0.36rem rgb(0 0 0 / 13%);
    /*border-radius: .2rem;*/
}

.news-tabColor .nav-link {
    background: #75b777 !important;
    color: #fff;
    border-right: 1px solid #fff;
}

.left{
    float: left;
    width: 30%;
    border: 1px solid black;
}

.internal{
    /* width: 31.75%;
    border: 1px solid black; */
    display: inline-block;
}


.center{
    overflow: hidden;
    white-space: nowrap;
    display: inline-block;
    /* float: left;
    width: 38.9%;
    border: 1px solid black;
    margin: 1px; */
    /* width: 95%; */
    
    /* max-width: 100%; */
}
.right{
    float: right;
    width: 30%;
    /* border: 1px solid black; */
}
.cat-nav {
    padding-bottom: 0;
    height: 36px;
    display: flex;
    padding-left: 1.65rem !important;
}

.card-header-tabs {
    margin-right: -1.65rem;
    margin-left: -1.65rem;
    border-bottom: 0;
}
#top {
    border-left: 1px solid #fff;
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
.nav-tabs{
    border-bottom: none;
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
.left-arr-btn .fas, .right-arr-btn .fas {
    color:#828282;
}

.cat-slider .list-group-item{
    border-bottom-right-radius:0rem !important;
    border-bottom-left-radius:0rem !important;
    border-top-left-radius:0rem !important;
    border-top-right-radius:0rem !important;
}

.cat-slider .adslist-card{  
    padding: 0;
    padding-left: 5px;
    padding-right: 5px;
    background: #fff;
    border: none;
}

.hovereffect .info{
    width: 100%;
    height: 80px !important;
    position: absolute;
    top:140px !important;
    /* background-color: #fff; */
    background-color: rgba(42, 45, 44, 0.69);
    color: #fff;
    text-align: justify !important;
}
.noimage > .hovereffect .info{
    top: 0px !important;
    height: 360px !important;
    background: #5f5f5f;
}
#myTab ul li {
    display: -ms-inline-flexbox;
    display: inline-flex;
    display: -webkit-inline-flex;
}

.nav {
    flex-wrap: nowrap;
}
.news-slider-width{
    width: 100%;
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
.tab_title_date {
    font-size: 12px;
    float: right;
    /*margin-top: 16px;*/
}
.tab_title_d {
    color: #969798!important;
}
.tab_title_n {
    color: #E83015!important;
}
.pattern-txt-box.medium_text {
    height: 62px;
    overflow: hidden;
}
.top_lar_pc .news_title_large {
    line-height: 1.3rem;
}
.top_med_pc {
    height: 98px;
    margin-bottom: 6.5px;
}
.top_sm_pc a .news-list-display {
    height: 34px;
}
.top_sm_pc a .news-list-display .sm_news_mp {
    max-width: 69.5%;
}
@media only screen and (min-width: 769px) and (max-width: 1200px){
    #view-1024 .first-child {
        max-width: 33.33%;
        flex: 0 0 33.33%;
    }
    #view-1024 .last-child {
        max-width: 33.33%;
        flex: 0 0 33.33%;
    }
    #view-1024-pattern .col-lg-3 {
        max-width: 33.333333%;
        flex: 0 0 33.333333%;
        /* overflow: hidden; */
    }
    #view-1024-pattern .col-lg-3:last-child {
        display: none;
    }
    .newssearch-width{
        max-width: 66.666667%;
        flex: 0 0 66.666667%;
    }
}

@media only screen and (max-width:480px){
    .p_3 {
        max-height: 50px;
        font-weight: bold;
        line-height: 1.1rem;
    }
    .list-label{
        color: #fff;     
    }
    .pattern-txt-box {
        max-height: 60px;
    }
    .txt_date {
        font-weight: normal;
        font-size: 12px;
        color: #969798;
    }
    .txt_align a .pattern-txt-box p, .sm_news_mp {
        font-weight: bold;
    }
    .sm_news_mp {
        max-width: 72%!important;
    }
}
@media only screen and (max-width: 1280px){
    .news-slider-width{
        width: 100%;
    }
}
@media only screen and (max-width:1024px){
    .news-slider-width{
        width: 100%;
    }
}

@media only screen and (max-width:1280px){
    
    
    .news-slider-width{
       
        width: 100%;
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
    .slick-next{
     
        right: 0px
    }
    .slick-prev{
      
        left: 5px;
        z-index: 999;       
    }
    .button:not(:disabled).slick-next{
        opacity: 0;
    }
    .slick-disabled{
        opacity: 0;
    }
    
}
@media only screen and (max-width: 414px){
    .news-slider-width{
        width: 100%;
    }
}
@media only screen and (max-width: 560px){
    .cat-nav {
        height: auto !important;
        padding: 0 !important;
    }
}
@media only screen and (min-width: 769px){
   .slick-arrow{   
    display: none !important;   
    } 
}
#widthmenu{
    display: inline-block;

}
.tab_title_color{
    border-radius: 3px;
    padding: 2px 4px 0px 4px;
    font-size: 10px;
    background-color: var(--bkgColor);
}
.tab_title_color span {
    color: #fff;
}
.bordertop-color{
    border-top: 2px solid var(--color);
}
.h-color span {
    border-left: 5px solid var(--color);
    color: var(--color);
}
.bordertop-color i {
    color: var(--color);
}
/* .display_align {
    display: inline-flex;
} */
.single-news-box {
    /*background: #f7f7f7;*/
    background: #fff;
    height: 307px;
    padding: 10px;
    /* box-shadow: 0px 0px 2px #ddd; */
    border: .1rem solid #f3efef;
    /*border-width: 0 .1rem .1rem 0;*/
    overflow: hidden;
    border: none;
    box-shadow: 0 0.03rem 0.09rem rgb(0 0 0 / 11%), 0 0.16rem 0.36rem rgb(0 0 0 / 13%);
}
.news-3-card {
    /*background-color: #f7f7f7;*/
    background: #fff;
    /* box-shadow: 0 0 2px #ddd; */
    border: .1rem solid #f3efef;
    /*border-width: 0 .1rem .1rem 0;*/
    padding: 10.7px 0;
    border: none;
    box-shadow: 0 0.03rem 0.09rem rgb(0 0 0 / 11%), 0 0.16rem 0.36rem rgb(0 0 0 / 13%);
    /*border-radius: .2rem;*/
}

.news-3-card .img-box{
    padding-left: 10px;
}
.txt_align {
    position: relative;
}
.txt_date {
    /* font-weight: bold; */
    text-align: right;
    position: absolute;
    bottom: 3px;
    right: 10px;
}
.txt_color {
    right: 5px;
    color: white;
}
.txt_color_pc {
    right: 16px;
    font-weight: normal;
    font-size: 12px;
    float: right;
    margin-top: 16px;    
    color: #969798;
    /* bottom: -2px; */
}
.s_top_left {
    position: relative;
    bottom: 2px;
}
.sm_news_fa {
    float: left;
}
.sm_news_mp {
    white-space: nowrap;
    text-overflow: ellipsis;
    max-width: 75%;
    float: left;
    max-height: 20px;
    overflow: hidden;
    padding: 0 0 0 5px;
}
.small_new {
    margin-left: 5px;
    border-radius: 1px;
    padding: 0px 6px 0px 6px;
    font-size: 10px;
    /*background-color: #FE2E2E;
    color: white;*/
    color: #FE2E2E;
    /*font-style: normal;*/
    font-weight: bold;
    text-align: left;
    margin-right: 10px;
}
.sm_news_date {
    font-size: 12px;
    color: #969798;
    float: right;
}
.sm_news_new_top {
    border-radius: 1px; 
    padding: 0px 4px;
    font-size: 10px;
    background-color: red;
    color: white;
    float: left;
    height: 15px;
    line-height: 15px;
}
.sm_tab_pane {
    padding-left: 0px !important;
    padding-right: 0px !important;
    min-height: 78px;
}
.sm_cat_date {
    display: flex;
    position: absolute;
    bottom: 5px;
    right: 17px;
    width: 60%;
    height: 25%;
}
.sm_left_cat {
    flex: 1;
}

.sm_right_date {
   text-align: right;
   flex: 1;
}
#sm_tab {
    background: #fff;
    margin-bottom: 10px;
    padding: 13px 13px 0px 13px !important;
    border: 1px solid #ccc;
    box-shadow: 1px 2px 3px rgb(0 0 0 / 10%);
}
.sm_txt_box {
    padding-left: 0px;
}
.sm_txt_box p{
    font-weight: bold;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;  
    overflow: hidden;
}
.sm_large_new img {
    height: 100%;
    transition: all 250ms ease-out;
    width: 100%;
    object-fit: contain;
}
.sm_cat_date_large {
    display: flex;
    width: 100%;
}
.sm_left_cat_large {
    flex: 1;
}

.sm_right_date_large {
   text-align: right;
   flex: 1;
}
.sm_source_title {
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
    font-size: 1em;
    text-transform: uppercase;
    color: #333;
    font-weight: bold;
    min-height: 72px;
    margin-top: 6px;
}
</style>
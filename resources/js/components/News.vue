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

                                                        <img :src="'/upload/news/' + latest_post_all_cat.photo " class="img-responsive fit-image" @error="imgUrlAlt">

                                                    </transition>

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

                                                                {{ latest_post_all_cat.main_point }}

                                                            </p>

                                                        </div>

                                                    </div>

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
                            <div class="card col-md-12 col-lg-6 pad-new d-none d-sm-block first-child" style="border:0px!important;">
                                <div class="tab-content tab-content2 scroll2" id="myTabContent">

                                    <div class="tab-pane fade show active p-1" id="one" role="tabpanel" aria-labelledby="one-tab">

                                        <div class="row">

                                            <div class="active-users col-md-6 col-sm-6">

                                                <router-link :to="'/newsdetails/'+latest_post.id">

                                                 <clazy-load class="wrapper-0" @load="log"  src="/images/noimage.jpg" :key="latest_post.id">

                                                    <transition name="fade">
                                                      
                                                        <img v-bind:src="'/upload/news/' + latest_post.photo" class="source-img img-responsive"  @error="imgUrlAlt">

                                                    </transition>

                                                    <transition name="fade" slot="placeholder">

                                                        <div class="preloader">

                                                            <div class="circle">

                                                            <div class="circle-inner"></div>

                                                            </div>

                                                        </div>

                                                    </transition>

                                                 </clazy-load>

                                                    <p class="source-title" v-if="latest_post.main_point" aria-label="">{{ latest_post.main_point }}</p>

                                                    <p class="source-subtitle" v-if="latest_post.created_at">

                                                      <img v-if="latest_post.created_at" alt="" src="/images/5.png" class="source-img" @error="imgUrlAlt">{{ latest_post.created_at }}

                                                    </p>

                                                </router-link>

                                            </div>

                                            <div class="col-md-6 col-sm-6 news-wrapper">

                                                <ul class="list-group list-group-flush all-item" v-for="post in posts" :key="post.id">

                                                    <li  class="list-group-item" style="padding:6px 0px 2px 0px!important;"  v-if = "posts[0].id != post.id">

                                                        <router-link :to="{path:'/newsdetails/'+post.id}">

                                                            <!-- <img src="/images/4.png" alt="" style="width:16px; height: 16px;" class="img-responsive float-right" @error="imgUrlAlt"> -->

                                                            <span class="source-img-small d-inline-block text-truncate">{{ post.main_point }}</span>

                                                        </router-link>

                                                    </li>

                                                </ul>

                                            </div>

                                        </div>

                                    </div>

                                </div>

                            </div>
                            <!-- end category box -->

                            <!-- category right side -->
                            <div class="col-md-12 col-lg-6 pad-free last-child  d-none d-sm-block">
                                <div class="" v-if="status =='0'">
                                    <!-- two show () aaaaaaaaa-->  
                                   
                                    <div v-if="(w_width >= 1280) || (w_width <= 768 && w_width >= 480)" class="row col-sm-12 p-lr-0 m-0">
                                        <div class="col-sm-6 m-b-8 pad-new" v-for="item in latest_post_all_cats.slice(0, 8)"  :key="item.id">
                                            <div class="col-md-12 row adslist-card news-3-card m-0" :class="item.category_id == 26?'break-news':''">
                                                

                                                <div class="col-md-4 col-sm-4 img-box">     

                                                    <router-link :to="'/newsdetails/'+item.id">

                                                        <clazy-load class="wrapper-4" @load="log" src="/images/noimage.jpg" :key="item.id">

                                                            <transition name="fade">

                                                                <img :src="'/upload/news/' + item.photo"  class="fit-image-0"  @error="imgUrlAlt">

                                                            </transition>

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


                                                <div class="col-md-8 col-sm-8 txt-box">                                                   
                                                    
                                                    <router-link :to="'/newsdetails/'+item.id">
                                                        <!-- <span> {{item.main_point}} </span> -->
                                                        <read-more more-str="" less-str="read less"  :max-chars="25" :text="item.main_point"></read-more>
                                                    </router-link>
                                                    <span v-if="item.category_id == 26" class="breaking-tip for-read-more" style="bottom:0px;">PR</span>
                                                    <span v-else :style="{'--bkgColor': item.color_code ? item.color_code : '#287db4'}" class="tab_title_color for-read-more">
                                                        
                                                    <span>{{item.cname}}</span>
                                                        
                                                    </span>
                                                    <span class="tab_title_date tab_title_d" v-if="item.created_at != 1">{{item.created_at}}</span>
                                                    <span class="tab_title_date tab_title_n" v-else >New</span>
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

                                                        <clazy-load class="wrapper-4" @load="log" src="/images/noimage.jpg" :key="item.id">

                                                            <transition name="fade">

                                                                <img :src="'/upload/news/' + item.photo"  class="fit-image-0"  @error="imgUrlAlt">

                                                            </transition>

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
                                                        <!-- <span> {{item.main_point}} </span> -->
                                                        <read-more more-str="" less-str="read less"  :max-chars="25" :text="item.main_point"></read-more>
                                                    </router-link>
                                                    <span v-if="item.category_id == 26" class="breaking-tip for-read-more" style="bottom:0px;">PR</span>
                                                    <span v-else :style="{'--bkgColor': item.color_code ? item.color_code : '#287db4'}" class="tab_title_color for-read-more"><span>{{item.cname}}</span></span>
                                                    <span class="tab_title_date tab_title_d" v-if="item.created_at != 1">{{item.created_at}}</span>
                                                    <span class="tab_title_date tab_title_n" v-else >New</span>
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

                                        <clazy-load class="wrapper-4" @load="log"  src="/images/noimage.jpg" :key="item.id">

                                            <!-- <img v-bind:src="'/upload/news/' + item.photo" class="fit-image" style="height:5rem;width:6rem" @error="imgUrlAlt"> -->

                                            <transition name="fade">

                                                <img v-bind:src="'/upload/news/' + item.photo" class="fit-image-0" @error="imgUrlAlt">

                                            </transition>

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



                                    <div class="col-md-8 col-sm-8 txt-box">                                        
                                        
                                        <router-link :to="'/newsdetails/'+item.id">
                                            <!-- <span> {{item.main_point}} </span> -->
                                            <read-more more-str="" less-str="read less"  :max-chars="25" :text="item.main_point"></read-more>
                                        </router-link>
                                        <span v-if="item.category_id == 26" class="breaking-tip for-read-more" style="bottom:0px;">PR</span>
                                        <span v-else :style="{'--bkgColor': item.color_code ? item.color_code : '#287db4'}" class="tab_title_color for-read-more">
                                            <span>{{item.cname}}</span>
                                        </span>
                                        <span class="tab_title_date tab_title_d" v-if="item.created_at != 1">{{item.created_at}}</span>
                                        <span class="tab_title_date tab_title_n" v-else >New</span>
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

                                                <img v-bind:src="'/upload/news/' + item.photo" class="fit-image-0" @error="imgUrlAlt">

                                            </transition>

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
                                        <!-- <span> {{item.main_point}} </span> -->
                                        <read-more more-str="" less-str="read less"  :max-chars="25" :text="item.main_point"></read-more>
                                    </router-link>
                                    <span v-if="item.category_id == 26" class="breaking-tip for-read-more" style="bottom:0px;">PR</span>
                                    <span v-else :style="{'--bkgColor': item.color_code ? item.color_code : '#287db4'}" class="tab_title_color for-read-more"><span>{{item.cname}}</span></span>
                                    <span class="tab_title_date tab_title_d" v-if="item.created_at != 1">{{item.created_at}}</span>
                                    <span class="tab_title_date tab_title_n" v-else >New</span>
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
  
                <div v-for="(group,name,index) in post_groups" :key="index" class="bordertop-color col-md-12 category_box" id="view-1024-pattern" :style="{'--color': name.slice(name.lastIndexOf(',')+1)}">
                    <h4  class="category_news_title h-color" :style="{'--color': name.split(',')[2]}">
                        <router-link :to="'/newscategory/'+name.split(',')[0]"><span >{{name.split(',')[1]}} </span> </router-link>
                        <label class="list-label" for="">新着ニュース一覧</label>
                        <label class="list-label sp-414">                         
                                <p :class="'newsChangeLink'+index" @click="newsToggle(index)" ><i :id="'newstogg' + index" class="fas fa-sort-down"></i></p>                      
                        </label>
                    </h4>    

                    <div  :id="'newsChangeLink' + index" class="row m-lr-0">
                        <slick :options="slickOptions" class="news-slider-width" v-if="w_width > 480"> 
                            <div v-for="(value, block_id, i) in group" :key="i">                  
                                <div class="pad-new pattern-child" v-if="block_id == 1 && value[0]">
                                    <router-link :to="'/newsdetails/'+value[0].pid">

                                        <div class="col-12 single-news-box">

                                            <clazy-load class="wrapper-3" @load="log" src="/images/noimage.jpg" :key="index" >

                                                <transition name="fade">

                                                    <img :src="'/upload/news/' + value[0].photo" class="fit-image img-fluid" @error="imgUrlAlt">

                                                </transition>                                

                                                <transition name="fade" slot="placeholder">

                                                <div class="preloader">

                                                    <div class="circle">

                                                    <div class="circle-inner"></div>

                                                    </div>

                                                </div>

                                                </transition>
                                            </clazy-load>
                                            <p> {{value[0].main_point}} </p>
                                        </div>

                                    </router-link>
                                </div>

                                <div class="pad-new pattern-child" v-if="block_id == 2">
                                    <router-link v-for="(item,inx) in value.slice(0, 3)" :key="inx" :to="'/newsdetails/'+item.pid">

                                        <div class="col-12 row m-b-10 adslist-card m-lr-0 news-3-card">

                                            <div class="col-4 img-box">

                                                <clazy-load class="wrapper-4" @load="log" src="/images/noimage.jpg" :key="inx" >

                                                    <!-- <img v-bind:src="'/upload/news/' + item.photo" class="fit-image" style="height:5rem;width:6rem" @error="imgUrlAlt"> -->

                                                    <transition name="fade">

                                                        <img :src="'/upload/news/' + item.photo" class="fit-image-0"  @error="imgUrlAlt">

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
                                                <!-- <read-more more-str="" less-str=""  :max-chars="40" :text="item.main_point"></read-more> -->

                                                <p>{{item.main_point}}</p>

                                            </div>

                                        </div>
                                    </router-link>
                                </div>

                                <div class="pad-new pattern-child" v-if="block_id == 3">
                                    <router-link v-for="(item,inx) in value.slice(0,8)" :key="inx" :to="'/newsdetails/'+item.pid" style="color:#333;">

                                        <p class="text-truncate news-list-display">
                                            <i class="fas fa-building"></i>{{item.main_point}}
                                        </p>
                                    </router-link>
                                </div>
                            </div>
                            <div v-for="(value, block_id, i) in group" :key="i">    
                                <div class="pad-new pattern-child" v-if="block_id == 1 && value[1]">

                                    <router-link :to="'/newsdetails/'+value[1].pid">

                                        <div class="col-12 single-news-box">

                                            <clazy-load class="wrapper-3" @load="log" src="/images/noimage.jpg" :key="index" >

                                                <transition name="fade">

                                                    <img :src="'/upload/news/' + value[1].photo" class="fit-image img-fluid" @error="imgUrlAlt">

                                                </transition>                                

                                                <transition name="fade" slot="placeholder">

                                                <div class="preloader">

                                                    <div class="circle">

                                                    <div class="circle-inner"></div>

                                                    </div>

                                                </div>

                                                </transition>
                                            </clazy-load>
                                            <p> {{value[1].main_point}} </p>
                                        </div>

                                    </router-link>
                                </div> 
                            </div>                 
                        </slick>
                        <slick :options="slickOptions" class="news-slider-width" v-else>
                                <div class="pad-new pattern-child" v-if="group[0]">
                                    <router-link v-for="(item,inx) in group.slice(0, 3)" :key="inx" :to="'/newsdetails/'+item.pid">
                                        <div class="col-12 row m-b-10 adslist-card m-lr-0 news-3-card">
                                            <div class="col-4 img-box">

                                                <clazy-load class="wrapper-4" @load="log" src="/images/noimage.jpg" :key="inx">

                                                    <transition name="fade">

                                                        <img v-bind:src="'/upload/news/' + item.photo" class="fit-image-0" @error="imgUrlAlt">

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
                                                <!-- <read-more more-str="" less-str=""  :max-chars="40" :text="item.main_point"></read-more> -->

                                                <p>{{item.main_point}}</p>

                                            </div>
                                        </div>
                                    </router-link>
                                </div>                    

                                <div class="pad-new pattern-child" v-if="group[3]">
                                    <router-link v-for="(item,inx) in group.slice(3, 11)" :key="inx" :to="'/newsdetails/'+item.pid" style="color:#333;">

                                        <p class="text-truncate news-list-display">

                                            <i class="fas fa-building"></i> {{item.main_point}}

                                        </p>

                                    </router-link>
                                </div>                                               
                        </slick>
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
            this.getPostByCatID();
            this.getLatestPostsByCatID();
            this.getLatestPostFromAllCat();
        },

    data() {

        return {
            posts: [],
            latest_post: [],
            latest_post_null: false,
            latest_post_all_cats: [],
            search_posts:[],
            post_groups : [],
            status:'0',
            search_word:null,
            w_width: window.innerWidth,
            norecord_msg: false,
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
        },  
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
                }
            },
            getPostByCatID: function() {
                // if ($('#search-free-word').val()) {
                //     var search_word = $('#search-free-word').val();
                // } else {
                //     var search_word = null;
                // }
                let fd = new FormData();
                //fd.append('search_word', search_word);
                this.axios.post("/api/posts", fd)
                    .then(response => {
                        this.latest_post = response.data.news[0];
                        this.posts = response.data.news;
                        eventBus.$emit('gotColor', response.data.line_color);
                    });
            },
            getLatestPostFromAllCat: function() {
                this.axios.get('/api/get_latest_post_all_cat')
                    .then(response => {                    
                        this.$loading(false);
                        const posts = response.data;
                        var current_date = new Date();
                        var is_within_48 = false;
                        posts.forEach(function(post){
                            const post_date = Date.parse(post.created_at);
                            const time_diff = (current_date.getTime() - post_date) / (1000 * 60 * 60 * 24);
                            if(time_diff < 2) {
                                post.created_at = "1";
                            }
                            else {
                                var post_txt = new Date(post.created_at);
                                var min = post_txt.getMinutes();
                                var month = post_txt.getMonth()+1;
                                if(min == 0 ) {
                                    min = '00';
                                }
                                post.created_at = post_txt.getDate() + '/' +  month + ' ' + post_txt.getHours () + ':' + min;
                            }
                        });
                        this.latest_post_all_cats = posts;
                    });
            },    
            newsToggle(id) {
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

<style>
/*.list-label{
    float: right; 
    color: #999; 
    font-size: 14px;
}*/
.list-label > p{
    padding-left: 10px;
    font-weight: bold;
    line-height: 1.2px;
    position: absolute;
    right: 10px;
    top: 10px;
    font-size: 20px;
}
/*.pad-new{
    padding-left: 5px !important;
    padding-right: 5px !important;
}*/
/*.news-list-display{
    padding: 5px 10px;
    margin-bottom: 4px;
    background: #f7f7f7;
    border:solid #f3efef;
    border-width: 0 .1rem .1rem 0;
}*/

/*.news-3-card {
    background-color: #f7f7f7;
    border:solid #f3efef;
    border-width: 0 .1rem .1rem 0;
}*/

/*.news-3-card .img-box{
    padding-left: 10px;
}*/

/*.single-news-box {
    background: #f7f7f7;
    height: 310px;
    padding: 10px;
    border:solid #f3efef;
    border-width: 0 .1rem .1rem 0;
    overflow: hidden;
}*/

/*.news-tabColor .nav-link {
    background: #75b777 !important;
    color: #fff;
    border-right: 1px solid #fff;
}*/

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



.right{
    float: right;
    width: 30%;
    /* border: 1px solid black; */
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

.news-slider-width{
    width: 100%;
}



/*.tab_title_date {
    font-size: 12px;
    float: right;
    margin-top: 16px;
}*/
/*.tab_title_d {
    color: #969798!important;
}*/
.tab_title_n {
    color: #E83015!important;
}

@media only screen and (min-width: 769px) and (max-width: 1200px){
    #view-1024 .first-child {
        max-width: 66.666667%;
        flex: 0 0 66.666667%;
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
    .list-label{  
        color: #fff;     
    }
}
@media only screen and (max-width: 1280px){
    .news-slider-width{
        width: 100%;
    }
}
/*@media only screen and (max-width:1024px){
    .news-slider-width{
        width: 100%;
    }
}*/

/*@media only screen and (max-width:1280px){
    .slick-next{
        right: 0;
    }
    .slick-prev{
        left: 0;     
    }
    .button:not(:disabled).slick-next{
        opacity: 0;
    }
}*/
/*@media only screen and (max-width: 414px){
    .news-slider-width{
        width: 100%;
    }
}*/

/*@media only screen and (min-width: 769px){
   .slick-arrow{   
        display: none !important;   
    } 
}*/
#widthmenu{
    display: inline-block;

}
/*.tab_title_color{
    border-radius: 3px;
    padding: 2px 4px 0px 4px;
    font-size: 13px;
    background-color: var(--bkgColor);
    color: #fff;
}*/
/*.tab_title_color span {
    color: #fff;
}*/
/*.bordertop-color{
    border-top: 2px solid var(--color);
}*/
/*.h-color span {
    border-left: 5px solid var(--color);
    color: var(--color);
}*/
/*.bordertop-color i {
    color: var(--color);
}*/
</style>

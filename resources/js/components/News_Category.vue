<template>
<layout>   
<div>    
    <div class="col-12">
        <!-- <div class="pc-991-1880">
            <span @click="$router.go(-1);" class="backbtn" style="cursor:pointer;right:0;top:1%;;position:relative;">
                <span class="btn btn-danger all-btn submit">
                    <i class="fas fa-arrow-left"></i> 
                    <span>戻る</span> 
                </span> 
            </span>                
            
        </div> -->
        <h4 class="profile-tit">{{cat_name}}
       <!--  <span @click="$router.go(-1);" class="backbtn pc-2000" style="cursor:pointer;top: 0px;">
            <span class="btn btn-danger all-btn submit">
                <i class="fas fa-arrow-left"></i> 
                <span>戻る</span> 
            </span>  
        </span>   -->       
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
    <div v-else-if="block && w_width > 480" v-for="(group,index) in news" :key="index" class="row m-lr-0" :class="'bordertop-color'+(5-(Math.floor(cat_id%5)))">        
        <slick :options="slickOptions" class="news-slider-width">             
            <div class="pad-new pattern-child" v-if="group[0]">
                <div v-for="(value,index) in group[0]" :key="index">
                    <router-link :to="'/newsdetails/'+value.id">
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

            <div class="pad-new pattern-child" v-if="group[1]">
                <div v-for="(value,index) in group[1]" :key="index">
                    <router-link :to="'/newsdetails/'+value.id"> 
                        <div class="col-12 row m-b-10 adslist-card m-lr-0 news-3-card">

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

            <div class="pad-new pattern-child" v-if="group[2]">
                <router-link v-for="(value,inx) in group[2]" :key="inx" :to="'/newsdetails/'+value.id" style="color:#333;">  
                    <p class="text-truncate news-list-display">

                        <i class="fas fa-building"></i> {{value.main_point}}

                    </p>
                </router-link>
            </div>

            <div class="pad-new pattern-child" v-if="group[3]">    
                <div v-for="(value,index) in group[3]" :key="index">
                    <router-link :to="'/newsdetails/'+value.id">

                        <div class="col-12 single-news-box">

                            <clazy-load class="wrapper-3" @load="log" src="/images/noimage.jpg" :key="index">

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
                            <p>{{value.main_point}}</p>

                        </div>

                    </router-link>
                </div>
            </div>                    
        </slick>
    </div>
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
   data() {

        return {
            news:[],
            searchnews:[],
            cat_name:'',
            cat_id:'',
            search_word:null,
            norecord_msg:false,
            block:false,
            nonblock:false,
            w_width: $(window).width(),
        }
   },
   created(){
    if($(window).width() > 480){
         this.axios.get(`/api/newscategory/${this.$route.params.id}`).then(response => {
            this.news = response.data.newslist;
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
   }
    
}
</script>
<style scoped>
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
    /* border: 1px solid #f7f7f7; */
    padding: 5px 10px;
    margin-bottom: 4px;
    background: #f7f7f7;
    /* box-shadow: 0px 0px 1px #ddd; */
    border:solid #f3efef;
    border-width: 0 .1rem .1rem 0;
}
.news-3-card {
    background-color: #f7f7f7;
    /* box-shadow: 0 0 2px #ddd; */
    border:solid #f3efef;
    border-width: 0 .1rem .1rem 0;
}

.news-3-card .img-box{
    padding-left: 10px;
}

.single-news-box {
    background: #f7f7f7;
    height: 310px;
    padding: 10px;
    /* box-shadow: 0px 0px 2px #ddd; */
    border:solid #f3efef;
    border-width: 0 .1rem .1rem 0;
    overflow: hidden;
}
</style>
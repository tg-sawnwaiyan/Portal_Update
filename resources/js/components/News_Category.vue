<template>
<layout>   
<div>    
    <div class="col-12">
        <div class="pc-991-1880">
            <a href="/" class="backbtn" style="cursor:pointer;right:0;top:1%;;position:relative;">
                <span class="btn btn-danger all-btn submit">
                    <i class="fas fa-arrow-left"></i> 
                    <span>戻る</span> 
                </span> 
            </a>                
            
        </div>
        <h4 class="profile-tit">{{cat_name}}
        <span @click="$router.go(-1);" class="backbtn pc-2000" style="cursor:pointer;top: 0px;">
            <span class="btn btn-danger all-btn submit">
                <i class="fas fa-arrow-left"></i> 
                <span>戻る</span> 
            </span>  
        </span>         
        </h4>
        
    </div>       
       
    <div class="col-sm-12 col-md-9 col-lg-6 pad-new m-b-15 mt-750-10 float-right">
        
        <!--search input-->
        <div class="search-input m-b-10">
            <span class="btn btn col-md-12 my-sm-0 danger-bg-color btn-danger cross-btn" v-if="status == 1" @click="clearSearch()">X</span>
            <input typee="text" class="searchNews" placeholder="ニュース検索" id="search-free-word" v-bind:value="search_word">
            <button type="submit" class="searchButtonNews" @click="searchCategory()">
                <i class="fas fa-search"></i> 検索
            </button>
        </div>
        <!--end search input-->  
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
    <div v-else class="row col-12 m-lr-0 p-0">
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
</div>
</layout>
</template>

<script>
    import layout from '../components/home.vue'
export default {

 components: {
    layout
  },
   data() {

        return {
            news:[],
            cat_name:'',
            search_word:null,
            norecord_msg:false,
        }
   },
   created(){
         this.axios.get(`/api/newscategory/${this.$route.params.id}`).then(response => {
            this.news = response.data.newslist;
            if(response.data.newslist.length == 0)
            {
                 this.norecord_msg = true;
            }
            else{
                 this.norecord_msg = false;
            }
            this.cat_name = response.data.cat_name;
          
      });
   },
   methods:{
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
                        var searchword = 'all_news_search';                
                    } else {
                        var searchword = this.search_word;
                    }
                    this.axios.get('/api/get_news_by_catId/'+searchword+'/'+this.$route.params.id).then(response => {
                    this.$loading(false);
                    this.news = response.data;
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
</style>
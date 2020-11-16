<template>
    <div class="tab-pane" id="tab1">
            <!-- slider -->
            <div v-if="this.$route.path === '/' || this.$route.path.includes('/newscategory')" class="card-header d-sm-block tab-card-header clearfix cat-nav infoBox" ref="infoBox" style="margin: 0 0.4rem 1.65rem 0.4rem;">
                <span id="left-button" class="left-arr-btn arr-btn d-none-sp" @click="swipeLeft" v-if="is_cat_slided" ><i class="fas fa-angle-left"></i></span>
                <div class="nav nav-tabs card-header-tabs center no-scrollbar" id="myTab" ref="content" v-bind:style="{ width: computed_width }">
                    <ul class="nav nav-tabs" role="tablist">
                        <li id="top" class="nav-item nav-line tab-color0"><a id='top_a' class="nav-link nav-line" v-on:click="changeBgColor(0);" href="/">トップ</a></li><li v-for="(cat, index) in cats" :key="cat.id" class="nav-item nav-line" id="category-id" :class="'tab-color'+(5-(Math.floor(cat['id']%5)))" v-bind:value="cat.id" v-on:click="scrollUp(index);changeBgColor((5-(Math.floor(cat['id']%5))));" ref="itemWidth">
                           <router-link class="nav-link" :to="{ path:'/newscategory/'+ cat.id}">{{ cat.name }}</router-link>
                        </li>

                    </ul>                            
                </div>
               
                <span id="right-button"  class="right-arr-btn arr-btn d-none-sp" @click="swipeRight" v-if="is_cat_overflow" ><i class="fas fa-angle-right"></i></span>
                <div class="bg_color"></div>
            </div>      
    </div>
</template>
<script>
export default {
    mounted() {
        if(localStorage.getItem("clicked") == null){
            localStorage.setItem('clicked', 1);
        }            
        this.getAllCat();
    },
    data(){
        return {
            cats: [],
            categoryId: 1,
            othersDetails: true,
            status:'0',
            search_word:null,
            post_groups : [],
            norecord_msg: false,
            is_cat_overflow: false,
            is_cat_slided: false,
            computed_width: '100%',
            cat_box_width: null,
            w_width: $(window).width(),
        }
    },
    created() {
        if(this.$route.path.includes("/newsdetails") && this.$auth.check(2) && this.visit == 'false'){
            this.othersDetails = false;
        }
        else{
            this.othersDetails = true;
        }
        this.$nextTick(() => {
            if(this.$refs.infoBox){
                this.cat_box_width = this.$refs.infoBox.clientWidth;
            }            
        }) 
    },
    methods: {
        getAllCat: function() {
           
                this.axios .get('/api/home') 
                .then(response => {
                        this.cats = response.data;
               
         
                        var total_word = 0;
                        $.each(this.cats, function(key,value) {
                            total_word += value.name.length;
                        });
 
                        if(this.cat_box_width/total_word < 26){
                            this.is_cat_overflow = true;
                            this.computed_width = '99.8%';
                        }

                        this.getPostByCatID();

                        this.getLatestPostByCatID();

                    });

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
        changeBgColor(no) {
            const color_ary = ['#0066CC','#a3774a','#9579ef','#21d1de','#d1291d','#63b7ff'];
            $('.bg_color').css('background-color', color_ary[no]);
        },
        
        swipeLeft() {
            const content = this.$refs.content;
            this.scrollTo(content, -300, 800);
        },

        swipeRight() {
            const content = this.$refs.content;
            this.scrollTo(content, 300, 800);
            this.is_cat_slided = true;
            this.computed_width = '98%';
        },
        scrollUp(index){
           // localStorage.clear();
            if(localStorage.getItem("clicked")){
                if(index >= localStorage.getItem('clicked')){
                    var pos = $('div.nav').scrollLeft() + 100;
                }else{
                    var pos = $('div.nav').scrollLeft() - 100;
                }
            }
            $('div.nav').scrollLeft(pos);
            localStorage.setItem('clicked', index);

    
        },
        scrollTo(element, scrollPixels, duration) {

                const scrollPos = element.scrollLeft;

                // Condition to check if scrolling is required

                if ( !( (scrollPos === 0 || scrollPixels > 0) && (element.clientWidth + scrollPos === element.scrollWidth || scrollPixels < 0)))

                {

                    // Get the start timestamp

                    const startTime =

                    "now" in window.performance

                        ? performance.now()

                        : new Date().getTime();



                    function scroll(timestamp) {

                    //Calculate the timeelapsed

                    const timeElapsed = timestamp - startTime;

                    //Calculate progress

                    const progress = Math.min(timeElapsed / duration, 1);

                    //Set the scrolleft

                    element.scrollLeft = scrollPos + scrollPixels * progress;

                    //Check if elapsed time is less then duration then call the requestAnimation, otherwise exit

                    if (timeElapsed < duration) {

                        //Request for animation

                        window.requestAnimationFrame(scroll);

                    } else {

                        return;

                    }

                    }

                    //Call requestAnimationFrame on scroll function first time

                    window.requestAnimationFrame(scroll);

                }

        },


    }
}
 
$(document).ready(function(){
    // $("#top_a").addClass("active");
    var url      = window.location.href; 
    if(url.indexOf('category') == -1){
        $("#top_a").addClass("active");
    }
});
</script>
<style>
    #myTab ul li {
        display: -ms-inline-flexbox;
        display: inline-flex;
        display: -webkit-inline-flex;
    }
    
    .hospital-tabColor li.subtab3 > .router-link-active{
        background: #fff!important;
        color: #63b7ff !important;
        border-bottom-color: transparent !important;
        border-top: 3px solid #63b7ff !important;
        border-bottom: 0px !important;
        /* border-left: 1px solid #63b7ff !important; */
    }
    .hospital-tabColor li.subtab3 > .router-link-exact-active>i.fa, .hospital-tabColor li.subtab3 > .router-link-active>i.fas {
        color: #63b7ff !important;
    }

    .news-tabColor .nav-link {
        background: #75b777 !important;
        color: #fff;
        border-right: 1px solid #fff;
        border-bottom: 0px !important;
    }
    .news-tabColor li.subtab1 > .router-link-active{
        background: #fff!important;
        color: #75b777 !important;
        border-bottom-color: transparent !important;
        border-top: 3px solid #75b777 !important;
        border-left: 1px solid #75b777 !important;
        border-bottom: 0px !important;
    }
    .news-tabColor li.subtab1 > .router-link-exact-active>i.fa, .news-tabColor li.subtab1 > .router-link-active>i.fas {
        color: #75b777 !important;
    }

    .nursing-tabColor .nav-link {
        /* background: #ff9563 !important; */
        background: #63b7ff !important;
        color: #fff;
        border-right: 1px solid #fff;
        border-bottom: 0px !important;
    }
    .nursing-tabColor li.subtab2 > .router-link-active{
        background: #fff!important;
        /* color: #ff9563 !important; */
        color: #63b7ff !important;
        border-bottom-color: transparent !important;
        /* border-top: 3px solid #ff9563 !important; */
        border-top: 3px solid #63b7ff !important;
        border-bottom: 0px !important;
        /* border-left: 1px solid #ff9563 !important; */
    }
    .nursing-tabColor li.subtab2 > .router-link-exact-active>i.fa, .nursing-tabColor li.subtab2 > .router-link-active>i.fas {
        /* color: #ff9563 !important; */
        color: #63b7ff !important;
    }


    .job-tabColor .nav-link {
        background: #828282 !important;
        color: #fff;
        border-right: 1px solid #fff;
        border-bottom: 0px !important;
    }
    .job-tabColor li.subtab4 > .router-link-active{
        background: #fff!important;
        color: #828282 !important;
        border-bottom-color: transparent !important;
        border-top: 3px solid #828282 !important;
        /* border-left: 1px solid #828282 !important; */
        border-right: 1px solid #828282 !important;
        border-bottom: 0px !important;
    }
    .job-tabColor li.subtab4 > .router-link-exact-active>i.fa, .job-tabColor li.subtab4 > .router-link-active>i.fas {
        color: #828282 !important;
    }

    .job-borderColor {
        border: 1px solid #828282 !important;
    }

    .news-borderColor {
        border: 1px solid #75b777 !important;
    }

    .hospital-borderColor {
        border: 1px solid #63b7ff !important;
    }

    .nursing-borderColor {
        /* border: 1px solid #ff9563 !important; */
         border: 1px solid #63b7ff !important;
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
        /* float: left;
        width: 38.9%;
        border: 1px solid black;
        margin: 1px; */
        /* width: 95%; */
        overflow: hidden;
        white-space: nowrap;
        display: inline-block;
        /* max-width: 100%; */
    }

    .card-header-tabs {
        margin-right: -1.65rem;
        /* margin-bottom: 0rem; */
        margin-left: -1.65rem;
        border-bottom: 0;
    }
    .cat-nav {
        padding-bottom: 0;
        height: 36px;
        display: flex;
        padding-left: 1.65rem;
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

    @media only screen and (max-width: 767px){    
    #myTab {
        overflow-x: auto;
        width: 100% !important;
        margin: 0 auto !important;
    }
    .cat-nav {
        margin: 0 auto 15px auto !important;
        padding-left: 0 !important;
        max-height: 43px;
        position: relative;
        height: auto;
        margin: 0 auto 15px auto !important;
        }
    .no-scrollbar {
        scrollbar-width: none;
        margin-bottom: 0;
        padding-bottom: 0;
    }
    .no-scrollbar::-webkit-scrollbar {
        display: none;
    }
    .card-header {
        padding: 0 0 3px 0 !important;
    }

    .tab-color0 {        
        height: auto;
        border-left: 5px solid #0066CC;
        background-color: #0066CC;
    }

    .tab-color1 {
        height: auto;
        border-left: 5px solid #a3774a;
        background-color: #a3774a;
    }

    .tab-color2 {
        height: auto;
        border-left: 5px solid #9579ef;
        background-color: #9579ef;
    }

    .tab-color3 {
        height: auto;
        border-left: 5px solid #21d1de;
        background-color: #21d1de;
    }

    .tab-color4 {
        height: auto;
        border-left: 5px solid #d1291d;
        background-color: #d1291d;
    }

    .tab-color5 {
        height: auto;
        border-left: 5px solid #63b7ff;
        background-color: #63b7ff;
    }

    .nav-tabs .router-link-exact-active,
    #myTab .nav-link.active {
        background-color: transparent !important;
        padding: 0.5rem 1rem 0.3rem 1rem;
        height: auto;
    }

    #myTab ul li {
        border-top-right-radius: 8px;
        border-top-left-radius: 8px;
    }

    #myTab .nav-link.active {
        background-color: #0066CC !important;
        border-top-right-radius: 8px !important;
        border-top-left-radius: 8px !important;
    }

    #myTab .nav-link {
        color: #fff !important;
    }

    .tab-card-header {
        background-color: transparent !important;
    }

    .nav-link {
        padding: 0.3rem 1rem;
    }
    .nav {
        display: -webkit-box;
    }
    .bg_color{
        width: 100%;
        height: 3px;
        background-color: #0066CC;
        position: absolute;
        bottom: 0;
        left: 0;
    }

    #top {
        border-top-right-radius: 8px;
        border-top-left-radius: 8px;
    }
    #navtab {
        left: 0px;
        bottom: 0px;
        z-index: 99;
        width: 100%;
        position: fixed;
    }
    .maintab-content {
    padding: 7px 7px 42px 7px;
    }
    .nursing-tabColor li.subtab2 > .router-link-active,
    .news-tabColor li.subtab1 > .router-link-active,
    .job-tabColor li.subtab4 > .router-link-active,
    .hospital-tabColor li.subtab3 > .router-link-active {
        padding: 0;
        height: 42px !important;
    }
    #upper-tab {
    margin-top: 5px;
    }
    }
    @media (max-width: 320px){
    #upper-tab {
    margin-top: 33px;
    }
    }

</style>
<style scoped>
@import "../../../../public/css/categorymenu.css?{{ Config::get('version.date') }}";
</style>



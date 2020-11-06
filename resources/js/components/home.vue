<template>
    <div>
        <!-- <adsSlider></adsSlider> -->
        <!--menu tabs-->
        <ul class="nav nav-tabs news-tabColor navtab tab-menu-responsive" id="navtab" v-if="othersDetails">
            <li role="presentation" class="subtab1 nav-item">
                <router-link  :to="{ name: 'News' }"  class="nav-link"><i class="fas fa-newspaper"></i> ニュース</router-link>
            </li>
            <li role="presentation" class="subtab2 nav-item"  >
                <router-link :to="{ name: 'nursingSearch' }"  class="nav-link"><i class="fas fa-user-md"></i> 介護施設検索</router-link>
            </li>
            <li role="presentation" class="subtab3 nav-item"  >
                <router-link  :to="{ name: 'hospital_search' }"  class="nav-link"><i class="fas fa-briefcase-medical"></i> 病院検索</router-link>
            </li>
            <li role="presentation" class="subtab4 nav-item"  >
                <router-link  :to="{ name: 'jobSearch' }"  class="nav-link"><i class="fas fa-users"></i> 求人検索</router-link>
            </li>
        </ul>
        
        <div class="tabs upper-tab" id="upper-tab">
            <div class="tab-pane" id="tab1">
                <main>
                    <slot />
                </main>
            </div>
        </div>
        <!--end menu tabs-->

    </div>
    <!-- {{ l_storage_hos_history }} -->
</template>

<script>
export default {
    async mounted() {
            
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
 
                        // if(total_word > 32) {
                        //     this.is_cat_overflow = true;
                        //     this.computed_width = '99%';
                        // }
                        // else{
                        //       this.is_cat_overflow = false;
                        // }

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
</style>



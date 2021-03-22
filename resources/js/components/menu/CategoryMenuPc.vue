<template>
    <div class="menu_tab_category" id="tab1" v-if="this.$route.path === '/' || this.$route.path.includes('/newscategory')" ref="infoBox" >
            <!-- Category Menu -->
                <div class="menu_category" ref="content" v-bind:style="{ width: computed_width }">
                    <ul id="ul_menu_category" class="nav nav-tabs" role="tablist" ref="menu">
                        <li v-for="(cat) in cats" :key="cat.id" class="nav-item nav-line tab_color" id="category-id" :style="{'--bkgColor': cat.color_code ? cat.color_code : '#287db4'}" v-bind:value="cat.id" ref="itemWidth">
                           <router-link v-if="cat.name != 'トップ'"  class="nav-link" :to="{ path:'/newscategory/'+ cat.id}"><h2>{{ cat.name }}</h2></router-link>
                           <router-link v-else id="top" class="nav-link" :to="{ path:'/'}"><h2>{{ cat.name }}</h2></router-link>
                        </li>
                    </ul>  
                </div>                
                <span id="left-button" class="left-arr-btn arr-btn d-none-sp" @click="swipeLeft" v-if="is_cat_overflow" ><i class="fas fa-angle-left"></i></span>          
                <span id="right-button"  class="right-arr-btn arr-btn d-none-sp" @click="swipeRight" v-if="is_cat_overflow" ><i class="fas fa-angle-right"></i></span>
    </div>
</template>
<script scoped>
export default {
    data(){
        return {
            cats: [],
            is_cat_overflow: false,
            is_cat_slided: false,
            computed_width: '100%',
            cat_box_width: null,
            w_width: window.innerWidth,
            gap_width: null,
        }
    },
    created() {

        this.getAllCat();
        this.$nextTick(() => {
                if(this.$refs.menu){
                this.cat_box_width = this.$refs.menu.clientWidth;
            }            
        }) 
    },
    updated: function () {
        this.$nextTick(function () {
            // Code that will run only after the
            // entire view has been re-rendered
            var ulWidth = 0;
            $("#ul_menu_category > li").each(function() {
            ulWidth = ulWidth + $(this).width();
            });
            this.menu_width = ulWidth;
            if(this.menu_width > this.cat_box_width){
            this.is_cat_overflow = true;
            // if(this.w_width >= 1440 && this.width <= 1888){
            //     this.computed_width = '94.2% !important';
            // }else if(this.w_width <= 768){                
            //         this.computed_width = '87.7% !important';                
            // }else if(this.w_width <= 1024){                
            //         this.computed_width = '90.7% !important';                
            // }else if(this.w_width >= 1024 && this.w_width <= 1400){                
            //         this.computed_width = '92.8% !important';                
            // }else{
            //     this.computed_width = '93.5% !important';
            // }        
            }
        })
    },
    methods: {
        getAllCat: function() {           
                this.axios .get('/api/home') 
                .then(response => {
                    this.cats = response.data;
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
</script>
<style>
    .tab_color{
        height: auto;
        border-left: 5px solid var(--bkgColor);
        background-color: var(--bkgColor);
    }
    .menu_tab_category{
        position: absolute;
        max-width: 1500px;
        top: 192px;
        z-index: 9;
        width: 100%;
        max-width: 1600px;
    }
    #left-button{
        position: absolute;
        top: 21px;
        left: auto;
        width: auto;
        line-height: 1;
        background: #fff;
        border: 1px solid #2980b9;
        padding: 1px 5px;
        right: 49px;
    }
    #right-button{
        position: absolute;
        top: 21px;
        right: 22px;
        width: auto;
        line-height: 1;
        background: #fff;
        border: 1px solid #2980b9;
        padding: 1px 5px;
    }
    .left-arr-btn .fas,
    .right-arr-btn .fas{
        color: #2980b9 !important;
    }
    .hidden {
        display: none;
    }
    /*@media only screen and (min-width: 561px) and (max-width: 989px){ 
        .tab {
            margin-top: 52px;
        }
    }*/
    @media only screen and (min-width: 561px) and (max-width: 1000px){
        .menu_category{
            /*width: 86.5% !important;*/
            /*margin: 5px 25px 0 21.5px;*/
        }
        /*.upper-tab {
            margin-top: 62.45px;
        }*/
        /*#right-button{
            right: 14px;
        }
        #left-button{
            right: 40px;
        }*/
    }
    @media only screen and (min-width: 991px) and (max-width: 1099px){
        .menu_tab_category{
            top: 204px;
        }
    }
    @media only screen and (min-width: 561px) and (max-width: 900px){
        .menu_tab_category{
            top: 173px;
        }
    }
    @media only screen and (min-width: 561px){
        ul.only_sp{
            display: none;
        }
    }
    @media only screen and (min-width: 1020px) and (max-width: 1050px) {
        .menu_category{
             /*width: 90% !important;*/
             /*margin: 5px 25px 0 21.5px;*/
        }
        /*#right-button{
            right: 13px;
        }
        #left-button{
            right: 39px;
        }*/
        /*.upper-tab {
            margin-top: 64.48px;
        }*/
    }
    @media only screen and (min-width: 1201px) and (max-width: 1280px) {
        .menu_category{
            /*margin: 5px 25px 0 21.7px;*/
        }
    }
    .nav-link h2 {
        padding: 0.2rem 0.1rem;
        font-size: 18px;
    }
    .router-link-exact-active h2 {
        font-weight: bold;
    }
</style>



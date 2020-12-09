<template>
    <div class="menu_tab_category" id="tab1">
            <!-- Category Menu -->
            <div v-if="this.$route.path === '/' || this.$route.path.includes('/newscategory')" ref="infoBox" >
                <span id="left-button" class="left-arr-btn arr-btn d-none-sp" @click="swipeLeft" v-if="is_cat_slided" ><i class="fas fa-angle-left"></i></span>
                <div class="menu_category" ref="content" v-bind:style="{ width: computed_width }">
                    <ul id="ul_menu_category" class="nav nav-tabs" role="tablist">
                        <li v-for="(cat) in cats" :key="cat.id" class="nav-item nav-line tab_color" id="category-id" :style="{'--bkgColor': cat.color_code ? cat.color_code : '#287db4'}" v-bind:value="cat.id" ref="itemWidth">
                           <router-link v-if="cat.name != 'トップ'"  class="nav-link" :to="{ path:'/newscategory/'+ cat.id}">{{ cat.name }}</router-link>
                           <router-link v-else id="top" class="nav-link" :to="{ path:'/'}">{{ cat.name }}</router-link>
                        </li>
                    </ul>                                             
                </div>               
                <span id="right-button"  class="right-arr-btn arr-btn d-none-sp" @click="swipeRight" v-if="is_cat_overflow" ><i class="fas fa-angle-right"></i></span>
                <div class="bg_color"></div>
            </div>      
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
        }
    },
    created() {
        this.getAllCat();
        this.$nextTick(() => {
                if(this.$refs.content){
                this.cat_box_width = this.$refs.content.clientWidth;
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
            if(ulWidth > this.cat_box_width){
            this.is_cat_overflow = true;
            this.computed_width = '99.8%';
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
        top: 13px;
        left: 30px;
        padding: 0;
        width: auto;
    }
    #right-button{
        position: absolute;
        top: 13px;
        right: 30px;
        padding: 0;
        width: auto;
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
            width: 86% !important;
        }
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
            width: 88% !important;
        }
        #left-button{
            left: 36px;
        }
        #right-button{
            right: 36px;
        }
    }
</style>



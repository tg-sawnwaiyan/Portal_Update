<template>
    <div class="tab-pane" id="tab1">
            <!-- slider -->
            <div v-if="this.$route.path === '/' || this.$route.path.includes('/newscategory')" class="card-header d-sm-block tab-card-header clearfix cat-nav infoBox" ref="infoBox" style="margin: 0 0.4rem 1.65rem 0.4rem;">
                <div class="nav nav-tabs card-header-tabs center no-scrollbar" id="myTab" ref="content" v-bind:style="{ width: computed_width }">
                    <ul class="nav nav-tabs" role="tablist">
                        <li v-for="(cat, index) in cats" :key="cat.id" class="nav-item nav-line tab_color" id="category-id" :style="{'--bkgColor': cat.color_code ? cat.color_code : '#287db4'}"  v-bind:value="cat.id" v-on:click="scrollUp(index);changeBgColor(cat.color_code);" ref="itemWidth">
                           <router-link v-if="cat.name != 'トップ'"  class="nav-link" :to="{ path:'/newscategory/'+ cat.id}"><h2>{{ cat.name }}</h2></router-link>
                           <router-link v-else id="top" class="nav-link" :to="{ path:'/'}"><h2>{{ cat.name }}</h2></router-link>
                        </li>

                    </ul>                            
                </div>
                <div class="bg_color" :style="lineStyle"></div>
            </div>      
    </div>
</template>
<script>

import { eventBus } from '../../event-bus.js';

export default {
    mounted() {
        if(localStorage.getItem("clicked") == null){
            localStorage.setItem('clicked', 1);
        } 
    },
    data(){
        return {
            cats: [],
            computed_width: '100%',
            w_width: window.innerWidth,
            bgColor: "",
        }
    },
    created() {              
        this.getAllCat();
    },
    computed: {
        lineStyle() {
        return {
            '--bg-color': this.bgColor,
            }
        }
    },
    updated:function(){
        if(this.$route.path === '/' && this.cats[0]){
            this.bgColor = this.cats[0].color_code ? this.cats[0].color_code : "#287db4";
        }else if(this.$route.path.includes('/newscategory')){
            eventBus.$on('gotColor', color => {
                this.bgColor = color ? color : "#287db4";
            });
        }
    },
    methods: {
        getAllCat: function() {           
                this.axios .get('/api/home') 
                .then(response => {
                        this.cats = response.data;
                        if(this.$route.path.includes('/newscategory')){
                            eventBus.$on('gotColor', color => {
                            this.bgColor = color ? color : localStorage.getItem("bgColor") ? localStorage.getItem("bgColor") : "#287db4";
                            });

                        }else{
                            this.bgColor = this.cats[0].color_code;
                            eventBus.$emit('gotColor', this.cats[0].color_code);
                        }
                    });

        },
        changeBgColor(color_code) {
            this.bgColor =  color_code ? color_code : "#287db4";
            localStorage.setItem('bgColor', this.bgColor);
            eventBus.$emit('gotColor', color_code);
        },
        scrollUp(index){
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
    }
}
</script>
<style>
    .tab_color{
        height: auto;
        border-left: 5px solid var(--bkgColor);
        background-color: var(--bkgColor);
    }
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

    /*.news-borderColor {
        border: 1px solid #75b777 !important;
    }*/

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
        border-left: 5px solid #287db4;
        background-color: #287db4;
    }

    .tab-color1 {
        height: auto;
        border-left: 5px solid #d1281c;
        background-color: #d1281c;
    }

    .tab-color2 {
        height: auto;
        border-left: 5px solid #9579ef;
        background-color: #9579ef;
    }

    .tab-color3 {
        height: auto;
        border-left: 5px solid #20d1de;
        background-color: #20d1de;
    }

    .tab-color4 {
        height: auto;
        border-left: 5px solid #a3774a;
        background-color: #a3774a;
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
        background-color: #287db4 !important;
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
        background-color: var(--bg-color);
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
        height: 60px !important;
    }
    }
    .nav-link h2 {
        padding: 0.2rem;
        font-size: 18px;
    }

</style>



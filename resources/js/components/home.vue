<template>
    <div>
        <!-- <adsSlider></adsSlider> -->
        <!--menu tabs-->
        <ul class="only_sp nav nav-tabs news-tabColor navtab tab-menu-responsive" id="navtab" v-if="othersDetails">
            <li role="presentation" class="subtab1 nav-item">
                <router-link v-on:click.native="activeTopMenu" :to="{ name: 'News' }"  class="nav-link" ><i class="fas fa-newspaper"></i> ニュース</router-link>
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
        
        <div class="tabs upper-tab" id="upper-tab" :style="useStyle">
            <div class="tab-pane" id="tab1">
                <main>
                    <slot />
                </main>
            </div>
            <ul class="navbar-nav pad-free" id="headerbar" v-if="!$auth.check()">
                <li class="fav-item fav-color btn all-btn m-r-10" style="color: #000 !important;">
                    <svg x="0px" y="0px" width="24" height="24" viewBox="0 0 172 172" style=" fill:#000000;"><g fill="none" fill-rule="nonzero" stroke="none" stroke-width="1" stroke-linecap="butt" stroke-linejoin="miter" stroke-miterlimit="10" stroke-dasharray="" stroke-dashoffset="0" font-family="none" font-weight="none" font-size="none" text-anchor="none" style="mix-blend-mode: normal"><path d="M0,172v-172h172v172z" fill="none"></path><g id="original-icon" fill="#c40000" opacity="0" visibility="hidden"><path d="M50.16667,78.83333h107.5v14.33333h-107.5zM50.16667,35.83333h107.5v14.33333h-107.5zM50.16667,121.83333h107.5v14.33333h-107.5zM21.5,75.25c-5.93706,0 -10.75,4.81294 -10.75,10.75c0,5.93706 4.81294,10.75 10.75,10.75c5.93706,0 10.75,-4.81294 10.75,-10.75c0,-5.93706 -4.81294,-10.75 -10.75,-10.75zM21.5,118.25c-5.93706,0 -10.75,4.81294 -10.75,10.75c0,5.93706 4.81294,10.75 10.75,10.75c5.93706,0 10.75,-4.81294 10.75,-10.75c0,-5.93706 -4.81294,-10.75 -10.75,-10.75zM21.5,32.25c-5.93706,0 -10.75,4.81294 -10.75,10.75c0,5.93706 4.81294,10.75 10.75,10.75c5.93706,0 10.75,-4.81294 10.75,-10.75c0,-5.93706 -4.81294,-10.75 -10.75,-10.75z"></path></g><g id="subtracted-icon" fill="#c40000"><path d="M50.16667,78.83333h107.5l0,10.81336c-1.5126,0.69131 -2.92913,1.65951 -4.17264,2.90462l-0.6155,0.61535h-102.71186zM50.16667,35.83333h107.5v14.33333h-107.5zM50.16667,121.83333h24.29256c-1.88479,4.7147 -1.16582,10.22759 2.1569,14.33333h-26.44946zM32.25,86c0,5.93706 -4.81294,10.75 -10.75,10.75c-5.93706,0 -10.75,-4.81294 -10.75,-10.75c0,-5.93706 4.81294,-10.75 10.75,-10.75c5.93706,0 10.75,4.81294 10.75,10.75zM32.25,129c0,5.93706 -4.81294,10.75 -10.75,10.75c-5.93706,0 -10.75,-4.81294 -10.75,-10.75c0,-5.93706 4.81294,-10.75 10.75,-10.75c5.93706,0 10.75,4.81294 10.75,10.75zM32.25,43c0,5.93706 -4.81294,10.75 -10.75,10.75c-5.93706,0 -10.75,-4.81294 -10.75,-10.75c0,-5.93706 4.81294,-10.75 10.75,-10.75c5.93706,0 10.75,4.81294 10.75,10.75zM123.60062,122.43755l-0.6045,-0.60422l1.20887,0z"></path></g><g><g id="Filled_3_" fill="#c40000"><path d="M123.60062,162.99169l-35.82908,-35.82908l10.13652,-10.13652l25.69256,25.69256l40.02993,-40.02993l10.13652,10.13652z"></path></g><g id="Filled_3_" fill="#000000" opacity="0"><path d="M183.90358,122.96087l-50.16644,50.16644c-2.79579,2.80295 -6.46615,4.20085 -10.13652,4.20085c-3.67037,0 -7.34073,-1.39789 -10.13652,-4.20085l-35.82908,-35.82908c-5.59874,-5.59874 -5.59874,-14.67429 0,-20.27304l10.13652,-10.13652c5.59157,-5.59874 14.68146,-5.59874 20.27304,0l15.55604,15.54887l29.89341,-29.88624c5.59157,-5.59874 14.68146,-5.59874 20.27304,0l10.13652,10.13652c5.59874,5.59874 5.59874,14.67429 0,20.27304z"></path></g></g></g></svg>

                    &nbsp; <span class="font-weight-bold">お気に入り</span>                    
                        <div class="div1 fav-nursing-link-box">
                            <router-link to="/favouriteNursing">
                                <i class="fa fa-chevron-circle-right is-nur"></i>
                                <span style="color:#2981cc;">
                                介護&nbsp;<span id="nus-fav-local">{{nusFav}}</span>&nbsp;<span style="color:#000;">件</span>
                                </span>
                            </router-link>
                        </div>
                    
                    
                        <div class="div2 fav-hospital-link-box">
                            <router-link to="/favouriteHospital">
                                <i class="fa fa-chevron-circle-right is-hos"></i>
                                <span style="color:#2981cc;">
                                病院&nbsp;<span id="hos-fav-local">{{hosFav}}</span>&nbsp;<span style="color:#000;">件</span>
                                </span>
                            </router-link>
                        </div>
                    
                </li>
                <li class="fav-item history-color btn all-btn m-r-10" style="color: #000 !important;">
                    <svg x="0px" y="0px" width="24" height="24" viewBox="0 0 172 172" style=" fill:#000000;"><g fill="none" fill-rule="nonzero" stroke="none" stroke-width="1" stroke-linecap="butt" stroke-linejoin="miter" stroke-miterlimit="10" stroke-dasharray="" stroke-dashoffset="0" font-family="none" font-weight="none" font-size="none" text-anchor="none" style="mix-blend-mode: normal"><path d="M0,172v-172h172v172z" fill="none"></path><g fill="#c40000"><path d="M86,15.0472l-78.83333,70.9528h21.5v64.5h59.44694c-1.3545,-4.54367 -2.11361,-9.3525 -2.11361,-14.33333h-43v-63.14225l43,-38.6888l57.61328,51.66439h21.22006zM136.19466,100.24935c-19.78717,0 -35.83333,16.04617 -35.83333,35.83333c0,19.78717 16.04617,35.83333 35.83333,35.83333c19.78717,0 35.83333,-16.04617 35.83333,-35.83333c0,-19.78717 -16.04617,-35.83333 -35.83333,-35.83333zM150.89193,119.24382l10.02213,10.03613l-28.30274,28.30274l-21.13606,-21.13607l10.02213,-10.03613l11.11393,11.11393z"></path></g></g></svg>
                    &nbsp;<span class="font-weight-bold"> 最近見た施設</span>
                    
                        <div class="div1 his-nursing-link-box">
                            <router-link to="/nursing_history">
                            <i class="fa fa-chevron-circle-right is-nur"></i>
                            <span  style="color:#2981cc;">
                            介護&nbsp;<span id="nus-his-local">{{nusHis}}</span>&nbsp;<span style="color:#000;">件</span>
                            </span>
                             </router-link>
                        </div>
                   
                    
                        <div class="div2 his-hospital-link-box">
                            <router-link to="/hospital_history">
                                <i class="fa fa-chevron-circle-right is-hos"></i>
                                <span style="color:#2981cc;">
                                病院&nbsp;<span id="hos-his-local">{{hosHis}}</span>&nbsp;<span style="color:#000;">件</span>
                                </span>
                            </router-link>
                        </div>
                    
                </li>
            </ul>
        </div>
        <!--end menu tabs-->

    </div>
    <!-- {{ l_storage_hos_history }} -->
</template>

<script>
 import { eventBus } from '../event-bus.js';
export default {
    data(){
        return {
            othersDetails: true,
            computed_width: '100%',
            cat_box_width: null,
            lineColor: "",
        }
    },
    computed: {
    useStyle () {
      return {
        '--line-color': this.lineColor
      }
    }
    },
    created() {
        eventBus.$on('gotColor', color => {
            this.lineColor = color ? color : "#287db4";
        });
        
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
        activeTopMenu(){
             $("#top_a").addClass("active");
        }
    }
}
</script>
<style>
    .upper-tab {
        border: 2px solid var(--line-color);
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
        /*border: 1px solid #828282 !important;*/
        border: 1px solid #63b7ff !important;
    }
    .hospital-borderColor {
        border: 1px solid #63b7ff !important;
    }
    .nursing-borderColor {
        /* border: 1px solid #ff9563 !important; */
         border: 1px solid #63b7ff !important;
    }
</style>

<template>
    <div>
        <!--navigation bar without login-->
        <nav class="navbar navbar-expand-lg  main-header">
            <div class="container nav-warp d-flex">
            <div class="d-flex align-items-center">
                <a class="navbar-brand logo-text" href="/">
                <h4 class="logo_subtitle">介護医療福祉の総合サイト</h4>
                <img src="/images/logo.png" style="width:215px;height:auto;" />
                </a>
                
                <div class="h-tel">
                <a class="tel" href="mailto:info@t-i-s.jp"><i class="fas fa-envelope"></i><span>info@t-i-s.jp</span></a>
                <br class="pc-1024">
                </div>               
            </div>
            
            <ul class="gNav">
                <li>
                <router-link :to="{ name: 'News' }"> <i class="fas fa-newspaper"></i> ニュース（ホーム）</router-link>
                </li>
                <li>
                <router-link :to="{ name: 'nursingSearch' }"><i class="fas fa-user-md"></i> 介護施設検索</router-link>
                </li>
                <li>
                <router-link :to="{ name: 'hospital_search' }"> <i class="fas fa-briefcase-medical"></i> 病院検索</router-link>
                </li>
                <li>
                <router-link :to="{ name: 'jobSearch' }"><i class="fas fa-users"></i> 求人検索</router-link>
                </li>
            </ul>
             
            <div class="collapse navbar-collapse  d-flex justify-content-end" id="navbarSupportedContent">
                <div class="d-flex">
                    <ul class="navbar-nav ml-auto pc  d-flex justify-content-end">
                        <li class="nav-item" v-if="!$auth.check()">
                            <button class="nav-link pad-free btn_login" @click="removeAllSess()"><i class="fa fa-sign-in-alt"></i>&nbsp;&nbsp;<span>事業者 ログイン</span></button>
                        </li>
                        <li class="nav-item  m-l-10" v-if="!$auth.check()">
                            <router-link :to="{name: 'register'}" class="nav-link pad-free"><i class="fa fa-user-plus"></i>&nbsp;&nbsp;<span>事業者 登録</span></router-link>
                        </li> 
                    
                        <li class="col-12 userprofile-name pc" v-if="$auth.check()">
                            <span v-if="user.data.type_id == 1">
                                <i class="fa fa-user userprofile-img" aria-hidden="true"></i>
                                <label for="" style="color:#2980b9;font-weight:bold;">{{user.data.name}} </label>
                            </span>
                            <span v-if="user.data.type_id == 2" style="color:#2980b9;">                            
                                <i class="fas fa-briefcase-medical"></i>
                                <span>{{user.data.name}}</span>
                            </span>
                            <span v-if="user.data.type_id >2" style="color:#2980b9;">                                
                                <i class="fas fa-user-md"></i>
                                    <span>{{user.data.name}}</span>
                            </span>                            
                        </li>                    
                    </ul>
                </div>
            </div>
            </div>
            <div id="sp_headerbar">
                <div class="row" style="display: none;">
                   
                    <div class="fav-dropdown col-5 col-md-3 col-sm-3">
                        <span id="dropdownMenuButton" data-toggle="dropdown"><svg x="0px" y="20px" width="18" height="18" viewBox="0 0 172 172" style=" fill:#000000;"><g fill="none" fill-rule="nonzero" stroke="none" stroke-width="1" stroke-linecap="butt" stroke-linejoin="miter" stroke-miterlimit="10" stroke-dasharray="" stroke-dashoffset="0" font-family="none" font-weight="none" font-size="none" text-anchor="none" style="mix-blend-mode: normal"><path d="M0,172v-172h172v172z" fill="none"></path><g id="original-icon" fill="#c40000" opacity="0" visibility="hidden"><path d="M50.16667,78.83333h107.5v14.33333h-107.5zM50.16667,35.83333h107.5v14.33333h-107.5zM50.16667,121.83333h107.5v14.33333h-107.5zM21.5,75.25c-5.93706,0 -10.75,4.81294 -10.75,10.75c0,5.93706 4.81294,10.75 10.75,10.75c5.93706,0 10.75,-4.81294 10.75,-10.75c0,-5.93706 -4.81294,-10.75 -10.75,-10.75zM21.5,118.25c-5.93706,0 -10.75,4.81294 -10.75,10.75c0,5.93706 4.81294,10.75 10.75,10.75c5.93706,0 10.75,-4.81294 10.75,-10.75c0,-5.93706 -4.81294,-10.75 -10.75,-10.75zM21.5,32.25c-5.93706,0 -10.75,4.81294 -10.75,10.75c0,5.93706 4.81294,10.75 10.75,10.75c5.93706,0 10.75,-4.81294 10.75,-10.75c0,-5.93706 -4.81294,-10.75 -10.75,-10.75z"></path></g><g id="subtracted-icon" fill="#c40000"><path d="M50.16667,78.83333h107.5l0,10.81336c-1.5126,0.69131 -2.92913,1.65951 -4.17264,2.90462l-0.6155,0.61535h-102.71186zM50.16667,35.83333h107.5v14.33333h-107.5zM50.16667,121.83333h24.29256c-1.88479,4.7147 -1.16582,10.22759 2.1569,14.33333h-26.44946zM32.25,86c0,5.93706 -4.81294,10.75 -10.75,10.75c-5.93706,0 -10.75,-4.81294 -10.75,-10.75c0,-5.93706 4.81294,-10.75 10.75,-10.75c5.93706,0 10.75,4.81294 10.75,10.75zM32.25,129c0,5.93706 -4.81294,10.75 -10.75,10.75c-5.93706,0 -10.75,-4.81294 -10.75,-10.75c0,-5.93706 4.81294,-10.75 10.75,-10.75c5.93706,0 10.75,4.81294 10.75,10.75zM32.25,43c0,5.93706 -4.81294,10.75 -10.75,10.75c-5.93706,0 -10.75,-4.81294 -10.75,-10.75c0,-5.93706 4.81294,-10.75 10.75,-10.75c5.93706,0 10.75,4.81294 10.75,10.75zM123.60062,122.43755l-0.6045,-0.60422l1.20887,0z"></path></g><g><g id="Filled_3_" fill="#c40000"><path d="M123.60062,162.99169l-35.82908,-35.82908l10.13652,-10.13652l25.69256,25.69256l40.02993,-40.02993l10.13652,10.13652z"></path></g><g id="Filled_3_" fill="#000000" opacity="0"><path d="M183.90358,122.96087l-50.16644,50.16644c-2.79579,2.80295 -6.46615,4.20085 -10.13652,4.20085c-3.67037,0 -7.34073,-1.39789 -10.13652,-4.20085l-35.82908,-35.82908c-5.59874,-5.59874 -5.59874,-14.67429 0,-20.27304l10.13652,-10.13652c5.59157,-5.59874 14.68146,-5.59874 20.27304,0l15.55604,15.54887l29.89341,-29.88624c5.59157,-5.59874 14.68146,-5.59874 20.27304,0l10.13652,10.13652c5.59874,5.59874 5.59874,14.67429 0,20.27304z"></path></g></g></g></svg> お気に入り<span class="count">{{nusFav+hosFav}}件</span></span>

                        <div class="dropdown-menu col-12" aria-labelledby="dropdownMenuButton">
                            <div class="fav-item fav-color t-show">
                                <router-link to="/favouriteNursing">
                                    <div class="dropdown-item div1 fav-nursing-link-box">
                                        <i class="fa fa-chevron-circle-right is-nur"></i>
                                        <span style="color:#2981cc;">
                                        介護&nbsp;<span id="pc-nus-fav-local">{{nusFav}}</span>&nbsp;<span style="color:#000;">件</span>
                                        </span>
                                    </div>
                                </router-link>
                                <router-link to="/favouriteHospital">
                                    <div class="dropdown-item div2 fav-hospital-link-box">
                                        <i class="fa fa-chevron-circle-right is-hos"></i>
                                        <span style="color:#2981cc;">
                                        病院&nbsp;<span id="pc-hos-fav-local">{{hosFav}}</span>&nbsp;<span style="color:#000;">件</span>
                                        </span>
                                    </div>
                                </router-link>
                            </div>
                        </div>
                    </div>
                    <div class="fav-dropdown col-5 col-md-3 col-sm-3">                        
                        <span  style="margin-left:-7px" id="dropdownMenuButton" data-toggle="dropdown"><svg x="0px" y="0px" width="18" height="18" viewBox="0 0 172 172" style=" fill:#000000;"><g fill="none" fill-rule="nonzero" stroke="none" stroke-width="1" stroke-linecap="butt" stroke-linejoin="miter" stroke-miterlimit="10" stroke-dasharray="" stroke-dashoffset="0" font-family="none" font-weight="none" font-size="none" text-anchor="none" style="mix-blend-mode: normal"><path d="M0,172v-172h172v172z" fill="none"></path><g fill="#c40000"><path d="M86,15.0472l-78.83333,70.9528h21.5v64.5h59.44694c-1.3545,-4.54367 -2.11361,-9.3525 -2.11361,-14.33333h-43v-63.14225l43,-38.6888l57.61328,51.66439h21.22006zM136.19466,100.24935c-19.78717,0 -35.83333,16.04617 -35.83333,35.83333c0,19.78717 16.04617,35.83333 35.83333,35.83333c19.78717,0 35.83333,-16.04617 35.83333,-35.83333c0,-19.78717 -16.04617,-35.83333 -35.83333,-35.83333zM150.89193,119.24382l10.02213,10.03613l-28.30274,28.30274l-21.13606,-21.13607l10.02213,-10.03613l11.11393,11.11393z"></path></g></g></svg> 最近見た施設<span class="count2">{{nusHis+hosHis}}件</span></span>
                        <div class="dropdown-menu col-12" aria-labelledby="dropdownMenuButton">
                            <div class="fav-item history-color t-show">
                                <div class="dropdown-item div1 his-nursing-link-box">
                                <router-link to="/nursing_history">
                                <i class="fa fa-chevron-circle-right is-nur"></i>
                                <span  style="color:#2981cc;">
                                介護&nbsp;<span id="pc-nus-his-local">{{nusHis}}</span>&nbsp;<span style="color:#000;">件</span>
                                </span>
                                </router-link>
                                </div>
                                <div class="dropdown-item div2 his-hospital-link-box">
                                    <router-link to="/hospital_history">
                                    <i class="fa fa-chevron-circle-right is-hos"></i>
                                    <span style="color:#2981cc;">
                                    病院&nbsp;<span id="pc-hos-his-local">{{hosHis}}</span>&nbsp;<span style="color:#000;">件</span>
                                    </span>
                                    </router-link>
                                </div>
                            </div>
                        </div>
                    </div>    
                </div>
                 <div style="display: none;" class="wt-4" v-if="this.$route.path !== '/' && this.$route.path != '/nursingFavouriteMail'"> 
                 <span @click="$router.go(-1);">
                    <div style="margin-left:10px;">
                        <i class="fas fa-arrow-left"></i> 
                    </div>
                    <span style="color:#2980b9">戻る</span> 
                </span>
                </div>    
                
                
                <ul class="menu" @click='isNav = !isNav'>
                <li class="first-submenu">
                    <span>メニュー</span>&nbsp;<i :class="!isNav ? open : close" style="width:15px;" ></i>     
                </li>
                <transition name="slide">  
                    <div class="sp_nav"  v-if="isNav">    
                    <ul class="menu_list child">
                        <li>
                        <router-link :to="{ name: 'News' }"><i class="fas fa-newspaper"></i>  ニュース（ホーム）</router-link>
                        </li>
                        <li>
                        <router-link :to="{ name: 'nursingSearch' }"><i class="fas fa-user-md"></i> 介護施設検索</router-link>
                        </li>
                        <li>
                        <router-link :to="{ name: 'hospital_search' }"> <i class="fas fa-briefcase-medical"></i> 病院検索</router-link>
                        </li>
                        <li>
                        <router-link :to="{ name: 'jobSearch' }"><i class="fas fa-users"></i> 求人検索</router-link>
                        </li>
                        <li>
                            <router-link :to="{name: 'sitepolicy'}"><i class="fas fa-info-circle"></i> 利用規約</router-link>
                        </li>
                        <li>
                            <router-link :to="{name: 'privacyPolicy'}"><i class="fa fa-lock"></i> プライバシーポリシー</router-link>
                        </li>
                        <li v-if="!$auth.check()">
                        <router-link :to="{name: 'login'}" class="nav-link pad-free"><i class="fa fa-sign-in-alt"></i> 事業者 ログイン</router-link>
                        </li>
                        <li v-if="!$auth.check()" class="menu-list_last">
                        <router-link :to="{name: 'register'}" class="nav-link pad-free"><i class="fa fa-user-plus"></i> 事業者 登録</router-link>
                        </li>
                        <li>
                        <ul class="contact_list">
                            <li><a href="mailto:info@t-i-s.jp"><i class="fas fa-envelope"></i>info@t-i-s.jp</a></li>     
                        </ul>
                        <ul class="sp_social text-center">
                        
                        </ul> 
                        </li>          
                    </ul>
                    </div>
                </transition>
                </ul>
            </div>
            
        </nav>
        <!--end navigation bar-->
    </div>
</template>
<style>
#sp_headerbar .dropdown-menu {
    background: transparent!important;
    border: 0px!important;
}
#sp_headerbar .fav-item {
    color: #fff !important;
    border: none !important;
    border: 1px solid #544e4e !important;
    cursor: pointer;
    box-shadow: 0 2px 4px 0 rgba(0, 0, 0, 0.16), 0 2px 10px 0 rgba(0, 0, 0, 0.12) !important;
    border-radius: 5px;
}
.fav-dropdown{
    background-color: #fff;
    border: 1px solid #544e4e !important;
    border-radius: 5px;
    margin: 10px 0 0 15px;
    padding: 1px 10px;
    cursor:pointer;
}
.fade-enter-active,
.fade-leave-active {
    transition: opacity .2s ease ;  
}

.fade-enter,
.fade-leave-to {   
  opacity: 0;
}

.slide-enter-active {
   -moz-transition-duration: 0.3s;
   -webkit-transition-duration: 0.3s;
   -o-transition-duration: 0.3s;
   transition-duration: 0.3s;
   -moz-transition-timing-function: ease-in;
   -webkit-transition-timing-function: ease-in;
   -o-transition-timing-function: ease-in;
   transition-timing-function: ease-in;
   transition: transform 0.5s ease;
}

.slide-leave-active {
   -moz-transition-duration: 0.3s;
   -webkit-transition-duration: 0.3s;
   -o-transition-duration: 0.3s;
   transition-duration: 0.3s;
   -moz-transition-timing-function: cubic-bezier(0, 1, 0.5, 1);
   -webkit-transition-timing-function: cubic-bezier(0, 1, 0.5, 1);
   -o-transition-timing-function: cubic-bezier(0, 1, 0.5, 1);
   transition-timing-function: cubic-bezier(0, 1, 0.5, 1);
}

.slide-enter-to, .slide-leave {
   max-height: 100vh;
   overflow: hidden;
}

.slide-enter, .slide-leave-to {
   overflow: hidden;
   max-height: 100vh;
  transform: translateX(-100%);
  transition: all 0.5s ease-in 0s;
}

.btn_login {
    border: 0;
    background-color: #fff;
}
</style>
<script>
  export default {
    data(){
      return{
        user:'',
        isFav : false,
        isHistory: false,
        isNav: false,
        isMenu: false,
        open : 'fa fa-bars' , 
        close : 'fa fa-times',
        cusName : '',
        cusType :'',
      }
    },
    mounted() {
  
        if(localStorage.getItem("visit")){
            this.visit = localStorage.getItem("visit");
        }
        else{
            if(this.$auth.check()){
                localStorage.setItem('visit', 'false');
            }
            else{
                localStorage.setItem('visit', 'true');
            }
        }
        this.user = this.$auth.watch._data;
        if(localStorage.getItem("hospital_history")){
            this.hosHis = localStorage.getItem("hospital_history").split(",").length;
            $('.his-hospital-link-box>a').css({'cursor':'pointer','pointer-events':'auto'});
        }
        else{
            this.hosHis = 0;
            $('.his-hospital-link-box>a').css({'cursor':'not-allowed','pointer-events':'none'});
            $( '.his-hospital-link-box>a ').parent('div').css({'cursor':'not-allowed'});
        }
        if(localStorage.getItem("nursing_history")){
            this.nusHis = localStorage.getItem("nursing_history").split(",").length;
            $('.his-nursing-link-box>a').css({'cursor':'pointer','pointer-events':'auto'});
        }
        else{
            this.nusHis = 0;
            $('.his-nursing-link-box>a').css({'cursor':'not-allowed','pointer-events':'none'});
            $( '.his-nursing-link-box>a').parent('div').css({'cursor':'not-allowed'});
        }
        if(localStorage.getItem("hospital_fav")){
            this.hosFav = localStorage.getItem("hospital_fav").split(",").length;
            $('.fav-hospital-link-box>a').css({'cursor':'pointer','pointer-events':'auto'});
        }
        else{
            this.hosFav = 0;
            $('.fav-hospital-link-box>a').css({'cursor':'not-allowed','pointer-events':'none'});
            $( '.fav-hospital-link-box>a').parent('div').css({'cursor':'not-allowed'});
        }
        if(localStorage.getItem("nursing_fav")){            
            this.nusFav = localStorage.getItem("nursing_fav").split(",").length;
            $('.fav-nursing-link-box>a').css({'cursor':'pointer','pointer-events':'auto'});
        }
        else{
            this.nusFav = 0;
            $('.fav-nursing-link-box>a').css({'cursor':'not-allowed','pointer-events':'none'});
            $( '.fav-nursing-link-box>a').parent('div').css({'cursor':'not-allowed'});
        }
    },
    methods: {
        removeAllSess: function() {
            localStorage.setItem('visit', '');
            localStorage.setItem('loginuser', '');
            localStorage.setItem('logintoken', '');
            this.$router.push('/login');
        },
    }
}
</script>
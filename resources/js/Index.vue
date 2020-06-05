<template>
    <div>
        <div id="main" class="pad-free" :class="[!$auth.check() ? inner : (visit == 'true'?inner:full),this.$route.name == 'profile'? footermargin : '']" v-if="this.$route.path !== '/register' && this.$route.path !== '/login' && this.$route.path !== '/reset' && this.$route.path !== '/resetpassword' && this.$route.path !== '/Unauthorized' && this.$route.path !== '/admin_login' && this.$route.path !== '/admin/t_is_admin_register' && this.$route.path !== '/admin/create' && this.$route.name !== 'adminedit' && this.$route.name !== '404'" >
            <button @click="topFunction()" id="myBtn">Top</button>
            <HeaderMenu v-if="!$auth.check()"></HeaderMenu>
            <AuthHeaderMenu v-if="$auth.check()"></AuthHeaderMenu>

            <div class="sidebar-scroll container-fluid">
                <div class="row"> 
                    <asideMenu v-if="$auth.check()"></asideMenu>
                    <!-- <div v-if="$auth.check()">
                            <sidebar-menu :menu="menu" v-if="visit == 'false'" :collapsed="collapsed" @toggle-collapse="onCollapse"  @item-click="onItemClick"/>
                        </div>  -->
                    <!-- <div id="menu-overlay" @click="menuToggle()"></div> -->
                <!-- login ================================================================================================== -->
                
                   

                <!-- not login================================================================================================================ -->
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 pad-free"  v-if="!$auth.check() || visit == 'true'" id="content-all">
                        <div class="maintab-content" id="v-pills-tabContent">
                            <!--section one-->
                            <section>
                                <div class="main-wrapper">
                                    <!--slider for ads-->
                                    <div class="col-md-auto pad-free">
                                        <adsslider class="d-none d-sm-block"></adsslider>
                                    </div>
                                        <!--end slider for ads-->
                                    <div class="row justify-content-md-center">
                                        <div class="col-12 col-lg-12 col-md-12 tab p0-480">
                                        <!-- vue component -->
                                            <router-view :key="$route.fullPath"></router-view>
                                    </div>
                                        
                                    </div>
                                </div>
                                <div class="container-fluid footer footer-div">
                                    <span>Copyright©TRUST-ESTATE Co,Ltd.All Rights Reserved. </span>
                                </div>
                            </section>
                        </div>
                    </div>
                </div>
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
       
        <div v-else>
            <router-view :key="$route.fullPath"></router-view>
        </div>
    </div>
</template>
<style scoped>
.fade-enter-active,
.fade-leave-active {
  transition: opacity 1s ease-in;
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

/* .sidebar-scroll {
    padding-left: 280px;
} */
.content-all.collapsed {
    padding-left: 50px;
}

.router-link-exact-active>i.fa, .router-link-exact-active>i.fas {
    color: #fff !important;
}
</style>
<script>
  import HeaderMenu from './components/menu/Menu.vue'
  import AuthHeaderMenu from './components/menu/AuthMenu.vue'
  import asideMenu from './components/menu/asideMenu.vue'
  import adsslider from './components/adsslider'
  export default {
    data: function() {        
      return {
        nursing_fav:'',     
        inner : 'main-content',
        full: 'full-content',
        footermargin: 'footer-margin',
        myBtnScroll: false,
        status:false,      
        window:{
                width: 0,
                height: 0
        },
        w_width:$(window).width(),
      }
    },
    components: {
      HeaderMenu,
      AuthHeaderMenu,
      asideMenu,
      adsslider
    }, 
    created() {
         window.addEventListener('resize', this.handleResize)
        this.handleResize();
        if(this.window.width <= 1440) {
            $(document).scroll(function() {　　　　
                var cur_pos = $(this).scrollTop();
                if (cur_pos >= 100) {
                    $('#headerbar').css('top','135px');
                    $('#headerbar li').css('display','block');
                    $('#myBtn').css('display','block');
                } else {
                    $('#headerbar').css('top','86px');
                    $('#headerbar li').css('display','inline-block');
                    $('#myBtn').css('display','none');
                }
            });                
        }
        document.addEventListener('scroll', this.handleScroll);
        
        axios.interceptors.response.use((response) => {
        console.log("token status",response.data.status)
        if((response.data.status == "Token is Expired" || response.data.status == "Token is Invalid") && this.status == false ){
        this.status = true;        
        this.visit = 'true';
        this.loginuser = 'false';
        localStorage.setItem('visit',this.visit);
        localStorage.setItem('loginuser',this.loginuser);
        this.$router.push({name: 'Unauthorized'});
        }
        
        return response

        })
    },
    destroyed() {
        document.removeEventListener('scroll', this.handleScroll);
    },
    mounted(){
        
        if(localStorage.getItem("visit")){
            this.visit = localStorage.getItem("visit");       
        }
        else{
            localStorage.setItem('visit', this.visit);
        }  
        if(localStorage.getItem("loginuser")){
            this.loginuser = localStorage.getItem("loginuser");       
        }
        else{
            localStorage.setItem('loginuser', this.loginuser);
        }  
        if(localStorage.getItem("hospital_history")){
            // $("#hos-his-local").html(localStorage.getItem("hospital_history").split(",").length);
            this.hosHis = localStorage.getItem("hospital_history").split(",").length;
            $('.his-hospital-link-box>a').css({'cursor':'pointer','pointer-events':'auto'});
        }
        else{
            // $("#hos-his-local").html(0);
            this.hosHis = 0;
            $('.his-hospital-link-box>a').css({'cursor':'not-allowed','pointer-events':'none'});
            $('.his-hospital-link-box>a ').parent('div').css({'cursor':'not-allowed'});
        }
        if(localStorage.getItem("nursing_history")){
            // $("#nus-his-local").html(localStorage.getItem("nursing_history").split(",").length);
            this.nusHis = localStorage.getItem("nursing_history").split(",").length;
            $('.his-nursing-link-box>a').css({'cursor':'pointer','pointer-events':'auto'});
        }
        else{
            // $("#nus-his-local").html(0);
            this.nusHis = 0;
            $('.his-nursing-link-box>a').css({'cursor':'not-allowed','pointer-events':'none'});
            $( '.his-nursing-link-box>a').parent('div').css({'cursor':'not-allowed'});
        }
        if(localStorage.getItem("hospital_fav")){
            this.hosFav = localStorage.getItem("hospital_fav").split(",").length;
            // $("#hos-fav-local").html(localStorage.getItem("hospital_fav").split(",").length);
            $('.fav-hospital-link-box>a').css({'cursor':'pointer','pointer-events':'auto'});
        }
        else{
            // $("#hos-fav-local").html(0);
            this.hosFav = 0;
            $('.fav-hospital-link-box>a').css({'cursor':'not-allowed','pointer-events':'none'});
            $( '.fav-hospital-link-box>a').parent('div').css({'cursor':'not-allowed'});
        }
        if(localStorage.getItem("nursing_fav")){
            // $("#nus-fav-local").html(localStorage.getItem("nursing_fav").split(",").length);
             this.nusFav = localStorage.getItem("nursing_fav").split(",").length;
       
        
            $('.fav-nursing-link-box>a').css({'cursor':'pointer','pointer-events':'auto'});
        }
        else{
            // $("#nus-fav-local").html(0);
            this.nusFav = 0;
            $('.fav-nursing-link-box>a').css({'cursor':'not-allowed','pointer-events':'none'});
            $( '.fav-nursing-link-box>a').parent('div').css({'cursor':'not-allowed'});
        }

    },

    methods: {
        handleResize() {
            this.window.width = window.innerWidth;
            this.window.height = window.innerHeight;
        },  
        menuToggle(){
            $("#admin-side-menu").toggle('medium');
            $("#menu-overlay").toggle('medium');
        },
        handleScroll(){
            if (document.scrollTop > 20 || document.documentElement.scrollTop > 20) {
                this.myBtnScroll = true;
            } else {
                this.myBtnScroll = false;
            }
        },
        topFunction() {
            $("html, body").animate({ scrollTop: 0 }, "slow");
	        return false;
        },
        onItemClick(event, item){
            if(item.title == 'ログアウト'){
                this.loginuser = 'false';
                localStorage.setItem('loginuser', this.loginuser);
                if(this.$auth.check(2)){
                    this.$auth.logoutAdmin();
                }
                else{
                    this.$auth.logout();
                }
            }
        },
        onCollapse (collapsed) {
      this.collapsed = collapsed
    }
    }


  }
</script>




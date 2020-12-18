<template>
    <div>
        <!--navigation bar when login-->
        <nav class="navbar navbar-expand-lg" :class="visit == 'true' ?  main_header: admin_header">
            <div class="nav-warp d-flex"  :class="visit == 'true' ?  container: ''">
                <div class="d-flex align-items-center">
                    <a class="navbar-brand logo-text" href="/" v-if="visit == 'true'">
                        <h4 class="logo_subtitle">介護医療福祉の総合サイト</h4>
                        <img src="/images/logo.png" alt="TIS" class="nav-img"/>
                    </a>
                    <a class="nav-a-img" href="/"  v-if="visit != 'true'">    
                      <img src="/images/admin_logo1.png" class="nav-img02"/>
                    </a>
                    <div class="h-tel" v-if="visit == 'true'">
                        <a class="tel" href="mailto:info@t-i-s.jp">
                            <i class="fas fa-envelope"></i>
                            <span>info@t-i-s.jp</span>
                        </a>
                        <br class="pc-1024">
                    </div>
                </div>
                <ul class="gNav">
                    <li v-if="visit == 'false'">
                        <router-link :to="{ name: 'News' }"> サイトを表示</router-link>
                    </li>
                    <li v-if="visit == 'true'">
                        <router-link :to="{ name: 'News' }"> <i class="fas fa-newspaper"></i> ニュース（ホーム）</router-link>
                    </li>
                    <li v-if="visit == 'true'">
                        <router-link :to="{ name: 'nursingSearch' }"><i class="fas fa-user-md"></i> 介護施設検索</router-link>
                    </li>
                    <li v-if="visit == 'true'">
                        <router-link :to="{ name: 'hospital_search' }"> <i class="fas fa-briefcase-medical"></i> 病院検索</router-link>
                    </li>
                    <li v-if="visit == 'true'">
                        <router-link :to="{ name: 'jobSearch' }"><i class="fas fa-users"></i> 求人検索</router-link>
                    </li>
                </ul>
                <div class="collapse navbar-collapse  d-flex justify-content-end" id="navbarSupportedContent">
                    <div class="d-flex">
                        <ul class="navbar-nav ml-auto pc  d-flex justify-content-end">
                            <li class="nav-item" v-if="!$auth.check()">
                            <router-link :to="{name: 'login'}" class="nav-link pad-free"><i class="fa fa-sign-in-alt"></i>&nbsp;&nbsp;<span>事業者 ログイン</span></router-link>
                        </li>
                        <li class="nav-item  m-l-10" v-if="!$auth.check()">
                            <router-link :to="{name: 'register'}" class="nav-link pad-free"><i class="fa fa-user-plus"></i>&nbsp;&nbsp;<span>事業者 登録</span></router-link>
                        </li>
                        <li class="nav-item m-r-10" v-if="visit == 'true'">
                            <a class="nav-link pad-free d-flex h-100 align-items-center mt-0" @click="gotoDash()"><i class="fas fa-tachometer-alt mr-1"></i> 管理画面へ</a>
                        </li>
                        <li class="userprofile-name pc" v-if="$auth.check()">
                            <span v-if="user.data">
                                <span v-if="user.data.type_id == 1">
                                    <i class="fa fa-user userprofile-img" aria-hidden="true"></i>
                                    <label for="" class="name-label">{{user.data.name}} </label>
                                </span>
                                <span v-if="user.data.type_id == 2" class="span-color">
                                    <i class="fas fa-briefcase-medical userprofile-img"></i>
                                    <label for="" class="name-label">{{user.data.name}}</label>
                                </span>
                                <span v-if="user.data.type_id >2" class="span-color">
                                    <i class="fas fa-user-md userprofile-img"></i>
                                    <label for=""class="name-label">{{user.data.name}}</label>
                                </span>
                            </span>
                        </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div id="sp_adminheader" v-if="visit == 'false'">                
                <div class="admin_menu"  @click="toggle('sub')" >
                    <span>メニュー</span>&nbsp;<i :class="!isNav? open : close"></i>
                </div>
                <div class="overlay_wrap"  v-if="isNav" v-on:click="isNav = !isNav">
                    <div class="overlay"></div> 
                </div>
                <transition name="slide">  
                    <div class="sp_adminNav"  v-if="isNav">
                        <ul class="sidebar_brand" v-if="visit != 'true'">
                             <li v-if="$auth.check(1)" class="admin_head admin_head01">
                               事業者管理画面
                            </li>
                            <li v-if="$auth.check(2)" class="admin_head admin_head02">
                               管理者画面
                            </li>                            
                            <li v-if="$auth.check(1)" @click="toggle">
                                <router-link :to="{ path: `/profiledit/${this.$auth.user().type_id == 2 ? 'hospital/': 'nursing/'}${this.$auth.user().customer_id}` }"><i class="fa fa-cog"></i>  プロフィール設定</router-link>
                            </li>
                            <li v-if="$auth.check(1)" @click="toggle">                              

                                <router-link v-if="this.$auth.user().type_id == 2" :to="{ path: `/accountlist/${this.$auth.user().type_id == 2 ? 'hospital/': 'nursing/'}${this.$auth.user().customer_id}` }"><i class="fa fa-user"></i>  病院一覧</router-link>

                                <router-link v-else :to="{ path: `/accountlist/${this.$auth.user().type_id == 2 ? 'hospital/': 'nursing/'}${this.$auth.user().customer_id}` }"><i class="fa fa-user"></i>  施設一覧</router-link>
                                
                            </li>
                            <li v-if="$auth.check(2)">
                                <span @click="subMenu(1)" :class="{ active : isActive == 1 }"><i class="fa fa-list-ul"></i>  ニュース <i class="fas fa-angle-right" :class="{ down : isRotate == 1 }"></i></span>
                                <transition name="slideup">
                                    <ul class="sub_menu" v-show="isSubmenu[1].show">
                                        <li  @click="toggle('sub')">
                                            <router-link :to="{ name: 'news_list' }" ><i class="fa fa-file-alt"></i>  ニュース一覧</router-link>
                                        </li>
                                        <li @click="toggle('sub')">
                                            <router-link :to="{ name: 'categorylist' }"><i class="fa fa-file-alt"></i>  カテゴリー設定</router-link>
                                        </li>
                                        <li @click="toggle('sub')">
                                            <router-link :to="{ name: 'ads' }"><i class="fa fa-globe"></i>  広告</router-link>
                                        </li>
                                    </ul>
                                </transition>
                            </li>
                            <li v-if="$auth.check(2)">
                                <span @click="subMenu(2)" :class="{ active : isActive == 2 }"><i class="fa fa-user-md"></i>  介護施設 <i class="fas fa-angle-right" :class="{ down : isRotate == 2 }"></i></span>
                                <transition name="slideup">
                                    <ul class="sub_menu" v-show="isSubmenu[2].show">
                                        <li @click="toggle('sub')">
                                            <router-link :to="{ name: 'nuscustomerlist' }"><i class="fa fa-user"></i>  事業者一覧</router-link>
                                        </li>
                                        <li @click="toggle('sub')">
                                            <router-link :to="{ name: 'nusfeaturelist' }"><i class="fa fa-file-alt"></i>  特長設定</router-link>
                                        </li>
                                        <li @click="toggle('sub')">
                                            <router-link :to="{ name: 'nuscommentlist' }"><i class="fa fa-list"></i>  口コミ一覧</router-link>
                                        </li>
                                    </ul>
                                </transition>
                            </li>
                            <li v-if="$auth.check(2)">
                                <span @click="subMenu(3)" :class="{ active : isActive == 3 }"><i class="fas fa-briefcase-medical"></i>  病院 <i class="fas fa-angle-right" :class="{ down : isRotate == 3 }"></i></span>
                                <transition name="slideup">
                                    <ul class="sub_menu" v-show="isSubmenu[3].show">
                                        <li @click="toggle('sub')">
                                            <router-link :to="{ name: 'hoscustomerlist' }"><i class="fa fa-user"></i>  事業者一覧</router-link>
                                        </li>
                                        <li @click="toggle('sub')">
                                            <router-link :to="{ name: 'facilitieslist' }"><i class="fa fa-list"></i>  院内施設設定</router-link>
                                        </li>
                                        <li @click="toggle('sub')">
                                            <router-link :to="{ name: 'hosfeaturelist' }"><i class="fa fa-list"></i>  特長設定</router-link>
                                        </li>
                                        <li @click="toggle('sub')">
                                            <router-link :to="{ name: 'subjectlist' }"><i class="fa fa-list"></i>  診療科目設定</router-link>
                                        </li>
                                        <li @click="toggle('sub')">
                                            <router-link :to="{ name: 'hoscommentlist' }"><i class="fa fa-list"></i>  口コミ一覧</router-link>
                                        </li>
                                    </ul>
                                </transition>
                            </li>
                            <li v-if="$auth.check(2)">
                                <span @click="subMenu(4)" :class="{ active : isActive == 4 }"><i class="fas fa-users"></i>  求人 <i class="fas fa-angle-right" :class="{ down : isRotate == 4 }"></i></span>
                                <transition name="slideup">
                                    <ul class="sub_menu" v-show="isSubmenu[4].show">
                                        <li @click="toggle('sub')">
                                            <router-link :to="{ name: 'occupationlist' }"><i class="fa fa-suitcase"></i>  求人職種設定</router-link>
                                        </li>
                                        <li @click="toggle('sub')">
                                            <router-link :to="{ name: 'jobofferlist' }"><i class="fa fa-tasks"></i>  求人編集</router-link>
                                        </li>
                                        <li @click="toggle('sub')">
                                            <router-link :to="{ name: 'jobapplicantlist' }"><i class="fa fa-tasks"></i>  求人応募者一覧</router-link>
                                        </li>
                                    </ul>
                                </transition>
                            </li>
                            <li>
                               <a href="/"><i class="fa fa-eye" aria-hidden="true"></i> サイトを表示</a>
                            </li>
                            <li>
                                <a href="#" @click.prevent="logout()"><i class="fa fa-lock"></i> ログアウト</a>
                            </li>
                        </ul>
                        <ul class="sidebar_brand" v-if="visit == 'true'">
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
                            <li  v-if="visit == 'true'">
                                <a  @click="gotoDash()"><i class="fas fa-tachometer-alt"></i> 管理画面へ</a>
                            </li>
                            <li>
                                <a href="#" @click.prevent="logout()"><i class="fa fa-lock"></i> ログアウト</a>
                            </li>
                            <li v-if="!$auth.check()">
                                <router-link :to="{name: 'login'}" class="nav-link pad-free"><i class="fa fa-sign-in-alt"></i> 事業者 ログイン</router-link>
                            </li>
                            <li v-if="!$auth.check()" class="bd-bottom">
                                <router-link :to="{name: 'register'}" class="nav-link pad-free"><i class="fa fa-user-plus"></i> 事業者 登録</router-link>
                            </li>
                            <li>
                            <ul class="contact_list"  v-if="visit == 'true'">
                                <li><a href="mailto:info@t-i-s.jp"><i class="fas fa-envelope"></i>info@t-i-s.jp</a></li>
                            </ul>
                            </li>
                        </ul>
                    </div>
                </transition>
            </div>
            <div id="sp_headerbar" class="login_nav" v-if="visit == 'true'">   
                 <span @click="$router.go(-1);" class="wt-admin">
                    <span>
                        <i class="fas fa-arrow-left"></i> 
                    </span>
                    <span class="span-color">戻る</span> 
                </span>         
                <ul class="menu" @click='isNav = !isNav'>
                    <li class="first-submenu">
                        <span>メニュー</span>&nbsp;<i :class="!isNav ? open : close" class="menu-width"></i>
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
                            <li  v-if="visit == 'true'">
                                <a  @click="gotoDash()"><i class="fas fa-tachometer-alt"></i> 管理画面へ</a>
                            </li>
                            <li class="menu-list_last">
                                <a href="#" @click.prevent="logout()"><i class="fa fa-lock"></i> ログアウト</a>
                            </li>
                            <li v-if="!$auth.check()">
                                <router-link :to="{name: 'login'}" class="nav-link pad-free"><i class="fa fa-sign-in-alt"></i> 事業者 ログイン</router-link>
                            </li>
                            <li v-if="!$auth.check()" class="bd-bottom">
                                <router-link :to="{name: 'register'}" class="nav-link pad-free"><i class="fa fa-user-plus"></i> 事業者 登録</router-link>
                            </li>
                            <li>
                            <ul class="contact_list"  v-if="visit == 'true'">
                                <li><a href="mailto:info@t-i-s.jp"><i class="fas fa-envelope"></i>info@t-i-s.jp</a></li>
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
    .nav-a-img{
        color:#fff;
        font-size:20px;
        width:230px;
        text-align:center;
        background: rgb(36, 84, 113); 
    }
    .nav-img{
        width:215px;
        height:auto; 
    }
    .nav-img02{
        width:230px;
        height:auto; 
    }
    .name-label{
        color:#2980b9;
        font-weight:bold;
        text-shadow: 2px 2px #dcdcdc;
    }
    .bd-bottom{
        border-bottom:1px solid #8c9090;
    }
    .span-color{
        color:#2980b9;
    }
    .menu-width{
        width:15px;
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
       transition: transform 0.3s ease;
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
      transition: all 0.3s ease-in 0s;
    }
    .slideup-enter-active {
       -moz-transition-duration: 1s;
       -webkit-transition-duration: 1s;
       -o-transition-duration: 1s;
       transition-duration: 1s;
       -moz-transition-timing-function: ease-in;
       -webkit-transition-timing-function: ease-in;
       -o-transition-timing-function: ease-in;
       transition-timing-function: ease-in;
    }

    .slideup-leave-active {
       -moz-transition-duration: 1s;
       -webkit-transition-duration: 1s;
       -o-transition-duration: 1s;
       transition-duration: 1s;
       -moz-transition-timing-function: cubic-bezier(0, 1, 0.5, 1);
       -webkit-transition-timing-function: cubic-bezier(0, 1, 0.5, 1);
       -o-transition-timing-function: cubic-bezier(0, 1, 0.5, 1);
       transition-timing-function: cubic-bezier(0, 1, 0.5, 1);
    }
    .slideup-enter-to, .slideup-leave {
       max-height: 600px;
       overflow: hidden;
    }
    .slideup-enter, .slideup-leave-to {
       overflow: hidden;
       max-height: 0;
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
        main_header : 'main-header',
        admin_header :'admin-header',
        container : 'container',
        isSubmenu : localStorage.getItem("isSubmenu")? JSON.parse(localStorage.getItem("isSubmenu")):[{show:false},{show:false},{show:false},{show:false},{show:false}],
        isActive: localStorage.getItem("isActive")? Number(localStorage.getItem("isActive")):null,
        isRotate : localStorage.getItem("isRotate")? Number(localStorage.getItem("isRotate")):null,
      }
    },
    mounted() {
        if(localStorage.getItem("visit")){
            this.visit = localStorage.getItem("visit");
        }
        else{
            if(this.$auth.check()){
                localStorage.setItem('visit', false);
            }
            else{
                localStorage.setItem('visit', true);
            }
        }
        this.user = this.$auth.watch._data;
    },
    methods: {
        gotoDash() {
            this.visit = 'false';
            localStorage.setItem('visit', this.visit);
            const redirectTo = this.$auth.user().role === 1 ? (this.$auth.user().type_id == 2 ? '/accountlist/hospital/'+ this.$auth.user().customer_id : '/accountlist/nursing/'+ this.$auth.user().customer_id ) : '/news_list'
            this.$router.push({path: redirectTo})
        },
        toggle(para = null) {    
            if(para != 'sub'){
                this.isRotate = null;
                this.isActive = null;
                for(var i = 0; i < 5; i++) { 
                    this.isSubmenu[i].show = false;              
                }
                localStorage.removeItem('isSubmenu');
                localStorage.removeItem('isRotate');
                localStorage.removeItem('isActive');
            }       
            this.isNav = !this.isNav;
        },
        subMenu: function (n) {   
            if(this.isSubmenu[n].show){
                this.isSubmenu[n].show = false;  
                this.isRotate = null;
            }else{
                for(var i = 0; i < 5; i++) { 
                    this.isSubmenu[i].show = false;              
                }
                this.isSubmenu[n].show = true; 
                this.isRotate = n;
            }
            this.isActive = n;
            localStorage.setItem('isSubmenu', JSON.stringify(this.isSubmenu));
            localStorage.setItem('isRotate', this.isRotate);
            localStorage.setItem('isActive', this.isActive);
        },
        logout(){              
            this.loginuser = 'false';
            localStorage.setItem('loginuser', this.loginuser);
            if(this.$auth.check(2)){
                this.$auth.logoutAdmin();
            }
            else{
                this.$auth.logout();
            }
            
        },
    }
}
</script>
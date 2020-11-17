<template>
    <!-- <div>
       <div class="sidebar-menu" @click='isClick = !isClick'>
           click
       </div>
       <transition name="slide">
            <div class="custom-sidebar" id="admin-side-menu" v-if="visit == 'false'" :style="{width: isClick ? '280px' : '60px'}">
                <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                    <div class="admin-logo">
                        <a href="/">LOGO <span v-show="isClick">HERE</span></a>
                    </div>

                    <ul class="adminview-sidebar pc">
                        <li class="admintit-item">
                            <i class="fas fa-tachometer-alt"></i><span class="nav-txt" v-show="isClick">管理画面</span>
                        </li>
                        <li v-if="$auth.check(2)">
                            <a href="#pageSubmenu01" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle collapsed nav-link text-pre"><i class="fa fa-newspaper"></i>&nbsp;&nbsp;<span class="nav-txt" v-show="isClick">ニュース一</span>
                            </a>
                            <ul class="collapse submenu" id="pageSubmenu01">
                                <li><router-link to="/news_list" class="nav-link"><i class="fa fa-list"></i>&nbsp;<span>ニュース一覧</span></router-link></li>
                                <li><router-link to="/categorylist" class="nav-link"><i class="fa fa-list"></i>&nbsp;<span>ニュースカテゴリー設定</span></router-link></li>
                            </ul>
                        </li>
                        <li v-if="$auth.check(2)">
                            <a href="#pageSubmenu02" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle collapsed nav-link text-pre"><i class="fas fa-user-md"></i>&nbsp;&nbsp;<span class="nav-txt" v-show="isClick">介護施設</span>
                            </a>
                            <ul class="collapse submenu" id="pageSubmenu02">
                                <li v-if="$auth.check(2)"><router-link to="/nuscustomerlist" class="nav-link"><i class="fa fa-user"></i>&nbsp;<span>事業者</span></router-link></li>
                                <li v-if="$auth.check(2)"><router-link to="/nusfeaturelist" class="nav-link" ><i class="fa fa-list"></i>&nbsp;&nbsp;<span class="nav-txt">特徴設定</span></router-link></li>
                                <li v-if="$auth.check(2)"><router-link to="/occupationlist" class="nav-link"><i class="fa fa-suitcase"></i>&nbsp;&nbsp;<span class="nav-txt">職種設定</span></router-link></li>
                                <li v-if="$auth.check(2)"><router-link to="/nuscommentlist" class="nav-link"><i class="fa fa-list"></i>&nbsp;<span>口コミ一覧</span></router-link></li>
                            </ul>
                        </li>
                        <li v-if="$auth.check(2)">
                            <a href="#pageSubmenu03" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle collapsed nav-link text-pre"><i class="fas fa-briefcase-medical"></i>&nbsp;&nbsp;<span class="nav-txt" v-show="isClick">病院</span>
                            </a>
                            <ul class="collapse submenu" id="pageSubmenu03">
                                <li v-if="$auth.check(2)"><router-link to="hoscustomerlist" class="nav-link"><i class="fa fa-user"></i>&nbsp;<span>事業者</span></router-link></li>
                                <li v-if="$auth.check(2)"><router-link to="/facilitieslist" class="nav-link" ><i class="fa fa-sun"></i>&nbsp;<span class="nav-txt">院内施設設定</span></router-link></li>
                                <li v-if="$auth.check(2)"><router-link to="/hosfeaturelist" class="nav-link" ><i class="fa fa-list"></i>&nbsp;&nbsp;<span class="nav-txt">特徴設定</span></router-link></li>
                                <li v-if="$auth.check(2)"><router-link to="/subjectlist" class="nav-link"><i class="fa fa-user-md"></i>&nbsp;&nbsp;<span class="nav-txt">診察科目設定</span></router-link></li>
                                <li v-if="$auth.check(2)"><router-link to="/hoscommentlist" class="nav-link"><i class="fa fa-list"></i>&nbsp;<span>口コミ一覧</span></router-link></li>
                            </ul>
                        </li>
                        <li  v-if="$auth.check(2)"><router-link to="/ads" class="nav-link"><i class="fa fa-globe"></i>&nbsp;&nbsp;<span class="nav-txt" v-show="isClick">広告</span></router-link></li>
                        <li v-if="$auth.check(1)"><router-link to="/profiledit" class="nav-link"><i class="fa fa-map" ></i>&nbsp;&nbsp;<span class="nav-txt">プロフィール編集</span></router-link></li>
                        <li v-if="$auth.check(1)"><router-link to="/profile" class="nav-link"><i class="fa fa-map"></i>&nbsp;&nbsp;<span class="nav-txt">マイページ</span></router-link></li>
                        <li v-if="$auth.check(1)"><router-link to="/jobofferlist" class="nav-link"><i class="fa fa-edit" ></i>&nbsp;&nbsp;<span class="nav-txt">仕事一覧</span> </router-link></li>
                        <li v-if="$auth.check()">
                            <a href="#" @click.prevent="$auth.logout()" class="nav-link" id="logoutId" ref="myid"><i class="fa fa-sign-out-alt"></i>&nbsp;&nbsp;<span class="nav-txt" v-show="isClick">ログアウト</span></a>
                        </li>
                    </ul>
                </div>
            </div>
      </transition>
    </div> -->
    <div v-if="$auth.check() && visit == 'false'" id="content-all" class="content-all"  :class="[{'collapsed' : collapsed}]">
        <sidebar-menu :menu="menu"  :collapsed="collapsed" :show-one-child="true" @toggle-collapse="onCollapse"  @item-click="onItemClick"/>
        <transition name="fade">
            <div class="maintab-content" id="v-pills-tabContent">
                <!-- <span @click="menuToggle()">Click</span> -->
                <!--section one-->
                <section>
                    <div class="container-fluid">
                        <!--slider for ads-->
                        <div class="col-md-auto pad-free"></div>
                        <!--end slider for ads-->
                        <div class="row justify-content-md-center">
                            <div class="col-12 p0-480">
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
        </transition>
    </div>
</template>
<style  scoped>
.v-sidebar-menu {
    top: 60px;
    bottom: 0;
    height: auto !important;
    background-color: #222d32;
}
.v-sidebar-menu.vsm_expanded{
    max-width: 230px !important;
}
.v-sidebar-menu .vsm--link_level-1.vsm--link_exact-active, .v-sidebar-menu .vsm--link_level-1.vsm--link_active {
    -webkit-box-shadow: 0px 0px 0px 0px red inset;
    box-shadow: 0px 0px 0px 0px red inset;
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
</style>
<script>
import 'vue-sidebar-menu/dist/vue-sidebar-menu.css'
export default {
data() {
    return {
        status:false,
        isClick: true,
        collapsed: false,
        url_name: null,
        menu: [
            {
                header: true,
                title: '管理者画面',
                hidden: this.$auth.check(1),
                hiddenOnCollapse: true
            },
            {
                title: 'ニュース',
                icon: 'fa fa-newspaper',
                hidden: this.$auth.check(1),
                child: [
                    {
                        href: '/news_list',
                        title: 'ニュース一覧',
                        icon: 'fa fa-file-alt'
                    },
                    {
                        href: '/categorylist',
                        title: 'カテゴリー設定',
                        icon: 'fa fa-file-alt'
                    },
                    {
                        href: '/ads',
                        title: '広告',
                        icon: 'fa fa-globe',
                    },
                    {
                        href: '/linkednews',
                        title: 'お知らせ・ニュース',
                        icon: 'fa fa-file-alt',
                    },
                ]
            },
            {
                title: '介護施設',
                icon: 'fa fa-user-md',
                hidden: this.$auth.check(1),
                child: [
                    {
                    href: '/nuscustomerlist',
                    title: '事業者一覧',
                    icon: 'fa fa-user'
                    },
                    {
                    href: '/nusfeaturelist',
                    title: '特長設定',
                    icon: 'fa fa-list'
                    },
                    {
                    href: '/nuscommentlist',
                    title: '口コミ一覧',
                    icon: 'fa fa-list'
                    }
                ]
            },
            {
                title: '病院',
                icon: 'fas fa-briefcase-medical',
                hidden: this.$auth.check(1),
                child: [
                    {
                    href: '/hoscustomerlist',
                    title: '事業者一覧',
                    icon: 'fa fa-user'
                    },
                    {
                    href: '/facilitieslist',
                    title: '院内施設設定',
                    icon: 'fa fa-list'
                    },
                    {
                    href: '/hosfeaturelist',
                    title: '特長設定',
                    icon: 'fa fa-list'
                    },
                    {
                    href: '/subjectlist',
                    title: '診療科目設定',
                    icon: 'fa fa-list'
                    },
                    {
                    href: '/hoscommentlist',
                    title: '口コミ一覧',
                    icon: 'fa fa-list'
                    }
                ]
            },
            {
                header: true,
                title: `事業者管理画面${this.$auth.user().type_id == 2 ? ' (病院)': ' (介護施設)'}`,
                hidden: this.$auth.check(2),
                hiddenOnCollapse: true
            },                
            {
                href: `/profiledit/${this.$auth.user().type_id == 2 ? 'hospital/': 'nursing/'}${this.$auth.user().customer_id}`,
                title: 'プロフィール設定',
                icon: 'fa fa-cog',
                hidden: this.$auth.check(2)
            },
            {
                href: `/accountlist/${this.$auth.user().type_id == 2 ? 'hospital/': 'nursing/'}${this.$auth.user().customer_id}`,
                title: this.$auth.user().type_id == 2 ? '病院一覧': '施設一覧' ,
                icon: 'fa fa-user',
                disabled:this.$auth.user().recordstatus==1?false:true,
                hidden: this.$auth.check(2),
            },
            // {
            //     href: '/profile',
            //     title: 'マイページ編集',
            //     icon: 'fa fa-map',
            //     hidden: this.$auth.check(2)
            // },
            {
                title: '求人',
                icon: 'fas fa-users',  
                hidden: this.$auth.check(1),                  
                child: [
                    {
                        href: '/occupationlist',
                        title: '求人職種設定',
                        icon: 'fa fa-suitcase',
                    },
                    {
                        href: '/jobofferlist',
                        title: '求人編集',
                        icon: 'fa fa-tasks',
                    },
                    {
                        href: '/jobapplicantlist',
                        title: '求人応募者一覧',
                        icon: 'fa fa-tasks',
                    },
                ]
            },
            {
                title: 'ログアウト',
                icon: 'fa fa-lock',
                // click: this.$auth.logout(),
            },
        ]
    }
},
created() {
    this.url_name = this.$auth.user().type_id == 2 ? 'hospital/': 'nursing/' + this.$auth.user().customer_id;
    axios.interceptors.response.use((response) => {
        // console.log(response.data)
        if((response.data.status == "Token is Expired" || response.data.status == "Token is Invalid") && this.status == false ){
            this.status = true
        // Swal.fire({
        //     title: 'セッションの有効期限が切れています。！',
            // text: "お手数ですがログイン画面より再度ログインしてください。",
        //     icon: 'warning',
        //     showCancelButton: false,
        //     confirmButtonColor: '#3085d6',
        //     cancelButtonColor: '#d33',
        //     confirmButtonText: 'OK'
        // }).then((result) => {
        //     // console.log()

        //     if (result.value) {
        //         this.$refs.myid.click();
        //         response.data.status = "logout success"

        //     }
        // })
        this.visit = 'true';
        this.loginuser = 'false';
        localStorage.setItem('visit',this.visit);
        localStorage.setItem('loginuser',this.loginuser);
        this.$router.push({name: 'Unauthorized',params: {reload:"reload"}});
        }
        return response
        })
    },
    methods: {
        menuToggle(){
            $("#admin-side-menu").toggle('medium');
            $("#menu-overlay").toggle('medium');
        },
        onItemClick(event, item){
            if(item.title == 'ログアウト'){
                this.loginuser = 'false';
                localStorage.setItem('loginuser', this.loginuser);
                localStorage.setItem('logintoken', '');
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
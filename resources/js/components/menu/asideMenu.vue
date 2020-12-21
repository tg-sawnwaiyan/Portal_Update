<template>
     <div v-if="$auth.check() && visit == 'false'" id="content-all" class="content-all"  :class="[{'collapsed' : collapsed}]">
        <sidebar-menu :menu="menu"  :collapsed="collapsed" :show-one-child="true" @toggle-collapse="onCollapse"  @item-click="onItemClick"/>
        <transition name="fade">
            <div class="maintab-content" id="v-pills-tabContent">
                <!-- <span @click="menuToggle()">Click</span> -->
                <!--section one-->
                <section>
                    <div class="container-fluid">
                        <!--slider for ads-->
                        <div class="col-md-auto pad-free">

                        </div>
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
    .v-sidebar-menu .vsm--link_level-1.vsm--link_exact-active, 
    .v-sidebar-menu .vsm--link_level-1.vsm--link_active{
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
                },
            ]
      }
    },
created() {
    this.url_name = this.$auth.user().type_id == 2 ? 'hospital/': 'nursing/' + this.$auth.user().customer_id;
    axios.interceptors.response.use((response) => {
        if((response.data.status == "Token is Expired" || response.data.status == "Token is Invalid") && this.status == false ){
            this.status = true
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



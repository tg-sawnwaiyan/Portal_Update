<template>
    <div class="col-12 scrolldiv2 pb-3 tab-content margin-none" id="hospital">
        <div class="col-12 pad-free pad-free-75">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb" style="padding-left:0px !important;padding-right:0px !important;">
                    <li class="breadcrumb-item">
                        <router-link to="/">ホーム</router-link>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">病院のお気に入り</li>
                </ol>
            </nav>
        </div>
        <div class="col-12 pad-free">
            <div class="col-md-12 fav-his-header pad-free">
                <svg x="0px" y="0px" width="24" height="24" viewBox="0 0 172 172" style=" fill:#000000;">
                    <g fill="none" fill-rule="nonzero" stroke="none" stroke-width="1" stroke-linecap="butt" stroke-linejoin="miter" stroke-miterlimit="10" stroke-dasharray="" stroke-dashoffset="0" font-family="none" font-weight="none" font-size="none" text-anchor="none" style="mix-blend-mode: normal">
                        <path d="M0,172v-172h172v172z" fill="none"></path>
                        <g id="original-icon" fill="#c40000" opacity="0" visibility="hidden">
                            <path d="M50.16667,78.83333h107.5v14.33333h-107.5zM50.16667,35.83333h107.5v14.33333h-107.5zM50.16667,121.83333h107.5v14.33333h-107.5zM21.5,75.25c-5.93706,0 -10.75,4.81294 -10.75,10.75c0,5.93706 4.81294,10.75 10.75,10.75c5.93706,0 10.75,-4.81294 10.75,-10.75c0,-5.93706 -4.81294,-10.75 -10.75,-10.75zM21.5,118.25c-5.93706,0 -10.75,4.81294 -10.75,10.75c0,5.93706 4.81294,10.75 10.75,10.75c5.93706,0 10.75,-4.81294 10.75,-10.75c0,-5.93706 -4.81294,-10.75 -10.75,-10.75zM21.5,32.25c-5.93706,0 -10.75,4.81294 -10.75,10.75c0,5.93706 4.81294,10.75 10.75,10.75c5.93706,0 10.75,-4.81294 10.75,-10.75c0,-5.93706 -4.81294,-10.75 -10.75,-10.75z"></path>
                        </g>
                        <g id="subtracted-icon" fill="#c40000">
                            <path d="M50.16667,78.83333h107.5l0,10.81336c-1.5126,0.69131 -2.92913,1.65951 -4.17264,2.90462l-0.6155,0.61535h-102.71186zM50.16667,35.83333h107.5v14.33333h-107.5zM50.16667,121.83333h24.29256c-1.88479,4.7147 -1.16582,10.22759 2.1569,14.33333h-26.44946zM32.25,86c0,5.93706 -4.81294,10.75 -10.75,10.75c-5.93706,0 -10.75,-4.81294 -10.75,-10.75c0,-5.93706 4.81294,-10.75 10.75,-10.75c5.93706,0 10.75,4.81294 10.75,10.75zM32.25,129c0,5.93706 -4.81294,10.75 -10.75,10.75c-5.93706,0 -10.75,-4.81294 -10.75,-10.75c0,-5.93706 4.81294,-10.75 10.75,-10.75c5.93706,0 10.75,4.81294 10.75,10.75zM32.25,43c0,5.93706 -4.81294,10.75 -10.75,10.75c-5.93706,0 -10.75,-4.81294 -10.75,-10.75c0,-5.93706 4.81294,-10.75 10.75,-10.75c5.93706,0 10.75,4.81294 10.75,10.75zM123.60062,122.43755l-0.6045,-0.60422l1.20887,0z"></path>
                        </g>
                        <g>
                            <g id="Filled_3_" fill="#c40000">
                                <path d="M123.60062,162.99169l-35.82908,-35.82908l10.13652,-10.13652l25.69256,25.69256l40.02993,-40.02993l10.13652,10.13652z"></path>
                            </g>
                            <g id="Filled_3_" fill="#000000" opacity="0">
                                <path d="M183.90358,122.96087l-50.16644,50.16644c-2.79579,2.80295 -6.46615,4.20085 -10.13652,4.20085c-3.67037,0 -7.34073,-1.39789 -10.13652,-4.20085l-35.82908,-35.82908c-5.59874,-5.59874 -5.59874,-14.67429 0,-20.27304l10.13652,-10.13652c5.59157,-5.59874 14.68146,-5.59874 20.27304,0l15.55604,15.54887l29.89341,-29.88624c5.59157,-5.59874 14.68146,-5.59874 20.27304,0l10.13652,10.13652c5.59874,5.59874 5.59874,14.67429 0,20.27304z"></path>
                            </g>
                        </g>
                    </g>
                </svg>
                &nbsp; <span class="font-weight-bold">お気に入りリスト</span>
                &nbsp; <span class="job_count">{{fav_hos}}件</span>
                <!-- &nbsp;<span style="color:#000;">件</span> -->

            </div>
        </div>
        <div class="row m-0">

            <form class="col-md-12 pad-free" id="fav-hospital-page" autocomplete="off">
                <div class="col-12"  id="fav-history-page">
                    <div class="justify-content-lg-center">
                        <div>
                            <label> {{message}} </label>
                        </div>
                        <div class="card-carousel-wrapper">

                            <div class="nav-box"  @click="moveCarousel(-1)" :disabled="atHeadOfList">
                                <div class="nav-content mr-2">
                                    <div class="card-carousel--nav__left"></div>
                                </div>
                            </div>
                            <div class="card-carousel">
                                <div class="card-carousel--overflow-container">
                                    <div class="card-carousel-cards col-3 pad-free" :style="{ transform: 'translateX' + '(' + currentOffset + 'px' + ')'}">
                                        <div class="card-carousel--card">
                                            <div class="card-carousel--card--footer">

                                                <table class="table table-bordered">
                                                    <tr>
                                                        <td v-for="hos_profile in fav_hospital" :key="hos_profile.id">
                                                            <div class="profile_img_wrap">
                                                                <img class="profile_img" v-bind:src="'/upload/hospital_profile/' + hos_profile.logo" alt  @error="imgUrlAlt"/>
                                                            </div> 
                                                            <router-link :to="{ path:'/profile/hospital/'+ hos_profile.id}" class="pseudolink">{{hos_profile.name}}</router-link>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td v-for="hos_profile in fav_hospital" :key="hos_profile.id">
                                                            <p class="profile_wd">
                                                                <span class="btn btn-danger all-btn hos-btn m-t-8 m-b-3" @click="deleteLocalSto(hos_profile.id)">お気に入りリストから削除</span>
                                                            </p>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td v-for="hos_profile in fav_hospital" :key="hos_profile.id" style="word-wrap: break-word;">
                                                            <div class="profile_wd"> <a :href="hos_profile.website" target="_blank" class="profile_wd pseudolink">{{hos_profile.website}}</a></div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td v-for="hos_profile in fav_hospital" :key="hos_profile.id">
                                                            <dl>
                                                                <dt class="text-left">診療時間</dt>
                                                            </dl>
                                                            <table class="table table-bordered">
                                                                <thead>
                                                                    <tr class="first-row">
                                                                        <th>日付</th>
                                                                        <th>午前</th>
                                                                        <th>午後</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <tr>
                                                                        <th class="second-row text-center">月</th>
                                                                        <td v-for="am in hos_profile.schedule_am" :key="am.id">{{am.mon}}</td>
                                                                        <td v-for="pm in hos_profile.schedule_pm" :key="pm.id">{{pm.mon}}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th class="second-row text-center">火</th>
                                                                        <td v-for="am in hos_profile.schedule_am" :key="am.id">{{am.tue}}</td>
                                                                        <td v-for="pm in hos_profile.schedule_pm" :key="pm.id">{{pm.tue}}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th class="second-row text-center">水</th>
                                                                        <td v-for="am in hos_profile.schedule_am" :key="am.id">{{am.wed}}</td>
                                                                        <td v-for="pm in hos_profile.schedule_pm" :key="pm.id">{{pm.wed}}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th class="second-row text-center">木</th>
                                                                        <td v-for="am in hos_profile.schedule_am" :key="am.id">{{am.thu}}</td>
                                                                        <td v-for="pm in hos_profile.schedule_pm" :key="pm.id">{{pm.thu}}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th class="second-row text-center">金</th>
                                                                        <td v-for="am in hos_profile.schedule_am" :key="am.id">{{am.fri}}</td>
                                                                        <td v-for="pm in hos_profile.schedule_pm" :key="pm.id">{{pm.fri}}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th class="second-row text-center">土</th>
                                                                        <td v-for="am in hos_profile.schedule_am" :key="am.id">{{am.sat}}</td>
                                                                        <td v-for="pm in hos_profile.schedule_pm" :key="pm.id">{{pm.sat}}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th class="second-row text-center">日</th>
                                                                        <td v-for="am in hos_profile.schedule_am" :key="am.id">{{am.sun}}</td>
                                                                        <td v-for="pm in hos_profile.schedule_pm" :key="pm.id">{{pm.sun}}</td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td v-for="hos_profile in fav_hospital" :key="hos_profile.id">
                                                            <dl>
                                                                <dt class="text-left">住所</dt>
                                                                <dd  class="profile_wd text-left m-l-10" >{{hos_profile.township_name}} {{hos_profile.city_name}}</dd>
                                                            </dl>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td v-for="hos_profile in fav_hospital" :key="hos_profile.id">
                                                            <dl>
                                                                <dt class="text-left">交通アクセス</dt>
                                                                <dd class="profile_wd text-left m-l-10" v-html="hos_profile.access"></dd>
                                                            </dl>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td v-for="hos_profile in fav_hospital" :key="hos_profile.id">
                                                            <dl>
                                                                <dt class="text-left">電話番号</dt>
                                                                <dd class="profile_wd text-left m-l-10">{{hos_profile.phone}}</dd>
                                                            </dl>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td v-for="hos_profile in fav_hospital" :key="hos_profile.id">
                                                            <div class="profile_wd">
                                                                <ul class="fac_container text-left">
                                                                    <h6 class="font-weight-bold">特長</h6>
                                                                    <li v-for="feature in hos_profile.special" :key="feature.id">{{ feature.short_name }}</li>
                                                                </ul>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td v-for="hos_profile in fav_hospital" :key="hos_profile.id">
                                                            <dl>
                                                                <dt class="text-left">診療科目</dt>
                                                                <dd class="profile_wd text-left m-l-10" v-for="subject in hos_profile.sub" :key="subject.id">{{ subject.name }}</dd>
                                                            </dl>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td v-for="hos_profile in fav_hospital" :key="hos_profile.id">
                                                            <dl>
                                                                <dt class="text-left">専門医</dt>
                                                                <dd  class="profile_wd text-left m-l-10" v-if="hos_profile.specialist != null">{{hos_profile.specialist}}</dd>
                                                                <dd v-else>-</dd>
                                                            </dl>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td v-for="hos_profile in fav_hospital" :key="hos_profile.id">
                                                            <dl>
                                                                <dt class="text-left">医療部</dt>
                                                                <dd class="profile_wd text-left m-l-10">{{hos_profile.medical_department}}</dd>
                                                            </dl>
                                                        </td>
                                                    </tr>

                                                </table>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="nav-box" @click="moveCarousel(1)" :disabled="atEndOfList">
                                <div class="nav-content ml-2">
                                <div class="card-carousel--nav__right"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

</template>

<script>
    export default {

        data() {
                return {
                    errors: [],
                    fav_hospital: [],
                    fav_hos:'',
                    local_sto: "",
                    post_list: [],
                    city_list: [],
                    post: "",
                    selectedCity: "",
                    zipStreet: "",
                    zipPref: "",
                    selectedValue: 0,
                    fav_email: [],
                    arr_email: [],
                    type: 'nursing',
                    specialfeature: [],
                    currentOffset: 0,
                    windowSize: 5,
                    paginationFactor: 272,
                    window:{
                        width:0,
                        height:0
                    },
                    message:''
                };
            },
            computed: {
                atEndOfList() {
                        return this.currentOffset <= (this.paginationFactor * -1) * (this.fav_hospital.length - this.windowSize);
                    },
                    atHeadOfList() {
                        return this.currentOffset === 0;
                    },
            },
            created() {
                this.$loading(true);  
               //for cardcarousel responsive
                window.addEventListener('resize', this.handleResize)
                this.handleResize(); 
                if(this.window.width >=320 && this.window.width < 360) {
                    this.windowSize = 1;  
                  this.paginationFactor = 268;    
                } 
                else if(this.window.width >=360 && this.window.width < 375) {
                    this.windowSize = 1;
                     this.paginationFactor = 270;    
                } 
                 else if(this.window.width >=375 && this.window.width < 450) {
                    this.windowSize = 1;
                     this.paginationFactor = 270;    
                }
                
                else if(this.window.width >= 414 && this.window.width < 768) {
                    this.windowSize = 1;
                     this.paginationFactor = 270; 
                } 
                else if(this.window.width >= 768 && this.window.width < 992) {
                    this.windowSize = 2;
                    this.paginationFactor = 269;  
                }
                else if(this.window.width >= 992 && this.window.width < 1024) {
                    this.windowSize = 3; 
                    this.paginationFactor = 266;                                 
                }
                else if(this.window.width >= 1024 && this.window.width < 1200) {
                    this.windowSize = 3; 
                      this.paginationFactor = 265;                                
                }
                else if (this.window.width >= 1200 && this.window.width < 1280) {
                    this.windowSize = 3;
                    this.paginationFactor = 270;                    
                }
                else if (this.window.width >= 1280 && this.window.width < 1440) {
                    this.windowSize = 4;
                    this.paginationFactor = 271;
                    
                }
                else if (this.window.width >= 1440 && this.window.width < 1880) {
                    this.windowSize = 4;
                     this.paginationFactor = 271;            
                }


                this.local_sto = localStorage.getItem("hospital_fav");
                this.getAllFavourite(this.local_sto);
                if(this.local_sto){
                    this.fav_hos =this.local_sto.split(",").length;
                }
            },
            mounted() {
                $('#navtab').removeClass('news-tabColor hospital-tabColor nursing-tabColor job-tabColor');
                $('#navtab').addClass('hospital-tabColor');
                $('.tab-content').removeClass('news-borderColor job-borderColor nursing-borderColor hospital-borderColor');
                $('#upper-tab').addClass('hospital-borderColor margin-none');
                $('.google_search_div').addClass('google_search_all');
                $('#headerbar').addClass('headerbarblock');
            },
            methods: {
                handleResize() {
                    this.window.width = window.innerWidth;
                    this.window.height = window.innerHeight;
                },

                moveCarousel(direction) {
                        // Find a more elegant way to express the :style. consider using props to make it truly generic
                        if (direction === 1 && !this.atEndOfList) {
                            this.currentOffset -= this.paginationFactor;
                        } else if (direction === -1 && !this.atHeadOfList) {
                            this.currentOffset += this.paginationFactor;
                        }
                    },

                    deleteLocalSto: function(id) {

                            this.$swal({
                            text: "お気に入りから削除してよろしいでしょうか 。",
                            type: "warning",
                            width: 400,
                            height: 200,
                            showCancelButton: true,
                            confirmButtonColor: "#EEA025",
                            cancelButtonColor: "#b1abab",
                            cancelButtonTextColor: "#000",
                            confirmButtonText: "はい",
                            cancelButtonText: "キャンセル",
                            confirmButtonClass: "all-btn",
                            cancelButtonClass: "all-btn",
                            allowOutsideClick: false,
                            
                        }).then(response => { 
                            var l_sto = this.local_sto;
                            var l_sto_arr = l_sto.split(",");
                            var rm_id = id.toString();
                            var index = l_sto_arr.indexOf(rm_id);
                            if (index > -1) {
                                l_sto_arr.splice(index, 1);
                                // $("#hos-fav-local").html(l_sto_arr.length);
                                this.hosFav = l_sto_arr.length;
                                if(l_sto_arr.length == 0){ 
                                    $('.fav-hospital-link-box>a').css({'cursor':'not-allowed','pointer-events':'none'})
                                }
                                else{
                                    $('.fav-hospital-link-box>a').css({'cursor':'pointer','pointer-events':'auto'})
                                }
                                var new_local = l_sto_arr.toString();
                                localStorage.setItem('hospital_fav', new_local);
                                this.local_sto = localStorage.getItem("hospital_fav");
                                
                                if (this.local_sto) {
                                    this.fav_hos =this.local_sto.split(",").length;
                                    this.getAllFavourite(this.local_sto);
                                } else {
                                    // window.location.reload();
                                    this.$router.push({
                                        name: 'hospital_search',                                        
                                    });
                                }
                            }
                         });
                            
                            
                            if(this.local_sto){
                                this.fav_hos =this.local_sto.split(",").length;
                            }
                      
                    },
                    getAllFavourite: function(local_storage) {
                       
                        this.axios
                            .post('/api/favHospital/' + local_storage)
                            .then(response => {
                               this.$loading(false);  
                                this.fav_hospital = response.data;                             
                            
                                if(this.fav_hospital.length < this.fav_hos && this.fav_hospital.length > 0)
                                {
                                    this.$swal({
                                    position: 'top-end',
                                    type: 'info',
                                    text: 'すでに掲載されていない施設をリストから削除しました。',
                                    showConfirmButton: true,
                                    confirmButtonText: "閉じる",
                                    width: 400,
                                    height: 200,
                                    allowOutsideClick: false,
                                    });
                                    var hos_id = '';
                                //   this.message = "現在本サイトに掲載されていない病院についてはお気に入りリストから削除しました。"
                                    for(var i= 0;i<this.fav_hospital.length;i++)
                                     {
                                         if(i== this.fav_hospital.length-1)
                                         {
                                            hos_id += this.fav_hospital[i]['id'];
                                         }
                                         else{
                                            hos_id += this.fav_hospital[i]['id'] + ",";
                                         }
                                       
                                     }
                                    localStorage.setItem('hospital_fav',hos_id);
                                    this.local_sto = localStorage.getItem("hospital_fav");
                                    this.hosFav = this.fav_hospital.length;
                                }
                                if(this.fav_hospital.length == 0)
                                {
                                    this.$swal({
                                    position: 'top-end',
                                    type: 'info',
                                    text: 'すでに掲載されていない施設をリストから削除しました。',
                                    showConfirmButton: true,
                                    confirmButtonText: "閉じる",
                                    width: 400,
                                    height: 200,
                                    allowOutsideClick: false,
                                    }).then(response => {
                                        localStorage.setItem('hospital_fav','');
                                        this.local_sto = localStorage.getItem("hospital_fav");
                                        this.hosFav = 0;
                                        $('.fav-hospital-link-box>a').css({'cursor':'not-allowed','pointer-events':'none'});
                                        $( '.fav-hospital-link-box>a').parent('div').css({'cursor':'not-allowed'});
                                        this.$router.push({name: 'hospital_search'});   

                                    });
                                }
                               
                            });
                           
                            
                    },
                     imgUrlAlt(event) {
                event.target.src = "/images/noimage.jpg"
            }
            }
    };
</script>
<style>
   
</style>

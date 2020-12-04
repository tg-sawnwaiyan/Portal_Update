<template>
    <div>
        <div class="col-12 scrolldiv2 pb-3 tab-content" id="hospital">
            <div class="col-12 pad-free pad-free-75">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-style">
                    <li class="breadcrumb-item">
                        <router-link to="/">ホーム</router-link>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">最近見た病院リスト</li>
                    </ol>
                </nav>
            </div>
            <div class="col-12 pad-free">
                <div class="col-md-12 fav-his-header pad-free">
                    <svg x="0px" y="0px" width="24" height="24" viewBox="0 0 172 172" class="svg-style">
                        <g fill="none" fill-rule="nonzero" stroke="none" stroke-width="1" stroke-linecap="butt" stroke-linejoin="miter" stroke-miterlimit="10" stroke-dasharray="" stroke-dashoffset="0" font-family="none" font-weight="none" font-size="none" text-anchor="none" class="g-style">
                            <path d="M0,172v-172h172v172z" fill="none"></path>
                            <g fill="#c40000">
                                <path d="M86,15.0472l-78.83333,70.9528h21.5v64.5h59.44694c-1.3545,-4.54367 -2.11361,-9.3525 -2.11361,-14.33333h-43v-63.14225l43,-38.6888l57.61328,51.66439h21.22006zM136.19466,100.24935c-19.78717,0 -35.83333,16.04617 -35.83333,35.83333c0,19.78717 16.04617,35.83333 35.83333,35.83333c19.78717,0 35.83333,-16.04617 35.83333,-35.83333c0,-19.78717 -16.04617,-35.83333 -35.83333,-35.83333zM150.89193,119.24382l10.02213,10.03613l-28.30274,28.30274l-21.13606,-21.13607l10.02213,-10.03613l11.11393,11.11393z"></path>
                            </g>
                        </g>
                    </svg>
                    &nbsp;<span class="font-weight-bold"> 最近見た病院リスト</span>
                    &nbsp; <span class="job_count">{{his_hos}} 件</span>
                </div>
            </div>
            <div id="fav-hospital-page">
                <div class="col-12" id="fav-history-page">
                    <div class="row justify-content-lg-center">
                        <div class="card-carousel-wrapper m-l-4">
                            <div class="nav-box" @click="moveCarousel(-1)" :disabled="atHeadOfList">
                                <div class="nav-content mr-2">
                                    <div class="card-carousel--nav__left"></div>
                                </div>
                            </div>
                            <div class="card-carousel">
                                <div class="card-carousel--overflow-container">
                                    <div class="card-carousel-cards col-3 pad-free" :style="{ transform: 'translateX' + '(' + currentOffset + 'px' + ')'}">
                                        <div class="card-carousel--card">
                                            <div class="card-carousel--card--footer">
                                                <div class="msg"> 
                                                    <label><strong> {{message}} </strong></label>
                                                </div>
                                                <table class="table table-bordered">
                                                    <tr>
                                                        <td v-for="hos_profile in hos_profiles" :key="hos_profile.id">
                                                            <div class="profile_img_wrap">
                                                                <img class="profile_img" v-bind:src="'/upload/hospital_profile/' + hos_profile.logo" alt @error="imgUrlAlt"/>
                                                            </div>
                                                            <router-link :to="{ path:'/profile/hospital/'+ hos_profile.id}" class="pseudolink">{{hos_profile.name}}</router-link>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td v-for="hos_profile in hos_profiles" :key="hos_profile.id">
                                                            <div class="profile_wd">
                                                                <span class="btn btn-danger all-btn hos-btn m-t-8 m-b-3" @click="deleteLocalSto(hos_profile.id)">最近見た病院リストから削除</span>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td v-for="hos_profile in hos_profiles" :key="hos_profile.id" class="hos_profile-style">
                                                            <div class="profile_wd"> <a :href="hos_profile.website" target="_blank" class="pseudolink">{{hos_profile.website}}</a></div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td v-for="hos_profile in hos_profiles" :key="hos_profile.id">
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
                                                        <td v-for="hos_profile in hos_profiles" :key="hos_profile.id">
                                                            <dl>
                                                                <dt class="text-left">住所</dt>
                                                                <dd class="profile_wd text-left m-l-10">{{hos_profile.township_name}} {{hos_profile.city_name}}</dd>
                                                            </dl>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td v-for="hos_profile in hos_profiles" :key="hos_profile.id">
                                                            <dl>
                                                                <dt class="text-left">交通アクセス</dt>
                                                                <dd class="profile_wd text-left m-l-10" v-html="hos_profile.access"></dd>
                                                            </dl>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td v-for="hos_profile in hos_profiles" :key="hos_profile.id">
                                                            <dl>
                                                                <dt class="text-left">電話番号</dt>
                                                                <dd class="profile_wd text-left m-l-10">{{hos_profile.phone}}</dd>
                                                            </dl>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td v-for="hos_profile in hos_profiles" :key="hos_profile.id">
                                                            <div class="profile_wd text-left">
                                                                <ul class="fac_container">
                                                                    <h6 class="h6-style">特長</h6>
                                                                    <li v-for="feature in hos_profile.special" :key="feature.id">{{ feature.short_name }}</li>
                                                                </ul>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td v-for="hos_profile in hos_profiles" :key="hos_profile.id">
                                                            <dl>
                                                                <dt class="text-left">診療科目</dt>
                                                                <dd v-for="sub in hos_profile.sub" :key="sub.id" class="profile_wd text-left m-l-10">{{sub.name}}</dd>
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
            </div>
        </div>
    </div>
</template>
<script>
export default {
    data() {
        return {
            his_hos:'',
            message:'',
            hos_profiles: [],
            specialfeature: [],
            local_sto: "",
            type: 'nursing',
            specialfeature: [],
            currentOffset: 0,
            windowSize: 5,
            paginationFactor: 272,
            window:{
                width:0,
                height:0
            }
        };
    },
    computed: {
        atEndOfList() {
            return this.currentOffset <= (this.paginationFactor * -1) * (this.hos_profiles.length - this.windowSize);
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
            // console.log(this.window.width);
        }
        this.local_sto = localStorage.getItem("hospital_history");
        this.getAllCustomer(this.local_sto);
        if(this.local_sto){
            this.his_hos = this.local_sto.split(",").length;
        }
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
        getAllCustomer: function(local_storage) {
            this.axios
            .post("/api/hospital_history/" + local_storage)
            .then(response => {
                this.$loading(false);  
                this.hos_profiles = response.data;
                if(response.data.length<this.his_hos && response.data.length > 0) { 
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
                    // this.message = "現在本サイトに掲載されていない病院については最近見た施設リストから削除しました。";
                    for(var i= 0;i<this.hos_profiles.length;i++) {
                        if(i== this.hos_profiles.length-1) {
                            hos_id += this.hos_profiles[i]['id'];
                        }
                        else {
                            hos_id += this.hos_profiles[i]['id'] + ",";
                        }
                    }
                    localStorage.setItem('hospital_history',hos_id);
                    this.local_sto = localStorage.getItem("hospital_history");
                    this.hosHis = this.hos_profiles.length;
                } else if(response.data.length == 0){
                    this.his_hos = 0;
                    this.$swal({
                        text: "すでに掲載されていない施設をリストから削除しました。",
                        type: 'info',
                        width: 400,
                        height: 200,
                        showConfirmButton: true,
                        confirmButtonText: "閉じる",
                        confirmButtonClass: "all-btn",
                        allowOutsideClick: false,
                    }).then(response => {
                        localStorage.setItem('hospital_history','');
                        this.local_sto = localStorage.getItem("hospital_history");
                        this.hosHis = 0;
                        this.$router.push({
                            name: 'hospital_search',
                        });
                    });
                }
            });
        },
        deleteLocalSto: function(id) {
            this.$swal({
                text: "最近見た施設から削除してよろしいでしょうか 。",
                type: "warning",
                width: 350,
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
                    // $("#hos-his-local").html(l_sto_arr.length);
                    this.hosHis = l_sto_arr.length;
                    if(l_sto_arr.length == 0){
                        $('.his-hospital-link-box>a').css({'cursor':'not-allowed','pointer-events':'none'})
                    }
                    else{
                        $('.his-hospital-link-box>a').css({'cursor':'pointer','pointer-events':'auto'})
                    }
                    var new_local = l_sto_arr.toString();
                    localStorage.setItem('hospital_history', new_local);
                    this.local_sto = localStorage.getItem("hospital_history");
                    if (this.local_sto) {
                        this.his_hos = this.local_sto.split(",").length;
                        this.getAllCustomer(this.local_sto);
                    } else {
                        // window.location.reload();
                        this.$router.push({
                            name: 'hospital_search',
                            // params: {
                            //     page: 'subtab3'
                            // }
                        });
                    }
                }
            });
            if(this.local_sto){
                this.his_hos = this.local_sto.split(",").length;
            }
        },
        imgUrlAlt(event) {
            event.target.src = "/images/noimage.jpg"
        }
    }
};
</script>
<style>
.breadcrumb-style{
    padding-left:0px !important;
    padding-right:0px !important;
}
.svg-style{
    fill:#000000;
}
.g-style{
    mix-blend-mode: normal;
}
.profile_img{
    width: 250px;
}
.hos_profile-style{
    word-wrap: break-word;
}
.h6-style{
    text-align:left;
    font-weight:bold;
}
</style>

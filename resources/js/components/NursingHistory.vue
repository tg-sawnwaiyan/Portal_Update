<template>
    <div class="scrolldiv2 pb-5 tab-content" id="nursing">
        <div class="row m-0">
            <div class="col-12 pad-free pad-free-75">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb" style="padding-left:0px !important;padding-right:0px !important;">
                        <li class="breadcrumb-item">
                            <router-link to="/">ホーム</router-link>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">最近見た介護施設リスト</li>
                    </ol>
                </nav>
            </div>
            <div class="col-md-12 pad-free">
                <div class="col-md-12 fav-his-header pad-free">
                    <svg x="0px" y="0px" width="24" height="24" viewBox="0 0 172 172" style=" fill:#000000;"><g fill="none" fill-rule="nonzero" stroke="none" stroke-width="1" stroke-linecap="butt" stroke-linejoin="miter" stroke-miterlimit="10" stroke-dasharray="" stroke-dashoffset="0" font-family="none" font-weight="none" font-size="none" text-anchor="none" style="mix-blend-mode: normal"><path d="M0,172v-172h172v172z" fill="none"></path><g fill="#c40000"><path d="M86,15.0472l-78.83333,70.9528h21.5v64.5h59.44694c-1.3545,-4.54367 -2.11361,-9.3525 -2.11361,-14.33333h-43v-63.14225l43,-38.6888l57.61328,51.66439h21.22006zM136.19466,100.24935c-19.78717,0 -35.83333,16.04617 -35.83333,35.83333c0,19.78717 16.04617,35.83333 35.83333,35.83333c19.78717,0 35.83333,-16.04617 35.83333,-35.83333c0,-19.78717 -16.04617,-35.83333 -35.83333,-35.83333zM150.89193,119.24382l10.02213,10.03613l-28.30274,28.30274l-21.13606,-21.13607l10.02213,-10.03613l11.11393,11.11393z"></path></g></g></svg>
                &nbsp;<span class="font-weight-bold"> 最近見た介護施設リスト</span>
                &nbsp;<span class ="job_count"> {{his_nus}}件</span>
                <!-- &nbsp;<span style="color:#000;">件</span> -->
                </div>
            </div>

            <!--modal-->
            <div class="modal fade bd-example-modal-google googlecheck" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display:none;">
                <div class="modal-dialog modal-xl" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLongTitle">交通アクセス／{{custname}}</h5>
                            <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <button class="btn btn-secondary">閉じる&times;</button>
                            </button> -->
                             <button type="button" data-dismiss="modal" aria-label="Close" class="close">
                                <button class="btn btn-secondary pc-480">×</button> <button class="btn btn-secondary close-480"><span>×</span>
                                            </button>
                            </button>
                        </div>
                        <div class="modal-body">
                           
                            <GmapMap id="googlemap" ref="map" :center="center" :zoom="10">
                                <GmapMarker v-for="(m, index) in markers" :key="index" :position="m.position" :clickable="true" :draggable="false" @click="center=m.position" />
                            </GmapMap>
                        </div>
                        <div class="modal-body">
                            <span class="job_ico"><i class="fas fa-map-marker-alt"></i></span><strong>住所</strong>
                            <br>
                            <span>{{address}}</span>
                            <hr>
                            <span class="job_ico"><i class="fa fa-map-signs"></i></span><strong>最寄り駅</strong>
                            <br>
                            <p v-html="access"></p>
                        </div>
                        <div class="modal-body">

                        </div>
                    </div>
                </div>
            </div>

            <!--monthly cost and expense cost -->
            <div class="modal fade bd-example-modal-cost costcheck" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display:none;">
                <div class="modal-dialog modal-xl" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLongTitle">料金プラン</h5>
                            <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <button class="btn btn-secondary">閉じる&times;</button>
                            </button> -->
                             <button type="button" data-dismiss="modal" aria-label="Close" class="close">
                                            <button class="btn btn-secondary pc-480">×</button> <button class="btn btn-secondary close-480"><span>×</span>
                                            </button>
                                        </button>
                        </div>
                        <div class="modal-body">
                            <table class="table table-bordered price_tbl test">
                                <thead>
                                    <tr>
                                        <th scope="col">プラン名／居室詳細</th>
                                        <th scope="col">入居時費用</th>
                                        <th scope="col">月額費用</th>
                                    </tr>
                                </thead>
                                <tbody v-for="payment in payment_name" :key="payment.id">
                                    <tr>
                                        <td><h5>【増税対応済】{{payment.payment_name}}</h5>
                                            <p class="room_type"><span>{{payment.living_room_type}}</span>{{payment.area}}</p>
                                        </td>
                                        <td class="expense_txt">{{payment.expense_moving}}</td>
                                        <td class="expense_txt">{{payment.monthly_fees}}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end monthly cost -->
            <div class="col-12">
                <div class="m-t-20"  id="fav-history-page">
                    <div class="col-12">
                        <div class="card-carousel-wrapper">

                            <div class="nav-box" @click="moveCarousel(-1)" :disabled="atHeadOfList">
                                <div class="nav-content mr-2">
                                    <div class="card-carousel--nav__left"></div>
                                </div>
                            </div>
                            <div class="card-carousel">
                                <div class="card-carousel--overflow-container">
                                    <div class="card-carousel-cards" :style="{ transform: 'translateX' + '(' + currentOffset + 'px' + ')'}">
                                        <div class="card-carousel--card">
                                            <div class="card-carousel--card--footer">
                                                <div class="msg"> 
                                                    <label><strong> {{message}} </strong></label>
                                                </div> 
                                                <table class="table table-bordered">
                                                    <tr>
                                                        <td v-for="nur_profile in nur_profiles" :key="nur_profile.id">
                                                            <div class="profile_img_wrap">
                                                                <img class="profile_img" v-bind:src="'/upload/nursing_profile/' + nur_profile.logo" alt @error="imgUrlAlt"/>
                                                            </div>
                                                            <div class="profile_wd">
                                                                <router-link class="pseudolink" :to="{ path:'/profile/nursing/'+ nur_profile.id}" >{{nur_profile.name}}</router-link>
                                                            </div>
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <td v-for="nur_profile in nur_profiles" :key="nur_profile.id">
                                                            <div class="profile_wd">
                                                                <span class="btn btn-danger all-btn hos-btn m-t-8" @click="deleteLocalSto(nur_profile.id)">最近見た介護施設リストから削除</span>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td v-for="nur_profile in nur_profiles" :key="nur_profile.id">
                                                            <div class="profile_wd"> <a :href="nur_profile.website" target="_blank">{{nur_profile.website}}</a></div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td v-for="nur_profile in nur_profiles" :key="nur_profile.id">
                                                            <div class="profile_wd">{{nur_profile.email}}</div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                    <td v-for="nur_profile in nur_profiles" :key="nur_profile.id">
                                                        <dl>
                                                            <dt class="text-left">住所</dt>
                                                            <dd class="profile_wd">{{nur_profile.township_name}} {{nur_profile.city_name}}</dd>
                                                        </dl>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td v-for="nur_profile in nur_profiles" :key="nur_profile.id">
                                                        <dl>
                                                            <dt class="text-left">交通アクセス</dt>
                                                            <dd class="profile_wd"><span v-html="nur_profile.access"></span></dd>
                                                        </dl>
                                                    </td>
                                                </tr>

                                                    <tr>
                                                    <td v-for="nur_profile in nur_profiles" :key="nur_profile.id">
                                                        <div class="profile_wd"><span class="pseudolink" @click="googlemap(nur_profile.id)" data-toggle="modal" data-target=".bd-example-modal-google" data-backdrop="static" data-keyboard="false"><i class="fa fa-search m-r-5"></i>地図・交通アクセス</span></div>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td v-for="nur_profile in nur_profiles" :key="nur_profile.id">
                                                        <dl>
                                                            <dt class="text-left">入居時の費用</dt>
                                                            <dd class="profile_price">
                                                                <strong v-if="Number(nur_profile.moving_in_from) == 0">0円</strong>
                                                                <strong v-else>{{(Math.floor(Number(nur_profile.moving_in_from)/10000))==0? '' : (Math.floor(Number(nur_profile.moving_in_from)/10000)).toLocaleString()+'万' }}{{(Number(nur_profile.moving_in_from)%10000)==0 ? '' : (Number(nur_profile.moving_in_from)%10000).toLocaleString()}}円～</strong></dd>
                                                        </dl>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td v-for="nur_profile in nur_profiles" :key="nur_profile.id">
                                                        <dl>
                                                            <dt class="text-left">月額の費用</dt>
                                                            <dd class="profile_price">
                                                                <strong v-if="Number(nur_profile.per_month_from) == 0">0円</strong>
                                                                <strong v-else>{{(Math.floor(Number(nur_profile.per_month_from)/10000))==0? '' : (Math.floor(Number(nur_profile.per_month_from)/10000)).toLocaleString()+'万' }}{{(Number(nur_profile.per_month_from)%10000)==0 ? '' : (Number(nur_profile.per_month_from)%10000).toLocaleString()}}円～</strong></dd>
                                                        </dl>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td v-for="nur_profile in nur_profiles" :key="nur_profile.id">
                                                        <div class="profile_wd"><span class="pseudolink" @click="monthlyCost(nur_profile.id)" data-toggle="modal" data-target=".bd-example-modal-cost" data-backdrop="static" data-keyboard="false"><i class="fa fa-search m-r-5"></i>料金プランの詳細</span></div>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td v-for="nur_profile in nur_profiles" :key="nur_profile.id">
                                                        <dl>
                                                            <dt class="text-left">入居条件</dt>
                                                            <dd class="profile_wd">{{nur_profile.occupancy_condition }}</dd>
                                                        </dl>
                                                    </td>
                                                </tr>

                                                    <tr>
                                                        <td v-for="nur_profile in nur_profiles" :key="nur_profile.id">
                                                            <ul class="fac_container profile_wd">
                                                                <h6 class="text-left font-weight-bold">特長</h6>
                                                                <li v-for="feature in nur_profile.special" :key="feature.id">{{ feature.short_name }}</li>
                                                            </ul>
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                    <td v-for="nur_profile in nur_profiles" :key="nur_profile.id" >
                                                        <dl>
                                                            <dt class="text-left">定員</dt>
                                                            <dd v-if="nur_profile.capacity != null" class="profile_wd">{{nur_profile.capacity }} </dd>
                                                            <dd v-else class="profile_wd">-人</dd>
                                                        </dl>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td v-for="nur_profile in nur_profiles" :key="nur_profile.id">
                                                        <dl>
                                                            <dt class="text-left">開設日</dt>
                                                            <dd class="profile_wd">{{nur_profile.date_of_establishment }}</dd>
                                                        </dl>
                                                    </td>
                                                </tr>

                                                </table>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="nav-box"  @click="moveCarousel(1)" :disabled="atEndOfList">
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
      nur_profiles: [],
      modal_btn: false,

      local_sto: "",
      message:"",

      type: "nursing",

       iscompare: false,
        markers: [{
            position: {
                lat: 0.0,
                lng: 0.0
            }
        }],
        center: {
            lat: 0,
            lng: 0
        },
        his_nus:'',
      address: '',
      access: '',
      custname: '',
      payment_name: [],
      specialfeature: [],
      currentOffset: 0,
      windowSize: 5,
      paginationFactor: 261,
      window:{
        width: 0,
        height: 0
        }
    };
  },

  computed: {
                atEndOfList() {
                        return this.currentOffset <= (this.paginationFactor * -1) * (this.nur_profiles.length - this.windowSize);
                    },
                    atHeadOfList() {
                        return this.currentOffset === 0;
                    },
            },

  created() {
    this.$loading(true);  
    window.addEventListener('resize', this.handleResize)
    this.handleResize(); 
    if(this.window.width >=320 && this.window.width < 360) {
        this.windowSize = 1;  
        this.paginationFactor = 260;    
    } 
    else if(this.window.width >=360 && this.window.width < 375) {
        this.windowSize = 1;
            this.paginationFactor = 260;    
    } 
        else if(this.window.width >=375 && this.window.width < 450) {
        this.windowSize = 1;
            this.paginationFactor = 260;    
    }
    
    else if(this.window.width >= 414 && this.window.width < 768) {
        this.windowSize = 1;
            this.paginationFactor = 260; 
    } 
    else if(this.window.width >= 768 && this.window.width < 992) {
        this.windowSize = 2;
        this.paginationFactor = 260;  
    }
    else if(this.window.width >= 992 && this.window.width < 1024) {
        this.windowSize = 3; 
        this.paginationFactor = 255;                                 
    }
    else if(this.window.width >= 1024 && this.window.width < 1200) {
        this.windowSize = 3; 
            this.paginationFactor = 255;                                
    }
    else if (this.window.width >= 1200 && this.window.width < 1280) {
        this.windowSize = 3;
        this.paginationFactor = 260;                    
    }
    else if (this.window.width >= 1280 && this.window.width < 1440) {
        this.windowSize = 4;
        this.paginationFactor = 257;
        
    }
    else if (this.window.width >= 1440 && this.window.width < 1880) {
        this.windowSize = 4;
            this.paginationFactor = 260;            
        // console.log(this.window.width);
    }
    
    
    this.local_sto = localStorage.getItem("nursing_history");
        if(this.local_sto){
            this.his_nus = this.local_sto.split(",").length;
        }

    this.getAllCustomer(this.local_sto);

    // this.axios
    //   .get(`/api/profile/specialfeature/${this.type}`)
    //   .then(response => {
    //     this.specialfeature = response.data;
    //   });
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
            allowOutsideClick: false,
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
                // $("#nus-his-local").html(l_sto_arr.length);
                this.nusHis = l_sto_arr.length;
                if(l_sto_arr.length == 0){
                    $('.his-nursing-link-box>a').css({'cursor':'not-allowed','pointer-events':'none'})
                }
                else{
                    $('.his-nursing-link-box>a').css({'cursor':'pointer','pointer-events':'auto'})
                }
                var new_local = l_sto_arr.toString();
                localStorage.setItem('nursing_history', new_local);
                this.local_sto = localStorage.getItem("nursing_history");
            
                if (this.local_sto) {
                    this.his_nus = this.local_sto.split(",").length;
                    this.getAllCustomer(this.local_sto);
                } else {
                   
                    this.$router.push({
                        name: 'nursingSearch',                       
                    });
                }
            }
         });
            
            
            if(this.local_sto){
                this.his_nus = this.local_sto.split(",").length;
            }
     
    },   

    getAllCustomer: function(local_storage) {
      this.axios
        .post("/api/nursing_history/" + local_storage)
        .then(response => {
            this.$loading(false);  
            if(response.data.length>0) {
                this.nur_profiles = response.data;
                if(response.data.length<this.his_nus) {
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
                    // $('.msg').html('<span>Some Nursing Accounts are Deactivated!</span>');
                    var nus_id = '';
                    // this.message = "現在本サイトに掲載されていない介護施設については最近見た施設リストから削除しました。";
                    for(var i= 0;i<this.nur_profiles.length;i++) {
                        if(i== this.nur_profiles.length-1) {
                            nus_id += this.nur_profiles[i]['id'];
                        }
                        else {
                            nus_id += this.nur_profiles[i]['id'] + ",";
                        }
                    }
                    localStorage.setItem('nursing_history',nus_id);
                    this.local_sto = localStorage.getItem("nursing_history");
                    this.nusHis = this.nur_profiles.length;
                }
            } else {
                this.his_nus = 0;
                this.$swal({
                    allowOutsideClick: false,
                    text: "すでに掲載されていない施設をリストから削除しました。",
                    type: 'info',
                    width: 400,
                    height: 200,
                    showConfirmButton: true,
                    // confirmButtonColor: "#dc3545",
                    // cancelButtonColor: "#b1abab",
                    // cancelButtonTextColor: "#000",
                    confirmButtonText: "閉じる",
                    // cancelButtonText: "キャンセル",
                    confirmButtonClass: "all-btn",
                    allowOutsideClick: false,
                    // cancelButtonClass: "all-btn"
                }).then(response => {
                    localStorage.setItem('nursing_history','');
                    this.local_sto = localStorage.getItem("nursing_history");
                    this.nusHis = 0;
                    this.$router.push({
                        name: 'nursingSearch',
                    });
                });
            }
        });
    },

     googlemap: function(id) {
                        $('.googlecheck').css('display', 'block');
                        for (var i = 0; i < this.nur_profiles.length; i++) {
                            if (this.nur_profiles[i].id == id) {
                                this.address = this.nur_profiles[i].address;
                                this.access = this.nur_profiles[i].access;
                                this.markers[0]['position']['lat'] = this.nur_profiles[i].latitude;
                                this.markers[0]['position']['lng'] = this.nur_profiles[i].longitude;
                                this.center['lat'] = this.nur_profiles[i].latitude;
                                this.center['lng'] = this.nur_profiles[i].longitude;
                                this.custname = this.nur_profiles[i].name;
                            }
                        }
                    },
       monthlyCost: function(id) {
                        $('.costcheck').css('display', 'block');
                        for (var i = 0; i < this.nur_profiles.length; i++) {
                            if (this.nur_profiles[i].id == id) {
                                this.payment_name = this.nur_profiles[i].payment_method;
                            }
                        }
                    },
          imgUrlAlt(event) {
                event.target.src = "/images/noimage.jpg"
            }


  }
};
</script>

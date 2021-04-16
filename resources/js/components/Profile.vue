<template>
  <div id="Profile-page">
    <h4 v-if="login_person == 'customer' && visit == 'false'" class="header" style="background:transparent;">{{heading}}</h4>
    <button @click="$router.go(-1)" v-if="login_person == 'admin' && visit == 'false'" class="btn btn-danger all-btn submit admin-backbtn" style="float:right"><i class="fas fa-arrow-left"></i>&nbsp;戻る</button>


    <!-- <span v-if="loginuser=='false' || visit == 'true'">
      <h4 v-if="type == 'nursing'" class="public-nurheader" style="background:transparent;"><i class="fas fa-user-md"></i> ページ</h4>
      <h4 v-if="type == 'hospital'" class="public-hosheader" style="background:transparent;"><i class="fas fa-briefcase-medical"></i> ページ</h4>
    </span> -->

    <div>

      <ul class="nav nav-tabs" :class="type == 'nursing'? 'nursing-tabColor': 'hospital-tabColor'" role="tablist" v-if="$auth.check() && visit == 'false'" id="profilenav" v-bind:style="{width:width}" >
        <li role="presentation" class="subtab1 nav-item" v-if="loginuser=='true' && visit == 'false'">
          <label for="hospital" class="typelabel nav-link active" id="hospital-lbl">
            <i class="fa fa-edit"></i>
            <input type="radio" v-model="btntype" value="create" v-on:change="changeBtnType('hospital-lbl','nursing-lbl')" name="btntype" id="hospital" />
            編集
          </label>
        </li>

        <li role="presentation" class="subtab2 nav-item" v-if="loginuser=='true' && visit == 'false'" >
          <label for="nursing" class="typelabel nav-link" id="nursing-lbl">
            <input type="radio" v-model="btntype" value="view" v-on:change="changeBtnType('nursing-lbl','hospital-lbl')" name="btntype" id="nursing" />
            <span ><i class="fas fa-search" style="font-size:18px;"></i>&nbsp;プレビュー</span>
            <!-- <span v-if="loginuser=='false'"></span> -->
          </label>
        </li>

      </ul>

      <div class="tab-content tab-content1 tabs" :class="type == 'nursing'? 'nursing-borderColor': 'hospital-borderColor'">
        <form class="col-md-12 pad-free" autocomplete="off">
          <div class="col-md-12 pad-free tab-pane" v-if="btntype == 'create'">
            <nursingProfile v-if="type == 'nursing'"></nursingProfile>
            <hospitalProfile v-if="type == 'hospital'"></hospitalProfile>
          </div>

          <div class="col-md-12 pad-free" v-if="btntype == 'view'">
            <profilePublish :pro_id="pro_id" :type="type" :loginuser="loginuser"></profilePublish>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script>
import hospitalProfile from "./HospitalProfile.vue";

import nursingProfile from "./NursingProfile.vue";

import profilePublish from "./ProfilePublish.vue";

export default {
  ready: function() {
    Vue.nextTick(function() {}.bind(this));
  },
  components: {
    hospitalProfile,
    nursingProfile,
    profilePublish
  },
  data() {
    return {
        type: null,
        // pro_id: null,
        btntype: "",
        width: "",
        login_person : null,
        // loginuser: true,
        l_storage_hos_history: [],
        l_storage_nus_history: [],
        l_storage_hos_fav: [],
        l_storage_nus_fav: [],
        view_pro_id: false,
        pro_id:0,
        heading:"",
    };
  },
  created() {    
    this.pro_id = Number(this.$route.params.id);
    this.type = this.$route.params.type;
    if(this.type == 'hospital'){
      this.heading = "病院情報編集";
    }
    else{
      this.heading = "施設情報編集";
    }
    
    if(this.$auth.check()){        
        if(this.$auth.user().role === 1){
            this.login_person = 'customer';            
        }
        else if(this.$auth.user().role === 2) {
            this.login_person = 'admin';
        }
        this.axios.get(`/api/getprofile/${this.pro_id}/${this.type}`).then(response => {
            this.loginView(response);
        })
    }
    else{
        this.publicView();
    }

    this.scrollTop();

    var new_width = $("#content-all").width();
    var fixed_width = new_width - 49.5;
    this.width = fixed_width + "px";

  },
  methods: {
    loginView(response){   
        this.loginuser = 'true';     
        if(this.visit == 'false'){
            this.btntype = "create";
            // this.loginuser = true;
            localStorage.setItem("lat_num", response.data.lat_lng[0].latitude==0?'35.6803997':response.data.lat_lng[0].latitude);
            localStorage.setItem("lng_num", response.data.lat_lng[0].longitude==0?'139.76901739':response.data.lat_lng[0].longitude);
        }
        else{
            this.btntype = "view";
            // this.loginuser = false;            
            this.axios.get(`/api/profile_view/${this.pro_id}/${this.type}`).then(response => {
                localStorage.setItem("lat_num", response.data[0].latitude);
                localStorage.setItem("lng_num", response.data[0].longitude);                
            });
        }
    },
    publicView(){
        this.btntype = "view";
        this.loginuser = 'false';        
        this.axios.get(`/api/profile_view/${this.pro_id}/${this.type}`).then(response => {
            localStorage.setItem("lat_num", response.data[0].latitude);
            localStorage.setItem("lng_num", response.data[0].longitude);            
        });
    },

    changeBtnType(a,b) {
      this.scrollTop();
        document.getElementById(a).classList.add("active");
        document.getElementById(b).classList.remove("active");
    },
    
    scrollTop(){
      $("html, body").animate({ scrollTop: 0 }, "slow");
    }
  }
};
</script>

<style >
#Profile-page {
  /* overflow: hidden; */
  /* max-width: 1600px; */
  width: 100%;
  /* margin-top: 10px; */
}
/* .hospital-tabColor .nav-link {
        background: #63b7ff !important;
        color: #fff;
        border-right: 1px solid #fff;
} */
.nursing-tabColor .nav-link {
        /* background: #ff9563 !important; */
         background: #63b7ff !important;
        color: #fff !important;
        border-right: 1px solid #fff;
}
.hospital-borderColor {
        border: 1px solid #63b7ff !important;
}
.nursing-borderColor {
        /* border: 1px solid #ff9563 !important; */
        border: 1px solid #63b7ff !important;
        background: none;
}
</style>

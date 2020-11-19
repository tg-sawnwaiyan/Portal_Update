<template>
    <div>
        <div>
            <div v-if="!acc_status" class="card card-default card-wrap">
                <p class="record-ico">
                    <i class="fa fa-exclamation"></i>
                </p>  
                <p class="record-txt01">アカウントが無効になりました。</p>
            </div>
            <!-- Create account Area --> 
            <div v-else >
                <div v-if="norecord_msg && !createNew" class="card card-default card-wrap">
                    <p class="record-ico">
                        <i class="fa fa-exclamation"></i>
                    </p>                    
                    <p class="record-txt01" v-if="norecord_msg && type == 'nursing'">施設が登録されていません。</p>
                    <p class="record-txt01" v-if="norecord_msg && type == 'hospital'">病院が登録されていません。</p>
                    <span class="main-bg-color create-btn all-btn" v-if="norecord_msg" @click="ShowHideDiv()">
                        <span v-if="type == 'nursing'">
                            <i class="fas fa-plus-circle"></i> 施設新規作成
                        </span>
                        <span v-else><i class="fas fa-plus-circle"></i> 病院新規作成</span>
                    </span> 
                </div>
                <div v-if="!createNew && !norecord_msg" class="col-12 tab-content" id="nusBlock">
                    <div class="p-2 p0-480">                            
                        <div class="container-fuid">
                            <div class="col-md-12 d-flex header pb-3 admin_header">
                                <h5 v-if="type == 'nursing'">施設一覧</h5>
                                <h5 v-else>病院一覧</h5>
                                <div class="ml-auto">
                                    <a class="" id="newcreate">
                                        <span v-if="type == 'nursing'" class="main-bg-color create-btn all-btn"  @click="ShowHideDiv()">
                                            <span><i class="fas fa-plus-circle"></i>
                                                <span class="dinone">介護施設新規作成</span>
                                            </span>
                                        </span>
                                        <span v-else class="main-bg-color create-btn all-btn"  @click="ShowHideDiv()">
                                            <i class="fas fa-plus-circle"></i>
                                            <span class="dinone">病院新規作成</span>
                                        </span>
                                    </a>
                                </div>
                            </div>
                            <!-- nursing -->
                            <div class="row col-12 m-lr-0  rl" v-if="type == 'nursing'">
                                <div class="col-xs-12 col-md-6 col-lg-4 col-xl-3 column" v-for="nursingprofiles in nursingprofile" :key="nursingprofiles.id">
                                    <div class="card_1">
                                        <img :src="'/upload/nursing_profile/'+ nursingprofiles.logo" alt="aa" @error="imgUrlAlt" />
                                        <div class="card-content">
                                            <div class="title-toggle title_toggle01">
                                            <span class="d-inline-block text-truncate font-weight-bold card-title card-title-leftwrapper">
                                                {{nursingprofiles.name}}
                                            </span>
                                            <span class="card-title-rightwrapper model-7">                                                 
                                                <div class="checkbox">
                                                    <input type='checkbox' :id="nursingprofiles.id" v-if="nursingprofiles.activate == 1" @click="changeActivate(nursingprofiles.id,nursingprofiles.activate)" checked/>
                                                    <input type='checkbox' :id="nursingprofiles.id" v-if="nursingprofiles.activate == 0" @click="changeActivate(nursingprofiles.id,nursingprofiles.activate)"  />
                                                    <label for="checkbox"></label>
                                                    <div  v-if="nursingprofiles.activate == 1" class="on">公開中</div>
                                                    <div v-if="nursingprofiles.activate == 0" class="on">非公開</div>
                                                </div>                                 
                                            </span>
                                            </div>
                                            <p>
                                                <router-link :to="{ path:'/profilejobofferlist/nursing/'+ nursingprofiles.id}" class="acc_router_link">
                                                <i class="vsm--icon fa fa-edit fa-fw i_color"></i>求人編集</router-link>&nbsp;&nbsp;
                                                <router-link :to="{ path:'/jobapplicantlist/nursing/profile/'+ nursingprofiles.id}" class="acc_router_link">
                                                <i class="vsm--icon fa fa-list i_color"></i>求人応募者一覧</router-link>
                                            </p>
                                            
                                        </div>
                                        <div class="card-read-more">
                                            <router-link :to="{ path:'/profile/nursing/'+ nursingprofiles.id}" class="btn edit-borderbtn btn_routerlink">施設情報編集</router-link>
                                            <span class="btn text-danger delete-borderbtn" @click="profileDelete(nursingprofiles.id)" ><i class="fa fa-trash-o" aria-hidden="true"></i>削除</span>
                                        </div>
                                    </div>
                                </div>
                            </div>                           
                            <!-- nursing -->
                            <!-- hospital -->
                            <div class="row col-12 m-lr-0  rl" v-else>
                                <div class="col-xs-12 col-md-6 col-lg-4 col-xl-3 column" v-for="hospitalprofiles in hospitalprofile" :key="hospitalprofiles.id">
                                    <div class="card_1">
                                        <img :src="'/upload/hospital_profile/'+ hospitalprofiles.logo" @error="imgUrlAlt" />
                                        <div class="card-content">
                                            <div class="title-toggle">
                                                <span class="d-inline-block text-truncate font-weight-bold card-title card-title-leftwrapper">
                                                    {{hospitalprofiles.name}}
                                                </span>
                                                <span class="card-title-rightwrapper model-7">  
                                                    <div class="checkbox">
                                                        <input type='checkbox' :id="hospitalprofiles.id" v-if="hospitalprofiles.activate == 1" @click="changeActivate(hospitalprofiles.id,hospitalprofiles.activate)" checked/>
                                                        <input type='checkbox' :id="hospitalprofiles.id" v-if="hospitalprofiles.activate == 0" @click="changeActivate(hospitalprofiles.id,hospitalprofiles.activate)"  />
                                                        <label for="checkbox"></label>
                                                        <div   v-if="hospitalprofiles.activate == 1" class="on">公開中</div>
                                                        <div v-if="hospitalprofiles.activate == 0" class="on">非公開</div>
                                                    </div>                                            
                                                </span>
                                            </div>
                                            <p>
                                                <router-link :to="{ path:'/profilejobofferlist/hospital/'+ hospitalprofiles.id}" class="acc_router_link">
                                                    <i class="vsm--icon fa fa-edit fa-fw i_color"></i>求人編集
                                                </router-link>&nbsp;&nbsp;
                                                <router-link :to="{ path:'/jobapplicantlist/hospital/profile/'+ hospitalprofiles.id}" class="acc_router_link">
                                                    <i class="vsm--icon fa fa-list fa-fw i_color"></i>求人応募者一覧
                                                </router-link>
                                            </p>
                                            
                                        </div>
                                        <div class="card-read-more">
                                            <router-link :to="{ path:'/profile/hospital/'+ hospitalprofiles.id}" class="btn edit-borderbtn btn_routerlink">病院情報編集</router-link>
                                            <span class="btn text-danger delete-borderbtn" @click="profileDelete(hospitalprofiles.id)" >
                                                <i class="fa fa-trash-o" aria-hidden="true"></i>削除
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- hospital -->
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
        return{
        createNew: false, nursingprofile:[], type:null, hospitalprofile:[], norecord_msg: false, acc_status: true, errors: { password: "" , name:"", city:'', township:'' }, activate_text:'',
        }
    },
    created(){
        this.getAccountList();
    },
    methods: {
        imgUrlAlt(event) { 
            event.target.src = "/images/noimage.jpg"
        },
        ShowHideDiv(){                
            this.axios.post(`/api/nursing/movelatlng/${this.cusid}`)
            .then((response) => {
            var pro_id = Number(response.data);
            this.$router.push({ path: '/profile/'+this.type+'/'+ pro_id });
            })    
        },
        CreateNew(){
            if(this.nursing_data.name != '' )
            {
                this.errors.name = "";
            }
            else{
                this.errors.name = "施設名は必須です";
            }
            if(this.nursing_data.city_id != 0 )
            {
                this.errors.city = "";
            }
            else{
                this.errors.city = "都道府県は必須です";
            }
            if(this.nursing_data.town_id != 0)
            {
                this.errors.township = "";    
            }
            else{
                this.errors.township = "市区町村は必須です";
            }
            if(this.errors.city == ""  &&  this.errors.township == "" && this.errors.name == "")
            {
                this.axios.post(`/api/nursing/movelatlng/${this.cusid}`, this.nursing_data)
                .then((response) => {
                    this.$swal({
                    allowOutsideClick: false,
                    text: "施設を作成しました。",
                    type: "success",
                    width: 350,
                    height: 200,
                    confirmButtonColor: "#31CD38",                       
                    confirmButtonText: "閉じる",
                    confirmButtonClass: "all-btn",
                })
                .then(response => { 
                    this.createNew = false;
                    this.getAccountList();
                });
                this.nursing_data.name = '';
                this.nursing_data.town_id = 0;
                this.nursing_data.city_id = 0;
                });
            }  
        },
       
        getAccountList(){
            this.cusid = this.$route.params.id;
            this.type = this.$route.params.type;
            if(this.type == "nursing") {
                this.axios.get(`/api/account_nursing/${this.cusid}`).then(response => {
                    this.nursingprofile = response.data.nuscustomer;
                    if(response.data.status == 0) {
                        this.acc_status = false;
                    }
                    else{
                        this.acc_status = true;
                    }
                    if(this.nursingprofile.length != 0){
                        this.norecord_msg = false;
                    }else{
                        this.norecord_msg = true;
                    }
                });
            }else {
                this.axios.get(`/api/account_hospital/${this.cusid}`).then(response => {
                    this.hospitalprofile = response.data.hoscustomer;
                    if(response.data.status == 0) {
                        this.acc_status = false;
                    }
                    else{
                        this.acc_status = true;
                    }
                    if(this.hospitalprofile.length != 0){
                        this.norecord_msg = false;
                    }else{
                        this.norecord_msg = true;
                    }
                });
            }
        },
        changeActivate(id,activate, $event){
            if(activate == 1)
            {
                this.activate_text = "施設を非公開にしてよろしいでしょうか。";
            }
            else{
                this.activate_text = "施設を公開してよろしいでしょうか。";
            }
            this.type = this.$route.params.type;        
            this.$swal({
                allowOutsideClick: false,
                text: this.activate_text,
                type: "warning",
                width: 350,
                height: 200,
                showCancelButton: true,
                confirmButtonColor: "#eea025",
                cancelButtonColor: "#b1abab",
                cancelButtonTextColor: "#000",
                confirmButtonText: "はい",
                cancelButtonText: "キャンセル",
                confirmButtonClass: "all-btn",
                cancelButtonClass: "all-btn"
            }).then(response => {
                this.axios.get(`/api/changeActivate/${id}/`+this.type)
                .then(response => {
                    this.getAccountList();
                });
            }).catch(error =>{
                if(activate == 1){
                    $("#"+id).prop("checked", true);
                }else{
                    $("#"+id).prop("checked", false);
                }                
            });
        },
        profileDelete(id){
            this.type = this.$route.params.type;
            this.$swal({
                allowOutsideClick: false,
                text: "施設を削除してよろしいでしょうか。",
                type: "warning",
                width: 350,
                height: 200,
                showCancelButton: true,
                confirmButtonColor: "#eea025",
                cancelButtonColor: "#b1abab",
                cancelButtonTextColor: "#000",
                confirmButtonText: "はい",
                cancelButtonText: "キャンセル",
                confirmButtonClass: "all-btn",
                cancelButtonClass: "all-btn"
            }).then(response => {
                this.$loading(true);
                this.axios.delete(`/api/profileDelete/${id}/`+this.type)
                .then(response => {
                    this.$loading(false);
                    this.getAccountList();
                });                   
            });
        },
        getTownship(){
            this.errors.city = '';
            this.nursing_data.town_id = 0;
            this.axios.get('/api/auth/township',{
                params:{
                    city:this.nursing_data.city_id
                },
            }).then((response)=>{
                this.town_list = response.data.townships
            })
        }
        /* CancelNew(){
            this.createNew = false;
            this.nursing_data.city_id = 0;
            this.nursing_data.town_id = 0;
            this.errors.city = '';
            this.errors.township = '';
        },
        */
    }
}
</script>
<style scoped>
.acc_color{
    color:#2980b9
}
img{
    vertical-align: middle;
    border-style: none;
    width: 100%;
    height: 230px;
}
.email{
    color:#8e8c8c;
}
.img-card {
    width: 100%;
    height:200px;
    border-top-left-radius:2px;
    border-top-right-radius:2px;
    display:block;
    overflow: hidden;
}
.img-card img{
    width: 100%;
    height: 200px;
    object-fit:cover; 
    transition: all .25s ease;
} 
.rl{
    padding:0px;
}
.column{
    padding-right: 7px;
    padding-left: 7px;
}
.model-7{
    text-align:end;
}
.checkbox{
    text-align:left;
}
.container-fostrap {
    display: table-cell;
    padding: 1em;
    vertical-align: middle;
}
.fostrap-logo {
    width: 100px;
    margin-bottom:15px
}
h1.heading {
    color: #fff;
    font-size: 1.15em;
    font-weight: 900;
    margin: 0 0 0.5em;
    color: #505050;
}
@media (min-width: 450px) {
    h1.heading {
        font-size: 3.55em;
    }
}
@media (min-width: 760px) {
    h1.heading {
        font-size: 3.05em;
    }
}
@media (min-width: 900px) {
    h1.heading {
        font-size: 3.25em;
        margin: 0 0 0.3em;
    }
} 
.card_1 {
    display: block; 
    margin-bottom: 20px;
    line-height: 1.42857143;
    background-color: #fff;
    border-radius: 2px;
    box-shadow: 0 2px 5px 0 rgba(0,0,0,0.16),0 2px 10px 0 rgba(0,0,0,0.12); 
    transition: box-shadow .25s; 
}
.card_1:hover {
    opacity: 0.9;
}
.img-card {
    width: 100%;
    height:200px;
    border-top-left-radius:2px;
    border-top-right-radius:2px;
    display:block;
    overflow: hidden;
}
.img-card img{
    width: 100%;
    height: 200px;
    object-fit:cover; 
    transition: all .25s ease;
} 
.title-toggle{
    margin-bottom:10px;
}
.title_toggle01{
    width: 100%;
}
.card-content {
    padding:10px;
    text-align:left;
}
.card-title { 
    font-size: 20px;
}
.card-title-leftwrapper{
    width: 70%;
    min-height: 30px;
}
.card-title-rightwrapper{
    width: 30%;
}
.card-title-rightwrapper .checkbox{
    vertical-align: top;
}
.card-title a {
    color: #000;
    text-decoration: none !important;
}
.card-read-more {
    border-top: 1px solid #D4D4D4;
    padding:10px 10px;
    text-align:right;
}
.card-read-more a {
    text-decoration: none !important;
    font-weight:600;
    text-transform: uppercase
}
/* toggle */
.switch-input {
    display: none;
}
.switch-label {
    float:right;
    position: relative;
    display: inline-block;
    cursor: pointer;
    color: #727272;
    font-weight: 500;
    text-align: left;
    padding: 5px 0 4px 44px;
}
.switch-label:before, .switch-label:after {
    content: "";
    position: absolute;
    margin: 0;
    outline: 0;
    top: 50%;
    -webkit-transform: translate(0, -50%);
    transform: translate(0, -50%);

    
    transition: all 0.3s ease;
}
.switch-label:before {
    left: 1px;
    width: 34px;
    height: 14px;
    background-color: #b6b6b6;
    border-radius: 8px;
}
.switch-label:after {
    left: 0;
    width: 20px;
    height: 20px;
    background-color: #FAFAFA;
    border-radius: 50%;
    box-shadow: 0 3px 1px -2px rgba(0, 0, 0, 0.14), 0 2px 2px 0 rgba(0, 0, 0, 0.098), 0 1px 5px 0 rgba(0, 0, 0, 0.084);
}
.switch-label .toggle--on {
    display: none;
}
.switch-label .toggle--off {
    display: inline-block;
}
.switch-input:checked + .switch-label:before {
    background-color: #2F6FA8;
}
.switch-input:checked + .switch-label:after {
    background-color: #428BCA;
    -webkit-transform: translate(80%, -50%);
    transform: translate(80%, -50%);
}
.switch-input:checked + .switch-label .toggle--on {
    display: inline-block;
}
.switch-input:checked + .switch-label .toggle--off {
    display: none;
}
.switch-input:checked + .switch-label .toggle--option {
    color: #428BCA;
}
.acc_router_link{
    font-weight:bold;
    text-decoration:underline;
}
.i_color{
    color: #585858;
}
.btn_routerlink{
    float:left;
}
</style>
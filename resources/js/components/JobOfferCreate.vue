<template>
    <!-- Page Content  -->
    <div class="row">
        <div class="col-md-12">
            <div class="card text-dark">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <h4 class="page-header header">{{ header }}</h4>
                        </div>
                        <form @submit.prevent="add" class="col-md-12" autocomplete="off">
                            <div class="form-group" v-if="$auth.check(2)">
                                <div class="form-group" v-if="editcheck">
                                    <label>事業者名</label>
                                    <label>{{cusName}}</label>
                                    <br>
                                    <label>施設名</label>
                                    <label>{{profileName}}</label>
                                </div>
                                <div v-if="type == 'admin'">
                                    <label>事業者名</label>
                                    <autocomplete placeholder="事業者名を検索" input-class="form-control" :source=customerList :results-display="formattedDisplay" @clear="cleartext()" @selected="getSelected($event)"></autocomplete>
                                    <span v-if="errors.customer_id" class="error">{{errors.customer_id}}</span>
                                    <br>
                                    <label>施設名</label>
                                    <select v-model="selectedValue" class="division form-control" @change="getProfile($event)">
                                        <option value="0">選択してください。</option>
                                        <option v-for="profile in profileList" :key="profile.id" v-bind:value="profile.id">
                                            {{profile.name}}
                                        </option>
                                    </select>
                                    <span v-if="errors.profile_id" class="error">{{errors.profile_id}}</span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="title">
                                    タイトル
                                    <span class="error sp2">必須</span>
                                </label>
                                <input type="title" class="form-control box" id="title" name="title" v-model="joboffer.title" placeholder="タイトルを入力してください。" />
                                <!-- <span v-if="errors.title" class="error">{{ errors.title }}</span> -->
                                 <span v-if="errors.title" class="error">{{errors.title}}</span>
                            </div>
                            <div class="form-group">
                                <label for="description">
                                    仕事内容
                                    <span class="error sp2">必須</span>
                                </label>
                                <textarea name="description" class="form-control" cols="50" rows="5" v-model="joboffer.description" placeholder="仕事内容を入力してください。"></textarea>
                                <!-- <span v-if="errors.description" class="error">{{errors.description}}</span> -->
                                 <!-- <span v-if="errors.includes('description')" class="error">題名は必須です。(description)</span> -->
                                <span v-if="errors.description" class="error">{{errors.description}}</span>
                            </div>
                            <div class="form-group">
                                <label for="skill">
                                    経験・スキル
                                    <span class="error sp2">必須</span>
                                </label>                               
                                <textarea name="skills" class="form-control" cols="50" rows="5" v-model="joboffer.skills" placeholder="経験・スキルを入力してください。"></textarea>
                                <span v-if="errors.skills" class="error">{{errors.skills}}</span>                             
                            </div>
                            <div class="form-group">
                                <label for="location">
                                    郵便番号 
                                    <!-- <span class="error sp2">必須</span> -->
                                </label>
                                <div class="row m-0">
                                    <div class="col-sm-6 col-12 pl-0 tel-input">
                                        <input type="text" class="form-control box" id="postal" placeholder="1006740" v-model="joboffer.postal" v-on:keydown="postalNumber" maxlength="7" />
                                    </div>
                                    <div class="col-sm-6 col-12 tel-button">
                                        <span class="float-left submit1 btn main-bg-color continue all-btn submit" @click="getPostal">郵便番号より住所を検索</span>
                                        <span class="float-left eg-txt">例）1006740 (<a href="https://www.post.japanpost.jp/zipcode/" target="_blank" class="pseudolink">郵便番号検索</a>)</span>
                                    </div>
                                </div>
                                <span id="jsErrorMessage" class="m-t-8"></span>                                
                                <!-- <span v-if="errors.includes('postal')" class="error">題名は必須です。(postal)</span> -->
                                <!-- <span v-if="errors.postal" class="error">{{errors.postal}}</span> -->
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="location">
                                            都道府県
                                            <span class="error sp2">必須</span>
                                        </label>                          
                                        <select v-model="joboffer.pref" class="division form-control"  @change="getTownship(2)">
                                            <option value="0">選択してください。</option>
                                            <option v-for="cities in city_list" :key="cities.id" v-bind:value="cities.id">
                                                {{cities.city_name}}
                                            </option>
                                        </select>                         
                                        <span v-if="errors.pref" class="error">{{errors.pref}}</span>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="location">
                                            <!-- 番地（建物名) -->市区町村
                                            <span class="error sp2">必須</span>
                                        </label>                                
                                        <select v-model="joboffer.str_address" class="division form-control" @change="getLocation()"  >
                                            <option value="0">市区町村を選択してください。</option>
                                            <option v-for="tw in townships" :key="tw.id" v-bind:value="tw.id">
                                                {{tw.township_name}}
                                            </option>
                                        </select>
                                        <!-- <input type="text" class="form-control box" v-model="joboffer.str_address" placeholder="市区町村、番地を入力してください。" /> -->
                                        <span v-if="errors.str_address" class="error">{{errors.str_address}}</span>
                                        <!-- <span v-if="errors.includes('str_address')" class="error">題名は必須です。(str_address)</span> -->
                                        <!-- <span v-if="errors.name" class="error">{{errors.str_address}}</span> -->
                                    </div>
                                </div>                                
                            </div>
                            <!-- <div class="form-group">                                
                            </div> -->
                            <div class="form-group">
                                <label for="location">
                                    勤務地
                                    <span class="error sp2">必須</span>
                                </label>
                                <textarea name="location" class="form-control" cols="50" rows="5" v-model="joboffer.location" placeholder="勤務地を入力してください。"></textarea>
                                <span v-if="errors.location" class="error">{{errors.location}}</span>
                                <!-- <span v-if="errors.includes('location')" class="error">題名は必須です。(location)</span> -->
                            </div>
                            <div class="form-group">
                                <label for="neareststation">最寄り駅</label>
                                <textarea name="neareststation" class="form-control" cols="50" rows="5" v-model="joboffer.nearest_station" placeholder="最寄り駅を入力してください。"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="neareststation">雇用形態</label>
                                <br />
                                <label class="control control--radio">
                                    <input type="radio" value="契約社員" v-model="joboffer.employmentstatus" /> 契約社員 &nbsp;&nbsp;&nbsp;
                                    <div class="control__indicator"></div>
                                </label>
                                <label class="control control--radio">
                                    <input type="radio" value="非常勤" v-model="joboffer.employmentstatus" /> 非常勤 &nbsp;&nbsp;&nbsp;
                                    <div class="control__indicator"></div>
                                </label>
                                <label class="control control--radio">
                                    <input type="radio" value="正職員" v-model="joboffer.employmentstatus" /> 正職員 &nbsp;&nbsp;&nbsp;
                                    <div class="control__indicator"></div>
                                </label>
                                <label class="control control--radio">
                                    <input type="radio" value="その他" v-model="joboffer.employmentstatus" /> その他
                                    <div class="control__indicator"></div>
                                </label>
                            </div>                        
                            <div class="form-group">
                                <label for="salary">職種</label>
                                <span class="error sp2">必須</span>
                                <select v-model="joboffer.occupation_id" class="form-control">
                                    <option value="-1">なし</option>
                                    <option v-for="occupation in OccupationList" :key="occupation.id" :value="occupation.id">{{occupation.name}}</option>
                                </select>
                                <span v-if="errors.occupation_id" class="error">{{errors.occupation_id}}</span>
                            </div>
                            <div class="form-group">
                                <label for="salary">
                                    給与
                                    <span class="error sp2">必須</span>
                                </label>
                                <div class="row m-0">                                 
                                    <div class="ml-0 joboffer-salary col-6 padding-left-0">
                                        <input type="text" class="form-control" v-model="joboffer.salary" name="salary" placeholder="給与を入力してください。"/>
                                        <p v-if="errors.salary" class="error">{{errors.salary}}</p>
                                    </div>
                                    <!-- <span v-if="errors.includes('salary')" class="error">題名は必須です。(salary)</span> -->
                                    <span class="pt-1 pl-1 col-6">例：時給1000～2000円</span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="salary_remark">給料備考</label>
                                <textarea name="salary_remark" class="form-control" cols="50" rows="5" v-model="joboffer.salary_remark" placeholder="給料備考を入力してください。"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="allowance">諸手当</label>
                                <textarea name="allowance" class="form-control" cols="50" rows="5" v-model="joboffer.allowances" placeholder="諸手当を入力してください。"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="insurance">各種保険</label>
                                <textarea name="insurance" class="form-control" cols="50" rows="5" v-model="joboffer.insurance" placeholder="各種保険を入力してください。"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="workhour">
                                    就業時間
                                    <span class="error sp2">必須</span>
                                </label>
                                <input type="workhour" class="form-control" name="workhour" v-model="joboffer.working_hours" placeholder="就業時間を入力してください。" />
                                <span v-if="errors.working_hours" class="error">{{errors.working_hours}}</span>
                                <!-- <span v-if="errors.includes('working_hours')" class="error">題名は必須です。(working_hours)</span> -->
                            </div>
                            <div class="form-group">
                                <label for="holiday">休日休暇</label>
                                <textarea name="holiday" class="form-control" cols="50" rows="5" v-model="joboffer.holidays" placeholder="休日休暇を入力してください。"></textarea>
                            </div>
                            <div class="form- group row">
                                <div class="col-sm-3"></div>
                            </div>
                            <div v-if="errors.checkallerror" class="error">{{errors.checkallerror}}
                            </div>
                            <div class="form-group">
                                <span class="btn bt-red all-btn" @click="$router.go(-1)">キャンセル</span>
                                <span class="btn main-bg-color white all-btn"  @click="checkValidate()">{{subtitle}}</span>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Autocomplete from 'vuejs-auto-complete'
    export default {
        components: {
            Autocomplete,
        },
        data() {
            return {
                type: '',
                header: "求人作成",
                subtitle: "作成",
                errors: {
                  title: '',
                  description:'',
                  postal:'',
                  pref:'',
                  str_address:'',
                  location:'',
                  salary_type:'',
                  salary:'',
                  working_hours:'',
                  occupation_id: '',
                  customer_id:'',
                  profile_id:'',
                  checkallerror:'',
                  skills:'',
                },
                OccupationList: {
                    id: "",
                    name: ""
                },
                joboffer: {
                    title: "",
                    description:"",
                    customer_id: "",
                    occupation_id: -1,
                    description: "",
                    salary_type:-1,
                    fields: [{
                        skills: "",

                        id: ""
                    }],
                    skills:"",
                    postal: "",
                    zipcode_id: "",
                    pref: "",
                    str_address: "",
                    township_id: "",
                    location: "",
                    nearest_station: "",
                    employmentstatus: "",
                    working_hours: "",
                    employment_status: [{
                        pchecked: false,
                        fchecked: false,
                        echecked: false,
                        cchecked: false,
                        ochecked: false
                    }],
                    salary_type: '-1',
                    salary: "",
                    salary_remark: '',

                    insurance: "",

                    holidays: "",

                    user_id: "",

                    recordstatus: "",
                    profile_id: 0,
                },
                ischeck: "",
                selectedValue: 0,
                city_list:[],
                townships:[],
                customerList: {
                    id: "",
                    name: "",
                    email: "",
                    type_id: ""
                },
                editcheck: false,
                cusName: '',
                profileList: {
                    id:"",
                    name:""
                },
                profileName: '',
                table_name: {
                    profile: ''
                }
            };
        },
        created() {
            this.joboffer.pref = 0;
            this.joboffer.str_address = 0;
            this.joboffer.employmentstatus = 'その他';             
            this.axios.get("/api/job/occupationlist").then(
                function(response) {
                    this.OccupationList = response.data;
                }.bind(this)
            );
            this.axios.get('/api/hospital/citiesList')
            .then(response => {
                this.city_list = response.data;
            });
            this.axios.get('/api/job/customerList/'+'job')
            .then(response=> {
                this.customerList = response.data;
                this.formattedDisplay(this.customerList);
            });
            if (this.$route.name == 'jobedit') {
                this.editcheck = true;
                this.axios
                .get(`/api/job/edit/${this.$route.params.id}`)
                .then(response => {
                    this.joboffer.title = response.data.job[0].title;
                    if(response.data.job[0].zip7_code == null){
                        this.joboffer.postal = "";
                        this.joboffer.zipcode_id = null;
                    }
                    else{
                        this.joboffer.postal = '0' + response.data.job[0].zip7_code;
                        this.joboffer.zipcode_id = response.data.job[0].zip_id;
                    }            
                    this.joboffer.pref = response.data.job[0].city_id;
                    this.getTownship(1);
                    this.joboffer.str_address = response.data.job[0].township_id;
                    this.joboffer.customer_id = response.data.job[0].customer_id;
                    this.selectedValue = response.data.job[0].occupation_id;
                    this.joboffer.occupation_id = response.data.job[0].occupation_id;
                    this.joboffer.description = response.data.job[0].description;
                    this.joboffer.skills = response.data.job[0].skills;
                    this.joboffer.location = response.data.job[0].location;
                    this.joboffer.nearest_station = response.data.job[0].nearest_station;
                    this.joboffer.employmentstatus = response.data.job[0].employment_status;
                    this.joboffer.salary_type = response.data.job[0].salary_type;
                    this.joboffer.salary = response.data.job[0].salary;
                    this.joboffer.salary_remark = response.data.job[0].salary_remark;
                    this.joboffer.allowances = response.data.job[0].allowances;
                    this.joboffer.insurance = response.data.job[0].insurance;
                    this.joboffer.working_hours = response.data.job[0].working_hours;
                    this.joboffer.holidays = response.data.job[0].holidays;
                    this.joboffer.user_id = response.data.job[0].user_id;
                    this.joboffer.recordstatus = response.data.job[0].recordstatus;
                    this.joboffer.profile_id = response.data.job[0].profile_id;
                    this.header = " 求人編集";
                    this.subtitle = "保存";
                    this.axios.get('/api/job/customerList/job')
                    .then(response=> {
                        var cus_list = response.data;
                        for(var i=0; i<cus_list.length; i++){
                        if(this.joboffer.customer_id == response.data[i].id){
                            this.cusName = response.data[i].name + '「 ' +response.data[i].email+ ' 」';
                            if(response.data[i].type_id == 2){
                            this.table_name.profile = 'hospital_profiles';
                        }else{
                            this.table_name.profile = 'nursing_profiles';
                        }
                        }
                        }
                    
                    this.axios.post(`/api/job/profileName/${this.joboffer.profile_id}`,this.table_name)
                    .then(response=> {
                
                        for(var i=0; i<response.data.length; i++){
                        
                            if(this.joboffer.profile_id == response.data[i].id){
                                
                                this.profileName = response.data[i].name;
                                this.selectedValue = -1;
                                
                            }
                        }
                    });
                        this.customerList = response.data;
                    });
                    
                    return this.header;
                    return this.subtitle;
                });
            }
            else if(this.$route.name == 'profilejoboffercreate'){                    
                this.editcheck = true;   
                this.joboffer.profile_id = this.$route.params.id;
                this.type = 'profile';
                if(this.$route.params.type == "nursing")
                {
                    this.table_name.profile = 'nursing_profiles';
                }
                else{
                    this.table_name.profile = 'hospital_profiles';
                }                 
                this.axios.post(`/api/job/profileName/${this.joboffer.profile_id}`,this.table_name)
                .then(response=> {
                    this.joboffer.customer_id = response.data[0].cus_id;                      
                    for(var i=0; i<response.data.length; i++){                            
                        if(this.joboffer.profile_id == response.data[i].id){                                  
                            this.profileName = response.data[i].name;
                            this.cusName = response.data[i].cus_name + '「 ' +response.data[i].cus_email+ ' 」';
                            this.selectedValue = -1;
                        }
                    }
                });
            }
            else{
                this.editcheck = false;
                this.type = 'admin';
            }
        },
        methods: {
            checkValidate() {
                if(this.joboffer.customer_id == "")
                {
                    this.errors.customer_id = "事業者名は必須です。";
                }
                else{
                    this.errors.customer_id = "";
                }
                if((this.selectedValue == -1 && this.profileName == '') || ( this.selectedValue == 0) )
                {
                    this.errors.profile_id = "施設名は必須です。";
                }
                else{
                    this.errors.profile_id = "";
                }
                if (this.joboffer.title == '') {
                    this.errors.title = '施設種別名は必須です。';
                } else {
                    this.errors.title = "";
                }
                if (this.joboffer.description == '') {
                    this.errors.description = '仕事内容は必須です。';
                } else {
                    this.errors.description = "";
                }                      
                // if (this.joboffer.postal == '') {
                //     this.errors.postal = '郵便番号は必須です。';
                // } else {
                //     this.errors.postal = "";
                // }
                if (this.joboffer.pref == '') {
                    this.errors.pref = '都道府県は必須です。';
                } else {
                    this.errors.pref = "";
                }
                if (this.joboffer.str_address == '') {
                    this.errors.str_address = '市区町村は必須です。';
                } else {
                    this.errors.str_address = "";
                }
                if (this.joboffer.location == '') {
                    this.errors.location = '勤務地は必須です。';
                } else {
                    this.errors.location = "";
                }
                // if (this.joboffer.salary_type == '-1') {
                //     this.errors.salary_type = " 給与タイプは必須です。";
                // }
                // else {
                //     this.errors.salary_type = null;
                // }
                if (this.joboffer.salary == '') {
                    this.errors.salary = '給与は必須です。';
                } else {
                    this.errors.salary = "";
                }             
                if (this.joboffer.working_hours == '') {
                    this.errors.working_hours = '就業時間は必須です。';
                } else {
                    this.errors.working_hours = "";
                }
                if (this.joboffer.skills == '') {
                    this.errors.skills = '経験・スキルは必必須です。';
                } else {
                    this.errors.skills = "";
                }
                if (this.joboffer.occupation_id == '-1' || this.joboffer.occupation_id == '') {
                    this.errors.occupation_id = " 職種は必須です。";
                }
                else {
                    this.errors.occupation_id = null;
                }
                if (
                    !this.errors.title &&
                    !this.errors.description &&
                    // !this.errors.postal &&
                    !this.errors.pref &&
                    !this.errors.location &&
                    !this.errors.description &&
                    !this.errors.salary_type &&
                    !this.errors.salary &&
                    !this.errors.working_hours&&
                    !this.errors.occupation_id && 
                    !this.errors.customer_id && 
                    !this.errors.profile_id &&
                    !this.errors.skills 
                ) {                          
                    this.errors.checkallerror = "";
                    this.add();
                }
                else{                         
                    this.errors.checkallerror = "保存できません。必須項目を確認してください。"
                }
            },
            getPostal: function(event) {
                if (this.joboffer.postal.length > 5) {
                    var postal = this.joboffer.postal;
                    this.axios.post("/api/hospital/postList/" + postal).then(response => {
                        var post_data = response.data.postal_list;
                        var length = response.data.postal_list.length;
                        if (length > 0) {
                            var pref = post_data[0]["city_id"];
                            this.joboffer.zipcode_id = post_data[0]["id"];
                            this.joboffer.pref = post_data[0]["city_id"];
                            this.getTownship(1);
                            this.joboffer.str_address = response.data.township_id[0]['id'];                               
                            this.joboffer.location = post_data[0]["street"];
                            $('#jsErrorMessage').html('<div></div>');
                        } else {
                            this.joboffer.str_address = 0;
                            this.joboffer.pref = 0;
                            this.joboffer.city = "";
                            $("#jsErrorMessage").html(
                                '<div class="error">郵便番号の書式を確認してください。</div>'
                            );
                        }
                    });
                }
            },
            getTownship(town_id){            
                this.axios.get('/api/auth/township',{
                    params:{
                        city:this.joboffer.pref
                    },
                }).then((response)=>{
                    if(town_id == 2)
                    {
                        this.joboffer.location = ''
                        // this.joboffer.postal = '';
                        this.joboffer.zipcode_id = null;
                        this.joboffer.str_address = 0;
                    }
                    this.townships = response.data.townships
                })
            },
            getLocation(){
                //  this.joboffer.postal = '';
                this.joboffer.location = '';
            },
            add() {              
                if (this.$route.name == 'jobedit') {
                    this.updateJob();
                } else {
                    this.$swal({
                        // title: "確認",
                        text: "求人を作成してよろしいでしょうか。",
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
                        cancelButtonClass: "all-btn",
                        allowOutsideClick: false,                           
                    }
                    ).then(response => {                    
                        this.$loading(true);                         
                        this.axios.post("/api/job/add", this.joboffer)
                        .then(response => {
                            this.$loading(false);
                            this.$swal({
                                position: "top-end",
                                type: "success",
                                text: "求人を作成しました。",
                                // text: "ファイルが作成されました。",
                                // type: "success",
                                width: 350,
                                height: 200,
                                confirmButtonText: "閉じる",
                                confirmButtonColor: "#31cd38",
                                allowOutsideClick: false,
                            });
                            // alert('Successfully Created')
                            this.$router.go(-1);
                            // this.$router.push({
                            //     name: "jobofferlist"
                            // });
                            // this.$route.params.id = null;
                        })
                        .catch(error => {
                            this.$loading(false);
                            if (error.response.status == 422) {
                                this.errors = error.response.data.errors;
                            }
                        });
                    });
                }
            },
            getParent: function() {
                this.joboffer.occupation_id = this.selectedValue;
            },          
            addRow: function() {
                this.joboffer.fields.push({
                    skills: "",
                    id: ""
                });
            },
            delRow: function(id) {
                this.joboffer.fields.splice(id, 1);
                // this.joboffer.fields.pop();
            },
            createskill: function(arr) {
                this.joboffer.fields.shift();
                for (var i = 0; i < arr.length; i++) {
                    this.joboffer.fields.push({
                        skills: arr[i],
                        id: arr[i]
                    });
                }
            },              
            updateJob() {
                this.$swal({
                    // title: "確認",
                    text: "求人を更新してよろしいでしょうか。",
                    type: "warning",
                    width: 350,
                    height: 200,
                    showCancelButton: true,
                    confirmButtonColor: "#eea025",
                    cancelButtonColor: "#b1abab",
                    cancelButtonTextColor: "#000",
                    confirmButtonText: "はい",
                    cancelButtonText: "キャンセル",
                    confirmButtonClass:  "all-btn",
                    cancelButtonClass: "all-btn",
                    allowOutsideClick: false,
                }).then(response => {
                    this.$loading(true);
                    this.axios.post(`/api/job/update/${this.$route.params.id}`, this.joboffer)
                    .then(response => {
                        this.joboffer = response.data.job;
                        this.$loading(false);                        
                        this.$swal({
                            // title: "求人を更新しました",
                            // text: "ファイルが更新されました。",
                            text:"求人を更新しました。",
                            type: "success",
                            width: 350,
                            height: 200,
                            confirmButtonText: "閉じる",
                            confirmButtonColor: "#31cd38",
                            allowOutsideClick: false,
                        });
                        var num = localStorage.getItem('page_no'); 
                        // this.$router.push({ name: 'jobofferlist', params: { status: 'update','page_no':num } })
                        this.$router.go(-1);
                    })
                    .catch(error => {
                        if (error.response.status == 422) {
                            this.errors = error.response.data.errors;
                        }
                    });
                });
            },
            formattedDisplay(result) {
                return result.name + '「' + result.email + '」';
            },
            cleartext(){
                this.selectedValue = 0;
                this.joboffer.customer_id = '';
                this.profileList = [];
            },
            getSelected(event){
                this.errors.customer_id = "";       
                if(event.selectedObject.type_id == 3){
                    this.table_name.profile = 'nursing_profiles';
                }else {
                    this.table_name.profile = 'hospital_profiles';
                }
                this.joboffer.customer_id = event.value;
                this.axios.post(`/api/job/profileList/${this.joboffer.customer_id}`,this.table_name)
                .then(response=> {
                    this.profileList = response.data;                 
                    if(this.profileList != ''){
                        this.selectedValue = this.profileList[0].id;
                        this.joboffer.profile_id = this.profileList[0].id;
                    }else{
                        this.selectedValue = 0;
                    }
                });
            },
            getProfile(event){
                this.joboffer.profile_id = event.target.value;
                if(this.joboffer.profile_id != 0)
                {
                    this.errors.profile_id = "";
                }
            },
            postalNumber: function(event) {
                if(!(event.keyCode >= 48 && event.keyCode <= 57) && !(event.keyCode >= 96 && event.keyCode <= 105) 
                    && event.keyCode != 8 && event.keyCode != 46 && !(event.keyCode >= 37 && event.keyCode <= 40)) 
                {
                    event.preventDefault();
                }
            },
        }
    };
</script>

<style scoped>
    .bt-red{
        color: #fff;
        background-color: #e3342f;
        border-color: #e3342f;
    }
    .bt-suc{   
        color: #fff;
        background-color: #0cc72c; 
        border-color: #0cc72c;
    }
    .padding-left-0 {
        padding-left:0px;
    }
</style>

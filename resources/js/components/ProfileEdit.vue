<template>
    <!--test-->
    <div class="row">
        <div class="col-md-12">
            <div class="card  text-dark">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <h4 class="page-header header">
                                プロフィール設定 
                                <a v-if="$auth.check(2)" @click="$router.go(-1)" class="btn bt-red all-btn submit float-right">
                                    <i class="fas fa-arrow-left"></i>
                                    &nbsp;戻る
                                </a>
                            </h4>
                            <span v-if="!$auth.check(2) && derecordstatus != 1" class="deactive">
                                このアカウントは現在無効となっています
                            </span>
                            <br>
                        </div>
                        <form class="col-md-8" autocomplete="off">
                            <div class="card card-default m-b-20 col-md-11">
                                <div class="card-body">
                                    <h5 class=" clearfix">
                                        事業者番号 
                                        <span class="color-clearfix">{{customer_info.cusnum}}</span>
                                    </h5>
                                </div>
                            </div>
                            <!--card-->
                           
                            <!--card-->

                            <!--card-->
                            <div class="card card-default m-b-20 col-md-11">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-12 m-t-8">
                                            <div class="header2">
                                                <h5 class=" clearfix">パスワード設定</h5>
                                            </div>
                                            <div class="form-group">                                                
                                                <label class="old-pass">現在のパスワード</label>
                                                <input type="password" name="old_password" v-model="old_password" placeholder="現在のパスワードを入力してください。" class="form-control old-password">
                                                <div class="error error-display" id="oldpassword">現在のパスワードが必要です。</div>
                                                <br>
                                                <label class="old-pass">新しいパスワード</label>
                                                <input type="password" name="new_password" placeholder="新しいパスワードを入力してください。" class="form-control new-password" v-model="password">
                                                <div class="error error-display" id="newpassword">新しいパスワードが必要です。</div>
                                                <div class="error error-display" id="newpasswordlength">パスワードは6桁以上にしてください。</div>
                                                <br>
                                                <label class="old-pass">新しいパスワードをもう一度入力してください</label>
                                                <input type="password" name="comfirm_password" class="form-control confirm-password" placeholder="新しいパスワードをもう一度入力してください" v-model="password_confirmation" @keyup="password_validate()">
                                                <div class="error error-display" id="confirmpassword">新しいパスワードをもう一度入力が必要です。</div>
                                                <div class="col-md-12 pad-free">
                                                    <span v-if="errors.password" class="error">{{errors.password}}</span>
                                                </div>
                                                <br>
                                                <div>
                                                    <span class="btn main-bg-color white all-btn"  @click="passwordChange()">変更</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--card-->
                            <!--card-->
                            <div class="card card-default m-b-20 col-md-11">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-12 m-t-8">
                                            <div class="header2">
                                                <h5 class=" clearfix">メールアドレスと運営事業者名設定</h5>
                                            </div>
                                            <div class="form-group">
                                                <label class="old-pass">運営事業者名</label>
                                                <input type="text" name="name" v-model="customer_info.name"  class="form-control old-password">
                                            </div>
                                            <div class="form-group">
                                                <label class="email-address">メールアドレス</label>
                                                <input type="text" class="form-control email" v-model="customer_info.email">
                                            </div>
                                            <div class="form-group">
                                                <span class="btn main-bg-color white all-btn"  @click="emailChange()">
                                                変更
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>                        
                            <div class="card card-default m-b-20 col-md-11" v-if="$auth.check(2)">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-12 m-t-8">
                                            <div class="header2">
                                                <h5 class="clearfix">事業者登録の有効/無効</h5>                                               
                                            </div>
                                            <div class="form-group">                                                
                                                <span :class="customer_info.recordstatus ==1?btnred:btnsuccess" class="btn all-btn" @click="AccountStatusChange(customer_info.recordstatus)">
                                                    {{accout_status}}
                                                </span>
                                                &nbsp;&nbsp;
                                                <span class="acc-status acc-status-color">{{accout_status2}}</span>
                                            </div>   
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--card-->
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!--test-->
    </div>
</template>

<script>
    export default {
        data() {
            return {
                derecordstatus: 1,
                btnred: 'bt-red',
                btnsuccess: 'bt-suc',
                customer_info: [],
                type: this.$route.params.type,
                logo: '',
                cusid: this.$route.params.id,
                upload_img: null,
                image: '',
                accout_status:'',
                accout_status2:'',
                name:'',
                password: '',
                password_confirmation: '',
                old_password: '',
                errors: {
                    password: "" ,
                    name:"",
                    city:'',
                    township:''
                },
                city_list:[],
                town_list:[],
                nursing_data:{
                    name:'',
                    city_id:'',
                    town_id:'',  
                }
            }
        },
        created() {                
            this.nursing_data.city_id = 0;
            this.nursing_data.town_id= 0;
            this.axios.get('/api/hospital/citiesList')
            .then(response => {
                this.city_list = response.data;                  
            });
            this.axios
                .get('/api/customerinfo/' + this.cusid)
                .then(response => {
                    this.customer_info = response.data;
                    this.derecordstatus = this.customer_info.recordstatus;
                    if(this.customer_info.recordstatus == '1') {
                        this.accout_status = '無効にする';
                        this.accout_status2 = '現在有効';
                    } else {
                        this.accout_status = '有効にする';
                        this.accout_status2 = '現在無効';
                    }
                    if (this.customer_info.type_id == '2') {
                        this.logo = '/upload/hospital_profile/' + response.data.logo;
                    } else {
                        this.logo = '/upload/nursing_profile/' + response.data.logo;
                    }
                });
        },
        methods: {
            Save(){
                document.getElementById('newcreate').style.display = "none";
                document.getElementById('nusNew').style.display = "block";
            },                
            imgUrlAlt(event) {
                event.target.src = "/images/noimage.jpg"
            },
            preview_image(fileInput) {
                this.logo = URL.createObjectURL(event.target.files[0]);
            },
            profileChange() {
                var file = document.getElementsByClassName('customer-logo')[0].files[0];
                if (file) {
                    var file_name = file.name;
                    let fd = new FormData();
                    fd.append('file', file)
                    fd.append('photo', file_name)
                    this.axios.post('/api/user/movephoto', fd)
                        .then(response => {}).catch(error => {
                            console.log(error);
                            if (error.response.status == 422) {
                                this.errors = error.response.data.errors
                            }
                        })
                    let arr = new FormData();
                    arr.append('logo', file_name)
                    this.$swal({
                        title: "確認",
                        text: "お客様のロゴを変更しましたか？",
                        type: "info",
                        width: 350,
                        height: 200,
                        showCancelButton: true,
                        confirmButtonColor: "#6cb2eb",
                        cancelButtonColor: "#b1abab",
                        cancelButtonTextColor: "#000",
                        confirmButtonText: "作成",
                        cancelButtonText: "キャンセル",
                        confirmButtonClass: "all-btn",
                        cancelButtonClass: "all-btn",
                        allowOutsideClick: false,
                    }).then(response => {
                        this.axios
                            .post(`/api/customer/update/${this.cusid}`, arr)
                            .then((response) => {
                                this.$swal({
                                        position: 'top-end',
                                        type: 'success',
                                        text: '更新されました',
                                        confirmButtonText: "閉じる",
                                        confirmButtonColor: "#6cb2eb",
                                        width: 350,
                                        height: 200,
                                        allowOutsideClick: false,
                                    })
                                    // alert('Logo is Successfully Updated!');
                            }).catch(error => {
                                if (error.response.status == 422) {
                                    this.errors = error.response.data.errors
                                }
                            });
                    });
                }
            },
            passwordChange() {                       
                if (this.old_password == '') {
                    $('#oldpassword').css('display', 'block');
                    return;
                }
                if (this.password == '') {
                    $('#newpassword').css('display', 'block');
                    return;
                }
                if (this.password.length < 6) {
                    $('#newpasswordlength').css('display', 'block');
                    return;
                }
                if (this.password_confirmation == '') {
                    $('#confirmpassword').css('display', 'block');
                    return;
                }
                if ("'" + this.password + "'" === "'" + this.password_confirmation + "'") {
                    let arr = new FormData();                            
                    arr.append('old_pass', this.old_password)
                    arr.append('new_pass', this.password)
                    arr.append('cus_id', this.cusid)
                    this.axios
                        .post(`/api/user/password-change`, arr)
                        .then((response) => {
                            if (response.data == 'oldpasswordwrong') {
                                this.$swal({
                                    position: 'top-end',
                                    type: 'error',
                                    text: '現在のパスワードに誤りがあります。',
                                    confirmButtonText: "閉じる",
                                    confirmButtonColor: "#FF5462 ",
                                    width: 350,
                                    height: 200,
                                    allowOutsideClick: false,
                                })
                                return;                                        
                            }else{
                                this.$swal({
                                    position: 'top-end',
                                    type: 'success',
                                    text: 'パスワードを変更しました。',
                                    confirmButtonText: "閉じる",
                                    confirmButtonColor: "#31cd38",
                                    width: 350,
                                    height: 200,
                                    allowOutsideClick: false,
                                })
                                this.name = null;
                                this.password = null;
                                this.password_confirmation = null;
                                this.old_password = null;                                           
                            }
                            // alert('Password is Successfully Changed!');
                        }).catch(error => {
                            if (error.response.status == 422) {
                                this.errors = error.response.data.errors
                            }
                        });
                } else {
                    this.$swal({
                            // title: "確認",
                            text: "新しいパスワードと確認パスワードは同じでなければなりません。",
                            type: "warning",
                            width: 350,
                            height: 200,
                            showCancelButton: true,
                            confirmButtonColor: "#eea025",
                            cancelButtonColor: "#b1abab",
                            cancelButtonTextColor: "#000",
                            confirmButtonText: "閉じる",
                            // cancelButtonText: "キャンセル",
                            confirmButtonClass: "all-btn",
                            allowOutsideClick: false,
                            // cancelButtonClass: "all-btn"
                        })
                        // alert('New-Password And Confirm-Password must be same!')
                }
            },
            emailChange(id) {
                var email = $('.email').val();
                let arr = new FormData();
                arr.append('name', this.customer_info.name)
                arr.append('email', email)
                arr.append('cus_id', this.cusid)
                this.$swal({
                    // title: "確認",
                    text: "メールアドレスと運営事業者名を変更してよろしいでしょうか。",
                    // text: "メールアドレスを変更してよろしいでしょうか。",
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
                }).then(response => {
                    this.axios
                        .post(`/api/user/email-change`, arr)
                        .then(response => {
                            this.customer_info = response.data;
                            this.name = ''
                            this.$swal({
                                    position: 'top-end',
                                    type: 'success',
                                    text: 'メールアドレスと運営事業者名を変更しました。',
                                    confirmButtonText: "閉じる",
                                    confirmButtonColor: "#31cd38",
                                    width: 350,
                                    height: 200,
                                    allowOutsideClick: false,
                                })
                                // setTimeout(function(){
                                //     location.reload();
                                // },2000)
                                // alert('Email is Successfully Changed!');
                        }).catch(error => {
                            if (error.response.status == 422) {
                                this.errors = error.response.data.errors
                            }
                        });
                })
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
            },
            changeTownship(){
                this.errors.township = '';
            },
            AccountStatusChange(status) {
                if(status == '1') {
                    var confirm_text = '事業者登録を無効にしますか。';
                } else {
                    var confirm_text = '事業者登録を有効にしますか。';
                }
                let fd = new FormData();
                    fd.append('status', status)
                    fd.append('cus_id',this.cusid)
                this.$swal({
                    // title: "確認",
                    text: confirm_text,
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
                    }).then(response => {
                        this.axios
                            .post('api/customer/account_update', fd)
                            .then((response) => {
                                this.customer_info = response.data;                                       
                                if(this.customer_info.recordstatus == '1') {
                                    this.accout_status = '無効にする';
                                    this.accout_status2 = '現在有効';
                                        this.$swal({
                                        position: 'top-end',
                                        type: 'success',
                                        text: '事業者登録を有効にしました。',
                                        confirmButtonText: "閉じる",
                                        confirmButtonColor: "#31cd38",
                                        width: 350,
                                        height: 200,
                                        allowOutsideClick: false,
                                    }).then(response => {
                                        if(this.$auth.user().role != 2){
                                            location.reload();
                                        }                                                
                                    });
                                } else {
                                    this.accout_status = '有効にする';
                                    this.accout_status2 = '現在無効';
                                        this.$swal({
                                        position: 'top-end',
                                        type: 'success',
                                        text: '事業者登録を無効にしました。',
                                        confirmButtonText: "閉じる",
                                        confirmButtonColor: "#31cd38",
                                        width: 350,
                                        height: 200,
                                        allowOutsideClick: false,
                                    }).then(response => {
                                        if(this.$auth.user().role != 2){
                                            location.reload();
                                        }  
                                    });
                                }                                        
                                if (this.customer_info.type_id == '2') {
                                    this.logo = '/upload/hospital_profile/' + response.data.logo;
                                } else {
                                    this.logo = '/upload/nursing_profile/' + response.data.logo;
                                }
                            }).catch(error => {
                                if (error.response.status == 422) {
                                    this.errors = error.response.data.errors
                                }
                            });
                    });
            },
            password_validate() {
                window.pwd_same = false;
                var nursing_type_exist = false;
                if(this.password != this.password_confirmation) {
                    this.errors.password = "※パスワードが一致しません。";
                }
                else {
                    this.errors.password = null;
                    window.pwd_same = true;
                }
            },
        }
    }
</script>

<style>
.color-clearfix {
    color:#2980B9 !important;
    font-weight:bold !important;
}
.error-display {
    display: none !important;
}
.acc-status-color {
    color:#346e90 !important;
}
</style>
<template>
    <div id="register" class="loginwrapper">
        <div class="login_content">
            <div class="logo_wrap">
                <div class="brand_logo_container logo_bk">
                    <img src="/images/login.png" class="brand_logo" alt="介護医療福祉の総合サイト[TIS ティーズ]">
                    <div id="preview">
                        <img v-if="url" :src="url" class="brand_logo" alt="介護医療福祉の総合サイト[TIS ティーズ]">
                    </div>
                </div>
            </div>
            <div class="user_card user_registercard">
                <div class="login_link">
                    <a href="/" class="home_link">ホーム</a>
                    <router-link to="/login" class="ml-auto text">ログイン</router-link>    
                </div>
                <div class="form_content">
                    <div class="reg_title">事業者新規登録</div>
                    <form autocomplete="off" @submit.prevent="register" v-if="!success" method="post" class="registerformwrapper">                       
                        <div class="form-group row">
                            <label class="col-12 col-lg-3 col-md-4 control-label">事業者名</label>
                            <div class="col-12 col-lg-9 col-md-8  p-0">
                                <div class="input-group">
                                    <div class="input-group-append">
                                        <span class="input-group-text"><i class="fas fa-user"></i></span>
                                    </div>
                                    <input type="text" autocomplete="off" class="form-control" name="name" v-model="username"  placeholder="事業者名を入力してください。" @keyup="focusName">
                                    <span v-if="errors.username" class="error">{{errors.username}}</span>
                                </div>
                            </div>
                        </div>
                        <div  class="form-group row">                           
                            <label class="col-12 col-lg-3 col-md-4 control-label">メールアドレス </label>
                            <div class="col-12 col-lg-9 col-md-8  p-0">
                                <div class="input-group">
                                    <div class="input-group-append">
                                        <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                    </div>
                                    <input type="text" autocomplete="off" class="form-control" name="email" v-model="email"  placeholder="メールアドレスを入力してください。"  @keyup="focusMail"> 
                                    <span v-if="errors.email" class="error">{{errors.email}}</span>
                                </div>
                            </div>
                        </div>
                        <div  class="form-group row">
                            <label class="col-12 col-lg-3 col-md-4 control-label">パスワード </label>
                            <div class="col-12 col-lg-9 col-md-8  p-0">
                                <div class="input-group">
                                    <div class="input-group-append">
                                        <span class="input-group-text"><i class="fas fa-key"></i></span>
                                    </div>
                                    <input type="password" autocomplete="off" class="form-control" name="password" @keyup="password_validate()" v-model="password" id="pwd"  placeholder="パスワードを入力してください。">
                                    <span v-if="errors.password" class="error">{{errors.password}}</span>
                                </div>
                            </div>
                         </div>
                         <div  class="form-group row">
                            <label class="col-12 col-lg-3 col-md-4 control-label">パスワード確認</label>
                            <div class="col-12 col-lg-9 col-md-8  p-0">
                                <div class="input-group">
                                    <div class="input-group-append">
                                        <span class="input-group-text"><i class="fas fa-key"></i></span>
                                    </div>
                                    <input type="password" autocomplete="off" class="form-control" name="comfirm_password" id="confirm_pwd" @keyup="password_validate()" v-model="password_confirmation"  placeholder="パスワードをもう一度入カしてください。">
                                    <span v-if="errors.password" class="error">{{errors.password}}</span>
                                </div>
                            </div>
                        </div>
                        <div  class="form-group row">
                            <label class="col-12 col-lg-3 col-md-4 control-label">事業者タイプ</label>
                            <div class="col-12 col-lg-9 col-md-8  p-0">
                                <div class="input-group">
                                    <div class="input-group-append">
                                        <span class="input-group-text"><i class="fas fa-list"></i></span>
                                    </div>
                                    <select id="type" class="form-control custom-select" name="types" :value="type.id" v-model="type" @change="focusType" >
                                        <option value="">事業者のタイプを選択してください(介護又は病院)</option>
                                        <option value="3">介護</option>
                                        <option value="2">病院</option>
                                    </select>
                                    <span v-if="errors.type" class="error">{{errors.type}}</span>
                                </div>
                            </div>
                        </div>
                        <div class="input-group hide form-check form-check-inline" id="showHideActionNursing">
                            <label class="col-12 col-lg-3 col-md-4 control-label">看護種類</label>
                            <div class="input-group-append " id="nursing">
                            </div>
                            <div class="error register-err-margin" id="radioerror">必須</div>
                        </div>
                        
                        <div class="form-group row">
                            <label class="col-12 col-lg-3 col-md-4 control-label">電話番号</label>
                            <div class="col-12 col-lg-9 col-md-8  p-0">
                                <span class="color-999">※ 数字のみ </span>
                                <div class="input-group">
                                    <div class="input-group-append">
                                        <span class="input-group-text"><i class="fas fa-phone-alt"></i></span>
                                    </div>
                                    <input class="form-control" id="phone" name="phone"  v-model="phone"  placeholder="電話番号を入力してください。" @keyup="focusPhone" maxlength="13">
                                    <span class="error" v-if="errors.ph_length">{{errors.ph_length}}</span>
                                    <span class="error" v-if="errors.ph_num">{{errors.ph_num}}</span>
                                </div>
                            </div>
                        </div>
                        <!-- 契約書 追加 -->
                        <div class="form-group col-12 text-center">
                            <a href="/contract" v-on:click="changeContractStatus()" class="btn register_btn login_btn" target="_blank">契約書</a>
                        </div>
                        <div class="contract-group">
                            <div class="contract-label">
                                <span class="contract-checkbox">
                                    <input type="checkbox" value=1 v-model="contract_chk" @change="check($event)" :disabled="contract_status == 0">
                                    本システムを使用するにあたり、上記契約書に同意する
                                </span>
                                <span v-if="errors.contract_chk" class="contract-error">{{errors.contract_chk}}</span>
                            </div>
                            <div class="contract-btn">
                                <button type="submit" class="disable_btn" :disabled="contract_status == 0">登録</button>
                            </div>
                        </div>
                        <!-- 契約書 追加 -->
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    data() {
        return {
            contract_status:0,
            contract_chk:[],
            disable_color:'#999',
            images:'',
            img_name:'',
            username: '',
            email: '',
            //cities: [],
            //city : '',
            //townships :[],
            //township :'',
            type:'',
            typ:[],
            types:[],
            phone:'',
            address:'',
            password: '',
            password_confirmation: '',
            passerr: false,
            has_error: false,
            correctVal: null,
            tempVal: null,
            error: '',
            errors: {
                img:"",
                name:"",
                email:"",
                password:"",
                username:"",
                type:'',
                ph_length:'',
                ph_num:'',
                //cities:"",
                //township:""
            },
            success: false,
            show: true,
            url: '',
            ph_length:'',
            ph_num:'',
            arr:[],
            Numbers:[],
            mail_reg:  /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,24}))$/,
            phone_reg: /^([0-9]*)$/
        }
    },

    methods: {
        changeContractStatus(){
            this.contract_status = 1;
            this.disable_color = '#2C3E50';
        },
        check(){
            if(this.contract_chk != '')
            {
                this.errors.contract_chk = ''
            }
        },
        getType(){
            this.axios.get('/api/auth/getTypes',{
                params:{
                type:this.type
                },
            }).then((response)=>{
                this.types = response.data.types

            })
        },
        password_validate() {
            // var pwd = $('#pwd').val();
            // var confirm_pwd = $('#confirm_pwd').val();
            window.pwd_same = false;
            var nursing_type_exist = false;
            if(this.password != this.password_confirmation) {
                // this.passerr = true;
                this.errors.password = "※パスワードが一致しません。";
                // $('#passworderror').css("display","block");
            }
            else {
                // $('#passworderror').css("display","none");
                // this.passerr = false;
                this.errors.password = null;
                window.pwd_same = true;
            }
        },
        focusName:function(event)
        {
            if(this.username != null || this.username != '')
            {
                this.errors.username = ''
            }
        },
        focusType:function(event)
        {
            if(this.type != '')
            {
                this.errors.type = ''
            }
        },
        focusMail: function(event) {
            if((this.email != '' && this.mail_reg.test(this.email))){
                this.errors.email='';
            }else{
                this.errors.email ='※メールアドレスが正しくありません。もう一度入力してください。';
            }
        },
        register() {
            if(this.type == '')
            {
                this.errors.type = "事業者タイプを選択してください。";
            }
            else{
                this.errors.type = '';
            }

            if(this.username == null || this.username == '')
            {
                this.errors.username = "事業者名が必須です。";
            }
            else
            {
                this.errors.username = "";
            }

            if(this.email == null || this.email == '')
            {
                this.errors.email = "メールアドレスが必須です。";
            }
            else
            {
                this.errors.email = "";
            }

            if(this.password_confirmation == null || this.password_confirmation == '' || this.password == null || this.password == '')
            {
                this.errors.password = "パスワードが必須です。";
            }
            else{
                this.errors.password = '';
            }

            if((this.email != '' && this.mail_reg.test(this.email))){      
                this.errors.email='';
            }else{
                
                this.errors.email ='※メールアドレスが必須です。';
            }
       
            if(this.phone != '' && this.phone != null)
            {
                this.errors.ph_num = '';
            }
            else{
                this.errors.ph_num = '※電話番号が必須です。';
            }

            if(this.contract_chk == '')
            {
                this.errors.contract_chk = "入力されていません。";
            }
            else{
                this.errors.contract_chk = '';
            }

            if(this.phone != '' && (this.phone_reg).test(this.phone) && (this.phone.length >= 10 && this.phone.length <= 13))
            {
                this.errors.ph_length = '';
            }
            else{
                this.errors.ph_length = '※電話番号を確認してください。';
            }
            if(this.errors.email == '' && this.errors.username == '' && this.errors.password == '' && this.errors.type == '' &&  this.errors.ph_length == '' && this.errors.ph_num == '' && this.errors.contract_chk == '')
            {
                var app = this
                let fData = new FormData();
                //fData.append('img', app.images)
                fData.append('name', app.username)
                fData.append('email', app.email)
                fData.append('password', app.password)
                fData.append('comfirm_password', app.password_confirmation)
                //fData.append('cities', app.city)
                //fData.append('township', app.township)
                fData.append('types', app.type)
                fData.append('phone', app.phone)
                var seltype = app.type == 2 ? '病院': '介護';
                
                this.$swal({
                    title: 'この内容で登録しますか。',  
                    // html: "事業者名:"+app.username+"<br/>メールアドレス:"+app.email+"<br/>事業者タイプ:"+seltype+"<br/>電話番号:"+app.phone, 
                    html:"<table style='margin:auto;'><tr><td class='tl'>事業者名</td><td class='tl'>: "+app.username+"</td></tr><tr class='tl'><td class='tl'>メールアドレス</td><td class='tl'>: "+app.email+"</td></tr><tr class='tl'><td class='tl'>事業者タイプ</td><td class='tl'>: "+seltype+"</td></tr><tr class='tl'><td class='tl'>電話番号</td><td class='tl'>: "+app.phone+"</td></tr></table>",             
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: "#EEA025",
                    confirmButtonText: 'はい',
                    cancelButtonText: 'キャンセル',
                    showCloseButton: true,
                    showLoaderOnConfirm: true,
                    allowOutsideClick: false,
                    }).then((result) => {
                        if(result) {
                            this.$loading(true);
                            this.axios.post('/api/register', fData).then(response => {
                                this.$loading(false);
                                this.$swal({
                                    position: 'top-end',
                                    type: 'success',
                                    title: '<p style="font-weight:bold;">サイト管理者に登録情報を通知いたしました</p>',
                                    html: "<p style='text-align:left;'>登録審査後、事業者様にメールにてお知らせいたします。しばらくおまちください。</p>",
                                    width: 350,
                                    height: 200,
                                    confirmButtonColor: "#31CD38",
                                    confirmButtonText: "閉じる",
                                    confirmButtonClass: "all-btn",
                                    allowOutsideClick: false,
                                })
                                this.$router.push({
                                    name: 'News'
                                });
                            }).catch(error => {
                                this.$loading(false);
                                if(error.response.status == 422){
                                    this.errors = error.response.data.errors;
                                    if(this.errors.email)
                                    {
                                        this.errors.email = "このメールアドレスは既に存在します。";
                                    }
                                    else{
                                        this.errors.email = "";
                                    }
                                    if(this.errors.password)
                                    {
                                        this.errors.password = "パスワードは6桁以上必要です。"
                                    }
                                    else{
                                        this.errors.password = "";
                                    }
                                }
                            })                        
                    } 
                })
                // .catch(error =>{

                //         this.$swal('Cancelled', 'Your file is still intact', 'info')
                //     });
            }
        },
        focusPhone: function(e) {
            if(this.phone != '')
            {
                this.errors.ph_num = '';
            }
            if(this.phone != '' && (this.phone_reg).test(this.phone) && (this.phone.length >= 10 && this.phone.length <= 13))
            {
                this.errors.ph_length = '';
            }
            else{
                this.errors.ph_length = '※電話番号を確認してください。';
            }
            if(this.phone == '' || this.phone == null)
            {
                this.errors.ph_length = '';
            }
        },    
    },

  }
</script>

<style>
.img{
    opacity: 1;
    transition: 0.5s;
    width:200px;
    height:200px;
}
.tl{
    text-align: left;
}
.register-err-margin {
    margin-bottom: 6px;
    margin-left: 210px;
}
.color-999 {
    color:#999;
}
/*  契約書 追加  */
.contract-group {
    float: right;
}
.contract-label {
    display: inline-block;
}
.contract-btn {
    float: right;
}
.contract-error {
    color: #ff0000;
    font-size: 16px;
    border: 1px solid;
    width: 100%;
    display: inline-block;
    line-height: 0.8;
    padding: 2px 5px;
}
.contract-checkbox::after {
    content: '\A';
    white-space: pre;
}
.disable_btn:disabled {
    background: #999 !important;
}
.disable_btn {
    background: #2980B9 !important;
    color:  #F5F5F5!important;
    font-weight: bold;
    font-size: 16px;
    border-radius: 0.25rem;
    border-color: transparent;
    margin-left: 5em;
}
 /* 契約書 追加  */
</style>

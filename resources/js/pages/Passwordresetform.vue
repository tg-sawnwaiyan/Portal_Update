<template>
<div>
   <div id="psd_reset_form" class="loginwrapper" v-if="!has_success">
       <div class="login_content" >
           <div class="logo_wrap">
                <div class="brand_logo_container logo_bk">
                    <img src="/images/login.png" class="brand_logo" alt="介護医療福祉の総合サイト[TIS ティーズ] ">
                </div>
            </div>
            <div class="user_card" id="altrole">
                <div class="login_link">
                    <a href="/" class="home_link">ホーム</a>
                </div>
                <div class="form_content">
                    <form autocomplete="off" @submit.prevent="resetPass" method="post">
                        <div class="mb-3 position-relative">
                            <div class="input-group">
                                <div class="input-group-append">
                                    <span class="input-group-text"><i class="fas fa-key"></i></span>
                                </div>
                                <input type="password" class="form-control input_user" id="password" @keyup="password_validate()" name="password" value="" v-model="password"  autofocus placeholder="新しいパスワード">
                                <span class="invalid-feedback" role="alert">
                                    <strong></strong>
                                </span>
                            </div>
                            <span v-if="errors.password" class="error"><small>{{errors.password}}</small></span>
                        </div>
                        <div class="mb-3 position-relative">
                            <div class="input-group">
                                <div class="input-group-append">
                                    <span class="input-group-text"><i class="fas fa-key"></i></span>
                                </div>
                                <input type="password" class="form-control input_user" id="confirm_pass" @keyup="password_validate()" name="confirm_pass" value="" v-model="confirm_pass"  autofocus placeholder="もう一度入力してください。">
                                <span class="invalid-feedback" role="alert">
                                    <strong></strong>
                                </span>                                
                            </div>
                            <span v-if="errors.confirmPassword" class="error"><small>{{errors.confirmPassword}}</small></span>
                        </div>
                        <div class="d-flex justify-content-center mt-3">
                            <button type="submit" name="button" id="changePass" class="btn login_btn" :disabled="is_disabled">変更</button>
                        </div>     
                    </form>                   
                </div>       
            </div>
       </div>      
   </div>
    <div v-else class="container-fluid successful-resetpwd">   
        <div class="resetpwd-img">
            <img src="/images/login.png" class="" alt="介護医療福祉の総合サイト[TIS ティーズ] "> 
        </div>       
        <div>            
            <p class="data-success">{{error_text}}</p>   
            <div class="form-group col-12 text-center">
                <a href="/" class="btn register_btn login_btn all-btn">ホーム</a>  
            </div>
        </div>                    
    </div>
</div>
</template>
<script>
export default {
    data() {
        return {
            password: null,
            confirm_pass: null,
            has_error: false,
            has_success: false,
            is_disabled: false,
            errors:{
                password:'',
                confirmPassword:''
            },
            error_texts:'',
            toke_expire:false
        }
    },
    mounted() {
      //
    },
    created() {
        this.axios.get(`/api/getStatus/${this.$route.query.code}`).then(res => {
            if(res.data.status == 2){
                this.has_success = true;
                this.error_text = "このパスワード再設定用URLは無効です。";
            }else{
                this.has_success = false;
            }
        })
    },
    methods: {
        resetPass() {
            if(this.password == '' || this.password == null)
            {
                this.errors.password = "パスワードが必須です。";
            }
            else{
                this.errors.password = '';
            }
             if(this.confirm_pass == '' || this.confirm_pass == null)
            {
                this.errors.confirmPassword = "パスワードが必須です。";
            }
            else{
                this.errors.confirmPassword = '';
            }
            if(this.password.length < 6 || this.confirm_pass.length < 6)
            {
                this.has_error = true;
                this.error_text = "Password must be greater than 6 ";
            }
            else{
                this.error_text = '';
            }

            if(this.errors.password == '' && this.errors.confirmPassword == '' && this.error_text == '')
            {
                this.$loading(true);
                // get the redirect object
                var fData = new FormData();
                fData.append('password', this.password);
                fData.append('token', this.$route.query.code);
                this.axios.post('/api/resetpassword',fData) 
                .then(response => {
                    this.$loading(false);
                    if(response.data == "success"){
                        this.has_success = true;
                        this.error_text = "パスワードの再設定が完了しました。";
                    }
                    else{
                        this.has_success = true;
                        this.error_text = "このパスワード再設定用URLま無効です。";                         
                    }
                })
            }
            
        },
        password_validate() {
            if(this.password == '' || this.password == null)
            {
                this.errors.password = "パスワードが必須です。";
            }
            else{
                this.errors.password = '';
            }
             if(this.confirm_pass == '' || this.confirm_pass == null)
            {
                this.errors.confirmPassword = "パスワードが必須です。";
            }
            else{
                this.errors.confirmPassword = '';
            }
            if(($('#password').val() != $('#confirm_pass').val()) ) {
                this.has_error = true;
                this.error_text = "※パスワードが一致しません。 ";
                this.is_disabled = true;
                $("#changePass").css('cursor','not-allowed')
            }
            else {
                this.has_error = false;
                this.is_disabled = false;
                $("#changePass").css('cursor','pointer')
            }
        },
    }
}
</script>
<style scoped>
.d-flex .alert-danger{
    width:90%;
    top:200px;
}
</style>
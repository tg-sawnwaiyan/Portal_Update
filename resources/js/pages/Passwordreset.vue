<template>
  <div class="loginwrapper" id="psd_reset">
    <div class="login_content">
      <div class="logo_wrap">
        <div class="brand_logo_container logo_bk">
          <img src="/images/login.png" class="brand_logo" alt="介護医療福祉の総合サイト[TIS ティーズ] ">
        </div>
      </div>
      <div class="user_card">
        <div class="login_link">
          <a href="/" class="home_link">ホーム</a>
        </div>
        <form class="reset_form" autocomplete="off" @submit.prevent="resetPass" method="post">
          <h3 for="" class="user_name h3-margin">事業者パスワード再設定</h3>
          <div class="mb-4  reset">
            <div class="input-group">
              <div class="input-group-append">
                <span class="input-group-text"><i class="fas fa-envelope"></i></span>
              </div>
              <input type="text" class="form-control input_user" id="email" name="email" value="" v-model="email" @keyup="focusMail" autofocus placeholder="メールアドレス">
              <span class="invalid-feedback" role="alert">
                <strong></strong>
              </span>   
            </div>
            <span v-if="errors.email" class="error"><small>{{errors.email}}</small></span>
          </div>                   
          <div class="d-flex justify-content-center mt-3">
            <button type="submit" name="button" id="getUser" class="btn login_btn">送信</button>
          </div>
        </form>
        <p class="reset_txt">
          ※ ユーザ名(メールアドレス)を入力してください。<br/>
          ※ メールアドレス宛にパスワード再設定用のリンクをお送りします。
        </p>
      </div>
    </div>
  </div>
</template>
<script>
  export default {
    data() {
      return {
        errors:{
          email:'',
        },
        email: null,
        has_error: false,
        mail_reg: /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,24}))$/
      }
    },
    mounted() {
      //
    },
    methods: {
      focusMail: function(event) {
        if((this.email != '' && this.mail_reg.test(this.email))){        
          this.errors.email='';
        }else{        
          this.errors.email ='※メールアドレスが正しくありません。もう一度入力してください。';         
        }    
      },
      resetPass() {
        if(this.email == '' || this.email == null)
        {
          this.errors.email = "メールアドレスが必須です。";
        }
        else{
          this.errors.email = '';
        }

        if((this.email != '' && this.mail_reg.test(this.email))){        
            this.errors.email='';
        }else{        
            this.errors.email ='※メールアドレスを入力してください。';         
            // this.errors.email ='※メールアドレスが必須です。';         
        }
        if(this.errors.email == '')
        {
          this.$loading(true);
          var fData = new FormData();
          fData.append('email', this.email);
          this.axios.post('/api/reset',fData) 
          .then(response => {
            this.$loading(false);
              this.$swal({       
                text: "ご登録のメールアドレスにパスワード変更用のURLを送付しました。",
                type: "success",
                width: 400,
                height: 200,                        
                confirmButtonColor: "#31CD38",                         
                confirmButtonText: "閉じる",
                confirmButtonClass: "all-btn",
                allowOutsideClick: false,
              }).then(response => { 
                this.$router.push({name: 'login'});
              });
          }).catch(error=>{
            this.$loading(false);  
            if(error.response.status == 404){
              this.$swal({
                html: "このメールアドレスは存在しません。<br/>ご確認の上、もう一度お試しください。",
                type: "error",
                width: 350,
                height: 200,                        
                confirmButtonColor: "#FF5462",                         
                confirmButtonText: "閉じる",
                confirmButtonClass: "all-btn",
                allowOutsideClick: false,      
              })
            }
          });
        }
      
      }
    }
  }
</script>

<style>
.h3-margin {
  margin: 0px 0px 30px 0px;
}
</style>
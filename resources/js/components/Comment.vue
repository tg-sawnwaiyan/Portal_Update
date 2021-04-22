<template>
 <div class="">     
      <div class="col-12 col-lg-12 col-md-12 tab" >       
          <div class="card title_comment title_comment2 margin-none" style="background:#edf2f4;">     
                       <div class="col-12 m-b-10 m-t-8 com-mt"><h4 class="comment-apply-color t-t" style="margin-left:5px;"><i class="fa fa-comments com_ic"></i> 口コミ投稿</h4></div>
                    <div class="card-body ">
                        <div class="row">
                            <div class="col-sm-12 col-md-12 register_box" v-if="type == 'register'">
                                <ul class="multi-step">
                                    <li class="active">1.<span>必要事項のご</span>入力</li>
                                    <li class="no-active">2.<span>内容のご</span>確認</li>
                                    <li>3.<span>送信</span>完了</li>
                                </ul>
                                <form  class="m-t-16 sendEmail comform comment" autocomplete="off">
                                        <div class="form-group row">
                                            <div class="col-sm-4 text-left">
                                                <label for ="title"  ><strong> 口コミタイトル &nbsp;<span class="error sp1">必須</span></strong>   </label>
                                            </div>
                                             <div class="col-sm-8">
                                                <input type="title"  class="form-control box " id="title"  name="title" v-model="comments.title">
                                                <div v-if="errors.title" style="color:red;">{{ errors.title }}</div>
                                             </div>
                                        </div>
                                         
                                          <div class="form-group row">
                                                <div class="col-sm-4 text-left">
                                                        <label for ="email" ><strong> メールアドレス（半角英数字）&nbsp;<span class="error sp1">必須</span></strong>  </label>
                                                </div>
                                                <div class="col-sm-8">
                                                      <input type="email"  class="form-control box " id="email"  name="email" v-model="comments.email">
                                                      <div v-if="errors.email" style="color:red;">{{ errors.email }}</div>
                                                </div>
                                        </div>
                                        
                                         <div class="form-group row">
                                            <div class="col-sm-4 text-left">
                                                <label for ="name"  ><strong> お名前&nbsp;<span class="error sp1">必須</span></strong>   </label>
                                            </div>
                                             <div class="col-sm-8">
                                                <input type="name" class="form-control box " id="name"  name="name" v-model="comments.name">
                                                 <div v-if="errors.name" style="color:red;">{{ errors.name }}</div>
                                             </div>
                                        </div>
                                         <div class="form-group row">
                                            <div class="col-sm-4 text-left">
                                                <label for ="year"  ><strong> 生まれた年</strong>   </label>
                                            </div>
                                             <div class="col-sm-8">
                                                <select id="dob" class="form-control"  v-model="selectedValue" @change="getYear()">
                                                    <option value="0">選択してください</option>
                                                    <option v-for="year in years" :key="year.id"  :value="year">{{ year }}</option>
                                                </select>
                                             </div>
                                        </div>
                                       
                                         <div class="form-group row"  v-for="field in comments.fields" :key="field.id">
                                            <div class="col-sm-4">
                                                <label for ="zipcode"  ><strong> 郵便番号(半角数字)</strong>   </label>
                                            </div>
                                             <div class="col-sm-5">
                                                 <input type="text" class="form-control box fnumericzip" value="firstzip" v-model="field.fzipcode" maxlength="7" v-on:keydown="isNumber">
                                              <span v-if="errors.fzipcode" class="error">{{errors.fzipcode[0]}}</span>
                                             </div>
                                             <div class="col-sm-3">
                                                 <label> 例）1006740 (<a href="https://www.post.japanpost.jp/zipcode/" target="_blank" class="pseudolink">郵便番号検索</a>)</label>
                                             </div>                                             
                                        </div>
                                          <div class="form-group row">
                                                <div class="col-sm-4 text-left">
                                                        <label for ="comment" ><strong> 口コミ内容&nbsp;<span class="error sp1">必須</span></strong>  </label>
                                                </div>
                                                <div class="col-sm-8">
                                                    <textarea name="comment" id="comment" class="form-control" cols="50" rows="5" v-model="comments.comment"></textarea>
                                                     <div v-if="errors.comment" style="color:red;">{{ errors.comment }}</div>
                                                </div>
                                        </div>                                        
                                        <div class="form-group row">
                                                <div class="col-sm-4">
                                                </div>
                                                <div class="col-sm-8">
                                                     <span v-if="errors.fields" class="error">{{errors.fields}}</span>
                                                </div>
                                         </div>
                                        <div class="form-group row">
                                            <div class="col-sm-5"></div>
                                            <div class="col-sm-4">
                                             
                                              <router-link to="/privacyPolicy" class="pseudolink"> <strong>「プライバシーポリシー」</strong></router-link>
                                            </div>
                                            <div class="col-sm-3"></div>
                                        </div>

                                        <div class="form-group row">                                            
                                            <div class="col-sm-12 text-center">
                                                <span class="btn btn-danger all-btn" @click="$router.go(-1)" > キャンセル </span>
                                                <span class="btn main-bg-color white all-btn" @click="checkValidate()">確認画面へ進む</span>
                                               
                                            </div>                                            
                                        </div>
                                </form>
                            </div>
                            <div class="col-sm-12 col-md-12" v-if="type == 'confirm'">
                                <ul class="multi-step">
                                    <li class="active">1.<span>必要事項のご</span>入力</li>
                                    <li class="active">2.<span>内容のご</span>確認</li>
                                    <li>3.<span>送信</span>完了</li>
                                </ul>
                                <form @submit.prevent ="add" class="m-t-16 sendEmail comform comment"  method="post" autocomplete="off">
                                        <div class="form-group row">
                                            <div class="col-sm-4 text-left">
                                                <label for ="title"  ><strong> 口コミタイトル </strong>   </label>
                                            </div>
                                             <div class="col-sm-8">
                                                <span class="pl-4">{{ comments.title }}</span>
                                             </div>
                                        </div>

                                        <div class="form-group row">
                                            <div class="col-sm-4 text-left">
                                                <label for ="email" ><strong> メールアドレス</strong>  </label>
                                            </div>
                                            <div class="col-sm-8">
                                                <span class="pl-4">{{ comments.email }}</span>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <div class="col-sm-4 text-left">
                                                <label for ="name"  ><strong> お名前 </strong>   </label>
                                            </div>
                                             <div class="col-sm-8">
                                                <span class="pl-4">{{ comments.name }}</span>
                                             </div>
                                        </div><br>


                                         <div class="form-group row">
                                            <div class="col-sm-4 text-left">
                                                <label for ="year"  ><strong> 生まれた年</strong>   </label>
                                            </div>
                                             <div class="col-sm-8">
                                                 <span class="pl-4">{{ selectedValue }}</span>
                                             </div>
                                        </div><br>

                                        <div class="form-group row" v-for="field in comments.fields" :key="field.id">
                                            <div class="col-sm-4" >
                                                <label for ="zipcode"  ><strong> 郵便番号</strong>   </label>
                                            </div>
                                            <div class="col-sm-8">
                                                <span class="pl-4">{{ field.fzipcode }}</span>
                                            </div>
                                        </div><br>

                                          <div class="form-group row">
                                                <div class="col-sm-4 text-left">
                                                        <label for ="comment" ><strong> 口コミ内容</strong>  </label>
                                                </div>
                                                <div class="col-sm-8">
                                                    <span class="pl-4">{{ comments.comment }}</span>
                                                </div>
                                        </div>

                                        <div class="form-group row">
                                            
                                            <div class="col-sm-12 text-center">
                                                <span class="btn btn-danger white all-btn width17 pc-m-r-10" @click="editCmt()">入力画面へ戻る</span>                                                
                                                <span class="btn main-bg-color white all-btn" @click="add()">投稿する</span>
                                            </div>
                                            
                                        </div>
                                </form>
                            </div>
                            <div class="col-md-12 confirm_box" v-if="type == 'completed'">
                                <ul class="multi-step">
                                <li class="active">1.<span>必要事項のご</span>入力</li>
                                <li class="active">2.<span>内容のご</span>確認</li>
                                <li class="active">3.<span>送信</span>完了</li>
                                </ul>
                                <div class="text-center">
                                <h3>入力内容は送信されました</h3>
                                <div class="row col-12 stepper-success-form text-center">     
                                    <p>口コミの投稿ありがとうございました。</p>
                                    <p>サイト管理者による承認後、口コミが公開されます。</p>
                                </div>
                               <div class="multi-step mt-5">
                                <router-link class="btn btn-info all-btn width17" to="/">ホームへ戻る</router-link>
                               </div>
                                </div>                               
                            </div>
                            <div class="col-sm-2"></div>
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
                errors: { title: "", email: "", name:"", comment:"", phonamene: "" },

                comments: {
                        type:'confirm',
                        title: '',
                        profile_id:'',
                        comment:'',
                        email:'',
                        name:'',
                        year:'',
                        gender:'',
                        fields:[{
                            fzipcode:'',
                            lzipcode:'',
                            id:''
                        }],
                        // profile_id:'',
                        status:'',
                        recordstatus:'',

                    },
                    type: "register",
                    selectedValue:0,
                     mail_reg: /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,24}))$/
            }

        },
        computed : {
             isDisabled: function() {
                // return !this.comments;
            },
            years () {
            const year = new Date().getFullYear()
            return Array.from({length: year - 1900}, (value, index) => 1901 + index)
            }
        },
        created(){
            
            this.comments.types = this.$route.params.type;
            this.comments.gender = 0;
            this.comments.profile_id = this.$route.params.id;
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
             checkValidate() {
                    if (this.comments.title) {
                        this.errors.title = "";
                    } else {
                        this.errors.title = "口コミタイトルは必須です。";
                    }
                    if (this.comments.email){
                        if(this.mail_reg.test(this.comments.email )){
                            this.errors.email = "";
                        }else{
                            this.errors.email = "※メールアドレスが正しくあ                                                                                                                                                                                                                           りません。もう一度入力してください。"
                        }
                    } else {
                        this.errors.email = "メールアドレスは必須です。";
                    }
                    if (this.comments.name) {
                        this.errors.name = "";
                    } else {
                        this.errors.name = "お名前は必須です。";
                    }
                    if (this.comments.comment) {
                        this.errors.comment = "";
                    } else {
                        this.errors.comment = "口コミは必須です。";
                    }
                    if (
                        !this.errors.title &&
                        !this.errors.email &&
                        !this.errors.name  &&
                        !this.errors.comment 
                    ) {
                        // this.add();
                        this.type = 'confirm';
                    }
                },
            isNumber: function(event) {
                if(!(event.keyCode >= 48 && event.keyCode <= 57) && !(event.keyCode >= 96 && event.keyCode <= 105) 
                    && event.keyCode != 8 && event.keyCode != 46 && !(event.keyCode >= 37 && event.keyCode <= 40)) 
                {
                    event.preventDefault();
                }
            },
            add() {
                  this.$loading(true);
                  this.axios.post('/api/comments/add', this.comments)
                    .then((response) => {
                        this.$loading(false);
                        this.type="completed";
                        this.name = ''                        
                    }).catch(error=>{
                    if(error.response.status == 422){
                        this.errors = error.response.data.errors
                    }
                })
            },
             getYear: function(){
               this.comments.year = this.selectedValue;
           },
           editCmt: function() {
             this.type = 'register';
            }

         }
}
</script>



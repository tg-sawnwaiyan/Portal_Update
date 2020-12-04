<template>
    <div>
        <div class="tab-content job-detail">
            <div class="row">               
                <div class="col-12 pad-free m-b-10">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><router-link to="/">ホーム</router-link></li>                         
                            <li class="breadcrumb-item"><span>介護施設資料請求</span></li>
                        </ol>                        
                    </nav>
                </div>                
                <div class="col-md-12 confirm_box" v-if="type == 'confirm'">
                    <div id="loader"></div>
                    <ul class="multi-step">
                        <li class="active">1.<span>お客様情報のご入力</span>入力</li>
                        <li class="active">2.<span>入力内容のご確認</span>確認</li>
                        <li>3.<span>送信完了</span>完了</li>
                    </ul>
                    <form class="col-md-12 form-wrap" @submit.prevent="add" method="post" autocomplete="off">
                        <h4 class="form-tit">資料請求される方について</h4>
                        <div class="mb-5">
                            <p class="require-txt">
                                <span class="nus-mail-confirm">※</span>
                                ご入力いただいた内容に誤りがないかどうか、ご確認ください。
                                <br/>
                                <span class="nus-mail-confirm">※</span> 
                                こちらの内容でよろしければ、「上記内容を送信する」ボタンを押してください。
                            </p>
                            <div class="form-group m-0 row bd">
                                <div class="col-md-3 col-sm-12 form-left">
                                   <strong> お名前</strong>
                                </div>
                                <div class="col-md-9 col-sm-12 form-right">
                                    <input type="text" name="outputSpan" id="outputSpan" class="mailbox" v-model="comments.name" disabled />
                                </div>
                            </div>
                            <div class="form-group m-0 row bd">
                                <div class="col-md-3 col-sm-12 form-left">
                                    <strong>フリガナ</strong>
                                </div>
                                <div class="col-md-9 col-sm-12 form-right">
                                    <input type="text" name="outputfurigana" id="outputfurigana" class="mailbox" disabled v-model="comments.furigana" />
                                </div>
                            </div>
                            <div class="form-group m-0 row bd">
                                <div class="col-md-3 col-sm-12 form-left">
                                    <strong>生年月日</strong>
                                </div>
                                <div class="col-md-9 col-sm-12 form-right">
                                    <input type="text" name="outputbdate" id="outputbdate" class="mailbox" disabled v-model="comments.bdate" />
                                </div>
                            </div>
                            <div class="form-group m-0 row bd">
                                <div class="col-md-3 col-sm-12 form-left">
                                   <strong> 性別</strong>
                                </div>
                                <div class="col-md-9 col-sm-12 form-right">
                                    <input type="text" name="outputsex1" id="outputsex1" class="mailbox" disabled v-model="comments.sex1" />
                                </div>
                            </div>
                            <div class="form-group m-0 row bd">                               
                                <div class="col-md-3 col-sm-12 form-left">                                   
                                    <div class="row col-12 m-0 p-0">
                                        <div class="col-xl-3 col-lg-3 col-12 p-0">
                                            <label class="subtitle"><strong>ご住所</strong></label>
                                        </div>               
                                        <div class="col-xl-9 col-lg-9 col-12 p-0 text-bold form-result">                                                                   
                                            <div class="form-left-child form-group pc-750"><label>郵便番号 </label></div>
                                            <div class="form-left-child form-group pc-750"><label>都道府県</label></div>
                                            <div class="form-left-child form-group pc-750"><label>市区町村</label></div>
                                            <div class="form-left-child form-group pc-750"><label>番地（建物名)</label></div>                                    
                                        </div>           
                                    </div>    
                                </div>
                                <div class="col-md-9 col-sm-12 form-right stepper-result-form">
                                    <div class="form-group  rightwrap row pl-3">
                                        <div class="col-md-3 p-0-990 sp-750">
                                            <label for=""><strong>郵便番号 </strong></label>
                                        </div>
                                        <div class="col-md-9 p-0">
                                            <label class="mailbox pl-2 label-result">{{comments.postal}}</label>
                                        </div>
                                    </div>
                                    <div class="form-group row pl-4">
                                        <div class="col-md-3 p-0-990 sp-750">
                                             <strong>都道府県</strong>
                                        </div>
                                        <div class="col-md-9 p-0">
                                            <label class="mailbox pl-2 label-result" >{{comments.division}}</label>
                                        </div>
                                    </div>
                                    <div class="form-group row pl-4">
                                        <div class="col-md-3 p-0-990 sp-750">
                                             <strong>市区町村</strong>
                                        </div>
                                        <div class="col-md-9 p-0">
                                            <label class="mailbox pl-2 label-result">{{comments.townshipname}}</label>
                                        </div>
                                    </div>
                                    <div class="form-group row pl-4 mb-0">
                                        <div class="col-md-3 p-0-990 sp-750">
                                             <strong>番地（建物名）</strong>
                                        </div>
                                        <div class="col-md-9 p-0">
                                            <label class="mailbox pl-2 label-result" >{{comments.city}}</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group m-0 row bd">
                                <div class="col-md-3 col-sm-12 form-left">
                                    <strong>電話番号</strong>
                                </div>
                                <div class="col-md-9 col-sm-12 form-right">
                                    <input type="number" name="outputphone" id="outputphone" class="mailbox" disabled v-model="comments.phone" />
                                </div>
                            </div>
                            <div class="form-group m-0 row bd-all">
                                <div class="col-md-3 col-sm-12 form-left">
                                   <strong> メールアドレス</strong>
                                </div>
                                <div class="col-md-9 col-sm-12 form-right">
                                    <input type="email" name="outputmail" id="outputmail" class="mailbox" disabled v-model="comments.mail" />
                                </div>
                            </div>                            
                        </div>
                        <div class="mb-5">
                            <h3 class="form-tit" v-if="type !== 'completed'">入居対象者様について</h3>
                            <div class="form-group m-0 row bd">
                                <div class="col-md-3 col-sm-12 form-left">
                                    <strong>入居対象者様とのご関係</strong>
                                </div>
                                <div class="col-md-9 col-sm-12 form-right">
                                    <input type="text" name="outputrelation" id="outputrelation" class="mailbox" v-model="comments.relation" disabled />
                                </div>
                            </div>
                            <div class="form-group m-0 row bd">
                                <div class="col-md-3 col-sm-12 form-left">
                                    <strong>お名前</strong>
                                </div>
                                <div class="col-md-9 col-sm-12 form-right">
                                    <input type="text" name="outputttname" id="outputttname" class="mailbox" v-model="comments.ttname" disabled />
                                </div>
                            </div>
                            <div class="form-group m-0 row bd">
                                <div class="col-md-3 col-sm-12 form-left">
                                   <strong> 性別</strong>
                                </div>
                                <div class="col-md-9 col-sm-12 form-right">
                                    <input type="text" name="outputsex" id="outputsex" class="mailbox" disabled v-model="comments.sex" />
                                </div>
                            </div>
                            <div class="form-group m-0 row bd">
                                <div class="col-md-3 col-sm-12 form-left">
                                    <strong>年齢</strong>
                                </div>
                                <div class="col-md-9 col-sm-12 form-right">
                                    <input type="text" name="outputyears" id="outputyears" class="mailbox" disabled v-model="comments.years" />
                                </div>
                            </div>
                            <div class="form-group m-0 row bd">
                                <div class="col-md-3 col-sm-12 form-left">
                                   <strong>介護度</strong> 
                                </div>
                                <div class="col-md-9 col-sm-12 form-right">
                                    <input type="text" name="outputnursing" id="outputnursing" class="mailbox" disabled v-model="comments.nursing" />
                                </div>
                            </div>
                            <div class="form-group m-0 row bd">
                                <div class="col-md-3 col-sm-12 form-left">
                                    <strong>認知症</strong>
                                </div>
                                <div class="col-md-9 col-sm-12 form-right">
                                    <input type="text" name="outputfect" id="outputfect" class="mailbox" disabled v-model="comments.fect" />
                                </div>
                            </div>
                            <div class="form-group m-0 row bd-all">
                                <div class="col-md-3 col-sm-12 form-left">
                                    <strong> ご要望や、お困りごと、その他お問い合わせ</strong>
                                </div>
                                <div class="col-md-9 col-sm-12 form-right">
                                    <input type="text" name="outputhope" id="outputhope" class="mailbox" disabled v-model="comments.hope" />
                                </div>
                            </div>
                        </div>
                        <div class="text-center">                            
                            <router-link :to="{name: 'nursingFavouriteMail', params: {input_data: this.comments, bk_postal: this.comments.selectedValue}, props: true}" class="btn btn-danger all-btn m-r-8">入力画面に戻る</router-link>
                            <button class="btn main-bg-color all-btn m-t-15 m-l-10 m-b-15 submit-button" id="myButton">上記内容を送信する</button>
                        </div>
                    </form>
                </div>
                <div class="col-md-12 confirm_box" v-if="type == 'completed'">
                    <ul class="multi-step">
                        <li class="active">1.必要事項のご入力</li>
                        <li class="active">2.内容のご確認</li>
                        <li class="active">3.送信完了</li>
                    </ul>
                    <div class="col-md-12 form-wrap text-center">
                        <h4 class="">資料請求が完了いたしました</h4>    
                    </div>
                    <div class="row col-12 stepper-success-form text-center">                       
                        <p>この度は「TIS ティーズ」をご利用いただきましてありがとうございました。</p>
                        <p>お申込みいただいた資料の送付およびお問い合わせいただいた内容につきましては、各施設よりご対応させていただきます。</p>
                    </div>               
                    <div class="multi-step mt-5">
                        <router-link class="btn btn-info all-btn width17" to="/">ホームへ戻る</router-link>
                    </div>    
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    export default {
        props: ["favmail"],
        data() {
            return {
                type: 'confirm',
                comments: {
                    name: "",
                    furigana: "",
                    bdate: "",
                    postal: "",
                    division: "",
                    city: "",
                    phone: "",
                    mail: "",
                    // present: "",
                    relation: "",
                    ttname: "",
                    sex1: "",
                    sex: "",
                    years: "",
                    nursing: "",
                    fect: "",
                    desire: "",
                    hope: "",
                    fav_mail: [{}],
                    fav_id: [{}],
                    fav_name: [{}],
                    // arr_reserve: [{}],
                    arr_document: [{}],
                    selectedValue: 0,
                    fav_name_copy:[]
                },
                errors: [],
                fav_nursing: [],
                local_sto: "",
                post_list: [],
                city_list: [],
                town_list:[]
            };
        },
        created() {
            this.comments = JSON.parse(localStorage.getItem("inputValue"));
            // if (this.comments.present) {
            //   this.comments.present = "する";
            // } else {
            //   this.comments.present = "しない";
            // }
            this.axios.get("/api/hospital/citiesList").then(response => {
                this.city_list = response.data;             
                for (var i = 0; i < this.city_list.length; i++) {
                    if (this.comments.division == this.city_list[i].id) {
                        this.comments.division = this.city_list[i].city_name;
                    }
                }
            });
            this.axios.get("/api/hospital/townshipList").then(response => {
                this.town_list = response.data;              
                for (var i = 0; i < this.town_list.length; i++) {
                    if (this.comments.township == this.town_list[i].id) {
                        this.comments.townshipname = this.town_list[i].township_name;
                    }
                }
            });           
        },
        methods: {
            add() {
                this.comments.fav_name_copy = [];
                this.$loading(true);
                this.axios
                    .post("/api/nurse/add", this.comments)
                    .then(response => {
                        this.$loading(false);
                        //   alert("Mail Sent Successfully !");
                        //   location.href = "favouriteNursing";
                        this.type = "completed";
                    })
                    .catch(error => {
                        if (error.response.status == 422) {
                            this.errors = error.response.data.errors;
                        }
                    });
                localStorage.removeItem("item");
                localStorage.removeItem("inputValue");
                // localStorage.removeItem("reserve");
                localStorage.removeItem("document");
            }
            // back() {
            //     this.$router.push({
            //             name: 'nursingFavouriteMail',
            //             params: { input_data: this.comments, bk_postal: this.comments.selectedValue},
            //             props: true
            //         });
            // },
        }
    };
</script>
<style>
.nus-mail-confirm {
    color: red !important; 
    font-weight: bold !important;
    font-size: 15px !important;
}
</style>
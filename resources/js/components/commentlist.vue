<template>
    <div id="commentList">
        <!--card-->
        <div class="col-12 tab-content">
            <div class="p-2 p0-480">
                <div v-if="norecord_msg" class="card card-default card-wrap">
                    <p class="record-ico">
                    <i class="fa fa-exclamation"></i>
                    </p>
                    <p class="record-txt01">口コミが登録されていません。</p>
                </div>
                <div v-else class="container-fuid">
                    <h4 class="main-color mb-3">口コミ検索</h4>
                    <div class="row mb-4">
                        <div class="col-md-12 choose-item">
                            <autocomplete id="cusname"  placeholder="施設名で検索" input-class="form-control" :source=profileList :results-display="formattedDisplay" @clear="cleartext()"   @selected="getProfile($event)">
                            </autocomplete> 
                        </div>
                    </div>
                    <hr />              
                    <h5 class="header">{{title}}</h5>
                    <div v-if="nosearch_msg" class="card card-default card-wrap">
                        <p class="record-ico">
                            <i class="fa fa-exclamation"></i>
                        </p>
                        <p class="record-txt01">データが見つかりません。</p>
                    </div>
                    <div v-else class="container-fuid">
                        <div class="card card-default m-b-20" v-for="comment in comments.data" :key="comment.id">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12 col-md-10 col-xl-9">   
                                        <div class="row boot-xl" id="customer_list">
                                            <div class="col-xl-1 col-lg-2 col-md-4 custom_title">
                                                <strong>事業者名</strong>
                                            </div>
                                            <div class="col-xl-11 col-lg-10 col-md-8">
                                                <span class="pc-414-inline">: &nbsp;</span>{{comment.cus_name}} 
                                            </div>
                                        </div>
                                        <div class="row boot-xl" id="customer_list">
                                            <div class="col-xl-1 col-lg-2 col-md-4 custom_title">
                                                <strong>施設名</strong>
                                            </div>
                                            <div class="col-xl-11 col-lg-10 col-md-8">
                                                <span class="pc-414-inline">: &nbsp;</span>{{comment.pro_name}} 
                                            </div>
                                        </div>
                                        <div class="row boot-xl" id="customer_list">
                                            <div class="col-xl-1 col-lg-2 col-md-4 custom_title">
                                                <strong>タイトル</strong>
                                            </div>
                                            <div class="col-xl-11 col-lg-10 col-md-8">
                                                <span class="pc-414-inline">: &nbsp;</span>{{comment.title}} 
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-2 col-xl-3 text-right cmt3 pc-414">                                    
                                        <button :class="'btn drop-bg-color changeLink'+comment.id" style="min-width: 65px;font-size:13px;" @click="commentToggle(comment.id)">
                                            詳細 <i :id="'icon' + comment.id" class="fas fa-sort-down animate rotate"></i></button>
                                    </div>
                                </div>
                                <div class="cmt col-12 p-0 mt-750-10">
                                    <span><i class="fa fa-calendar-alt"></i>&nbsp;{{comment.created_date | moment("YYYY年MM月DD日") }}</span>
                                    <span><i class="fa fa-clock"></i>&nbsp;{{comment.created_time}}&nbsp;投稿</span>
                                </div>
                                <div class="cmt2 test sp-414">                           
                                    <button :class="'btn drop-bg-color changeLink'+comment.id" style="min-width: 65px;font-size:13px;" @click="commentToggle(comment.id)">
                                            詳細 <i :id="'icon' + comment.id" class="fas fa-sort-down animate rotate"></i></button>
                                </div>
                                <!--comment-->
                                <div class="collapse" :id="'changeLink' + comment.id" style="margin-top:15px;">
                                    <table class="table table-bordered">
                                        <tr>
                                            <td  class="w-50">
                                                    <p class="mb-2"><span class="text-orange"><span class="job_ico"><i class="fa fa-envelope" aria-hidden="true"></i></span>メールアドレス:&nbsp;</span><span class=""> {{comment.email}}</span></p>
                                            </td>
                                            <td  class="w-50">
                                                    <p class="mb-2"><span class="text-orange"><span class="job_ico"><i class="fa fa-user" aria-hidden="true"></i></span>お名前:&nbsp;</span><span class=""> {{comment.name}}</span></p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td  class="w-50">
                                                    <p class="mb-2"><span class="text-orange"><span class="job_ico"><i class="fa fa-calendar-alt" aria-hidden="true"></i></span>生年月日:&nbsp;</span><span class="" v-if="comment.year != '' && comment.year != null"> {{comment.year}} 年生まれ</span></p> 
        
                                            <td  class="w-50">
                                                    <p class="mb-2"><span class="text-orange"><span class="job_ico">〒<i aria-hidden="true"></i></span>郵便番号:&nbsp;</span><span class=""> {{comment.zipcode}}</span></p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td  class="w-50" colspan="2">
                                                <p class="mb-2"><span class="text-orange"><span class="job_ico"><i class="far fa-comment" aria-hidden="true"></i></span>口コミ内容:&nbsp;</span><span class=""> {{comment.comment}}</span></p>
                                        </td>
                                        </tr>                                  
                                    </table>
                                    <div class="d-inline-block mt-2">
                                        <button class="btn text-danger delete-borderbtn" @click="deleteComment(comment.id)">削除</button>
                                        <span class="mt-2" style="color: #81ad3b;font-weight: bold;" v-if="comment.status != 0" ><i class="fa fa-check-circle" aria-hidden="true"></i>&nbsp;承認済み</span>
                                        <button class="btn confirm-borderbtn" v-else @click="commentConfirm(comment.id)"><i class="fa fa-check" aria-hidden="true"></i>&nbsp;新規口コミ承認</button>
                                    </div>
                                </div>
                                <!--comment-->
                            </div>                                                
                        </div>
                    </div>
                    <div>
                        <pagination :data="comments" @pagination-change-page="searchcomment" :limit="limitpc">
                            <span slot="prev-nav"><i class="fas fa-angle-left"></i> 前へ</span>
                            <span slot="next-nav">次へ <i class="fas fa-angle-right"></i></span>
                        </pagination>
                    </div>
                </div>
            </div>
        </div>
        <!--end card-->
    </div>
</template>
<script>
    import Autocomplete from 'vuejs-auto-complete';
    export default {
        components: {
            Autocomplete,
        },
        props:{
            limitpc: {
                type: Number,
                default: 5
            },
        },
        data() {
            return {
                comments: [],
                profileList:[],
                norecord: 0,
                items: [],
                norecord_msg: false,
                nosearch_msg: false,
                title: '',
                type:'',
                profileid:'',
                customerList:'',
                cusid:'',
                proid:'',
                table_name: {
                    profile: ''
                },
                cusname:'',
                selectedValue:0
            }
        },
        created() {
            Vue.use(require('vue-moment'));
            this.selectedValue = 0;
            this.profileid = 0;
            this.$loading(true);
            if(this.$route.path == "/nuscommentlist"){
                this.type = "nursing";
                this.title = "口コミ一覧";
                this.axios
                .get('/api/comments/comment/3')
                .then(response => {
                    this.$loading(false);
                    this.comments = response.data.commentlist;
                    this.norecord = this.comments.data.length;                   
                    if(this.norecord != 0) {
                        this.norecord_msg = false;
                    }else{
                        this.norecord_msg = true;
                    }
                });
            }
            else if(this.$route.path == "/hoscommentlist"){
                this.type = "hospital";
                this.title = "口コミ一覧";
                this.axios
                .get('/api/comments/comment/2')
                .then(response => {
                    this.$loading(false);
                    this.comments = response.data.commentlist;
                    this.norecord = this.comments.data.length;
                    if(this.norecord != 0) {
                        this.norecord_msg = false;
                    }else{
                        this.norecord_msg = true;
                    }
                });
            }
            if(this.type == "nursing"){
                this.table_name.profile = 'nursing_profiles';
            }else {
                this.table_name.profile = 'hospital_profiles';
            }
            this.axios.post(`/api/job/profileList/`+ 0,this.table_name).then(response=> {
                this.profileList = response.data;
            });
        },
        methods: {
            getComment()
            {
                this.$loading(true);
                if(this.$route.path == "/nuscommentlist"){
                    this.axios.get('/api/comments/getCustomComment/3/'+this.selectedValue).then(response => {
                        this.$loading(false);
                        this.comments = response.data;
                        if(this.comments.data.length == 0)
                        {
                            this.nosearch_msg = true;
                        }
                        else{
                            this.nosearch_msg = false;
                        }
                    });
                }
                else if(this.$route.path == "/hoscommentlist"){
                    this.axios.get('/api/comments/getCustomComment/2/'+this.selectedValue).then(response => {
                        this.$loading(false);
                        this.comments = response.data;
                        if(this.comments.data.length == 0)
                        {
                            this.nosearch_msg = true;
                        }
                        else{
                            this.nosearch_msg = false;
                        }                                                    
                    });
                }
            },
            getProfile($event)
            {
                this.selectedValue = $event.value;
                this.getComment();
            },
            cleartext(){
                this.selectedValue = 0;
                this.getComment();
            },                
            deleteComment(id) {
                this.$swal({
                    text: "口コミを削除してよろしいでしょうか。",
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
                    if(this.$route.path == "/nuscommentlist"){
                        this.type = "nursing";
                    }
                    else{
                        this.type = "hospital"
                    }
                    this.axios
                    .delete(`/api/comments/delete/${id}`+'/'+this.type+"/"+this.selectedValue)
                    .then(response => {
                        this.comments = response.data;
                        this.norecord = this.comments.data.length;
                        if(this.norecord > this.size){
                            this.pagination = true;
                        }else{
                            this.pagination = false;
                        }
                        if(this.norecord != 0) {
                            this.norecord_msg = false;
                        }else{
                            this.norecord_msg = true;
                        }
                        this.$swal({
                            text: "口コミを削除しました。",
                            type: "success",
                            width: 350,
                            height: 200,
                            confirmButtonText: "閉じる",
                            confirmButtonColor: "#31cd38",
                            allowOutsideClick: false,
                        });

                    })
                    .catch(() => {
                        this.$swal({                                       
                            html: "システムエラーです。<br/>社内エンジニアにお問い合わせください。<br/><a href='mailto:pg@management-partners.co.jp'>pg@management-partners.co.jp</a>",
                            type: "error",
                            width: 350,
                            height: 200,
                            confirmButtonText: "閉じる",
                            confirmButtonColor: "#FF5462",
                            allowOutsideClick: false,
                        });
                    });
                });
            },
            commentConfirm(id) {
                this.$swal({
                    text: "口コミを承認してよろしいでしょうか。",
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
                    this.$loading(true);
                        if(this.$route.path == "/nuscommentlist"){
                            this.type = "nursing";
                        }
                        else{
                            this.type = "hospital"
                        }
                    this.axios.get(`/api/comments/confirm/${id}`+'/'+this.type+'/'+this.selectedValue)
                    .then(response => {
                        this.$loading(false);
                        this.comments = response.data.comments;
                        this.$swal({
                            text: "口コミを承認しました。",
                            type: "success",
                            width: 350,
                            height: 200,
                            confirmButtonText: "閉じる",
                            confirmButtonColor: "#31cd38",
                            allowOutsideClick: false,
                        })
                        .catch(() => {
                            this.$swal({
                                html: "システムエラーです。<br/>社内エンジニアにお問い合わせください。",
                                type: "error",
                                width: 350,
                                height: 200,
                                confirmButtonText: "閉じる",
                                confirmButtonColor: "#FF5462",
                                allowOutsideClick: false,
                            });
                        });
                    })
                });
            },
            searchcomment(page) {
                if(this.$route.path == "/nuscommentlist"){
                    this.type = "nursing";
                }
                else
                {  
                    this.type = "hospital"
                }
                if(typeof page === "undefined"){
                    page = 1;
                }
                        
                var search_word = this.selectedValue;
                let fd = new FormData();
                fd.append("search_word", search_word);
                fd.append("type",this.type);
                this.$loading(true);
                $("html, body").animate({ scrollTop: 0 }, "slow");
                this.axios.post("/api/comments/search?page="+page, fd).then(response => {
                    this.$loading(false);
                    this.comments = response.data;
                    if(this.comments.data.length == 0){
                        this.nosearch_msg = true;
                    }else{
                        this.nosearch_msg = false;
                    }
                    });
            },
            commentToggle(id) {
                var class_by_id = $('#icon' + id).attr('class');
                if (class_by_id == "fas fa-sort-down animate rotate") {
                    $('#icon' + id).removeClass("fas fa-sort-down animate rotate");
                    $('.changeLink' + id).removeClass("fas fa-sort-down animate");
                    $('#icon' + id).addClass("fas fa-sort-down animate");
                    $('#changeLink' + id).show('medium');
                } else {
                    $('#icon' + id).removeClass("fas fa-sort-down animate");
                    $('.changeLink' + id).removeClass("fas fa-sort-down animate");
                    $('#icon' + id).addClass("fas fa-sort-down animate rotate");
                    $('#changeLink' + id).hide('medium');
                }
            },
        }
    }
</script>

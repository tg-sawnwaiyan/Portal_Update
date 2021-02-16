<template>
    <div id="job_apply">
        <div class="col-12  tab-content">
            <div class="p-2 p0-480">
                <h4 class="main-color mb-3">求人応募者検索 <a @click="$router.go(-1)" v-if="$route.params.id" class="btn btn-danger all-btn submit float-right"><i class="fas fa-arrow-left"></i>&nbsp;戻る</a></h4>
                <div class="row mb-4">
                    <div class="col-md-12">
                        <input type="text" class="form-control" placeholder="求人タイトルで検索" id="search-item"  @keyup="searchApplicantList()" />
                        <input type="hidden" class="form-contrl"/>
                    </div>
                </div>
                <hr />    
              
                <h5 class="header"> 求人応募者一覧</h5>     
                <div class="row m-b-10">
                    <div class="m-l-20" v-if="job_id != ''">
                        <p class="job_id"><span>求人番号 :</span>{{job_id}}</p>
                    </div> 
                    <div class="col-12">
                    <p  v-if="page == 'job' && job_id != ''" style="font-size: 0.9em; font-weight: normal; color: #333;">
                        <router-link class="job_title pseudolink" :to="{path:'/job_details/'+jobapplies.data[0]['job_id']}">{{job_title}} </router-link>
                    </p>
                    <div  class="col-12 m-b-15 p-0" v-if="page == 'profile' && proname != ''">                        
                        <h5 class="subtitle" style=""><strong>施設名:</strong> {{proname}} </h5>                                         
                    </div>    
                </div>
                </div> 
                <div v-if="nosearch_msg" class="card card-default card-wrap">
                    <p class="record-ico">
                    <i class="fa fa-exclamation"></i>
                    </p>                   
                    <p class="record-txt01">求人応募者が存在しません。</p>
                </div>
                <div v-else class="container-fuid">
                    <div class="card card-default m-b-20"  v-for="jobapply in jobapplies.data" :key="jobapply.id">
                            <div class="card-body p-3">
                                <div class="row"  v-if="page == null || page == 'profile' ">
                                    <div class="col-9">
                                         <span class="job_id_1"><span>求人番号 :</span>{{jobapply.jobid}}</span>
                                    </div>
                                     <div class="col-3 pad-free-750 text-right">
                                        <button :class="'btn btn drop-bg-color changeLink'+jobapply.id"  @click="applicatnToggle(jobapply.id)">
                                        詳細  <i :id="'icon' + jobapply.id" class="fas fa-sort-down animate rotate"></i></button>
                                    </div>
                                    <div class="col-12">
                                        <div class="joboffer-tit clearfix">
                                            <router-link class="job_title_1 pseudolink" :to="{path:'/job_details/'+jobapply.job_id}">{{jobapply.job_title}} </router-link>
                                        </div>
                                    </div> 
                                   
                                </div>
                                <div v-else>
                                     <div class="col-12  text-right">
                                        <button :class="'btn btn drop-bg-color changeLink'+jobapply.id"  @click="applicatnToggle(jobapply.id)">
                                        詳細 <i :id="'icon' + jobapply.id" class="fas fa-sort-down animate rotate"></i></button>
                                    </div>
                                </div>
                               
                                <div class="row boot-xl mt-4" id="customer_list">
                                    <div class="col-xl-1 col-lg-2 col-md-4 custom_title">
                                        <strong>お名前</strong>
                                    </div>
                                    <div class="col-xl-11 col-lg-10 col-md-8"><span class="pc-414-inline">: &nbsp;</span>{{jobapply.first_name}}</div>
                                </div>
                                 <div class="row boot-xl" id="customer_list">
                                    <div class="col-xl-1 col-lg-2 col-md-4 custom_title">
                                        <strong>フリガナ</strong>
                                    </div>
                                    <div class="col-xl-11 col-lg-10 col-md-8"><span class="pc-414-inline">: &nbsp;</span>{{jobapply.last_name}}</div>
                                </div>
                                <div class="collapse" :id="'changeLink' + jobapply.id">                                    
                                    <table class="table table-bordered jobapp-tb">
                                        <tr>
                                            <td  class="w-50">
                                                    <p class="mb-2"><span class="text-orange"><span class="job_ico"><i class="fa fa-calendar-alt" aria-hidden="true"></i></span>生年月日:&nbsp;</span><span class=""> {{jobapply.birthday}}</span></p>
                                            </td>
                                            <td class="w-50">
                                                <p class="mb-2"><span class="text-orange"><span class="job_ico">〒</span> 郵便番号:&nbsp;</span><span class=""> {{jobapply.postal}}</span></p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td  class="w-50">
                                                <p class="mb-2"><span class="text-orange"><span class="job_ico"><i class="fa fa-user"></i></span> 性別:&nbsp;</span><span class=""> {{jobapply.gender}}</span></p>
                                                   
                                            </td>
                                            <td  class="w-50">
                                                    <p class="mb-2"><span class="text-orange"><span class="job_ico"><i class="fa fa-map-marker-alt"></i></span>住所:&nbsp;</span>{{jobapply.city_name}}{{jobapply.township_name}}{{jobapply.street_address}}</p> 
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="w-50">
                                                <p class="mb-2"><span class="text-orange"><span class="job_ico"><i class="fa fa-envelope"></i></span> メールアドレス:&nbsp;</span><span class=""> {{jobapply.email}}</span></p>
                                            </td>
                                            <td  class="w-50">
                                                    <p class="mb-2"><span class="text-orange"><span class="job_ico"><img src="/images/icons8-phone.png" width="75%"></span> 電話番号:&nbsp;</span><span class=""> {{jobapply.phone}}</span></p>
                                            </td>
                                        </tr>
                                    </table>
                                    <span class="btn delete-borderbtn mr-2 mb-2" @click="jobApplicantDelete(jobapply.id)">削除</span>
                                </div>
                                    
                            </div>
                        </div>
                        <pagination :data="jobapplies" @pagination-change-page="searchApplicantList" :limit="limitpc" class="mt-3">
                        <span slot="prev-nav"><i class="fas fa-angle-left"></i> 前へ</span>
                        <span slot="next-nav">次へ <i class="fas fa-angle-right"></i></span>
                    </pagination>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {

    props:{
            limitpc: {
            type: Number,
            default: 5,
        },
    },

    data() {
        return {

            jobapplies: [],  
            nosearch_msg: false,
            search_id:0,
            job_title: '',
            type: null,
            page: null,
            job_id:'',
            proname:'',
            colnum: 'col-3',
            loginuser:true
        };

    },
    created() {
        this.getJobapplicantList();
        this.axios.get('/api/user').then(response => {
            this.loginuser = 'true';
        }).catch((error) => {
            this.loginuser = 'false';
        })
    },

    methods: {
        searchApplicantList(page) {
            if(typeof page === "undefined"){
                page = 1;
            }
            var search_word = $("#search-item").val();

            let fd = new FormData();
            fd.append("search_word", search_word);
            fd.append("search_id",this.search_id);
            fd.append("pages",this.page);
            fd.append("type",this.type);
            this.$loading(true);
            $("html, body").animate({ scrollTop: 0 }, "slow");
            this.axios.post("/api/jobapplicant/search?page="+page, fd).then(response => {
                this.$loading(false);
                this.jobapplies = response.data;
                if(this.jobapplies.data.length != 0){
                    
                     this.nosearch_msg = false;
                }
                else{
                     this.nosearch_msg = true;
                }
                if(this.jobapplies.data.length != 0 && this.page == 'job')
                {
                     this.job_id = this.jobapplies.data[0].jobid;
                     this.job_title = this.jobapplies.data[0].job_title;
                }
                else if(this.jobapplies.data.length  && this.page == 'profile'){
                    this.proname = this.jobapplies.data[0].proname;
                }
        
            });
        },
        
        getJobapplicantList(){
            if(this.$route.name == 'jobapplicantlist'){
                this.search_id = 0;
                this.type = 'admin';
                this.page = null;  
                this.colnum = 'col-3';
            }
            else{                        
                this.type = this.$route.params.type;
                this.search_id = this.$route.params.id;                        
                this.page = this.$route.params.page;    
                this.colnum = 'col-12';                    
            }
            this.$loading(true);
            this.axios.get("/api/jobapplicantlist/"+this.type+"/"+this.page+"/"+this.search_id).then(response => {
                this.$loading(false);
                this.jobapplies = response.data;
                if(this.jobapplies.data.length != 0){
                    
                     this.nosearch_msg = false;
                }
                else{
                     this.nosearch_msg = true;
                }
             
                if(this.jobapplies.data.length != 0 && this.page == 'job')
                {
                  
                     this.job_id = this.jobapplies.data[0].jobid;
                     this.job_title = this.jobapplies.data[0].job_title;
                }
                else if(this.page == 'profile'){
                    
                    this.proname = this.jobapplies.data[0].proname;
                   
                }
               
            });
        },

        applicatnToggle(id) {
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

        jobApplicantDelete(id){
            this.$swal({
                // title: "確認",
                text: "求人応募者を削除してよろしいでしょうか。",
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
                this.axios.delete(`/api/jobApplicantDelete/${id}`)
                        .then(res => {
                        this.getJobapplicantList();
                    });
                this.$swal({
                    text: "求人応募者を削除しました。",
                    type: "success",
                    width: 350,
                    height: 200,
                    confirmButtonText: "閉じる",
                    confirmButtonColor: "#31cd38",
                    allowOutsideClick: false,
                });
            });                       
        }
    }
}
</script>
<style scoped>

.collapse .table-bordered{
    margin:13px auto 15px auto !important;

}
.joboffer-tit .font-weight-bold{
    line-height: 2em !important;
}
</style>

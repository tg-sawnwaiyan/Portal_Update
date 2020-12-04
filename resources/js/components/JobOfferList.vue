<template>
    <div id="joboffer_list">
        <div class="col-12 tab-content">
            
            <div class="p-2 p0-480">
                <div v-if="norecord_msg" class="card card-default m-b-20 card-wrap">
                    <p class="record-ico">
                        <i class="fa fa-exclamation"></i>
                    </p>
                 
                    <p class="record-txt01">求人が登録されていません。</p>
                 
                    <router-link :to="hrefroute" class="main-bg-color create-btn all-btn">
                        <i class="fas fa-plus-circle"></i> 求人新規作成
                    </router-link>
                </div>

                <div v-else class="container-fuid">
                    <h4 class="main-color mb-3">求人検索 <a @click="$router.go(-1)" v-if="$route.params.id" class="btn btn-danger all-btn submit float-right"><i class="fas fa-arrow-left"></i>&nbsp;戻る</a></h4>
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <input type="text" class="form-control" placeholder="求人タイトルで検索" id="search-item" @keyup="searchJobOffer()" />
                            <input type="hidden" class="form-contrl" id="customer-id" v-model="customer_id" />                               
                        </div>
                    </div>
                    <hr />
                    <div class="d-flex header pb-3 admin_header">
                        <h5>求人一覧  </h5>                       
                        <div class="ml-auto" v-if="!norecord_msg">
                            <router-link :to="hrefroute" class="main-bg-color create-btn all-btn">
                                <i class="fas fa-plus-circle"></i> <span class="first_txt"> 求人</span><span class="dinone">新規作成</span>
                            </router-link>
                        </div>
                    </div>
                     <div class="col-12 m-b-15 p-0">                        
                            <h5>                                 
                                <span v-if="type != 'admin' && jobs.data.length">
                                    <label for="" class="subtitle"><strong>施設名:</strong> </label>
                                    {{jobs.data[0].profile_name}}
                                </span>
                            </h5>
                        </div>
                    
                    <div v-if="nosearch_msg" class="card card-default card-wrap">
                        <p class="record-ico">
                            <i class="fa fa-exclamation"></i>
                        </p>
                        <p class="record-txt01">データが見つかりません。</p>
                    </div>
                   

                    <div class="container-fuid">
                        <div class="card card-default m-b-20" v-for="job in jobs.data" :key="job.id">
                            <div class="card-body p-3">
                                <div class="row">
                                    <div class="col-12 col-md-7">
                                         <div class="d-flex">                                            
                                            <p class="job_id_1 mt-0  d-flex align-items-center">求人番号：{{job.jobid}}</p>
                                        </div>
                                    </div>
                                     <div class="col-12 col-md-5 text-right choose-item">
                                        <p class="job-no">応募者数:
                                            <span class="text-orange"><span class="job_count">{{job.count}}件</span></span>
                                        </p>
                                    </div>   
                                </div>
                                <div class="row">
                                     <div class="col-12">
                                        <div class="joboffer-tit clearfix">
                                            <router-link class="pseudolink" :to="{path:'/job_details/'+job.id}">{{job.title}} </router-link>                                            
                                        </div>
                                    </div>
                                    
                                </div>
                                <div class="row mt-4">
                                    <div class="model-7 col-12">
                                        <div class="checkbox">
                                            <input type='checkbox' v-if="job.recordstatus == 1" @click="confirm(job.id)" checked/>
                                            <input type='checkbox' v-if="job.recordstatus==0" @click="confirm(job.id)"  />
                                            <label for="checkbox"></label>
                                            <div v-if="job.recordstatus == 1" class="on">公開中</div>
                                            <div v-if="job.recordstatus == 0" class="on">非公開</div>
                                        </div>
                                         <ul class="btn-list mt-4">
                                             
                                        <li>
                                            <router-link :to="{path: '/jobedit/'+job.id }" class="btn edit-borderbtn">編集</router-link>
                                        </li>                           
                                        <li><a class="btn text-danger delete-borderbtn" @click="deleteJob(job.id)">削除</a></li>
                                        
                                        <li class="mt-2" v-if="job.count">
                                            <router-link :to="{path: '/jobapplicantlist/'+type+'/job/'+job.id, params:{title:job.title}}" class="btn confirm-borderbtn confirmed"><i class="fa fa-list"></i>求人応募一覧<span class="pc-414-inline ">ページへ</span></router-link>
                                        </li>
                                    </ul>
                                    </div>
                                    <div class=" col-6">
                                        
                                    </div>
                                </div>
                                
                                  
                            </div>
                        </div>
                        
                    </div>
                    <div>
                        <pagination :data="jobs" @pagination-change-page="searchJobOffer" :limit="limitpc">
                            <span slot="prev-nav"><i class="fas fa-angle-left"></i> 前へ</span>
                            <span slot="next-nav">次へ <i class="fas fa-angle-right"></i></span>
                        </pagination>
                    </div>
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
                default: 5
            },
        },
        //  mounted(){

        //     this.count = this.countJobapplylist()

        // },
        data() {
                return {
                    jobs: [],
                    customer_id: "",
                    count: "",
                    job_id: [],
                    items: [],
                    loginuser: true,
                    norecord_msg: false,
                    nosearch_msg: false,
                    subtitle: 'OFF',
                    pro_id: 0,
                    hrefroute: '',
                };
            },

            created() {
               
                

                if(this.$route.name == "profilejobofferlist"){
                    
                    this.pro_id = this.$route.params.id;
                    this.type = this.$route.params.type;
                    this.hrefroute = "/profilejoboffercreate/"+this.type+"/"+this.pro_id;
                }
                else{
                    
                    this.pro_id = null;
                    this.type = 'admin';
                    this.hrefroute = "/joboffercreate";
                }
                this.getAllJobs();
                
                this.axios.get('/api/user').then(response => {
                // this.pro_id = response.data.lat_lng[0].id;
                this.loginuser = 'true';
                }).catch((error) => {
                    this.loginuser = 'false';
                })

                // this.countJobapplylist(this.job_id);
            },
            methods: {
                   getAllJobs() { 
                    if(this.$route.params.status == 'update'){
                        var page_no = this.$route.params.page_no;
                        this.nextPaginate(page_no);
                    }else{
                        this.$loading(true);
                        this.axios.get("/api/job/index/"+this.type+"/"+this.pro_id).then(response => {
                            this.$loading(false);
                            this.jobs = response.data.profilejob;
                            this.customer_id = response.data.user;
                            if(this.jobs.data){
                                if(this.jobs.data.length != 0){
                                    this.norecord_msg = false;
                                }else{
                                    this.norecord_msg = true;
                                }
                            }else{
                                this.norecord_msg = true;
                            }
                            

                        });
                    }
                },
                jobToggle(id) {
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

                
                confirm(id) {

                    this.axios.get(`/api/job/confirm/${id}`)
                        .then(response => {


                            // this.jobs = response.data.jobs;
                            this.getAllJobs();
                        });


                    },
                deleteJob(id) {
                        this.$swal({
                            // title: "確認",
                            text: "求人を削除してよろしいでしょうか。",
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
                                .delete(`/api/job/delete/${id}/`+this.type+"/"+this.pro_id)
                                .then(response => {
                                    // let i = this.jobs.map(item => item.id).indexOf(id); // find index of your object
                                    // this.jobs.splice(i, 1);
                                    this.jobs = response.data.profilejob;
                                    this.customer_id = response.data.user;
                                    if(this.jobs.data.length != 0){
                                        this.norecord_msg = false;
                                    }else{
                                        this.norecord_msg = true;
                                    }
                                    this.$swal({
                                        text: "求人を削除しました。",
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
                    searchJobOffer(page) {
                     
                        if(typeof page === "undefined"){
                            page = 1;
                        }
                        var search_word = $("#search-item").val();

                        let fd = new FormData();
                        fd.append("search_word", search_word);
                        fd.append('type',this.type);
                        fd.append('pro_id',this.pro_id);
                         this.$loading(true);
                         $("html, body").animate({ scrollTop: 0 }, "slow");
                        this.axios.post("/api/job/search?page="+page, fd).then(response => {
                            this.$loading(false);
                            this.jobs = response.data.jobsearch;
                           
                            if(this.jobs.data.length != 0){
                                this.nosearch_msg = false;
                            }else{
                                this.nosearch_msg = true;
                            }
                        });
                        localStorage.setItem('job_page_no',page);
                    },
                    nextPaginate(num){
                        let fd = new FormData();
                        fd.append('type',this.type);                 
                        this.$loading(true);
                        this.axios.post("/api/job/search?page="+num,fd).then(response => {
                            this.$loading(false);
                            this.jobs = response.data.jobsearch;
                           
                            if(this.jobs.data.length != 0){
                                this.nosearch_msg = false;
                            }else{
                                this.nosearch_msg = true;
                            }
                        });
                    },
    
            }
    };
</script>
<style>

/*eee*/


/*=====================*/

</style>

<template>
    <div>
        <!--card-->
        <div class="col-12  tab-content">
            <div class="p-2 p0-480">
                <div v-if="norecord_msg" class="card card-default card-wrap">
                    <p class="record-ico">
                        <i class="fa fa-exclamation"></i>
                    </p>
                  
                    <p class="record-txt01">特長が登録されていません。</p>
                   
                    <router-link to="/specialfeature" class="main-bg-color create-btn all-btn">
                        <i class="fas fa-plus-circle"></i> 特長新規作成
                    </router-link>
                </div>
                <div v-else class="container-fuid">
                    <h4 class="main-color mb-3">特長検索</h4>
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <input type="text" class="form-control" placeholder="特長検索" id="search-item" @keyup="searchFeature()" />
                        </div>
                    </div>
                    <hr />
                    <div class="d-flex header pb-3 admin_header">
                        <h5>{{title}}</h5>
                        <div class="ml-auto" v-if="!norecord_msg">
                            <router-link to="/specialfeature" class="main-bg-color create-btn all-btn">
                                <i class="fas fa-plus-circle"></i> <span class="first_txt">特長</span><span class="dinone">新規作成</span>
                            </router-link>
                        </div>
                    </div>
                    <div class="col-md-12 pad-free scrolldiv p0-480">
                     
                    <div v-if="nosearch_msg" class="card card-default card-wrap">
                        <p class="record-ico">
                        <i class="fa fa-exclamation"></i>
                        </p>
                        <p class="record-txt01">データが見つかりません。</p>
                    </div>
                        
                        <div v-else class="container-fuid scroll_responsive">
                            <table class="table table-hover custom-table">
                                <thead>
                                    <tr>
                                        <th>特長名</th>
                                        <th>略語</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="feature in features.data" :key="feature.id">
                                        <td>{{feature.name}}</td>
                                        <td>{{feature.short_name}}</td>
                                        <td class="text-right">
                                            <router-link :to="{name:'specialfeature', params:{id : feature.id}}" class="btn edit-borderbtn">編集</router-link>
                                            <button class="btn text-danger delete-borderbtn" @click="deleteFeature(feature.id,feature.type)">削除</button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            
                        </div>
                        <div>
                            <pagination :data="features" @pagination-change-page="searchFeature" :limit="limitpc" class="mt-3">
                                <span slot="prev-nav"><i class="fas fa-angle-left"></i> 前へ</span>
                                <span slot="next-nav">次へ <i class="fas fa-angle-right"></i></span>
                            </pagination>
                        </div>
                    </div>
                </div>
                <!--end card-->
            </div>
        </div>
        <!--end card-->
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
        data() {
            return {
                features: [],
                norecord: 0,
                norecord_msg: false,
                nosearch_msg: false, 
                title: '',
            };
        },

        created() {
            this.$loading(true);
            if(this.$route.path == "/nusfeaturelist"){
                this.type = 'nursing';
                this.title = "特長一覧";
                this.axios.get("/api/feature/featurelist/nursing").then(response => {
                    this.$loading(false);
                    this.features = response.data;
                    this.norecord = this.features.data.length;
                    if (this.norecord != 0){
                        this.norecord_msg = false;
                    }else {
                        this.norecord_msg = true;
                    }
                });
            }
            else if(this.$route.path == "/hosfeaturelist"){
                this.type = 'hospital';
                this.title = "特長一覧";
                this.axios.get("/api/feature/featurelist/hospital").then(response => {
                    this.$loading(false);
                    this.features = response.data;
                    this.norecord = this.features.data.length;
                    if (this.norecord != 0){
                        this.norecord_msg = false;
                    }else {
                        this.norecord_msg = true;
                    }
                });
            }

        },
        methods: {
            deleteFeature(id,type) {
                this.$swal({
                    text: "特長を削除してよろしいでしょうか。",
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
                    .delete(`/api/feature/delete/${id}/${type}`)
                    .then(response => {
                        this.features = response.data;
                        this.norecord = this.features.data.length;
                        if (this.norecord > this.size) {
                            this.pagination = true;
                        } else {
                            this.pagination = false;
                        }
                        if (this.norecord != 0){
                            this.norecord_msg = false;
                        }else {
                            this.norecord_msg = true;
                        }
                        this.$swal({
                            text: "特長を削除しました。",
                            type: "success",
                            width: 350,
                            height: 200,
                            confirmButtonText: "閉じる",
                            confirmButtonColor: "#31cd38",
                            allowOutsideClick: false,
                            
                        });
                    }).catch(error=>{
                        if(error.response.status == 404){ 
                            this.$swal({
                                html: "削除に失敗しました。<br/>削除しようとした特長の施設が存在するため削除できません。 ",
                                type: "error",
                                width: 350,
                                height: 200,
                                confirmButtonText: "閉じる",
                                confirmButtonColor: "#ff5462",
                                allowOutsideClick: false,
                            });
                        }
                    });
                });
            },

            searchFeature(page) {
                if (typeof page === 'undefined') {
                    page = 1;
                }
                var search_word = $("#search-item").val();
                let fd = new FormData();
                fd.append("search_word", search_word);
                this.$loading(true);
                $("html, body").animate({ scrollTop: 0 }, "slow");
                this.axios.post("/api/feature/search/"+this.type+"?page="+page, fd).then(response => {
                    this.$loading(false);
                    this.features = response.data;
                    if(this.features.data.length != 0){
                        this.nosearch_msg = false;
                    }else {
                        this.nosearch_msg = true;
                    }
                });
            },
        }
    };
</script>

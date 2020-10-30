<template>
        <div>
            <!--card-->
            <div class="col-12  tab-content">
                <div class="p-2 p0-480">
                    <div v-if="norecord_msg" class="card card-default card-wrap">
                        <p class="record-ico">
                            <i class="fa fa-exclamation"></i>
                        </p>
                   
                        <p class="record-txt01">ニュースカテゴリーが登録されていません。</p>
                       
                        <router-link to="/createcategory" class="main-bg-color create-btn all-btn">
                            <i class="fas fa-plus-circle"></i> カテゴリー新規作成
                        </router-link>
                    </div>
                    <div v-else class="container-fuid">
                        <h4 class="main-color mb-3">ニュースカテゴリー検索</h4>
                        <div class="row mb-4">
                            <div class="col-md-12">
                                <input type="text" class="form-control" placeholder="ニュースカテゴリー検索" id="search-item" @keyup="searchCategory()" />
                            </div>
                            <!-- <div class="col-md-2 text-right">
                                    <button class="btn secondary-bg-color all-btn white" style="width:100%;"><i class="fas fa-search"></i> 検索</button>
                            </div>-->
                        </div>
                        <hr />
                        <div class="d-flex header pb-3 admin_header">
                            <h5>ニュースカテゴリー一覧</h5>
                            <div class="ml-auto" v-if="!norecord_msg">
                                <router-link to="/createcategory" class="main-bg-color create-btn all-btn">
                                    <i class="fas fa-plus-circle"></i> <span class="first_txt">カテゴリー</span><span class="dinone">新規作成</span>
                                </router-link>
                            </div>
                        </div>
                        
                        <!-- <div v-if="nosearch_msg" class="container-fuid no_search_data">新規作成するデータが消える。</div> -->

                            <div v-if="nosearch_msg" class="card card-default card-wrap">
                                <p class="record-ico">
                                    <i class="fa fa-exclamation"></i>
                                </p>
                                <p class="record-txt01">データが見つかりません。</p>
                            </div>
                        
                        <div v-else class="container-fuid">
                            <div class="card card-default m-b-20" v-for="category in categories.data" :key="category.id">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6 col-sm-8 m-t-8" v-if="category.name == 'トップ'">{{category.name}}</div>
                                        <div class="col-md-6 col-sm-8 m-t-8" v-if="category.name != 'トップ'">{{category.name}} ({{category.order_number}})</div>
                                        <div  v-if="category.name != 'PR' && category.name != 'トップ'" class="col-md-6 col-sm-4 text-right admin_page_edit">
                                            <router-link :to="{name:'editcategory', params:{id : category.id}}" class="btn edit-borderbtn">編集</router-link>
                                            <button class="btn text-danger delete-borderbtn" @click="deleteCategory(category.id)" >削除</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- <pagination :data="categories" @pagination-change-page="searchCategory"></pagination> -->
                        <div>
                            <pagination :data="categories" @pagination-change-page="searchCategory" :limit="limitpc">
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
    export default {
           props:{
            limitpc: {
                type: Number,
                default: 5
            },
        },
        data() {
                return {
                    categories: [],
                    norecord: 0,
                    norecord_msg: false,
                    nosearch_msg: false,
                    items: [],
                };
            },

            created() {
                if(this.$route.params.status == 'update'){
                    var page_no = this.$route.params.page_no;
                    this.nextPaginate(page_no);
                }else{
                    this.$loading(true);
                    this.axios.get("/api/category/categories").then(response => {
                        this.$loading(false);
                        this.categories = response.data;
                        this.norecord = this.categories.data.length;
                        if (this.norecord != 0) {
                            this.norecord_msg = false;
                        }else {
                            this.norecord_msg = true;
                        }
                    });
                }
            },
            methods: {
                deleteCategory(id) {
                        this.$swal({
                            // title: "確認",
                            text: "ニュースカテゴリーを削除してよろしいでしょうか。",
                            type: "warning",
                            width: 380,
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
                                .delete(`/api/category/delete/${id}`)
                                .then(response => {
                                    this.categories = response.data;
                                    this.norecord = this.categories.data.length;
                                    if (this.norecord > this.size) {
                                        this.pagination = true;
                                    } else {
                                        this.pagination = false;
                                    }
                                    if (this.norecord != 0) {
                                        this.norecord_msg = false;
                                    }else {
                                        this.norecord_msg = true;
                                    }
                                    // let i = this.categories.map(item => item.id).indexOf(id); // find index of your object
                                    // this.categories.splice(i, 1);
                                    this.$swal({
                                        // title: "削除済",
                                        text: "ニュースカテゴリーを削除しました。",
                                        type: "success",
                                        width: 350,
                                        height: 200,
                                        confirmButtonText: "閉じる",
                                        confirmButtonColor: "#31cd38",
                                        allowOutsideClick: false,
                                        allowOutsideClick: false,
                                    });

                                })
                                 .catch(error=>{
                                    if(error.response.status == 404){
                                        // this.$swal("このカテゴリーに関連するニュースがあるため、削除できません。");
                                        this.$swal({
                                            // title: "削除に失敗しました",
                                            html: "削除に失敗しました。<br>削除しようとしたカテゴリーのニュースが存在するため削除できません。",
                                            type: "error",
                                            width: 350,
                                            height: 200,
                                            confirmButtonText: "閉じる",
                                            confirmButtonColor: "#FF5462",
                                            allowOutsideClick: false,
                                        });
                                    }
                                });
                        });
                    },

                    searchCategory(page) {
                        if (typeof page === 'undefined') {
                        page = 1;
                        }
                        var search_word = $("#search-item").val();
                        let fd = new FormData();
                        fd.append("search_word", search_word);
                        this.$loading(true);
                        $("html, body").animate({ scrollTop: 0 }, "slow");
                        this.axios.post("/api/category/search?page="+page, fd).then(response => {
                            this.$loading(false);
                            this.categories = response.data;
                            if (this.categories.data.length != 0) {
                                this.nosearch_msg = false;
                            }else {
                                this.nosearch_msg = true;
                            }
                        });
                        localStorage.setItem('category_page_no',page);//comment set to createcategory/updateCategory()

                    },
                    nextPaginate(num){
                        this.$loading(true);
                        this.axios.post("/api/category/search?page="+num).then(response => {
                            this.$loading(false);
                            this.categories = response.data;
                            if (this.categories.data.length != 0) {
                                this.nosearch_msg = false;
                            }else {
                                this.nosearch_msg = true;
                            }
                        });
                    },
            }
    };
</script>

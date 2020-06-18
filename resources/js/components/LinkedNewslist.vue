<template>
    <div id="ads_list">
        <div class="col-md-12  tab-content">
            <div class="p-2 p0-480">
                <div v-if="norecord_msg" class="card card-default card-wrap">
                    <p class="record-ico">
                        <i class="fa fa-exclamation"></i>
                    </p>                   
                    <p class="record-txt01">広告が登録されていません。</p>
                    <router-link to="/editnews" class="main-bg-color create-btn all-btn">
                        <i class="fas fa-plus-circle"></i> お知らせ・ニュース新規作成
                    </router-link>
                </div>
                <div v-else class="container-fuid">
                    <h4 class="main-color mb-3">ニュース・お知らせ</h4>
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <input type="text" class="form-control" placeholder="広告検索" id="search-item" @keyup="searchLinkedNewws()" />
                        </div>
                    </div>
                    <hr />
                    <div class="d-flex header pb-3 admin_header">
                        <h5>News</h5>
                        <div class="ml-auto" v-if="!norecord_msg">
                            <router-link to="/editnews" class="main-bg-color create-btn all-btn">
                                <i class="fas fa-plus-circle"></i> <span class="first_txt">広告</span><span class="dinone">新規作成</span>
                            </router-link>
                        </div>
                    </div>
                     
                    <!-- <div v-if="nosearch_msg" class="container-fuid no_search_data">新規作成するデタが消える。</div> -->

                    <div v-if="nosearch_msg" class="card card-default card-wrap">
                    <p class="record-ico">
                        <i class="fa fa-exclamation"></i>
                    </p>
                     <p class="record-txt01">データが見つかりません。</p>
                    </div>
                    
                    <div v-else class="container-fuid">
                        <table  class="table List_tbl">
                            <tr  v-for="news in news.data" :key="news.id">
                                <td class="p-3">
                                   <h5 class="font-weight-bold">{{news.post_date}}</h5>
                                </td>
                                <td class="p-3">
                                   <!-- <h5 class="font-weight-bold">{{news.type}}</h5> -->
                                    <span v-if="news.type == 1">介護施設検索</span>
                                    <span v-else-if="news.type == 2">病院検索</span>
                                    <span v-else>求人検索</span>
                                </td>
                                <td class="p-3">
                                    <span v-if="news.status == 1">ニュースリリース</span>
                                    <span v-else-if="news.status == 2">メディア掲載</span>
                                    <span v-else>お知らせ</span>
                                </td>
                                <td class="p-3 desc">
                                   <!-- <h5 class="font-weight-bold">{{news.description}}</h5> -->
                                   <p v-html="news.description"></p> 
                                </td>
                                <td class="p-3">
                                    <router-link :to="{path: '/editnews/'+news.id}" class="btn edit-borderbtn">編集</router-link>
                                    <button class="btn delete-borderbtn ml-2" @click="deleteLinkedNews(news.id)">削除</button>
                                </td>
                            </tr>
                        </table>
                        
                    </div>
                    <!-- <pagination :data="advertisements" @pagination-change-page="searchAdvertisment"></pagination> -->
                    <!-- <pagination :data="advertisements" @pagination-change-page="searchAdvertisment" :limit="limitpc">
                        <span slot="prev-nav"><i class="fas fa-angle-left"></i> 前へ</span>
                        <span slot="next-nav">次へ <i class="fas fa-angle-right"></i></span>
                    </pagination> -->
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
        data() {
                return {
                    news: [],
                    isOpen: false,
                    norecord: 0,
                    items: [],
                    norecord_msg: false,
                    nosearch_msg: false,
                };
            },
            created() {
                this.getNews();
            },
            methods: {
                // toggleModal() {
                //     this.isOpen = !this.isOpen;
                // },
                getNews(){
                    if(this.$route.params.status == 'update'){
                        var page_no = this.$route.params.page_no;
                        this.nextPaginate(page_no);
                    }else{
                        this.$loading(true);
                        this.axios.get("/api/news/news").then(response => {
                            this.$loading(false);
                            console.log(response.data);
                            this.news = response.data;
                            this.norecord = this.news.data.length;
                            if(this.norecord != 0) {
                                this.norecord_msg = false;
                            }else{
                                this.norecord_msg = true;
                            }
                        });
                    }
                },
                deleteLinkedNews(id) {
                        this.$swal({
                            // title: "確認",
                            text: "広告を削除してよろしいでしょうか。",
                            type: "warning",
                            width: 350,
                            height: 200,
                            showCancelButton: true,
                            confirmButtonColor: "#eea025 ",
                            cancelButtonColor: "#b1abab",
                            cancelButtonTextColor: "#000",
                            confirmButtonText: "はい",
                            cancelButtonText: "キャンセル",
                            confirmButtonClass: "all-btn",
                            cancelButtonClass: "all-btn",
                            allowOutsideClick: false,
                        }).then(response => {
                            this.axios.delete("/api/news/delete/"+id).then(response => {
                                this.news = response.data;
                                this.norecord = this.news.data.length;
                                if(this.norecord != 0) {
                                    this.norecord_msg = false;
                                }else{
                                    this.norecord_msg = true;
                                }
                                //alert("Delete Successfully!");
                                //   let a = this.advertisements.map(item => item.id).indexOf(id);
                                //   this.advertisements.splice(a, 1);
                                this.$swal({
                                    // title: "削除済",
                                    text: "広告を削除しました。",
                                    type: "success",
                                    width: 350,
                                    height: 200,
                                    confirmButtonText: "閉じる",
                                    confirmButtonColor: "#31cd38",
                                    allowOutsideClick: false,
                                });
                            });
                        })

                    },

                    searchLinkedNewws(page) {
                        if(typeof page === "undefined"){
                            page = 1;
                        }
                        var search_word = $("#search-item").val();
                        let fd = new FormData();
                        fd.append("search_word", search_word);
                        this.$loading(true);
                        $("html, body").animate({ scrollTop: 0 }, "slow");
                        this.axios.post("/api/news/search?page="+page, fd).then(response => {
                            this.$loading(false);
                            this.news = response.data;
                            if(this.news.data.length != 0){
                                this.nosearch_msg = false;
                            }else{
                                this.nosearch_msg = true;
                            }
                        });
                        localStorage.setItem('page_no',page);//set to editads/updateAds()
                    },
                    imgUrlAlt(event) {
                        event.target.src = "/images/noimage.jpg"
                    },

                nextPaginate(num){
                    
                    this.$loading(true);
                    $("html, body").animate({ scrollTop: 0 }, "slow");
                    this.axios.post("/api/news/search?page="+num).then(response => {
                            this.$loading(false);
                            this.news = response.data;
                            if(this.news.data.length != 0){
                                this.nosearch_msg = false;
                            }else{
                                this.nosearch_msg = true;
                            }
                        });
                }
                
            }
    }
</script>
<style>
.desc {
    max-width: 268px;
}
</style>

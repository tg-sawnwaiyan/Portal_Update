<template>
    <div id="ads_list">
        <div class="col-md-12  tab-content">
            <div class="p-2 p0-480">
                <div v-if="norecord_msg" class="card card-default card-wrap">
                    <p class="record-ico">
                        <i class="fa fa-exclamation"></i>
                    </p>                   
                    <p class="record-txt01">広告が登録されていません。</p>
                    <router-link to="/advertisement" class="main-bg-color create-btn all-btn">
                        <i class="fas fa-plus-circle"></i> 広告新規作成
                    </router-link>
                </div>
                <div v-else class="container-fuid">
                    <h4 class="main-color mb-3">広告検索</h4>
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <input type="text" class="form-control" placeholder="広告検索" id="search-item" @keyup="searchAdvertisment()" />
                        </div>
                    </div>
                    <hr />
                    <div class="d-flex header pb-3 admin_header">
                        <h5>広告一覧</h5>
                        <div class="ml-auto" v-if="!norecord_msg">
                            <router-link to="/advertisement" class="main-bg-color create-btn all-btn">
                                <i class="fas fa-plus-circle"></i> <span class="first_txt">広告</span><span class="dinone">新規作成</span>
                            </router-link>
                        </div>
                    </div>
                     
                    <div v-if="nosearch_msg" class="card card-default card-wrap">
                    <p class="record-ico">
                        <i class="fa fa-exclamation"></i>
                    </p>
                     <p class="record-txt01">データが見つかりません。</p>
                    </div>
                    
                    <div v-else class="container-fuid">
                        <table  class="table List_tbl">
                            <tr  v-for="ads in advertisements.data" :key="ads.id">
                                <td class="p-3">
                                    <div>
                                        <img :src="'/upload/advertisement/'+ ads.photo" class="img-fluid" alt="ads" @error="imgUrlAlt" />
                                    </div>
                                </td>
                                <td class="p-3">
                                    <h5 class="font-weight-bold">{{ads.title}}</h5>
                                    <div class="mt-4">
                                    <span class="card-title-rightwrapper model-7">                                                 
                                        <div class="checkbox">
                                            <input type='checkbox' :id="ads.id" v-if="ads.recordstatus == 1" @click="changeActivate(ads.id,ads.recordstatus)" checked/>
                                            <input type='checkbox' :id="ads.id" v-if="ads.recordstatus == 0" @click="changeActivate(ads.id,ads.recordstatus)"/>
                                            <label for="checkbox"></label>
                                            <div  class="on" v-if="ads.recordstatus == 1">公開中</div>
                                            <div class="on"  v-if="ads.recordstatus == 0">非公開</div>
                                        </div>                                                                                             
                                    </span>
                                    <div class="d-flex mt-4">
                                        <router-link :to="{path: '/editads/'+ads.id}" class="btn edit-borderbtn">編集</router-link>
                                        <button class="btn delete-borderbtn ml-2" @click="deleteAds(ads.id)">削除</button>
                                    </div>
                                    </div>
                                </td>
                            </tr>
                        </table>
                        
                    </div>
                    <pagination :data="advertisements" @pagination-change-page="searchAdvertisment" :limit="limitpc">
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
                default: 5
            },
        },
        data() {
                return {
                    advertisements: [],
                    isOpen: false,
                    norecord: 0,
                    items: [],
                    norecord_msg: false,
                    nosearch_msg: false,
                };
            },
            created() {
                this.getAds();
            },
            methods: {
                // toggleModal() {
                //     this.isOpen = !this.isOpen;
                // },
                getAds(){
                    if(this.$route.params.status == 'update'){
                        var page_no = this.$route.params.page_no;
                        this.nextPaginate(page_no);
                    }else{
                        this.$loading(true);
                        this.axios.get("/api/advertisement/ads").then(response => {
                            this.$loading(false);
                            this.advertisements = response.data;
                            this.norecord = this.advertisements.data.length;
                            if(this.norecord != 0) {
                                this.norecord_msg = false;
                            }else{
                                this.norecord_msg = true;
                            }
                        });
                    }
                },
                deleteAds(id) {
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
                            this.axios.delete(`/api/advertisement/delete/${id}`).then(response => {
                                this.advertisements = response.data;
                                this.norecord = this.advertisements.data.length;
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

                    searchAdvertisment(page) {
                        if(typeof page === "undefined"){
                            page = 1;
                        }
                        var search_word = $("#search-item").val();
                        let fd = new FormData();
                        fd.append("search_word", search_word);
                        this.$loading(true);
                        $("html, body").animate({ scrollTop: 0 }, "slow");
                        this.axios.post("/api/advertisement/search?page="+page, fd).then(response => {
                            this.$loading(false);
                            this.advertisements = response.data;
                            if(this.advertisements.data.length != 0){
                                this.nosearch_msg = false;
                            }else{
                                this.nosearch_msg = true;
                            }
                        });
                        localStorage.setItem('ads_page_no',page);//set to editads/updateAds()
                    },
                    imgUrlAlt(event) {
                        event.target.src = "/images/noimage.jpg"
                    },

                changeActivate(id, recordstatus){
                    if(recordstatus == 1)
                    {
                    this.activate_text = "広告を非公開にしてよろしいでしょうか。";
                    }
                    else{
                        this.activate_text = "広告を公開してよろしいでしょうか。";
                    }
                    this.$loading(true);
                    this.$swal({
                        allowOutsideClick: false,
                        text: this.activate_text,
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
                        cancelButtonClass: "all-btn"
                    }).then(response => {
                        this.axios.get("/api/advertisement/activate/"+id).then(response => {
                           
                                this.getAds();
                        });
                    
                    }).catch(error =>{

                        if(recordstatus == 1){
                            $("#"+id).prop("checked", true);
                        }else{
                            $("#"+id).prop("checked", false);
                        }
                        this.$loading(false);                
                    });
                    
                },
                nextPaginate(num){
                    
                    this.$loading(true);
                    $("html, body").animate({ scrollTop: 0 }, "slow");
                    this.axios.post("/api/advertisement/search?page="+num).then(response => {
                            this.$loading(false);
                            this.advertisements = response.data;
                            if(this.advertisements.data.length != 0){
                                this.nosearch_msg = false;
                            }else{
                                this.nosearch_msg = true;
                            }
                        });
                }
                
            }
    }
</script>

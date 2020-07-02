<template>
    <!-- Page Content  -->
    <div id="news_list">       
        <div class="col-12  tab-content">
            <div class="p-2 p0-480">                
                <div v-if="norecord_msg" class="card card-default card-wrap">
                    <p class="record-ico">
                        <i class="fa fa-exclamation"></i>
                    </p>
                    <p class="record-txt01">ニュースが登録されていません。</p>
                    <router-link to="/create_news" class="main-bg-color create-btn all-btn">
                        <i class="fas fa-plus-circle"></i>ニュース新規作成
                    </router-link>
                </div>
                <div v-else class="container-fuid">
                    <h4 class="main-color mb-3">ニュース検索</h4>
                    <div class="row mb-4">
                        <div class="col-12 col-sm-6">
                            <input type="text" class="form-control w-75 w-sm-100" placeholder="ニュース検索" id="search-item" @keyup="searchbyCategory()" />
                        </div>
                        <div class="col-12 col-sm-6">
                            <div class=" d-flex  justify-content-md-end align-items-center">
                            <label for="selectBox" class="select_label  mr-2">カテゴリー</label>
                            <select  id="selectBox" class="form-control select_box" @change="searchbyCategory()">
                                    <option selected="selected" value>全体</option>
                                    <option v-for="category in categories" :key="category.id" v-bind:value="category.id">{{category.name}}</option>
                                </select>
                            </div>
                            <div id="date_picker" class=" d-flex  justify-content-md-end align-items-center my-3" @click="changeCalendarHeader">
                                <label style="width:20%;">日付</label><br>
                                    <!-- added by maythirihtet -->
                                    <date-picker class="" @change="showDate"  :lang="en" valueType="format" v-model="select_date"  style="width:300px;" placeholder="日付を選択してください"></date-picker>
                                    <!-- added by maythirihtet -->
                            </div>
                            <div v-if="news_list.total !=0 && date_flag==false" class="">
                                <p class=" d-flex  justify-content-md-end align-items-center my-3" id="showTotal">検索結果：{{news_list.total}}件が該当しました</p>                                  
                            </div>
                            <div v-else-if="month_count !=0 && select_date!=''" class="">
                                <p class=" d-flex  justify-content-md-end align-items-center my-3" id="showTotal">{{month_count}}ニュースが登録されています</p>                                  
                            </div>
                            <div v-else-if="month_count ==0 && select_date!='' &&date_flag ==true" class="">
                                <p class=" d-flex  justify-content-md-end align-items-center my-3" id="showTotal">ニュースが登録されていません</p>                                  
                            </div>
                            <div v-else-if="news_list.total !=0 && date_flag==true" class="">
                                <p class=" d-flex  justify-content-md-end align-items-center my-3" id="showTotal">検索結果：{{news_list.total}}件が該当しました</p>                                  
                            </div>
                        </div>
                    </div>
                    <hr />
                    <div class="d-flex header pb-3 admin_header">
                        <h5>ニュース一覧</h5>
                        <div class="ml-auto" v-if="!norecord_msg">
                            <router-link to="/create_news" class="main-bg-color create-btn all-btn">
                                <i class="fas fa-plus-circle"></i> <span class="first_txt">ニュース</span><span class="dinone">新規作成</span>
                            </router-link>
                        </div>
                    </div>
                    
                    <!-- <div v-if="nosearch_msg" class="container-fuid no_search_data">データが見つかりません。</div> -->

                    <div v-if="nosearch_msg" class="card card-default card-wrap">
                    <p class="record-ico">
                        <i class="fa fa-exclamation"></i>
                    </p>
                     <p class="record-txt01">データが見つかりません。</p>
                </div> 

                    <div v-else class="container-fuid">
                        <table class="table List_tbl">
                            <tr v-for="newsList in news_list.data" :key="newsList.id">
                                <td class="p-3">
                                    <div v-if="newsList.photo !=null">
                                        <img :src="'/upload/news/'+ newsList.photo"   @error="imgUrlAlt" />
                            
                                    </div>
                                    <div  v-else> <img src="/images/noimage.jpg" alt  /></div>
                                </td>
                                <td class="p-3">                             
                                    <!--posting period-->
                                    <div class="row col-12 posting-per justify-content-end m-b-10 pc-414">
                                  
                                     <!-- <div class="set-date"  v-if="newsList.cat_name != 'PR'" >
                                            <p :class="'title'+ newsList.category_id ">
                                            <span> {{newsList.cat_name}}</span>
                                            <small style="color:#aaa;" >
                                            <i class="fa fa-calendar-alt"></i>
                                            &nbsp;&nbsp;{{newsList.created_at}}
                                            </small>
                                            </p>   
                                    </div> -->
                                <table class="table table-borderless text-right m-b-0 posting-per cmt">
                                        <tr v-if="newsList.cat_name != 'PR'">
                                            <!-- <td>
                                                 <th :class="'title'+ newsList.category_id " style="float:right;">
                                                    <span> {{newsList.cat_name}}</span> 
                                                </th> 
                                            </td> -->
                                            <td style="width:auto;">
                                                <th :class="'title'+(5-(Math.floor(newsList.category_id%5)))">
                                                    <span> {{newsList.cat_name}}</span>
                                                    <i class="fa fa-calendar-alt"></i>&nbsp;
                                                    {{newsList.created_at}}                                                    
                                                </th>    
                                                                                        
                                            </td>
                                            
                                        </tr>
                                    </table>

                                   
                                    <table class="table table-borderless text-right m-b-0 posting-per cmt" >
                                        <tr v-if="newsList.category_id == 26 && (newsList.to_date == null || newsList.to_date == '')">
                                            <td>
                                                <th>
                                                    <span v-if="newsList.category_id == 26" class="breaking-tip">PR</span>
                                                    <span><i class="fa fa-calendar-alt common-fa"></i></span>
                                                </th>
                                                <th>
                                                    {{newsList.from_date}} 
                                                </th>
                                                <th>
                                                    ~
                                                </th>
                                                
                                            </td>
                                        </tr>
                                        <tr v-else>
                                            <td v-if="newsList.category_id == 26">
                                                <th>
                                                    <span v-if="newsList.category_id == 26" class="breaking-tip">PR</span>
                                                    <span><i class="fa fa-calendar-alt common-fa"></i></span>
                                                </th>
                                                <th>
                                                    {{newsList.from_date}}
                                                </th>
                                                <th>
                                                    ~
                                                </th>
                                                <th>
                                                     <span>{{newsList.to_date}}</span>
                                                </th>
                                                
                                               
                                            </td>
                                        </tr>
                                    </table>
                                    </div>
                                    <!--posting period-->

                                    <div class="sp-414 m-b-10">
                                        <div class="set-date posting-per"  v-if="newsList.cat_name != 'PR'" style="text-indent: 0em;float:none;">
                                            <div :class="'title'+ newsList.category_id ">
                                            <span class="m-b-2"> {{newsList.cat_name}}</span>                                         
                                            <i class="fa fa-calendar-alt common-fa"></i>&nbsp;
                                            {{newsList.created_at}}                                           
                                            </div>   
                                        </div>

                                    <div class="row col-12 p-0 m-0 posting-per" v-if="newsList.category_id == 26 && (newsList.to_date == null || newsList.to_date == '')"> 
                                            <span v-if="newsList.category_id == 26" class="breaking-tip">PR</span>                                           
                                            <div class="posting-firstwrap"> 
                                                <span>&nbsp;<i class="fa fa-calendar-alt common-fa"></i></span>                                              
                                                <span>{{newsList.from_date}} ~ </span>
                                            </div>           
                                              <div class="posting-secondwrap">
                                              </div>                                                                           
                                    </div>

                                    <div v-else>   
                                        <div class="row m-0 posting-per" v-if="newsList.category_id == 26"> 
                                            <span v-if="newsList.category_id == 26" class="breaking-tip">PR</span>                                    
                                            <div class="p-0 posting-firstwrap">
                                                <span>&nbsp;<i class="fa fa-calendar-alt common-fa"></i></span>
                                                <span>{{newsList.from_date}} ~</span>
                                            </div>
                                            <div class="posting-secondwrap">
                                                <span>{{newsList.to_date}}</span>
                                            </div>
                                        </div>
                                        
                                    </div>
                                    </div>
                                                                        
                                     <h5 class="align-middle">
                                        <router-link
                                            :to="{path: '/newsdetails/'+newsList.id}"
                                            class="pseudolink"
                                        >{{newsList.title}}</router-link>
                                    </h5>                                   
                                    <p class="mt-4">{{newsList.main_point}}</p>
                                     <div class="card-title-rightwrapper model-7 mt-2">                                                 
                                        <div class="checkbox">
                                            <input type='checkbox' :id="newsList.id" v-if="newsList.recordstatus == 1" @click="changeActivate(newsList.category_id,newsList.id,newsList.recordstatus)" checked/>
                                            <input type='checkbox' :id="newsList.id" v-if="newsList.recordstatus == 0" @click="changeActivate(newsList.category_id,newsList.id,newsList.recordstatus)"  />
                                            <label for="checkbox"></label>
                                            <div  v-if="newsList.recordstatus == 1" class="on">公開中</div>
                                            <div v-if="newsList.recordstatus == 0" class="on">非公開</div>
                                        </div>                                                                                             
                                    </div>
                                    <div class="d-flex mt-4">
                                        <router-link :to="{ path:'/editPost/'+ newsList.id}" class="btn edit-borderbtn">編集</router-link>
                                        <button class="btn delete-borderbtn ml-2" @click="deletePost(newsList.category_id,newsList.id)">削除</button>
                                    </div>
                                </td>
                            </tr>
                        </table>
                        <!-- <pagination :data="news_list" @pagination-change-page="searchbyCategory"></pagination> -->
                         <div>
                              <pagination :data="news_list" @pagination-change-page="searchbyCategory" :limit="limitpc">
                                <span slot="prev-nav"><i class="fas fa-angle-left"></i> 前へ</span>
                                <span slot="next-nav">次へ <i class="fas fa-angle-right"></i></span>
                            </pagination>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <!-- Page Content end  -->
</template>

<script>
    export default {
        components: {
        },
        props:{        
            limitpc: {
                type: Number,
                default: 5
            },
        },

        data() {
            return {
                news_list: [],
                norecord: 0,
                norecord_msg: false,
                nosearch_msg: false,
                categories: {
                    id: "",
                    name: ""
                },
                isOpen: false,
                items: [],
                pagination: false,
                activate_text: '',
                select_date:null,
                month_count:0,
                date_flag:false,
            };
        },
        created() {
            this.$loading(true);
            this.getResults();

        },
        methods: {
            /** added by maythirihtet */
            changeCalendarHeader(){

                $('div.mx-calendar-content table thead tr th:nth-child(2)').text('月');
                $('div.mx-calendar-content table thead tr th:nth-child(3)').text('火');
                $('div.mx-calendar-content table thead tr th:nth-child(4)').text('水');
                $('div.mx-calendar-content table thead tr th:nth-child(5)').text('木');
                $('div.mx-calendar-content table thead tr th:nth-child(6)').text('金');
                $('div.mx-calendar-content table thead tr th:nth-child(7)').text('土');

            },
            showDate (select_date) {
                this.select_date = select_date;
                this.date_flag = true;
                let fd = new FormData();
                fd.append("select_date", select_date);
                
                this.axios.post("/api/new/getNewsCountByMonth", fd).then(response => {
                    this.month_count = response.data;
                    console.log(this.month_count);
                });

            },
            /** end of added by maythirihtet */
            changeActivate(catid,id,activate, $event){
                
                if(activate == 1)
                {                    
                    this.activate_text = (catid == 26? "PR":"ニュース") +"を非公開にしてよろしいでしょうか。";
                }
                else{
                    this.activate_text = (catid == 26? "PR":"ニュース") +"を公開してよろしいでしょうか。";
                }
            
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
                    this.axios.get(`/api/changeRecordstatus/${id}`)
                        .then(response => {
                            this.getResults();
                    });
                
                }).catch(error =>{
                    if(activate == 1){
                        $("#"+id).prop("checked", true);
                    }else{
                        $("#"+id).prop("checked", false);
                    }                
                });
            },
            getResults() {
                this.$http.get('/api/news_list')
                .then(response => {

                    this.news_list = response.data.news;
                    this.categories = response.data.category;
                    this.norecord = this.news_list.data.length                       
                    // if(this.norecord > this.size) {
                    //     this.pagination = true;
                    // } else {
                    //     this.pagination = false;
                    // }
                    if(this.norecord != 0){
                        this.norecord_msg = false;
                    }else{
                        this.norecord_msg = true;
                    }
                    this.$loading(false);

                    if(this.$route.params.status == 'update'){
                        var page_no = this.$route.params.page_no;
                        this.nextPaginate(page_no);
                    }
                });
                    
            },

            deletePost(catid,id) {
                   var selected_category = document.getElementById("selectBox").value;
                   if(selected_category == null || selected_category == '')
                   {
                       selected_category = 0;
                   }
              
                    this.$swal({
                        // title: "確認",
                        text: (catid == 26? "PR":"ニュース") +"を削除してよろしいでしょうか。",
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
                        this.axios
                            .delete(`/api/new/delete/${id}`+'/'+selected_category)
                            .then(response => {
                                this.news_list = response.data;

                                this.norecord = this.news_list.length;
                                // if (this.norecord > this.size) {
                                //     this.pagination = true;
                                // } else {
                                //     this.pagination = false;
                                // }
                                if(this.norecord != 0){
                                    this.norecord_msg = false;
                                }else{
                                    this.norecord_msg = true;
                                }
                                 this.$loading(false);

                                this.$swal({
                                    text: "ニュースを削除しました。",
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
                searchbyCategory(page) {

                    if (typeof page === 'undefined') {
                        page = 1;
                    }
                    var search_word = $("#search-item").val();

                    var selected_category = document.getElementById("selectBox").value;
                    let fd = new FormData();
                    fd.append("search_word", search_word);
                    fd.append("selected_category", selected_category);
                    fd.append("postid",null);
                    this.$loading(true);
                    $("html, body").animate({ scrollTop: 0 }, "slow");
                    this.axios.post("/api/news_list/search?page="+page, fd).then(response => {
                        this.$loading(false);
                        this.news_list = response.data;
                        this.norecord = this.news_list.data.length;
                        // if(this.news_list.length > this.size){
                        //     this.pagination = true;
                        // }else{
                        //     this.pagination = false;
                        // }
                        if(this.norecord != 0) {
                            this.nosearch_msg = false;
                        }else{
                            this.nosearch_msg = true;
                        }
                        localStorage.setItem('page_no',page);//set to editNewsPost.vue/updatepost()
                    });
                },
                nextPaginate(num){
                     
                    let fd = new FormData();
                    fd.append("postid",null);
                    this.$loading(true);
                    this.axios.post("/api/news_list/search?page="+num, fd).then(response => {
                        this.$loading(false);
                        this.news_list = response.data;

                        this.norecord = this.news_list.data.length;
                       
                        if(this.norecord != 0) {
                            this.nosearch_msg = false;
                        }else{
                            this.nosearch_msg = true;
                        }
                    });
                },
                imgUrlAlt(event) {
                    event.target.src = "/images/noimage.jpg"
                },
        }
    };
</script>

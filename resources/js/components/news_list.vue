<template>
    <!-- Page Content  -->
    <div id="news_list">       
        <div class="col-12 tab-content">
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
                            <div>
                            <input type="text" class="form-control w-75 w-sm-100" placeholder="ニュース検索" id="search-item" @keyup="searchbyCategory()" />
                            </div>
                            <div class="my-3 chk_div">
                            <input type="checkbox" id="title" value="title" name="contents" @change="searchbyCategory()"><label class="chk_label">題名</label>
                            <input type="checkbox" id="main_point" value="main_point" name="contents" @change="searchbyCategory()"><label class="chk_label01">内容要約</label>
                            <input type="checkbox" id="body" value="body" name="contents" @change="searchbyCategory()"><label class="chk_label">内容</label>
                            <input type="checkbox" id="body" value="created_by_company" name="contents" @change="searchbyCategory()"><label class="chk_label02">記者名・通信社名等</label>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6">
                            <div class=" d-flex  justify-content-md-end align-items-center">
                                <label for="selectBox" class="select_label  mr-2">カテゴリー</label>
                                <select  id="selectBox" class="form-control select_box" @change="searchbyCategory()">
                                    <option selected="selected" value>全体</option>
                                    <option v-for="category in categories" :key="category.id" v-bind:value="category.id">{{category.name}}</option>
                                </select>
                            </div>

                            <!-- smart news -->
                            <div class=" d-flex  justify-content-md-end align-items-center my-3">
                                <label for="smartnew" class="select_label  mr-2">SmartNews掲載</label>
                                <select  id="smartnew" class="form-control select_box" @change="searchbyCategory()">
                                    <option selected="selected" value>指定なし</option>
                                    <option v-bind:value="1">揭載</option>
                                    <option v-bind:value="0">非揭載</option>
                                </select>
                            </div>

                            <div id="date_picker" @click="changeCalendarHeader" class=" d-flex  justify-content-md-end align-items-center my-3">
                                <label class="width-20">日付</label><br>
                                <input type="hidden" id="hidden_select_date" v-bind:value="select_date">
                                <date-picker @change="showDate" class="width-65" :lang="lang" v-model="select_date" valueType="format" placeholder="日付を選択してください"></date-picker>
                            </div>
                            <div v-if="news_list.total" class="">
                                <p class=" d-flex  justify-content-md-end align-items-center my-3" id="showTotal">検索結果：{{news_list.total}}件が該当しました</p>                                  
                            </div>
                            <div v-else class="">
                                <p class=" d-flex  justify-content-md-end align-items-center my-3" id="showTotal">検索条件当てはまるデータはありません</p>                                  
                            </div>
                            <!-- end of linked news -->
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
                                        <table class="table table-borderless text-right m-b-0 posting-per cmt">
                                            <tr v-if="newsList.cat_name != 'PR'">
                                                <td class="width-auto">
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
                                        <div class="set-date posting-per posting-period"  v-if="newsList.cat_name != 'PR'">
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
                                        <div class="checkbox">
                                            <input type='checkbox' :id="newsList.id" v-if="newsList.smartnew == 1" @click="smartActive(newsList.category_id,newsList.id,newsList.smartnew)" checked/>
                                            <input type='checkbox' :id="newsList.id" v-if="newsList.smartnew == 0" @click="smartActive(newsList.category_id,newsList.id,newsList.smartnew)"  />
                                            <label for="checkbox"></label>
                                            <div  v-if="newsList.smartnew == 1" class="on">SmartNewsに掲載する</div>
                                            <div v-if="newsList.smartnew == 0" class="on">SmartNewsに掲載しない</div>
                                        </div>                                                                                             
                                    </div>
                                    <div class="d-flex mt-4">
                                        <router-link :to="{ path:'/editPost/'+ newsList.id}" class="btn edit-borderbtn">編集</router-link>
                                        <button class="btn delete-borderbtn ml-2" @click="deletePost(newsList.id)">削除</button>
                                    </div>
                                </td>
                            </tr>
                        </table>
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
                page: 1,
            };
        },
        created() {
            this.$loading(true);
            this.getResults();
        },
        methods: {
            /** linked news */
            changeCalendarHeader(){
                $('div.mx-calendar-content table thead tr th:nth-child(2)').text('月');
                $('div.mx-calendar-content table thead tr th:nth-child(3)').text('火');
                $('div.mx-calendar-content table thead tr th:nth-child(4)').text('水');
                $('div.mx-calendar-content table thead tr th:nth-child(5)').text('木');
                $('div.mx-calendar-content table thead tr th:nth-child(6)').text('金');
                $('div.mx-calendar-content table thead tr th:nth-child(7)').text('土');
            },            
            /** end of linked news */
            changeActivate(catid,id,activate){                
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
                        this.searchbyCategory(this.page);
                    });                
                }).catch(error =>{
                    if(activate == 1){
                        $("#"+id).prop("checked", true);
                    }else{
                        $("#"+id).prop("checked", false);
                    }                
                });
            },
            smartActive(catid,postid,smartnew){                
                if(smartnew == 1)
                {                    
                    this.smartnew_text = (catid == 26? "PR":"ニュース") +"をSmartNewsに掲載しないでしょうか";
                }
                else{
                    this.smartnew_text = (catid == 26? "PR":"ニュース") +"をSmartNewsに掲載してよろしいでしょうか。";
                }            
                this.$swal({
                    allowOutsideClick: false,
                    text: this.smartnew_text,
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
                    this.axios.get(`/api/changeSmartStatus/${postid}`)
                    .then(response => {
                        this.searchbyCategory(this.page);
                    });                
                }).catch(error =>{
                    if(activate == 1){
                        $("#"+postid).prop("checked", true);
                    }else{
                        $("#"+postid).prop("checked", false);
                    }                
                });
            },
            getResults() {
                this.$http.get('/api/news_list')
                .then(response => {
                    this.news_list = response.data.news;
                    this.categories = response.data.category;
                    this.norecord = this.news_list.data.length                       
                    
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
            deletePost(id) {
                if(this.norecord == 1){
                        this.page = this.page > 1 ? this.page-1 : this.page;
                }
                var catid = document.getElementById("selectBox").value;

                this.$swal({

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
                    .delete(`/api/new/delete/${id}`)
                    .then(response => {
                        
                        
                        this.searchbyCategory(this.page);
                        this.$loading(false);
                        this.$swal({
                            text: (catid == 26? "PR":"ニュース") +"を削除しました。",
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
                var contents = [];
                $.each($("input[name='contents']:checked"), function(){
                contents.push($(this).val());
                });
                
                var search_word = $("#search-item").val();
                var selected_category = document.getElementById("selectBox").value; 
                var smartnew = document.getElementById("smartnew").value;       

                let fd = new FormData();
                fd.append("search_word", search_word);
                fd.append("selected_category", selected_category);
                fd.append("smartnew", smartnew);
                fd.append("contents", contents);
                if(this.select_date != null){
                    fd.append("selected_date", this.select_date);//linked news
                }
                fd.append("postid",null);
                this.$loading(true);
                $("html, body").animate({ scrollTop: 0 }, "slow");
                this.axios.post("/api/news_list/search?page="+page, fd).then(response => {
                    this.$loading(false);
                    this.news_list = response.data.query;
                    this.norecord = response.data.postCount;
    
                    if(this.norecord != 0) {
                        this.nosearch_msg = false;
                    }else{
                        this.nosearch_msg = true;
                    }
                    this.page = page;
                    
                });
            },
            /** linked news */
            showDate(select_date){
                this.select_date = select_date;
                this.searchbyCategory();
            },
            /** end of linked news */
            nextPaginate(num){                     
                let fd = new FormData();
                fd.append("postid",null);
                this.$loading(true);
                this.axios.post("/api/news_list/search?page="+num, fd).then(response => {
                    this.$loading(false);
                    this.news_list = response.data.query;
                    this.norecord = response.data.postCount;
                    
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
<style>
.width-20 {
    width: 20% !important;
}
.width-65 {	
    width: 65%;	
}
.width-auto {
    width: auto !important;
}
.posting-period {
    text-indent: 0em !important;
    float:none !important;
}
.chk_label {
    padding-left: 5px;
    width: 9% !important;
}
.chk_label01 {
    padding-left: 5px;
    width: 15% !important;
}
.chk_label02 {
    padding-left: 5px;
}
.chk_div {
    padding-top: 5px;
}
</style>
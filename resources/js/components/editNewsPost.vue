<template>
    <!-- Page Content  -->
    <div id="news_post">
        <div class="card">
            <div class="card-body">
                <div v-if='status == 1'>
                    <h4 class="page-header header">ニュース編集</h4>
                </div>
                <div v-else>
                    <h4 class="page-header header">ニュース新規作成</h4>
                </div>
                <form @submit.prevent="updatepost" autocomplete="off">
                    <div class="form-group">
                        <label>題名 <span class="error sp2">必須</span></label>
                        <input type="text" autocomplete="off" class="form-control" placeholder="題名を入力してください。" v-model="news.title">
                        <span v-if="errors.title" class="error">{{errors.title}}</span>
                    </div>
                    <div class="form-group">
                        <label>記者名・通信社名等 </label>
                        <input type="text" autocomplete="off" class="form-control" placeholder="記者名を入力してください。" v-model="news.created_by_company">
                    </div>
                    <div class="form-group">
                        <label>プロフィル</label>
                        <input type="text" autocomplete="off" class="form-control" placeholder="プロフィルを入力してください。" v-model="news.created_by">
                    </div>
                    <div class="form-group" id="showimage">
                        <label class="">写真</label>
                        <div class="d-flex align-items-center">
                            <span class="btn-file d-inline-block">画像を選択        
                                <input type="file" ref="file" accept="image/*" @change="fileSelected">
                            </span> 
                            <span class="pl-4">{{img_name}}</span>
                        </div>
                    </div>
                    <div class="image_show" v-if="upload_img ">
                        <div class='col-md-2'>
                            <img :src="upload_img" class='show-img' @error="imgUrlAlt">
                        </div>
                    </div>  
                    <div  class="form-group image_update" id="x-image" v-if ="noimage == 0 && news.photo && !upload_img && !old_photo">
                        <div class="col-md-12" >
                            <div id='x-image' class='col-md-2' >
                                <span class='img-close-btn' v-on:click='closeBtnMethod(news.photo)'>X</span>
                                <img :src="'/upload/news/'+ news.photo" class='show-img' alt="" @error="imgUrlAlt1">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>内容要約 <span class="error sp2">必須</span></label>
                        <input type="text" autocomplete="off" class="form-control" placeholder="ニュースの内容要約を入力してください。" v-model="news.main_point">
                        <span v-if="errors.main_point" class="error">{{errors.main_point}}</span>
                    </div>
                    <div class="form-group">
                        <label>カテゴリー <span class="error sp2">必須</span></label>
                            <select v-model="selectedValue" class="form-control" @change='getstates()'>
                                <option v-bind:value="0">選択してください。</option>
                                <option v-for="category in categories" :key="category.id" v-bind:value="category.id">
                                    {{category.name}}
                                </option>
                            </select>
                        <span v-if="errors.category_id" class="error">{{errors.category_id}}</span>
                    </div>
                    <div class="form-group">
                        <label>ブロック</label>
                            <select v-model="block_id" class="form-control" @change='getblock()'>
                                <option v-bind:value="0">選択してください。</option>
                                <option v-bind:value="1">大きなブロック</option>
                                <option v-bind:value="2">中型ブロック</option>
                                <option v-bind:value="3">小さなブロックサイズ</option>
                            </select>
                    </div>
                    <div v-if="selectedValue == 26" class="form-group">
                        <div class="row">
                            <div class="col-12 col-sm-4 col-md-4">
                                <label>掲載開始日 <span class="error sp2">必須</span></label>
                                <date-picker class="" :lang="lang"  valueType="format" v-model="news.from_date" style="width:100%"></date-picker>
                                <span v-if="errors.from_date" class="error">{{errors.from_date}}</span>
                            </div>
                             <div class="col-12 col-sm-4 col-md-4 mt-567-10">
                                <label>掲載終了日 </label>
                                <date-picker class=""  :lang="lang" valueType="format" v-model="news.to_date"  style="width:100%"></date-picker>
                            </div>
                        </div>
                        <span v-if="errors.date_check" class="error">{{errors.date_check}}</span>
                    </div>
                    <div class="form-group bd-form">
                        <label>内容 <span class="error sp2">必須</span></label>
                        <quill-editor  ref="myQuilEditor" id="exampleFormControlTextarea1" class="rounded-0" placeholder="内容を入力してください。"  @change="onDetailInfoEditorChange($event)" v-model="news.body" :options="editorOption" @blur="onEditorBlur($event)" @focus="onEditorFocus($event)"/>
                        <span v-if="errors.body" class="error">{{errors.body}}</span>
                    </div>
                    <div v-if="selectedValue != 26" class="form-group">
                        <label>関連ニュース</label>
                        <div class="card related-card">
                            <div class="card-body">
                                <input type="hidden" v-model="old_photo" >
                                <input type="hidden" v-model="old_quill_photo" >
                                <div class="d-sm-flex">
                                    <div class="d-flex align-items-center cat_box">
                                        <label class="cat_lbl"> カテゴリー</label>
                                        <select v-model="category_id_1" id="categories" class="form-control cat_select" @change='getPostsByCatId()'>
                                            <option v-for="category in prcategories" :key="category.id" v-bind:value="category.id">
                                                {{category.name}}
                                            </option>
                                        </select>
                                    </div>
                                    <div class="search_box">
                                        <input type="text" autocomplete="off" placeholder="関連ニュース検索" aria-label="search" id="search-word" class="form-control form_search" v-model="search_word"  @keyup='getSearchPostsByCatId()'>
                                    </div>
                                </div>
                                <br>
                                <div class="row m-0">
                                    <div class="related_post_box card card-default" v-for="r_news in related_news.data" :key="r_news.id">
                                        <div class="card-body">
                                            <label class="form-check-label control control--checkbox">
                                                <input type="checkbox" :value="r_news.id" id="aaa" v-model="checkedNews">
                                                <div id="create_news" class="create_news">
                                                    <p>
                                                        <img :src="'/upload/news/'+ r_news.photo" class="float-left m-r-10" alt="news" @error="imgUrlAlt">
                                                        {{r_news.title}}
                                                    </p>
                                                </div>
                                                <div class="control__indicator"></div>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div v-if="nosearch_msg" class="card card-default card-wrap noseaech_msg">
                                    <p class="record-ico">
                                        <i class="fa fa-exclamation"></i>
                                    </p>
                                    <p class="record-txt01">データが見つかりません。</p>
                                </div> 
                                <div>
                                    <pagination :data="related_news" @pagination-change-page="getSearchPostsByCatId" :limit="limitpc" class="mt-3">
                                        <span slot="prev-nav"><i class="fas fa-angle-left"></i> 前へ</span>
                                        <span slot="next-nav">次へ <i class="fas fa-angle-right"></i></span>
                                    </pagination>
                                </div>
                                <input type="hidden" v-model="checkedNews" >
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <span @click="$router.go(-1)" :to="{name: 'news_list'}" class="btn bt-red all-btn">キャンセル</span>
                        <span class="btn main-bg-color white all-btn" @click="checkValidate()" v-if='status == 1'> 保存</span>
                        <span class="btn main-bg-color white all-btn" @click="checkValidate()" v-if='status == 0'> 作成</span>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>
<script>
import 'quill/dist/quill.snow.css'
import {quillEditor} from 'vue-quill-editor'
    export default {
        components: {
            quillEditor
        },
        props:{
            limitpc: {
                type: Number,
                default: 5
            },
        },
        data() {
            return {
                lang:{
                    days: ['日', '月', '火', '水', '木', '金', '土'],
                    months: ['1月', '2月', '3月', '4月', '5月', '6月', '7月', '8月', '9月', '10月', '11月', '12月'],
                    placeholder: {
                    date: '年 - 月 - 日',
                    }
                },
                selectedValue: 0,
                block_id: 0,
                status:0,
                errors: {
                    title: "",
                    main_point: "",
                    body: "",
                    category_id: "",
                    from_date: "",
                    date_check: "",
                },
                editorOption:{
                    debug:'info',
                    placeholder:'',
                    readonly:true,
                    theme:'snow',
                    modules: {
                        toolbar: [
                        ['bold', 'italic', 'underline', 'strike'],
                        ['blockquote', 'code-block'],
                        [{ 'header': 1 }, { 'header': 2 }],
                        [{ 'list': 'ordered' }, { 'list': 'bullet' }],
                        [{ 'script': 'sub' }, { 'script': 'super' }],
                        [{ 'indent': '-1' }, { 'indent': '+1' }],
                        [{ 'direction': 'rtl' }],
                        [{ 'color': [] }, { 'background': [] }],
                        [{ 'align': [] }],
                        ['clean'],
                        ['link', 'image', 'video']
                        ]
                    },
                    access_val: '',
                    detail_info: '', stations:[], station_list:[],
                },
                news: {
                    title: '',
                    body: '',
                    category_id: '',
                    block_id:'',
                    related_news: '',
                    photo: '',
                    from_date:'',
                    to_date:'',
                    created_by:'',
                    created_by_company:'',
                },
                categories: {
                    id: '',
                    name: ''
                },
                prcategories:{
                    id:'',
                    name:''
                },
                category_id_1: '1',
                related_news: [],
                checkedNews: [],
                old_photo: "",
                old_quill_photo: "",
                upload_img: null,
                currentPage: 0,
                size: 12,
                pageRange: 5,
                items: [],
                pagination: false,
                search_word:'',
                img_name : '',
                noimage:0,
                nosearch_msg:false,
            }
        },
        created() {
            this.noimage = 0;
            this.getResults();
        }, 
        mounted() {
            this.axios.get('/api/category/category_list')
            .then(function(response) {
                this.categories = response.data.categories;
                this.prcategories = response.data.prcategories;
            }.bind(this));
        },
        methods: { 
            getResults() { 
                if(this.$route.name == "editPost"){
                    this.status = 1;
                    this.axios
                    .get(`/api/new/editPost/${this.$route.params.id}`)
                    .then((response) => {
                        this.news = response.data;
                    
                        if(this.news.to_date == null)
                        {
                            this.news.to_date = '';
                        }
                       this.noimage = 0;
                        this.checkedNews = [];
                        if(this.news.related_news != undefined){
                            this.checkedNews = this.news.related_news.split(',');
                        }
                        else{
                            this.checkedNews = [];
                        }
                        if(this.news.photo == null || this.news.photo == '') {
                            this.old_photo = '';
                        }
                        this.selectedValue = this.news.category_id;
                        this.block_id = this.news.block_id ? this.news.block_id : 0;
                    });
                    this.getPostsByCatId();
                    this.getSearchPostsByCatId();
                } 
                else {
                    this.getPostsByCatId();
                }
            },
            fileSelected(e) {
                this.news.photo = event.target.files[0];
                this.upload_img = URL.createObjectURL(event.target.files[0]);
                const file =event.target.files[0];
                this.img_name = file.name;
            },
            reset() {
                const input = this.$refs.file;
                input.type = 'text';
                input.type = 'file';
            },
            onDetailInfoEditorChange({ editor, html, text }) {
                this.news['body'] = html
            },
            updatepost() {
                this.$swal({
                    text: "ニュースを更新してよろしいでしょうか。",
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
                    let fData = new FormData();
                    if(this.news.category_id != 26 )
                    {
                        this.news.from_date = null;
                        this.news.to_date = null;
                    }
                    fData.append('photo', this.news.photo)
                    fData.append('from_date', this.news.from_date)
                    fData.append('to_date', this.news.to_date)
                    fData.append('title', this.news.title)
                    fData.append('created_by', this.news.created_by)
                    fData.append('created_by_company', this.news.created_by_company)
                    fData.append('main_point', this.news.main_point)
                    fData.append('body', this.news.body)
                    fData.append('category_id', this.news.category_id)
                    fData.append('block_id', this.news.block_id)
                    fData.append('related_news', this.checkedNews)
                    fData.append('old_photo',this.old_photo)
                    fData.append('old_quill_photo',this.old_quill_photo)
                    this.$loading(true);
                    this.axios.post(`/api/new/update/${this.$route.params.id}`, fData).then(response => {
                        this.$loading(false);
                        this.$swal({
                            position: 'top-end',
                            type: 'success',
                            text: 'ニュースを更新しました。',
                            confirmButtonText: "閉じる",
                            confirmButtonColor: "#31cd38",
                            width: 350,
                            height: 200,
                            allowOutsideClick: false,                                   
                        })
                        var num = localStorage.getItem('page_no');
                        this.$router.push({ name: 'news_list', params: { status: 'update','page_no':num } })
                    })
                    .catch(error=>{
                        if(error.response.status == 422){
                            this.errors = error.response.data.errors
                        }
                    });
                });
            },
            add() {
                this.$swal({
                text: "ニュースを投稿してよろしいでしょうか。",
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
                    let fData = new FormData();
                    fData.append('photo', this.news.photo)
                    fData.append('from_date', this.news.from_date)
                    fData.append('to_date', this.news.to_date)
                    fData.append('title', this.news.title)
                    fData.append('created_by', this.news.created_by)
                    fData.append('created_by_company', this.news.created_by_company)
                    fData.append('main_point', this.news.main_point)
                    fData.append('body', this.news.body)
                    fData.append('category_id', this.news.category_id)
                    fData.append('block_id', this.news.block_id)
                    fData.append('related_news', this.checkedNews)
                    this.$loading(true);
                    this.axios.post('/api/new/add', fData)
                    .then(response => {
                    this.$loading(false);
                    this.name = ''
                    this.$swal({
                        position: 'top-end',
                        type: 'success',
                        text: 'ニュースを投稿しました。',
                        confirmButtonText: "閉じる",
                        confirmButtonColor: "#31cd38",
                        width: 350,
                        height: 200,
                        allowOutsideClick: false,
                    })
                    this.$router.push({  name: 'news_list'})
                    }).catch(error=>{
                        if(error.response.status == 422){
                            this.errors = error.response.data.errors
                        }
                    });
                })
            },
            getstates: function() {
                this.news.category_id = this.selectedValue;
                this.news.from_date = '';
                this.news.to_date = '';
            },
            getblock: function() {
                this.news.block_id = this.block_id;
            },
            getPostsByCatId: function(page) {
                if (typeof page === 'undefined') {
                    page = 1;
                }
                var cat_id = this.category_id_1;
                let fd = new FormData();
                fd.append("cat_id", cat_id);
                fd.append("search_word",this.search_word);
                this.axios
                .post('/api/new/getPostsByCatId/page=' + page+"/"+`${this.$route.params.id}`,fd)
                .then(response => {
                    this.related_news = response.data;
                    this.norecord = this.related_news.data.length;
                    if(this.norecord != 0) {
                        this.nosearch_msg = false;
                    }else{
                        this.nosearch_msg = true;
                    }
                    if(this.related_news.length > this.size) {
                        this.pagination = true;
                    }else{
                        this.pagination = false;
                    }
                });
            },
            getSearchPostsByCatId(page) {
                if (typeof page === 'undefined') {
                    page = 1;
                }
                var cat_id = this.category_id_1;
                let fd = new FormData();
                fd.append("search_word", this.search_word);
                fd.append("selected_category", cat_id);
                fd.append("postid",`${this.$route.params.id}`)
                this.axios.post("/api/news_list/search?page="+ page,fd).then(response => {
                    this.related_news = response.data;
                    this.norecord = this.related_news.data.length;
                    if(this.norecord != 0) {
                        this.nosearch_msg = false;
                    }else{
                        this.nosearch_msg = true;
                    }
                    this.check_head = true;
                    if(this.related_news.length > this.size) {
                        this.pagination = true;
                    }else{
                        this.pagination = false;
                    }
                });
            },
            closeBtnMethod: function(old_photo) {
                if(confirm)
                {
                    this.$swal({
                    text: "画像を削除してよろしいでしょうか。",
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
                    }).then(response =>{
                    var image_x = document.getElementById('x-image');
                    image_x.parentNode.removeChild(image_x);
                    document.getElementById('showimage').style.display = 'block';
                   }).then(response => {
                        this.$swal({
                                text: "画像を削除しました。",
                                type: "success",
                                width: 350,
                                height: 200,
                                confirmButtonText: "閉じる",
                                confirmButtonColor: "#31cd38",
                                allowOutsideClick: false,
                            });
                            this.old_photo = old_photo;
                            this.getPostsByCatId;
                   });
                }
            },
            checkValidate() {
                if(this.selectedValue == 26){
                    if(this.news.from_date == ''){
                        this.errors.from_date = '掲載開始日は必須です。'
                    }
                    else{
                        this.errors.from_date = '';
                    }
                }
                if (this.news.title) {
                    this.errors.title = "";
                } else {
                    this.errors.title = "ニュースの題名は必須です。";
                }
                if (this.news.main_point) {
                    this.errors.main_point = "";
                } else {
                    this.errors.main_point = "ニュースの内容要約は必須です。";
                }
                if (this.news.body) {
                    this.errors.body = "";
                } else {
                    this.errors.body = "ニュースの内容は必須です。";
                }
                if (this.news.category_id) {
                    this.errors.category_id = "";
                } else {
                    this.errors.category_id = "ニュースのカテゴリーは必須です。";
                }
                if(this.selectedValue == 26){
                    if (
                        !this.errors.title &&
                        !this.errors.main_point &&
                        !this.errors.body &&
                        !this.errors.category_id &&
                        !this.errors.from_date
                    ){
                        //date 
                        if(this.news.to_date != ''){
                            var fromd = new Date(this.news.from_date);
                            var tod = new Date(this.news.to_date)
                            if(fromd.getTime() >  tod.getTime()){
                                this.errors.date_check = "掲載終了日を掲載開始日より後にしてください。";
                            } else {
                                this.errors.date_check = '';
                                if(this.status == 0) {
                                    this.add();
                                } else {
                                    this.updatepost();
                                } 
                            } 
                        }  
                        else {
                            if(this.status == 0) {
                                this.add();
                            } else {
                                this.updatepost();
                            } 
                        }                                                             
                    }
                }
                else{
                    if (
                        !this.errors.title &&
                        !this.errors.main_point &&
                        !this.errors.body &&
                        !this.errors.category_id
                    ) {
                        if(this.status == 0) {
                            this.add();
                        } else {
                            this.updatepost();
                        } 
                    }
                }                        
            },
            imgUrlAlt(event) {
               event.target.src = "/images/noimage.jpg"
            },
            imgUrlAlt1(event) {
                this.noimage = 1;
                event.target.src = "/images/noimage.jpg"
            },
        }  
    }
</script>
<style>
    .quill-editor{
        background-color: #fff;
    }
    .bt-red
    {
        color: #fff;
        background-color: #e3342f;
        border-color: #e3342f;
    }
    .bt-suc
    {   
        color: #fff;
        background-color: #0cc72c; 
        border-color: #0cc72c;
    }
    .bd-form{
        border:1px solid #ccc;
    }
    .nosearch_msg{
        height:250px;
        padding-top:30px;
    }
</style>

<template>
     <div id="ads_post">
      
          <div class="card">
              <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <h4 class="page-header header">{{header}}</h4>
                            <br>
                        </div>
                        <div class="col-md-12">
                            <form @submit.prevent="updateAds" autocomplete="off">
                            <div class="form-group">
                                <label style="width:20%;">広告タイトル <span class="error sp2">必須</span></label>
                                    <date-picker class=""  :lang="lang" valueType="format" v-model="newsByCat.post_date"  style="width:60%"></date-picker>
                                    <!-- <span v-if="errors.title" class="error">{{errors.title}}</span> -->
                            </div>

                            <div class="form-group">
                                <label>カテゴリー <span class="error sp2">必須</span></label>
                                <select v-model="newsByCat.type" class="form-control" @change='getstates()' style="display:inline-block;width:50%;">
                                    <option value="">事業者のタイプを選択してください(介護又は病院)</option>
                                    <option value="1">介護</option>
                                    <option value="2">病院</option>
                                    <option value="3">Recruit</option>
                                </select>
                                <span v-if="errors.category_id" class="error">{{errors.category_id}}</span>
                            </div>

                            <div class="form-group">
                                <label>Status <span class="error sp2">必須</span></label>
                                <select v-model="newsByCat.status" class="form-control" @change='getstates()' style="display:inline-block;width:50%;">
                                    <option value="">事業者のタイプを選択してください(介護又は病院)</option>
                                    <option value="1">ニュースリリース</option>
                                    <option value="2">メディア掲載</option>
                                    <option value="3">お知らせ</option>
                                </select>
                                <span v-if="errors.category_id" class="error">{{errors.category_id}}</span>
                            </div>

                            <div class="form-group">
                                <label>内容 <span class="error sp2">必須</span></label>
                                <quill-editor  ref="myQuilEditor" id="exampleFormControlTextarea1" class="rounded-0" placeholder="内容を入力してください。"  @change="onDetailInfoEditorChange($event)" v-model="newsByCat.description" :options="editorOption" @blur="onEditorBlur($event)" @focus="onEditorFocus($event)"/>
                                <span v-if="errors.body" class="error">{{errors.body}}</span>
                            </div>
                            
                            <div class="form-group">
                                <router-link to="/linkedNews" class="btn bt-red all-btn">キャンセル</router-link>
                                <span class="btn main-bg-color white all-btn" @click="clickValidation()" >保存</span>
                            </div>
                                </form>
                            </div>
                         </div>
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
                errors: {
                    post_date:"",
                    type:"",
                    status:"",
                    description:"",
                },
                categories: {
                        id: '',
                        name: ''
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
                newsByCat: {
                    post_date: '',
                    type:'',
                    status: '',
                    description:'',
                },
                ischeck:'',
                old_photo: "",
                old_pdf: "",
                upload_img:'',
                upload_pdf:'',
                update_img: false,
                update_pdf: false,
                showhide:false,
                header : '',
                img_name : '',
                pdf_name : '',
            }
        },
        created() {
            if(this.$route.params.id){
                 this.showhide = false;
                 this.axios
                .get(`/api/news/edit/${this.$route.params.id}`)
                .then((response) => {
                    this.newsByCat.post_date = response.data.post_date;
                    this.newsByCat.type = response.data.type;
                    this.newsByCat.status = response.data.status;
                    this.newsByCat.description = response.data.description;
                });
                this.header = 'Edit News';
            }
            else{
                this.showhide = true;
                this.newsByCat.post_date = '';
                this.newsByCat.type = '';
                this.newsByCat.status = '';
                this.newsByCat.description = '';
                this.header = 'Create News';
            }
           
        },
         methods: {
            updateAds() {
               
                    this.$swal({
                        // title: "確認",
                        text: "広告を更新してよろしいでしょうか。",
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
                        this.errors = [];
                        let newsData = new FormData();
                        // this.advertisement.location = "topbar";
                        
                        newsData.append('post_date',this.newsByCat.post_date)
                        newsData.append('type',this.newsByCat.type)
                        newsData.append('status',this.newsByCat.status)
                        newsData.append('description',this.newsByCat.description)
                        // console.log(newsData);
                        console.log('yyyy');
                        this.$loading(true);
                        this.axios.post(`/api/news/update/${this.$route.params.id}`, newsData)
                        .then((response) => {
                            this.$loading(false);
                           
                            this.$swal({
                                position: 'top-end',
                                type: 'success',
                                text: '広告を更新しました。',                             
                                confirmButtonText: "閉じる",
                                confirmButtonColor: "#31cd38",
                                width: 350,
                                height: 200,
                                allowOutsideClick: false,
                            })
                            //this.$router.push({name: 'ads'});
                            var num = localStorage.getItem('page_no');//get from adslist/searchAds()
                            // this.$router.push({ name: 'ads', params: { status: 'update','page_no':num } });
                            this.$router.push({
                                name: 'linkedNews'
                            });

                        }).catch(error=>{
                        if(error.response.status == 422){
                            this.errors = error.response.data.errors
                        }
                    })
                });
                

            },
            add() {
                //   this.advertisement.location = "topbar";
                  this.$swal({
                            // title: "確認",
                            text: "広告を作成してよろしいでしょうか。",
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
                            let newsData = new FormData();
                            newsData.append('post_date', this.newsByCat.post_date)
                            newsData.append('type', this.newsByCat.type)
                            newsData.append('status', this.newsByCat.status)
                            newsData.append('description', this.newsByCat.description)
                            
                            this.$loading(true);
                        this.axios.post('/api/news/add', newsData)
                              .then((response) => {
                        this.$loading(false);
                       
                        this.$swal({
                            position: 'top-end',
                            type: 'success',
                            // title:'確認済',
                            text: '広告を投稿しました。',
                            confirmButtonText: "閉じる",
                            confirmButtonColor: "#31cd38",
                            width: 350,
                            height: 200,
                            allowOutsideClick: false,
                        });
                        this.$router.push({name: 'linkedNews'});
                    }).catch(error => {

                        if (error.response.status == 422) {

                            this.errors = error.response.data.errors

                        }
                         });
               
                    })
            },
            clickValidation() {
                if (this.newsByCat.post_date) 
                {
                    this.errors.post_date = "";
                } else 
                {
                    this.errors.post_date = " 題名は必須です。";
                }
            
                if(this.newsByCat.type)
                {
                    this.errors.type = "";     
                } else 
                {    
                    this.errors.type = "写真は必須です。";
                }
                if(this.newsByCat.status)
                {
                    this.errors.status = "";     
                } else 
                {    
                    this.errors.status = "写真は必須です。";
                }
                if(this.newsByCat.description)
                {
                    this.errors.description = "";     
                } else 
                {    
                    this.errors.description = "写真は必須です。";
                }

                if(!this.errors.link && !this.errors.title && !this.errors.photo && !this.errors.pdf && this.$route.params.id)
                {
                    // console.log('update');
                this.updateAds();
                }
                else if(!this.errors.post_date && !this.errors.type && !this.errors.status && !this.errors.description && !this.$route.params.id){
                    this.add();
                }
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
</style>

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
                                                <label>広告タイトル <span class="error sp2">必須</span></label>
                                                <input type="title" class="form-control box" id="title"  name="title" v-model="advertisement.title" placeholder="広告タイトルを入力してください。">
                                                <span v-if="errors.title" class="error">{{errors.title}}</span>
                                    </div>
                            <div class="form-group">
                                <label>説明</label>
                                <textarea name="description" class="form-control" cols="50" rows="5" v-model="advertisement.description"></textarea>
                            </div>
                            <div class="form-group">
                                <label>広告リンク  <span class="error sp2">必須</span></label>
                                <input type="link" class="form-control box" id="link"  name="link" v-model="advertisement.link" placeholder="広告リンクを入力してください。">
                                <span v-if="errors.link" class="error">{{errors.link}}</span>
                            </div>
                            <div class="form-group" id="showpdf">
                                <label>PDF ファイル<span class="error sp2">必須</span></label><br/>
                                <div class="d-flex align-items-center">
                                    <span class="btn-file d-inline-block">PDF ファイルを選択        
                                        <input type="file" v-if="!showhide" ref="file" accept="application/pdf" id="upd_pdf" @change ="pdfFileSelected">
                                        <input type="file" v-if="showhide" id="upload_pdf" accept="application/pdf" @change="uploadPDF"> 
                                    </span> 
                                    <span class="pl-4 text-wrap w-75">{{pdf_name}}</span>
                                </div>
                                <span v-if="errors.pdf" class="error">{{errors.pdf}}</span>
                                <div class="col-md-12" id="par">
                                    <div class="row file_preview"></div>
                                </div>
                            </div>
                            <div class="pdf_show" v-if="update_pdf && upload_pdf">
                                <div class='col-md-2'>
                                </div>
                            </div>

                            <div class="form-group pdf_update" v-if="!update_pdf && advertisement.pdf" id="x-pdf" >
                                <div class="row" >
                                    <div v-if="!showhide" id='x-pdf' class='col-md-12 col-6'>
                                        <input type="text" v-model="advertisement.pdf"  class='show-pdf form-control box' readonly> 
                                        <span class='pdf-close-btn' v-on:click='closePDFBtnMethod(advertisement.pdf)'>削除</span>                                       
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>トップページに表示したいリンクを選択</label><br>
                                <input type="radio"   v-model="advertisement.show_flag" id="ads"  value="link" >
                                <span class="show-flag">広告リンク</span>
                                <input type="radio"   v-model="advertisement.show_flag" id="pdf" value="pdf"  >
                                <span class="show-flag">PDFリンク </span>
                            </div>
                            <input type="hidden" v-model="old_pdf" >
                            <div class="form-group" id="showimage">
                                <label>写真 <span class="error sp2">必須</span></label><br/>
                                <div class="d-flex align-items-center">
                                    <span class="btn-file d-inline-block">画像を選択        
                                        <input type="file" v-if="!showhide" ref="file" accept="image/*" id="upd_img" @change ="fileSelected">
                                        <input type="file" v-if="showhide" id="upload" accept="image/*" @change="uploadImage"> 
                                    </span> 
                                    <span class="btn-file d-inline-block" v-if="!showhide" @click="selectLogoImage()">TISのロゴを使用 
                                    </span> 
                                    <span class="btn-file d-inline-block" v-if="showhide" id="upload" @click="uploadLogoImage()">TISのロゴを使用 
                                    </span>
                                    <span class="pl-4 text-wrap w-75">{{img_name}}</span>
                                </div>
                                <span v-if="errors.photo" class="error">{{errors.photo}}</span>
                                <div class="col-md-12" id="par">
                                    <div class="row image_preview" id="x-logo"></div>
                                </div>
                            </div>
                            <div class="image_show" v-if="update_img && upload_img">
                                <div class='col-md-2'>
                                 
                                    <img :src="upload_img" class='show-img' @error="imgUrlAlt">
                                </div>

                            </div>

                            <div class="form-group image_update" v-if="!update_img" id="x-image" >
                                <div class="row" >
                                    <div v-if="!showhide" id='x-image' class='col-md-4 col-6'>
                                        <span class='img-close-btn' v-on:click='closeBtnMethod(advertisement.photo)'>X</span>
                                        <img :src="'/upload/advertisement/'+ advertisement.photo"  class='show-img' alt="ads" @error="imgUrlAlt">
                                
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" v-model="old_photo" >
                            <div class="form-group">
                                <router-link to="/ads" class="btn bt-red all-btn">キャンセル</router-link>
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
export default {
          data() {
            return {
                errors: {
                    title:"",
                    location:"",
                    photo:"",
                    link:"",
                    pdf:"",
                    
                },
                advertisement: {
                    title: '',
                    description:'',
                    link:'',
                    // location : [{
                    //     topbars: false,
                    //     sidebars:false
                    // }],
                    location:'',
                    photo:'',
                    pdf:'',
                    show_flag:"link",
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
            if(this.$route.name == "editadvertisement"){
                 this.showhide = false;
                 this.axios
                .get(`/api/advertisement/edit/${this.$route.params.id}`)
                .then((response) => {
                    this.advertisement.title = response.data.title;
                    this.advertisement.description = response.data.description == null ? '':response.data.description;
                    this.advertisement.link = response.data.link == null ? '':response.data.link;
                    //this.advertisement.link = response.data.link;
                    this.advertisement.pdf = response.data.pdf;
                    this.advertisement.show_flag = response.data.show_flag;
                    this.advertisement.location = "topbar";
                    // this.ischeck = response.data.location;
                    // this.updateCheck(this.ischeck);
                    this.advertisement.photo=response.data.photo;
                });
                this.header = '広告編集';
            }
            else{
                this.showhide = true;
                this.advertisement.title = '';
                this.advertisement.description = '';
                this.advertisement.link = '';
                this.advertisement.pdf = '';
                this.advertisement.show_flag = 'link';
                this.ischeck = '';
                this.advertisement.photo='';     
                this.header = '広告新規作成';
            }
           
        },
         methods: {
            imgUrlAlt(event) {
                event.target.src = "/images/noimage.jpg"
            },
            fileSelected(){
                this.advertisement.photo = event.target.files[0];
                this.upload_img = URL.createObjectURL(event.target.files[0]);
                this.update_img = true;
                const file =event.target.files[0];
                this.img_name = file.name;
            },
            selectLogoImage () {
                this.advertisement.photo = "logo.png";
                this.upload_img = "/images/logo.png";
                this.update_img = true;
                this.img_name = "logo.png";
            },
            pdfFileSelected(){
                this.advertisement.pdf = event.target.files[0];
                this.upload_pdf = URL.createObjectURL(event.target.files[0]);
                this.update_pdf = true;
                const file =event.target.files[0];
                this.pdf_name = file.name;
            },
            closeBtnMethod: function(old_photo) {
                this.$swal({
                    // title: "確認",
                    text: "削除してよろしいでしょうか。",
                    type: "warning",
                    width: 350,
                    height: 200,
                    showCancelButton: true,
                    confirmButtonColor: "#EEA025",
                    cancelButtonColor: "#b1abab",
                    cancelButtonTextColor: "#000",
                    confirmButtonText: "はい",
                    cancelButtonText: "キャンセル",
                    confirmButtonClass: "all-btn",
                    cancelButtonClass: "all-btn",
                    allowOutsideClick: false,
                }).then(response => {
                        this.$swal({
                                text: "画像を削除しました。",
                                type: "success",
                                width: 350,
                                height: 200,
                                confirmButtonText: "閉じる",
                                confirmButtonColor: "#31CD38",
                                allowOutsideClick: false,
                            });
                    }).then(response => {
                        this.img_name = '';
                        this.update_img = true;
                        this.advertisement.photo = '';
                        if(this.advertisement.photo){
                            var image_x = document.getElementById('x-image');
                            image_x.parentNode.removeChild(image_x);
                        }
                }); 
            },
            closePDFBtnMethod: function(old_pdf) {
                console.log
                this.$swal({
                    // title: "確認",
                    text: "削除してよろしいでしょうか。",
                    type: "warning",
                    width: 350,
                    height: 200,
                    showCancelButton: true,
                    confirmButtonColor: "#EEA025",
                    cancelButtonColor: "#b1abab",
                    cancelButtonTextColor: "#000",
                    confirmButtonText: "はい",
                    cancelButtonText: "キャンセル",
                    confirmButtonClass: "all-btn",
                    cancelButtonClass: "all-btn",
                    allowOutsideClick: false,
                }).then(response => {
                        this.$swal({
                                text: "PDFファイルを削除しました。",
                                type: "success",
                                width: 350,
                                height: 200,
                                confirmButtonText: "閉じる",
                                confirmButtonColor: "#31CD38",
                                allowOutsideClick: false,
                            });
                    }).then(response => {
                        this.pdf_name = '';
                        this.update_pdf = true;
                        this.advertisement.pdf = '';
                        if(this.advertisement.pdf){
                            var pdf_x = document.getElementById('x-pdf');
                            pdf_x.parentNode.removeChild(pdf_x);
                        }
                }); 
            },           
            uploadImage() {
                $('.image_preview').html("<div class='col-md-2'><img src='" + URL.createObjectURL(event.target.files[0]) + "' class='show-img'></div>");
                this.advertisement.photo = event.target.files[0];
                const file =event.target.files[0];
                this.img_name = file.name;
            },
            uploadLogoImage() {
                $('.image_preview').html("<div class='col-md-2'><img src='images/logo.png' class='show-img'></div>");
                this.advertisement.photo = "logo.png";
                this.img_name = "logo.png";
                
            },
            uploadPDF() {    
                $('.file_preview').html("<div class='col-md-2'></div>");
                this.advertisement.pdf = event.target.files[0];
                const file =event.target.files[0];
                this.pdf_name = file.name;
            },
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
                        let adsData = new FormData();
                        this.advertisement.location = "topbar";
                        
                        adsData.append('location',this.advertisement.location)
                        adsData.append('title',this.advertisement.title)
                        adsData.append('description',this.advertisement.description)
                        adsData.append('link',this.advertisement.link)
                        adsData.append('pdf',this.advertisement.pdf)
                        adsData.append('show_flag',this.advertisement.show_flag)
                        adsData.append('photo',this.advertisement.photo)
                        adsData.append('old_photo',this.old_photo)
                        adsData.append('old_pdf',this.old_pdf)
                      
                        this.$loading(true);
                        this.axios.post(`/api/advertisement/update/${this.$route.params.id}`, adsData)
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
                                name: 'ads'
                            });

                        }).catch(error=>{
                        if(error.response.status == 422){
                            this.errors = error.response.data.errors
                        }
                    })
                });
                

            },
            add() {
                  this.advertisement.location = "topbar";
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
                             let adsData = new FormData();
                            adsData.append('title', this.advertisement.title)
                            adsData.append('description', this.advertisement.description)
                            adsData.append('link', this.advertisement.link)
                            adsData.append('location', this.advertisement.location)
                            adsData.append('photo', this.advertisement.photo)
                            adsData.append('pdf', this.advertisement.pdf)
                            adsData.append('show_flag', this.advertisement.show_flag)
                            this.$loading(true);
                        this.axios.post('/api/advertisement/add', adsData)
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
                        })
                        this.$router.push({
                            name: 'ads'
                        });
                    }).catch(error => {

                        if (error.response.status == 422) {

                            this.errors = error.response.data.errors

                        }
                         });
               
                    })
            },
            clickValidation() {
                if (this.advertisement.title) 
                {
                    this.errors.title = "";
                } else 
                {
                    this.errors.title = " 題名は必須です。";
                }
            
                if(this.advertisement.photo)
                {
                    this.errors.photo = "";     
                } else 
                {    
                    this.errors.photo = "写真は必須です。";
                }
                // if(this.advertisement.pdf)
                // {
                //     this.errors.pdf = "";     
                // } else 
                // {    
                //     this.errors.pdf = "PDF ファイルは必須です。";
                // }

                // if(this.advertisement.link)
                // {
                //     this.errors.link = "";     
                // } else 
                // {    
                //     this.errors.link = "広告リンクは必須です。";
                // }

               /* if((this.advertisement.pdf) && (this.advertisement.link))
                {
                    this.errors.link = "";
                    this.errors.pdf = "";     
                } 
                else if ((this.advertisement.pdf) || (this.advertisement.link))
                {    
                    this.errors.link = "";
                    this.errors.pdf = "";  
                }
                else
                {
                    this.errors.link = "「広告リンク」または「PDF ファイル」を入力してください。";
                    this.errors.pdf = "「広告リンク」または「PDF ファイル」を入力してください。"; 
                }*/
                if(!(this.advertisement.link) && (this.advertisement.show_flag == "link")){
                this.errors.link = "広告リンクは必須です。";
                this.errors.pdf = "";  
                }else if(!(this.advertisement.pdf) && (this.advertisement.show_flag == "pdf")){
                    this.errors.pdf = "PDF ファイルは必須です。";
                    this.errors.link = "";
                }else{
                    this.errors.link = "";
                    this.errors.pdf = ""; 
                }
                

                if(!this.errors.link && !this.errors.title && !this.errors.photo && !this.errors.pdf && this.$route.params.id)
                {
                this.updateAds();
                }
                else if(!this.errors.link && !this.errors.title && !this.errors.photo && !this.errors.pdf && !this.$route.params.id){
                    this.add();
                }
            },
        }
}
</script>

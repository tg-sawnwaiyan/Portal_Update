<template>

<div id="create_subject">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <h4 class="page-header header">{{ header }}</h4>
                </div>
                        <div class="col-md-12">
                            <form @submit.prevent ="add" autocomplete="off">
                    <div class="form-group">
                        <label>科目カテゴリー <span class="error sp2">必須</span></label>
                            <select v-model="selectedValue" class="form-control" @change='getParent()'>
                                <option value="0">選択してください。</option>
                                <option v-for="Subjectlist in SubjectList" :key="Subjectlist.id" v-bind:value="Subjectlist.id">
                                    {{Subjectlist.name}}
                                </option>
                            </select>
                    </div>
                        <div class="form-group">
                            <label>科目 <span class="error sp2">必須</span></label>
                            <input type="text" class="form-control"  v-model="Subject.name"  placeholder="科目を入力してください。" >
                            <span v-if="errors.name" class="error">{{errors.name}}</span>
                        </div>
                        <br/>
                            <div class="form-group">
                                <router-link class="btn btn-danger all-btn" to="/subjectlist" > キャンセル </router-link>
                                <span class="btn main-bg-color white all-btn" @click="checkValidate()">{{subtitle}}</span>
                                    <!-- <button class="btn news-post-btn all-btn">{{subtitle}}</button> -->
                                
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
                 errors:{
                     name:""
                 },
                //  Parents : [ { id: 0,name : 'None'},{ id: 1, name: 'Hospital' },{ id: 2, name: 'Nursing' }],
                 Subject: {
                        name: '',
                        parent:'',
                    },
                SubjectList:{
                        id: '',
                        name: ''
                   },

                selectedValue:0,
                header: '診療科目作成',
                subtitle: '作成'

            }
        },
         created() {

             this.axios.get('/api/subjects/subjectlist')
              .then(function (response) {
                   this.SubjectList = response.data;
              }.bind(this));
        },
        mounted() {

            if(this.$route.params.id)
            {

                this.axios
               .get(`/api/subjects/edit/${this.$route.params.id}`)
                .then((response) => {
                        this.Subject.name = response.data.name;
                        this.Subject.parent = response.data.parent;
                        this.selectedValue = response.data.parent;
                        this.SubjectList.name = response.data.name;
                        this.header = ' 診療科目編集';
                        this.subtitle = '保存';
                        return this.header;
                        return this.subtitle;
                });
            }


        },

         methods: {
               checkValidate() {
                     if (this.Subject.name) {
                        // console.log('exist');
                        this.errors.name = "";
                    } else {
                        // console.log('null');
                        this.errors.name = "診療科目は必須です。";
                    }
                   if (
                        !this.errors.name
                        
                    ) {
                        this.add();
                    }
                },
				
            add() {
                 if( `${this.$route.params.id}` == "undefined")
                {
                    this.$swal({
                            // title: "確認",
                            text: "診療科目を作成してよろしいでしょうか。",
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
                                this.$loading(true);
                                   this.axios.post('/api/subjects/add', this.Subject)
                        .then(response => {
                            this.$loading(false);
                            this.name = ''
                            this.$swal({
                            position: 'top-end',
                            type: 'success',
                            // title:'確認済',
                            text: '診療科目を作成しました。',
                            confirmButtonText: "閉じる",
                            confirmButtonColor: "#31cd38",
                            // showConfirmButton: false,
                            // timer: 1800,
                            width: 350,
                            height: 200,
                            allowOutsideClick: false,
                        })
                        // alert('Successfully Created')
                        this.$router.push({name: 'subjectlist'});
                        }).catch(error=>{

                    if(error.response.status == 422){

                        this.errors = error.response.data.errors

                    }
                })
                            })

                }
                else{
                     this.updateSubject();
                }
               
            },
             getParent: function(){

               this.Subject.parent = this.selectedValue;

           },
           updateSubject() {
 
                this.$swal({
                        //   title: "確認",
                            text: "診療科目を登録してよろしいでしょうか。",
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
                             this.axios.post(`api/subjects/update/${this.$route.params.id}`, this.Subject)
                    .then((response) => {
                        this.$loading(false);
                        this.$swal({
                            position: 'top-end',
                            type: 'success',
                            text: '診療科目を更新しました',
                            // showConfirmButton: false,
                            // timer: 1800,
                            confirmButtonText: "閉じる",
                            confirmButtonColor: "#31cd38",
                            width: 350,
                            height: 200,
                            allowOutsideClick: false,
                        })
                         
                            var num = localStorage.getItem('page_no');//comment get from Subjectlist/searchSubject()
                            // this.$router.push({ name: 'subjectlist', params: { status: 'update','page_no':num } })
                             this.$router.push({
                                name: 'subjectlist'
                            });

                    }).catch(error=>{

                    if(error.response.status == 422){

                        this.errors = error.response.data.errors

                    }
                });
                         });
               
            },

        }

}
</script>

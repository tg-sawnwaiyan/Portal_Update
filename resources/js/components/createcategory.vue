<template>
    <div class="card"  id="cat_post">
        <div class="card-body">
            <h4 class="page-header header">{{title}}</h4>
            <br>
            <form>
                <div class="form-group">
                    <label>{{label}}<span class="error sp2">必須</span></label>
                    <input type="text" class="form-control"  v-model="category.name"  :placeholder='[[placeholder]]'>
                    <span v-if="errors.name" class="error">{{errors.name}}</span>
                </div>
                <div class="form-group">
                    <label>タブ順序</label>
                    <input type="number" v-on:keydown="isNumber" class="form-control"  v-model="category.order_number" placeholder="タブ順序を半角数字で入力してください。">
                    <span v-if="errors.order_number" class="error">{{errors.order_number}}</span>
                </div>
                <div class="form-group"> 
                    <router-link class="btn bt-red all-btn" to="/categorylist" > キャンセル </router-link>
                    <span class="btn main-bg-color white all-btn" @click="checkValidate()"> {{buttontext}}</span>
                </div>
            </form>  
        </div>
    </div>             
</template>
<script>
export default {
    data() {
        return {
            errors: {
                name: "",
                order_number: null,
            },
            category: {
                name: '',
                order_number: null,
            },
            title:'',
            label:'',
            placeholder:'',
            buttontext:'',
        }
    },
    created() {
        if(this.$route.name == "editcategory"){
            this.title = "ニュースカテゴリー編集";
            this.label = "ニュースカテゴリー名 ";
            this.placeholder = "カテゴリー名を入力してください。";
            this.buttontext = "保存";
            this.axios
            .get(`/api/category/edit/${this.$route.params.id}`)
            .then(response => {
                this.category = response.data;
            });
        }
        else{
            this.title = "ニュースカテゴリー作成";
            this.label = "ニュースカテゴリー名 ";
            this.placeholder = "ニュースカテゴリー名を入力してください。";
            this.buttontext = "作成";
        }
    },
    methods: {
        add() {
            this.$swal({
                text: "ニュースカテゴリーを作成してよろしいでしょうか。",
                type: "warning",
                width: 390,
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
            })
            .then(response => { 
                if(this.category.order_number == null || this.category.order_number == ''){
                    this.category.order_number = 0;
                }
                this.$loading(true);
                this.axios.post('/api/category/add', this.category)
                .then((response) => {
                    this.$loading(false);
                    this.name = ''
                    this.$swal({
                        position: 'top-end',
                        type: 'success',
                        text: 'ニュースカテゴリーを作成しました。',
                        confirmButtonText: "閉じる",
                        confirmButtonColor: "#31cd38",
                        width: 350,
                        height: 200,
                        allowOutsideClick: false,
                    })
                    this.$router.push({name: 'categorylist'});
                }).catch(error=>{
                if(error.response.status == 422){
                    this.errors = error.response.data.errors
                }
            });
            });     
        },
        updateCategory() { 
            if(this.category.order_number == null || this.category.order_number == ''){
                this.category.order_number = 0;
            }
            this.$loading(true);
            this.axios.post(`/api/category/update/${this.$route.params.id}`, this.category)
            .then((response) => {
                this.$loading(false);
                this.name = ''
                this.$swal({
                    position: 'top-end',
                    type: 'success',
                    text: 'カテゴリーを更新しました。',
                    confirmButtonText: "閉じる",
                    confirmButtonColor: "#31cd38  ",
                    width: 350,
                    height: 200,
                    allowOutsideClick: false,
                })
                var num = localStorage.getItem('page_no');
                this.$router.push({name: 'categorylist'});
                }).catch(error=>{
                if(error.response.status == 422){
                    this.errors = error.response.data.errors
                }
            });                       
        },
        checkValidate() {
            if(!this.category.name && !this.$route.params.id){
                this.errors.name = " ニュースカテゴリー名は必須です。";
            }
            else if(!this.category.name && this.$route.params.id){
                this.errors.name = "カテゴリー名は必須です。";
            }
            else if(this.category.name ) {
                this.errors.name = "";
            }
            if (!this.errors.name && !this.$route.params.id ) 
            {
                this.add();
            }
            else if(!this.errors.name && this.$route.params.id){
                this.updateCategory();
            }
        },
        isNumber: function(event) {
            if(!(event.keyCode >= 48 && event.keyCode <= 57) && !(event.keyCode >= 96 && event.keyCode <= 105) 
            && event.keyCode != 8 && event.keyCode != 46 && !(event.keyCode >= 37 && event.keyCode <= 40)) 
            {
                event.preventDefault();
            }
        },
    }
}
</script>
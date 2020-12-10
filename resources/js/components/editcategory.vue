<template>
    <div class="card text-dark" id="cat_post">
        <div class="card-body">
            <h4 class="page-header header">カテゴリー編集</h4>
            <br>
            <form @submit.prevent="updateCategory" autocomplete="off">
                <div class="form-group">
                    <label>
                        カテゴリー名:
                        <span class="error">*</span>
                    </label>
                    <input type="text" class="form-control" v-model="category.name" placeholder="カテゴリー名を入力してください。" />
                    <span v-if="errors.name" class="error">{{errors.name}}</span>
                </div>
                <div class="form-group">
                    <router-link to="/categorylist" class="btn btn-danger all-btn">キャンセル</router-link>
                    <button class="btn main-bg-color white all-btn" @click="clickValidation()">保存</button>
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
                name:'',
            },
            category: {
                name: "",
            }
        };
    },
    created() {
        this.axios
        .get(`/api/category/edit/${this.$route.params.id}`)
        .then(response => {
            this.category = response.data;
        });
    },
    methods: {
        updateCategory() {
            if( `${this.$route.params.id}` && this.errors.name == null ){
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
                        confirmButtonColor: "#6cb2eb",
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
            }
        },
        clickValidation() {
            if (this.category.name) {
                this.$swal({
                    title: "確認",
                    text: "カテゴリーを更新してよろしいでしょうか",
                    type: "success",
                    width: 350,
                    height: 200,
                    showCancelButton: true,
                    confirmButtonColor: "#6cb2eb",
                    cancelButtonColor: "#b1abab",
                    cancelButtonTextColor: "#000",
                    confirmButtonText: "はい",
                    cancelButtonText: "キャンセル",
                    confirmButtonClass: "all-btn",
                    cancelButtonClass: "all-btn",
                    allowOutsideClick: false,
                }).then(response => { 
                    this.errors.name = null;
                    this.updateCategory();
                })
            } else {
                this.errors.name = " カテゴリー名は必須です。";
            }
            if (!this.errors.name) {
                this.updateCategory();
            }
        }
    }
};
</script>
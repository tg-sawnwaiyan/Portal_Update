<template>
    <div id="feature">
        <div class="card">
            <div class="card-body">
                <h4 class="page-header header">{{ header }}</h4>
                <br>
                <form @submit.prevent="add" autocomplete="off">
                    <div class="form_group">
                        <label> 施設種別 <span class="error sp2">必須</span></label>
                        <select v-model="feature.type" name="type" class="form-control">
                            <option v-bind:value='-1'>選択してください。 </option>
                            <option value="nursing">介護</option>
                            <option value="hospital" >病院</option>
                        </select>
                        <span v-if="errors.type" class="error">{{errors.type}}</span>
                    </div>
                    <br/>
                    <div class="form-group">
                        <label>特長 <span class="error sp2">必須</span></label>
                        <input type="text" class="form-control"  v-model="feature.name"  placeholder="特長を入力してください。" >
                        <span v-if="errors.name" class="error">{{errors.name}}</span>
                    </div>
                    <div class="form-group">
                        <label>特長の略語 <span class="error sp2">必須</span></label>
                        <input type="text" class="form-control" v-model="feature.short_name"  placeholder="特長の略語を入力してください。" >
                        <span v-if="errors.short_name" class="error">{{errors.short_name}}</span>
                    </div>
                    <div class="form-group ">
                        <span class="btn bt-red all-btn" @click="$router.go(-1)" > キャンセル </span>
                        <span class="btn main-bg-color white all-btn" @click="checkValidate()"> {{subtitle}}</span>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    data() {
        return {
            errors: { name:"", short_name:"", selectedValue:"", host:"", nurse:"", type: "" }, feature: { name: '', short_name:'', type: '-1', host:"", nurse:"" }, selectedValue:0, header: '特長新規作成', subtitle: '作成'
        }
    },
    created() {
        if(this.$route.params.id){              
            this.axios
            .get(`/api/feature/edit/${this.$route.params.id}`)
            .then((response) => {
                this.feature= response.data;                   
                this.header = ' 特長編集';
                this.subtitle = '保存';
                return this.header;
                return this.subtitle;
            });
        }
    },
    methods: {
        checkValidate() {
            if (this.feature.name) {
                this.errors.name = "";
            } else {
                this.errors.name = " 特長は必須です。";
            }
            if (this.feature.short_name) {
                this.errors.short_name = "";
            } else {
                this.errors.short_name = " 特長の略語は必須です。";
            }
            if (this.feature.type == '-1') {
                this.errors.type = " カテゴリーは必須です。";
            }
            else {
                this.errors.type = "";
            }
            if (
                !this.errors.name &&
                !this.errors.short_name &&
                !this.errors.type                        
            ) {                        
                this.add();
            }
        },
        add() {
            if( !this.$route.params.id || this.$route.params.id == 'undefined')
            {
                this.$swal({
                    text: "特長を作成してよろしいでしょうか。",
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
                })
                .then(response =>{
                    this.$loading(true);
                    this.axios.post('/api/feature/add', this.feature)
                    .then(response => {
                        this.$loading(false);
                        this.name = ''
                        this.$swal({
                            position: 'top-end',
                            type: 'success',
                            text: '特長を投稿しました。',
                            confirmButtonText: "閉じる",
                            confirmButtonColor: "#31cd38",                            
                            width: 350,
                            height: 200,
                            allowOutsideClick: false,
                        })
                        this.$router.go(-1);
                    }).catch(error=>{
                        console.log(error)
                        if(error.response.status == 422){
                            this.errors = error.response.data.errors
                        }
                    })
                })
            }
            else{
                this.updateFeature();
            }
        },
        updateFeature() {
            this.$swal({
                text: "特長を更新してよろしいでしょうか。",
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
                this.axios.post(`/api/feature/update/${this.$route.params.id}`, this.feature)
                .then((response) => {
                    this.$loading(false);               
                    this.$swal({
                        position: 'top-end',
                        type: 'success',
                        text: '特長を更新しました。',
                        confirmButtonText: "閉じる",
                        confirmButtonColor: "#31cd38",
                        width: 350,
                        height: 200,
                        allowOutsideClick: false,
                    })
                    this.$router.go(-1);
                }).catch(error=>{
                    console.log(error)
                    if(error.response.status == 422){
                        this.errors = error.response.data.errors
                    }
                });
            });
        }
    }
}
</script>
<template>
<div>
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <h4 class="page-header header">{{ header }}</h4>
                </div>
                <div class="col-md-12">
                    <form @submit.prevent ="add" autocomplete="off">
                        <div class="form-group">
                            <label>職種カテゴリー<span class="error sp2">必須</span></label>
                            <select v-model="selectedValue" class="form-control" @change='getOccupation()'>
                                <option value="0">選択してください。</option>
                                <option v-for="occupations in occupationList" :key="occupations.id" v-bind:value="occupations.id">
                                    {{occupations.name}}
                                </option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>職種<span class="error sp2">必須</span></label>
                            <input type="text" class="form-control"  v-model="occupation.name"  placeholder="職種名を入力してください。" >
                            <span v-if="errors.name" class="error">{{errors.name}}</span>
                        </div>
                        <div class="form-group ">
                            <router-link class="btn bt-red all-btn" to="/occupationlist" > キャンセル </router-link>
                            <span class="btn main-bg-color white all-btn" @click="checkValidate()">{{subtitle}}</span>
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
            occupation: {
                name: '',
                parent:'',
            },
            occupationList:{
                id: '',
                name: ''
            },
            selectedValue:0,
            header: '求人職腫新規作成',
            subtitle: '作成'
        }
    },
    created() {
        this.axios.get('/api/occupation/occupationList')
        .then(function (response) {
            this.occupationList = response.data;
        }.bind(this));
    },
    mounted() {
        this.axios
        .get(`/api/occupation/edit/${this.$route.params.id}`)
        .then((response) => {
            if( `${this.$route.params.id}` == "undefined"){
            }
            else{
                this.occupation.name = response.data.name;
                this.occupation.parent = response.data.parent;
                this.selectedValue = response.data.parent;
                this.occupationList.name = response.data.name;
                this.header = ' 求人職種編集';
                this.subtitle = '保存';
                return this.header;
                return this.subtitle;
            }
        });
    },
    methods: {
        checkValidate() {
            if (this.occupation.name) {
                this.errors.name = "";
            } else {
                this.errors.name = " 職種は必須です。";
            }
            if (!this.errors.name) {
                this.add();
            }
        },
        add() {
            if( `${this.$route.params.id}` == "undefined") {
                this.$swal({
                    text: "求人職種を作成してよろしいでしょうか。",
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
                    this.axios.post('/api/occupation/add', this.occupation)
                    .then(response => {
                        this.$loading(false);
                        this.name = ''
                        this.$swal({
                            position: 'top-end',
                            type: 'success',
                            text: '求人職種を作成しました。',
                            confirmButtonText: "閉じる",
                            confirmButtonColor: "#31cd38",
                            width: 350,
                            height: 200,
                            allowOutsideClick: false,
                        })
                        this.$router.push({name: 'occupationlist'});
                    }).catch(error=>{
                        if(error.response.status == 422){
                            this.errors = error.response.data.errors
                        }
                    })
                })
            }
            else{
                this.updateType();
            }
        },
        getOccupation: function(){
            this.occupation.parent = this.selectedValue;
        },
        updateType() {
            this.$swal({
                text: "求人職種を更新してよろしいでしょうか。",
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
                this.axios.post(`/api/occupation/update/${this.$route.params.id}`, this.occupation)
                .then(response => {
                    this.$loading(false);
                    this.$swal({
                        position: 'top-end',
                        type: 'success',
                        text: '求人職種を更新しました。',
                        confirmButtonText: "閉じる",
                        confirmButtonColor: "#31cd38 ",
                        width: 350,
                        height: 200,
                        allowOutsideClick: false,
                    })
                    var num = localStorage.getItem('page_no');//comment get from occupationlist.vue/searchOccupation()
                    this.$router.push({name: 'occupationlist'});
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

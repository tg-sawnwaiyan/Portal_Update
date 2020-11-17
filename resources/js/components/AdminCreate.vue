<template>
    <div class="d-flex justify-content-center h-100 admin-create-container">
        <div class="admin_card admin_registercard admin-create-wrapper">
            <div class="row">
                <div class="col-md-12">
                    <h4 class="page-header header header_bg">
                        {{ header }}
                        <span v-if="show" class="btn btn-danger all-btn float-right m-b-10" @click="$router.go(-1)">
                            <i class="fas fa-arrow-left"></i>&nbsp;戻る
                        </span>
                    </h4>           
                </div>
                <div class="col-md-12">
                    <form @submit.prevent="add" autocomplete="off">                       
                        <div class="row">
                            <div class="col-md-12 m-t-8">
                                <div class="form-group">
                                    <label>管理者名 :
                                        <span class="error-star">*</span>
                                    </label>
                                    <input type="text" class="form-control" v-model="adminData.name" placeholder="管理者名を入力してください。">
                                    <span v-if="errors.name" class="error-star">{{errors.name}}</span>
                                </div>
                                <div class="form-group">
                                    <label>メールアドレス :<span class="error-star">*</span></label>
                                    <input type="text" class="form-control" v-model="adminData.email" placeholder="メールアドレスを入力してください。">
                                    <span v-if="errors.email" class="error-star">
                                        {{errors.email}}
                                    </span>
                                </div>
                                <div class="form-group" v-if="!show">
                                    <label>パスワード :<span class="error-star">*</span></label>
                                    <input type="password" class="form-control" v-model="adminData.password" placeholder="パスワードを入力してください。">
                                    <span v-if="errors.password" class="error-star">{{errors.password}}</span>
                                    <div class="error-star d_none" id="newpasswordlength">
                                        パスワードは6桁以上にしてください。
                                    </div>
                                </div>
                                <div>
                                    <span class="btn main-bg-color white all-btn" v-if="show" @click="nameMailChange()">変更
                                    </span>
                                </div>
                            </div>
                        </div>                         
                        <div class="form-group m-t-10 m-b-0" v-if="show">                           
                            <div class="row">
                                <div class="col-md-12 m-t-8">
                                    <div class="row">
                                        <div class="col-md-9 col-6">
                                            <label class="font-weight-bold">
                                                <i class="fas fa-cogs"></i>&nbsp;パスワード設定
                                            </label>
                                        </div>
                                        <div class="col-md-3 col-6">
                                            <span class="btn drop-bg-color m-l-8 btn_min_width" @click="passwordToggleDiv()">詳細&nbsp;<i class="fas fa-sort-down animate"  :class="{'rotate': !isRotate}"></i></span>
                                        </div>
                                    </div>
                                    <div class="header2">  
                                    </div>
                                    <div class="password-setting">
                                        <label class="old-pass">現在のパスワード:
                                            <span class="error-star">*</span>
                                        </label>
                                        <input type="password" name="old_password" placeholder="現在のパスワードを入力してください。" v-model="old_password" class="form-control old-password">
                                        <span v-if="errors.old_password" class="error-star">
                                            {{errors.old_password}}
                                        </span>
                                        <br>
                                        <label class="old-pass">新しいパスワード:
                                            <span class="error-star">*</span>
                                        </label>
                                        <input type="password" name="new_password" placeholder="新しいパスワードを入力してください。" v-model="new_password" class="form-control new-password">
                                        <span v-if="errors.new_password" class="error-star">
                                            {{errors.new_password}}
                                        </span>
                                        <div class="error-star d_none" id="newpasswordlength">
                                            パスワードは6桁以上にしてください。
                                        </div>
                                        <br>
                                        <label class="old-pass">
                                            新しいパスワードをもう一度入力してください
                                            <span class="error-star">*</span>
                                        </label>
                                        <input type="password" name="comfirm_password" class="form-control confirm-password" v-model="confirm_password" placeholder="新しいパスワードをもう一度入力してください" @keyup="password_validate()">
                                        <span v-if="errors.old_password" class="error-star">
                                            {{errors.confirm_password}}
                                        </span>
                                        <div class="col-md-12 pad-free">
                                            <span v-if="errors.edit_password" class="error-star">
                                                {{errors.edit_password}}
                                            </span>
                                        </div>
                                        <div>
                                            <span class="btn main-bg-color white all-btn m-t-30" @click="passwordChange()">変更</span>
                                        </div>
                                    </div>                                    
                                </div>
                            </div>                              
                        </div>
                        <div class="form-group " v-if="!show">
                            <router-link class="btn btn-danger all-btn" to="t_is_admin_register">
                                キャンセル 
                            </router-link>
                            <span class="btn main-bg-color white all-btn" @click="checkValidate()">
                                {{subtitle}}
                            </span>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    data(){
        return {
            header: '管理者新規作成', subtitle: '作成', adminData: { name: '', email: '', password: '', old_password: '', new_password: '', confirm_password: '', }, errors: { name: '', email: '', password: '', edit_password: '', old_password: '', new_password: '', confirm_password: '', }, show: false, old_password: '', new_password: '', confirm_password: '', admin_id: this.$route.params.id, isRotate: false,
            mail_reg: /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,24}))$/
        }
    },
    created() {
        if (this.$route.name == "adminedit") {
            this.show = true;
            this.axios
            .get(`/api/main_admin/edit/${
                this.$route.params.id}`)
                .then((response) => {
                this.adminData = response.data;
                this.header = ' 管理者編集';
                this.subtitle = '保存';
                return this.header;
                return this.subtitle;
            });
        } else {
            this.show = false;
        }
    },
    methods: {
        checkValidate() {
            if (this.adminData.name) {
                this.errors.name = "";
            } else {
                this.errors.name = "管理者名は必須です。";
            }
            if (this.adminData.email) {
                if (this.mail_reg.test(this.adminData.email)) {
                    this.errors.email = "";
                } else {
                    this.errors.email = "※メールアドレスが正しくありません。もう一度入力してください。"
                }
            } else {
                this.errors.email = "メールアドレスは必須です。";
            }
            if (this.adminData.password) {
                this.errors.password = "";
            } else {
                this.errors.password = "パスワードは必須です。";
            }
            if (!this.errors.name && !this.errors.email && !this.errors.password) {
                this.add();
            }
        },
        add() {
            if (`${this.$route.params.id}` == "undefined") {
                if (this.adminData.password.length < 6) {
                    $('#newpasswordlength').css('display', 'block');
                    return;
                }{
                    this.$swal({
                        title: "確認",
                        text: "管理者を作成してよろしいでしょうか。",
                        type: "info",
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
                        this.$loading(true);
                        this.axios.post('/api/main_admin/add', this.adminData)
                            .then(response => {
                                this.$loading(false);
                                this.name = ''
                                this.$swal({
                                    position: 'top-end',
                                    type: 'success',
                                    text: '管理者を作成しました。',
                                    confirmButtonText: "閉じる",
                                    confirmButtonColor: "#31CD38",
                                    width: 350,
                                    height: 200,
                                    allowOutsideClick: false,
                                })
                                this.$router.push({
                                    name: 'adminlist'
                                });
                            }).catch(error => {
                                if (error.response.status == 422) {
                                    this.errors = error.response.data.errors
                                }
                            })
                    })
                }
            } 
        },
        password_validate() {
            window.pwd_same = false;
            if (this.new_password != this.confirm_password) {
                this.errors.edit_password = "※パスワードが一致しません。";
            } else {
                this.errors.edit_password = null;
                window.pwd_same = true;
            }
        },
        passwordToggleDiv() {
            $(".password-setting").toggle('medium');
            this.isRotate = !this.isRotate;
        },
        nameMailChange() {
            if (this.adminData.name) {
                this.errors.name = "";
            } else {
                this.errors.name = "管理者名は必須です。";
            }
            if (this.adminData.email) {
                if (this.mail_reg.test(this.adminData.email)) {
                    this.errors.email = "";
                } else {
                    this.errors.email = "※メールアドレスが正しくありません。もう一度入力してください。"
                }
            } else {
                this.errors.email = "メールアドレスは必須です。";
            }
            this.$swal({
                title: "確認",
                text: "管理者名とメールアドレスを更新してよろしいでしょうか。",
                type: "info",
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
                let arr = new FormData();
                    arr.append('admin_id', this.admin_id)
                    arr.append('name', this.adminData.name)
                    arr.append('email', this.adminData.email)
                    arr.append('old_pass', '')
                this.axios
                        .post(`/api/main_admin/update`, arr)
                        .then((response) => {
                           this.$swal({
                                    position: 'top-end',
                                    type: 'success',
                                    text: '管理者を更新しました',
                                    confirmButtonText: "閉じる",
                                    confirmButtonColor: "#31CD38",
                                    allowOutsideClick: false,
                                    width: 350,
                                    height: 200,
                                }) 
                                this.$router.push({
                                    name: 'adminlist'
                                });
                        }).catch(error => {
                            if (error.response.status == 422) {
                                this.errors = error.response.data.errors
                            }
                        });
            });
        },
        passwordChange() {
            if (this.old_password) {
                this.errors.old_password = "";
            }else{
                this.errors.old_password = "現在のパスワードは必須です。"
            }
            if (this.new_password) {
                this.errors.new_password = "";
            }else{
                this.errors.new_password = "新しいパスワードは必須です。"
            }
            if (this.confirm_password) {
                this.errors.confirm_password = "";
            }else{
                this.errors.confirm_password = "新しいパスワードをもう一度入力が必要です。"
            }
            if(!this.errors.old_password && !this.errors.new_password && !this.errors.confirm_password){
                if (this.new_password.length < 6) {
                    $('#newpasswordlength').css('display', 'block');
                    return;
                }
                this.$swal({
                    title: "確認",
                    text: "管理者を更新してよろしいでしょうか。",
                    type: "info",
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
                    if ("'" + this.new_password + "'" === "'" + this.confirm_password + "'") {
                        let arr = new FormData();
                        arr.append('admin_id', this.admin_id)
                        arr.append('name', this.adminData.name)
                        arr.append('email', this.adminData.email)
                        arr.append('old_pass', this.old_password)
                        arr.append('new_pass', this.new_password)
                        this.axios
                            .post(`/api/main_admin/update`, arr)
                            .then((response) => {
                                if (response.data == 'oldpasswordwrong') {
                                    this.$swal({
                                        position: 'top-end',
                                        type: 'error',
                                        text: '現在のパスワードに誤りがあります。',
                                        confirmButtonText: "閉じる",
                                        confirmButtonColor: "#FF5462",
                                        allowOutsideClick: false,
                                        width: 350,
                                        height: 200,
                                    })
                                    return;
                                } else {
                                    this.$swal({
                                        position: 'top-end',
                                        type: 'success',
                                        text: '管理者を更新しました。',
                                        confirmButtonText: "閉じる",
                                        confirmButtonColor: "#31CD38",
                                        width: 350,
                                        height: 200,
                                        allowOutsideClick: false,
                                    })
                                    this.password_confirmation = null;
                                    this.old_password = null;
                                    this.$router.push({
                                        name: 'adminlist'
                                    });
                                }
                            }).catch(error => {
                                if (error.response.status == 422) {
                                    this.errors = error.response.data.errors
                                }
                        });
                    } else {
                        this.$swal({
                            text: "新しいパスワードと確認パスワードは同じでなければなりません。",
                            type: "warning",
                            width: 350,
                            height: 200,
                            showCancelButton: true,
                            confirmButtonColor: "#EEA025",
                            cancelButtonColor: "#b1abab",
                            cancelButtonTextColor: "#000",
                            confirmButtonText: "閉じる",
                            confirmButtonClass: "all-btn",
                            allowOutsideClick: false,
                        })
                    }
                });
            }                                               
        },
    }
}
</script>
<style>
.error-star {
    color: #ff0000;
}
.password-setting {
    display: none;
}
.password-setting{
    padding: 10px;
    border: 1px dashed #2980b9;
    margin-top: 10px;
}
.header_bg{
    background:transparent;
}
.d_none{
    display: none;
}
.btn_min_width{
    min-width: 0px;
}
</style>
<template>   
    <div class="d-flex justify-content-center h-100 admin-list-container">      
        <div class="admin_card admin_registercard admin-list-wrapper">
            <div class="col-md-12 m-b-10">
                <router-link :to="{name:'news_list'}" class="btn btn-danger all-btn submit">管理者画面へ</router-link>
                <router-link :to="{name:'admincreate'}" class="float-right main-bg-color create-btn all-btn">
                    <i class="fas fa-plus-circle"></i> 管理者新規作成
                </router-link>                
            </div>
            <div class="col-md-12 admin-list">
                <h6 class="page-header header bg-style">管理者一覧</h6>
                <div class="scroll_responsive admin-list-table">
                    <table class="table table-hover custom-table">
                        <thead>
                            <tr>
                                <th>管理者名</th>
                                <th>メールアドレス</th>
                                <th></th>
                            </tr>
                        </thead> 
                        <tbody>
                            <tr v-for="admin in displayItems" :key="admin.id">
                                <td>{{admin.name}}</td>
                                <td >{{admin.email}}</td>
                                <td class="text-right">
                                    <router-link :to="{path: '/admin/edit/'+admin.id}" class="btn edit-borderbtn">編集</router-link>
                                    <button class="btn text-danger delete-borderbtn" @click="deleteFeature(admin.id)">削除</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-12" v-if="pagination">
                <nav aria-label="Page navigation example">
                    <ul class="pagination">
                        <li class="page-item">
                            <span class="spanclass pc-480" @click="first">
                                <i class='fas fa-angle-double-left'></i> 最初
                            </span>
                        </li>
                        <li class="page-item">
                            <span class="spanclass" @click="prev">
                                <i class='fas fa-angle-left'></i>
                                <span class="pc-paginate"> 前へ</span>
                            </span>
                        </li>
                        <li class="page-item" v-for="(i,index) in displayPageRange" :key="index" :class="{active_page: i-1 === currentPage}">
                            <span class="spanclass" @click="pageSelect(i)">{{i}}</span>
                        </li>
                        <li class="page-item">
                            <span class="spanclass" @click="next">
                                <span class="pc-paginate">次へ </span>
                                <i class='fas fa-angle-right'></i>
                            </span>
                        </li>
                        <li class="page-item">
                            <span class="spanclass pc-480" @click="last">最後 
                                <i class='fas fa-angle-double-right'></i>
                            </span>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>    
</template>
<script>
export default {
    data() {
        return {
            admin_list :[],
            isOpen: false,
            currentPage: 0,
            size: 10,
            pageRange: 5,
            pagination: false,
        }
    },
    created (){
        this.axios.get("/api/main_admin/admin_list").then(response => {
            this.admin_list = response.data;
            if(this.admin_list.length > this.size) {
                this.pagination = true;
            } else {
                this.pagination = false;
            }
        });
    },
    computed: {
        pages() {
            return Math.ceil(this.admin_list.length / this.size);
        },
        displayPageRange() {
            const half = Math.ceil(this.pageRange / 2);
            const isEven = this.pageRange % 2 == 0;
            const offset = isEven ? 1 : 2;
            let start, end;
            if (this.pages < this.pageRange) {
                start = 1;
                end = this.pages;
            } else if (this.currentPage < half) {
                start = 1;
                end = start + this.pageRange - 1;
            } else if (this.pages - half < this.currentPage) {
                end = this.pages;
                start = end - this.pageRange + 1;
            } else {
                start = this.currentPage - half + offset;
                end = this.currentPage + half;
            }
            let indexes = [];
            for (let i = start; i <= end; i++) {
                indexes.push(i);
            }
            return indexes;
        },
        displayItems() {
            const head = this.currentPage * this.size;
            return this.admin_list.slice(head, head + this.size);
        },
        isSelected(page) {
            return page - 1 == this.currentPage;
        }
    },
    methods: {
        deleteFeature(id) {
            this.$swal({
                // title: "確認",
                text: "特徴を削除してよろしいでしょうか。",
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
                this.axios
                .delete(`/api/main_admin/delete/${id}`)
                .then(response => {
                    this.admin_list = response.data;
                    this.$swal({
                        text: "特徴を削除しました。",
                        type: "success",
                        width: 350,
                        height: 200,
                        confirmButtonText: "閉じる",
                        confirmButtonColor: "#31CD38",
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
        first() {
            this.currentPage = 0;
            $("html, body").animate({ scrollTop: 0 }, "slow");
            // window.scrollTo(0,0);
        },
        last() {
            this.currentPage = this.pages - 1;
            $("html, body").animate({ scrollTop: 0 }, "slow");
            // window.scrollTo(0,0);
        },
        prev() {
            if (0 < this.currentPage) {
            $("html, body").animate({ scrollTop: 0 }, "slow");
            this.currentPage--;
        }
        // window.scrollTo(0,0);
        },
        next() {
            if (this.currentPage < this.pages - 1) {
            $("html, body").animate({ scrollTop: 0 }, "slow");
            this.currentPage++;
        }
        // window.scrollTo(0,0);
        },
        pageSelect(index) {
            this.currentPage = index - 1;
            $("html, body").animate({ scrollTop: 0 }, "slow");
            // window.scrollTo(0,0); 
        },
    }
}
</script>
<style>
    .bg-style{
        background:transparent;
    }
</style>
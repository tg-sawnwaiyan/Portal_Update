<template>
    <div id="customer_list">
        <div class="col-md-12  tab-content">
            <div class="p-2 p0-480">
                <div v-if="norecord_msg" class="card card-default card-wrap">
                    <p class="record-ico">
                        <i class="fa fa-exclamation"></i>
                    </p>                   
                    <p class="record-txt01">介護施設事業者が登録されていません。</p>                 
                </div>
                <div v-else class="container-fuid">
                    <h4 class="main-color mb-3">事業者検索 </h4>
                    <div class="row mb-4 advanced-search">
                        <div class="col-xl-7 col-md-11">                      
                            <autocomplete id="cusname"  placeholder="事業者名で検索" input-class="form-control" :source=customerList :results-display="formattedDisplay" @clear="clearcustomer()"  @selected="getselected($event)">
                            </autocomplete>                           
                        </div> 
                       
                        <div class="col-xl-5 col-md-13 p-t-1024 form-check form-check-inline choose-item m-t-10">                          
                            <label class="form-check-label control control--checkbox"  style="padding-left:5px;">
                            <input type="checkbox" class="form-check-input" value="1"   v-model="recordstatus" @change="searchCustomer()">
                            有効
                            <div class="control__indicator"></div>
                            </label>
                            <label class="form-check-label control control--checkbox" style="padding-left:5px;" @change="searchCustomer()">
                            <input type="checkbox" class="form-check-input" value="0" v-model="recordstatus"  >
                            無効
                            <div class="control__indicator"></div>
                            </label>
                            <label class="form-check-label control control--checkbox" style="padding-left:5px;" @change="searchCustomer()">
                            <input type="checkbox" class="form-check-input" value="2" v-model="status"  >
                            未承認
                            <div class="control__indicator"></div>
                            </label>
                            <label class="form-check-label control control--checkbox" style="padding-left:5px;" @change="searchCustomer()">
                            <input  type="checkbox" class="form-check-input" value="0" v-model="status" >
                            登録承認審査中
                            <div class="control__indicator"></div>
                            </label>                            
                        </div>
                    </div>
                    <p v-if="customers.total != 0" class="">
                    検索結果：{{customers.total}}件が該当しました
                    </p>                          
                      
                    <div v-if="nosearch_msg" class="card card-default card-wrap no_search_data">
                        <p class="record-ico">
                            <i class="fa fa-exclamation"></i>
                        </p>
                        <p class="record-txt01"> 検索キーワードに該当する事業者は存在しません。</p>                        
                    </div>                        
                       
                    <div v-else class="container-fuid">
                        <table class="table table-bordered">
                            <tr v-for="customer in customers.data" :key="customer.id">
                                <td  class="p-3">
                                    <div class="row m-0">
                                        <div class="col-sm-12 p-0">
                                            <div class="row boot-xl">
                                                <div class="col-xl-1 col-lg-2 col-md-4 custom_title">
                                                    <strong>事業者番号</strong>
                                                </div>
                                                <div class="col-xl-11 col-lg-10 col-md-8"><span class="pc-414-inline">: &nbsp;</span>{{customer.cusnum}}</div>
                                            </div>
                                            <div class="row boot-xl">
                                                <div class="col-xl-1 col-lg-2 col-md-4 custom_title">
                                                    <strong>事業者名</strong>
                                                </div>
                                                <div class="col-xl-11 col-lg-10 col-md-8"><span class="pc-414-inline">: &nbsp;</span>{{customer.name}}</div>
                                            </div>
                                            <div class="row boot-xl">
                                                <div class="col-xl-1 col-lg-2 col-md-4 custom_title">
                                                    <strong >状態</strong>
                                                </div>
                                                <div class="col-xl-11 col-lg-10 col-md-8" v-if="customer.status == 0" ><span class="pc-414-inline">: &nbsp;</span>登録承認審査中</div>
                                                <div class="col-xl-11 col-lg-10 col-md-8" v-else><span class="pc-414-inline">: &nbsp;</span>
                                                    <span v-if="customer.recordstatus == '1'" >有効</span>
                                                    <span v-else >無効</span>
                                                </div>
                                            </div>
                                            <div class="row boot-xl">
                                                <div class="col-xl-1 col-lg-2 col-md-4 custom_title">
                                                    <strong>メールアドレス</strong>
                                                </div>
                                                <div class="col-xl-11 col-lg-10 col-md-8"><span class="pc-414-inline">: &nbsp;</span>{{customer.email}}</div>
                                            </div>
                                            <div class="row boot-xl">
                                                <div class="col-xl-1 col-lg-2 col-md-4 custom_title">
                                                    <strong>電話番号</strong>
                                                </div>
                                                <div class="col-xl-11 col-lg-10 col-md-8"><span class="pc-414-inline">: &nbsp;</span>{{customer.phone}}</div>
                                            </div>
                                            
                                            <div class="row mt-3">
                                                <div class="col-md-12">
                                                    <button class="btn delete-borderbtn mr-2 mb-2" v-if="customer.status != 0" @click="deleteCustomer(customer.id,'delete')">削除</button>
                                                    <button class="btn delete-borderbtn mr-2 mb-2" v-if="customer.status == 0" @click="deleteCustomer(customer.id,'denied')">新規登録承認しない</button>
                                                    
                                                    <button class="btn confirm-borderbtn  mb-2" :id="'confirm-btn'+customer.id" v-if="customer.status == 0" @click="comfirm(customer.id)"><i class="fa fa-check" aria-hidden="true"></i>&nbsp;新規登録承認</button>
                                                    
                                                    <span v-else class="">                                                  
                                                    <span v-if="customer.status == 1 && customer.recordstatus == 0" class="btn confirm-disable-orangebtn mr-2 mb-2"><i class="fa fa-list"></i> 施設一覧</span>
                                                    <router-link :to="{ path:'/accountlist/'+ type +'/'+ customer.id}" v-if="customer.status == 1 && customer.recordstatus == 1" class="btn confirm-orangebtn mr-2 mb-2"><i class="fa fa-list"></i> 施設一覧</router-link>
                                                    <router-link :to="{ path:'/profiledit/'+ type +'/'+ customer.id}" v-if="customer.status == 1" class="btn confirm-orangebtn mb-2"><i class="fa fa-edit"></i> プロフィール設定</router-link>
                                                    <p class="mt-2" style="color: #81ad3b;font-weight: bold;" v-if="customer.status == 1"><i class="fa fa-check-circle" aria-hidden="true"></i>&nbsp;この事業者は登録承認済です。</p>
                                                    <p class="mt-2" style="color: #7bbcdc;font-weight: bold;" v-if="customer.status == 2"><i class="fa fa-check-circle" aria-hidden="true"></i>&nbsp;この事業者は登録不許可です。</p>
                                                    </span>                                                    
                                                </div>
                                            </div>
                                        </div>                                        
                                    </div>
                                </td>
                            </tr>
                        </table>                        
                    </div>
                    <div>
                        <pagination :data="customers" @pagination-change-page="searchCustomer" :limit="limitpc">
                                <span slot="prev-nav"><i class="fas fa-angle-left"></i> 前へ</span>
                                <span slot="next-nav">次へ <i class="fas fa-angle-right"></i></span>
                          </pagination>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
  import Autocomplete from 'vuejs-auto-complete'
    export default {
         components: {
            Autocomplete,
        },

         props:{
            limitpc: {
                type: Number,
                default: 5
            },
        },
        data() {
                return {
                    customers: [], items: [], norecord: 0, norecord_msg: false, nosearch_msg: false, title: '', type: null, status:'', searchkeyword:'', customerList:'', profileList:[], recordstatus :[], status:[], table_name: { profile: '' }, cusid:'',                  
                };
            },
            created() {
                this.$loading(true);
                this.initialCall();               
                  this.axios.get('/api/job/customerList/'+this.type).then(response=> {
                    this.customerList = response.data;
                });
            },
            methods: {               
                initialCall(){
                    if(this.$route.path == "/nuscustomerlist"){
                        this.type = "nursing";
                        this.title = "介護施設事業者一覧";
                        this.axios.get("/api/customers/3").then(response => {
                            this.$loading(false);
                            this.customers = response.data;
                            this.norecord = this.customers.data.length;
                            if(this.norecord != 0){
                                this.norecord_msg = false;
                            }else{
                                this.norecord_msg = true;
                            }
                        });
                    }
                    else if(this.$route.path == "/hoscustomerlist"){
                        this.type = "hospital";
                        this.title = "病院事業者一覧";
                        this.axios.get("/api/customers/2").then(response => {
                            this.$loading(false);
                            this.customers = response.data;
                            this.norecord = this.customers.data.length;
                            if(this.norecord != 0){
                                this.norecord_msg = false;
                            }else{
                                this.norecord_msg = true;
                            }
                        });
                    }
                },
                getselected($event){                  
                    this.cusid = $event.display;
                    this.searchCustomer();
                },
                clearcustomer(){
                    this.cusid = '';
                    this.searchCustomer();
                },                          
                deleteCustomer(id,type) {
                    if(type == 'delete'){
                        var textval = '事業者を削除してよろしいでしょうか。';
                    }
                    else{
                        var textval = '本当に承認しなくてよろしいでしょうか。<br/>承認しない場合事業者情報が削除されます。';
                    }
                    
                        this.$swal({
                            html: textval,
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
                            this.axios.delete(`/api/customer/delete/${id}/${type}`).then(response => {
                                this.$loading(false);
                                // this.customers = response.data.customers;
                                this.initialCall();
                                // this.$swal({
                                // // title: "削除済",
                                // text: "事業者を削除しました。",
                                // type: "success",
                                // width: 350,
                                // height: 200,
                                // confirmButtonText: "閉じる",
                                // confirmButtonColor: "#dc3545",
                                // allowOutsideClick: false,
                                // });
                                if(this.norecord != 0){
                                    this.norecord_msg = false;
                                }else{
                                    this.norecord_msg = true;
                                }
                                // let a = this.customers.map(item => item.id).indexOf(id);
                                // this.customers.splice(a, 1);

                            });
                            
                        }).catch(error => {
                            this.$loading(false);
                        });
                    },
                    comfirm(id) {
                        this.$swal({
                            // title: "確認",
                            text: "本当に承認してよろしいでしょうか。",
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
                            this.axios.get(`/api/confirm/${id}`).then(response => {
                                this.initialCall();
                                // this.displayItems();
                                if (response.data.status == 'success') {
                                    this.$swal({
                                        title: "新規登録承認",
                                        text: "事業者にメールを送信しました。",
                                        type: "success",
                                        width: 350,
                                        height: 200,
                                        confirmButtonText: "閉じる",
                                        confirmButtonColor: "#31cd38",
                                        allowOutsideClick: false,
                                    });
                                } else {
                                    this.$swal({
                                        title: "新規登録承認",
                                        text: "顧客はすでに確認されています。",
                                        type: "warning",
                                        width: 350,
                                        height: 200,
                                        confirmButtonText: "閉じる",
                                        confirmButtonColor: "#31cd38",
                                        allowOutsideClick: false,
                                    });
                                }
                                this.$loading(false);
                            });
                        }).catch(error => {
                            this.$loading(false);
                        })
                        
                    },
                  

                    searchCustomer(page) {

                     
                        if(typeof page === "undefined"){
                            page = 1;
                        }
                      
                        let fd = new FormData();
                        fd.append("status",this.status)
                        fd.append("recordstatus",this.recordstatus);
                        fd.append("cusid",this.cusid);
                      
                        if(this.$route.path == "/nuscustomerlist"){
                            fd.append("type",3)
                        }
                        else{
                            fd.append("type",2)
                        }
                        this.$loading(true);
                        $("html, body").animate({ scrollTop: 0 }, "slow");
                        this.axios.post("/api/customer/search?page="+page, fd).then(response => {
                            this.$loading(false);
                            this.customers = response.data;
                            this.norecord = this.customers.data.length; 
                         
                            if(this.customers.data.length != 0) {
                                this.nosearch_msg = false;
                            }else{
                                this.nosearch_msg = true;
                            }
                        });
                    },
                    imgUrlAlt(event) {
                        event.target.src = "/images/noimage.jpg"
                    },                    
            }
    };
</script>

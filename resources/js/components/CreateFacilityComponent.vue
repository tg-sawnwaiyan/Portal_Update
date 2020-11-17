<template>    
  <div id="create_fact">
    <div class="card">
      <div class="card-body">                
        <div class="row">
          <div class="col-md-12">
            <h4 class="page-header header">{{title}}</h4>
          </div>
          <div class="col-md-12">
            <form>
              <div class="form-group">
                <label>院内施設 <span class="error sp2">必須</span></label>
                <input type="text" class="form-control"  v-model="facility.description"  :placeholder='[[placeholder]]' >
                <span v-if="errors.description" class="error">{{errors.description}}</span>
              </div>
              <div class="form-group">
                <router-link to="/facilitieslist" class="btn bt-red all-btn">キャンセル</router-link>    
                <span class="btn main-bg-color white all-btn" @click="checkValidate()"> {{buttontext}}</span>
                <!-- <button class="btn news-post-btn all-btn" > 作成する </button> -->
                <!-- <router-link to="/facilitieslist" class="btn news-post-btn all-btn">更新</router-link> -->
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
        description:"",
      },
      facility: {
        description: ""
      },
      title:'',
      label:'',
      placeholder:'',
      buttontext:''
    };
  },
  created() {
    if(this.$route.name == "editfacility"){
      this.title = "院内施設編集";
      this.label = "院内施設:";
      this.placeholder = "院内施設名を入力してください";
      this.buttontext = "保存";
      this.axios
      .get(`/api/facility/edit/${this.$route.params.id}`)
      .then(response => {
        this.facility = response.data;
      });
    }
    else{
      this.title = "院内施設新規作成";
      this.label = "院内施設:";
      this.placeholder = "院内施設名を入力してください";
      this.buttontext = "作成";
    }
  },
  methods: {
    add() {
      this.$swal({
        text: "院内施設を投稿してよろしいでしょうか。",
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
      .then(response => {
        this.$loading(true); 
        this.axios.post("/api/facility/add", this.facility)
        .then((response) => {
          this.$loading(false);
          this.name = ''
          this.$swal({
            position: 'top-end',
            type: 'success',
            text: '院内施設を投稿しました。',                            
            confirmButtonText: "閉じる",
            confirmButtonColor: "#31cd38",
            width: 350,
            height: 200,
            allowOutsideClick: false,
          })
          this.$router.push({ name: "facilitieslist" });
        })
        .catch(error=>{
          if(error.response.status == 422){
            this.errors = error.response.data.errors
          }
        });
      });
    },
    updateFacility() {
      this.$loading(true);
      this.axios.post(`/api/facility/update/${this.$route.params.id}`, this.facility).then(response =>{
          this.$loading(false);
          this.description = "";
          this.$swal({
            position: 'top-end',
            type: 'success',
            text: '院内施設を更新しました。',
            confirmButtonText: "閉じる",
            confirmButtonColor: "#31cd38",
            width: 350,
            height: 200,
            allowOutsideClick: false,
          })
          this.$router.push({ name: "facilitieslist" });
        }).catch(error => {
          if (error.response.status == 422) {
          this.errors = error.response.data.errors;
        }
      });
    },
    checkValidate() {
      if (this.facility.description) {
        this.errors.description = "";
      } 
      if(!this.facility.description && !this.$route.params.id){
        this.errors.description = " 院内施設の種類は必須です。";
      }
      else if(!this.facility.description && this.$route.params.id){
        this.errors.description = " 施設の種類は必須です。";
      }
      if ( !this.errors.description && !this.$route.params.id ) {
        this.add();
      }
      else if(!this.errors.description && this.$route.params.id){
        this.updateFacility();
      }
    },
  }
};
</script>
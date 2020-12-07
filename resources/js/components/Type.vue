<template>
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <div class="row">
            <div class="col-md-12">
              <h4 class="page-header header">{{ header }}</h4>
            </div>
            <div class="col-md-12">
              <form @submit.prevent="add" autocomplete="off">
                <div class="form-group">
                  <label>
                    事業者の種類 :
                    <span class="error">*</span>
                  </label>
                  <input type="text" class="form-control" v-model="Type.name" placeholder="事業者の種類" />
                  <span v-if="errors.name" class="error">{{errors.name}}</span>
                </div>
                <div class="form-group">
                  <label>
                    ペアレント :
                    <span class="error">*</span>
                  </label>
                  <select v-model="selectedValue" class="form-control" @change="getParent()">
                    <option value="0">なし</option>
                    <option
                      v-for="typelist in TypeList"
                      :key="typelist.id"
                      v-bind:value="typelist.id"
                    >{{typelist.name}}</option>
                  </select>
                </div>
                <br />
                <div class="form-group">
                  <router-link class="btn btn-danger all-btn" to="/typelist">キャンセル</router-link>
                  <span class="btn main-bg-color white all-btn" @click="checkValidate()"> {{subtitle}}</span>
                </div>
              </form>
            </div>
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
        name:"",
      },
      categories: {
        id: '',
        name: ''
      },
      Type: {
        name: "",
        parent: "",
      },
      TypeList: {
        id: "",
        name: ""
      },
      selectedValue: 0,
      header: "タイプ作成",
      subtitle: "作成する"
    };
  },
  created() {
    this.axios.get("/api/types/typelist").then(
      function(response) {
        this.TypeList = response.data;
      }.bind(this)
    );
  },
  mounted() {
    if (this.$route.params.id) {
      this.axios
        .get(`/api/types/edit/${this.$route.params.id}`)
        .then(response => {
          this.Type.name = response.data.name;
          this.Type.parent = response.data.parent;
          this.selectedValue = response.data.parent;
          this.TypeList.name = response.data.name;
          this.header = " タイプ更新";
          this.subtitle = "更新する";
          return this.header;
          return this.subtitle;
        });
    }
  },
  methods: {
    add() {
      if (this.$route.params.id) {
        this.updateType();
      } else {
        this.$swal({
          title: "確認",
          text: "作成よろしいでしょうか",
          type: "info",
          width: 350,
          height: 200,
          showCancelButton: true,
          confirmButtonColor: "#6cb2eb",
          cancelButtonColor: "#b1abab",
          cancelButtonTextColor: "#000",
          cancelButtonText: "キャンセル",
          confirmButtonText: "作成",
          confirmButtonClass: "all-btn",
          cancelButtonClass: "all-btn",
          allowOutsideClick: false,
        }).then(response => {
          this.axios
          .post("/api/types/add", this.Type)
          .then(response => {
            this.name = "";
            this.$swal({
              position: "top-end",
              type: "作成済",
              title: "作成されました",
              text: "事業者の種類を作成されました。",
              type: "success",
              width: 350,
              height: 200,
              confirmButtonText: "はい",
              confirmButtonColor: "#6cb2eb",
              allowOutsideClick: false,
            });
            this.$router.push({ name: "typelist" });
          })
          .catch(error => {
            if (error.response.status == 422) {
              this.errors = error.response.data.errors;
            }
          });
        });
      }
    },
    getParent: function() {
      this.Type.parent = this.selectedValue;
    },
    updateType() {
      this.$swal({
        title: "確認",
        text: "編集をよろしでしょうか。",
        type: "info",
        width: 350,
        height: 200,
        showCancelButton: true,
        confirmButtonColor: "#6cb2eb",
        cancelButtonColor: "#b1abab",
        cancelButtonTextColor: "#000",
        cancelButtonText: "キャンセル",
        confirmButtonText: "更新",
        confirmButtonClass: "all-btn",
        cancelButtonClass: "all-btn",
        allowOutsideClick: false,
      }).then(response => {
        this.axios
          .post(`/api/types/update/${this.$route.params.id}`, this.Type)
          .then(response => {
            this.types = response.data;
            this.norecord = this.types.length;
            this.$swal({
              title: "更新済",
              text: "事業者の種類を更新されました。",
              type: "success",
              width: 350,
              height: 200,
              confirmButtonText: "はい",
              confirmButtonColor: "#6cb2eb",
              allowOutsideClick: false,
            });
            this.$router.push({ name: "typelist" });
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
    checkValidate() {
      if (this.Type.name) {
        this.errors.name = "";
      } else {
        this.errors.name = " 事業者の種類は必須です。";
      }
      if (!this.errors.name) {
        this.add();
      }
    }
  }
};
</script>

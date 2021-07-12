<template>
  <div class="tab-content job-detail margin-none">
    <div class="col-md-12 pad-free m-b-20">
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb" v-if="!$auth.check()">
          <li class="breadcrumb-item"><a href="/" class="router-link-active">ホーム</a></li>
          <li aria-current="page" class="breadcrumb-item active">求人詳細</li>
        </ol>
        <a @click="$router.go(-1)" v-if="$route.params.id && $auth.check(2)" class="btn btn-danger all-btn submit float-right pc-990"><i class="fas fa-arrow-left"></i>&nbsp;戻る</a>
      </nav>
      
     
    </div>
      <div class="col-12 m-b-15" v-if="job_details.length>0">
        <h5 class="subtitle" style=""><strong>施設名:</strong> {{job_details[0].cusname}} </h5>
      </div>
    
    <div class="row m-0" v-for="jobDetail in job_details" :key="jobDetail.id">
     
      <div class="col-12 p0-480">
        <h4 class="job-title-color">{{jobDetail.title}} </h4>
        <label class="job_id" style="color:#000;">求人番号: {{jobDetail.jobid}}</label>

      </div>
      <div class="col-xl-10 col-md-12 col-12 offset-xl-1 p0-480">
        <!-- <img src="/images/img1.jpg" class="img-responsive" style="width:150px;"> -->

        <div class="form-wrap mt-3 mb-3">
          <div class="form-group m-0 row bd">
            <div class="col-md-2 col-sm-12 form-left">
              <label><span class="job_ico"><i class="fa fa-file"></i></span>仕事内容</label>
            </div>
            <div class="col-md-10 col-sm-12 form-right">{{jobDetail.description}}</div>
          </div>
          <div class="form-group m-0 row bd">
            <div class="col-md-2 col-sm-12 form-left">
              <label><span class="job_ico"><i class="fa fa-star"></i></span>経験・スキル</label>
            </div>
            <div class="col-md-10 col-sm-12 form-right">{{jobDetail.skills}}</div>
          </div>
          <div class="form-group m-0 row bd">
            <div class="col-md-2 col-sm-12 form-left">
              <label><span class="job_ico"><i class="fa fa-map-marker-alt"></i></span>都道府県</label>
            </div>
            <div class="col-md-10 col-sm-12 form-right">{{jobDetail.city_name}}</div>
          </div>
          <div class="form-group m-0 row bd">
            <div class="col-md-2 col-sm-12 form-left">
              <label><span class="job_ico"><i class="fa fa-map-marker-alt"></i></span>市区町村</label>
            </div>
            <div class="col-md-10 col-sm-12 form-right">{{jobDetail.township_name}}</div>
          </div>
          <div class="form-group m-0 row bd">
            <div class="col-md-2 col-sm-12 form-left">
              <label><span class="job_ico"><i class="fa fa-map-marker-alt"></i></span>勤務地</label>
            </div>
            <div class="col-md-10 col-sm-12 form-right"><pre>{{jobDetail.location}}</pre></div>
          </div>

          <div class="form-group m-0 row bd">
            <div class="col-md-2 col-sm-12 form-left">
              <label><span class="job_ico"><i class="fa fa-map-signs"></i></span>最寄り駅</label>
            </div>
            <div class="col-md-10 col-sm-12 form-right"><pre>{{jobDetail.nearest_station}}</pre></div>
          </div>
          <div class="form-group m-0 row bd">
            <div class="col-md-2 col-sm-12 form-left">
              <label><span class="job_ico">類</span>雇用形態</label>
            </div>
            <div class="col-md-10 col-sm-12 form-right"><p class="job_status">{{jobDetail.employment_status}} </p></div>
          </div>
          <div class="form-group m-0 row bd">
            <div class="col-md-2 col-sm-12 form-left">
              <label><span class="job_ico">&#xa5;</span>給料</label>
            </div>
            <div class="col-md-10 col-sm-12 form-right"> {{jobDetail.salary}}  <span v-if="jobDetail.salary_remark"> ( {{ jobDetail.salary_remark }} ) </span></div>
            <!-- {{jobDetail.salary_type}} : {{(Number(jobDetail.salary)).toLocaleString()}} 円 -->
          </div>
          <div class="form-group m-0 row bd">
            <div class="col-md-2 col-sm-12 form-left">
              <label><span class="job_ico"><i class="fa fa-briefcase"></i></span>特別な条件</label>
            </div>
            <div class="col-md-10 col-sm-12 form-right"><pre>{{jobDetail.allowances}}</pre></div>
          </div>
          <div class="form-group m-0 row bd">
            <div class="col-md-2 col-sm-12 form-left">
              <label><span class="job_ico"><i class="fa fa-id-card"></i></span>各種保険</label>
            </div>
            <div class="col-md-10 col-sm-12 form-right"><pre>{{jobDetail.insurance}}</pre></div>
          </div>
          <div class="form-group m-0 row bd">
            <div class="col-md-2 col-sm-12 form-left">
              <label><span class="job_ico"><i class="fa fa-clock"></i></span>就業時間</label>
            </div>
            <div class="col-md-10 col-sm-12 form-right"><pre>{{jobDetail.working_hours}}</pre></div>
          </div>
          <div class="form-group m-0 row bd">
            <div class="col-md-2 col-sm-12 form-left">
              <label><span class="job_ico">休</span>休日休暇</label>
            </div>
            <div class="col-md-10 col-sm-12 form-right"><pre>{{jobDetail.holidays}}</pre></div>
          </div>
          <div class="form-group m-0 row bd-all">
            <div class="col-md-2 col-sm-12 form-left">
              <label><span class="job_ico"><i class="fa fa-building"></i></span>施設名</label>
            </div>
            <div class="col-md-10 col-sm-12 form-right">  
                 
              <div v-if="jobDetail.type_id == 2">   
                  <div v-if="jobDetail.activate == 0">
                    <span>{{jobDetail.cusname}}</span>
                    <span class="disabledlink">施設詳細</span>
                  </div>
                  <div v-else>
                      <span>{{jobDetail.cusname}}</span>
                     <router-link  class="enabledlink" :to="{ path:'/profile/hospital/'+jobDetail.profile_id }">施設詳細</router-link>                    
                  </div>          
              </div>
              <div v-else> 
                 <div v-if="jobDetail.activate == 0">
                    <span>{{jobDetail.cusname}}</span>
                    <span class="disabledlink">施設詳細</span>                     
                  </div>
                  <div v-else>
                    <span>{{jobDetail.cusname}}</span>
                    <router-link  class="enabledlink" :to="{ path:'/profile/nursing/'+jobDetail.profile_id }">施設詳細</router-link>                    
                  </div>    
              </div>
              
            </div>
          </div>
          <!-- <h4 style="padding:3px;"></h4> -->
          <div class="row mt-4">
            <div class="col-md-12 text-center">
              <!-- <button type="button" class="btn btn-warning btn-width white">戻る</button> -->
              <!-- <span class="btn main-bg-color white all-btn" @click="jobApply()">確認画面へ進む</span> -->
              <router-link :to="{name: 'jobapply', params: { job_id: job_id }}"
              class="btn job_detail_btn" v-if="!$auth.check()">この案件に応募する</router-link>
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
      job_details: [],
      job_id: "",
      login_user: Boolean,
      active:0,

    };
  },
  created() {
    this.axios
      .get(`/api/job_details/${this.$route.params.id}`)
      .then(response => {
        this.job_details = response.data;
        // console.log("res",response.data);
        var catname = this.job_details[0].type_id == 2? '病院':'介護';

        this.$ga.event({
          eventCategory: '求人',
          eventAction: catname+'/'+this.job_details[0].jobid+'/'+this.job_details[0].title,
        }) 
      });
    this.job_id = this.$route.params.id;
  },
  mounted() {
      $('#navtab').removeClass('news-tabColor hospital-tabColor nursing-tabColor job-tabColor');
      $('#navtab').addClass('hospital-tabColor');
      $('.tab-content').removeClass('news-borderColor job-borderColor nursing-borderColor hospital-borderColor');
      $('#upper-tab').addClass('hospital-borderColor margin-none');
      $('.google_search_div').addClass('google_search_all');
      $('#headerbar').addClass('headerbarblock');
      $('#sp_headerbar').addClass('headerbarblock');
      $('.maintab-content').addClass('margin-top-none');
  },
};
</script>

<template>
  
<layout>
  <div id="news_details">
    <!-- news details-->

    <!-- Tab panes -->
    <div class="tab-content1 tabs">
      <div role="tabpanel" class="tab-pane active" id="tab1">
        <div class="row col-sm-12 margin-free-750">
          <nav aria-label="breadcrumb" v-if="othersDetails">
            <ol class="breadcrumb">
              <li class="breadcrumb-item">
                <router-link to="/">ホーム</router-link>
              </li>
              <li class="breadcrumb-item active" aria-current="page">ニュース詳細</li>
            </ol>
          </nav>
          <!-- <span v-else>Back</span> -->
          <div v-else class="d-flex justify-content-end mb-4">
              <router-link to="/news_list" class="mr-2 btn btn-danger all-btn submit"><i class="fas fa-arrow-left"></i>&nbsp;戻る</router-link>
              <router-link v-if="getData"  :to="{ path:'/editPost/'+ newdetails[0].id}" class="btn edit-borderbtn">編集</router-link>&nbsp;
          </div>
          
        </div>
        <div class="justify-content-md-center scrolldiv2">
          <div class="col-md-12 pad-free">
            <div class="row m-lr-0 mb-3" v-for="news in newdetails" :key="news.id">
             
                <div class="col-md-12" >
                  <h4 class="header news_detail_tit" style="margin-bottom: 0px;">                  
                    <!-- <span class="breaking-news-tip"> {{news.cat_name}}</span> -->
                    {{news.title}}
                  </h4>  
                  <div class="detail-block">
                    <span v-if="news.created_by_company" class="news-create-cmp">
                      {{news.created_by_company}}
                    </span>
                    <div class="set-date">
                      <p :class="news.cat_id == 26 ? 'title26': 'title_color'" :style="{'--color': news.color_code ? news.color_code : '#287db4'}">
                       <span>{{news.cat_name}}</span>
                       <small style="color:#aaa;"  v-if="news.cat_name != 'PR'" >
                         <i class="fa fa-calendar-alt"></i>
                         &nbsp;&nbsp;{{news.created_at}}
                      </small>
                      </p>   
                  </div>
                  </div>
                </div>
                <div class="col-12">
                  <div class="float-left mr-4 newsDetail_leftwrapper">
              
                    <div class="img-wrap mb-2" v-if="!noimage" >
                      <img :src="'/upload/news/'+ news.photo"  class="img-responsive img_2" :alt="news.cat_name+'ニュース画像'" @error="imgUrlAlt" style="max-width:100%;"  />
                    </div>
                   
                    <p class="img_2 details_title mb-1">{{news.main_point}}</p>
                  </div>
                  <div>
                    <p class="p5 mb-2 text-justify" v-html="news.body"></p>
                    <!--for quill upload image (@author: pzo) -->
                    <!-- <div class="img-wrap mb-2" v-if="news.quill_photo" >
                      <img :src="'/upload/news/'+ news.quill_photo"  class="img-responsive img_2" alt="img" @error="imgUrlAlt" style="max-width:100%;"  />
                    </div> -->
                    <!-- end quill image -->
                  </div>
                </div>
                <span v-if="news.created_by" style="font-size: 1rem;line-height: 1.384;color: #666;display: inline-block;margin: 1rem auto 0;">
                  {{news.created_by}}
                </span>
                
            </div>
            
          <section v-for="news in newdetails" :key="news.id">
          <div v-if="news.cat_name != 'PR'">
            <div class="row col-md-12 m-lr-0 m-t-15" v-if="latest_post_all_cats.length > 0">   
                <div  class="row col-md-12 text-center m-lr-0 pad-free" style="border-top: 2px dashed #eee;" v-if="latest_post_all_cats.length != 0">
                  <h4 class="h4 next-title" style="border-left: 5px solid #2980b9;" >関連ニュース</h4>
                </div>
                <div class="related_content">
                <div class="related_box mt-2" v-for="latest_post_all_cat in latest_post_all_cats" :key="latest_post_all_cat.id" >
                  <router-link :to="'/newsdetails/'+ latest_post_all_cat.id">
                    <div class="hovereffect fit-image" style="cursor:pointer;">
                      <img class="img-responsive fit-image" v-bind:src="'/upload/news/' + latest_post_all_cat.photo" :alt="latest_post_all_cat.cat_name+'ニュース画像'"  @error="imgUrlAlt1"/>
                      <div class="overlay">
                        <span class="btn btn-sm all-btn secondary-bg-color m-t-20">詳細</span>
                      </div>
                      <div class="info">
                        <div class="row">
                          <div class="col-12 p-0">
                            <p class="p_3">{{ latest_post_all_cat.main_point }}</p>
                          </div>
                        </div>
                      </div>
                    </div>
                  </router-link>
                </div>
                </div>
              </div>
              </div>
              </section>
          </div>
        </div>
      </div>
     
    </div>
    <!--end Tab panes-->
  </div>
  <!-- end news details-->
  </layout>
</template>

<script>
import { eventBus } from '../event-bus.js';
import layout from '../components/home.vue'
export default {
  components: {
    layout
  },

  data() {
    return {
      newdetails: [],
      latest_post_all_cats: [],
      othersDetails: true,
      getData:false,
      noimage:false,
    };
  },
  mounted() {
    $('#upper-tab').addClass('margin-none');
  },
  created() {
    this.scrollToTop();
    this.noimage = false;
    if(this.$route.path.includes("/newsdetails") && this.$auth.check(2) && this.visit == 'false'){
        this.othersDetails = false;
    }
    else{
        this.othersDetails = true;
    }

    this.axios
      .get(`/api/newdetails/${this.$route.params.id}`)
      .then(response => {
        this.newdetails = response.data.news;
        eventBus.$emit('gotColor', this.newdetails[0].color_code);
        this.getData = true; 
        this.$ga.event({
          eventCategory: 'ニュース',
          eventAction: this.newdetails[0].cat_name+' / '+this.newdetails[0].title,
        })     
      });   

    this.relatedNews(this.$route.params.id);
  },
  updated:function(){
        $(".gNav .router-link-active").addClass("router-link-exact-active");
    },
  beforeDestroy:function(){
        $(".gNav .router-link-active").removeClass("router-link-exact-active");
    },

  methods: {   
    scrollToTop() {
      window.scrollTo(0,0);
    },
    imgUrlAlt(event) { 
      this.noimage = true;  
      event.target.src = "/images/noimage.jpg"
    },

      imgUrlAlt1(event) { 
     
      event.target.src = "/images/noimage.jpg"
    },
    
    relatedNews: function(pid) {
     
      this.axios.get(`/api/relatednews/${pid}`).then(response => {
        if(response.data.related_news != null)
        {
          this.latest_post_all_cats = response.data.related_news;
        }
      
        // this.latest_news = response.data.latest_news;
      });
    },
    changeRoute(e,tab){
        $('#navtab').removeClass('news-tabColor hospital-tabColor nursing-tabColor job-tabColor');                        
        $('#navtab').addClass(tab+'-tabColor');
        $('.tab-content').removeClass('news-borderColor job-borderColor nursing-borderColor hospital-borderColor');                        
        $('.tab-content').addClass(tab+'-borderColor'); 
          this.$router.push({name:'home',params:{page:e.target.hash}});   
    },
  
  }
};
</script>

<style>
/* .hospital-tabColor .nav-link {
        background: #63b7ff !important;
        color: #fff;
        border-right: 1px solid #fff;
} */
.margin-none{
  margin-top: 0px !important;
}
.scrolldiv2{
  padding-top: 0;
}
.news-tabColor .nav-link {
        background: #75b777 !important;
        color: #fff;
        border-right: 1px solid #fff;
}
.nursing-tabColor .nav-link {
        background: #63b7ff !important;
        color: #fff;
        border-right: 1px solid #fff;
}
.job-tabColor .nav-link{
        background: #828282 !important;
        color: #fff;
        border-right: 1px solid #fff;
}

.job-borderColor {
        border: 1px solid #ccc !important;
}
/*.news-borderColor {
        border: 1px solid #75b777 !important;
}*/
.hospital-borderColor {
        border: 1px solid #f0b700 !important;
}
.nursing-borderColor {
        border: 1px solid #63b7ff !important;
}
.title_color span {
    background-color: var(--color);
    color: #fff;
    border-radius: 3px;
    padding: 2px 4px 0px 4px;
    font-size: 13px;
}
.detail-block{
  text-align: center;
  margin: 0 auto 20px auto;
  width: 100%;
  display: block;
}
.set-date{
  margin-top: 0.5rem;
  display: inline-block;
}
.news-create-cmp{
  font-size: 1rem;
  line-height: 1.384;
  color: #666;
  text-align: center;
  margin-top: .5rem;
  display: inline-block;
}
</style>
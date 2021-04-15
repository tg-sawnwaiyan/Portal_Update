<template>
  
        <div class="divisions row " id="divisionswrap">
           <img src="/images/mapHospital.png" alt="map" v-if="path == 'nursing'"  class="img-fluid" style="margin:0 auto;">
            <img src="/images/mapHospital.png" alt="map" v-if="path == 'hospital'" class="img-fluid" style="margin:0 auto;">
            <!-- <img src="/images/mapJob.png" alt="map" v-if="path == 'job'" class="img-fluid" style="margin:0 auto;"> -->
            <img src="/images/mapHospital.png" alt="map" v-if="path == 'job'" class="img-fluid" style="margin:0 auto;">
            <div class="col-sm-2 hokkaido-box">
                <div class="mb-3">
                <div class="division-box">
                    <ul class="hokkaido-wrap">
                    <a data-info="Hokkaido" class="path Hokkaido card-text" @click="getStateClick($event)">
                        <li class="spanclass" id="1" v-scroll-to="'#scrollMap'" @click="selected = 1" :class="{highlight:selected == 1}">北海道</li>
                    </a>
                    </ul>
                </div>
                </div>
            </div>
            <div class="col-sm-2 tohoku-box">
                <div class="mb-3">
                <div class="division-box">
                    <ul class="multiple-boxa">
                    <a data-info="Aomori" class="path Aomori card-text" @click="getStateClick">
                        <li class="spanclass" id="2" v-scroll-to="'#scrollMap'" @click="selected = 2" :class="{highlight:selected == 2}">青森</li>
                    </a>
                    <a data-info="Iwate" class="path Iwate card-text" @click="getStateClick">
                        <li class="spanclass" id="3" v-scroll-to="'#scrollMap'" @click="selected = 3" :class="{highlight:selected == 3}" >岩手</li>
                    </a>

                    <a data-info="Akita" class="path Akita card-text" @click="getStateClick">
                        <li class="spanclass" id="5" v-scroll-to="'#scrollMap'" @click="selected = 5" :class="{highlight:selected == 5}">秋田</li>
                    </a>

                    <a data-info="Miyagi" class="path Miyagi card-text" @click="getStateClick">
                        <li class="spanclass" id="4" v-scroll-to="'#scrollMap'" @click="selected = 4" :class="{highlight:selected == 4}">宮城</li>
                    </a>

                    <a data-info="Yamagata" class="path Yamagata card-text" @click="getStateClick">
                        <li class="spanclass" id="6" v-scroll-to="'#scrollMap'" @click="selected = 6" :class="{highlight:selected == 6}">山形</li>
                    </a>
                    <a data-info="Fukushima" class="path Fukushima card-text" @click="getStateClick">
                        <li class="spanclass" id="7" v-scroll-to="'#scrollMap'" @click="selected = 7" :class="{highlight:selected == 7}">福島</li>
                    </a>
                    </ul>
                </div>
                </div>
            </div>

            <div class="col-sm-2 kanto-box">
                <div class="mb-3">
                <!-- <div class="card-header pad-10" style="background-color:#71d5cb">関東</div> -->
                <div class="division-box">
                    <ul class="multiple-box">
                    <a data-info="Tokyo" class="path Tokyo card-text" @click="getStateClick">
                            <li class="spanclass" id="13" v-scroll-to="'#scrollMap'" @click="selected = 13" :class="{highlight:selected == 13}">東京</li>
                    </a>

                    <a data-info="Kanagawa" class="path Kanagawa card-text" @click="getStateClick">
                        <li class="spanclass" id="14" v-scroll-to="'#scrollMap'" @click="selected = 14" :class="{highlight:selected == 14}">神奈川</li>
                    </a>

                    <a data-info="Saitama" class="path Saitama card-text" @click="getStateClick">
                        <li class="spanclass" id="11" v-scroll-to="'#scrollMap'" @click="selected = 11" :class="{highlight:selected == 11}" >埼玉</li>
                    </a>


                    <a data-info="Chiba" class="path Chiba card-text" @click="getStateClick">
                        <li class="spanclass" id="12" v-scroll-to="'#scrollMap'" @click="selected = 12" :class="{highlight:selected == 12}">千葉</li>
                    </a>

                    <a data-info="Gunma" class="path Gunma card-text" @click="getStateClick">
                        <li class="spanclass" id="10" v-scroll-to="'#scrollMap'" @click="selected = 10" :class="{highlight:selected == 10}">群馬</li>
                    </a>

                    <a data-info="Ibaraki" class="path Ibaraki card-text" @click="getStateClick">
                        <li class="spanclass" id="8" v-scroll-to="'#scrollMap'" @click="selected = 8" :class="{highlight:selected == 8}">茨城</li>
                    </a>

                    <a data-info="Tochigi" class="path Tochigi card-text" @click="getStateClick">
                            <li class="spanclass" id="9" v-scroll-to="'#scrollMap'" @click="selected = 9" :class="{highlight:selected == 9}">栃木</li>
                    </a>

                    <a data-info="Yamanashi" class="path Yamanashi card-text" @click="getStateClick">
                        <li class="spanclass" id="19" v-scroll-to="'#scrollMap'" @click="selected = 19" :class="{highlight:selected == 19}">山梨</li>
                    </a>
                    </ul>
                </div>
                </div>
            </div>

            <div class="col-sm-3 hokuriku-box">
                <div class="mb-3">
                <!-- <div class="card-header pad-10" style="background-color:#75b777">北陸</div> -->
                <div class="division-box">
                    <ul class="">
                    <a data-info="Niigata" class="path Niigata card-text" @click="getStateClick">
                        <li class="spanclass" id="15" v-scroll-to="'#scrollMap'" @click="selected = 15" :class="{highlight:selected == 15}" >新潟</li>
                    </a>

                    <a data-info="Nagano" class="path Nagano card-text" @click="getStateClick">
                        <li class="spanclass" id="20" v-scroll-to="'#scrollMap'" @click="selected = 20" :class="{highlight:selected == 20}">長野</li>
                    </a>

                        <a data-info="Toyama" class="path Toyama card-text" @click="getStateClick">
                        <li class="spanclass" id="16" v-scroll-to="'#scrollMap'" @click="selected = 16" :class="{highlight:selected == 16}">富山</li>
                    </a>

                    <a data-info="Ishikawa" class="path Ishikawa card-text" @click="getStateClick">
                        <li class="spanclass" id="17" v-scroll-to="'#scrollMap'" @click="selected = 17" :class="{highlight:selected == 17}">石川</li>
                    </a>

                    <a data-info="Fukui" class="path Fukui card-text" @click="getStateClick">
                            <li class="spanclass" id="18" v-scroll-to="'#scrollMap'" @click="selected = 18" :class="{highlight:selected == 18}">福井</li>
                    </a>

                    </ul>
                </div>
                </div>
            </div>

            <div class="col-sm-3 tokai-box">
                <div class="mb-3">
                <!-- <div class="card-header pad-10" style="background-color:#c0c743">東海甲信</div> -->
                <div class="division-box">
                    <ul class="multiple-boxa">

                    <a data-info="Aichi" class="path Aichi card-text" @click="getStateClick">
                            <li class="spanclass" id="23" v-scroll-to="'#scrollMap'" @click="selected = 23" :class="{highlight:selected == 23}">愛知</li>
                    </a>


                    <a data-info="Shizuoka" class="path Shizuoka card-text" @click="getStateClick">
                        <li class="spanclass" id="22" v-scroll-to="'#scrollMap'" @click="selected = 22" :class="{highlight:selected == 22}">静岡</li>
                    </a>

                    <a id="21" data-info="Gifu" class="path Gifu card-text" @click="getStateClick">
                        <li class="spanclass" id="21" v-scroll-to="'#scrollMap'" @click="selected = 21" :class="{highlight:selected == 21}">岐阜</li>
                    </a>

                    <a data-info="Mie" class="path Mie card-text" @click="getStateClick">
                            <li class="spanclass"  id="24" v-scroll-to="'#scrollMap'" @click="selected = 24" :class="{highlight:selected == 24}">三重</li>
                    </a>
                    </ul>
                </div>
                </div>
            </div>

            <div class="col-sm-4 kinki-box">
                <div class="mb-3">
                <!-- <div class="card-header pad-10" style="background:#efb838">近畿</div> -->
                <div class="division-box">
                    <ul class="multiple-boxa">

                    <a data-info="Osaka" class="path Osaka card-text" @click="getStateClick">
                        <li class="spanclass" id="27" v-scroll-to="'#scrollMap'" @click="selected = 27" :class="{highlight:selected == 27}">大阪</li>
                    </a>

                    <a data-info="Hyogo" class="path Hyogo card-text" @click="getStateClick">
                            <li class="spanclass" id="28" v-scroll-to="'#scrollMap'" @click="selected = 28" :class="{highlight:selected == 28}">兵庫</li>
                    </a>

                    <a data-info="Kyoto" class="path Kyoto card-text" @click="getStateClick">
                        <li class="spanclass"  id="26" v-scroll-to="'#scrollMap'" @click="selected = 26" :class="{highlight:selected == 26}">京都</li>
                    </a>

                    <a data-info="Nara" class="path Nara card-text" @click="getStateClick">
                        <li class="spanclass"  id="29" v-scroll-to="'#scrollMap'" @click="selected = 29" :class="{highlight:selected == 29}">奈良</li>
                    </a>

                    <a data-info="Shiga" class="path Shiga card-text" @click="getStateClick">
                            <li class="spanclass"  id="25" v-scroll-to="'#scrollMap'" @click="selected = 25" :class="{highlight:selected == 25}">滋賀</li>
                    </a>

                    <a data-info="Wakayama" class="path Wakayama card-text" @click="getStateClick">
                        <li class="spanclass" id="30" v-scroll-to="'#scrollMap'" @click="selected = 30" :class="{highlight:selected == 30}">和歌山</li>
                    </a>
                    </ul>
                </div>
                </div>
            </div>

            <div class="col-sm-3 chugoku-box">
                <div class="mb-3">
                <!-- <div class="card-header pad-10" style="background:#f58c3f;">中国</div> -->
                <div class="division-box">
                    <ul class="">

                    <a data-info="Okayama" class="path Okayama card-text" @click="getStateClick">
                            <li class="spanclass" id="33" v-scroll-to="'#scrollMap'" @click="selected = 33" :class="{highlight:selected == 33}"> 岡山</li>
                    </a>

                    <a data-info="Hiroshima" class="path Hiroshima card-text" @click="getStateClick">
                        <li class="spanclass" id="34" v-scroll-to="'#scrollMap'" @click="selected = 34" :class="{highlight:selected == 34}" >広島</li>
                    </a>

                    <a data-info="Yamaguchi" class="path Yamaguchi card-text" @click="getStateClick">
                        <li class="spanclass" id="35" v-scroll-to="'#scrollMap'" @click="selected = 35" :class="{highlight:selected == 35}">山口</li>
                    </a>

                    <a data-info="Shimane" class="path Shimane card-text" @click="getStateClick">
                        <li class="spanclass" id="32" v-scroll-to="'#scrollMap'" @click="selected = 32" :class="{highlight:selected == 32}">島根</li>
                    </a>

                    <a data-info="Tottori" class="path Tottori card-text" @click="getStateClick">
                        <li class="spanclass"  id="31" v-scroll-to="'#scrollMap'" @click="selected = 31" :class="{highlight:selected == 31}">鳥取</li>
                    </a>


                    </ul>
                </div>
                </div>
            </div>

            <div class="col-sm-3 shikoku-box">
                <div class="mb-3">
                <!-- <div class="card-header pad-10" style="background:#f1a296;">四国</div> -->
                <div class="division-box">
                    <ul class="multiple-boxa">

                    <a data-info="Tokushima" class="path Tokushima card-text" @click="getStateClick">
                        <li class="spanclass" id="36" v-scroll-to="'#scrollMap'" @click="selected = 36" :class="{highlight:selected == 36}">徳島</li>
                    </a>

                    <a data-info="Kagawa" class="path Kagawa card-text" @click="getStateClick">
                        <li class="spanclass" id="37" v-scroll-to="'#scrollMap'" @click="selected = 37" :class="{highlight:selected == 37}">香川</li>
                    </a>

                    <a data-info="Kochi" class="path Kochi card-text" @click="getStateClick">
                        <li class="spanclass" id="39" v-scroll-to="'#scrollMap'" @click="selected = 39" :class="{highlight:selected == 39}">高知</li>
                    </a>

                    <a data-info="Ehime" class="path Ehime card-text" @click="getStateClick">
                        <li class="spanclass" id="38" v-scroll-to="'#scrollMap'" @click="selected = 38" :class="{highlight:selected == 38}">愛媛</li>
                    </a>

                    </ul>
                </div>
                </div>
            </div>

            <div class="col-sm-2 kyushu-box">
                <div class="mb-3">
                <!-- <div class="card-header pad-10" style="background-color:#e77a72;">九州・沖縄</div> -->
                <div class="division-box">
                    <ul class="">

                    <a data-info="Fukuoka" class="path Fukuoka card-text" @click="getStateClick">
                        <li class="spanclass" id="40" v-scroll-to="'#scrollMap'" @click="selected = 40" :class="{highlight:selected == 40}">福岡</li>
                    </a>

                    <a data-info="Saga" class="path Saga card-text" @click="getStateClick">
                        <li class="spanclass" id="41" v-scroll-to="'#scrollMap'" @click="selected = 41" :class="{highlight:selected == 41}">佐賀</li>
                    </a>

                    <a data-info="Nagasaki" class="path Nagasaki card-text" @click="getStateClick">
                        <li class="spanclass" id="42" v-scroll-to="'#scrollMap'" @click="selected = 42" :class="{highlight:selected == 42}">長崎</li>
                    </a>

                    <a data-info="Oita" class="path Oita card-text" @click="getStateClick">
                        <li class="spanclass" id="44" v-scroll-to="'#scrollMap'" @click="selected = 44" :class="{highlight:selected == 44}">大分</li>
                    </a>

                    <a data-info="Kumamoto" class="path Kumamoto card-text" @click="getStateClick">
                        <li class="spanclass" id="43" v-scroll-to="'#scrollMap'" @click="selected = 43" :class="{highlight:selected == 43}">熊本</li>
                    </a>


                    <a data-info="Miyazaki" class="path Miyazaki card-text" @click="getStateClick">
                            <li class="spanclass" id="45" v-scroll-to="'#scrollMap'" @click="selected = 45" :class="{highlight:selected == 45}">宮崎</li>
                    </a>

                    <a data-info="Kagoshima" class="path Kagoshima card-text" @click="getStateClick">
                        <li class="spanclass" id="46" v-scroll-to="'#scrollMap'" @click="selected = 46" :class="{highlight:selected == 46}">鹿児島</li>
                    </a>

                    </ul>
                </div>
                </div>
            </div>

            <div class="col-sm-2 okinawa-box">
                <div class="mb-3">
                <!-- <div class="card-header pad-10" style="background-color:#e77a72;">九州・沖縄</div> -->
                <div class="division-box">
                    <ul class="">
                        <a data-info="Okinawa" class="path Okinawa card-text" @click="getStateClick">
                            <li class="spanclass" id="47" v-scroll-to="'#scrollMap'" @click="selected = 47" :class="{highlight:selected == 47}">沖縄</li>
                    </a>
                    </ul>
                </div>
                </div>
            </div>

        </div>
     
</template>

<script>
    export default {
        methods: {
            getStateClick(e){
                this.$parent.$options.parent.$options.methods.parentGetStateClick(e,this.$parent.$options.parent);
            }
        },
         created() {
               if(this.$router.currentRoute.path == "/nursingSearch")
               {
                 
                   this.path = "nursing";
                
               }
               else if(this.$router.currentRoute.path == "/hospital_search")
               {
                
                   this.path = "hospital";
                
               }
               else if(this.$router.currentRoute.path == "/jobSearch"){
                
                    this.path = "job";
                  
               }
            
          
           },
    };
</script>

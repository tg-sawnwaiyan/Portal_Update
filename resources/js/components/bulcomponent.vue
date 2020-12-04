<template>
    <div>
        <bulma-accordion :icon="'custom'" >
            <!--Start hokkaido-box and  tohoku-box -->
            <bulma-accordion-item>
                <p slot="title" class="title is-4 has-text-weight-normal">北海道・東北</p>
                <i slot="icon-closed" :class="$route.name == 'nursingSearch'? 'nursing-map-addicon': ($route.name == 'hospital_search'? 'hospital-map-addicon': 'job-map-addicon')" class="fa fa-plus-circle map-addicon"></i>
                <i slot="icon-open" :class="$route.name == 'nursingSearch'? 'nursing-map-addicon': ($route.name == 'hospital_search'? 'hospital-map-addicon': 'job-map-addicon')" class="fa fa-minus-circle map-addicon"></i>
                <p slot="content" class="custom_group">
                    <a data-info="Hokkaido" @click="getStateClick">
                        <li id="1" v-scroll-to="'#scroll-responsive'" @click="selected = 1" :class="{resHighlight:selected == 1}">北海道 <i class="fas fa-angle-double-right arrow_icon"></i></li>
                    </a>
                    <a data-info="Aomori" @click="getStateClick" >
                        <li id="2" v-scroll-to="'#scroll-responsive'" @click="selected = 2" :class="{resHighlight:selected == 2}">青森 <i class="fas fa-angle-double-right arrow_icon"></i></li>
                    </a>
                    <a data-info="Iwate" @click="getStateClick" >
                        <li id="3" v-scroll-to="'#scroll-responsive'" @click="selected = 3" :class="{resHighlight:selected == 3}">岩手 <i class="fas fa-angle-double-right arrow_icon"></i></li>
                    </a>
                    <a data-info="Akita" @click="getStateClick">
                        <li id="5" v-scroll-to="'#scroll-responsive'" @click="selected = 5" :class="{resHighlight:selected == 5}"> 秋田 <i class="fas fa-angle-double-right arrow_icon"></i></li>
                    </a>
                    <a data-info="Miyagi" @click="getStateClick" >
                        <li id="4" v-scroll-to="'#scroll-responsive'" @click="selected = 4" :class="{resHighlight:selected == 4}">宮城 <i class="fas fa-angle-double-right arrow_icon"></i></li>
                    </a>
                    <a data-info="Yamagata" @click="getStateClick" >
                        <li id="6" v-scroll-to="'#scroll-responsive'" @click="selected = 6" :class="{resHighlight:selected == 6}"> 山形 <i class="fas fa-angle-double-right arrow_icon"></i></li>
                    </a>
                    <a data-info="Fukushima" @click="getStateClick" >
                        <li id="7" v-scroll-to="'#scroll-responsive'" @click="selected = 7" :class="{resHighlight:selected == 7}"> 福島 <i class="fas fa-angle-double-right arrow_icon"></i></li>
                    </a>
                </p>
            </bulma-accordion-item>
            <!-- End hokkaido-box and  tohoku-box -->
            <!--  Start kanto-box -->
            <bulma-accordion-item>
                <p slot="title" class="title is-4 has-text-weight-normal">関東</p>
                <i slot="icon-closed" :class="$route.name == 'nursingSearch'? 'nursing-map-addicon': ($route.name == 'hospital_search'? 'hospital-map-addicon': 'job-map-addicon')" class="fa fa-plus-circle map-addicon"></i>
                <i slot="icon-open" :class="$route.name == 'nursingSearch'? 'nursing-map-addicon': ($route.name == 'hospital_search'? 'hospital-map-addicon': 'job-map-addicon')" class="fa fa-minus-circle map-addicon"></i>
                <p slot="content" class="custom_group">
                    <a data-info="Tokyo" @click="getStateClick" >
                        <li id="13" v-scroll-to="'#scroll-responsive'" @click="selected = 13" :class="{resHighlight:selected == 13}">東京 <i class="fas fa-angle-double-right arrow_icon"></i></li>
                    </a>
                    <a data-info="Kanagawa" @click="getStateClick" >
                        <li id="14" v-scroll-to="'#scroll-responsive'" @click="selected = 14" :class="{resHighlight:selected == 14}">神奈川 <i class="fas fa-angle-double-right arrow_icon"></i></li>
                    </a>
                    <a data-info="Chiba" @click="getStateClick" >
                        <li id="11" v-scroll-to="'#scroll-responsive'" @click="selected = 11" :class="{resHighlight:selected == 11}">埼玉 <i class="fas fa-angle-double-right arrow_icon"></i></li>
                    </a>
                    <a data-info="Miyagi" @click="getStateClick" >
                        <li id="12" v-scroll-to="'#scroll-responsive'" @click="selected = 12" :class="{resHighlight:selected == 12}">千葉 <i class="fas fa-angle-double-right arrow_icon"></i></li>
                    </a>
                    <a data-info="Gunma" @click="getStateClick">
                        <li id="10" v-scroll-to="'#scroll-responsive'" @click="selected = 10" :class="{resHighlight:selected == 10}"> 群馬 <i class="fas fa-angle-double-right arrow_icon"></i></li>
                    </a>
                    <a data-info="Ibaraki" @click="getStateClick" >
                        <li id="8" v-scroll-to="'#scroll-responsive'" @click="selected = 8" :class="{resHighlight:selected == 8}"> 茨城 <i class="fas fa-angle-double-right arrow_icon"></i></li>
                    </a>
                    <a data-info="Tochigi" @click="getStateClick" >
                        <li id="9" v-scroll-to="'#scroll-responsive'" @click="selected = 9" :class="{resHighlight:selected == 9}"> 栃木 <i class="fas fa-angle-double-right arrow_icon"></i></li>
                    </a>
                    <a data-info="Yamanashi" @click="getStateClick" >
                        <li id="19" v-scroll-to="'#scroll-responsive'" @click="selected = 19" :class="{resHighlight:selected == 19}"> 山梨 <i class="fas fa-angle-double-right arrow_icon"></i></li>
                    </a>
                </p>
            </bulma-accordion-item>
            <!-- End kanto-box -->
            <!-- Start hokuriku-box-->
            <bulma-accordion-item>
                <p slot="title" class="title is-4 has-text-weight-normal">北陸</p>
                <i slot="icon-closed" :class="$route.name == 'nursingSearch'? 'nursing-map-addicon': ($route.name == 'hospital_search'? 'hospital-map-addicon': 'job-map-addicon')" class="fa fa-plus-circle map-addicon"></i>
                <i slot="icon-open" :class="$route.name == 'nursingSearch'? 'nursing-map-addicon': ($route.name == 'hospital_search'? 'hospital-map-addicon': 'job-map-addicon')" class="fa fa-minus-circle map-addicon"></i>
                <p slot="content" class="custom_group">
                    <a data-info="Niigata" @click="getStateClick" >
                        <li id="15" v-scroll-to="'#scroll-responsive'" @click="selected = 15" :class="{resHighlight:selected == 15}">新潟 <i class="fas fa-angle-double-right arrow_icon"></i></li>
                    </a>
                    <a data-info="Nagana" @click="getStateClick" >
                        <li id="20" v-scroll-to="'#scroll-responsive'" @click="selected = 20" :class="{resHighlight:selected == 20}">長野 <i class="fas fa-angle-double-right arrow_icon"></i></li>
                    </a>
                    <a data-info="Toyama" @click="getStateClick" >
                        <li id="16" v-scroll-to="'#scroll-responsive'" @click="selected = 16" :class="{resHighlight:selected == 16}">富山 <i class="fas fa-angle-double-right arrow_icon"></i></li>
                    </a>
                    <a data-info="Ishikawa" @click="getStateClick" >
                        <li id="17" v-scroll-to="'#scroll-responsive'" @click="selected = 17" :class="{resHighlight:selected == 17}">石川 <i class="fas fa-angle-double-right arrow_icon"></i></li>
                    </a>
                    <a data-info="Fukui" @click="getStateClick">
                        <li id="18" v-scroll-to="'#scroll-responsive'" @click="selected = 18" :class="{resHighlight:selected == 18}"> 福井 <i class="fas fa-angle-double-right arrow_icon"></i></li>
                    </a>
                </p>
            </bulma-accordion-item>
            <!-- End hokuriku-box-->
            <!--Start tokai-box -->
            <bulma-accordion-item>
                <p slot="title" class="title is-4 has-text-weight-normal">東海</p>
                <i slot="icon-closed" :class="$route.name == 'nursingSearch'? 'nursing-map-addicon': ($route.name == 'hospital_search'? 'hospital-map-addicon': 'job-map-addicon')" class="fa fa-plus-circle map-addicon"></i>
                <i slot="icon-open" :class="$route.name == 'nursingSearch'? 'nursing-map-addicon': ($route.name == 'hospital_search'? 'hospital-map-addicon': 'job-map-addicon')" class="fa fa-minus-circle map-addicon"></i>
                <p slot="content" class="custom_group">
                    <a data-info="Aichi" @click="getStateClick" >
                        <li id="23" v-scroll-to="'#scroll-responsive'" @click="selected = 23" :class="{resHighlight:selected == 23}">愛知 <i class="fas fa-angle-double-right arrow_icon"></i></li>
                    </a>
                    <a data-info="Shizuoka" @click="getStateClick" >
                        <li id="22" v-scroll-to="'#scroll-responsive'" @click="selected = 22" :class="{resHighlight:selected == 22}">静岡 <i class="fas fa-angle-double-right arrow_icon"></i></li>
                    </a>
                    <a data-info="Gifu" @click="getStateClick" >
                        <li id="21" v-scroll-to="'#scroll-responsive'" @click="selected = 21" :class="{resHighlight:selected == 21}">岐阜 <i class="fas fa-angle-double-right arrow_icon"></i></li>
                    </a>
                    <a data-info="Mie" @click="getStateClick" >
                        <li id="24" v-scroll-to="'#scroll-responsive'" @click="selected = 24" :class="{resHighlight:selected == 24}">三重 <i class="fas fa-angle-double-right arrow_icon"></i></li>
                    </a>
                </p>
            </bulma-accordion-item>
            <!--End tokai-box -->
            <!-- Start kansai -box -->
            <bulma-accordion-item>
                <p slot="title" class="title is-4 has-text-weight-normal">関西</p>
                <i slot="icon-closed" :class="$route.name == 'nursingSearch'? 'nursing-map-addicon': ($route.name == 'hospital_search'? 'hospital-map-addicon': 'job-map-addicon')" class="fa fa-plus-circle map-addicon"></i>
                <i slot="icon-open" :class="$route.name == 'nursingSearch'? 'nursing-map-addicon': ($route.name == 'hospital_search'? 'hospital-map-addicon': 'job-map-addicon')" class="fa fa-minus-circle map-addicon"></i>
                <p slot="content" class="custom_group">
                    <a data-info="Osaka" @click="getStateClick" >
                        <li id="27" v-scroll-to="'#scroll-responsive'" @click="selected = 27" :class="{resHighlight:selected == 27}">大阪 <i class="fas fa-angle-double-right arrow_icon"></i></li>
                    </a>
                    <a data-info="Hyogo" @click="getStateClick" >
                        <li id="28" v-scroll-to="'#scroll-responsive'" @click="selected = 28" :class="{resHighlight:selected == 28}">兵庫 <i class="fas fa-angle-double-right arrow_icon"></i></li>
                    </a>
                    <a data-info="kyoto" @click="getStateClick" >
                        <li id="26" v-scroll-to="'#scroll-responsive'" @click="selected = 26" :class="{resHighlight:selected == 26}">京都<i class="fas fa-angle-double-right arrow_icon"></i></li>
                    </a>
                    <a data-info="Nara" @click="getStateClick" >
                        <li id="29" v-scroll-to="'#scroll-responsive'" @click="selected = 29" :class="{resHighlight:selected == 29}">奈良 <i class="fas fa-angle-double-right arrow_icon"></i></li>
                    </a>
                    <a data-info="Shiga" @click="getStateClick">
                        <li id="25" v-scroll-to="'#scroll-responsive'" @click="selected = 25" :class="{resHighlight:selected == 25}"> 滋賀 <i class="fas fa-angle-double-right arrow_icon"></i></li>
                    </a>
                    <a data-info="Wakayama" @click="getStateClick" >
                        <li id="30" v-scroll-to="'#scroll-responsive'" @click="selected = 30" :class="{resHighlight:selected == 30}"> 和歌山 <i class="fas fa-angle-double-right arrow_icon"></i></li>
                    </a>
                </p>
            </bulma-accordion-item>
            <!-- End kinki-box -->
            <!-- Start chugoku-box and shikoku-box-->
            <bulma-accordion-item>
                <p slot="title" class="title is-4 has-text-weight-normal">中国・四国</p>
                <i slot="icon-closed" :class="$route.name == 'nursingSearch'? 'nursing-map-addicon': ($route.name == 'hospital_search'? 'hospital-map-addicon': 'job-map-addicon')" class="fa fa-plus-circle map-addicon"></i>
                <i slot="icon-open" :class="$route.name == 'nursingSearch'? 'nursing-map-addicon': ($route.name == 'hospital_search'? 'hospital-map-addicon': 'job-map-addicon')" class="fa fa-minus-circle map-addicon"></i>
                <p slot="content" class="custom_group">
                    <a data-info="Okayama" @click="getStateClick" >
                        <li id="33" v-scroll-to="'#scroll-responsive'" @click="selected = 33" :class="{resHighlight:selected == 33}">岡山 <i class="fas fa-angle-double-right arrow_icon"></i></li>
                    </a>
                    <a data-info="Hiroshima" @click="getStateClick" >
                        <li id="34" v-scroll-to="'#scroll-responsive'" @click="selected = 34" :class="{resHighlight:selected == 34}">広島 <i class="fas fa-angle-double-right arrow_icon"></i></li>
                    </a>
                    <a data-info="Yamaguchi" @click="getStateClick" >
                        <li id="35" v-scroll-to="'#scroll-responsive'" @click="selected = 35" :class="{resHighlight:selected == 35}">山口 <i class="fas fa-angle-double-right arrow_icon"></i></li>
                    </a>
                    <a data-info="Shimane" @click="getStateClick" >
                        <li id="32" v-scroll-to="'#scroll-responsive'" @click="selected = 32" :class="{resHighlight:selected == 32}">島根 <i class="fas fa-angle-double-right arrow_icon"></i></li>
                    </a>
                    <a data-info="Tottori" @click="getStateClick">
                        <li id="31" v-scroll-to="'#scroll-responsive'" @click="selected = 31" :class="{resHighlight:selected == 31}"> 鳥取 <i class="fas fa-angle-double-right arrow_icon"></i></li>
                    </a>
                    <a data-info="Ehime" @click="getStateClick" >
                        <li id="38" v-scroll-to="'#scroll-responsive'" @click="selected = 38" :class="{resHighlight:selected == 38}"> 愛媛 <i class="fas fa-angle-double-right arrow_icon"></i></li>
                    </a>
                    <a data-info="Kagawa" @click="getStateClick" >
                        <li id="37" v-scroll-to="'#scroll-responsive'" @click="selected = 37" :class="{resHighlight:selected == 37}">香川 <i class="fas fa-angle-double-right arrow_icon"></i></li>
                    </a>
                    <a data-info="Kochi" @click="getStateClick">
                        <li id="39" v-scroll-to="'#scroll-responsive'" @click="selected = 39" :class="{resHighlight:selected == 39}"> 高知 <i class="fas fa-angle-double-right arrow_icon"></i></li>
                    </a>
                    <a data-info="Tokushima" @click="getStateClick" >
                        <li id="36" v-scroll-to="'#scroll-responsive'" @click="selected = 36" :class="{resHighlight:selected == 36}"> 徳島 <i class="fas fa-angle-double-right arrow_icon"></i></li>
                    </a>
                </p>
            </bulma-accordion-item>
            <!-- End chugoku-box and shikoku-box-->
            <!-- Start kyushu-box and  okinawa-box -->
            <bulma-accordion-item>
                <p slot="title" class="title is-4 has-text-weight-normal">九州・沖縄</p>
                <i slot="icon-closed" :class="$route.name == 'nursingSearch'? 'nursing-map-addicon': ($route.name == 'hospital_search'? 'hospital-map-addicon': 'job-map-addicon')" class="fa fa-plus-circle map-addicon"></i>
                <i slot="icon-open" :class="$route.name == 'nursingSearch'? 'nursing-map-addicon': ($route.name == 'hospital_search'? 'hospital-map-addicon': 'job-map-addicon')" class="fa fa-minus-circle map-addicon"></i>
                <p slot="content" class="custom_group">
                    <a data-info="Fukuoka" @click="getStateClick" >
                        <li id="40" v-scroll-to="'#scroll-responsive'" @click="selected = 40" :class="{resHighlight:selected == 40}">福岡 <i class="fas fa-angle-double-right arrow_icon"></i></li>
                    </a>
                    <a data-info="Saga" @click="getStateClick" >
                        <li id="41" v-scroll-to="'#scroll-responsive'" @click="selected = 41" :class="{resHighlight:selected == 41}">佐賀 <i class="fas fa-angle-double-right arrow_icon"></i></li>
                    </a>
                    <a data-info="Nagasak" @click="getStateClick" >
                        <li id="42" v-scroll-to="'#scroll-responsive'" @click="selected = 42" :class="{resHighlight:selected == 42}">長崎 <i class="fas fa-angle-double-right arrow_icon"></i></li>
                    </a>
                    <a data-info="Oita" @click="getStateClick" >
                        <li id="44" v-scroll-to="'#scroll-responsive'" @click="selected = 44" :class="{resHighlight:selected == 44}">大分 <i class="fas fa-angle-double-right arrow_icon"></i></li>
                    </a>
                    <a data-info="Kumamoto" @click="getStateClick">
                        <li id="43" v-scroll-to="'#scroll-responsive'" @click="selected = 43" :class="{resHighlight:selected == 43}"> 熊本 <i class="fas fa-angle-double-right arrow_icon"></i></li>
                    </a>
                    <a data-info="Miyazaki" @click="getStateClick" >
                        <li id="45" v-scroll-to="'#scroll-responsive'" @click="selected = 45" :class="{resHighlight:selected == 45}"> 宮崎 <i class="fas fa-angle-double-right arrow_icon"></i></li>
                    </a>
                    <a data-info="Kagoshima" @click="getStateClick" >
                        <li id="46" v-scroll-to="'#scroll-responsive'" @click="selected = 46" :class="{resHighlight:selected == 46}">鹿児島 <i class="fas fa-angle-double-right arrow_icon"></i></li>
                    </a>
                    <a data-info="Okinawa" @click="getStateClick">
                        <li id="47" v-scroll-to="'#scroll-responsive'" @click="selected = 47" :class="{resHighlight:selected == 47}"> 沖縄 <i class="fas fa-angle-double-right arrow_icon"></i></li>
                    </a>
                </p>
            </bulma-accordion-item>
            <!--End kyushu-box and   okinawa-box-->
        </bulma-accordion>
    </div>
</template>
<script>
export default {
    methods: {
        getStateClick(e){
            this.$parent.$options.parent.$options.methods.parentGetStateClick(e,this.$parent.$options.parent);
        }
    }
};
</script>

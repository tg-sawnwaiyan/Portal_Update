<template>
<div class="ads-slider">
    <slick ref="slick" :options="slickOptions" v-if="ads_list.length > 0">  
        <div class="list-group-item adslist-card" v-for="adsList in ads_list" :key="adsList.id">
            <div v-if="adsList.link && adsList.show_flag == 'link'">
                <a :href="adsList.link" target="_blank">
                    <div class="slide-img">
                        <img :src="'/upload/advertisement/'+ adsList.photo" alt class="img-fluid ads-img" @error="imgUrlAlt"/>
                    </div>
                    <h3 class="smallads-title">{{adsList.title}}</h3>
                </a>
            </div>
            <div v-else>
                <a @click="showPDF($event, adsList.pdf)">
                    <div class="slide-img">
                        <img :src="'/upload/advertisement/'+ adsList.photo" alt class="img-fluid ads-img" @error="imgUrlAlt"/>
                    </div>
                    <h3 class="smallads-title pdf-link">{{adsList.title}}</h3>
                </a>
            </div>       
        </div>
    </slick>
</div>
</template>

<script>
import Slick from 'vue-slick';


export default {
    components: { Slick },
    data() {
        return {
            ads_list: [],
            slickOptions: {
                slidesToShow: 3,
                slidesToScroll: 3,
                infinite: true,
                accessibility: true,
                adaptiveHeight: false,
                edgeFriction: 0.30,
                swipe: true,
                autoplay: true,
                lazyLoad: 'ondemand',
                responsive: [
                    {
                    breakpoint: 1100,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 2,
                        infinite: true,
                        dots: true
                    }
                    },
                    {
                    breakpoint: 990,
                    settings: {
                        slidesToShow: 3,
                        slidesToScroll: 3
                    }
                    },
                    {
                    breakpoint: 600,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 2
                    }
                    },
                    {
                    breakpoint: 480,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1
                    }
                    }
                ]               
            },
        }
    },
    created() {
    this.axios.get("/api/advertisement/adslide").then(response => {
      this.ads_list = response.data;
    });
  },
    methods: {
        next() {
            this.$refs.slick.next();
        },
        prev() {
            this.$refs.slick.prev();
        },
        reInit() {
            // Helpful if you have to deal with v-for to update dynamic lists
            this.$nextTick(() => {
                this.$refs.slick.reSlick();
            });
        },
         imgUrlAlt(event) 
        {
            event.target.src = "/images/noimage.jpg"
        },
        showPDF:function(event, pdf_name)
        {
            var show_pdf = '../upload/static/'+pdf_name;
            open(show_pdf);
        }
    }
   
}
</script>


<style scoped>
/* Slider */

</style>
// import 'es6-promise/auto'
import axios from 'axios'
import './bootstrap'
import VueAuth from '@websanova/vue-auth'
import VueAxios from 'vue-axios'
import VueRouter from 'vue-router'
import Index from './Index'
import auth from './auth'
import VueSidebarMenu from 'vue-sidebar-menu'
import router from './router'
import Vuex from 'vuex';
import * as VueGoogleMaps from "vue2-google-maps";
import DatePicker from 'vue2-datepicker';
import { BulmaAccordion, BulmaAccordionItem } from "vue-bulma-accordion";
import Slick from 'vue-slick'; //vue slick
import VueAnalytics from 'vue-analytics'

Vue.use(VueAnalytics, {
    id: 'UA-164662727-1',
    router,
})
// id: 'UA-164662727-1',
// id: 'UA-161193570-2',

Vue.use(Slick);
Vue.use(BulmaAccordion, BulmaAccordionItem)
Vue.use(Vuex);
Vue.use(DatePicker);
Vue.use(VueSidebarMenu);
//start editor

//start onepage
import 'animate.css'
let globalData = new Vue({
    data: {
        nusFav: 0,
        hosFav: 0,
        nusHis: 0,
        hosHis: 0,
        visit: 'true',
        loginuser: 'false',
        test: [],
        logintoken: '',
    }
});

Vue.mixin({
    computed: {
        nusFav: {
            get: function() { return globalData.$data.nusFav },
            set: function(newVal) { globalData.$data.nusFav = newVal; }
        },
        hosFav: {
            get: function() { return globalData.$data.hosFav },
            set: function(newVal) { globalData.$data.hosFav = newVal; }
        },
        nusHis: {
            get: function() { return globalData.$data.nusHis },
            set: function(newVal) { globalData.$data.nusHis = newVal; }
        },
        hosHis: {
            get: function() { return globalData.$data.hosHis },
            set: function(newVal) { globalData.$data.hosHis = newVal; }
        },
        visit: {
            get: function() { return globalData.$data.visit },
            set: function(newVal) { globalData.$data.visit = newVal; }
        },
        loginuser: {
            get: function() { return globalData.$data.loginuser },
            set: function(newVal) { globalData.$data.loginuser = newVal; }
        },
        test: {
            get: function() { return globalData.$data.test },
            set: function(newVal) { globalData.$data.test = newVal; }
        },
        logintoken: {
            get: function() { return globalData.$data.logintoken },
            set: function(newVal) { 
                globalData.$data.logintoken = newVal; }
        }
    }
})

import VueCarousel from '@chenfengyuan/vue-carousel';
Vue.component(VueCarousel.name, VueCarousel);

Vue.component('pagination', require('laravel-vue-pagination'));


var VueScrollactive = require('vue-scrollactive');
Vue.use(VueScrollactive);

//vue-pannellum
import VuePannellum from '../js/components/vue-pannellum.vue'
Vue.use(VuePannellum);
Vue.component('VPannellumn', VuePannellum)

//vue Panorama
// import Panorama from 'vuejs-panorama';
// Vue.use(Panorama);

//vue sweetaler
import VueSweetAlert from 'vue-sweetalert';
Vue.use(VueSweetAlert)

import ReadMore from 'vue-read-more';
Vue.use(ReadMore);


//start Light Gallery
import Lightbox from 'vue-my-photos'
Vue.use(Lightbox)
    //end Light Gallery

Vue.use(require('vue-moment'));
// Vue.use(require('vue-moment'));

//autocomplete

//end autocomplete
//vuejs loading
import VueLoading from 'vuejs-loading-plugin'
// import { Button } from 'iview'
Vue.use(VueLoading, {
    text: ''
})

window.events = new Vue();
Vue.use(VueClazyLoad)
    // Vue.use(VueRouter);
Vue.use(VueAxios, axios);

Vue.use(VueGoogleMaps, {
    load: {
        key: "AIzaSyC-2U_IRuSrajQavHadFp8FlXNi61MA3nw",
    }
});

// Set Vue globally
window.Vue = Vue
    // Set Vue router
Vue.router = router
Vue.use(VueRouter)


    // Set Vue authentication
Vue.use(VueAxios, axios)
axios.defaults.baseURL = `${process.env.MIX_APP_URL}`
Vue.use(VueAuth, auth)

Vue.component('index', Index)

router.beforeEach((to, from, next) => {
    NProgress.start()
    NProgress.set(0.1)
    next()
})
router.afterEach(() => {
    setTimeout(() => NProgress.done(), 500)
})

const app = new Vue({
    el: '#app',
    router,
    component: {
        Index,
        meta: {
            auth: undefined
        }
    },

});
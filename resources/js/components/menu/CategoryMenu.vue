<template>
    <div class="tab-pane" id="tab1">
            <!-- slider -->
            <div v-if="this.$route.path === '/' || this.$route.path.includes('/newscategory')" class="d-sm-block cat-nav clearfix infoBox" ref="infoBox">
                <div class="no-scrollbar" id="myTab" ref="content" v-bind:style="{ width: computed_width }">
                    <ul role="tablist">
                        <li v-for="(cat, index) in cats" :key="cat.id" class="nav-item nav-line tab_color" id="category-id" :style="{'--bkgColor': cat.color_code ? cat.color_code : '#287db4'}"  v-bind:value="cat.id" v-on:click="scrollUp(index);changeBgColor(cat.color_code);" ref="itemWidth">
                           <router-link v-if="cat.name != 'トップ'"  class="nav-link" :to="{ path:'/newscategory/'+ cat.id}">{{ cat.name }}</router-link>
                           <router-link v-else id="top" class="nav-link" :to="{ path:'/'}">{{ cat.name }}</router-link>
                        </li>
                    </ul>                            
                </div>
                <div class="bg_color" :style="lineStyle"></div>
            </div>      
    </div>
</template>
<script>

import { eventBus } from '../../event-bus.js';

export default {
    mounted() {
        if(localStorage.getItem("clicked") == null){
            localStorage.setItem('clicked', 1);
        } 
    },
    data(){
        return {
            cats: [],
            computed_width: '100%',
            w_width: window.innerWidth,
            bgColor: "",
        }
    },
    created() {              
        this.getAllCat();
    },
    computed: {
        lineStyle() {
        return {
            '--bg-color': this.bgColor,
            }
        }
    },
    updated:function(){
        if(this.$route.path === '/'){
            this.bgColor = this.cats[0].color_code ? this.cats[0].color_code : "#287db4";
        }else if(this.$route.path.includes('/newscategory')){
            eventBus.$on('gotColor', color => {
                this.bgColor = color ? color : "#287db4";
            });
        }
    },
    methods: {
        getAllCat: function() {           
                this.axios .get('/api/home') 
                .then(response => {
                        this.cats = response.data;
                        if(this.$route.path.includes('/newscategory')){
                            eventBus.$on('gotColor', color => {
                            this.bgColor = color ? color : localStorage.getItem("bgColor") ? localStorage.getItem("bgColor") : "#287db4";
                            });

                        }else{
                            this.bgColor = this.cats[0].color_code;
                            eventBus.$emit('gotColor', this.cats[0].color_code);
                        }
                    });

        },
        changeBgColor(color_code) {
            this.bgColor =  color_code ? color_code : "#287db4";
            localStorage.setItem('bgColor', this.bgColor);
            eventBus.$emit('gotColor', color_code);
        },
        scrollUp(index){
            if(localStorage.getItem("clicked")){
                if(index >= localStorage.getItem('clicked')){
                    var pos = $('div#myTab').scrollLeft() + 100;
                }else{
                    var pos = $('div#myTab').scrollLeft() - 100;
                }
            }
            $('div#myTab').scrollLeft(pos);
            localStorage.setItem('clicked', index);    
        },
    }
}
</script>



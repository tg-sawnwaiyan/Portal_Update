<template>
    <div class="tab-pane" id="tab1">
            <!-- slider -->
            <div v-if="this.$route.path === '/' || this.$route.path.includes('/newscategory')" class="infoBox" ref="infoBox">
                <div class="no-scrollbar" id="myTab" ref="content">
                    <ul class="nav" role="tablist">
                        <li v-for="(cat, index) in cats" :key="cat.id" id="category-id" :class="'tab-color'+(Math.floor(index%5))" v-bind:value="cat.id" v-on:click="scrollUp(index);changeBgColor((Math.floor(index%5)));" ref="itemWidth">
                           <router-link v-if="!!cat.id"  class="nav-link" :to="{ path:'/newscategory/'+ cat.id}">{{ cat.name }}</router-link>
                           <router-link v-else id="top" class="nav-link" :to="{ path:'/'}">{{ cat.name }}</router-link>
                        </li>
                    </ul>                            
                </div>
                <div class="bg_color"></div>
            </div>      
    </div>
</template>
<script>
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
            w_width: $(window).width(),
        }
    },
    created() {              
        this.getAllCat();
    },
    methods: {
        getAllCat: function() {           
                this.axios .get('/api/home') 
                .then(response => {
                        const topic = new Array();
                        topic['name'] = "トップ";
                    
                        this.cats = response.data;
                        this.cats = [topic].concat(this.cats);

                    });
        },
        changeBgColor(no) {
            const color_ary = ['#287db4','#a3774a','#9579ef','#20d1de','#d1281c'];
            $('.bg_color').css('background-color', color_ary[no]);
        },
        scrollUp(index){
            if(localStorage.getItem("clicked")){
                if(index >= localStorage.getItem('clicked')){
                    var pos = $('div.nav').scrollLeft() + 100;
                }else{
                    var pos = $('div.nav').scrollLeft() - 100;
                }
            }
            $('div.nav').scrollLeft(pos);
            localStorage.setItem('clicked', index);    
        },
    }
}
</script>
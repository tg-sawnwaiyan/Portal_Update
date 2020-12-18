<template>
    <div>
        <nav class="navbar navbar-expand-lg  main-header">
            <div class="container nav-warp d-flex">
                <div class="d-flex align-items-center">
                    <a class="navbar-brand logo-text">               
                        <h4 class="logo_subtitle">介護医療福祉の総合サイト</h4>
                        <img src="/images/fixed_logo.png" class="logo_img"/>
                    </a>
                </div>
            </div>
        </nav>
        <div class="unauth-page">
            <div class="content">
                <div class="unauth-title">
                    <div class="col-12">
                        <img src="/images/cloud-cross.png">               
                    </div>
                    <p class="unauth-title">ページがみつかりません。                
                        <span class="unauth-span">URLに間違いがないかご確認ください。</span>
                    </p>
                    <div class="text-center">
                        <a href="/" class="gohome all-btn">ホームページに戻る</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<style>
    .img_logo{
        width:215px;
        height:auto; 
    }
    .unauth-page .unauth-title .col-12{
        margin:0 auto;
        margin-bottom: 30px;
    }
    .unauth-page .unauth-title .col-12 img{
        width: 34%;
    }
    .unauth-span{
        font-size:20px;
        display:block;
    }
</style>
<script>
export default {
    methods:{
        created(){
            this.$loading(false);
        },
    }
}
</script>
<template>
  <div>
      <h2 class="site_header">TIS（ティーズ） のホームページへの設定方法</h2>
      <div class="container pad-free-750">
       <div class="sitepolicy_home">
            <span>TIS（ティーズ） をホームページに設定すると、ご利用のブラウザを開いてすぐに TIS（ティーズ） を使うことができます。<br>
            ご利用のブラウザを選択し、手順の通りに操作してください。</span>
        </div>    

        <!-- <div class="title">
          <h5>ホームページを変更する方法</h5>
        </div>  
        <div class="sitepolicy_home">
            <span>下記のブラウザを選択し、手順どおりに操作してください。下記以外のブラウザを使う場合は、お使いのブラウザの [ヘルプ] から、ブラウザのホームページを変更する方法をご確認ください。</span>
            

        </div>     -->

        <div class="title" v-on:click="isActive1 = !isActive1">
          <i class="fal fa-angle-down"></i>
          <h5>Google Chrome</h5>
        </div>
        <div class="privacy" v-if="isActive1">
             <ol class="sub-ol">
                <li>
                    ブラウザの右上にある 「三点マーク」をクリックし、 <strong>「設定」</strong> を選択します。
                </li>
                <li>
                  「デザイン」の <strong>「ホームボタンを表示する」</strong> を有効にします。
                </li>
                <li>
                   2 番目のオプションを選択し、「<span style="color: green">https://t-i-s.jp</span>」と入力します。
                </li>
            </ol>    
        </div>

        <div class="title" v-on:click="isActive2 = !isActive2">
          <h5>Microsoft Edge</h5>
        </div>
        <div class="privacy" v-if="isActive2">
             <ol class="sub-ol">
                <li>
                    ブラウザの右上にある「・・・」 をクリックし、 <strong>「設定」</strong> を選択します。
                </li>
                <li>
                   「起動時」を選択し、<strong>「特定のページを開く」</strong> に変更します。
                </li>
                <li>
                   <strong>「新しいページを追加してください」</strong> を選択します。
                </li>
                <li>
                    <strong>「URLを入力してください」</strong> 欄に「<span style="color: green">https://t-i-s.jp</span>」と入力し、<strong>「追加」</strong>を選択します。
                </li>
                <li>
                    ブラウザを再起動します。
                </li>
            </ol>    
        </div>

        <div class="title" v-on:click="isActive3 = !isActive3">
          <h5>Internet Explorer</h5>
        </div>
        <div class="privacy" v-if="isActive3">
             <ol class="sub-ol">
                <li>
                    ブラウザ上部の <strong>「歯車マーク」</strong>をクリックします。
                </li>
                <li>
                   <strong> 「インターネット オプション」</strong> を選択します。
                </li>
                <li>
                   <strong>「全般」</strong> タブの「ホームページ」のテキスト ボックスに「<span style="color: green">https://t-i-s.jp</span>」と入力します。
                </li>
                <li>
                   <strong>「OK」</strong> をクリックします。
                </li>
                <li>
                   ブラウザを再起動します。
                </li>
            </ol>    
        </div>

        <div class="title" v-on:click="isActive4 = !isActive4">
          <h5>Firefox</h5>
        </div>
        <div class="privacy" v-if="isActive4">
            <ol class="sub-ol">
                <li>
                    ブラウザを開いて <a href="https://www.t-i-s.jp" target="_blank" rel="noopener">t-i-s.jp</a> にアクセスします。
                </li>
                <li>
                    ホームボタンにタブをドラッグ＆ドロップします。
                </li>
                <li>
                    <strong>「はい」</strong> をクリックします。
                </li>
            </ol>      
        </div>

        <div class="title" v-on:click="isActive5 = !isActive5">
          <h5>Safari</h5>
        </div>
        <div class="privacy" v-if="isActive5">
            <ol class="sub-ol">
                <li>
                    画面の左上にある <strong>「Safari」</strong> <strong>「環境設定」</strong> <strong>「一般」</strong> を選択します。
                </li>
                <li>
                   「新規ウィンドウを開く場合」と 「新規タブを開く場合」で <strong>「ホームページ」</strong> を選択します。
                </li>
                <li>
                   「ホームページ」欄に「<span style="color: green">https://t-i-s.jp</span>」と入力します。
                </li>
                <li>
                   ブラウザを再起動します。
                </li>
            </ol>    
        </div>
      </div>
  </div>
</template>
<script>
  export default {
   // el: "#aa",
    data: function() {        
      return {
         isActive1: true,
         isActive2: true,
         isActive3: true,
         isActive4: true,
         isActive5: true,
      }
    },
    method: {
        aa: function () {
          alert("hi");
      this.isActive = !this.isActive;
    }  
    }
  }
</script>


<template>
  <div class="aboutus">
      <h2 class="site_header">運営会社</h2>
      <div class="container pad-free-750">
        <div class="title" id="browser1" v-on:click="toggle(1);isActive1 = !isActive1" >
          <table>
        <tbody>
          <tr>
          <th>社名</th>
          <td>株式会社 TRUST-ESTATE</td>
          </tr>
          <tr>
          <th>所在地</th>
          <td>〒164-0003　<br>東京都中野区東中野１－５９－９　リックビル2階<br>東中野駅西口徒歩1分</td>
          </tr>
          <tr>
          <th>メール</th>
          <td><a class="email" href="mailto: info@t-i-s.jp">info@t-i-s.jp</a></td>
          </tr>
          <tr>
          <th>設立</th>
          <td>平成18年9月1日</td>
          </tr>
          <tr>
          <th>役員</th>
          <td>代表取締役　庄司芳則</td>
          </tr>
          <tr>
          <th>取引銀行</th>
          <td>三菱UFJ銀行新宿中央支店</td>
          </tr>
          <tr>
          <th>事業内容</th>
          <td>外国人向け賃貸物件の仲介<br>不動産売買仲介<br>各種　保険代理店<br>介護・医療・福祉の情報総合メディア「TIS(ティーズ)／Trust Information Space」の運営</td>
          </tr>
          <tr>
          <th>会社資格</th>
          <td>宅地建物取引業者　東京都知事（1）103487</td>
          </tr>
          <tr>
          <th>URL</th>
          <td><a class="link-page" href="https://trust-estate.jp/" target="_blank">https://trust-estate.jp/</a></td>
          </tr>
        </tbody>
        </table>
        </div>
      </div>
  </div>
</template>
<script>
  export default {
    data: function() {        
      return {
         isActive1: false,
         isActive2: false,
         isActive3: false,
         isActive4: false,
         isActive5: false,
      }
    },
    methods: {
      toggle(id) {
          $('.title').removeClass('active');
          $('#browser'+id).addClass('active');
      }
    }
  }
</script>


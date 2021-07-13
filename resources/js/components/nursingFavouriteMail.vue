
<template>
    <div>
        <div class="tab-content job-detail margin-none">
            <div class="row">
                <div class="col-md-12 pad-free m-b-10 cmt-1">
                    <nav aria-label="breadcrumb">                       
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">                                
                                <router-link to="/" >ホーム</router-link>
                            </li>                          
                           <li class="breadcrumb-item"><span>介護施設資料請求</span></li>
                        </ol>
                    </nav>
                </div>
                <div class="col-12 m-b-10">

                </div>
                <div class="col-md-12 register_box" v-if="type == 'register'">
                    <ul class="multi-step">
                        <li class="active">1.<span>お客様情報のご入力</span>入力</li>
                        <li class="no-active">2.<span>入力内容のご確認</span>確認</li>
                        <li>3.<span>送信完了</span>完了</li>
                    </ul>
                    <!--inputform-->
                    <form class="col-md-12 form-wrap" autocomplete="off">
                        <h4 class="form-tit">資料請求される方について</h4>
                        <!-- <h4 class="nursing-info">資料請求される方について</h4> -->
                        <p class="require-txt"><span class="error sp1" style="margin-left:0px;">必須</span> のついた項目は全て入力してくださいますようお願いいたします。</p>
                        <div class="form-group m-0 row bd">
                            <div class="col-md-3 col-sm-12 form-left"><label><strong>お名前 </strong><span class="error sp1">必須</span></label></div>
                            <div class="col-md-9 col-sm-12 form-right">
                                <input type="text" id="tbname" name="name" class="form-control float-left" placeholder="お名前を入力してください。" v-model="comments.name" @change="aggreBtn" @focusout="focusName" @keyup="focusName"/>
                                <span class="float-left eg-txt">例）探し太郎</span>
                                 <span class="error m-l-30" v-if="comment_focus">※入力は必須です。</span>
                            </div>
                        </div>
                        <div class="form-group m-0 row bd">
                            <div class="col-md-3 col-sm-12 form-left"> <label><strong>フリガナ </strong><span class="error sp1">必須</span></label></div>
                            <div class="col-md-9 col-sm-12 form-right">
                                <div class="col-md-12 pad-free">
                                    <!-- <div class="col-md-9 pad-free"> -->
                                        <input type="text" id="furigana" name="furigana" class="form-control float-left" placeholder="フリガナを入力してください。" v-model="comments.furigana" @keyup="ChekChar" @focusout="ChekChar" @change="aggreBtn"/>
                                    <!-- </div>
                                    <div class="col-md-3"> -->
                                         <span class="float-left eg-txt"> 例）サガシタロウ</span>
                                        <span class="error m-l-30" v-if="furigana_focus " >※入力は必須です。</span>

                                    <!-- </div> -->

                                </div>
                                 <span class="float-left error p-l-30" v-if="charErr">※カタカナで入力してください。</span>

                            </div>
                        </div>
                        <div class="form-group m-0 row bd">
                            <div class="col-md-3 col-sm-12 form-left"> <label><strong>生年月日</strong> </label></div>
                            <div class="col-md-9 col-sm-12 form-right">
                                <!-- <input type="text" id="bdate" name="bdate" class="form-control float-left" placeholder="生年月日を入力してください。" v-model="comments.bdate" @change="aggreBtn" @focusout="focusbdate"/> -->
                                <date-picker class="" :lang="lang" valueType="format" v-model="comments.bdate" style="margin-left: 20px;"></date-picker>
                                <!-- <span class="error m-l-30" v-if="bdate_focus">※入力は必須です。</span> -->
                            </div>
                        </div>
                        <div class="form-group m-0 row bd">
                                <div class="col-md-3 col-sm-12 form-left"><label><strong>性別</strong> </label></div>
                                <div class="col-md-9 col-sm-12 form-right pl-4">
                                    <label class="control control--radio">
                                        <input type="radio" class="custom-radio" id="sex1" name="sex1" value="男性"  v-model="comments.sex1">&nbsp;男性&nbsp;&nbsp;&nbsp;&nbsp;
                                        <!-- <input type="radio" class="custom-radio" id="sex1" name="sex1" value="女性"    v-model="comments.sex1">&nbsp;女性&nbsp;&nbsp;&nbsp;&nbsp;
                                        <input type="radio" class="custom-radio" id="sex1" name="sex1" value="夫婦"   v-model="comments.sex1">&nbsp;夫婦 -->
                                         <div class="control__indicator"></div>
                                    </label>
                                    <label class="control control--radio">
                                        <input type="radio" class="custom-radio" id="sex1" name="sex1" value="女性"    v-model="comments.sex1">&nbsp;女性&nbsp;&nbsp;&nbsp;&nbsp;
                                        <div class="control__indicator"></div>
                                    </label>
                                    <label class="control control--radio">
                                       <input type="radio" class="custom-radio" id="sex1" name="sex1" value="夫婦"   v-model="comments.sex1">&nbsp;夫婦
                                        <div class="control__indicator"></div>
                                    </label>

                                </div>
                            </div>
                        <div class="form-group m-0 row bd">
                            <div class="col-md-3 col-sm-12 form-left"> 
                            <div class="row col-12 m-0 p-0">
                                <div class="col-xl-3 col-lg-3 col-12 p-0">
                                    <label class="subtitle"><strong>ご住所</strong></label>
                                </div>               
                                <div class="col-xl-9 col-lg-9 col-12 p-0 stepper-form">                                                                   
                                    <div class="form-left-child form-group pc-750"><label> <strong>郵便番号 </strong></label></div>
                                    <div class="form-left-child form-group pc-750"><label><strong>都道府県</strong><span class="error sp1">必須</span></label></div>
                                    <div class="form-left-child form-group pc-750"><label><strong>市区町村</strong> <span class="error sp1">必須</span></label></div>
                                    <div class="form-left-child form-group pc-750"><label><strong>番地（建物名)</strong><span class="error sp1">必須</span></label></div>                                    
                                </div>           
                            </div>    
                            </div>                           
                            <div class="col-md-9 col-sm-12 form-right stepper-form">
                                <div class="form-group  rightwrap row pl-3">
                                    <div class="col-md-12 sp-750"><label> <strong>郵便番号 </strong></label></div>
                                    <div class="col-md-12 rightwrap-child p-0 ">
                                        <input type="text" v-model="comments.postal" name="postal" v-on:keydown="postalNumber" class="postal form-control float-left" id="postal" placeholder="郵便番号を入力してください。" maxlength="7"/>                                        
                                        <span class="float-left submit1 btn main-bg-color continue all-btn submit m-l-10 pc-1024" @click="getPostal"><span class="first_txt">郵便番号より住所を</span><span class="dinone">検索</span></span>
                                        <span class="float-left m-l-10">例）1006740 (<a href="https://www.post.japanpost.jp/zipcode/" target="_blank" class="pseudolink">郵便番号検索</a>)</span>
                                    </div>
                                    <div id="jsErrorMessage" class="float-left eg-txt"></div>
                                </div>
                                <div class="form-group row pl-3">                                  
                                    <div class="col-md-12 sp-750"><label> <strong> 都道府県</strong><span class="error sp1">必須</span></label></div>
                                    <div class="col-md-12 p-0">
                                        <select v-model="comments.selectedValue" class="division form-control" id="division" @change="getTownship(2)">
                                            <option value="0">選択してください。</option>
                                            <option v-for="cities in city_list" :key="cities.id" v-bind:value="cities.id">
                                                {{cities.city_name}}
                                            </option>
                                        </select>
                                        <span v-if="errors.division" class="error">{{errors.division[0]}}</span>
                                    </div>
                                </div>

                                 <div class="form-group row pl-3">                             
                                    <div class="col-md-12 sp-750"><label>  <strong>市区町村 </strong><span class="error sp1">必須</span></label></div>
                                    <div class="col-md-12 p-0">
                                        <select v-model="comments.township" class="division form-control" id="division" @change="aggreBtn">
                                            <option value="0">選択してください。</option>
                                            <option v-for="town in comments.townships_list" :key="town.id" v-bind:value="town.id">
                                                {{town.township_name}}
                                            </option>
                                        </select>
                                        <!-- <span v-if="errors.division" class="error">{{errors.division[0]}}</span> -->
                                    </div>  
                                </div>
                                <div class="form-group row pl-3 m-b-0">
                                    <div class="col-md-12 sp-750"><label><strong>番地（建物名)</strong><span class="error sp1">必須</span></label></div>
                                    <div class="col-md-12 p-0">
                                         <input type="text" id="city" name="city" class="city form-control float-left" placeholder="番地を入力してください。" v-model="comments.city" @change="aggreBtn" @keyup="focusCity">
                                        <span class="float-left eg-txt">例）区丸の内1-9-1 グラントウキョウノースタワー40階</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group m-0 row bd-all">
                            <div class="col-md-3 col-sm-12 form-left"><label class="pl-0"><strong>電話番号</strong></label></div>
                            <div class="col-md-9 col-sm-12 form-right p-b-0">
                            <div class="row pl-3">
                                    <div class="col-md-12 p-0">
                                        <label class="col-md-12">※ 電話番号またはメールアドレス必須 <span class="error sp1">必須</span></label>
                                        <input type="text" id="phone" name="number" class="form-control float-left" placeholder="電話番号を入力してください。" v-model="comments.phone"   @keyup="focusPhone" @change="aggreBtn" maxlength="13">
                                        <!-- v-on:keyup="isNumberOnly" -->
                                                                               
                                        <span class="float-left eg-txt">例）0312345678（半角）</span>
                                        <!-- <span class="error m-l-30" v-if="mail_focus">※入力は必須です。</span>                                        -->
                                    </div>
                                     <span class="error m-l-30" v-if="ph_length">※電話番号が正しくありません。もう一度入力してください。</span>
                                </div>
                            </div>
                            <!-- </div>
                            <div class="form-group m-0 row bd-all"> -->
                            <div class="col-md-3 col-sm-12 form-left"><label class="pl-0"><strong>メールアドレス </strong></label></div>
                            <div class="col-md-9 col-sm-12 form-right">
                            <div class="row pl-3">
                                <div class="col-md-12 p-0">
                                        <input type="email" id="mail" name="mail" class="form-control float-left" placeholder="メールアドレスを入力してください。" v-model="comments.mail" @change="aggreBtn" @keyup="focusMail">                          
                                        <span class="float-left eg-txt"> 例）abc@example.jp （半角）</span>
                                       
                                    </div>
                                     <span class="error m-l-30" v-if="mail_focus && this.comments.mail !=''">※メールアドレスが正しくありません。もう一度入力してください。</span>
                                </div>
                            </div>
                        </div>
                        <!-- <div class="form-group m-0 row bd-all">
                            <div class="col-md-3 col-sm-12 form-left"><label>プレゼントのご希望:</label></div>
                            <div class="col-md-9 col-sm-12 form-right pl-4">
                                <input type="checkbox" id="present"  name="present" value="早分かり用語集」プレゼントを希望する" v-model="comments.present" @change="aggreBtn">「早分かり用語集」プレゼントを希望する
                            </div>
                        </div> -->
                       

                        <div class="btn-list mt-5 clearfix">
                             <div class="mt-1 submit txt-err" v-if="btn_disable">
                            <div class="error">※未入力の必須項目がございます。</div>
                        </div>
                            <ul>
                                <!-- <li class="m-r-15"><a @click="$router.go(-1)" class="btn btn-danger all-btn submit">戻る</a></li> -->
                                <li> <button type="button" :disabled="isdisable" class="submit1 btn main-bg-color continue all-btn submit" @click="add()">確認ページに進む</button></li>
                                
                            </ul>
                        </div>
                        <!--next_form-->
                        <div class="m-t-30">
                            <h5 class="form-tit">入居対象者様について</h5>
                            <div class="form-group m-0 row bd">
                                <div class="col-md-3 col-sm-12 form-left">
                                    <label><strong>入居対象者様とのご関係</strong></label>
                                </div>
                                <div class="col-md-9 col-sm-12 form-right">
                                    <select class="form-control" id="relation"  v-model="comments.relation">
                                        <option value="">選択してください</option>
                                        <option value="本人">本人</option>
                                        <option value="家族">家族</option>
                                        <option value="親族">親族</option>
                                        <option value="友人">友人</option>
                                        <option value="ケアマネージャー">ケアマネージャー</option>
                                        <option value="ソーシャルワーカー">ソーシャルワーカー</option>
                                        <option value="その他">その他</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group m-0 row bd">
                                <div class="col-md-3 col-sm-12 form-left"><label><strong>お名前</strong></label></div>
                                <div class="col-md-9 col-sm-12 form-right">
                                    <input type="text" id="ttname" name="ttname" class="form-control float-left" placeholder="お名前を入力してください。"  v-model="comments.ttname">
                                    <span class="eg-txt float-left">例）探し太郎</span>
                                </div>
                            </div>
                            <div class="form-group m-0 row bd">
                                <div class="col-md-3 col-sm-12 form-left"><label><strong>性別</strong></label></div>
                                <div class="col-md-9 col-sm-12 form-right pl-4">
                                     <label class=" control control--radio">
                                        <input type="radio" class="custom-radio" id="sex" name="sex" value="男性"  v-model="comments.sex">&nbsp;男性&nbsp;&nbsp;&nbsp;&nbsp;
                                        <div class="control__indicator"></div>
                                     </label>
                                    <label class="control control--radio">
                                         <input type="radio" class="custom-radio" id="sex" name="sex" value="女性"    v-model="comments.sex">&nbsp;女性&nbsp;&nbsp;&nbsp;&nbsp;
                                          <div class="control__indicator"></div>
                                    </label>
                                   <label class="control control--radio">
                                       <input type="radio" class="custom-radio" id="sex" name="sex" value="夫婦"   v-model="comments.sex">&nbsp;夫婦
                                       <div class="control__indicator"></div>
                                   </label>

                                </div>
                            </div>
                            <div class="form-group m-0 row bd">
                                <div class="col-md-3 col-sm-12 form-left"><label><strong>年齢</strong></label></div>
                                <div class="col-md-9 col-sm-12 form-right">
                                    <select class="form-control" id="years"  v-model="comments.years">
                                        <option value="">選択してください</option>
                                        <optgroup label="50代">
                                            <option value="50">50</option>
                                            <option value="51">51</option>
                                            <option value="52">52</option>
                                            <option value="53">53</option>
                                            <option value="54">54</option>
                                            <option value="55">55</option>
                                            <option value="56">56</option>
                                            <option value="57">57</option>
                                            <option value="58">58</option>
                                            <option value="59">59</option>
                                        </optgroup>
                                        <optgroup label="60代">
                                            <option value="60">60</option>
                                            <option value="61">61</option>
                                            <option value="62">62</option>
                                            <option value="63">63</option>
                                            <option value="64">64</option>
                                            <option value="65">65</option>
                                            <option value="66">66</option>
                                            <option value="67">67</option>
                                            <option value="68">68</option>
                                            <option value="69">69</option>
                                        </optgroup>
                                        <optgroup label="70代">
                                            <option value="70">70</option>
                                            <option value="71">71</option>
                                            <option value="72">72</option>
                                            <option value="73">73</option>
                                            <option value="74">74</option>
                                            <option value="75">75</option>
                                            <option value="76">76</option>
                                            <option value="77">77</option>
                                            <option value="78">78</option>
                                            <option value="79">79</option>
                                        </optgroup>
                                        <optgroup label="80代">
                                            <option value="80">80</option>
                                            <option value="81">81</option>
                                            <option value="82">82</option>
                                            <option value="83">83</option>
                                            <option value="84">84</option>
                                            <option value="85">85</option>
                                            <option value="86">86</option>
                                            <option value="87">87</option>
                                            <option value="88">88</option>
                                            <option value="89">89</option>
                                        </optgroup>
                                        <optgroup label="90代">
                                            <option value="90">90</option>
                                            <option value="91">91</option>
                                            <option value="92">92</option>
                                            <option value="93">93</option>
                                            <option value="94">94</option>
                                            <option value="95">95</option>
                                            <option value="96">96</option>
                                            <option value="97">97</option>
                                            <option value="98">98</option>
                                            <option value="99">99</option>
                                        </optgroup>
                                        <optgroup label="100歳以上">
                                            <option value="100">100</option>
                                            <option value="101">101</option>
                                            <option value="102">102</option>
                                            <option value="103">103</option>
                                            <option value="104">104</option>
                                            <option value="105">105</option>
                                            <option value="106">106</option>
                                            <option value="107">107</option>
                                            <option value="108">108</option>
                                            <option value="109">109</option>
                                            <option value="110">110</option>
                                        </optgroup>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group m-0 row bd">
                                <div class="col-md-3 col-sm-12 form-left"><label><strong>介護度</strong></label></div>
                                <div class="col-md-9 col-sm-12 form-right">
                                    <select class="form-control" id="nursing"  v-model="comments.nursing">
                                        <option value="">選択してください</option>
                                        <option value="自立">自立</option>
                                        <option value="要支援">要支援</option>
                                        <option value="要介護1">要介護1</option>
                                        <option value="要介護2">要介護2</option>
                                        <option value="要介護4">要介護4</option>
                                        <option value="要介護5">要介護5</option>
                                        <option value="不明">不明</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group m-0 row bd">
                                <div class="col-md-3 col-sm-12 form-left"><label><strong>認知症</strong></label></div>
                                <div class="col-md-9 col-sm-12 form-right pl-4">
                                    <label class="control control--radio">
                                        <input type="radio" class="custom-radio" id="fect" name="fect" value="あり"  v-model="comments.fect">&nbsp;あり&nbsp;&nbsp;&nbsp;&nbsp;
                                        <div class="control__indicator"></div>
                                    </label>
                                    <label class="control control--radio">
                                         <input type="radio" class="custom-radio" id="fect" name="fect" value="なし"  v-model="comments.fect">&nbsp;なし&nbsp;&nbsp;&nbsp;&nbsp;
                                         <div class="control__indicator"></div>
                                    </label>
                                   <label class="control control--radio">
                                    <input type="radio" class="custom-radio" id="fect" name="fect" value="わからない"  v-model="comments.fect">&nbsp;わからない &nbsp;&nbsp;&nbsp;&nbsp;
                                    <div class="control__indicator"></div>
                                    </label>
                                </div>
                            </div>
                            <!-- <div class="form-group m-0 row bd">
                                <div class="col-md-3 col-sm-12 form-left"><label>認知症</label></div>
                                <div class="col-md-9 col-sm-12 form-right pl-4">
                                    <input type="radio" id="desire" name="desire" value="できるだけ早く"  v-model="comments.desire">&nbsp;できるだけ早く<br>
                                    <input type="radio" id="desire" name="desire" value="３ヶ月以内"  v-model="comments.desire">&nbsp;３ヶ月以内<br>
                                    <input type="radio" id="desire" name="desire" value="半年以内"  v-model="comments.desire">&nbsp;半年以内<br>
                                    <input type="radio" id="desire" name="desire" value="1年以内"  v-model="comments.desire">&nbsp;1年以内<br>
                                    <input type="radio" id="desire" name="desire" value="未定"  v-model="comments.desire">&nbsp;未定
                                </div>
                            </div> -->
                            <div class="form-group m-0 row bd-all">
                                <div class="col-md-3 col-sm-12 form-left"><label><strong>ご要望や、お困りごと、その他お問い合わせ</strong></label></div>
                                <div class="col-md-9 col-sm-12 form-right pl-4">
                                    <textarea name="hope" id="hope" class="form-control m-0"   v-model="comments.hope" ></textarea>
                                </div>
                            </div>
                        </div>
                        
                        <div class="btn-list mt-5 clearfix">
                            <div class="mt-1 submit txt-err" v-if="btn_disable">
                            <div class="error">※未入力の必須項目がございます。</div>
                            </div>
                            <ul>
                                <!-- <li class="m-r-15"> -->
                                <!-- <router-link :to="{name: 'favouriteNursing'}"  class="btn btn-danger all-btn submit">戻る</router-link> -->
                                <!-- <a @click="$router.go(-1)" class="btn btn-danger all-btn submit">戻る</a>
                                </li> -->
                                <li> <button type="button" :disabled="isdisable" class="submit1 btn main-bg-color continue all-btn submit" @click="add()" >確認ページに進む</button></li>
                               
                            </ul>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    export default {
       data() {
            return {
                lang:{
                days: ['日', '月', '火', '水', '木', '金', '土'],
                months: ['1月', '2月', '3月', '4月', '5月', '6月', '7月', '8月', '9月', '10月', '11月', '12月'],
                placeholder: {
                //date: new Date().toISOString().slice(0,10),
                date: '年 - 月 - 日',

                }
            },
                type:'register',
                comments: {
                    name: '',
                    furigana: '',
                    bdate: '',
                    postal: '',
                    division: 0,
                    townshipname:0,
                    city: '',
                    phone: '',
                    mail: '',
                    present: '',
                    relation: '',
                    ttname: '',
                    sex: '',
                    sex1: '',
                    years: '',
                    nursing: '',
                    fect: '',
                    desire: '',
                    hope: '',
                    fav_mail: [{}],
                    fav_id: [{}],
                    fav_name: [{}],
                    // arr_reserve: [{}],
                    arr_document: [{}],
                    selectedValue: 0,
                    township:0,
                    townships_list:[],
                 
                },
                errors: [],
                fav_nursing: [],
                local_sto: '',
                city_list: [],
                all_mail: [],
                bk_data: [],
                bk_postal: 0,
                // reservation: [],
                documentation: [],
                btn_disable: false,
                comment_focus: false,
                furigana_focus: false,
                bdate_focus: false,
                postal_focus: false,
                city_focus: false,
                phone_focus: false,
                mail_focus: false,
                ph_length: false,
                ph_error: false,
                charErr:false,
                correctVal: null,
                mail_reg: /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,24}))$/,
                phone_reg: /^([0-9]*)$/
            }
        },
        computed: {
            isdisable:function() {
                return this.btn_disable;
            }
        },
        created() {
            this.bk_data = this.$route.params.input_data;
            this.bk_postal = this.$route.params.bk_postal;
            if (this.bk_data != undefined) {
                this.comments = this.bk_data;
                this.selectedValue = this.bk_postal;
            }
            this.axios.get('/api/hospital/citiesList')        
                .then(response => {
                    this.city_list = response.data;
                });
            if(this.comments.name != '' && this.comments.fav_mail != '' && this.comments.selectedValue != 0 && this.comments.township != 0 && this.comments.city != '' && (this.comments.phone != '' || this.comments.mail != '')){
                    this.btn_disable=false;
                }else{
                    this.btn_disable=true;
                }
        },
        mounted() {
            $('#navtab').removeClass('news-tabColor hospital-tabColor nursing-tabColor job-tabColor');
            $('#navtab').addClass('hospital-tabColor');
            $('.tab-content').removeClass('news-borderColor job-borderColor nursing-borderColor hospital-borderColor');
            $('#upper-tab').addClass('hospital-borderColor margin-none');
            $('.google_search_div').addClass('google_search_all');
            $('#headerbar').addClass('headerbarblock');
            $('#sp_headerbar').addClass('headerbarblock');
            $('.maintab-content').addClass('margin-top-none');
        },
        methods: {
            getPostal: function(event) {    
                if (this.comments.postal.length > 5) {
                    var postal = this.comments.postal;
                    this.axios
                        .post('/api/hospital/postList/' + postal)
                        .then(response => {
                            var post_data = response.data.postal_list;
                            var length = response.data.postal_list.length;
                            if (length > 0) {
                                var pref = post_data[0]['city_id'];
                                this.comments.selectedValue = pref;
                                this.getTownship(1);
                                this.comments.township = response.data.township_id[0]['id'];  
                                this.comments.city = post_data[0]["street"];                               
                                this.comments.division = pref;
                              
                                 $('#jsErrorMessage').html('<div class="error"></div>');
                            } else {

                                this.comments.selectedValue = 0;
                                this.comments.township = 0;
                                this.comments.city = '';
                                $('#jsErrorMessage').html('<div class="error">郵便番号の書式を確認してください。</div>');
                            }
                            this.aggreBtn();    
                        });
                }
            },
            getTownship(town_id){
            
            this.axios.get('/api/auth/township',{
                params:{
                city:this.comments.selectedValue
                },
            }).then((response)=>{
                if(town_id == 2)
                {
                this.comments.city = ''
                // this.comments.postal = '';
                    this.comments.township = 0;
                }
                this.comments.townships_list = response.data.townships
                this.aggreBtn();
            })
            
            },
            // getLocation(){

            //     // this.comments.postal = '';
            //     this.comments.city = '';
            //     this.aggreBtn();
            // },
            add() {
                this.all_mail = JSON.parse(localStorage.getItem("item"));
                // this.reservation = JSON.parse(localStorage.getItem("reserve"));
                this.documentation = JSON.parse(localStorage.getItem("document"));
                if(this.all_mail == null || this.documentation == null){
                    this.$router.push({
                        name: 'favouriteNursing',
                    });
                }
                else{
                    for (var i = 0; i < this.all_mail.length; i++) {
                        this.comments.fav_mail.push(this.all_mail[i].email);
                        this.comments.fav_id.push(this.all_mail[i].id);
                        this.comments.fav_name.push(this.all_mail[i].name);
                    }

                    // this.comments.arr_reserve = this.reservation;
                    this.comments.arr_document = this.documentation;
                    this.comments.division = this.comments.selectedValue;
                    localStorage.setItem("inputValue", JSON.stringify(this.comments));
                    var data = JSON.parse(localStorage.getItem("inputValue"));
                    this.$router.push({
                        name: 'nursingMailConfirm',
                    });
                }
                
                
            },
            aggreBtn: function(){
                if(($('#furigana').val().length > 0 && !this.charErr) && this.comments.name != '' && this.comments.selectedValue != 0 && this.comments.township != 0 && this.comments.city != '' && ((this.mail_reg.test(this.comments.mail) || (!this.ph_length && this.comments.phone != '' ) ) && (!this.ph_length && !this.mail_focus))){
                  
                    this.btn_disable=false;
                }else{
                  
                    this.btn_disable=true;
                }
            },
            focusName: function(event) {
                if(this.comments.name != ''){
                    this.comment_focus=false;
                    this.aggreBtn();
                }else{
                    this.comment_focus=true;
                     this.btn_disable = true;
                    document.getElementById('tbname').style.backgroundColor = black;
                }
            },
            // focusFuri: function(event) {
            //     if(this.comments.furigana != ''){
            //         this.furigana_focus=false;
            //         this.aggreBtn();
            //     }else{
            //         this.furigana_focus=true;
            //     }
            // },
            // focusbdate: function(event) {
            //     if(this.comments.bdate != ''){
            //         this.bdate_focus = false;
            //     }else{
            //         this.bdate_focus = true;
            //     }
            // },
            focusCity: function(event) {
                if(this.comments.city != 0){
                    this.city_focus=false;
                    this.aggreBtn();
                }else{
                    this.city_focus=true;
                     this.btn_disable = true;
                }
            },
            focusMail: function(event) {
                if(this.comments.mail != '')
                {
                    if(this.mail_reg.test(this.comments.mail)){
                         this.mail_focus=false;
                    }else{
                        this.mail_focus=true;
                        // this.ph_length = false;
                    }
                }
                else{
                    this.mail_focus = false;
                }
               
                this.aggreBtn();
                // var input_data = $('#phone').val();
                // var code = 0;
                // code = input_data.charCodeAt();
                // if((48 <= code && code <= 57)){
                //     this.ph_error = false;
                // }else{
                //     this.ph_error = true;
                // }

            },

            focusPhone: function(e) {

               if(this.comments.phone != '' )
               {
                    if( (this.phone_reg).test(this.comments.phone) && (this.comments.phone.length >= 10 && this.comments.phone.length <= 13))
                    {
                    
                        this.ph_length = false;
                    
                    }
                    else{
                        this.ph_length = true;
                    }
               }
               else{
                        this.ph_length = false;
               }
            
                this.aggreBtn();
                // var input_data = this.comments.phone;
                // if(((e.keyCode  >= 48 && e.keyCode  <= 57) || (e.keyCode  >= 96 && e.keyCode  <= 105) || (e.keyCode  == 8) || (e.keyCode  == 35) || (e.keyCode  == 36) || (e.keyCode  == 37) || (e.keyCode  == 39) || (e.keyCode  == 46) || (e.keyCode  == 109) || (e.keyCode  == 189)) && input_data.charAt(0) != '-' && !input_data.includes('--'))
                // {
                //     this.correctVal = input_data;
                //     if(input_data.length >= 10 && input_data.length < 14 && input_data.charAt(input_data.length -1 ) != '-'){
                //     this.ph_error = false;
                //     this.ph_length = false;
                //     this.aggreBtn(); 
                //     }
                //     else{
                //     if(input_data.length == 0){
                //         this.ph_error = false;
                //         this.ph_length = false;
                //         this.aggreBtn(); 
                //     }
                //     else{
                //             this.ph_error = true;
                //             this.btn_disable = true;
                //     }
                    
                //     }
                // }
                // else{
                //     // e.preventDefault();
                //     this.comments.phone = this.correctVal;
                //     if(this.comments.phone.length >= 10 && this.comments.phone.length < 14 && this.comments.phone.charAt(this.comments.phone.length -1 ) != '-'){
                //     this.ph_length = false;
                //     this.ph_error = false;
                //     this.aggreBtn(); 
                //     }
                //     else{
                //         if(this.comments.phone.length == 0){
                //             this.ph_error = false;
                //             this.ph_length = false;
                //             this.aggreBtn(); 
                //         }
                //         else{
                //             this.ph_length = true;
                //             this.ph_error = false;
                //             this.btn_disable = true;
                //         }
                    
                //     }
                // }
            
            },

            // focusPhone(){

            // //   var input_data = $('#phone').val(); 
            // //   console.log(input_data.length)
                
            //   if(this.comments.phone.charAt(this.comments.phone.length - 1) != '-' && this.comments.phone.charAt(0) != '-' && ((this.comments.phone.length >= 10 && this.comments.phone.length <= 14) || this.comments.phone.length == 0))
            //   {  
            //       this.ph_num = false;
            //       this.ph_length = false; 
            //       this.aggreBtn();    
            //   }
            //   else{
            //       this.ph_num = true;
            //       this.ph_length = true;
            //       this.btn_disable = true;
            //   }
                    
            // },
            ChekChar: function(event) {
                var _this = this;
               // $('.char-err').text('');
                var input_val = $('#furigana').val();
                var each_val = input_val.split('');
                _this.charErr= false;
                var code = 0;
                $.each(each_val, function (key, value) {
                    code = value.charCodeAt();
                    // if (!(code > 12352 && code < 12447)) {
                    if (!(code > 12448 && code < 12543)) {
                        //$('.char-err').text('ひらがなで入力してください!');
                        _this.btn_disable = true;
                        _this.charErr = true;
                    
                    }  
                });    
                 if(input_val == ''){
                    if(this.comments.furigana != ''){
                    this.furigana_focus=false;                    
                    }else{
                        this.furigana_focus=true;
                    }
                }else{            
                    this.furigana_focus=false;　
                } 
                this.aggreBtn(); 

            },

            // isNumberOnly: function(event) {
            //     // var input_data = $('#phone').val();
            //     var code = 0;
            //     code = this.comments.phone.charCodeAt();
            //     if(this.comments.phone.length >= 10 && this.comments.phone.length <= 14) {
            //         this.ph_length = false;
            //         // console.log('a',this.comments.phone.length)
            //     }else{
            //         this.ph_length = true;
            //         // console.log('b',this.comments.phone.length)
            //     }
            //     if((48 <= code && code <= 57)){
            //         this.ph_error = false;
            //         // console.log('c')
            //     }else{
            //         this.ph_error = true;
            //         // console.log('d')
            //     }
            // },
            postalNumber: function(event) {
                if(!(event.keyCode >= 48 && event.keyCode <= 57) && !(event.keyCode >= 96 && event.keyCode <= 105) 
                    && event.keyCode != 8 && event.keyCode != 46 && !(event.keyCode >= 37 && event.keyCode <= 40)) 
                {
                    event.preventDefault();
                }
            },
        }
    }
</script>

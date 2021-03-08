<template>
  <layout>
<div class="tab_pane_02">
  <div class="col-md-12" style="border-bottom: 1px dashed #2980b9;padding-bottom: 10px; margin-bottom: 20px;">
    <h5 class="font-weight-bold"><i class="fas fa-map" style="color:#2980b9;"></i>&nbsp;地図検索 
        <span v-if="count == false  && searchword != '' && searchword == 'all' && hos_data.length && !stateclick "> 「<span class="result-span">全国</span>の病院 <span class="result-span"> {{hos_data.length}} </span>件」 </span>
        <span v-if="count == false && searchword != '' && searchword != 'all' && hos_data.length && !stateclick "> 「<span class="result-span">{{searchword}}</span>の病院 <span class="result-span"> {{hos_data.length}} </span>件」 </span>
        <span v-if="count == false && id != '-1' && hos_data.length  && stateclick"> 「<span class="result-span">{{hos_data[0].city_name}}</span>の病院 <span class="result-span"> {{hos_data.length}} </span>件」</span>
        <span v-if="count == true && hos_data.length ">「<span class="result-span">{{hos_data[0].city_name}}</span>の病院 <span class="result-span"> {{hos_data.length}} </span>件」</span>
    </h5> 
  </div>
  <div class="search-map card-body"  @mouseover="getStateHover">
    <div class="row" id="hos">
      <div class="col-md-12">
        <div>
          <!-- <div class="info-box"></div> -->
          <div class="row map-wrap">
          <div class="col-lg-5 col-md-12 col-sm-12 float-left map-leftwrapper">
            <h2 class="map-header hospital-map-header" style="bottom: 155px;">赤ちゃんからおと<br/>なまでみんなで通<br/>える街の名医が見<br/>つかります。</h2>

            <!--search input-->
              <div class="wrap">
                <div class="search">
                    <input type="text" id="search-free-word" class="searchTerm" placeholder="地名、病院名、診療科目などを入力" style="border: 3px solid #63b7ff;">
                    <button type="submit" class="searchButton" style="border: 1px solid #63b7ff;background: #63b7ff;" @click="searchfreeword">
                      <i class="fas fa-search"></i> 検索
                  </button>
                </div>
              </div>
            <!--end search input-->
            </div>
        <div class="col-lg-7 col-md-12 col-sm-12 float-right align-center">
            <maptag></maptag>
        </div>
          </div>
        <section id="map-responsive">
            <div class="freeword-responsive">
                <h3 class="map-resicon">
                  <div class="map-text-wrapper">                    
                    <div>
                      <p class="text-left hospital-map-header"> &nbsp;赤ちゃんからおとなまでみんなで通<br class="pc-768"/>える街の名医が見つかります。 </p>
                    </div>
                  </div>
                </h3>
             <!--search input-->
                <div class="search hospital-search-box">
                    <input type="text" class="searchTerm" id="search-free-word-mob" placeholder="地名、病院名、診療科目などを入力">
                    <button type="submit" class="searchButton" @click="searchfreeword">
                      <i class="fas fa-search"></i> 検索
                    </button>
                </div>
              <!--end search input-->
            </div>
            <bulcomponent v-if="!clicksearch && (!ci || (ci && hos_data.length < 1))"></bulcomponent>
        </section>
        <div id="scroll-responsive">
            <div id="hos_search" class="col-12 hospitalselect pad-free m-b-10">

                <div>
                    <h5 class="profile_header m-t-10" style="border-left: 5px solid #63b7ff;">現在の検索条件</h5>

                    <table class="table table-bordered col-12" style="border:none;">
                        <tbody>
                        <tr>
                            <th class="pc-414-table sp-768-block">地域</th>
                            <td class="sp-768-block sp-414-table">
                            <div class="row mt-2 mb-2">
                            <div class="col-lg-9 col-md-8 col-sm-12 m-b-8">
                            <select id="selectCity" class="form-control custom-select" v-model="id" @change="ChangeTownship();search();">
                                <option value="-1" >▼市区町村</option>
                                <option v-for="city in cities" :value="city.id" :key="city.id">{{city.city_name}}</option>
                            </select>
                            </div>
                            <div class="col-lg-3 col-md-4 col-sm-12 pc-414">
                            <button @click="toggleContent" v-if="getTownships.length > 0" class="btn seemore-btn all-btn">
                                <i class="fa" aria-hidden="true"></i>
                                <!-- <em>{{city.city_name}}</em> -->
                                <span id="close"><i class="fas fa-arrow-circle-up"></i> 市区町村エリアを閉じる </span>
                            </button>

                            </div>
                            </div>
                            <div class="toBeToggled" id="toBeToggled">
                              <div class="dropdown search_rsp">
                                  <button type="button" class="btn btn-default btn-sm dropdown-toggle sp-414" data-toggle="dropdown" style="width:100%;text-align:left;">
                                  市から探す
                                  </button>
                                  <ul class="dropdown-menu dropdown-menu-form" aria-labelledby="dropdownMenuButton" v-if="w_width <= 420" @click.stop="stopTheEvent">
                                    <li>
                                    <a data-value="option">
                                      <div class="row">
                                        <div class="col-lg-2 col-md-4 col-sm-4" v-for="township in getTownships" :key="township.id">
                                          <label class="form-check-label control control--checkbox">
                                            <input class="form-check-input" type="checkbox" :id="township.id" :value="township.id" v-model="townshipID" @click="getCheck($event)" >
                                            {{township.township_name}}
                                            <div class="control__indicator"></div>
                                          </label>
                                        </div>
                                      </div>
                                    </a>
                                    </li>
                                  </ul>
                                  <a v-if="w_width >= 420">
                                    <div class="row">
                                        <div class="col-lg-2 col-md-4 col-sm-4" v-for="township in getTownships" :key="township.id">
                                          <label class="form-check-label control control--checkbox">
                                            <input class="form-check-input" type="checkbox" :id="township.id" :value="township.id" v-model="townshipID" @click="getCheck($event)">
                                            {{township.township_name}}
                                            <div class="control__indicator"></div>
                                          </label>
                                        </div>
                                      </div>
                                  </a>
                              </div>
                            </div>
                            </td>
                        </tr>
                        <tr >
                            <th class="pc-414-table sp-768-block">特長</th>
                            <td class="sp-768-block sp-414-table">
                              <!--特長から探す-->
                              <div class="dropdown search_rsp">
                                <button type="button" class="btn btn-default btn-sm dropdown-toggle sp-414" data-toggle="dropdown" style="width:100%;text-align:left;">
                                  特長から探す
                                </button>
                                <ul class="dropdown-menu dropdown-menu-form" aria-labelledby="dropdownMenuButton" v-if="w_width <= 420" @click.stop="stopTheEvent">
                                  <li>

                                  <a data-value="option">
                                      <div class="row">
                                      <div class="col-lg-2 col-md-4 col-sm-4" v-for="feature in special_features" :key="feature.id">
                                        <!-- <label class="form-check-label" > -->
                                          <label class="form-check-label control control--checkbox">
                                          <input  class="form-check-input" type="checkbox" :id="feature.id" v-model="specialfeatureID" :value="feature.id" @click="features($event)" >
                                          {{feature.name}}
                                          <div class="control__indicator"></div>
                                          </label>
                                      </div>
                                      </div>
                                  </a>
                                  </li>
                                </ul>
                                <a v-if="w_width >= 420">

                                      <div class="row">
                                      <div class="col-lg-2 col-md-4 col-sm-4" v-for="feature in special_features" :key="feature.id">
                                          <!-- <label class="form-check-label" > -->
                                          <label class="form-check-label control control--checkbox">
                                          <input  class="form-check-input" type="checkbox" :id="feature.id" v-model="specialfeatureID" :value="feature.id" @click="features($event)">
                                          {{feature.name}}
                                          <div class="control__indicator"></div>
                                          </label>
                                      </div>
                                      </div>
                                  </a>
                              </div>
                              <!--end 特長から探す -->

                            </td>
                        </tr>
                        <tr >
                            <th class="pc-414-table sp-768-block">診療科目</th>
                            <td class="sp-768-block sp-414-table" id="test-td">
                                <div class="form-check form-check-inline row align-items-start innerwrapper" v-if="w_width >= 420">
                                    <div v-for="(v,i) in array_len"  :key="i">
                                        <div class="hospital-subject"  v-for="(subject,index) in subjects.slice((i*3),((i*3)+3))"  :key="index" v-bind:class="{ lastblock: i==array_len-1 }">
                                           <strong class="table-innertitle row col-12 m-b-10">{{subject.name}}</strong>
                                            <div class="row col-md-12">
                                                <div class="col-lg-6 col-md-12 pad-free" v-for="ch in subject.child" :key="ch.id+1">
                                                    <label class="form-check-label control control--checkbox" style="padding-left:5px;">
                                                    <input  class="form-check-input" type="checkbox" :id="ch.id" v-model="subjectID" :value="ch.id">
                                                    {{ch.name}}
                                                    <div class="control__indicator"></div>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--test-->
                                <div v-if="w_width <= 420">
                                <h5 class="font-weight-bold sp-414">診療科目</h5>
                                <div class="dropdown  m-b-10" v-for="(v,i) in subjects" :key="i">
                                <button type="button" class="btn btn-default btn-sm dropdown-toggle sp-414" data-toggle="dropdown" style="width:100%;text-align:left;">
                                 {{v.name}}

                                  <ul class="dropdown-menu dropdown-menu-form search_rsp" aria-labelledby="dropdownMMenuButton"  @click.stop="stopTheEvent">
                                  <li v-for="ch in v.child" :key="ch.id+1">
                                  <a data-value="option" >
                                      <div class="row">
                                      <div class="col-lg-2 col-md-4 col-sm-4" >
                                          <label class="form-check-label control control--checkbox">
                                          <input  class="form-check-input" type="checkbox" :id="ch.id" v-model="subjectID" :value="ch.id">
                                          {{ch.name}}
                                          <div class="control__indicator"></div>
                                          </label>
                                      </div>
                                      </div>
                                  </a>
                                  </li>
                                </ul>
                                </button>
                                </div>
                                </div>
                                <!--end test-->
                            </td>
                        </tr>

                        <tr class="text-center">
                            <td colspan="2" style="border:none;">
                            <button type="button" class="main-bg-color create-btn all-btn col-lg-2 col-md-4 col-sm-2" id="search" name="search" value="検索"  @click="search">
                            <i class="fas fa-search"></i>&nbsp; 検索
                            </button>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                    <div class="col-12">
                        <div class="row">
                            <div id="job_detail" class="col-md-12 col-sm-12 pad-free offset" style="margin-top:20px;" v-for="(hos,index) in displayItems" :key="hos.hos_id">
                                <div class="hos-content">
                                    <div class="job-header">
                                    <div class="row pad-free">
                                        <div class="col-md-10 col-sm-12">
                                        <div>
                                          <p class="job_id4"><span>施設番号:{{hos.profilenumber}}</span></p>
                                        </div>
                                        <h5 class="hos-title">
                                            
                                            <router-link :to="{ path:'/profile/hospital/'+ hos.hos_id}" class="pseudolink">{{hos.name}}</router-link>
                                         
                                        </h5>
                                               
                                        </div>
                                        <div class="col-md-2 col-sm-12">
                                        <p class="float-right pc-768">
                                           
                                        <span class="btn fav-profile fav-item fav-color" v-if="hos.fav_check == '' && !$auth.check()" :class="'view_pro_id'+hos.nursing_id" style="display:block;" @click="favAddFun('add',hos.hos_id,index);"><i class="fas fa-plus-square" style="color:#c40000!important;"></i>&nbsp; お気に入りに追加</span>
                                        <span class="btn fav-profile fav-item fav-color" v-if="hos.fav_check == 'check' && !$auth.check()" :class="'done_pro_id'+hos.nursing_id" style="color:#aaa;display:block;" @click="favAddFun('remove',hos.hos_id,index);"><i class="fas fa-check-double" style="color:#c40000!important;"></i>&nbsp; 追加済み</span>
                                        </p>
                                        </div>
                                    </div>
                                    <div class="row col-12">
                                      <div class="clearfix">

                                        <span v-for="(sub,index) in subject" :key="index+'-'+sub.name+'-'+hos.hos_id">
                                            <span v-if="sub.profile_id == hos.hos_id" class="job_status">
                                              {{sub.name}}
                                            </span>
                                        </span>
                                      </div>
                                    </div>
                                    </div>

                                    <div class="hos-body row clearfix">
                                        <div class="col-lg-3 col-md-6 job-img">
                                            <img v-bind:src="'/upload/hospital_profile/' + hos.logo"  alt="img" class="img-fluid" @error="imgUrlAlt">

                                        </div>
                                        <div class="col-lg-4 col-md-6 job-box">
                                            <table  class="table table-bordered table-sm">                                               
                                                <tr>
                                                    <td style="width:34%;"><span class="job_ico"><i class="fa fa-envelope"></i></span>メールアドレス</td>
                                                    <td class="text-break">{{hos.email}}</td>
                                                </tr>
                                                <tr>
                                                    <td style="width:30%;"><span class="job_ico"><i class="fa fa-map-marker-alt"></i></span>住所</td>
                                                    <td>{{hos.city_name}}{{hos.township_name}}{{hos.address}}</td>
                                                </tr>                                                
                                            </table>
                                            <!--special feature and subject-->
                                          
                                            <h5 class="header m-t-10">こだわりの特長</h5>
                                            <span v-for="(spe,index) in specialfeatures" :key="index+'-'+spe.name+'-'+hos.hos_id">
                                                <span v-if="spe.profile_id == hos.hos_id" class="hos_feature_list">
                                                {{spe.name}}
                                                </span>
                                            </span>
                                            <!--end special feature and subject-->
                                        </div>
                                        <div class="col-lg-5 col-md-12 sp-414-timetable">
                                            <!--schedule-->
                                            <h5 class="header">診療時間
                                                <span class="hos_phone pc-768"><span class="circle-phone"><i class="fa fa-phone-alt"></i></span><span class="phone-no"><a :href="`tel:${hos.phone}`">{{hos.phone}}</a></span></span>
                                            </h5>
                                            
                                            <table class="table table-bordered consultTable">                                                
                                                <tbody>
                                                 <tr class="first-row">
                                                    <th>日付</th>
                                                    <th>月</th>
                                                    <th>火</th>
                                                    <th>水</th>
                                                    <th>木</th>
                                                    <th>金</th>
                                                    <th>土</th>
                                                    <th>日</th>
                                                </tr>
                                                <tr v-for="(time,index) in timetable" :key="index+'-'+time.id+'-'+hos.hos_id" class="text-center">
                                                    <th class="second-hos-row" style="width:8%;" v-if="(hos.hos_id == time.profile_id && time.part == 'am' )">午前</th>
                                                    <th class="second-hos-row" style="width:8%;" v-if="(hos.hos_id == time.profile_id && time.part == 'pm' )">午後</th>
                                                    <th style="width:10%;" v-if="hos.hos_id == time.profile_id">{{time.mon}}</th>
                                                    <th style="width:10%;" v-if="hos.hos_id == time.profile_id">{{time.tue}}</th>
                                                    <th style="width:10%;" v-if="hos.hos_id == time.profile_id">{{time.wed}}</th>
                                                    <th style="width:10%;" v-if="hos.hos_id == time.profile_id">{{time.thu}}</th>
                                                    <th style="width:10%;" v-if="hos.hos_id == time.profile_id">{{time.fri}}</th>
                                                    <th style="width:10%;" v-if="hos.hos_id == time.profile_id">{{time.sat}}</th>
                                                    <th style="width:10%;" v-if="hos.hos_id == time.profile_id">{{time.sun}}</th>
                                                </tr>
                                                </tbody>
                                            </table>
                                            <span v-if="hos.closed_day"> <strong> 休診日：</strong>{{hos.closed_day}}</span>
                                            <!--end schedule-->
                                        </div>
                                    </div>
                                    <div class="row m-t-10">
                                      <div class="col-md-6 col-sm-12 m-b-414 m-b-8">
                                        <span class="sp_hos_phone sp-768"><span class="circle-phone"><i class="fa fa-phone-alt"></i></span><span class="phone-no"><a :href="`tel:${hos.phone}`">{{hos.phone}}</a></span></span>
                                      </div>
                                      <div class="col-md-6 col-sm-12">
                                         <p class="sp-768">
                                          <span class="btn fav-profile fav-item fav-color" v-if="hos.fav_check == '' && !$auth.check()" :class="'view_pro_id'+hos.nursing_id" style="display:block;" @click="favAddFun('add',hos.hos_id,index);"><i class="fas fa-plus-square" style="color:#c40000!important;"></i>&nbsp; お気に入りに追加</span>
                                          <span class="btn fav-profile fav-item fav-color" v-if="hos.fav_check == 'check' && !$auth.check()" :class="'done_pro_id'+hos.nursing_id" style="color:#aaa;display:block;" @click="favAddFun('remove',hos.hos_id,index);"><i class="fas fa-check-double" style="color:#c40000!important;"></i>&nbsp; 追加済み</span>
                                        </p>
                                      </div>
                                    </div>
                                    <div class="mt-4 detail-btn text-center"><router-link :to="{ path:'/profile/hospital/'+ hos.hos_id}" class="btn all-btn">詳細を見る</router-link></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
           <div class="row">
            <div class="col-md-12 col-lg-12 col-sm-6" v-if="show_paginate">
              <nav aria-label="Page navigation example">
                <ul class="pagination">
                  <li class="page-item previous">
                    <span class="spanclass el1 disabled" @click="first"><i class='fas fa-angle-double-left'></i> 最初</span>
                  </li>
                  <li class="page-item ">
                    <span class="spanclass" @click="prev()"><i class='fas fa-angle-left'></i> 前へ</span>
                  </li>
                  <li class="page-item" v-for="(i,index) in displayPageRange" :key="index" :class="{active_page: i-1 === currentPage}">
                    <span class="spanclass" @click="pageSelect(i)">{{i}}</span>
                  </li>
                  <li class="page-item ">
                    <span class="spanclass" @click="next">次へ <i class='fas fa-angle-right'></i></span>
                  </li>
                  <li class="page-item next">
                    <span class="spanclass el2" @click="last">最後 <i class='fas fa-angle-double-right'></i></span>
                  </li>
                </ul>
              </nav>
            </div>
          </div>
            <span v-if="norecord_msg">
                    <div class="container-fuid m-t-20">
                        <p class="nosearch-icon">
                            <svg x="0px" y="0px" width="30" height="30" viewBox="0 0 172 172" style=" fill:red;"><g transform=""><g fill="none" fill-rule="nonzero" stroke="none" stroke-width="1" stroke-linecap="butt" stroke-linejoin="miter" stroke-miterlimit="10" stroke-dasharray="" stroke-dashoffset="0" font-family="none" font-weight="none" font-size="none" text-anchor="none" style="mix-blend-mode: normal"><path d="M0,172v-172h172v172z" fill="none"></path><path d="M86,172c-47.49649,0 -86,-38.50351 -86,-86v0c0,-47.49649 38.50351,-86 86,-86v0c47.49649,0 86,38.50351 86,86v0c0,47.49649 -38.50351,86 -86,86z" fill="none"></path><path d="M86,168.56c-45.59663,0 -82.56,-36.96337 -82.56,-82.56v0c0,-45.59663 36.96337,-82.56 82.56,-82.56v0c45.59663,0 82.56,36.96337 82.56,82.56v0c0,45.59663 -36.96337,82.56 -82.56,82.56z" fill="none"></path><path d="M0,172v-172h172v172z" fill="none"></path><path d="M3.44,168.56v-165.12h165.12v165.12z" fill="none"></path><path d="M86,172c-47.49649,0 -86,-38.50351 -86,-86v0c0,-47.49649 38.50351,-86 86,-86v0c47.49649,0 86,38.50351 86,86v0c0,47.49649 -38.50351,86 -86,86z" fill="none"></path><path d="M86,168.56c-45.59663,0 -82.56,-36.96337 -82.56,-82.56v0c0,-45.59663 36.96337,-82.56 82.56,-82.56v0c45.59663,0 82.56,36.96337 82.56,82.56v0c0,45.59663 -36.96337,82.56 -82.56,82.56z" fill="none"></path><path d="M0,172v-172h172v172z" fill="none"></path><path d="M3.44,168.56v-165.12h165.12v165.12z" fill="none"></path><path d="M86,172c-47.49649,0 -86,-38.50351 -86,-86v0c0,-47.49649 38.50351,-86 86,-86v0c47.49649,0 86,38.50351 86,86v0c0,47.49649 -38.50351,86 -86,86z" fill="none"></path><path d="M86,168.56c-45.59663,0 -82.56,-36.96337 -82.56,-82.56v0c0,-45.59663 36.96337,-82.56 82.56,-82.56v0c45.59663,0 82.56,36.96337 82.56,82.56v0c0,45.59663 -36.96337,82.56 -82.56,82.56z" fill="none"></path><g fill="#666666"><path d="M74.53333,17.2c-31.59643,0 -57.33333,25.73692 -57.33333,57.33333c0,31.59641 25.7369,57.33333 57.33333,57.33333c13.73998,0 26.35834,-4.87915 36.24766,-12.97839l34.23203,34.23203c1.43802,1.49778 3.5734,2.10113 5.5826,1.57735c2.0092,-0.52378 3.57826,-2.09284 4.10204,-4.10204c0.52378,-2.0092 -0.07957,-4.14458 -1.57735,-5.5826l-34.23203,-34.23203c8.09923,-9.88932 12.97839,-22.50768 12.97839,-36.24766c0,-31.59641 -25.7369,-57.33333 -57.33333,-57.33333zM74.53333,28.66667c25.39939,0 45.86667,20.46729 45.86667,45.86667c0,25.39937 -20.46728,45.86667 -45.86667,45.86667c-25.39939,0 -45.86667,-20.46729 -45.86667,-45.86667c0,-25.39937 20.46728,-45.86667 45.86667,-45.86667zM91.67734,51.52161c-1.51229,0.03575 -2.94918,0.66766 -3.99765,1.75807l-13.14636,13.14636l-13.14636,-13.14636c-1.07942,-1.10959 -2.56162,-1.73559 -4.10963,-1.73568c-2.33303,0.00061 -4.43306,1.41473 -5.31096,3.57628c-0.8779,2.16155 -0.3586,4.6395 1.31331,6.26669l13.14636,13.14636l-13.14636,13.14636c-1.49777,1.43802 -2.10111,3.5734 -1.57733,5.58259c0.52378,2.0092 2.09283,3.57825 4.10203,4.10203c2.0092,0.52378 4.14457,-0.07956 5.58259,-1.57733l13.14636,-13.14636l13.14636,13.14636c1.43802,1.49778 3.5734,2.10113 5.5826,1.57735c2.0092,-0.52378 3.57826,-2.09284 4.10204,-4.10204c0.52378,-2.0092 -0.07957,-4.14458 -1.57735,-5.5826l-13.14636,-13.14636l13.14636,-13.14636c1.70419,-1.63875 2.22781,-4.1555 1.31865,-6.33798c-0.90916,-2.18248 -3.06468,-3.58317 -5.42829,-3.52739z"></path></g></g></g></svg>
                        </p>
                        <p class="nosearch-data">お探しの条件に合う病院は見つかりませんでした。</p>
                        <p class="nosearch">条件の変更を行い再度ご検索いだだくと見つかる可能性がございます。</p>
                    </div>
                </span>
        </div>
      </div>
    </div>
  </div>
</div>
</div>
<!-- linked news added by maythirihtet-->
<div v-if="linkednews.length > 0" class="container_news">
  <div class="row-2">
    <div class="text-new">
        <span>News</span>
    </div>
    <div class="button-year" v-for="(year_arr, index) in yeararr" :key="index">
        <button type="button" :class="{ 'active' : year_arr == c_year}" class="btn btn-outline-dark btn-lg btn-2020" @click="showDataByYear(year_arr)" v-bind:id="year_arr">{{year_arr}}年</button>
    </div>

    <div class="scroll-year">
        <div class="year-2020">
            <div v-for="linked_news in linkednews" :key="linked_news.id">
                <div v-if="(linked_news.post_date.includes(c_year))">
                    <article class="row text-body">
                        <div class="new-1">
                            <div class="day">
                                {{linked_news.post_date}}
                            </div>
                            <div>
                                <span v-if="linked_news.status == 1" class="categories p-categories color-3">ニュースリリース</span>
                                <span v-else-if="linked_news.status == 2" class="categories p-categories color-2">メディア掲載</span>
                                <span v-else class="categories p-categories color-1">お知らせ</span>
                            </div>
                        </div>
                        <div class="new-2">
                            <p v-html="linked_news.description"></p> 
                        </div>
                    </article>
                </div>
            </div>
        </div>
    </div>
  </div>
</div>
<!-- end linked news added by maythirihtet-->
</layout>
</template>


<script>
import maptag from './map.vue'
import layout from '../components/home.vue'
import bulcomponent from './bulcomponent.vue'

  export default {
    components: {
        maptag,
        layout,
        bulcomponent
    },

    data() {
      return {
        /**added by maythirihtet */
        c_year:new Date().getFullYear(),
        vactive:true,
        linkednews: [],
        yeararr: [],
        /**end of added by maythirihtet */
        id: -1, timetable:[], hos_data:[], townshipID: [], township_id: [], cities: '', getCity: [], getTownships: [], specialfeatureID:[], special_features: [], specialfeatures:[], fac_types: [], fac_id: [], medical_acceptance: [], subjectID:[], subjects: [], sub_child:[], subject:[], company:[], toggleCheck: true, toggleCheck_1: false, currentPage: 0, size: 20, pageRange: 5, items: [], show_paginate: false, selected: undefined, localst:'', norecord_msg: false, int:0, array_len: 0, window:{ width: 0, height: 0 }, w_width: $(window).width(), showOne:true, count:false, stateclick:false, clicksearch: false, ci: false, isActive: true,
      }
    },
    created(){


        this.axios.get('api/getmap',{
            params:{
            id: this.id,
            township_id:-1,
            moving_in:-1,
            per_month:-1,
            local:0,
            feature:'hospital',
            SpecialFeatureID:[0],
            MedicalAcceptanceID:[0],
            FacTypeID:[0],
            MoveID:[0],
        },
        })
        .then((response) => {
            this.showOne = false;
            this.cities = response.data.city
            this.getCity = response.data.getCity
            this.getTownships = response.data.getTownships
            this.special_features = response.data.special_features
            this.subjects = response.data.subjects;
        })

        /**added by maythirihtet*/
        this.axios.get('/api/getLinkedNews/'+2).then((response) => { 
            this.linkednews = response.data.linkednews,
            this.yeararr = response.data.yeararr;
        });
        /**end of added by maythirihtet */
        window.addEventListener('resize', this.handleResize);
        this.handleResize();
    },
    mounted() {
            $('#navtab').removeClass('news-tabColor hospital-tabColor nursing-tabColor job-tabColor');
            $('#navtab').addClass('hospital-tabColor');
            $('.tab-content').removeClass('news-borderColor job-borderColor nursing-borderColor hospital-borderColor');
            $('#upper-tab').addClass('hospital-borderColor margin-none');
            $('#headerbar').addClass('headerbarblock');
        },
    methods: {
    /**added by maythirihtet */
    showDataByYear(year) {
        this.c_year = year;
    },
    /**end of added by maythirihtet */
    stopTheEvent:function(e){
        $('.dropdown-menu').on('click', function(e) {

            if($(this).hasClass('dropdown-menu-form')) {
                e.stopPropagation();

            }
        });
    },
    handleResize() {
        this.window.width = window.innerWidth;
        this.window.height = window.innerHeight;
        //console.log('hello');
    },
    search(){
        this.count = true;
        this.$loading(true);
        if(this.townshipID == null || this.townshipID == '')
        {
        this.townshipID[0] = 0;
        }
        if(this.specialfeatureID == null || this.specialfeatureID == '')
        {
        this.specialfeatureID[0] = 0;
        }
        if(this.subjectID == null || this.subjectID == '')
        {
        this.subjectID[0] = 0;
        }

        if ($('#search-free-word').val() != '')
        {

            var search_word = $('#search-free-word').val();
            this.searchword = search_word;
        }
        else if ($('#search-free-word-mob').val() != '')
        {

            var search_word = $('#search-free-word-mob').val();
            this.searchword = search_word;
        }
        else{
          var search_word = 'null';
          this.searchword = '';
        }
        if(localStorage.getItem("hospital_fav") == null){

            this.locast = 0;
        }
        else{
            this.locast = localStorage.getItem("hospital_fav");
        }


        this.axios.get('api/gethospitalsearch/'+ search_word,{
        params:{
            id: this.id,
            townshipID:this.townshipID,
            specialfeatureID:this.specialfeatureID,
            subjectID:this.subjectID,
            local:this.locast
        },
        }).then((response)=>{
        this.showOne = false;
        this.$loading(false);
        this.getTownships = response.data.township;
        this.hos_data = response.data.hospital;
        this.timetable = response.data.timetable;
        this.specialfeatures = response.data.specialfeature;
        this.subject = response.data.subject;
        this.subjects = response.data.subjects;
        this.company = response.data.company;

        if(this.hos_data.length > this.size) {
            this.show_paginate = true;
        }else{
            this.show_paginate = false;
        }
        if(this.hos_data.length != 0){
            this.norecord_msg = false;
        }else{
            this.norecord_msg = true;
        }
        })
     
    },
    searchfreeword(){

        this.ci = true;
        this.count = false;
        this.stateclick = false;
        //clear all checkbox
        this.id = -1;
        this.townshipID = [];
        this.specialfeatureID = [];
        this.subjectID = [];

        if(this.townshipID == null || this.townshipID == '')
        {
        this.townshipID[0] = 0;
        }
        if(this.specialfeatureID == null || this.specialfeatureID == '')
        {
        this.specialfeatureID[0] = 0;
        }
        if(this.subjectID == null || this.subjectID == '')
        {
        this.subjectID[0] = 0;
        }

        if ($('#search-free-word').val() != '')
        {

            var search_word = $('#search-free-word').val();
            this.searchword = search_word;
        }
        else if ($('#search-free-word-mob').val() != '')
        {

            var search_word = $('#search-free-word-mob').val();
            this.searchword = search_word;
        }
        else{
                var search_word = "all";
                 this.searchword = search_word;
        }
            if(localStorage.getItem("hospital_fav") == null){

            this.locast = 0;
        }
        else{
            this.locast = localStorage.getItem("hospital_fav");
        }

        this.axios.get('api/gethospitalsearch/'+ search_word,{
        params:{            
            id: this.id,
            townshipID:this.townshipID,
            specialfeatureID:this.specialfeatureID,
            subjectID:this.subjectID,
            local:this.locast

        },
        }).then((response)=>{

                    $('.hospitalselect').removeClass('hospitalselect');
                    $('#hos_search').css("display","block");
                    this.hos_data = response.data.hospital;
                    this.cities = response.data.city;
                    this.timetable = response.data.timetable;
                    this.specialfeatures = response.data.specialfeature;
                    this.special_features = response.data.special_feature;
                    this.getTownships = [];
                    this.subject = response.data.subject;
                    this.subjects = response.data.subjects;
                   
                    if(this.hos_data.length > this.size) {
                        this.show_paginate = true;
                    }else{
                        this.show_paginate = false;
                    }
                    if(this.hos_data.length != 0){
                        this.norecord_msg = false;
                    }else{
                        this.norecord_msg = true;
                    }
                  this.array_len = ((this.subjects.length)%3)==0?((this.subjects.length)/3):Math.floor(((this.subjects.length)/3)+1);
               

            });

        },

        favAddFun(status,index,ind){


        if(status == 'add'){

            this.hos_data[ind].fav_check = 'check';

            if(localStorage.getItem("hospital_fav")){

                var fav_arr = JSON.parse("[" + localStorage.getItem("hospital_fav") + "]");
                fav_arr.push(index);
                fav_arr = [...new Set(fav_arr)];
                localStorage.setItem("hospital_fav", fav_arr);
                // $("#hos-fav-local").html(fav_arr.length);
                this.hosFav = fav_arr.length;
            }
            else{

                var fav_arr = [index];
                localStorage.setItem("hospital_fav", fav_arr);

                // $("#hos-fav-local").html(fav_arr.length);
                this.hosFav = fav_arr.length;
            }
            $(".fav-hospital-link-box>a").css({'cursor':'pointer','pointer-events':'auto'});
        }
        else{

            this.hos_data[ind].fav_check = '';

            var fav_arr = JSON.parse("[" + localStorage.getItem("hospital_fav") + "]");
            var index = fav_arr.indexOf(index);
            if (index > -1) {
                fav_arr.splice(index, 1);
                localStorage.setItem("hospital_fav", fav_arr);
            }
            // $("#hos-fav-local").html(fav_arr.length);
            this.hosFav = fav_arr.length;

            if(fav_arr.length == 0){
                $(".fav-hospital-link-box>a").css({'cursor':'not-allowed','pointer-events':'none'})
            }
            else{
                $(".fav-hospital-link-box>a").css({'cursor':'pointer','pointer-events':'auto'})
            }

        }
    },
    groupBy(array, key){

        const result = {}
        array.forEach(item => {
        if (!result[item[key]]){
        result[item[key]] = []
        }
        result[item[key]].push(item)
        })
        return result
    },
    toggleContent() {

        this.toggleCheck = !this.toggleCheck;
        if (this.toggleCheck == true) {
            $('#close').empty();
            $("#toBeToggled").slideDown();
            $('#close').append('<i class="fas fa-arrow-circle-up"></i> 市区町村エリアを閉じる');

        } else {
            $('#close').empty();
            $("#toBeToggled").slideUp();
            $('#close').append('<i class="fas fa-arrow-circle-down"></i> 市区町村エリアを開く');
        }
    },
    ShowHide1() {

         this.toggleCheck_1 = !this.toggleCheck_1;
      
        if (this.toggleCheck_1 == true) {
            $('#close2').empty();
            // $(".ShowHide1").toggle("medium");
             $(".ShowHide1").slideDown();
            $('#close2').append('<i class="fas fa-arrow-circle-up"></i> 閉じる');

        } else {
            $('#close2').empty();
            // $(".ShowHide1").toggle("medium");
            $(".ShowHide1").slideUp();
            $('#close2').append('<i class="fas fa-arrow-circle-down"></i> もっと見る');
        }

    },
    ChangeTownship(){
        this.count = false;
      
  
        this.townshipID = [];
        if(localStorage.getItem("hospital_fav") == null){
            this.locast = 0;
        }
        else{
            this.locast = localStorage.getItem("hospital_fav");
        }
        this.axios.get('api/getmap',{
            params:{
            id: this.id,
            township_id:-1,
            moving_in:-1,
            per_month:-1,
            local:this.locast,
            feature:'hospital',
            SpecialFeatureID:[0],
            MedicalAcceptanceID:[0],
            FacTypeID:[0],
            MoveID:[0],
        },
        })
        .then((response) => {
            this.showOne = false;
            $('.hospitalselect').removeClass('hospitalselect');
            this.cities = response.data.city
            this.getCity = response.data.getCity
            this.getTownships = response.data.getTownships
            this.special_features = response.data.special_features
            this.subjects = response.data.subjects;
        })
            // this.search();
    },

    parentGetStateClick(e,parentVue) {        
        var _this = parentVue;
        _this.clicksearch = true;
        _this.stateclick = true;
        _this.count = false;
        _this.ci = false;
     
        localStorage.setItem('features', 'hospital');
        //clear all checkbox
        _this.townshipID = [];
        _this.specialfeatureID = [];
        _this.subjectID = [];

        if(e.target.id != 'selectCity')
        {
            if(e.target.id == '')
            {
                var id = $('#selectCity').val();
                _this.id = id;
            }else{
                var id = e.target.id;
                _this.id = id;
            }
        }

        if(localStorage.getItem("hospital_fav") == null){

            _this.locast = 0;
        }
        else{
            _this.locast = localStorage.getItem("hospital_fav");
        }
        _this.searchword = '';
        _this.$loading(true);
        _this.axios.get('api/getmap',{
            params:{
            id: _this.id,
            township_id:-1,
            moving_in:-1,
            per_month:-1,
            local:_this.locast,
            feature:'hospital',
            SpecialFeatureID:[0],
            MedicalAcceptanceID:[0],
            FacTypeID:[0],
            MoveID:[0],
        },
        })
        .then((response) => {
             this.showOne = false;
            _this.$loading(false);
            $('#hos_search').css("display","block");
            $('.hospitalselect').removeClass('hospitalselect');
            _this.cities = response.data.city
            _this.getCity = response.data.getCity
            _this.getTownships = response.data.getTownships
            _this.special_features = response.data.special_features
            _this.subjects = response.data.subjects
            _this.company = response.data.company
        //   _this.sub_child = response.data.sub_child
            _this.id = id;
            _this.array_len = ((_this.subjects.length)%3)==0?((_this.subjects.length)/3):Math.floor(((_this.subjects.length)/3)+1);
        })

        document.getElementById('search-free-word').value = '';
        document.getElementById('search-free-word-mob').value = '';
        _this.search();
     


    },
    getCheck(e) {
        if (e.target.checked) {
            this.township_id.push(e.target.value);
        }
    },
    features(e) {
        if (e.target.checked) {
        }
    },
    getStateHover(e) {
        if (e.target.tagName === 'path') {
            //console.log(e)
        }
    },
    first() {
       this.currentPage = 0;
       const page = Math.ceil(this.hos_data.length / this.size);
       const currentPage = this.currentPage + 1; 
       if(currentPage == 1){
        let el1 = document.querySelector('.el1');
        let el2 = document.querySelector('.el2');
        el1.classList.add('disabled');
        el2.classList.remove('disabled');
      }

    },
    last() {
      this.currentPage = this.pages - 1;
      const page = Math.ceil(this.hos_data.length / this.size);
      const currentPage = this.currentPage + 1; 
       if(currentPage == page){
        let el1 = document.querySelector('.el1');
        let el2 = document.querySelector('.el2');
        el1.classList.remove('disabled');
        el2.classList.add('disabled');
      }
    },
    prev() {
      if(0<this.currentPage) {
        this.currentPage--;
      }
       const page = Math.ceil(this.hos_data.length / this.size);
       const currentPage = this.currentPage + 1; 
       if(currentPage > 1 && currentPage < page){
        let el1 = document.querySelector('.el1');
        let el2 = document.querySelector('.el2');
        el1.classList.remove('disabled');
        el2.classList.remove('disabled');
      }
      else if(currentPage == page){
        let el1 = document.querySelector('.el1');
        let el2 = document.querySelector('.el2');
        el1.classList.remove('disabled');
        el2.classList.add('disabled');
      }
      else if(currentPage == 1){
        let el1 = document.querySelector('.el1');
        let el2 = document.querySelector('.el2');
        el1.classList.add('disabled');
        el2.classList.remove('disabled');
      }

    },
    next() {
      if(this.currentPage < this.pages - 1) {
        this.currentPage++;
      }
      const page = Math.ceil(this.hos_data.length / this.size);
       const currentPage = this.currentPage + 1; 
       if(currentPage > 1 && currentPage < page){
        let el1 = document.querySelector('.el1');
        let el2 = document.querySelector('.el2');
        el1.classList.remove('disabled');
        el2.classList.remove('disabled');
      }
       else if(currentPage == page){
        let el1 = document.querySelector('.el1');
        let el2 = document.querySelector('.el2');
        el1.classList.remove('disabled');
        el2.classList.add('disabled');
      }
       else if(currentPage == 1){
        let el1 = document.querySelector('.el1');
        let el2 = document.querySelector('.el2');
        el1.classList.add('disabled');
        el2.classList.remove('disabled');
      }
    },
    imgUrlAlt(event) {
        event.target.src = "/images/noimage.jpg"
    },
    pageSelect(index) {
        this.currentPage = index - 1;
        const page = Math.ceil(this.hos_data.length / this.size);
        const currentPage = this.currentPage + 1; 
        if(currentPage > 1 && currentPage < page){
          let el1 = document.querySelector('.el1');
          let el2 = document.querySelector('.el2');
          el1.classList.remove('disabled');
          el2.classList.remove('disabled');
        }
        else if(currentPage == page){
          let el1 = document.querySelector('.el1');
          let el2 = document.querySelector('.el2');
          el1.classList.remove('disabled');
          el2.classList.add('disabled');
        }
        else if(currentPage == 1){
          let el1 = document.querySelector('.el1');
          let el2 = document.querySelector('.el2');
          el1.classList.add('disabled');
          el2.classList.remove('disabled');
        }
    }
    },
    computed: {
    pages() {
      return Math.ceil(this.hos_data.length / this.size);
    },
    displayPageRange() {
      const half = Math.ceil(this.pageRange/2);
      const isEven = this.pageRange / 2 == 0;
      const offset = isEven ? 1 : 2;
      let start, end;
      if(this.pages < this.pageRange) {
        start = 1;
        end = this.pages;
      }else if (this.currentPage < half) {
        start = 1;
        end = start + this.pageRange - 1;
      }else if (this.pages - half < this.currentPage) {
        end = this.pages;
        start = end - this.pageRange + 1;
      }else {
        start = this.currentPage - half + offset;
        end = this.currentPage + half;
      }
      let indexes = [];
      for (let i = start; i <= end; i++) {
        indexes.push(i);
      }
      return indexes;
    },
    displayItems() {
      const head = this.currentPage * this.size;
      return this.hos_data.slice(head, head + this.size);
    },
    isSelected(page) {
      return page - 1 == this.currentPage;
    }
	},
  };
</script>
<style type="text/css">
@media only screen and (max-width: 560px){
  #hos_search {
      display: block;
  }
  #map-responsive {
    display: none;
  }

}
</style>

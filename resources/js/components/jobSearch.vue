<template>
<layout>
<div id="job-search-ui">
  
 
   <div class="col-md-12" style="border-bottom: 1px dashed #828282;padding-bottom: 10px; margin-bottom: 20px;">
     <h5 class="font-weight-bold"><i class="fas fa-map" style="color:#828282;"></i>&nbsp;地図検索  

        <span v-if="count == false  && searchword != '' && searchword == 'all' && job_data.length && !stateclick "> 「<span class="result-span">全国</span>の求人 <span class="result-span"> {{job_data.length}} </span>件」 </span>
        <span v-if="count == false && searchword != '' && searchword != 'all' && job_data.length && !stateclick "> 「<span class="result-span">{{searchword}}</span>の求人 <span class="result-span"> {{job_data.length}} </span>件」 </span>
        <span v-if="count == false && id != '-1' && job_data.length  && stateclick"> 「<span class="result-span">{{job_data[0].city_name}}</span>の求人 <span class="result-span"> {{job_data.length}} </span>件」</span>
        <span v-if="count == true && job_data.length ">「<span class="result-span">{{job_data[0].city_name}}</span>の求人 <span class="result-span"> {{job_data.length}} </span>件」</span>
        <!-- <span v-if="job_data.length && searchword == '' && job_data[0].city_name != ''"> 「<span class="result-span">{{job_data[0].city_name}}</span>の求人 <span class="result-span">{{job_data.length}} </span>件」</span>
        <span v-if="job_data.length && searchword != '' && searchword == 'all' && id == '-1'"> 「<span class="result-span">求人</span>の求人  <span class="result-span">{{job_data.length}} </span>件」</span>
        <span v-if="job_data.length && searchword != '' && searchword != 'all' && id == '-1'"> 「<span class="result-span">{{searchword}}</span>の求人  <span class="result-span">{{job_data.length}} </span>件」</span>
        <span v-if="job_data.length && searchword != '' && searchword == 'all' && id != '-1'"> 「<span class="result-span">求人 , {{job_data[0].city_name}}</span>の求人  <span class="result-span">{{job_data.length}} </span>件」</span>
        <span v-if="job_data.length && searchword != '' && searchword != 'all' && id != '-1'"> 「<span class="result-span">{{searchword}} , {{job_data[0].city_name}}</span>の求人  <span class="result-span">{{job_data.length}} </span>件」</span> -->
    </h5>
  </div>
  <div class="search-map card-body" @mouseover="getStateHover">
    <div class="row" id="hos">
      <div class="col-md-12">
        <div>
          <!-- <div class="info-box"></div> --> 
          <!--start map-->
          <div class="row map-wrap" style="background-color:#ececec;">

          <!-- free word left wrapper--->
            <div class="col-lg-5 col-md-12 col-sm-12 float-left map-leftwrapper">
              <!-- <h2 class="map-header" style="bottom: 184px;">老人ホームや病院<br/>で働きたいあなた<br/>の希望叶えます。</h2> -->
              <h2 class="map-header job-map-header" style="bottom: 155px;">あなたのやさしい<br/>手を求めてる老人<br/>ホーム・病院が見<br/>つかります。</h2>


              <!--search input-->
                <div class="wrap">
                  <div class="search">
                      <input type="text" class="searchTerm" style="border: 3px solid #828282;" id="search-free-word" placeholder="地名、求人タイトルなどを入力">
                      <button type="submit" class="searchButton" style="border: 1px solid #828282;background: #828282;" @click="searchfreeword">
                        <i class="fas fa-search"></i> 検索
                    </button>
                  </div>
                </div>
              <!--end search input-->
            </div>
          <!--end free word left wrapper-->

          <!--map right wrapper-->
          <div class="col-lg-7 col-sm-12 col-md-12 float-right align-center">
            <maptag></maptag>
          </div>
          <!--end map right wrapper-->
        </div>

        <section id="map-responsive">
            <div>

            </div>
            <div class="freeword-responsive">
                <h3 class="map-resicon">
                  <div class="map-text-wrapper">
                    <!-- <div>
                     <img src="/images/map-responsive1.png" alt="" class="img-responsive"> 
                      <i class="fa icon map-fa-icon map-fa-icon-job"></i>
                    </div> -->
                    <div>
                      <p class="text-left job-map-header"> &nbsp;あなたのやさしい 手を求めてる老人<br class="pc-768"/>ホーム・病院が見つかります。</p>
                    </div>
                  </div>
                </h3>


             <!--search input-->
                <div class="search job-search-box">
                    <input type="text" class="searchTerm" id="search-free-word-mob" placeholder="地名、求人タイトルなどを入力">
                    <button type="submit" class="searchButton" @click="searchfreeword">
                      <i class="fas fa-search"></i> 検索
                    </button>
                </div>
              <!--end search input-->
            </div>

            <bulcomponent v-if="!clicksearch && (!ci || (ci && job_data.length < 1))"></bulcomponent>
        </section>
        <div id="scroll-responsive">
          <div id="job_search" class="row jobselect">
              
            <div class="col-12">
             <h5 class="profile_header m-t-10" style="border-left: 5px solid #828282;">現在の検索条件</h5>
            <table class="table table-bordered col-12" style="border:none;">
              <tbody>
                <tr>
                  <th class="pc-414-table sp-768-block">地域</th>
                  <td class="sp-768-block">
                    <div class="row mt-2 mb-2">
                      <div class="col-lg-9 col-md-8 col-sm-12 m-b-8">
                      <select id="selectCity" class="form-control custom-select" v-model="id" @change="changeTownship">
                        <option value="-1" >▼市区町村</option>
                        <option v-for="city in cities" :value="city.id" :key="city.id" >{{city.city_name}}</option>
                    </select>
                    </div>
                    <div class="col-lg-3 col-md-4 col-sm-12 pc-414">
                      <button @click="toggleContent4" class="btn seemore-btn all-btn" v-if="getTownships.length > 0">
                      <i class="fa" aria-hidden="true"></i>
                          <!-- <em>{{city.city_name}}</em> -->
                          <span id="close6"><i class="fas fa-arrow-circle-up"></i> 市区町村エリアを閉じる </span>
                    </button>
                    </div>
                    </div>
                    <div class="toBeToggled4" id="toBeToggled4">
                      <div class="dropdown search_rsp">
                          <button type="button" class="btn btn-default btn-sm dropdown-toggle sp-414" data-toggle="dropdown" style="width:100%;text-align:left;">
                          市から探す
                          </button>
                          <ul class="dropdown-menu dropdown-menu-form" aria-labelledby="dropdownMenuButton" v-if="w_width <= 420" @click.stop="stopTheEvent">
                            <li>
                            <a data-value="option">
                              <div class="row">
                              <div class="col-lg-2 col-md-4 col-sm-4" v-for="township in getTownships" :key="township.id">
                                  <label class="checkbox form-check-label control control--checkbox">
                                      <input class="form-check-input" type="checkbox" :id="township.id" :value="township.id" v-model="townshipID" @change="getCheck($event)">{{township.township_name}}
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
                                  <label class="checkbox form-check-label control control--checkbox">
                                      <input class="form-check-input" type="checkbox" :id="township.id" :value="township.id" v-model="townshipID" @change="getCheck($event)">{{township.township_name}}
                                        <div class="control__indicator"></div>
                                  </label>
                              </div>
                              </div>
                            </a>
                      </div>
                    </div>
                  </td>
                </tr>
                 <!--test-->
                <!-- <tr class="toBeToggled1 ShowHide">
                    <th class="pc-414-table sp-768-block">職種</th>
                    <td class="sp-768-block sp-414-table">
                        <div v-for="(v,i) in array_len" :key="i">
                            <div class="hospital-subject" v-for="(occupation,index) in occupations.slice((i*3),((i*3)+3))" :key="index">
                                <div class="row col-12">
                                    <strong class="table-innertitle row col-12">{{occupation.name}}</strong>
                                    <div class="col-6" v-for="ch in occupation.child" :key="ch.id+1">
                                        <label class="form-check-label control control--checkbox" style="padding-left:5px;">
                                        <input  class="form-check-input" type="checkbox" :id="ch.id" v-model="occupationID" :value="ch.id">
                                            {{ch.name}}
                                        <div class="control__indicator"></div>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr> -->

                <tr >
                    <th class="pc-414-table sp-768-block">職種</th>
                    <td class="sp-768-block sp-414-table">
                        <div class="form-check form-check-inline row align-items-start innerwrapper" v-if="w_width >= 420" >
                          
                            <div v-for="(v,i) in array_len" :key="i">
                                <div class="hospital-subject" v-for="(occupation,index) in occupations.slice((i*3),((i*3)+3))" :key="index" v-bind:class="{ lastblock: i==array_len-1 }">       <!--v-bind:class="{ lastblock: i==array_len-1 }"-->
                                        <strong class="table-innertitle row col-12 m-b-10">{{occupation.name}}</strong>
                                        <div class="row col-12">
                                            <div class="col-lg-6 col-md-12 pad-free" v-for="ch in occupation.child" :key="ch.id+1">
                                            <label class="form-check-label control control--checkbox" style="padding-left:5px;">
                                            <input  class="form-check-input" type="checkbox" :id="ch.id" v-model="occupationID" :value="ch.id">
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
                        <h5 class="font-weight-bold sp-414">職種</h5>
                        <div class="dropdown m-b-10" v-for="(v,i) in occupations" :key="i" >
                        <button type="button" class="btn btn-default btn-sm dropdown-toggle sp-414" data-toggle="dropdown" style="width:100%;text-align:left;">
                        {{v.name}}
                            <ul class="dropdown-menu dropdown-menu-form" aria-labelledby="dropdownMMenuButton"  @click.stop="stopTheEvent">
                            <li v-for="ch in v.child" :key="ch.id+1">
                            <a data-value="option" >
                                <div class="row">
                                <div class="col-lg-2 col-md-4 col-sm-4" >
                                    <label class="form-check-label control control--checkbox">
                                    <input  class="form-check-input" type="checkbox" :id="ch.id" v-model="occupationID" :value="ch.id">
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
                    </td>
                </tr>

                <tr >
                  <th style="padding:10px;" class="pc-414-table sp-768-block">雇用形態</th>
                  <td class="sp-768-block">
                    <!--雇用形態から探す-->
                    <div class="dropdown search_rsp">
                        <button type="button" class="btn btn-default btn-sm dropdown-toggle sp-414" data-toggle="dropdown" style="width:100%;text-align:left;">
                        雇用形態から探す
                        </button>
                         <ul class="dropdown-menu dropdown-menu-form" aria-labelledby="dropdownMenuButton" v-if="w_width <= 420"  @click.stop="stopTheEvent">
                            <li>
                        <a>
                          <div class="row col-12">
                              <div class="form-check form-check-inline col-sm-2">
                              <label class="form-check-label control control--checkbox" style="padding-left:5px;">
                              <input class="form-check-input" value="正職員" v-model="empstatus" type="checkbox">
                              正社員(正職員)
                              <div class="control__indicator"></div>
                              </label>
                            </div>
                            <div class="form-check form-check-inline col-sm-2">
                              <label class="form-check-label control control--checkbox" style="padding-left:5px;">
                              <input class="form-check-input" value="契約社員" v-model="empstatus" type="checkbox">
                              契約社員(職員)
                              <div class="control__indicator"></div>
                              </label>
                            </div>
                            <div class="form-check form-check-inline col-sm-2">
                              <label class="form-check-label control control--checkbox" style="padding-left:5px;">
                              <input class="form-check-input" value="非常勤" v-model="empstatus" type="checkbox">
                              非常勤/パート
                              <div class="control__indicator"></div>
                              </label>
                            </div>
                            <div class="form-check form-check-inline col-sm-2">
                              <label class="form-check-label control control--checkbox" style="padding-left:5px;">
                              <input class="form-check-input" value="その他" v-model="empstatus" type="checkbox">
                              その他
                              <div class="control__indicator"></div>
                              </label>
                            </div>
                          </div>
                        </a>
                            </li>
                         </ul>

                        <a v-if="w_width >= 420">
                          <div class="row">
                              <div class="col-lg-2 col-sm-4">
                              <label class="form-check-label control control--checkbox">
                              <input class="form-check-input" value="正職員" v-model="empstatus" type="checkbox">
                              正社員(正職員)
                              <div class="control__indicator"></div>
                              </label>
                            </div>
                            <div class="col-lg-2 col-sm-4">
                              <label class="form-check-label control control--checkbox">
                              <input class="form-check-input" value="契約社員" v-model="empstatus" type="checkbox">
                              契約社員(職員)
                              <div class="control__indicator"></div>
                              </label>
                            </div>
                            <div class="col-lg-2 col-sm-4">
                              <label class="form-check-label control control--checkbox">
                              <input class="form-check-input" value="非常勤" v-model="empstatus" type="checkbox">
                              非常勤/パート
                              <div class="control__indicator"></div>
                              </label>
                            </div>
                            <div class="col-lg-2 col-sm-4">
                              <label class="form-check-label control control--checkbox">
                              <input class="form-check-input" value="その他" v-model="empstatus" type="checkbox">
                              その他
                              <div class="control__indicator"></div>
                              </label>
                            </div>
                          </div>
                        </a>
                    </div>
                    <!--end 雇用形態から探す-->
                  </td>
                </tr>

                <tr class="text-center" >
                  <td colspan="2" style="border:none;">
                     <button class="main-bg-color create-btn all-btn col-lg-2 col-md-4 col-sm-2" @click="search"><i class="fas fa-search"></i>&nbsp; 検索 </button>
                  </td>
                </tr>
              </tbody>
            </table>
            </div>

             <span  class="col-12" v-if="norecord_msg">
                <div class="container-fuid m-t-20">
                    <p class="nosearch-icon">
                        <svg x="0px" y="0px" width="30" height="30" viewBox="0 0 172 172" style=" fill:red;"><g transform=""><g fill="none" fill-rule="nonzero" stroke="none" stroke-width="1" stroke-linecap="butt" stroke-linejoin="miter" stroke-miterlimit="10" stroke-dasharray="" stroke-dashoffset="0" font-family="none" font-weight="none" font-size="none" text-anchor="none" style="mix-blend-mode: normal"><path d="M0,172v-172h172v172z" fill="none"></path><path d="M86,172c-47.49649,0 -86,-38.50351 -86,-86v0c0,-47.49649 38.50351,-86 86,-86v0c47.49649,0 86,38.50351 86,86v0c0,47.49649 -38.50351,86 -86,86z" fill="none"></path><path d="M86,168.56c-45.59663,0 -82.56,-36.96337 -82.56,-82.56v0c0,-45.59663 36.96337,-82.56 82.56,-82.56v0c45.59663,0 82.56,36.96337 82.56,82.56v0c0,45.59663 -36.96337,82.56 -82.56,82.56z" fill="none"></path><path d="M0,172v-172h172v172z" fill="none"></path><path d="M3.44,168.56v-165.12h165.12v165.12z" fill="none"></path><path d="M86,172c-47.49649,0 -86,-38.50351 -86,-86v0c0,-47.49649 38.50351,-86 86,-86v0c47.49649,0 86,38.50351 86,86v0c0,47.49649 -38.50351,86 -86,86z" fill="none"></path><path d="M86,168.56c-45.59663,0 -82.56,-36.96337 -82.56,-82.56v0c0,-45.59663 36.96337,-82.56 82.56,-82.56v0c45.59663,0 82.56,36.96337 82.56,82.56v0c0,45.59663 -36.96337,82.56 -82.56,82.56z" fill="none"></path><path d="M0,172v-172h172v172z" fill="none"></path><path d="M3.44,168.56v-165.12h165.12v165.12z" fill="none"></path><path d="M86,172c-47.49649,0 -86,-38.50351 -86,-86v0c0,-47.49649 38.50351,-86 86,-86v0c47.49649,0 86,38.50351 86,86v0c0,47.49649 -38.50351,86 -86,86z" fill="none"></path><path d="M86,168.56c-45.59663,0 -82.56,-36.96337 -82.56,-82.56v0c0,-45.59663 36.96337,-82.56 82.56,-82.56v0c45.59663,0 82.56,36.96337 82.56,82.56v0c0,45.59663 -36.96337,82.56 -82.56,82.56z" fill="none"></path><g fill="#666666"><path d="M74.53333,17.2c-31.59643,0 -57.33333,25.73692 -57.33333,57.33333c0,31.59641 25.7369,57.33333 57.33333,57.33333c13.73998,0 26.35834,-4.87915 36.24766,-12.97839l34.23203,34.23203c1.43802,1.49778 3.5734,2.10113 5.5826,1.57735c2.0092,-0.52378 3.57826,-2.09284 4.10204,-4.10204c0.52378,-2.0092 -0.07957,-4.14458 -1.57735,-5.5826l-34.23203,-34.23203c8.09923,-9.88932 12.97839,-22.50768 12.97839,-36.24766c0,-31.59641 -25.7369,-57.33333 -57.33333,-57.33333zM74.53333,28.66667c25.39939,0 45.86667,20.46729 45.86667,45.86667c0,25.39937 -20.46728,45.86667 -45.86667,45.86667c-25.39939,0 -45.86667,-20.46729 -45.86667,-45.86667c0,-25.39937 20.46728,-45.86667 45.86667,-45.86667zM91.67734,51.52161c-1.51229,0.03575 -2.94918,0.66766 -3.99765,1.75807l-13.14636,13.14636l-13.14636,-13.14636c-1.07942,-1.10959 -2.56162,-1.73559 -4.10963,-1.73568c-2.33303,0.00061 -4.43306,1.41473 -5.31096,3.57628c-0.8779,2.16155 -0.3586,4.6395 1.31331,6.26669l13.14636,13.14636l-13.14636,13.14636c-1.49777,1.43802 -2.10111,3.5734 -1.57733,5.58259c0.52378,2.0092 2.09283,3.57825 4.10203,4.10203c2.0092,0.52378 4.14457,-0.07956 5.58259,-1.57733l13.14636,-13.14636l13.14636,13.14636c1.43802,1.49778 3.5734,2.10113 5.5826,1.57735c2.0092,-0.52378 3.57826,-2.09284 4.10204,-4.10204c0.52378,-2.0092 -0.07957,-4.14458 -1.57735,-5.5826l-13.14636,-13.14636l13.14636,-13.14636c1.70419,-1.63875 2.22781,-4.1555 1.31865,-6.33798c-0.90916,-2.18248 -3.06468,-3.58317 -5.42829,-3.52739z"></path></g></g></g></svg>
                    </p>
                     <p class="nosearch-data">お探しの条件に合う求人は見つかりませんでした。</p>
                     <p class="nosearch">条件の変更を行い再度ご検索いだだくと見つかる可能性がございます。</p>
                </div>
            </span>
            
           
            
             <div id="scroll" class="col-12">
                <div class="row pad-free m-b-10">
                   <div id="job_detail" class="col-lg-6 col-md-12" style="margin-top:20px;" v-for="(job,index) in displayItems" :key="index+'-'+job.title+'-'+job.jobid">
                     <div class="job-content">
                      <div class="job-header">
                        <p class="search_jobid"><span>求人番号:</span>{{job.jobnum}}</p>
                        <h5 class="job-tit">
                          <router-link :to="{path:'/job_details/'+job.jobid}">{{job.jrecord}}{{job.title}}</router-link>
                          </h5>
                        <div class="clearfix">
                          <span class="job_status">{{job.employment_status}}</span>
                          
                        </div>
                      </div>
                      <div class="job-body d-flex clearfix">
                        <!-- <div class="col-4 job-img">
                          <img src="/upload/news/nursing.JPG"  alt="">
                        </div> -->
                        <div class="col-12 pad-free job-box p0-480">
                          <table  class="table table-bordered  table-sm">
                            <tr>
                              <td><span class="job_ico"><i class="fa fa-map-marker-alt"></i></span>最寄り駅</td>
                              <td>{{job.nearest_station}}</td>
                            </tr>
                            <tr>
                              <td><span class="job_ico">&#xa5;</span>給料</td>
                              <td> {{job.salary}} <span v-if="job.salary_remark"> ( {{ job.salary_remark }} ) </span> </td>
                            </tr>
                            <!-- {{job.salary_type}} : {{(Number(job.salary)).toLocaleString()}} 円 -->
                            <tr>
                              <td><span class="job_ico">時</span>就業時間/休日休暇</td>
                              <td> {{job.working_hours}} <span v-if="job.holidays!='' && job.holidays!=null">/</span> {{job.holidays}}  </td>
                            </tr>
                            <tr>
                              <td><span class="job_ico"><i class="fa fa-briefcase"></i></span>特別な条件</td>
                              <td> {{job.allowances}} </td>
                            </tr>
                          </table>
                        </div>
                      </div>
                      <div class="mt-4 detail-btn">
                        <span class="btn all-btn" @click="gotoJobdetail(job.jobid)">詳細を見る</span>
                        <!-- <router-link :to="{path:'/job_details/'+job.jobid}" class="btn all-btn">詳細を見る</router-link> -->
                        </div>
                    </div>
                  </div>
                </div>
              </div>
            <!-- <div class="offset-md-4 col-md-8 mt-3" v-if="show_paginate"> -->
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
            </div>
        </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- linked news added by maythirihtet-->
<div v-if="linkednews.length > 0" class="container_news job_container_news">
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
import layout from '../components/home.vue'
import maptag from './map.vue' 
import bulcomponent from './bulcomponent.vue' 

export default {
    components: {
      layout,
      maptag,
      bulcomponent
    },
    //props: ['initOpen'],
    data(){
      return{
        /**added by maythirihtet */
        c_year:new Date().getFullYear(),
        vactive:true,
        linkednews: [],
        yeararr: [],
        /**end of added by maythirihtet */
        id:-1, townshipID:[], township_id:[], cities:'', getCity:[], township_id:-1, moving_in:-1, per_month:-1, getTownships:[], special_features:[], fac_types:[], fac_id:[], medical_acceptance:[], subjects:[], occupationID:[], occupations:[], occupation:[], toggleCheck: true, toggleCheck_1: false, empstatus:[], job_data:[], currentPage: 0, size: 20, pageRange: 5, items: [], show_paginate: false, selected: undefined, locast:'', company:[], open:false, norecord_msg: false, window:{ width: 0, height: 0 }, w_width: $(window).width(), testclass:'', array_len: 0, searchword:'', stateclick:false, count:false, clicksearch: false, ci: false, isActive: true, isActivePreNext:true,
      }
    },
    created() {

         this.axios.get('api/getmap',{
            params:{ id: this.id, township_id:-1, moving_in:-1, per_month:-1, local:0, feature:'job', SpecialFeatureID:[0], MedicalAcceptanceID:[0], FacTypeID:[0], MoveID:[0], },
          })
          .then((response)=>{
            this.cities = response.data.city
            this.getCity = response.data.getCity
            this.getTownships = response.data.getTownships
            this.occupation = response.data.occupation
            this.occupations = response.data.occupations
            this.id = id
         })

        /**added by maythirihtet*/
            this.axios.get('/api/getLinkedNews/'+3).then((response) => { 
                this.linkednews = response.data.linkednews,
                this.yeararr = response.data.yeararr;
            });
        /**end of added by maythirihtet */

        this.axios.get('/api/user').then(response => {
                this.pro_id = response.data.lat_lng[0].id;
                this.loginuser = 'true';
                }).catch((error) => {
                    this.loginuser = 'false';
                });
        this.open = !this.initOpen

        window.addEventListener('resize', this.handleResize);
        this.handleResize();
    },
    watch: {
      
      job_data(){

          if(this.job_data.length >= 0){ 

           

             var elmnt = document.querySelector("#scroll");
             elmnt.scrollIntoView({block: 'start', inline: 'start',offsetTop:200}); 
          
          
            // const scrollToEl = document.querySelector("#scroll");
            // scrollToEl.scrollIntoView({behavior: "smooth",block:"start"});
            //   var scrollToEl = document.querySelector("#scroll");
            //   const topOfElement = window.pageYOffset + scrollToEl.getBoundingClientRect().top - 10000;
            //  topOfElement.scrollIntoView(true); 
            //  var elmnt = document.querySelector("#scroll").offsetHeight;
            // const topOfElement = window.pageYOffset + elmnt.getBoundingClientRect().top - headerHeight - buffer;       
            //  elmnt.scrollIntoView({block:"start",offsetHeight:2000}); 
          }
      }    
    },
    mounted() {
            $('#navtab').removeClass('news-tabColor hospital-tabColor nursing-tabColor job-tabColor');
            $('#navtab').addClass('job-tabColor');
            $('.tab-content').removeClass('news-borderColor job-borderColor nursing-borderColor hospital-borderColor');
            $('#upper-tab').addClass('job-borderColor');
        },
  methods:{
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
    },
    search()
    {       
        this.count = true;
        this.$loading(true);
      
        if(this.townshipID == null || this.townshipID == '')
        {
          this.townshipID[0] = 0;
        }
        if(this.occupationID == null || this.occupationID == '')
        {
          this.occupationID[0] = 0;
        }
        if(this.empstatus == null || this.empstatus == '')
        {
          this.empstatus[0] = 0;
        }

        if ($('#search-free-word').val() != '')
        {

          var search_word = $('#search-free-word').val();
        }
        else if ($('#search-free-word-mob').val() != '')
        {

          var search_word = $('#search-free-word-mob').val();
        }
        else{
          var search_word = 'null';
        }

        this.axios.get('api/getjobsearch/'+search_word,{

          params:{
              id: this.id,
              townshipID:this.townshipID,
              occupationID:this.occupationID,
              empstatus:this.empstatus
          },
        }).then((response)=>{
          this.$loading(false);
            this.job_data = response.data.job;
            this.occupations = response.data.occupations;
            this.array_len = ((this.occupations.length)%3)==0?((this.occupations.length)/3):Math.floor(((this.occupations.length)/3)+1);
           
         
          if(this.job_data.length > 0)
          {
               $('#job_search').css("display","block");
          }
          this.cities = response.data.city

          if(this.job_data.length > this.size) {
              this.show_paginate = true;
          }else{
              this.show_paginate = false;
          }
          if(this.job_data.length != 0){
              this.norecord_msg = false;
          }else{
              this.norecord_msg = true;
          }
        })   
    },
    searchfreeword(){     
        this.id = -1;
        this.count = false;
        this.stateclick = false;
        this.townshipID = [];
        this.occupationID = [];
        this.empstatus = [];
        this.ci = true;

        if(this.townshipID == null || this.townshipID == '')
        {
            this.townshipID[0] = 0;
        }
        if(this.occupationID == null || this.occupationID == '')
        {
            this.occupationID[0] = 0;
        }
        if(this.empstatus == null || this.empstatus == '')
        {
            this.empstatus[0] = 0;
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
            this.searchword = 'all';
        }

        this.axios.get('api/getjobsearch/'+ search_word,{
            params:{ id: this.id, townshipID:this.townshipID, occupationID:this.occupationID, empstatus:this.empstatus },
        })
        .then((response)=>{
            $('.jobselect').removeClass('jobselect');
            $('#job_search').css("display","block");
            this.job_data = response.data.job;
            this.cities = response.data.city;
            this.occupations = response.data.occupations;
            this.getTownships = [];
            this.array_len = ((this.occupations.length)%3)==0?((this.occupations.length)/3):Math.floor(((this.occupations.length)/3)+1);

            if(this.job_data.length > this.size) {
                this.show_paginate = true;
            }else{
                this.show_paginate = false;
            }
            if(this.job_data.length != 0) {
                this.norecord_msg = false;
            }else{
                this.norecord_msg = true;
            }
        });   
    },

    gotoJobdetail(jid) {
        this.$router.push({ path:'/job_details/'+jid});
    },

    toggleContent4() {
        this.toggleCheck = !this.toggleCheck;
            if (this.toggleCheck == true) {
                $('#close6').empty();
                $("#toBeToggled4").slideToggle();
                $('#close6').append('<i class="fas fa-arrow-circle-up"></i> 市区町村エリアを閉じる');

            } else {
                $('#close6').empty();
                $("#toBeToggled4").slideToggle(); 
                $('#close6').append('<i class="fas fa-arrow-circle-down"></i> 市区町村エリアを開く');
            }
        },
       ShowHide4() {
        
            this.toggleCheck_1 = !this.toggleCheck_1;
            // $(".ShowHide").toggle();
            if (this.toggleCheck_1 == true) {
                $('#close4').empty();  
                $(".ShowHide").slideDown();       
                $('#close4').append('<i class="fas fa-arrow-circle-up"></i> 閉じる');

            } else {
                $('#close4').empty(); 
                 $(".ShowHide").slideUp();                  
                $('#close4').append('<i class="fas fa-arrow-circle-down"></i> もっと見る');
            }
        },
        changeTownship()
        {
           this.count = false;
           this.townshipID = [];
            if(localStorage.getItem("nursing_fav") == null){

                this.locast = 0;
            }
            else{
                this.locast = localStorage.getItem("nursing_fav");
            }

            this.axios.get('api/getmap',{
            params:{ id: this.id, township_id:-1, moving_in:-1, per_month:-1, local:this.locast, feature:'job', SpecialFeatureID:[0], MedicalAcceptanceID:[0], FacTypeID:[0], MoveID:[0], },
          })
          .then((response)=>{

          $('.jobselect').removeClass('jobselect');
            this.cities = response.data.city
            this.getCity = response.data.getCity
            this.getTownships = response.data.getTownships
            this.occupation = response.data.occupation
            this.occupations = response.data.occupations
            this.id = id
         })

        },       

      parentGetStateClick(e,parentVue) {
        var _this = parentVue;
        _this.clicksearch = true;
        _this.ci = false;
            _this.stateclick = true;
            _this.count = false;
            _this.townshipID = [];
            _this.occupationID = [];
            _this.empstatus = [];
          if(e.target.id == ''){
            var id = $('#selectCity').val();
          }else{
            var id = e.target.id;
          }
          _this.id = id;

           if(localStorage.getItem("nursing_fav") == null){

                _this.locast = 0;
            }
            else{
                _this.locast = localStorage.getItem("nursing_fav");
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
              feature:'job',
              SpecialFeatureID:[0],
              MedicalAcceptanceID:[0],
              FacTypeID:[0],
              MoveID:[0],
          },
          })
          .then((response)=>{
            _this.$loading(false);
          $('.jobselect').removeClass('jobselect');
          _this.cities = response.data.city
          _this.getCity = response.data.getCity
          _this.getTownships = response.data.getTownships

          _this.occupations = response.data.occupations
          _this.id = id,
           _this.array_len = ((_this.occupations.length)%3)==0?((_this.occupations.length)/3):Math.floor(((_this.occupations.length)/3)+1);
         })

        document.getElementById('search-free-word').value = '';
        document.getElementById('search-free-word-mob').value = '';
        _this.search();
      },

      getCheck(e){
        //  console.log(this.townshipID);      
      },
      features(e){
        if(e.target.checked){

        }
      },
      getStateHover(e){
        if(e.target.tagName ==='path'){
         //console.log(e)
        }
      },
      first() {
        this.currentPage = 0;
        const page = Math.ceil(this.job_data.length / this.size);
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
      const page = Math.ceil(this.job_data.length / this.size);
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
      const page = Math.ceil(this.job_data.length / this.size);
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
      const page = Math.ceil(this.job_data.length / this.size);
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
    pageSelect(index) {
      this.currentPage = index - 1;
      const page = Math.ceil(this.job_data.length / this.size);
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

    },
    computed: {
    pages() {
      return Math.ceil(this.job_data.length / this.size);
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
      return this.job_data.slice(head, head + this.size);
    },
    isSelected(page) {
      return page - 1 == this.currentPage;
    }
	},
};
    function showCheckboxes() {
        if ($('#checkboxes').is(':visible')) {
            $('#checkboxes').hide();
        }
        else {
            $('#checkboxes').show();
        }
    }

$(document).click(function(e) {
  if(e.target.nodeName == 'BODY')
    $('#checkboxes').hide();
});

// for .container_news
$(document).ready(function(){
    $('.button-year').find('.btn-2020').addClass('active');
    $('.year-2019').addClass('hidden');
});

$(document).on('click','.btn-2020',function(){
    $(this).addClass('active');
    $(this).parent().find('.btn-2019').removeClass('active');
    $('.year-2019').addClass('hidden');
    $('.year-2020').removeClass('hidden');
});
$(document).on('click','.btn-2019',function(){
    $(this).addClass('active');
    $(this).parent().find('.btn-2020').removeClass('active');
    $('.year-2020').addClass('hidden');
    $('.year-2019').removeClass('hidden');
});
// end of .container_news

</script>


<style>
#job-search-ui .result-span {
    color: #828282;
}
#job-search-ui .jobselect {
  display: none;
}
#job-search-ui .offset {
  display: none;
}
#job-search-ui .toBeToggled4 {
    display: block;
}
#job-search-ui .toBeToggled1 {
    display: none;
}
#job-search-ui table > tbody > tr th{
  background-color: #eeeeee;
  width:140px;
  padding:25px;
}
#job-search-ui .job-tabColor .nav-link {
  background: #828282 !important;
  color: #fff;
  border-right: 1px solid #fff;
}
#job-search-ui .job-borderColor {
  border: 1px solid #828282 !important;
}
#job-search-ui .offset{
  width: 500px !important;
  margin: 20px auto;
}
@media only screen and (max-width: 767px){
#job-search-ui .jobselect {
    display: block;
}
#map-responsive {
    display: none;
}
}
</style>


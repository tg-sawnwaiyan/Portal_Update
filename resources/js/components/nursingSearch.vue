<template>
<layout>
<div class="tab_pane_02">
    <div class="col-md-12" style="border-bottom: 1px dashed #2980b9;padding-bottom: 10px; margin-bottom: 20px;">
        <h5 class="font-weight-bold"><i class="fas fa-map" style="color:#2980b9;"></i>&nbsp;地図検索 
            <span v-if="nus_data.length && !ci &&  MoveID == 0 &&  SpecialFeatureID ==0  && FacTypeID == 0 && MedicalAcceptanceID == 0 && township_id == -1 && moving_in == -1  && per_month == -1">「<span class="result-span">{{nus_data[0].city_name}}</span>の介護施設 <span class="result-span">{{nus_data.length}}</span> 件」</span>
            <span v-if="nus_data.length && ci && searchword != 'all' && searchword != '' && MoveID ==0  && SpecialFeatureID == 0 && FacTypeID == 0 && MedicalAcceptanceID == 0 && township_id == -1 && moving_in == -1  && per_month == -1" >「<span class="result-span">{{searchword}}</span>の介護施設 <span class="result-span">{{nus_data.length}}</span> 件」</span>
            <span v-if="nus_data.length && searchword == 'all' && MoveID == 0 && SpecialFeatureID == 0 && FacTypeID == 0 && MedicalAcceptanceID == 0 && township_id == -1 && moving_in == -1  && per_month == -1">「<span class="result-span">全国</span>の介護施設 <span class="result-span">{{nus_data.length}}</span> 件」</span>
            <span v-if="nus_data.length && ( MoveID != 0 || SpecialFeatureID != 0 || FacTypeID != 0 || MedicalAcceptanceID != 0 || township_id != -1 || moving_in != -1  || per_month != -1 )">「介護施設 <span class="result-span">{{nus_data.length}}</span> 件」</span>
        </h5>   
    </div>
    <div class="search-map"  @mouseover="getStateHover">
        <div class="row" id="hos">
            <div class="col-md-12" id="scrollMap">
                <div>
                    <div class="row map-wrap"  id="searchMap">
                        <!-- search map and path -->
                        <div class="col-lg-5 col-md-12 col-sm-12 float-left map-leftwrapper">
                           <h2 class="map-header nursing-map-header">あなたらしい暮ら<br/>しができる。そん<br/>な老人ホームが見 <br/>つかります。</h2>
                            <!--search input-->
                            <div class="wrap">
                                <div class="search">
                                    <input type="text"  id="search-free-word" style="border: 3px solid #63b7ff;" class="searchTerm" placeholder="地名、施設名などを入力"> 
                                    <button class="searchButton" style="border: 1px solid #63b7ff;background: #63b7ff;" @click="searchfreeword">
                                        <i class="fas fa-search"></i> 検索
                                    </button>
                                </div>                                        
                            </div>
                        
                            <!--end search input-->
                        </div>
                        <div class="col-lg-7 col-md-12 col-sm-12 float-right align-center" >
                            <maptag></maptag>
                        </div>
                    </div>
                    <section id="map-responsive">
                        <div class="freeword-responsive">
                            <h3 class="map-resicon">
                            <div class="map-text-wrapper">
                              <!--   <div>
                                <i class="fa icon map-fa-icon map-fa-icon-nursing"></i>
                                </div> -->
                                <div>
                                <p class="text-left nursing-map-header"> &nbsp;あなたらしい暮らしができる。そん<br class="pc-768"/>な老人ホームが見つかります。</p>
                                </div>
                            </div>
                            </h3>
                            <!--search input-->
                            <div class="search nursing-search-box">
                                <input type="text" class="searchTerm" id="search-free-word-res" placeholder="地名、施設名などを入力">
                                <button type="submit" class="searchButton" @click="searchfreeword">
                                    <i class="fas fa-search"></i> 検索
                                </button>
                            </div>
                            <!--end search input-->
                        </div>
                        <bulcomponent v-if="!clicksearch && (!ci || (ci && nus_data.length < 1))"></bulcomponent>
                    </section>
                    <!-- search city , township  -->
                    
                    <div id="scroll-responsive">
                        <div class="select" id="filter" style="justify-content:space-between">
                           <h5 class="profile_header" style="border-left: 5px solid #63b7ff;">現在の検索条件</h5>
                           
                            <div class="row">
                            <div class="col-lg-5 col-md-6 m-b-414">
                                <div><p class="nurs-sub-heading">地域で絞り込む</p></div>                                    
                                <div class="card search-border-dash">
                                    <div class="card-body">
                                        <div class="row">
                                        <div class="col-lg-6"> 
                                        <select id="selectCity" class="form-control custom-select" @change="nursingSearchData(1);" style="background-color: #fff;" v-model="id">
                                        <option value="-1" disabled>▼市区町村</option>
                                        <option  :value="city.id" v-for="(city,index) in cities" :key="index" >{{city.city_name}} </option>
                                        </select>
                                        </div>
                                        <div class="col-lg-6">
                                        <select id="selectTownship" class="form-control custom-select nus-town-m-t" style="background-color: #fff;" @change="nursingSearchData(2);" v-model="township_id">
                                        <option value="-1" >▼市区町村</option>
                                        <option  :value="selectTownship.id"  v-for="(selectTownship,index) in getTownships" :key="index">{{selectTownship.township_name}}</option>
                                        </select>
                                        </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-5 col-md-6 m-b-414">
                                <div><p class="nurs-sub-heading">料金で絞り込む</p></div>
                                <div class="card search-border-dash">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-lg-6">
                                    <select name="" id="" class="form-control custom-select" style="background-color: #fff;" @change="nursingSearchData()" v-model="moving_in">
                                        <option data-price-type="" value="-1" >▼入居一時金</option>
                                        <!-- <option data-price-type="" value="0">一時金なし</option> -->
                                        <option data-price-type="" value="500000">50万円以下</option>
                                        <option data-price-type="" value="1000000">100万円以下</option>
                                        <option data-price-type="" value="2000000">200万円以下</option>
                                        <option data-price-type="" value="3000000">300万円以下</option>
                                        <option data-price-type="" value="4000000">400万円以下</option>
                                        <option data-price-type="" value="5000000">500万円以下</option>
                                        <option data-price-type="" value="6000000">600万円以下</option>
                                        <option data-price-type="" value="7000000">700万円以下</option>
                                        <option data-price-type="" value="8000000">800万円以下</option>
                                        <option data-price-type="" value="9000000">900万円以下</option>
                                        <option data-price-type="" value="1000000">1,000万円以下</option>
                                        <option data-price-type="" value="20000000">2,000万円以下</option>
                                        <option data-price-type="" value="30000000">3,000万円以下</option>
                                        <option data-price-type="more" value="30000000">3,000万円以上</option>
                                    </select>
                                        </div>
                                        <div class="col-lg-6">
                                    <select name="" id="" class="form-control custom-select nus-town-m-t" style="background-color: #fff;" @change="nursingSearchData()" v-model="per_month">
                                        <option data-price-type="" value="-1" >▼月額利用料</option>
                                        <option data-price-type="" value="100000">10万円以下</option>
                                        <option data-price-type="" value="120000">12万円以下</option>
                                        <option data-price-type="" value="140000">14万円以下</option>
                                        <option data-price-type="" value="160000">16万円以下</option>
                                        <option data-price-type="" value="180000">18万円以下</option>
                                        <option data-price-type="" value="200000">20万円以下</option>
                                        <option data-price-type="" value="220000">22万円以下</option>
                                        <option data-price-type="" value="240000">24万円以下</option>
                                        <option data-price-type="" value="260000">26万円以下</option>
                                        <option data-price-type="" value="280000">28万円以下</option>
                                        <option data-price-type="" value="300000">30万円以下</option>
                                        <option data-price-type="" value="350000">35万円以下</option>
                                        <option data-price-type="" value="400000">40万円以下</option>
                                        <option data-price-type="" value="450000">45万円以下</option>
                                        <option data-price-type="" value="500000">50万円以下</option>
                                        <option data-price-type="more" value="500000">50万円以上</option>
                                    </select>
                                        </div>
                                    </div>
                                </div>
                                </div>
                            </div>                                    
                            <div class="col-lg-2 col-md-4 m-b-414 pc-768 align-self-center m-t-30">
                                <span class="btn seemore-btn select all-btn" style="width:100%;padding:15px 10px;font-size:0.8em;" id="showSearchMap" @click="showSearchMap"><i class="fas fa-exchange-alt"></i>&nbsp;都道府県を再選択する</span>                                    
                            </div>
                            </div>
                        </div>
                    </div>
                    <!-- google map  -->

                    <section id="holder">
                        <div class="row" >
                            <div class="col-sm-12 col-md-12">
                                
                                <div class="m-t-10 m-b-10">
                                    <div v-if="loading" class=" m-t-10 m-b-10" style="background-color:#000;opacity:0.5;position:absolute;z-index:10;width: 98%;margin-top: 0px !important;">
                                        <div class="lds-ripple m-t-10 m-b-10" style="width:100%;heigth:100%" >
                                            <div>
                                                <div></div><div></div>
                                            </div>
                                        </div>
                                        <div class="col-12 overlay" style="z-index:9"> ffff</div>
                                    </div>
                                    <div id="mymap" ></div>
                                </div>
                                
                            </div>
                        </div>
                    </section>
                    <!-- nursing list -->
                    <div id="nursing-search" >
                       
                        <div class="row" >
                            <div class="card-carousel-wrapper col-12" v-if="nus_data.length > 0">
                                <div class="nav-box" @click="moveCarousel(-1)" :disabled="atHeadOfList">
                                <div class="nav-content mr-2">
                                    <div class="card-carousel--nav__left"></div>
                                </div>
                                </div>
                                <div class="card-carousel">
                                <div class="card-carousel--overflow-container">
                                    <div class="card-carousel-cards" :style="{ transform: 'translateX' + '(' + currentOffset + 'px' + ')'}">
                                    <!-- <div @mouseover="mouseover(items.alphabet)" @mouseleave="mouseleave(items.alphabet)" class="card-carousel--card"  v-for="items in nus_data" :id="items.alphabet"  :key="items.nursing_id"> -->
                                    <div class="card-carousel--card">
                                        <div class="MarkerHover">
                                            <table class="nursingSearch-tbl">
                                                <tbody>
                                                <tr >
                                                    <td class="pt-2 pb-2"  v-for="(items,index) in nus_data" @mouseover="mouseover(items.alphabet)" @mouseleave="mouseleave(items.alphabet)" :id="items.alphabet" :key="items.nursing_id">
                                                        <div class="wd-in">
                                                            <p class="mb-2 clearfix"><span class="num-room">{{items.num_rooms}} </span><span class="float-right">{{items.date_of_establishment}}</span></p>

                                                            <p class="item-fav btn btn-sm" v-if="items.fav_check == '' && !$auth.check()" :class="'view_pro_id'+items.nursing_id" style="" @click="favAddFun('add',items.nursing_id,index);">
                                                                <i class="fas fa-plus-square" style="color:#c40000;"></i> お気に入りに追加 {{items.fav_check}}
                                                            </p>

                                                            <p class="item-fav btn btn-sm" v-if="items.fav_check == 'check' && !$auth.check()" :class="'done_pro_id'+items.nursing_id" style="color:#aaa;" @click="favAddFun('remove',items.nursing_id,index);">
                                                                <i class="fas fa-check-double" style="color:#c40000!important;"></i>&nbsp; 追加済み
                                                            </p>
                                                            <p class="job_id1 search_jobid"><span>施設番号:{{items.profilenumber}}</span></p>

                                                            <p class="item-name"><img :src="'http://chart.apis.google.com/chart?chst=d_map_pin_letter&chld='+items.alphabet+'|fd0e0e|ffffff'" alt="">
                                                                <router-link :to="{ path:'/profile/nursing/'+items.nursing_id}" class="pseudolink" style="font-weight:bold;color:#63b7ff !important">{{items.name}}</router-link>
                                                            </p>
                                                        
                                                            <p>{{items.city_name}} <i class="fas fa-angle-double-right" style="color:#b9b5b5;"></i> {{items.township_name}}</p>
                                                        </div>
                                                        
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td  v-for="items in nus_data" @mouseover="mouseover(items.alphabet)" @mouseleave="mouseleave(items.alphabet)" :id="items.alphabet" :key="items.nursing_id">
                                                        <div class="wd-in">
                                                            <span class="type-name" v-if="items.type_name">{{items.type_name}} </span>
                                                            <span class="type-name" v-else>介護</span>
                                                            

                                                            <div class="row m-t-10 m-b-10">
                                                                <div class="col-5 col-lg-5 col-sm-6" style="padding-top:3px;">
                                                                    <div class="carousel-img">
                                                                    <img :src="'/upload/nursing_profile/'+items.logo" alt="image" class="img-fluid" @error="imgUrlAlt"/>
                                                                    </div>
                                                                </div>
                                                                <div class="col-7 col-lg-7 col-sm-6 m-b-15 p-l-0">
                                                                    <ul class="nursingSearch-list">
                                                                        <!-- <li class="d-flex"><p class="text-truncate"><span>住所</span><span> {{items.township_name}} {{items.address}}</span></p></li> -->
                                                                        <li class="d-flex"><p class="text-truncate"><span>運営事業者名</span></p></li><span> {{items.cus_name}}</span>
                                                                        <li class="d-flex"><span>電話 </span></li><span class="text-truncate">{{items.phone}}</span>
                                                                        <!-- <li class="d-flex"><span>サイト</span><a :href="'http://'+ items.website" target="_blank"  class="text-truncate">{{items.website}}</a></li> -->
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td  v-for="items in nus_data" @mouseover="mouseover(items.alphabet)" @mouseleave="mouseleave(items.alphabet)" :id="items.alphabet" :key="items.nursing_id">
                                                        <div class="wd-in">
                                                            <table class="table table-bordered price-tbl text-center">
                                                                <thead>
                                                                    <tr style="background-color:#ecf8ff">
                                                                        <th class="text-center" style="background-color:#ecf8ff">入居時費用</th>
                                                                        <th class="text-center" style="background-color:#ecf8ff">月額費用</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <tr>
                                                                        <td><span>{{(Number(items.moving_in_to)/10000).toLocaleString()}} </span>万円</td>
                                                                        <td><span>{{(Number(items.per_month_to)/10000).toLocaleString()}} </span>万円</td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </td>
                                                </tr>
                                                </tbody>
                                            </table>

                                        </div>
                                    </div>
                                    </div>
                                </div>
                                </div>
                                <div class="nav-box" @click="moveCarousel(1)" :disabled="atEndOfList">
                                    <div class="nav-content ml-2">
                                        <div class="card-carousel--nav__right"></div>
                                    </div>
                                </div>
                            </div>
                            <div id="nursingView" class="col-12">
                                <h5 class="profile_subtit">もっと探す条件</h5>
                            </div>
                            <!--list-->
                            <div id="filtertable" class="col-12">
                                <table class="table table-bordered col-12 box-wrap">
                                    <tbody>
                                        
                                        <tr>
                                           
                                            <th class="pc-414-table sp-768-block" v-if="showOne" style="padding:10px;">入居時の条件</th>
                                            <td class="sp-768-block sp-414-table" v-if="showOne">
                                                <!--入居時の条件から探す-->
                                                <div class="dropdown search_rsp">
                                                    <button type="button" class="btn btn-default btn-sm dropdown-toggle sp-414" data-toggle="dropdown" style="width:100%;text-align:left;">
                                                    入居時の条件から探す
                                                    </button>
                                                    <ul class="dropdown-menu dropdown-menu-form" aria-labelledby="dropdownMenuButton" v-if="w_width <= 420" @click.stop="stopTheEvent">
                                                    <li>
                                                    <a data-value="option">
                                                        <div class="row">
                                                            <div class="col-lg-2 col-md-4" id="customCheck1">
                                                            <label class="form-check-label control control--checkbox">
                                                                <input class="form-check-input" :id="1" value="自立" v-model="MoveID" type="checkbox">
                                                                自立
                                                                <div class="control__indicator"></div>
                                                            </label>
                                                            </div>
                                                            <div class="col-lg-2 col-md-4" id="customCheck1">
                                                            <label class="form-check-label control control--checkbox">
                                                                <input class="form-check-input" :id="2" value="要支援" v-model="MoveID" type="checkbox">
                                                                要支援
                                                                <div class="control__indicator"></div>
                                                            </label>
                                                            </div>
                                                            <div class="col-lg-2 col-md-4" id="customCheck1">
                                                            <label class="form-check-label control control--checkbox">
                                                                <input class="form-check-input" :id="3" value="要介護" v-model="MoveID" type="checkbox">
                                                                要介護
                                                                <div class="control__indicator"></div>
                                                            </label>
                                                            </div>
                                                        </div>
                                                    </a>
                                                    </li>
                                                    </ul>
                                                    <a v-if="w_width >= 420">
                                                         <div class="row">
                                                            <div class="col-lg-2 col-md-4 search_wd" id="customCheck1">
                                                            <label class="form-check-label control control--checkbox">
                                                                <input class="form-check-input" :id="1" value="自立" v-model="MoveID" type="checkbox">
                                                                自立
                                                                <div class="control__indicator"></div>
                                                            </label>
                                                            </div>
                                                            <div class="col-lg-2 col-md-4 search_wd" id="customCheck1">
                                                            <label class="form-check-label control control--checkbox">
                                                                <input class="form-check-input" :id="2" value="要支援" v-model="MoveID" type="checkbox">
                                                                要支援
                                                                <div class="control__indicator"></div>
                                                            </label>
                                                            </div>
                                                            <div class="col-lg-2 col-md-4 search_wd" id="customCheck1">
                                                            <label class="form-check-label control control--checkbox">
                                                                <input class="form-check-input" :id="3" value="要介護" v-model="MoveID" type="checkbox">
                                                                要介護
                                                                <div class="control__indicator"></div>
                                                            </label>
                                                            </div>
                                                        </div>
                                                    </a>
                                                </div>
                                                <!--end 入居時の条件から探す -->
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="pc-414-table sp-768-block" v-if="showOne">特長</th>
                                            <td class="sp-768-block sp-414-table" v-if="showOne">
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
                                                            <input  class="form-check-input" type="checkbox" v-model="SpecialFeatureID" :id="feature.id" :value="feature.id" @click="features($event)">
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
                                                            <input  class="form-check-input" type="checkbox" v-model="SpecialFeatureID" :id="feature.id" :value="feature.id" @click="features($event)">
                                                            {{feature.name}}
                                                            <div class="control__indicator"></div>
                                                            </label>
                                                        </div>
                                                        </div>
                                                    </a>
                                                </div>
                                            <!-- end 特長 から探す-->

                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="pc-414-table sp-768-block" v-if="showOne">施設の種類  </th>
                                            <td class="sp-768-block sp-414-table" v-if="showOne">

                                            <!--施設の種類から探す-->
                                            <div class="dropdown search_rsp">
                                                
                                            <button type="button" class="btn btn-default btn-sm dropdown-toggle sp-414" data-toggle="dropdown" style="width:100%;text-align:left;">
                                                施設の種類から探す
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-form" aria-labelledby="dropdownMenuButton" v-if="w_width <= 420" @click.stop="stopTheEvent">
                                                <li>
                                                <a data-value="option">
                                                    <div class="row">
                                                    <div class="col-lg-2 col-md-4 col-sm-4" v-for="fac_type in fac_types" :key="fac_type.id">
                                                        <label class="form-check-label control control--checkbox">
                                                        <input class="form-check-input" type="checkbox" v-model="FacTypeID" :id="fac_type.id" :value="fac_type.id">
                                                        {{fac_type.description}}
                                                        <div class="control__indicator"></div>
                                                        </label>
                                                    </div>
                                                    </div>
                                                </a>
                                                </li>
                                            </ul>
                                             
                                            <a v-if="w_width >= 420">
                                              
                                                    <div class="row">
                                                    <div class="col-lg-2 col-md-4 col-sm-4" v-for="fac_type in fac_types" :key="fac_type.id">
                                                        <label class="form-check-label control control--checkbox">
                                                            <input class="form-check-input" type="checkbox" v-model="FacTypeID" :id="fac_type.id" :value="fac_type.id">
                                                            {{fac_type.description}}
                                                            <div class="control__indicator"></div>
                                                        </label>
                                                    </div>
                                                    </div>
                                                </a>
                                            </div>
                                            <!--end から探す -->
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="pc-414-table sp-768-block" v-if="showOne">医療面・診療科目</th>
                                            <td class="sp-768-block sp-414-table" v-if="showOne">
                                                <!--医療面・診療科目から探す-->
                                                <div class="dropdown search_rsp">
                                                    <button type="button" class="btn btn-default btn-sm dropdown-toggle sp-414" data-toggle="dropdown" style="width:100%;text-align:left;">
                                                    医療面・診療科目から探す
                                                    </button>
                                                    <ul class="dropdown-menu dropdown-menu-form" aria-labelledby="dropdownMenuButton" v-if="w_width <= 420" @click.stop="stopTheEvent">
                                                    <li>
                                                    <a data-value="option">
                                                         <div class="row">
                                                        <div class="col-lg-2 col-md-4 col-sm-4" v-for="medical in medical_acceptance" :key="medical.id">
                                                            <label class="form-check-label control control--checkbox">
                                                            <input class="form-check-input" type="checkbox" v-model="MedicalAcceptanceID" :id="medical.id" :value="medical.id">
                                                            {{medical.name}}
                                                            <div class="control__indicator"></div>
                                                            </label>
                                                        </div>
                                                        </div>
                                                    </a>
                                                    </li>
                                                    </ul>
                                                    <a v-if="w_width >= 420">
                                                         <div class="row">
                                                        <div class="col-lg-2 col-md-4 col-sm-4" v-for="medical in medical_acceptance" :key="medical.id">
                                                            <label class="form-check-label control control--checkbox">
                                                            <input class="form-check-input" type="checkbox" v-model="MedicalAcceptanceID" :id="medical.id" :value="medical.id">
                                                            {{medical.name}}
                                                            <div class="control__indicator"></div>
                                                            </label>
                                                        </div>
                                                        </div>
                                                    </a>
                                                </div>
                                                <!--end 医療面・診療科目から探す -->
                                            </td>
                                        </tr>
                                        
                                        <tr class="text-center">
                                            <td colspan="2" style="border:none;">
                                                <button class="main-bg-color create-btn all-btn col-lg-2 col-md-4 col-sm-2" id="search" @click="search"><i class="fas fa-search"></i>&nbsp; 検索 </button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                         <span v-if="norecord_msg">
                            <div class="container-fuid m-t-20">
                                <p class="nosearch-icon">
                                    <svg x="0px" y="0px" width="30" height="30" viewBox="0 0 172 172" style=" fill:red;"><g transform=""><g fill="none" fill-rule="nonzero" stroke="none" stroke-width="1" stroke-linecap="butt" stroke-linejoin="miter" stroke-miterlimit="10" stroke-dasharray="" stroke-dashoffset="0" font-family="none" font-weight="none" font-size="none" text-anchor="none" style="mix-blend-mode: normal"><path d="M0,172v-172h172v172z" fill="none"></path><path d="M86,172c-47.49649,0 -86,-38.50351 -86,-86v0c0,-47.49649 38.50351,-86 86,-86v0c47.49649,0 86,38.50351 86,86v0c0,47.49649 -38.50351,86 -86,86z" fill="none"></path><path d="M86,168.56c-45.59663,0 -82.56,-36.96337 -82.56,-82.56v0c0,-45.59663 36.96337,-82.56 82.56,-82.56v0c45.59663,0 82.56,36.96337 82.56,82.56v0c0,45.59663 -36.96337,82.56 -82.56,82.56z" fill="none"></path><path d="M0,172v-172h172v172z" fill="none"></path><path d="M3.44,168.56v-165.12h165.12v165.12z" fill="none"></path><path d="M86,172c-47.49649,0 -86,-38.50351 -86,-86v0c0,-47.49649 38.50351,-86 86,-86v0c47.49649,0 86,38.50351 86,86v0c0,47.49649 -38.50351,86 -86,86z" fill="none"></path><path d="M86,168.56c-45.59663,0 -82.56,-36.96337 -82.56,-82.56v0c0,-45.59663 36.96337,-82.56 82.56,-82.56v0c45.59663,0 82.56,36.96337 82.56,82.56v0c0,45.59663 -36.96337,82.56 -82.56,82.56z" fill="none"></path><path d="M0,172v-172h172v172z" fill="none"></path><path d="M3.44,168.56v-165.12h165.12v165.12z" fill="none"></path><path d="M86,172c-47.49649,0 -86,-38.50351 -86,-86v0c0,-47.49649 38.50351,-86 86,-86v0c47.49649,0 86,38.50351 86,86v0c0,47.49649 -38.50351,86 -86,86z" fill="none"></path><path d="M86,168.56c-45.59663,0 -82.56,-36.96337 -82.56,-82.56v0c0,-45.59663 36.96337,-82.56 82.56,-82.56v0c45.59663,0 82.56,36.96337 82.56,82.56v0c0,45.59663 -36.96337,82.56 -82.56,82.56z" fill="none"></path><g fill="#666666"><path d="M74.53333,17.2c-31.59643,0 -57.33333,25.73692 -57.33333,57.33333c0,31.59641 25.7369,57.33333 57.33333,57.33333c13.73998,0 26.35834,-4.87915 36.24766,-12.97839l34.23203,34.23203c1.43802,1.49778 3.5734,2.10113 5.5826,1.57735c2.0092,-0.52378 3.57826,-2.09284 4.10204,-4.10204c0.52378,-2.0092 -0.07957,-4.14458 -1.57735,-5.5826l-34.23203,-34.23203c8.09923,-9.88932 12.97839,-22.50768 12.97839,-36.24766c0,-31.59641 -25.7369,-57.33333 -57.33333,-57.33333zM74.53333,28.66667c25.39939,0 45.86667,20.46729 45.86667,45.86667c0,25.39937 -20.46728,45.86667 -45.86667,45.86667c-25.39939,0 -45.86667,-20.46729 -45.86667,-45.86667c0,-25.39937 20.46728,-45.86667 45.86667,-45.86667zM91.67734,51.52161c-1.51229,0.03575 -2.94918,0.66766 -3.99765,1.75807l-13.14636,13.14636l-13.14636,-13.14636c-1.07942,-1.10959 -2.56162,-1.73559 -4.10963,-1.73568c-2.33303,0.00061 -4.43306,1.41473 -5.31096,3.57628c-0.8779,2.16155 -0.3586,4.6395 1.31331,6.26669l13.14636,13.14636l-13.14636,13.14636c-1.49777,1.43802 -2.10111,3.5734 -1.57733,5.58259c0.52378,2.0092 2.09283,3.57825 4.10203,4.10203c2.0092,0.52378 4.14457,-0.07956 5.58259,-1.57733l13.14636,-13.14636l13.14636,13.14636c1.43802,1.49778 3.5734,2.10113 5.5826,1.57735c2.0092,-0.52378 3.57826,-2.09284 4.10204,-4.10204c0.52378,-2.0092 -0.07957,-4.14458 -1.57735,-5.5826l-13.14636,-13.14636l13.14636,-13.14636c1.70419,-1.63875 2.22781,-4.1555 1.31865,-6.33798c-0.90916,-2.18248 -3.06468,-3.58317 -5.42829,-3.52739z"></path></g></g></g></svg>
                                </p>
                                <p class="nosearch-data">お探しの条件に合う施設は見つかりませんでした。</p>
                                <p class="nosearch">条件の変更を行い再度ご検索いだだくと見つかる可能性がございます。</p>
                            </div>
                        </span>
                    </div>
                    <!--end search list-->

                    <div class="">
                        <div class="row">
                            <div class="col-lg-6 col-md-12 col-slg-12" style="margin-top:20px;" v-for="(nus,index) in displayItems" :key="nus.id">
                                <div class="nur-content">
                                    <div class="job-header">
                                        <div class="row pad-free">
                                            <div class="col-lg-9 col-sm-9">
                                            <p class="job_id2"><span> 施設番号:{{nus.profilenumber}}</span></p>
                                            <h5 class="nur-tit">
                                                <router-link :to="{ path:'/profile/nursing/'+ nus.nursing_id}" class="pseudolink" style="font-weight:bold;">{{nus.name}}</router-link>
                                            </h5>
                                          
                                           

                                            <div class="d-flex sp-414" id="sp-414-block">
                                                <span v-for="(fac,index) in fac_types" :key="index+'-'+fac.description+'-'+nus.id">
                                                    <span v-if="fac.id == nus.fac_type" class="fac_list">
                                                        {{fac.description}}
                                                    </span>
                                                </span>
                                                <span v-if="nus.date_of_establishment" class="nur_date"><span style="font-weight:bold;color:green;">開設年月日 :</span> {{nus.date_of_establishment}}</span>
                                            </div>

                                            </div>

                                            <div class="col-lg-3 col-sm-3 text-right pc-768">
                                            <span class="btn fav-profile fav-item fav-color" v-if="nus.fav_check == '' && !$auth.check()" :class="'view_pro_id'+nus.nursing_id" style="display:block;" @click="favAddFun('add',nus.nursing_id,index);"><i class="fas fa-plus-square" style="color:#c40000!important;"></i>&nbsp; お気に入りに追加</span>
                                            <span class="btn fav-profile fav-item fav-color" v-if="nus.fav_check == 'check' && !$auth.check()" :class="'done_pro_id'+nus.nursing_id" style="color:#aaa;display:block;" @click="favAddFun('remove',nus.nursing_id,index);"><i class="fas fa-check-double" style="color:#c40000!important;"></i>&nbsp; 追加済み</span>
                                            </div>
                                        </div>
                                    </div>

                                    <p class="m-b-10"><span class="job_ico"><i class="fa fa-map-signs"></i></span>{{nus.city_name}} <i class="fas fa-angle-double-right" style="color:#b9b5b5;"></i> {{nus.township_name}} </p>
                                    
                                    
                                    
                                    <div class="col-12 pad-free m-b-10 clearfix">
                                        <span class="num-room"> {{nus.num_rooms}} </span>
                                        <p class="hos_phone float-right pc-768" v-if="nus.phone"><span class="circle-phone" ><i class="fa fa-phone-alt"></i></span><span class="phone-no"><a :href="`tel:${nus.phone}`">{{nus.phone}}</a></span></p>
                                    </div>
                                    <div class="job-body row  clearfix">
                                        <div class="col-md-4 col-sm-12 job-img">
                                            <img :src="'/upload/nursing_profile/'+nus.logo" alt="image" @error="imgUrlAlt">
                                            <div class="mt-4 col-12 detail-btn text-center pc-768">
                                                <router-link :to="{ path:'/profile/nursing/'+ nus.nursing_id}" class="btn all-btn" style="font-weight:bold;">詳細を見る</router-link>
                                            </div>
                                        </div>
                                        <div class="col-md-8 col-sm-12 job-box">
                                            <table  class="table table-bordered table-sm">
                                                <!-- <tr>
                                                <td style="width:30%;"><span class="job_ico"><i class="fa fa-user"></i></span>名前</td>
                                                <td>{{nus.name}}</td              >
                                                </tr> -->
                                                <tr>
                                                    <td><span class="job_ico">&#xa5;</span>入居時費用</td>
                                                    <!-- <td><span class="cash-lbl">{{Number(nus.moving_in_to)/10000}} </span>万円</td> -->
                                                    <td class="cash-lbl">
                                                        <span v-if="Number(nus.moving_in_from) == 0">0円</span>
                                                        <span v-else>
                                                        {{(Math.floor(Number(nus.moving_in_from)/10000))==0? '' : (Math.floor(Number(nus.moving_in_from)/10000)).toLocaleString()+'万' }}{{(Number(nus.moving_in_from)%10000)==0 ? '' : (Number(nus.moving_in_from)%10000).toLocaleString()}}円
                                                        </span>
                                                            ~
                                                        <span v-if="Number(nus.moving_in_to) == 0">0円</span>
                                                        <span v-else>
                                                        {{(Math.floor(Number(nus.moving_in_to)/10000))==0? '' : (Math.floor(Number(nus.moving_in_to)/10000)).toLocaleString()+'万' }}{{(Number(nus.moving_in_to)%10000)==0 ? '' : (Number(nus.moving_in_to)%10000).toLocaleString()}}円
                                                        </span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><span class="job_ico">&#xa5;</span>月額費用</td>
                                                    <td>
                                                        <font class="cash-lbl">
                                                            <span v-if="Number(nus.per_month_from) == 0">0円</span>
                                                            <span v-else>
                                                            {{(Math.floor(Number(nus.per_month_from)/10000))==0? '' : (Math.floor(Number(nus.per_month_from)/10000)).toLocaleString()+'万' }}{{(Number(nus.per_month_from)%10000)==0 ? '' : (Number(nus.per_month_from)%10000).toLocaleString()}}円
                                                            </span>
                                                                ~
                                                            <span v-if="Number(nus.per_month_to) == 0">0円</span>
                                                            <span v-else>
                                                            {{(Math.floor(Number(nus.per_month_to)/10000))==0? '' : (Math.floor(Number(nus.per_month_to)/10000)).toLocaleString()+'万' }}{{(Number(nus.per_month_to)%10000)==0 ? '' : (Number(nus.per_month_to)%10000).toLocaleString()}}円
                                                            </span>
                                                        </font>
                                                    </td>
                                                </tr>
                                                <!-- <tr>
                                                <td style="width:30%;"><span class="job_ico"><i class="fa fa-envelope"></i></span>メールアドレス</td>
                                                <td>{{nus.email}}</td>
                                                </tr> -->
                                                <tr>
                                                <td><span class="job_ico"><i class="fa fa-map-marker-alt"></i></span>住所</td>
                                                <td>{{nus.city_name}}{{nus.township_name}}{{nus.address}}</td>
                                                </tr>
                                                <tr>
                                                <td><span class="job_ico"><i class="fa fa-map-marker-alt"></i></span>アクセス</td>
                                                <td><p v-html="nus.access"></p></td>
                                                </tr>
                                                <tr>
                                                   
                                                <td><span class="job_ico"><i class="fa fa-building"></i></span>運営事業者名 </td>
                                                <td>{{nus.cus_name}}</td>
                                                </tr>
                                                <!-- <tr>
                                                <td style="width:30%;"><span class="job_ico">&#xa5;</span>入居時費用</td>
                                                <td>{{nus.moving_in}} </td>
                                                </tr> -->
                                            </table>
                                            <h5 class="header m-t-10">こだわりの特長</h5>                                              
                                            <span v-for="(spe,index) in specialfeature" :key="index+'-'+spe.name+'-'+nus.id">
                                      
                                            <span v-if="spe.profile_id == nus.nursing_id" class="feature_list">
                                                {{spe.name}}
                                            </span>
                                            </span>
                                        </div>
                                    </div>
                                    <!--responsive add-fav and phone-->
                                        <div class="row" id="job_detail">
                                            <div class="col-md-6 col-sm-12 m-b-414">
                                                <p class="sp_hos_phone sp-768 m-b-10" v-if="nus.phone"><span class="circle-phone" ><i class="fa fa-phone-alt"></i></span><span class="phone-no"><a :href="`tel:${nus.phone}`">{{nus.phone}}</a></span></p>
                                            </div>
                                            <div class="col-md-6 col-sm-12 m-t-768">
                                                <p class="sp-768">
                                                    <span class="btn fav-profile fav-item fav-color" v-if="nus.fav_check == '' && !$auth.check()" :class="'view_pro_id'+nus.nursing_id" style="display:block;" @click="favAddFun('add',nus.nursing_id,index);"><i class="fas fa-plus-square" style="color:#c40000!important;"></i>&nbsp; お気に入りに追加</span>
                                                    <span class="btn fav-profile fav-item fav-color" v-if="nus.fav_check == 'check' && !$auth.check()" :class="'done_pro_id'+nus.nursing_id" style="color:#aaa;display:block;" @click="favAddFun('remove',nus.nursing_id,index);"><i class="fas fa-check-double" style="color:#c40000!important;"></i>&nbsp; 追加済み</span>
                                                </p>
                                            </div>
                                        </div>
                                        <!--end responsive add-fav and phone-->
                                        <div class="detail-btn text-center sp-768">
                                            <router-link :to="{ path:'/profile/nursing/'+ nus.nursing_id}" class="btn all-btn" style="font-weight:bold;">詳細を見る</router-link>
                                        </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-12 col-lg-12 col-sm-6" v-if="show_paginate">
                            <nav aria-label="Page navigation example">
                                <ul class="pagination">
                                <li class="page-item previous">
                                    <span class="spanclass el1 disabled"  @click="first"><i class='fas fa-angle-double-left'></i> 最初</span>
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
                                    <span class="spanclass el2"  @click="last">最後 <i class='fas fa-angle-double-right'></i></span>
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
    import { eventBus } from '../event-bus.js';

    export default {

        name: "mymap",
        components: {
        layout,
        bulcomponent,
        maptag
        },

        data() {
            return {
                /**added by maythirihtet */
                c_year:new Date().getFullYear(),
                vactive:true,
                linkednews: [],
                yeararr: [],
                /**end of added by maythirihtet */
                cityid:[], listid : '', map: null, markers: [], searchmarkers:[], marker:[], selectedLocation: null, infoBoxOpen: false, places: [], id: '-1', townshipID:[], township_id:-1, moving_in:-1, per_month:-1, cities: '', getCity: [], getTownships: [], special_features: [], fac_types: [], fac_id: [], medical_acceptance: [], show: false, showOne: true, currentOffset: 0, windowSize: 4, paginationFactor: 328, window:{ width: 0, height: 0 }, nursingList: [], alphabet: [], markerHover:[], SpecialFeatureID:[], MedicalAcceptanceID:[], FacTypeID:[], MoveID:[], nus_data:[], specialfeature:[], medicalacceptance:[], factype:[], selectedcity:'', citylatlng:[], view_pro_id: [], currentPage: 0, size: 20, pageRange: 5, items: [], show_paginate: false, onchangeid:0, localst:'', selected: undefined, toggleCheck: true, loading: false, coordinate:[], norecord_msg: false, ci : false, window:{ width: 0, height: 0 }, w_width:$(window).width(), cityArray: [], allCity: [], citynewArray:[], boundsval: 'no marker', searchword:'', index:'', clicksearch: false, isActive: true,
            }
        },

        created(){
            this.axios('/api/cities').then((response) => {
                this.cities = response.data.city;
            })
            /**added by maythirihtet*/
            this.axios.get('/api/getLinkedNews/'+1).then((response) => { 
                this.linkednews = response.data.linkednews,
                this.yeararr = response.data.yeararr;
            });
            /**end of added by maythirihtet */
            window.addEventListener('resize', this.handleResize)
            this.handleResize();
            if(this.window.width >= 320 && this.window.width < 360) {
                this.windowSize = 1;
                this.paginationFactor=277;
            }
            else if(this.window.width >= 360 && this.window.width < 375) {
                this.windowSize = 1;
                this.paginationFactor=277;
            }
            else if(this.window.width >= 375 && this.window.width < 452) {
                this.windowSize = 1;
                this.paginationFactor=277;
            }
            else if(this.window.width >= 450 && this.window.width < 768) {
                this.windowSize = 1;
                this.paginationFactor=341;
            }
            else if(this.window.width >= 768 && this.window.width < 992) {
                this.windowSize = 2;
                this.paginationFactor=277;
            }
            else if(this.window.width >= 992 && this.window.width < 1024) {
                this.windowSize = 2;
                this.paginationFactor=398;
            }
            else if (this.window.width >= 1024 && this.window.width < 1200) {
                this.windowSize = 3;
                this.paginationFactor=270;
            }
                else if (this.window.width >= 1200 && this.window.width < 1280) {
                this.windowSize = 2;
                this.paginationFactor=412;
            }
            else if (this.window.width >= 1280 && this.window.width < 1440) {
                this.windowSize = 3;
                this.paginationFactor=329;
            }
            else if (this.window.width >= 1440 && this.window.width < 1800) {
                this.windowSize = 3;
                this.paginationFactor=340;
                console.log(this.window.width);
            }
             else if (this.window.width >= 1800 && this.window.width < 1880) {
                this.windowSize = 4;
                this.paginationFactor=329;
            }
        },

        mounted() {
            $('#navtab').removeClass('news-tabColor hospital-tabColor nursing-tabColor job-tabColor');
            $('#navtab').addClass('nursing-tabColor');
            $('.tab-content').removeClass('news-borderColor job-borderColor nursing-borderColor hospital-borderColor');
            $('#upper-tab').addClass('nursing-borderColor');
        },

        computed: {
            atEndOfList() {
                return this.currentOffset <= (this.paginationFactor * -1) * (this.nus_data.length - this.windowSize);
            },
            atHeadOfList() {
                return this.currentOffset === 0;
            },
            pages() {
                return Math.ceil(this.nus_data.length / this.size);
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
            return this.nus_data.slice(head, head + this.size);
            },
            isSelected(page) {
            return page - 1 == this.currentPage;
            }
        },

        methods: {
            /**added by maythirihtet */
            showDataByYear(year) {
                this.c_year = year;
            },
            /**end of added by maythirihtet */
            handleResize() {
                this.window.width = window.innerWidth;
                this.window.height = window.innerHeight;
            },            

            searchfreeword(){
           
                this.ci = true;
             
                //clear all drop down
                this.id = -1;
                this.township_id = -1;
                this.moving_in = -1;
                this.per_month = -1;

                // if(this.townshipID == null || this.townshipID == '')
                // {
                // this.townshipID[0] = 0;
                // }
                if(this.SpecialFeatureID == null || this.SpecialFeatureID == '')
                {
                this.SpecialFeatureID[0] = 0;
                }
                if(this.MedicalAcceptanceID == null || this.MedicalAcceptanceID == '')
                {
                this.MedicalAcceptanceID[0] = 0;
                }
                if(this.FacTypeID == null || this.FacTypeID == '')
                {
                this.FacTypeID[0] = 0;
                }
                if(this.MoveID == null || this.MoveID == '')
                {
                this.MoveID[0] = 0;
                }

                if ($('#search-free-word').val() != '')
                {
                    this.id = -1;
                    var search_word = $('#search-free-word').val();
                    this.searchword = search_word;
                }
                else if($('#search-free-word-res').val() != '')
                {
                    this.id = -1;
                    var search_word = $('#search-free-word-res').val();
                    this.searchword = search_word;
                }
                else{
                    var search_word = 'all';
                    this.searchword = 'all';
                }

                if(localStorage.getItem("nursing_fav") == null){
                    this.locast = 0;
                }
                else{
                    this.locast = localStorage.getItem("nursing_fav");
                }

                this.axios.get('/api/getnursingsearch/'+search_word,{
                params:{
                
                id: this.id,
                townshipID:this.township_id,
                Moving_in:this.moving_in,
                Per_month:this.per_month,
                local:this.locast,
                // townshipID:this.townshipID,
                SpecialFeatureID:this.SpecialFeatureID,
                MedicalAcceptanceID:this.MedicalAcceptanceID,
                FacTypeID:this.FacTypeID,
                MoveID:this.MoveID,

                },
                })
                .then((response) => { 
                     
                    $("#mymap").css({'display' : 'block','height' : '400px','width':'100%'});
                    $("#filtertable").css("display", "block");
                    $("#nursing-search").css("display", "block");
                   
    
                    if(response.data.nursing.length != 0){
                     
                        this.norecord_msg = false;
                      
                        this.changeMap(response,1);
                        this.getTownships = [];
                    }else{
                     
                        $("#mymap").css({'display' : 'none'});
                        this.nus_data = [];
                        this.norecord_msg = true;
                        this.special_features = response.data.special_features;
                        this.fac_types = response.data.fac_types;
                        this.medical_acceptance = response.data.medical_acceptance;

                    }
                });

            },

            check() {
                this.onchangeid = 0;
                this.moving_in = -1;
                this.township_id = -1;
            },

            openInfoWindow(marker) {
                this.selectedLocation = marker;
                this.infoBoxOpen = true;
            },
            closeInfoWindow() {
                this.infoBoxOpen = false;
            },
            showSearchMap() {
               
                //clear all checkbox
                this.id = [];
                this.townshipID = [];
                this.SpecialFeatureID = [];
                this.FacTypeID = [];
                this.MoveID = [];
                this.MedicalAcceptanceID = [];
                this.nus_data = [];

                $('#searchMap').removeClass('select');
                $('#showSearchMap').addClass('select');
                $('#filter').addClass('select');
                $("#mymap").css("display", "none");
                $("#nursing-search").css("display", "none");
                $("#filtertable").css("display", "none");
                document.getElementById('search-free-word').value = '';
                
            },

            moveCarousel(direction) {
                // Find a more elegant way to express the :style. consider using props to make it truly generic
                if (direction === 1 && !this.atEndOfList) {
                this.currentOffset -= this.paginationFactor;
                } else if (direction === -1 && !this.atHeadOfList) {
                this.currentOffset += this.paginationFactor;
                }
            },

//  google map  function start========================================

            parentGetStateClick(e,parentVue) {                
               
                var _this = parentVue;
                _this.clicksearch = true;
                $("#mymap").css({'display' : 'block','height' : '400px','width':'100%'});
                $('.select').removeClass('select');
                $('#searchMap').addClass('select');
                $('#showSearchMap').removeClass('select');
                $('#filter').removeClass('select');
                // this.$loading(true);
                _this.loading = true;
               localStorage.setItem('features', 'nursing');
                _this.ci = false;
                _this.township_id= -1;
                _this.moving_in = -1;
                _this.per_month = -1;
                $("#nursing-search").css("display", "block");
                
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
             
                // _this.$loading(true);
                
                _this.axios.get('/api/getmap',{
                    params:{
                    id: _this.id,
                    township_id:-1,
                    moving_in:-1,
                    per_month:-1,
                    local:_this.locast,
                    feature:'nursing',
                    SpecialFeatureID:[0],
                    MedicalAcceptanceID:[0],
                    FacTypeID:[0],
                    MoveID:[0],

                   
                    },
                })
                    .then((response) => {
                    //   _this.$loading(false);
                    $("#mymap").css({'display' : 'block','height' : '400px','width':'100%'});
                    // $("#mymap").css('display', 'block');
                    $("#nursing-search").css("display", "block");
                    $("#filtertable").css("display", "block");
                    
                    _this.changeMap(response,2)
                    })

                //  _this.changeSearch();
            },

            // map onclick function

            // make infowindow, marker , google map
            changeMap(response,freewordornot){ 
              
                 
                if(this.id == -1 && freewordornot == 2)
                {
                    freewordornot = 1;
                }
             
                $('.select').removeClass('select');
                $('#searchMap').addClass('select');
                $('#showSearchMap').removeClass('select');
                $('#filter').removeClass('select');

                this.cities = response.data.city
                this.getCity = response.data.getCity       
                this.getTownships = response.data.getTownships;
                this.specialfeature = response.data.specialfeature;
                this.special_features = response.data.special_features
                this.fac_types = response.data.fac_types
                this.medical_acceptance = response.data.medical_acceptance
                this.nus_data = response.data.nursing
                this.markers = response.data.nursing;
                if(this.nus_data.length != 0){
                    this.norecord_msg = false;
                }else{
                    this.norecord_msg = true;
                   
                }
                if(this.nus_data.length > this.size) {
                  this.show_paginate = true;
                }else{
                  this.show_paginate = false;  
                }

                    var mmarker = new Array();
                    var item = [];
                    for (var i = 0; i < this.markers.length; i++) {
                        mmarker.push([this.markers[i]['alphabet'], this.markers[i]['lat'], this.markers[i]['lng']])
                        item.push(this.markers[i])
                    }

                if(this.getCity.length > 0)
                {
                      var theCity = response.data.getCity[0]['city_eng'].trim();
                      var lat = response.data.getCity[0]['latitude']
                      var lng = response.data.getCity[0]['longitude']
                }
                else{
                    var lat = 38.2682;
                    var lng = 140.8694;
                }
                if(this.map == null){ 
                 
              
                    this.createMap(theCity,lat,lng)
                    if(freewordornot == 1)
                    {
               
                        this.infoWindow(item, mmarker,response);
                    }
                    else{
                    
                        this.coordinates(theCity,lat,lng);
                        this.infoWindow(item, mmarker,response);
                    }
                }else{

                
                        var map = this.map
                        var callback = function(feature) {
                            map.data.remove(feature);
                        };
                        map.data.forEach(callback);
                        if(freewordornot != 1)
                        {
                            this.coordinates(theCity,lat,lng);
                        }
                        this.infoWindow(item, mmarker,response); 
                        this.loading = false;
                  
                   
                 
                 
                }
            },
            nursingSearchData(id){
               

                this.searchword = '';
                this.loading = true;
                this.ci = false;
                if(id == 1) //if choose city
                {
               
                    this.township_id = -1;
                    this.townshipID = [];
                }
                else{ //if choose township
                this.townshipID = [];
                this.townshipID[0] = this.township_id;
                }

                 if(this.SpecialFeatureID == null || this.SpecialFeatureID == '')
                {
                this.SpecialFeatureID[0] = 0;
                }
                if(this.MedicalAcceptanceID == null || this.MedicalAcceptanceID == '')
                {
                this.MedicalAcceptanceID[0] = 0;
                }
                if(this.FacTypeID == null || this.FacTypeID == '')
                {
                this.FacTypeID[0] = 0;
                }
                if(this.MoveID == null || this.MoveID == '')
                {
                this.MoveID[0] = 0;
                }

                //if change dropdown , clear array
                // this.MoveID = [];
                // this.MedicalAcceptanceID = [];
                // this.FacTypeID = [];
                // this.SpecialFeatureID = [];
                this.onchangeid = 1;
                if(localStorage.getItem("nursing_fav") == null){
                    this.locast = 0;
                }
                else{
                    this.locast = localStorage.getItem("nursing_fav");
                }

                this.axios.get('/api/getmap',{
                    params:{
                    id: this.id,
                    township_id:this.township_id,
                    moving_in:this.moving_in,
                    per_month:this.per_month,
                    local:this.locast,
                    feature:'nursing',
                    SpecialFeatureID:this.SpecialFeatureID,
                    MedicalAcceptanceID:this.MedicalAcceptanceID,
                    FacTypeID:this.FacTypeID,
                    MoveID:this.MoveID,

                    },

                })
                .then((response) => {
                    $("#mymap").css({'display' : 'block','height' : '400px','width':'100%'});
                    $(".profile_header").css("display", "block");
                    $("#nursing-search").css("display", "block");
                    $("#filtertable").css("display", "block");
                    this.changeMap(response,2)
                  
                })
            },

            createMap(theCity,lat,lng){

                if(this.township_id == -1){
                    var mapProp = {
                        center: new google.maps.LatLng(lat, lng),
                        minZoom: 4,
                        maxZoom: 18,
                        zoom: 7,
                        mapTypeId: google.maps.MapTypeId.ROADMAP,
                        options: {
                            gestureHandling: 'greedy'
                        }
                    };
                }else{
                    var mapProp = {
                        center: new google.maps.LatLng(lat, lng),
                        minZoom: 4,
                        maxZoom: 18,
                        zoom: 7,
                        mapTypeId: google.maps.MapTypeId.ROADMAP,
                        options: {
                            gestureHandling: 'greedy'
                        }
                    };
                }
                this.map = new google.maps.Map(document.getElementById("mymap"), mapProp);
                
            },
            coordinates(theCity,lat,lng){
              
                // this.loading = false
                let  coor =[];
                var townshipName = [];
                var town = [];
                const city_coordinates = [];
                const arr = [];
                if(this.township_id != -1){
                    // get township postalcode
                    for (let i = 0; i < this.getTownships.length; i++) {
                        if(this.getTownships[i]['id'] == this.township_id){
                            townshipName.push(this.getTownships[i]['postalcode'])
                            town.push(this.getTownships[i]['township_name'])
                        }
                    }
                }else if(this.townshipID != 0){
                    for (let i = 0; i < this.townshipID.length; i++) {
                        for (let k = 0; k < this.getTownships.length; k++) {
                            if(this.getTownships[k]['id'] == this.townshipID[i]){
                                townshipName.push(this.getTownships[k]['postalcode'])
                                town.push(this.getTownships[k]['township_name'])
                            }                    
                        }                    
                    }
                }

               var township_name = townshipName;
            //    this.coordinate = []; 
            //    this.coordinate = [
            //        {"type":"FeatureCollection","features":[{"type":"Feature","geometry":{"type":"MultiPolygon"}}]}
            //    ]

               if(this.ci == true && (this.townshipID[0] == "-1" || this.townshipID.length == 0))
               {              
                  
                    this.loading = false;                    
               }
               else if(this.ci == false && (this.townshipID[0] == 0 || this.townshipID[0] == "-1" || this.townshipID.length == 0)){ 
                
                var newresult=[];
                var jsonfile = theCity+".json";
                // https://t-i-s.jp
                // https://testikportal.management-partners.co.jp/
                this.axios.get("https://test.t-i-s.jp/json/cities/"+jsonfile).then(respon => {
                    this.coordinate = respon.data.reduce((acc, val) => acc.concat(val), []);
                    this.boundariesGoogleMap(lat,lng,this.coordinate);  
                }); 

                }  
                else{
                    var jsonfile = theCity+".json";
                    jsonfile = jsonfile.toLowerCase();
                    this.axios.get('https://test.t-i-s.jp/json/Townships/'+jsonfile).then(res => {
                     var township_coor = []
                    for(var i = 0; i < res.data.features.length; i++)
                    {
                      
                         if(res.data.features[i]['properties']['N03_007'] == township_name)
                         {
                            //  console.log(res.data);
                              township_coor.push(res.data.features[i]);
                               this.boundariesGoogleMap(lat,lng,township_coor);       
                         }
                     }                     
                    })
                }
            },

            boundariesGoogleMap(lat,lng,coor){        
                // var bb = coor.reduce((acc, val) => acc.concat(val), []);   
                var data = coor.reduce((acc, val) => acc.concat(val), []);   
                // var data = coor; 
        
                for (let i = 0; i < data.length; i++) {
                    this.map.data.addGeoJson(data[i]); 
                }
     
                var bounds = new google.maps.LatLngBounds();
                this.map.data.forEach(function(feature){
                    var geo = feature.getGeometry();
                    geo.forEachLatLng(function(LatLng){
                    bounds.extend(LatLng)
                    });
                });
                this.map.data.setStyle({
                strokeColor: "red",
                fillColor: 'red',
                strokeOpacity: 0.8,
                fillOpacity: 0.1,
                strokeWeight: 1
                })
              
                
                if(this.boundsval == 'no marker'){
                    this.boundsval = bounds;
                }
                this.map.fitBounds(this.boundsval)                
                this.loading = false;
            },

            infoWindow(item, mmarker,response){    
                      
                var infoWindowContent = new Array();
               
                if(item.length  && mmarker.length)
                {
                    for (var i = 0; i < item.length; i++) {
                        var typename = item[i]['type_name'] == null ? '介護':item[i]['type_name'];
                        var phonenum = item[i]['phone'] == null ? '':item[i]['phone'];
                        var phclass = item[i]['phone'] == null ? 'nus_phone_none': 'nus_phone';
                        infoWindowContent.push([
                            '<div id="info_content">' +
                            '<div class="">' +
                                '<table class="table" style="margin-bottom:0px;">' +
                                '<thead>' +
                                    '<tr>' +
                                    '<td colspan="2"><span class="type-name">' +
                                    typename+
                                    '</span>'+
                                    '</td>' +
                                    '</tr>' +
                                    '<tr>' +
                                    '<td colspan="2"><p class="job_id search_jobid" style="float:left;margin-top:0px;margin-bottom:0px;"><span> 施設番号:' +
                                     item[i]['profilenumber']+
                                    '</span></p>'+
                                    '</td>' +
                                    '</tr>' +
                                '</thead>' +
                                '<tbody>' +
                                    '<tr>' +
                                    '<td colspan="2" class="text-left" style="padding-bottom:0px;">' +
                                    '<img src="http://chart.apis.google.com/chart?chst=d_map_pin_letter&chld='+item[i]['alphabet']+'|fd0e0e|ffffff" alt="" style="margin-right:10px; @error="imgUrlAlt"">' +
                                    '<span class="item-name">' + item[i]['name'] + '</span> <br>' +
                                    '</td>' +
                                '</tr>' +

                                '<tr>' +                                
                                '<td colspan="2">' +
                                    '<p class="'+phclass+'"><span class="circle-phone"><i class="fa fa-phone-alt"></i></span>' + phonenum + '</p>' +
                                '</td>' +
                                '</tr>' +
                                ' <tr>' +
                                '<td colspan="2" style="padding-top:0px;">' +
                                    '<div class="">' +
                                    '<table class="table table-bordered price-tbl text-center" style="margin-bottom:0px">'+
                                    '<thead><tr style="background-color:#ecf8ff"><th class="text-center" style="background-color:#ecf8ff">入居時費用</th><th class="text-center" style="background-color:#ecf8ff">月額利用料</th></tr></thead>'+
                                    '<tbody>'+
                                    '<tr><td><span>'+ (Number(item[i]['moving_in_to'])/10000).toLocaleString() + '</span>万円</td><td><span>'+ (Number(item[i]['per_month_to'])/10000).toLocaleString() + '</span>万円</td></tr>'+
                                    '</tbody>'+
                                    '</table>'+
                                    '</div>' +
                                '</td>' +
                                '</tr>' +
                                '</tbody>' +
                                '</table>' +
                            '</div>' +
                            '</div>'
                        ])
                    }
                    var markers = mmarker;
                    var bounds = new google.maps.LatLngBounds();
                    this.markerHover = [];
                    var infoWindow = new google.maps.InfoWindow(),marker, i;
                }
              
                if(this.marker.length)
                {
                   for (let index = 0; index < this.marker.length; index++) {
                       this.marker[index].setMap(null);
                   }
                }
            
                var marker = [];
                var markers = [];
                markers = mmarker;
                var bounds = new google.maps.LatLngBounds();
                this.markerHover = [];
                var infoWindow = [];
                infoWindow = new google.maps.InfoWindow();
               
                   var i = [];
                   for (let i = 0; i < this.markers.length; i++) {
                    var beach = this.markers[i]
                    var lats = this.markers[i]['lat']
                    var lngs = this.markers[i]['lng']
                    var img = this.markers[i]['alphabet']
                    var myLatLng = new google.maps.LatLng(lats, lngs);
                    var  position = new google.maps.LatLng(markers[i][1], markers[i][2]);
                    // var trafficLayer = new google.maps.TrafficLayer();
                    // trafficLayer.setMap(this.map);
            
                    this.marker[i] = new google.maps.Marker({
                            position: position,
                            map: this.map,
                            animation: google.maps.Animation.DROP,
                            zoom:5,
                            icon: 'http://chart.apis.google.com/chart?chst=d_map_pin_letter&chld=' + img + '|fd0e0e|ffffff',
                            title: this.markers[i]['name'],
                            options: {
                            gestureHandling: 'greedy'
                        }
                    });
                    marker = this.marker[i]
                    // this.googleMarker = marker;
                    bounds.extend(position);
                    google.maps.event.addListener(marker, 'click', (function(marker, i) {
                    return function() {
                        infoWindow.setContent(infoWindowContent[i][0]);
                        infoWindow.open(this.map, marker);
                         jQuery(".gm-ui-hover-effect").attr('title', '閉じる');                   
                         }
                    })(marker, i));
                    this.markerHover.push(marker)
                    var boundsListener = google.maps.event.addListener((this.map), 'bounds_changed', function(event) {
                    google.maps.event.removeListener(boundsListener);
                    });

                }
                this.boundsval = bounds;
                if(position != undefined){
                    this.map.fitBounds(this.boundsval);
                }
                else{
                    this.boundsval = "no marker";
                }
            },
            // make infowindow, marker , google map
            clearmap(citylatlng)
            {
                // for clean googleMap
                var lat = citylatlng[0]['latitude']
                var lng = citylatlng[0]['longitude']
                var theCity = citylatlng[0]['city_name']
                const result = jp_township.features
                const coordinates = []
                for (var i = 0; i < result.length; i++) {
                    if (result[i].Name == theCity) {
                    coordinates.push(result[i].geometry['coordinates'])
                    }
                }
                var coordinate = coordinates.reduce((acc, val) => acc.concat(val), []);
                var data = {
                    type: "Feature",
                    geometry: {
                    "type": "Polygon",
                    "coordinates": coordinate
                    },
                };
                var mapProp = {
                    center: new google.maps.LatLng(lat, lng),
                    zoom: 5,
                    mapTypeId: google.maps.MapTypeId.ROADMAP,
                };
                this.map = new google.maps.Map(document.getElementById("mymap"), mapProp);
                this.map.data.addGeoJson(data);
                this.map.data.setStyle({
                    strokeColor: "red",
                    fillColor: 'red',
                    strokeOpacity: 0.8,
                    fillOpacity: 0.1,
                    strokeWeight: 1
                })
            },

            search(){              

                // if(this.townshipID == null || this.townshipID == '')
                // {
                // this.townshipID[0] = 0;
                // }
                
                if(this.SpecialFeatureID == null || this.SpecialFeatureID == '')
                {
                this.SpecialFeatureID[0] = 0;
                }
                if(this.MedicalAcceptanceID == null || this.MedicalAcceptanceID == '')
                {
                this.MedicalAcceptanceID[0] = 0;
                }
                if(this.FacTypeID == null || this.FacTypeID == '')
                {
                this.FacTypeID[0] = 0;
                }
                if(this.MoveID == null || this.MoveID == '')
                {
                this.MoveID[0] = 0;
                }
                // if(this.onchangeid == 1)
                // {
                //     if(this.township_id == -1)
                //     {
                //         this.townshipID[0] = 0;
                //     }
                //     else{
                //         this.townshipID[0] = this.township_id;
                //         this.township_id = -1;
                //     }
                // }
                // else{

                //     this.township_id = -1;
                // }
           

                // this.moving_in = -1;
                // this.per_month = -1;
               
             
                // if ($('#search-free-word').val() != '')
                // {
                    // this.id = -1;
                //     var search_word = $('#search-free-word').val();
                  
                // }
               
               
              
                 var  search_word= 'null';

                if(localStorage.getItem("nursing_fav") == null){

                    this.locast = 0;
                }
                else{
                    this.locast = localStorage.getItem("nursing_fav");
                }

                 this.searchword = '';
      
                 this.axios.get('api/getnursingsearch/'+search_word,{
              
                params:{
                    id: this.id,
                    townshipID:this.township_id,
                    // townshipID:this.townshipID,
                    SpecialFeatureID:this.SpecialFeatureID,
                    MedicalAcceptanceID:this.MedicalAcceptanceID,
                    FacTypeID:this.FacTypeID,
                    MoveID:this.MoveID,
                    Moving_in:this.moving_in,
                    Per_month:this.per_month,
                    local:this.locast,
                },
                }).then((response)=>{
                this.nus_data = response.data.nursing;
                this.specialfeature = response.data.specialfeature;
                this.medicalacceptance = response.data.medicalacceptance;
                this.factype = response.data.factype;
                this.searchmarkers = response.data.nursing;
                this.citylatlng = response.data.getCity;
                this.markers = response.data.nursing;
                var mmarker = new Array()
                var item = []
                if(this.map != null){
                    var map = this.map
                    var callback = function(feature) {
                            map.data.remove(feature);
                    };
                    map.data.forEach(callback);
                }
                if(this.nus_data.length > 0){
                    for (var i = 0; i < this.searchmarkers.length; i++) {
                        mmarker.push([this.searchmarkers[i]['alphabet'], this.searchmarkers[i]['lat'], this.searchmarkers[i]['lng']])
                        item.push(this.searchmarkers[i])
                    }
                    const theCity = this.searchmarkers[0]['city_eng'].trim();
                    const lat = this.searchmarkers[0]['lat']
                    const lng = this.searchmarkers[0]['lng']

                    // google map
                    this.coordinates(theCity,lat,lng)
                    this.infoWindow(item, mmarker);
                    this.norecord_msg = false;
                }
                else{
                    //if choose city
                    if(this.citylatlng.length > 0)
                    {
                        const theCity = this.citylatlng[0]['city_eng'].trim();
                        const lat = this.citylatlng[0]['latitude']
                        const lng = this.citylatlng[0]['longitude']
                        this.coordinates(theCity,lat,lng);
                        this.infoWindow(item, mmarker);
                    }
                    else{
                        var mapProp = {
                        center: new google.maps.LatLng(35.6804, 139.7690),
                        zoom: 5,
                        mapTypeId: google.maps.MapTypeId.ROADMAP,
                        };
                        this.map = new google.maps.Map(document.getElementById("mymap"), mapProp);
                    }
                    this.norecord_msg = true;
                }
                if (this.nus_data > this.size){
                this.show_paginate = true;
              }else {
                this.show_paginate = false;
              }
                });
            },
            // hover animate function
            mouseover(index) {
                for (let i = 0; i < this.markerHover.length; i++) {
                    if(this.markers[i]['alphabet'] == index)
                    {
                    this.markerHover[i].setAnimation(google.maps.Animation.BOUNCE);
                    }
                }
            },

            mouseleave(index){
                for (let i = 0; i < this.markerHover.length; i++) {
                    if(this.markers[i]['alphabet'] == index)
                    {
                    this.markerHover[i].setAnimation(null);
                    }
                }
            },

//  google map  function end========================================

            features(e) {
                if (e.target.checked) {

                }
            },

            getStateHover(e) {
                // if(e.target.tagName ==='AREA'){
                //  console.log(e)
                // }
            },

            imgUrlAlt(event) {
                event.target.src = "images/noimage.jpg"
            },

            favAddFun(status,index,ind){
                if(status == 'add'){
                    this.nus_data[ind].fav_check = 'check';

                    if(localStorage.getItem("nursing_fav")){
                        var fav_arr = JSON.parse("[" + localStorage.getItem("nursing_fav") + "]");
                        fav_arr.push(index);
                        fav_arr = [...new Set(fav_arr)];
                        localStorage.setItem("nursing_fav", fav_arr);
                        // $("#nus-fav-local").html(fav_arr.length);
                        this.nusFav = fav_arr.length;
                    }
                    else{
                        var fav_arr = [index];
                        localStorage.setItem("nursing_fav", fav_arr);
                        // $("#nus-fav-local").html(fav_arr.length);
                        this.nusFav = fav_arr.length;
                    }

                    $(".fav-nursing-link-box>a").css({'cursor':'pointer','pointer-events':'auto'});
                }
                else{
              
                    this.nus_data[ind].fav_check = '';

                    var fav_arr = JSON.parse("[" + localStorage.getItem("nursing_fav") + "]");
                    var index = fav_arr.indexOf(index);
                    if (index > -1) {
                        fav_arr.splice(index, 1);
                        localStorage.setItem("nursing_fav", fav_arr);
                    }
                    // $("#nus-fav-local").html(fav_arr.length);
                    this.nusFav = fav_arr.length;

                    if(fav_arr.length == 0){
                        $(".fav-nursing-link-box>a").css({'cursor':'not-allowed','pointer-events':'none'})
                    }
                    else{
                        $(".fav-nursing-link-box>a").css({'cursor':'pointer','pointer-events':'auto'})
                    }

                }
            },

            first() {
                this.currentPage = 0;
                const page = Math.ceil(this.nus_data.length / this.size);
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
                    const page = Math.ceil(this.nus_data.length / this.size);
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
                    const page = Math.ceil(this.nus_data.length / this.size);
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
                    const page = Math.ceil(this.nus_data.length / this.size);
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
                    const page = Math.ceil(this.nus_data.length / this.size);
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

            ChangeTownship(){
              
                this.townshipID = [];
                if(localStorage.getItem("nursing_fav") == null){
                    this.locast = 0;
                }
                else{
                    this.locast = localStorage.getItem("nursing_fav");
                }
                 if(this.SpecialFeatureID == null || this.SpecialFeatureID == '')
                {
                this.SpecialFeatureID[0] = 0;
                }
                if(this.MedicalAcceptanceID == null || this.MedicalAcceptanceID == '')
                {
                this.MedicalAcceptanceID[0] = 0;
                }
                if(this.FacTypeID == null || this.FacTypeID == '')
                {
                this.FacTypeID[0] = 0;
                }
                if(this.MoveID == null || this.MoveID == '')
                {
                this.MoveID[0] = 0;
                }

                this.axios.get('api/getmap',{
                        params:{
                        id: this.id,
                        township_id:-1,
                        moving_in:-1,
                        per_month:-1,
                        local:this.locast,
                        feature:'nursing',
                        SpecialFeatureID:this.SpecialFeatureID,
                        MedicalAcceptanceID:this.MedicalAcceptanceID,
                        FacTypeID:this.FacTypeID,
                        MoveID:this.MoveID,

                    
                  
                    },
                })
                .then((response) => {
                    $('.hospitalselect').removeClass('hospitalselect');
                    this.cities = response.data.city
                    this.getCity = response.data.getCity
                    this.getTownships = response.data.getTownships
                    this.special_features = response.data.special_features
                    this.subjects = response.data.subjects;
                    //   this.sub_child = response.data.sub_child;
                    //console.log("aaa",this.subjects);
                    // this.id = id;
                })
                    // this.search();
            },
        }
  };
</script>

<style scoped>
.result-span {
    color: #23a2f5;
}
.overlay{ 
  top: 0;
  background-color: rgba(0, 0, 0, 0.19);
  position: relative;
  background: #000;
  width: 100%;
  height: 400px;
}
.select {
    display: none;
}
.toBeToggled {
    display: block;
}
.toBeToggled2 {
    display: block;
}
.toBeToggled1 {
    display: none;
}
.table th,
.table td {
    border-top: none !important;
}
#nursing-search table>tbody>tr th {
    background-color: #e8e7e7;
    width: 140px;
    padding: 25px;
}
label {
    color: black !important;
}
#mymap {
    width: 100%;    
}
div#holder {
    position: absolute;
}
.hidden {
    display: none;
}
.card_1 {
    display: inline-block;
    box-shadow: 0 1px 2px 0 rgba(0, 0, 0, .15);
    margin: 20px;
    position: relative;   
    transition: all .2s ease-in-out;
}
.card_1:hover {   
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.19), 0 6px 6px rgba(0, 0, 0, 0.23);   
}
.image {
    height: 200px;
    opacity: .7;
    overflow: hidden;
    transition: all .2s ease-in-out;
}
.image:hover,
.card_1:hover .image {
    height: 200px;
    opacity: 1;
}
.text {
    background: #FFF;
    padding: 20px;
    min-height: 200px;
}
.text p {
    margin-bottom: 0px;
}
.fav-profile {
    top:0px;
    right:15px;
}
.offset{
  width: 500px !important;
  margin: 20px auto;
}
@media only screen and (max-width: 767px){
.select {
    display: block;
}
.profile_header, #searchMap {
    display: none;
}
#map-responsive {
    display: none;
}
}
</style>

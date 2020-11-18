<template>
    <div class="card profile m-t-22 border-none">
        <!-- <span style="position:fixed;right:50px;" class="btn secondary-bg-color all-btn" @click="createProfile()">作成</span> -->
        <form class="col-md-12 form-class pad-free-750" autocomplete="off">
            <div class="col-md-12 pad-free">
                <button v-scroll-to="{ el: '#btn'}" id="btn_click" hidden></button>
                <div class="row ">
                    <div class="col-lg-4 col-md-5">
                        <div class="form-group form-group-wrapper logo-area height-91">
                            <img :src="profile_img" id="thumbnil" class="profile_logo m-b-8 img-fluid fit-image-profile" alt="Logo"  @error="imgUrlAlt">                              
                            <div class="m-t-10">
                                <span class="btn-file d-inline-block">画像を選択                     
                                    <input type="file" name="" class ="customer-logo m-b-10" accept="image/*" id="customer-logo" @change="preview_image($event,'logo')">                                      
                                </span>                                      
                                <span id="imgname" class="d-inline-block align-top pl-2">{{nursing_info.logo}}</span>
                            </div>                                
                        </div>
                    </div>
                    <div class="col-lg-8 col-md-7">
                        <div class="form-group form-group-wrapper d-flex">
                            <label class="heading-lbl col-md-2 col-12 pad-free">施設名称<p class="error sp3 sp-t">必須</p></label>
                            <input type="text" class="form-control customer-name col-md-10 col-12 nursing_input" id="btn" placeholder="施設名称を入力してください。" v-model="nursing_info.name">
                        </div>
                        <div class="form-group form-group-wrapper d-flex">
                            <label class="heading-lbl col-md-2 col-12 pad-free">メールアドレス<p class="error sp3 sp-t2">必須</p></label>
                            <input type="text" class="form-control customer-email col-md-10 col-12 nursing_input" id="btn" v-model="nursing_info.email" @change="aggreBtn" @keyup="focusMail" placeholder="メールアドレスを入力してください。">
                        </div>                           
                            <span class="error pro-1" v-if="mail_focus || nursing_info.email =='' || nursing_info.email == null">※メールアドレスが正しくありません。</span>
                            <!-- <span v-else-if="this.nursing_info.email">sssss</span> -->                           
                        <div class="form-group form-group-wrapper d-flex">
                            <label class="heading-lbl col-md-2 col-12 pad-free">電話番号</label>                                
                            <input type="text" class="form-control customer-phone col-md-10 col-12 nursing_input" id="phone" placeholder="電話番号を入力してください。" v-model="nursing_info.phone"  @keyup="focusPhone" maxlength="13">
                        </div>                           
                        <span class="error pro-1" v-if="ph_length || ph_num">※電話番号が正しくありません。もう一度入力してください。</span>
                    </div>
                </div>
                <div class="form-group form-group-wrapper d-flex">
                    <label class="heading-lbl col-md-2 col-12 pad-free">公式サイト</label>
                    <input type="text" name="official-website" class="form-control website col-md-10 col-12 nursing_input" v-model="nursing_info.website">
                </div>
                <!-- <div class="form-group form-group-wrapper d-flex">
                        <label class="heading-lbl col-md-2 col-12 pad-free">運営事業者</label>
                        <input type="text" class="form-control customer-name col-md-10 col-12 nursing_input" id="btn" disabled v-model="nursing_info.cusname" placeholder="運営事業者を入力してください。">
                </div> -->

                <!-- start panorama area -->
                <div class="col-md-12 m-lr-0 pad-free">
                    <div class="form-group form-group-wrapper">
                        <div class="row m-0 mt-2 d-flex">
                            <label class="heading-lbl col-md-2 col-12 pad-free">パノラマ</label>
                            <div class="heading-lbl col-md-2 col-12 pad-free">
                                <span class="btn-file d-inline-block font-weight-normal">画像を選択                     
                                    <input type="file" name="img" class="nursing-panorama m-b-10" accept="image/*" id="upload_panorama" @change="preview_panorama()" multiple>
                                </span> 
                                <span id="imgname" class="d-inline-block align-top pl-2 text-truncate">{{img_name}}</span>
                            </div>
                        </div>
                        <div class="row col-md-12 pad-free panorama panorama-box">
                            <div class="col-4 col-sm-3 col-md-3 col-lg-1 mt-2 gallery-area-panorama pad-free" v-bind:id="'x-panorama'+indx" v-for="(img,indx) in panorama_arr" :key="img.id">
                                <input type="hidden" class="already-panorama" v-model="img.photo">
                                <span class='img-close-btn' v-on:click="DeleteArr(indx,'panorama',img.id,img.photo, 'パノラマ画像')">X</span>
                                <img :src="'/upload/nursing_profile/Imagepanorama/'+ img.photo" class="img-fluid panorama-old-img" alt="profile" v-if="img.id!=null"  id="already-panorama">
                                <img :src="img.path" class="img-fluid panorama-new-img" alt="profile" v-if="img.id==null" id="already-panorama">
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end panoram area -->
                <table class="table table-bordered table-wrapper">
                    <tr>
                        <th class="nursing_table pc-414-table sp-768-block border-none">
                            <label class="heading-lbl pad-free">特長</label>
                        </th>
                        <td  class="nursing_table1 pc-414-table sp-768-block border-none">
                            <!-- <textarea name="feature" id="" cols="30" rows="10" ></textarea> -->
                            <quill-editor  ref="myQuilEditor" name="feature" class="feature" v-model="nursing_info.feature" @change="onFeatureEditorChange($event)" :options="editorOption" @blur="onEditorBlur($event)" @focus="onEditorFocus($event)"/>
                        </td>
                    </tr>
                </table>

                <!--table 1 for 費用-->
                <table class="table table-bordered table-wrapper">
                    <tr>
                        <td class="border-none">
                            <div class="form-group">
                                <label class="heading-lbl heading-lbl-cost">費用</label>
                            </div>
                            <div class="form-group displayFlex m-b-0">
                                <label class="heading-lbl col-lg-2 col-md-2 pad-free">入居時費用</label>
                                <div class="col-12 col-lg-10 col-md-12 pad-free nursing-m-b-15">
                                    <div class="row">
                                        <div class="col-md-6 nursing_cost">
                                            <input type="text"  class="form-control col-10 nursing-moving-in-f float-left white-bg-color m-r-10" v-model="nursing_info.moving_in_from"><span class="cash-lbl"> 円</span>
                                        </div>
                                        <div class="col-md-6 nursing_cost">
                                            <input type="text"  class="form-control col-10 nursing-moving-in-t float-left white-bg-color m-r-10" v-model="nursing_info.moving_in_to"><span class="cash-lbl"> 円</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group displayFlex m-b-0">
                                <label class="heading-lbl col-lg-2 col-md-2 pad-free">月額費用</label>
                                <div class="col-12 col-lg-10 col-md-12 pad-free nursing-m-b-15">
                                    <div class="row">
                                        <div class="col-md-6 nursing_cost">
                                            <input type="text"  class="form-control col-10 nursing-per-month-f float-left white-bg-color m-r-10" v-model="nursing_info.per_month_from"><span class="cash-lbl"> 円</span>
                                        </div>
                                        <div class="col-md-6 nursing_cost">
                                            <input type="text"  class="form-control col-10 nursing-per-month-t float-left white-bg-color m-r-10" v-model="nursing_info.per_month_to"><span class="cash-lbl"> 円</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- <div class="form-group displayFlex clearfix">
                                <label class="heading-lbl col-lg-2 col-md-3 pad-free">支払い方法</label>
                                <div class="col-12 col-lg-10 col-md-12 pad-free nursing-m-b-15">
                                    <input type="text"  class="form-control col-md-9 col-12 nursing-payment-method float-left white-bg-color" v-model="nursing_info.method">
                                </div>
                            </div> -->
                            <div class="form-group">
                                <label class="headinglbl col-6 col-lg-2 col-md-3 pad-free">タイプ</label>
                                <div class="col-6 col-lg-10 float-right p-0 addbtn-right">
                                    <span class="nusing_btn1 btn all-btn main-bg-color" @click="methodAdd(this)"><i class="fas fa-plus-circle"></i>&nbsp;追加</span>
                                </div>
                                <div class="col-lg-10 col-md-12 float-right pad-free nursing-m-b-15">                                    
                                    <div class="col-md-12 pad-free nursing-gallery" id="gallery-payment">
                                        <div class="pad-free col-md-12 gallery-area-payment" v-bind:id="'payments'+indx" v-for="(payment,indx) in payment_arr" :key="payment.id">
                                            <div class="col-md-12 p-0">
                                                <table class="table m-b-0">
                                                    <tr>
                                                        <td colspan="2" class="text-right border-none">                                                        
                                                            <a class="mr-auto text-danger btn delete-borderbtn" @click="DeltArr(indx,'payment','タイプ')">
                                                            <i class="fa fa-trash"></i> 削除</a>
                                                            <span :class="'bg-trans btn dropdown-arrow changeLinkpayment'+indx" @click="mainToggle('payment',indx)">
                                                                詳細 <i :id="'payment'+indx" v-bind:class="[payment.id != null? 'fas fa-sort-down animate rotate':'fas fa-sort-down']"></i>
                                                            </span>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th class="nursing_title_lbl">
                                                            <label class="title-lbl">タイプ名</label>
                                                        </th>
                                                        <th class="nursing_title_lbl">
                                                            <input type="text" name="method[]" class="form-control payment-name white-bg-color" v-model="payment.payment_name">
                                                        </th>
                                                    </tr>
                                                </table>
                                            </div>
                                            <div class="col-md-12 " v-bind:style="[payment.id != null? {'display':'none'}:{'display':'block'}]" :id="'changeLinkpayment'+indx">
                                                <div class="col-md-12">
                                                    <h3 class="title-lbl">料金概要</h3>
                                                    <table class="table">
                                                        <tr>
                                                            <th class="nursing_title_lbl font-weight-bold">入居時にかかる費用</th>
                                                            <th class="nursing_title_lbl">
                                                                <input type="text" name="exp[]" class="form-control col-mdexpense-moving white-bg-color" v-model="payment.expense_moving">
                                                            </th>
                                                        </tr>
                                                        <tr>
                                                            <th class="nursing_title_lbl font-weight-bold">居室タイプ</th>
                                                            <th class="nursing_title_lbl">
                                                                <input type="text" name="exp[]" class="form-control living-room-type white-bg-color" v-model="payment.living_room_type">
                                                            </th>
                                                        </tr>
                                                        <tr>
                                                            <th class="nursing_title_lbl font-weight-bold">月額利用料</th>
                                                            <th class="nursing_title_lbl">
                                                                <input type="text" name="exp[]" class="form-control monthly-fees white-bg-color" v-model="payment.monthly_fees">
                                                            </th>
                                                        </tr>
                                                        <tr>
                                                            <th class="nursing_title_lbl font-weight-bold">広さ</th>
                                                            <th class="nursing_title_lbl">
                                                                <input type="text" name="exp[]" class="form-control area white-bg-color" v-model="payment.area">
                                                            </th>
                                                        </tr>
                                                    </table>
                                                </div>
                                                <div class="col-md-12">
                                                    <h3 class="title-lbl">料金詳細</h3>
                                                    <table class="table">
                                                        <tr>
                                                            <th class="title-lbl">
                                                                <span>入居にかかる費用</span>
                                                            </th>
                                                            <th>&nbsp;</th>
                                                        </tr>
                                                        <tr>
                                                            <th class="nursing_title_lbl font-weight-bold">入居一時金または敷金</th>
                                                            <th class="nursing_title_lbl">
                                                                <input type="text" name="breakdown[]" class="form-control deposit white-bg-color" v-model="payment.deposit">
                                                            </th>
                                                        </tr>
                                                        <tr>
                                                            <th class="nursing_title_lbl font-weight-bold">その他（使途）</th>
                                                            <th class="nursing_title_lbl">
                                                                    <input type="text" name="breakdown[]" class="form-control other-use white-bg-color" v-model="payment.other_use">
                                                            </th>
                                                        </tr>
                                                        <tr>
                                                            <th class="title-lbl"><span>月額費用</span></th><th>&nbsp;</th>
                                                        </tr>
                                                        <tr>
                                                            <th class="nursing_title_lbl font-weight-bold">賃料</th>
                                                            <th class="nursing_title_lbl">
                                                                <input type="text" name="breakdown[]" class="form-control rent white-bg-color" v-model="payment.rent">
                                                            </th>
                                                        </tr>
                                                        <tr>
                                                            <th class="nursing_title_lbl font-weight-bold">管理費</th>
                                                            <th class="nursing_title_lbl">
                                                                <input type="text" name="breakdown[]" class="form-control admin-expense white-bg-color" v-model="payment.admin_expense">
                                                            </th>
                                                        </tr>
                                                        <tr>
                                                            <th class="nursing_title_lbl font-weight-bold">食費</th>
                                                            <th class="nursing_title_lbl">
                                                                <input type="text" name="breakdown[]" class="form-control food-expense white-bg-color" v-model="payment.food_expense">
                                                            </th>
                                                        </tr>
                                                        <tr>
                                                            <th class="nursing_title_lbl font-weight-bold">介護上乗せ金（生活サービス費）</th>
                                                            <th class="nursing_title_lbl">
                                                                <input type="text" name="breakdown[]" class="form-control nurse-care-surcharge white-bg-color" v-model="payment.nurse_care_surcharge">
                                                            </th>
                                                        </tr>
                                                        <tr>
                                                            <th class="nursing_title_lbl font-weight-bold">その他</th>
                                                            <th class="nursing_title_lbl">
                                                                <input type="text" name="breakdown[]" class="form-control other-monthly-cost white-bg-color" v-model="payment.other_monthly_cost">
                                                            </th>
                                                        </tr>
                                                        <tr>
                                                            <th class="title-lbl"><span>返還金について</span></th>
                                                            <th>&nbsp;</th>
                                                        </tr>
                                                        <tr>
                                                            <th class="nursing_title_lbl font-weight-bold">返還制度</th>
                                                            <th class="nursing_title_lbl">
                                                                <input type="text" name="breakdown[]" class="form-control refund-system white-bg-color" v-model="payment.refund_system">
                                                            </th>
                                                        </tr>
                                                        <tr>
                                                            <th class="nursing_title_lbl font-weight-bold">償却期間</th>
                                                            <th class="nursing_title_lbl">
                                                                <input type="text" name="breakdown[]" class="form-control depreciation-period white-bg-color" v-model="payment.depreciation_period">
                                                            </th>
                                                        </tr>
                                                        <tr>
                                                            <th class="nursing_title_lbl font-weight-bold">初期償却</th>
                                                            <th class="nursing_title_lbl">
                                                                <input type="text" name="breakdown[]" class="form-control initial-deprecration white-bg-color" v-model="payment.initial_deprecration">
                                                            </th>
                                                        </tr>
                                                        <tr>
                                                            <th class="nursing_title_lbl font-weight-bold">その他メッセージ</th>
                                                            <th class="nursing_title_lbl">
                                                                <input type="text" name="breakdown[]" class="form-control other-message-refund white-bg-color" v-model="payment.other_message_refund">
                                                            </th>
                                                        </tr>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                </table>
                <!-- end table 1 for 費用--->

                <!--table 2 for 施設の概要-->
                <table class="table table-bordered table-wrapper">
                    <tr>
                        <td class="border-none">
                            <label class="headinglbl col-6 col-lg-2 col-md-3 pad-free">施設の概要</label>
                            <span class="bg-trans btn dropdown-arrow nursing_toggle_responsive" @click="nurseFacToggleDiv()">
                                詳細 <i class="fas fa-sort-down animate"  :class="{'rotate': isRotate1}"></i>
                            </span>                            
                            <!-- testtest -->
                            <div class="col-xl-10 col-md-12 col-12 pad-free float-right nurse-fac-toggle-div toggle-div m-t-10">
                                <div class="date-witdh-410">
                                    <div class="date-label">開設年月日</div>
                                    <div class="datepicker">                                       
                                        <date-picker class="box date-of-establishment" :lang="lang" v-model="nursing_info.date_of_establishment" id="datepickerbox" valueType="format"></date-picker>
                                    </div>
                                </div>
                                <table class="table table-striped table-bordered nursing_table_title">
                                    <tr>
                                        <td class="width15 title-bg font-weight-bold">事業主体</td>
                                        <td ><textarea class="form-control white-bg-color business-entity" :options="editorOption" v-model="nursing_info.business_entity"></textarea></td>
                                        <!-- <td> <quill-editor class="business-entity" ref="myQuilEditor" :options="editorOption" v-model="nursing_info.business_entity"/></td> -->

                                    </tr>
                                    <tr class="dateTime">
                                        <td class="width15 title-bg font-weight-bold">開設年月日</td>
                                        <td >                                                    
                                            <date-picker class="date-of-establishment" :lang="lang" v-model="nursing_info.date_of_establishment" id="datepickerbox" valueType="format"></date-picker>
                                            <!-- <textarea class="form-control white-bg-color date-of-establishment" :options="editorOption" v-model="nursing_info.date_of_establishment"></textarea> -->
                                        </td>
                                        <!-- <td> <quill-editor  class="date-of-establishment" ref="myQuilEditor" :options="editorOption" v-model="nursing_info.date_of_establishment"/></td> -->
                                    </tr>
                                    <tr>
                                        <td class="width15 title-bg font-weight-bold">土地の権利形態</td>
                                        <td ><textarea class="form-control white-bg-color land-right-form" :options="editorOption" v-model="nursing_info.land_right_form"></textarea></td>
                                        <!-- <td> <quill-editor  class="land-right-form" ref="myQuilEditor" :options="editorOption" v-model="nursing_info.land_right_form"/></td> -->
                                    </tr>
                                    <tr>
                                        <td class="width15 title-bg font-weight-bold">建物の権利形態</td>
                                        <td ><textarea class="form-control white-bg-color building-right-form" :options="editorOption" v-model="nursing_info.building_right_form"></textarea></td>
                                        <!-- <td> <quill-editor  class="building-right-form" ref="myQuilEditor" :options="editorOption" v-model="nursing_info.building_right_form"/></td> -->
                                    </tr>
                                    <tr>
                                        <td class="width15 title-bg font-weight-bold">敷地面積</td>
                                        <td ><textarea class="form-control white-bg-color site-area" :options="editorOption" v-model="nursing_info.site_area"></textarea></td>
                                        <!-- <td> <quill-editor  class="site-area" ref="myQuilEditor" :options="editorOption" v-model="nursing_info.site_area"/></td> -->
                                    </tr>
                                    <tr>
                                        <td class="width15 title-bg font-weight-bold">延床面積</td>
                                        <td ><textarea class="form-control white-bg-color floor-area" :options="editorOption" v-model="nursing_info.floor_area"></textarea></td>
                                        <!-- <td> <quill-editor  class="floor-area" ref="myQuilEditor" :options="editorOption" v-model="nursing_info.floor_area"/></td> -->
                                    </tr>
                                    <tr>
                                        <td class="width15 title-bg font-weight-bold">構造</td>
                                        <td ><textarea class="form-control white-bg-color construction" :options="editorOption" v-model="nursing_info.construction"></textarea></td>
                                        <!-- <td > <quill-editor  class="construction" ref="myQuilEditor" :options="editorOption" v-model="nursing_info.construction"/></td> -->
                                    </tr>
                                    <tr>
                                        <td class="width15 title-bg font-weight-bold">定員</td>
                                        <td ><textarea class="form-control white-bg-color capacity" :options="editorOption" v-model="nursing_info.capacity"></textarea></td>
                                        <!-- <td > <quill-editor  class="capacity" ref="myQuilEditor" :options="editorOption" v-model="nursing_info.capacity"/></td> -->
                                    </tr>
                                    <tr>
                                        <td class="width15 title-bg font-weight-bold">総居室・戸数</td>
                                        <td ><textarea class="form-control white-bg-color num-rooms" :options="editorOption" v-model="nursing_info.num_rooms"></textarea></td>
                                        <!-- <td > <quill-editor  class="num-rooms" ref="myQuilEditor" :options="editorOption" v-model="nursing_info.num_rooms"/></td> -->
                                    </tr>
                                    <tr>
                                        <td class="width15 title-bg font-weight-bold">居住の権利形態</td>
                                        <!-- <td ><textarea class="form-control white-bg-color residence-form" :options="editorOption" v-model="nursing_info.residence_form"></textarea></td> -->
                                        <td ><quill-editor  class="residence-form" ref="myQuilEditor" @change="onResidenceEditorChange($event)" :options="editorOption" v-model="nursing_info.residence_form"/></td>
                                    </tr>
                                    <tr>
                                        <td class="width15 title-bg font-weight-bold">類型</td>
                                        <td>
                                            <select class="form-control white-bg-color fac-type" v-model="nursing_info.fac_type">
                                                <option value='0'>施設タイプを選択</option>
                                                <option v-for="fac in fac_types" :key="fac.id" v-bind:value="fac.id" :selected="fac.id == nursing_info.fac_type">{{ fac.description }}</option>
                                            </select>
                                        </td>
                                        <!-- <td ><textarea class="form-control white-bg-color fac-type" :options="editorOption" v-model="nursing_info.fac_type"></textarea></td> -->
                                        <!-- <td > <quill-editor  class="fac-type" ref="myQuilEditor" :options="editorOption" v-model="nursing_info.fac_type"/></td> -->
                                    </tr>
                                    <tr>
                                        <td class="width15 title-bg font-weight-bold">入居条件</td>
                                        <td ><textarea class="form-control white-bg-color occupancy-condition" :options="editorOption" v-model="nursing_info.occupancy_condition"></textarea></td>
                                        <!-- <td > <quill-editor  class="occupancy-condition" ref="myQuilEditor" :options="editorOption" v-model="nursing_info.occupancy_condition"/></td> -->
                                    </tr>
                                    <tr>
                                        <td class="width15 title-bg font-weight-bold">居室区分・間取り等</td>
                                        <td><textarea class="form-control white-bg-color room-floor" :options="editorOption"  v-model="nursing_info.room_floor"></textarea></td>
                                        <!-- <td > <quill-editor  class="room-floor" ref="myQuilEditor" :options="editorOption"  v-model="nursing_info.room_floor"/></td> -->
                                    </tr>
                                    <tr>
                                        <td class="width15 title-bg font-weight-bold">居室設備</td>
                                        <td ><textarea class="form-control white-bg-color living-room-facilities" :options="editorOption" v-model="nursing_info.living_room_facilities"></textarea></td>
                                        <!-- <td > <quill-editor  class="equipment" ref="myQuilEditor" :options="editorOption" v-model="nursing_info.equipment"/></td> -->
                                    </tr>
                                    <tr>
                                        <td class="width15 title-bg font-weight-bold">共用施設・設備</td>
                                        <td ><textarea class="form-control white-bg-color equipment" :options="editorOption" v-model="nursing_info.equipment"></textarea></td>
                                        <!-- <td > <quill-editor  class="living-room-facilities" ref="myQuilEditor" :options="editorOption" v-model="nursing_info.living_room_facilities"/></td> -->
                                    </tr>
                                </table>
                            </div>
                        </td>
                    </tr>
                </table>
                <!-- end table 2 for 施設の概要 -->

                <!-- table 3 for 協力医療機関 -->
                <table class="table table-bordered table-wrapper">
                    <tr>
                        <td class="border-none">
                            <div class="form-group">
                                <label class="headinglbl col-6 col-lg-2 col-md-3 pad-free">協力医療機関</label>
                                <div class="col-6 col-lg-10 float-right p-0 addbtn-right">
                                    <span class="btn all-btn main-bg-color nusing_btn1" @click="cooperateAdd()">
                                    <i class="fas fa-plus-circle"></i> 追加</span>
                                </div>                               
                                <div class="nursing_btn col-xl-10 col-md-12 col-md-9 pad-free float-right ">     
                                    <div class="col-md-12 pad-free" id="gallery-cooperate">
                                        <!-- cooperation -->
                                        <div class="col-md-12 m-t-20 m-b-20 gallery-area-cooperate p-0" v-bind:id="'cooperated'+indx" v-for="(cooperate,indx) in cooperate_arr" :key="cooperate.id">
                                            <div class="clearfix margin-bottom750 m-b-30 text-align-right">                                                
                                                 <a class="mr-auto text-danger btn delete-borderbtn" @click="DeltArr(indx,'cooperate','協力医療機関')">
                                                <i class="fa fa-trash"></i> 削除</a>
                                                <span :class="'bg-trans btn dropdown-arrow changeLinkcooperate'+indx" @click="mainToggle('cooperate',indx)">
                                                    詳細 
                                                    <i :id="'cooperate'+indx" class="fas fa-sort-down"></i>                                                        
                                                </span>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-3 col-md-2 pad-free font-weight-bold">名前 <span class="error sp2">必須</span></label>
                                                <input type="text" class="form-control col-9 col-md-10 float-right cooperate-name white-bg-color" name="co-medical-header[]" v-model="cooperate.name">
                                            </div>
                                            <div :id="'changeLinkcooperate'+indx">
                                                <table class="table table-bordered nursing_table_title">
                                                <tr>
                                                    <th class="width15 title-bg">診療科目</th>
                                                    <th ><textarea class="form-control clinical-sub white-bg-color" name="clinical-sub" v-model="cooperate.clinical_subject"></textarea></th>
                                                </tr>
                                                <tr>
                                                    <th class="width15 title-bg">協力内容</th>
                                                    <th><textarea class="form-control details white-bg-color" name="details" v-model="cooperate.details"></textarea></th>
                                                </tr>
                                                <tr>
                                                    <th class="width15 title-bg">診療費用</th>
                                                    <th><textarea class="form-control expense white-bg-color" name="expense" v-model="cooperate.medical_expense"></textarea></th>
                                                </tr>
                                                <tr>
                                                    <th class="width15 title-bg">備考</th>
                                                    <th><textarea class="form-control remark white-bg-color" name="remark" v-model="cooperate.remark"></textarea></th>
                                                </tr>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                </table>
                <!-- end table 3 for 協力医療機関 -->

                <!-- table 4 for 医療面の受入れ  -->
                <table class="table table-bordered table-wrapper">
                    <tr>
                        <td>
                            <div class="form-group m-b-0">
                                <label class="headinglbl col-6 col-lg-2 col-md-3 pad-free">医療面の受入れ</label>
                                <span class="bg-trans btn dropdown-arrow nursing_toggle_responsive" @click="acceptanceList()">詳細 <i class="fas fa-sort-down animate" :class="{'rotate': isRotate2}"></i></span>
                                <div class="col-xl-10 col-md-12 float-right m-t-10 accept-toggle-div toggle-div pad-free">
                                    <label for="" class="m-r-15"><i class="fas fa-check green"></i> 受入れ可</label>
                                    <label for="" class="m-r-15"><i class="fas fa-times red"></i> 受入れ不可</label>
                                    <label for="" class="m-r-15"><i class="fas fa-adjust blue"></i> 応相談</label>
                                    <div class="row">
                                        <div class="col-md-6" v-for="medical in medical_acceptance" :key="medical.id">
                                            <div class="col-md-12 accept-box">
                                                {{medical.name}} {{medical.id}}
                                                <div class="nursing_radiobtn">
                                                    <label ><input type="radio"  class="medical-acceptance custom-radio" :name="'medical'+medical.id" :checked="medical.accept_checked" v-bind:value="'accept-'+medical.id"> <i class="fas fa-check green"></i></label>
                                                    <label ><input type="radio" class="medical-acceptance custom-radio " :name="'medical'+medical.id" :checked="medical.unaccept_checked" v-bind:value="'unaccept-'+medical.id"> <i class="fas fa-times red"></i></label>
                                                    <label ><input type="radio" class="medical-acceptance custom-radio" :name="'medical'+medical.id" :checked="medical.negotiate_checked" v-bind:value="'negotiate-'+medical.id"> <i class="fas fa-adjust blue"></i></label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group m-b-0">
                                        <label for="" class="font-weight-bold">備考</label>
                                        <!-- <textarea name="" class="form-control"></textarea> -->
                                        <quill-editor  ref="myQuilEditor" :options="editorOption" @change="onAcceptanceEditorChange($event)" name="" class="acceptance-remark" v-model="nursing_info.acceptance_remark"/>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                </table>
                <!-- end table 4 for 医療面の受入れ -->

                <!-- table 5 for 職員体制 -->
                <table class="table table-bordered table-wrapper">
                    <tr>
                        <td>
                            <label class="headinglbl col-6 col-lg-2 col-md-3 pad-free">職員体制</label>
                            <span class="bg-trans btn dropdown-arrow nursing_toggle_responsive " @click="staffToggleDiv()">
                                詳細 <i class="fas fa-sort-down animate" :class="{'rotate': isRotate3}"></i>
                            </span>
                            <div class="col-xl-10 col-md-12 col-12 pad-free float-right staff-toggle-div toggle-div m-t-10">
                                <table class="table table-striped table-bordered nursing_table_title">
                                    <tr>
                                        <td class="width15 title-bg font-weight-bold">介護に関わる職員体制（入居者：職員）</td>
                                        <td><textarea class="form-control staff white-bg-color" :options="editorOption" v-model="staff_info.staff"></textarea></td>
                                        <!-- <td><quill-editor  ref="myQuilEditor" class="staff" :options="editorOption" v-model="staff_info.staff"/></td>                                                       -->
                                    </tr>
                                    <tr>
                                        <td class="width15 title-bg font-weight-bold">介護職員</td>
                                        <td><textarea class="form-control nursing-staff white-bg-color" :options="editorOption" v-model="staff_info.nursing_staff"></textarea></td>
                                        <!-- <td><quill-editor  ref="myQuilEditor" class="nursing-staff" :options="editorOption" v-model="staff_info.nursing_staff"/></td> -->
                                    </tr>
                                    <tr>
                                        <td class="width15 title-bg font-weight-bold">夜間の最少職員数</td>
                                        <td><textarea class="form-control min-num-staff white-bg-color" :options="editorOption" v-model="staff_info.min_num_staff"></textarea></td>
                                        <!-- <td><quill-editor  ref="myQuilEditor" class="min-num-staff" :options="editorOption" v-model="staff_info.min_num_staff"/></td>                                                        -->
                                    </tr>
                                    <tr>
                                        <td class="width15 title-bg font-weight-bold">看護職員数</td>
                                        <td><textarea class="form-control num-staff white-bg-color" :options="editorOption" v-model="staff_info.num_staff"></textarea></td>
                                        <!-- <td><quill-editor  ref="myQuilEditor" class="num-staff" :options="editorOption" v-model="staff_info.num_staff"/></td> -->
                                    </tr>
                                    <tr>
                                        <td class="width15 title-bg font-weight-bold">
                                            <label for="">備考</label>
                                        </td>
                                        <td>
                                            <quill-editor  ref="myQuilEditor" name="" :options="editorOption" @change="onNursingEditorChange($event)" class="nursing-remarks" v-model="staff_info.remarks"/>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </td>
                    </tr>
                </table>
                <!-- end table 5 for 職員体制 -->

                <!-- table 6 for こだわりの特長  -->
                <table class="table table-bordered table-wrapper">
                    <tr>
                        <td>
                            <div class="form-group m-b-0">
                                <label  class="headinglbl col-6 col-lg-2 pad-free">こだわりの特長</label>
                                <span class="bg-trans btn dropdown-arrow nursing_toggle_responsive" @click="specialFeAdd()">
                                    詳細 <i class="fas fa-sort-down animate" :class="{'rotate': isRotate4}"></i>
                                </span>
                                <div class="col-xl-10 col-md-12 float-right special-feature-toggle-div toggle-div m-t-10">
                                    <div class="row">
                                        <div v-for="feat in feature_list" :key="feat.id" class="form-check form-check-inline col-6 col-md-4 col-lg-3">
                                            <label  class="padding-left-5 form-check-label control control--checkbox">
                                                <input type="checkbox" class="form-check-input"  name="special-features" v-bind:value="feat.id"  v-model="feat.checked">
                                                {{feat.name}}
                                                <div class="control__indicator"></div>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                </table>
                <!-- end table 6 for こだわりの特長  -->

                <!-- start photo and video area -->
                <div class="form-group form-group-wrapper">
                    <label class="headinglbl col-6 col-lg-2 pad-free">フォトアルバム</label>                    
                    <span class='changeLinkphoto bg-trans btn dropdown-arrow nursing_toggle_responsive' @click="mainToggle('photo',null)" >
                        詳細 <i id="photo" class="fas fa-sort-down"></i>                        
                    </span>
                    <div id="changeLinkphoto"  class="row col-12 m-0 p-0">
                        <div class="col-12 col-lg-12 float-right p-0">
                            <span class="galleryadd btn all-btn main-bg-color float-right min-width-0" @click="galleryAdd()">
                                <i class="fas fa-plus-circle"></i> 追加
                            </span>
                        </div>                    
                        <div id ="gallery-photo" class="row col-12 pad-free m-0">
                            <div class="col-12 col-md-6 gallery-area-photo" v-bind:id="'photo'+indx" v-for="(img,indx) in img_arr" :key="img.id">
                                <div class="col-md-12">
                                    <span class="btn-file d-inline-block">画像を選択        
                                        <input type="file" name="" class="nursing-photo" accept="image/*" v-bind:class="img.classname" id="upload_img" @change="preview_image($event,indx)">
                                    </span> 
                                    <span class="d-inline-block align-top pt-2" v-bind:id="'img_name'+indx"></span>
                                    <div class="col-md-12  p0-480" v-bind:class="img.id">
                                        <input type="hidden" class="already-photo" v-model="img.photo">
                                        <img v-bind:src="img.src" class="img-fluid nursing-image" alt="profile" v-if="img.src!=null" @error="imgUrlAlt">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <label class="m-t-10 font-weight-bold">タイトル</label>
                                    <input type="text" name="title" placeholder="タイトル" class="form-control m-b-15 white-bg-color" v-model="img.title">
                                    <label class="font-weight-bold">コンテンツ</label>
                                    <textarea name="description" placeholder="コンテンツ" class="form-control m-b-15 description white-bg-color" v-model="img.description"></textarea>
                                </div>
                                <div class="col-md-12 text-right">
                                    <a class="mr-auto text-danger btn delete-borderbtn" @click="DeleteArr(indx,'photo',img.id,img.photo,'画像')"> <i class="fa fa-trash"></i> 削除</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>               
                <div class="form-group form-group-wrapper">
                    <label class="headinglbl col-6 col-lg-2 col-md-3 pad-free">動画</label>                                                      
                    <span class='changeLinkvideo  bg-trans btn dropdown-arrow nursing_toggle_responsive' @click="mainToggle('video',null)">
                        詳細 <i id="video" class="fas fa-sort-down"></i>
                    </span>
                    <div id="changeLinkvideo" class="row col-12 m-0 p-0">
                        <div class="col-12 col-lg-12 float-right p-0">
                            <span class="galleryadd btn all-btn main-bg-color float-right min-width-0" @click="galleryVideoAdd()">
                                <i class="fas fa-plus-circle"></i> 追加
                            </span>   
                        </div>                               
                        <div id="gallery-video" class="row col-12 pad-free m-0" >
                            <div class="col-12 col-md-6 gallery-area-video" v-bind:id="'video'+indx" v-for="(video,indx) in video_arr" :key="video.id">
                                <div class="col-md-12">
                                    <label class="font-weight-bold">URL</label>
                                    <input type="text" name="url" placeholder="url" class="form-control m-b-15 video-url white-bg-color" v-model="video.photo">
                                </div>
                                <div class="col-md-12">
                                    <label class="font-weight-bold">タイトル</label>
                                    <input type="text" name="title" placeholder="タイトル" class="form-control m-b-15 white-bg-color" v-model="video.title">
                                    <label class="font-weight-bold">コンテンツ</label>
                                    <textarea name="description" placeholder="コンテンツ" class="form-control m-b-15 description white-bg-color" v-model="video.description"></textarea>
                                </div>
                                <div class="col-md-12 text-right">
                                    <a class="mr-auto text-danger btn delete-borderbtn" @click="DeleteArr(indx,'video',video.id,video.photo,'動画')"> <i class="fa fa-trash"></i> 削除</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end photo and video area -->

                <!-- table 7 for 公式サイト -->
                <table class="table table-bordered table-wrapper">
                    <tr>
                        <td>
                            <label class="headinglbl col-6 col-lg-2 col-md-3 pad-free">地図</label>
                            <div class="col-6 col-lg-10 float-right p-0">
                                <span class="bg-trans btn dropdown-arrow nursing_toggle_responsive" @click="maptogglediv()">詳細 <i class="fas fa-sort-down animate" :class="{'rotate': isRotate5}"></i></span>
                            </div>                            
                            <div class="col-xl-10 col-md-12 float-right m-t-10 map-toggle-div toggle-div pad-free">
                                <div class="col-md-12 p-0">
                                    <div class="col-md-12 pad-free" id="mapbox">
                                        <span class="error pro-1 nus-profile-err" v-if="loc == true">※都道府県と市区町村をを入力してください。</span>
                                        <GoogleMap :address="address_show" :township="nursing_info.townships_id" :city="city_id" :township_list="township_list" :latnum='nursing_info.latitude' :lngnum='nursing_info.longitude'></GoogleMap>
                                    </div>                                   
                                    <div class="form-group m-b-0">
                                        <label class="font-weight-bold">交通 / アクセス</label>
                                        <!-- <textarea name="address" rows="10" class="form-control"></textarea> -->
                                        <quill-editor  ref="myQuilEditor" name="address" :options="editorOption" class="transporation-access" @change="onAccessEditorChange($event)" v-model="nursing_info.access"/>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                </table>
                <!-- end table 7 for 公式サイト -->
                <div class="bottom-fixed-btn">
                    <div class="row justify-content-center">
                        <div class="col-8 col-md-3 col-lg-2">                            
                            <span class="btn secondary-bg-color col-8 offset-2 all-btn" @click="createProfile()" id="create-profile">保存</span>
                        </div>                        
                    </div>
                </div>
            </div>
        </form>
    </div>
</template>

<script>
import 'quill/dist/quill.snow.css'
import {quillEditor} from 'vue-quill-editor'
// import {Button, Input,Select} from 'iview'
import GoogleMap from './GoogleMap.vue' 

export default {    
    components: {
        GoogleMap,
        quillEditor,
        // Button,
        // Input,
        // Select,
        email:''
    },
    errors: [],      
    data() {
        return {               
            lang:{
                days: ['日', '月', '火', '水', '木', '金', '土'],
                months: ['1月', '2月', '3月', '4月', '5月', '6月', '7月', '8月', '9月', '10月', '11月', '12月'],
                placeholder: {
                    // date: new Date().toISOString().slice(0,10),
                    date: '年 - 月 - 日', 
                },               
            },
            isRotate1: false, isRotate2: false, isRotate3: false, isRotate4: false, isRotate5: false, fac_list: [], feature_list:[], medical_acceptance:[], nursing_info:[],nursing_info_push:[], staff_info:[], staff_info_push:[], acceptance: [], img_arr:[], video_arr:[], panorama_arr:[], tmp_list:[],test:[], cooperate_arr:[], cooperate_list:[], payment_arr:[],payment_list:[], profile_type:'nursing', profile_arr:[], test:'', station_list:[],chek_feature : [], panorama_count:'0', fac_types:[], stations:[], count:-1, v_count: -1, c_count: -1, p_count: -1, type:'', title:[], v_title:[], description:[], v_description:[], img:[], sub:[], coop_details:[], expense:[],remark:[], method:[],move_in:[],room_type:[],monthly_usage:[],breadth:[], security_deposit:[],other_use:[], rent:[], management_fee:[], food_expense:[],life_service:[],cost_other:[],return_system:[], depreciation_period:[],initial_depreciation:[],other_message:[], cooperate_list:[], payment_list:[],meth_details:[], content: '', 
            editorOption:{ debug:'info', placeholder:'', readonly:true, theme:'snow',
                modules: {
                    toolbar: [
                        ['bold', 'italic', 'underline', 'strike'],
                        ['blockquote', 'code-block'],
                        [{ 'header': 1 }, { 'header': 2 }],
                        [{ 'list': 'ordered' }, { 'list': 'bullet' }],
                        [{ 'script': 'sub' }, { 'script': 'super' }],
                        [{ 'indent': '-1' }, { 'indent': '+1' }],
                        [{ 'direction': 'rtl' }],
                        [{ 'color': [] }, { 'background': [] }],
                        [{ 'align': [] }],
                        ['clean'],
                        ['link', 'image', 'video']
                    ]
                },
            }, feature_val: '', acceptance_remark_val: '', nursing_remarks_val: '', residence_form_val: '', customer_address_val:'', access_val: '', panorama_length: 0, new_panorama_img: [], ph_length: false, ph_num: false, city_id: 0, township_list: [], address_show: '', img_name:'',profile_img:'', pro_id: 0, btn_disable: false, mail_focus: false, loc: false,
                mail_reg: /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,24}))$/,
                phone_reg: /^([0-9]*)$/
        }
    },        
    mounted() {
        document.getElementById('btn_click').click();
    },
    created(){       
        this.pro_id = Number(this.$route.params.id);
        this.type = this.$route.params.type;       
        this.initialCall();
    },
    methods: {
        initialCall(){
            this.address_show = $('#address_show').val();                
            this.axios
            .get('/api/nursinginfo/'+this.pro_id)
            .then(response=>{
                console.log(response.data)                
                this.nursing_info = response.data;
                this.address_show = this.nursing_info.address;            
                this.profile_img = '/upload/nursing_profile/' +this.nursing_info.logo;
                this.axios
                .get('/api/nurscities/'+this.nursing_info.townships_id)
                .then(response=>{
                    this.city_id = Number(response.data[0].city_id);
                    this.township_list = response.data[0].township_list;
                    localStorage.setItem('townshiplist',JSON.stringify(this.township_list));
                });
                if(this.nursing_info.latitude == 0){
                    localStorage.setItem('lat_num',35.6803997);
                    localStorage.setItem('lng_num',139.76901739);
                }
                else{
                    localStorage.setItem('lat_num',this.nursing_info.latitude);
                    localStorage.setItem('lng_num',this.nursing_info.longitude);
                }
                this.focusMail();               
            });

            this.axios
            .get('/api/staffinfo/'+this.pro_id)
            .then(response=>{
                this.staff_info = response.data;
            });

            this.axios
            .get('/api/facilities')
            .then(response=>{
                this.fac_list = response.data;
            });

            this.axios
            .get('/api/facility_types')
            .then(response=>{
                this.fac_types = response.data;
            });

            this.axios
            .get('/api/medical/acceptancewithtransactions/'+this.pro_id)
            .then(response => {
                this.medical_acceptance = response.data;
            });

            this.axios
            .get('/api/feature/'+this.profile_type+'/'+this.pro_id)
            .then(response=>{
                this.feature_list = response.data;
            });

            this.axios
            .get('/api/pgallery/'+this.pro_id+'/nursing')
            .then(response=>{
                this.img_arr = response.data;
            });

            this.axios
            .get('/api/nursing-panorrama-gallery/'+this.pro_id)
            .then(response=>{
                this.panorama_arr = response.data;
                this.panorama_length = this.panorama_arr.length;
            });

            this.axios
            .get('/api/vgallery/'+this.pro_id+'/nursing')
            .then(response=>{
                this.video_arr = response.data;
            });

            this.axios
            .get('/api/nursing-cooperate/'+this.pro_id)
            .then(response=>{
                this.cooperate_arr = response.data;
            });

            this.axios
            .get('/api/nursing-payment/'+this.pro_id)
            .then(response=>{
                this.payment_arr = response.data;
            });
            
            this.$loading(false);
        },
        aggreBtn: function(){
            if((this.mail_reg.test(this.nursing_info.email)) && this.nursing_info.email != '' && this.nursing_info.email != null){
                this.btn_disable=false;
            }else{
                this.btn_disable=true;
            }
        },
        focusMail: function(event) {
            if((this.nursing_info.email != '' && this.mail_reg.test(this.nursing_info.email))){
                this.mail_focus=false;
            }else{
                this.mail_focus=true;
                
            }
            this.aggreBtn();        
        },
        focusPhone(){
            if(this.nursing_info.phone != '')
            {
                this.ph_num = false;
            }        
            if(this.nursing_info.phone != '' && (this.phone_reg).test(this.nursing_info.phone) && (this.nursing_info.phone.length >= 10 && this.nursing_info.phone.length <= 13))
            {            
                this.ph_length = false;            
            }
            else{        
                this.ph_length = true;
            }
            if(this.nursing_info.phone == '' || this.nursing_info.phone == null)
            {            
                this.ph_length = false;
            }

            //   var input_data = $('#phone').val();

            //   if(input_data.length == 0 || (input_data.length >= 10 && input_data.length <= 14 && input_data.charAt(input_data.length - 1) != '-' && input_data.charAt(0) != '-'))
            //   {
            //       this.ph_num = false;
            //       this.ph_length = false;
            //   }
            //   else{
            //       this.ph_num = true;
            //       this.ph_length = true;
            //   }
        },
        imgUrlAlt(event) {
            event.target.src = "/images/noimage.jpg"
        },

        onEditorBlur(quill) {

        },

        onEditorFocus(quill) {

        },

        maptogglediv() {
            $(".map-toggle-div").toggle('medium');
            this.isRotate5 = !this.isRotate5;
        },

        nurseFacToggleDiv() {
            $(".nurse-fac-toggle-div").toggle('medium');
            this.isRotate1 = !this.isRotate1;
        },

        staffToggleDiv() {
            $(".staff-toggle-div").toggle('medium');
            this.isRotate3 = !this.isRotate3;
        },
        preview_image(event,indx) {
            if(indx == 'logo') {
                this.nursing_info.logo = event.target.files[0].name;
                this.profile_img = URL.createObjectURL(event.target.files[0]);
                $('#customer-logo').text(event.target.files[0].name);
            } else {
                this.img_arr[indx]['photo'] = event.target.files[0].name;
                this.img_arr[indx]['src'] = URL.createObjectURL(event.target.files[0]);
                $('#img_name'+indx).text(event.target.files[0].name);
            }
        },
        preview_panorama() {
            const file =event.target.files[0];
            this.img_name = file.name;
            for(var i=0; i< event.target.files.length; i++) {
                var pathreal = URL.createObjectURL(event.target.files[i]);
                this.panorama_arr.push({id:null,type:"panorama",photo:event.target.files[i].name,title:'',description:'', path:pathreal, file:event.target.files[i]});
            }
        },

        closeBtnMethod: function(indx,id,photo) {
            if(confirm("Are you sure you want to delete?"))
            {
                if(id) {
                    this.panorama_arr.splice(indx, 1);
                    let fd = new FormData();
                    fd.append('id',id);
                    fd.append('type','panorama');
                    fd.append('photo',photo);
                    fd.append('customer_id',this.pro_id)
                    fd.append('custype','nursing')
                    this.axios
                    .post('/api/delete-pgallery',fd)
                    .then(response=>{
                        // this.panorama_arr = response.data;
                    });
                } else {
                    this.panorama_arr.splice(indx, 1);
                }
            }
        },
        DeltArr(indx,type,name) {
            this.$swal({
                text: name+ "を削除してよろしいでしょうか。",
                type: "warning",
                width: 350,
                height: 200,
                showCancelButton: true,
                confirmButtonColor: "#EEA025",
                cancelButtonColor: "#b1abab",
                cancelButtonTextColor: "#000",
                confirmButtonText: "はい",
                cancelButtonText: "キャンセル",
                confirmButtonClass: "all-btn",
                cancelButtonClass: "all-btn",
                allowOutsideClick: false,
            }).then(response => {
                    if(type == 'cooperate') {
                    this.cooperate_arr.splice(indx,1);
                }
                if(type == 'payment') {
                    this.payment_arr.splice(indx,1);
                }
            });
        },
        DeleteArr(indx,type,id,photo,name) {
            this.$swal({
                text: name + "を削除してよろしいでしょうか。",
                type: "warning",
                width: 350,
                height: 200,
                showCancelButton: true,
                confirmButtonColor: "#EEA025",
                cancelButtonColor: "#b1abab",
                cancelButtonTextColor: "#000",
                confirmButtonText: "はい",
                cancelButtonText: "キャンセル",
                confirmButtonClass: "all-btn",
                cancelButtonClass: "all-btn",
                allowOutsideClick: false,
            }).then(response => {
                if(type == 'photo' || type == 'panorama') {
                    if(id){
                        let fd = new FormData();
                        fd.append('id',id);
                        fd.append('type',type);
                        fd.append('photo',photo);
                        fd.append('customer_id',this.pro_id)
                        fd.append('custype','nursing')
                        if(type == 'photo'){
                            this.img_arr.splice(indx,1);
                        }
                        else{
                            this.panorama_arr.splice(indx, 1);
                        }
                        this.axios
                        .post('/api/delete-pgallery',fd)
                        .then(response=>{
                            this.$swal({
                                text: name + "を削除しました。",
                                type: "success",
                                width: 350,
                                height: 200,
                                confirmButtonText: "閉じる",
                                confirmButtonColor: "#31CD38",
                                allowOutsideClick: false,
                            });
                        })
                        .catch(error=>{
                            if(error.response.status == 422){
                                this.errors = error.response.data.errors
                            }
                        })
                    } else {
                        if(type == 'photo'){
                            this.img_arr.splice(indx,1);
                        }
                        else{
                            this.panorama_arr.splice(indx, 1);
                            this.img_name = '';
                        }
                    }
                }
                else if(type == 'video') {
                    this.video_arr.splice(indx,1);
                }
            })
        },
        galleryAdd() {
            this.img_arr.push({id:null,photo:'',title:'',description:'', src:null});
        },
        galleryVideoAdd() {
            this.video_arr.push({id:null,photo:'',title:'',description:''});
        },
        methodAdd() {
            this.payment_arr.push({id:null,payment_name:'',expense_moving:'',monthly_fees:'',living_room_type:'', area:'',details:'',deposit:'',other_use:'',rent:'',
            admin_expense:'',food_expense:'', nurse_care_surcharge:'',other_monthly_cost:'',refund_system:'',depreciation_period:'', initial_deprecration:'',
            other_message_refund:''});
        },
        cooperateAdd() {
            this.cooperate_arr.push({id:null,name:'',clinical_subject:'',details:'',medical_expense:'',remark:''});
        },
        acceptanceList() {
            $(".accept-toggle-div").toggle('medium');
            this.isRotate2 = !this.isRotate2;
        },
        specialFeAdd() {
            $(".special-feature-toggle-div").toggle('medium');
            this.isRotate4 = !this.isRotate4;
        },
        StationAdd() {
            $(".station-toggle-div").toggle('medium');
            this.isRotate4 = !this.isRotate4;
        },
        onDrop: function(e) {
            e.stopPropagation();
            e.preventDefault();
            var files = e.dataTransfer.files;
            this.createFile(files[0]);
        },
        onChange(e) {
            var files = e.target.files;
            this.createFile(files[0]);
        },
        createFile(file) {
            if (!file.type.match('image.*')) {            
                return;
            }
            var img = new Image();
            var reader = new FileReader();
            var vm = this;
            reader.onload = function(e) {
                vm.image = e.target.result;
            }
            reader.readAsDataURL(file);
        },
        removeFile() {
            this.image = '';
        },
        onFeatureEditorChange({ editor, html, text }) {
            this.nursing_info['feature'] = html
        },
        onNursingEditorChange({ editor, html, text }) {
            this.staff_info['remarks'] = html
        },
        onAcceptanceEditorChange({ editor, html, text }) {
            this.nursing_info['acceptance_remark'] = html
        },
        onResidenceEditorChange({ editor, html, text }) {
            this.nursing_info['residence_form'] = html
        },
        onAccessEditorChange({ editor, html, text }) {
            this.nursing_info['access'] = html
        },

        mainToggle(type,id) {            
            if(id == null) { id =''; }
            var class_by_id = $('#'+type+id).attr('class');            
            if(class_by_id == "fas fa-sort-down animate rotate")
            {
                $('#'+type+id).removeClass("fas fa-sort-down animate rotate");                   
                $('#'+type+id).addClass("fas fa-sort-down");
                $('#changeLink'+type+id).show('medium');
                if(type == 'photo' || type == 'video') {
                    $('.gallery'+type).show();
                }                
            }
            else {
                $('#'+type+id).removeClass("fas fa-sort-down");
                $('.changeLink'+type+id).removeClass("fas fa-sort-down");
                $('#'+type+id).addClass("fas fa-sort-down animate rotate");
                $('#changeLink'+type+id).hide('medium');
                if(type == 'photo' || type == 'video') {
                    $('.gallery'+type).hide();
                }
            }
        },
        createProfile() {
            if($('#new_lat').val() == "" || $('#new_lat').val() == 0 || $('#new_long').val() == "" || $('#new_long').val() == 0 || $('#gmaptownship').val() == 0){
                this.loc = true;
                this.btn_disable = true;
                this.nursing_info.townships_id = $('#gmaptownship').val();
                // this.nursing_info.latitude = $('#new_lat').val();
                // this.nursing_info.longitude = $('#new_long').val();
                this.city_id = $('#division').val();
                this.township_list = JSON.parse(localStorage.getItem("townshiplist"));
            }
            else{
                this.loc = false;
                this.nursing_info.townships_id = $('#gmaptownship').val();
                this.nursing_info.latitude = $('#new_lat').val();
                this.nursing_info.longitude = $('#new_long').val();
                this.city_id = $('#division').val();
                this.township_list = JSON.parse(localStorage.getItem("townshiplist"));
                if(this.mail_focus != true && this.ph_num != true && this.nursing_info.name != '' && this.nursing_info.name != null){
                    this.btn_disable = false;
                }
                else{
                    this.btn_disable = true;
                }
            }            
            if(this.btn_disable){
                // console.log("mail");                
                this.$swal({
                    // title: "確認",
                    html: "保存できません。<br/>必須項目を確認してください。",
                    type: "error",
                    width: 350,
                    height: 200,
                    showCancelButton: false,
                    confirmButtonColor: "#FF5462",
                    confirmButtonText: "閉じる",
                    confirmButtonClass: "all-btn",
                    allowOutsideClick: false,            
                })                    
                this.nursing_info.townships_id = $('#gmaptownship').val();
                // this.nursing_info.latitude = $('#new_lat').val();
                // this.nursing_info.longitude = $('#new_long').val();
                this.city_id = $('#division').val();
                this.township_list = JSON.parse(localStorage.getItem("townshiplist"));  
    
            }
            else{              
                this.$loading(true);
                this.profile_arr = [];
                this.nursing_info.latitude = $('#new_lat').val();
                this.nursing_info.longitude = $('#new_long').val();
                this.nursing_info.address = $('#address_show').val();
                this.address_show = $('#address_show').val();
                this.nursing_info.townships_id = Number($('#gmaptownship').val());
                localStorage.setItem('lat_num',this.nursing_info.latitude);
                localStorage.setItem('lng_num',this.nursing_info.longitude);

                // Photo
                let pt = new FormData();
                var img = document.getElementsByClassName('gallery-area-photo');
                for(var i =this.img_arr.length-1;i>=0;i--)
                {
                    this.img_arr[i]['type'] = 'photo';
                    if(this.img_arr[i]['photo'] == null || this.img_arr[i]['photo'] == '')
                    {
                        this.img_arr.splice(i,1);
                    }
                    var file = img[i].getElementsByClassName('nursing-photo')[0].files[0];
                    if(file) {
                        pt.append(i ,file )
                    }
                }
                this.axios.post('/api/nursing/movephoto', pt)
                    .then(response => {
                    }).catch(error=>{
                        console.log(error);
                        if(error.response.status == 422){
                            this.errors = error.response.data.errors
                        }
                    })

                // Logo
                let lg = new FormData();
                if(document.getElementsByClassName('customer-logo')[0].files[0]) {
                    var file = document.getElementsByClassName('customer-logo')[0].files[0];
                    lg.append('logo',file);
                    this.axios.post('/api/nursing/movelogo', lg)
                    .then(response => {
                    }).catch(error=>{
                        console.log(error);
                        if(error.response.status == 422){
                            this.errors = error.response.data.errors
                        }
                    })
                }

                // Video
                for(var i =this.video_arr.length-1;i>=0;i--){
                    if(this.video_arr[i].photo == null || this.video_arr[i].photo == '' )
                    {
                        this.video_arr.splice(i,1);
                    }
                }

                // Cooperate
                for(var i =this.cooperate_arr.length-1;i>=0;i--){
                    if(this.cooperate_arr[i].name == null || this.cooperate_arr[i].name == '')
                    {
                        this.cooperate_arr.splice(i,1);
                    }
                }

                // Payment Method
                for(var i =this.payment_arr.length-1;i>=0;i--){
                    if(this.payment_arr[i].payment_name == null || this.payment_arr[i].payment_name == '')
                    {
                        this.payment_arr.splice(i,1);
                    }
                }

                var s_features =[];
                this.chek_feature = [];
                $.each($("input[name='special-features']:checked"), function(){
                    s_features.push($(this).val());
                });
                this.chek_feature.push({special_feature_id:s_features});
                var acceptance=[];
                $.each($("input:radio.medical-acceptance:checked"), function(){
                    var accept_val = $(this).val();
                    var tmp_arr = accept_val.split('-');
                    var type = tmp_arr[0];
                    var id = tmp_arr[1];
                    var type = tmp_arr[0];
                    var acceptance_id = tmp_arr[1];
                    acceptance.push({id:id,type:type});
                });

                // Panorama
                let fd = new FormData();
                for(var i = 0; i< this.panorama_arr.length; i++) {
                    if(this.panorama_arr[i]['path']!=''){
                        fd.append(i ,this.panorama_arr[i]["file"] )
                    }
                }

                this.axios.post('/api/nursing/movepanorama', fd)
                    .then(response => {
                    }).catch(error=>{
                        console.log(error);
                        if(error.response.status == 422){
                            this.errors = error.response.data.errors
                        }
                    })

                this.profile_arr.push({nursing_profile:this.nursing_info,staff_info:this.staff_info, cooperate_list:this.cooperate_arr,
                    payment_list:this.payment_arr, video:this.video_arr, image: this.img_arr, panorama: this.panorama_arr,
                    acceptance:acceptance,chek_feature:this.chek_feature
                });

                if(this.profile_arr.length > 0) {
                    this.axios
                    .post(`/api/nursing/profile/${this.pro_id}`,this.profile_arr)
                    .then((response) => {
                        this.initialCall();
                        this.$swal({
                            position: 'top-end',
                            type: 'success',
                            text: '保存されました。',
                            confirmButtonText: "閉じる",
                            confirmButtonColor: "#31cd38",
                            width: 350,
                            height: 200,
                            allowOutsideClick: false,
                        })
                    }).then(response => {
                        this.img_name = '';
                    })   
                    .catch(error=>{
                        this.$loading(false);
                        if(error.response.status == 422){
                            this.profile_arr = 'error';
                            this.errors = error.response.data.errors
                        }
                    }) ;
                }
            }
        },
        // isNumberOnly: function(event) {
        //     var input_data = $('#phone').val();
        //     var code = 0;
        //     code = input_data.charCodeAt();
        //     if((48 <= code && code <= 57) && (this.nursing_info.phone.length >= 10 && this.nursing_info.phone.length <= 14)){
        //         this.ph_num = false;
        //         this.ph_length = false;
        //     }else{
        //         this.ph_num = true;
        //         this.ph_length = true;
        //     }
        // }
    }
}

</script>

<style scoped> 
.gallery-area-panorama {  
    /* background: #e6e6e6;; */
    padding: 2px;
}
.panorama-old-img{
    height: 120px;
    background-size: cover;
    width: 260px;
}       
.panorama-new-img{       
    height: 120px;
    background-size: cover;
    width: 260px !important;
}  
.quill-editor{ 
    background-color: #fff; 
}          
.panorama-box {     
    margin: 0px; 
 }
.form-wrap .sp1,.sp3 {
    /* margin: 0 5px; */
    padding: 0 5px 0 5px;
    background: #F54336;
    font-size: 12px;
    color: #fff;
    font-weight: bold;
    border-radius: 3px;
    vertical-align: text-top;
    width: 35px;
}
.height-91 {
    height:91% !important;
}
.heading-lbl-cost {
    border-left: 5px solid #63b7ff !important;
    padding-left: 5px !important;
}
.padding-left-5 {
    padding-left:5px !important;
}
.nus-profile-err {
    margin-top:0px !important;
    margin-bottom:10px !important;
}

@media (max-width: 1440px){
    .panorama-old-img{      
        height: 85px !important;        
        width: 188px !important;
    } 
    .panorama-new-img{      
        height: 85px !important;        
        width: 188px !important;
    } 
}
@media (min-width: 992px) {
    .panorama-box .col-lg-1{
        -webkit-box-flex: 0;
        -ms-flex: 0 0 16.66666667%;
        flex: 0 0 16.66666667%;
        max-width: 16.66666667%;
        width: 294px !important
    }
}
@media screen and (max-width:580px){
    .d-flex{
        display:  block !important;
    }
    .panorama-box { 
        padding: 0px !important;  
        margin: 0px !important;          
    }
}
</style>

<template>
        <div class="col-md-12 pad-free m-b-10">
              <div class="col-md-12 pad-free nursing-m-b-15">
                <div class="col-md-12 pad-free postal-search">
                    <!-- <div class="form-group">
                        <div class="col-md-12 p-0 "><label class="font-weight-bold"> 郵便番号 </label></div>
                        <div class="col-md-12 row m-0 p-0">
                        <div class="col-md-6 pad-free">
                            <input type="text" v-model="comment.postal" v-on:keydown="postalNumber" name="postal" class="form-control white-bg-color" id="postal" placeholder="郵便番号を入力してください。" maxlength="7"/>                    
                        </div>
                        <div class="col-md-6 pad-free">
                            <span class="float-left submit1 btn main-bg-color continue all-btn submit m-l-10  m-l-480" @click="getPostal">郵便番号より住所を検索</span>
                            <span class="float-left m-l-10 m-l-768">例）1006740 (<a href="https://www.post.japanpost.jp/zipcode/" target="_blank" class="pseudolink">郵便番号検索</a>)</span>
                        </div>                       
                        </div>
                        <span id="jsErrorMessage" class="m-t-8"></span>
                  </div> -->
                    <div class="col-md-12 row p-0 m-0 m-b-10">
                        <div class="col-md-6 pad-free nursing-m-b-15 ">
                            <div class="col-md-12 p-0 "><label class="font-weight-bold"> 郵便番号 </label></div>
                            <div class="col-md-12 p-l-0 nursing_p-r-2">
                                <input type="text" v-model="comment.postal" v-on:keydown="postalNumber" name="postal" class="form-control white-bg-color" id="postal" placeholder="郵便番号を入力してください。" maxlength="7"/>                    
                            </div>
                        </div>
                        <div class="col-md-6 pad-free nursing-m-b-15">
                            <!-- <div class="col-md-12 p-r-0"><label class="font-weight-bold"></label></div> -->
                            <div class="col-md-12 p-r-0 nursing_map nursing_p-l-2">
                                <span class="col-md-6 submit1 btn main-bg-color continue all-btn submit m-l-480" @click="getPostal">郵便番号より住所を検索</span>
                                <span class="col-md-6 m-l-10 m-l-768">例）1006740 (<a href="https://www.post.japanpost.jp/zipcode/" target="_blank" class="pseudolink">郵便番号検索</a>)</span>
                            </div>
                        </div>
                        <span id="jsErrorMessage" class="m-t-8"></span>
                    </div>
                    <div class="col-md-12 row p-0 m-0">
                        <div class="col-md-6 pad-free nursing-m-b-15 ">
                            <div class="col-md-12 p-l-0 "><label class="font-weight-bold">  都道府県 <span class="error sp2">必須</span></label></div>
                            <div class="col-md-12 p-l-0 nursing_p-r-2">
                                <select v-model="city" class="division form-control" id="division" @change="cityChange('city',$event)">
                                  <option value="0">選択してください。</option>
                                    <option v-for="cities in city_list" :key="cities.id" v-bind:value="cities.id">
                                        {{cities.city_name}}
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6 pad-free nursing-m-b-15">
                            <div class="col-md-12 p-r-0"><label class="font-weight-bold">  市区町村 <span class="error sp2">必須</span></label></div>
                            <div class="col-md-12 p-r-0 nursing_p-l-2">
                                <select v-model="township" class="division form-control" id="gmaptownship">
                                  <option value="0">選択してください。</option>
                                    <option v-for="townships in township_list" :key="townships.id" v-bind:value="townships.id" ref="township">
                                        {{townships.township_name}}
                                    </option>
                                </select>
                            </div>
                        </div>
                    </div>
                  <div class="form-group m-t-10 ">
                    <label class="font-weight-bold">番地（建物名）</label> 
                    <div class="row">
                      <!-- <div class="col-md-12" v-if="status === '0'">
                        <input type="text" id="address_val" name="city" class="old-city form-control white-bg-color" placeholder="番地を入力してください。" v-model="address">
                      </div> -->
                      <div class="col-md-10 nursing-m-b-15">
           
                        <input type="text" id="address_show" name="city" class="city form-control white-bg-color" placeholder="番地を入力してください。" v-model="address">
                        <!-- <input type="text" id="address_val" class="hide form-control white-bg-color" v-model="address_val"> -->
                      </div>
                      <!-- <div class="col-md-2">
                        <span class="btn news-post-btn all-btn" @click="searchAddress()">番地検索</span>
                      </div> -->
                      <!-- <div class="col-md-2">
                        <span id="submit" class="btn secondary-bg-color all-btn" style="width:100%;" @click="initMap('clickfun')">住所より地図を検索</span>
                      </div> -->
                    </div>
                    <p class="m-l-768">例）丸の内1-9-1　グラントウキョウノースタワー40階</p>
                  </div>
                </div>
                <div class="form-group">
                  <h5 class="lbl-lat-lng">緯度経度や住所の指定または地図上のマーカの移動により施設の位置を指定してください</h5>
                    <div class="row col-md-12 m-0 p-l-0">
                      <div class="col-lg-3 col-md-12 hos_map_lbl p-r-0">
                        <label class="font-weight-bold">緯度 <span class="error sp2">必須</span></label>
                        <input type="text" class="form-control white-bg-color" name="new_lat" v-model="new_lat" id="new_lat" ref="new_lat">
                      </div>
                      <div class="col-lg-3 col-md-12 p-r-0">
                        <label class="font-weight-bold">経度 <span class="error sp2">必須</span></label>
                        <input type="text" class="form-control white-bg-color" name="new_long" v-model="new_long" id="new_long" ref="new_long">
                      </div>

                      <div class="nursing_map col-lg-3 col-md-12">
                        <span class="btn news-post-btn all-btn" style="width:100%;" @click="addressSelect(parseFloat(new_lat),parseFloat(new_long))">緯度経度より地図を検索</span>
                      </div>

                      <div class="nursing_map col-lg-3 col-md-12">
                        <span id="submit" class="btn news-post-btn all-btn" style="width:100%;" @click="initMap('clickfun')">住所より地図を検索</span>
                      </div>
                    </div>
                  </div>
              </div>
                            
              <div id="googlemap" ref="map"></div>
          
        </div>
</template>
<script>
export default {
  name: "GoogleMap",
  props:{
         address:String,
         township: Number,
         city: Number,
         latnum: Number,
         lngnum: Number,
         township_list: Array 
        },
  data () {
    return {
      geocoder: null,
      map: null,
      status:'0',
      markers: [],
      markerr: [],
      places: [],
      center:{},
      selected: '',
      new_lat: '',
      new_long: '',
      comment: {
        postal: '',
        city: '',
        gmap_city: ''
      },
      address_btn: false,
      city_list: [],
      address_val: '',
      test:'',
    //   selected_city:this.city,
    }
  },

mounted(){    
    this.center = { lat: parseFloat(35.6899624), lng: parseFloat(139.6915642) }      
},
  
  watch: {
    latnum(){
        if(this.latnum != undefined){                       
            this.mapCall();
            this.initMap();
        }
    }    
  },
  methods: { 
    initMap(c = null) {
        var _this = this;
        if(c == null){
            _this.new_lat = parseFloat(_this.latnum);
            _this.new_long = parseFloat(_this.lngnum);
            _this.map = new google.maps.Map(document.getElementById('googlemap'), {
            zoom: 12,
            center: _this.center,
            });

            var m = new google.maps.Marker({
              map: _this.map,
              draggable: true,
              position: {
                    lat: parseFloat(_this.latnum),
                    lng: parseFloat(_this.lngnum)
                }
            });
            m.addListener('dragend', function(e) {
                $('#new_lat').val(e.latLng.lat());
                $('#new_long').val(e.latLng.lng());
                _this.new_lat = e.latLng.lat();
                _this.new_long = e.latLng.lng();
            })
            _this.markerr.push(m);
            _this.geocoder = new google.maps.Geocoder();
        }
        else{
            _this.geocodeAddress(_this.geocoder, _this.map);
        }
                
    }, 
    geocodeAddress(geocoder,resultsMap) { 
        this.$loading(true);
        var tship = $('#gmaptownship option:selected').text();
        tship = tship.trim();
        var cty = $('#division option:selected').text();
        cty = cty.trim();
        var address = this.address+tship+cty;
        var _this = this;
        geocoder.geocode({'address': address}, function(results, status) {
          if (status === 'OK') {
            resultsMap.setCenter(results[0].geometry.location);
            
            for (var i = 0; i < _this.markerr.length; i++) {
                _this.markerr[i].setMap(null);
            }
            var m = new google.maps.Marker({
              map: resultsMap,
              draggable: true,
              position: results[0].geometry.location
            });
            m.addListener('dragend', function(e) {
                $('#new_lat').val(e.latLng.lat());
                $('#new_long').val(e.latLng.lng());
                _this.new_lat = e.latLng.lat();
                _this.new_long = e.latLng.lng();
            })
            _this.markerr.push(m);
            
            _this.new_lat = parseFloat(results[0].geometry.location.lat());
            _this.new_long = parseFloat(results[0].geometry.location.lng());
            _this.$loading(false);
          } else {
            alert('Geocode was not successful for the following reason: ' + status);
          }

        });
    },   
    
    
      mapCall(){       
        
        this.markers = [{
            position: {
                lat: parseFloat(this.latnum),
                lng: parseFloat(this.lngnum)
            }
            }];
        
        this.new_lat = parseFloat(this.latnum);
        this.new_long = parseFloat(this.lngnum);

        this.center = { lat: parseFloat(this.latnum), lng: parseFloat(this.lngnum) }    

        this.axios.get('/api/hospital/citiesList')
        .then(response => {
            this.city_list = response.data;
        });
    },
      
    // receives a place object via the autocomplete component
    addressSelect: function (lat_add,lng_add) {
        var _this = this;
        _this.new_lat = lat_add;
        _this.new_long = lng_add;
        _this.map.setCenter({lat: _this.new_lat, lng: _this.new_long});
            
        for (var i = 0; i < _this.markerr.length; i++) {
            _this.markerr[i].setMap(null);
        }
        var m = new google.maps.Marker({
            map: _this.map,
            draggable: true,
            position: {lat: _this.new_lat, lng: _this.new_long}
        });
        m.addListener('dragend', function(e) {
            $('#new_lat').val(e.latLng.lat());
            $('#new_long').val(e.latLng.lng());
            _this.new_lat = e.latLng.lat();
            _this.new_long = e.latLng.lng();
        })
        _this.markerr.push(m);
        
    },

    updateCoordinates(e) {
      $('#new_lat').val(e.latLng.lat());
      $('#new_long').val(e.latLng.lng());
      this.new_lat = e.latLng.lat();
      this.new_long = e.latLng.lng();
    },

    getPostal: function(event) {
      
                this.status = 1;
                if (this.comment.postal.length > 5) {
                    var postal = this.comment.postal;
                    this.axios
                        .post('/api/hospital/postList/' + postal)
                        .then(response => {
                            var post_data = response.data.postal_list;
                            var length = response.data.postal_list.length;
                            if (length > 0) {
                                var pref = post_data[0]['city_id'];

                                this.address =post_data[0]['street'];
                                // this.address_val = post_data[0]['pref']+post_data[0]['city']+post_data[0]['street'];
                                this.city = post_data[0]['city_id'];
                                this.cityChange('postal','');
                                this.township = response.data.township_id[0]['id'];
                            
                                $('#jsErrorMessage').html('<div></div>');
                            }else {
                                this.address ='';
                                this.township = 0;
                                this.city = 0;
                                $('#jsErrorMessage').html('<div class="error">郵便番号の書式を確認してください。</div>');
                            }
                        });
                }
            },
           
            cityChange(status,event){
              
                this.axios
                .get('/api/townshiplist/'+this.city)
                .then(response=>{
                  if(status != 'postal'){
                    // this.comment.postal = '';
                    this.comment.city = this.city_list[event.target.options.selectedIndex].city_name;
                    this.address ='';
                    this.township = 0;
                }
                    this.township_list = response.data.townships;
                    localStorage.removeItem('townshiplist');
                    localStorage.setItem('townshiplist',JSON.stringify(this.township_list));
                   
                });
            },
            postalNumber: function(event) {
                if(!(event.keyCode >= 48 && event.keyCode <= 57) && !(event.keyCode >= 96 && event.keyCode <= 105) 
                    && event.keyCode != 8 && event.keyCode != 46 && !(event.keyCode >= 37 && event.keyCode <= 40)) 
                {
                    event.preventDefault();
                }
            },

  }
};

</script>
<style scoped>
.lbl-lat-lng {
    margin: 15px 0px;
    font-weight: bold;
    border-left: 5px solid #2980b9;
    padding-left: 10px;
}
.hide{
  display: none;
}

</style>

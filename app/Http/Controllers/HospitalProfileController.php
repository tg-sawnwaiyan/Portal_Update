<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\HospitalProfile;
use App\Gallery;
use App\Schedule;
use DB;
use App\Medical;
use App\Category;
use App\Subject;
use App\Customer;
use App\SubjectJunctions;
use App\SpecialFeaturesJunctions;

class HospitalProfileController extends Controller
{
    function getFavouriteHospital($local_sto) 
    {
        $query = "SELECT hospital_profiles.* , '' AS schedule_am, '' AS schedule_pm, group_concat(special_features_junctions.special_feature_id) AS special, group_concat(subject_junctions.subject_id) AS sub, townships.township_name, townships.city_id, cities.city_name FROM `hospital_profiles`
        LEFT JOIN townships ON townships.id = hospital_profiles.townships_id
        LEFT JOIN cities ON townships.city_id = cities.id
        LEFT JOIN special_features_junctions ON special_features_junctions.profile_id = hospital_profiles.id
        LEFT JOIN subject_junctions ON subject_junctions.profile_id = hospital_profiles.id
        WHERE hospital_profiles.activate=1 AND hospital_profiles.id IN (" . $local_sto . ") group by hospital_profiles.id";
        $fav_hospital = DB::select($query);
        foreach($fav_hospital as $fav) {
            $sfeature = $fav->special;
            if($sfeature != null){
                $sql = "SELECT short_name FROM special_features WHERE id IN (".$sfeature.")";
                $specialfeature = DB::select($sql);
                $fav->special = $specialfeature;
            }
            $subject = $fav->sub;
            if($subject != null){
                $sql = "SELECT name FROM subjects WHERE id IN (".$subject.")";
                $subjects = DB::select($sql);
                $fav->sub = $subjects;
            }
            $cId = $fav->id;
            $sql = "SELECT schedule.* FROM schedule WHERE schedule.profile_id = $cId AND schedule.part = 'am'";
            $schedule_am = DB::select($sql);
            $fav->schedule_am = $schedule_am;
            $sql = "SELECT schedule.* FROM schedule WHERE schedule.profile_id = $cId AND schedule.part = 'pm'";
            $schedule_pm = DB::select($sql);
            $fav->schedule_pm = $schedule_pm;
        }
        return $fav_hospital;
    }

    function getFavouriteNursing($local_sto) 
    {
        $query = "SELECT nursing_profiles.* , group_concat(special_features_junctions.special_feature_id) AS special,'' AS payment_method, townships.township_name, townships.city_id, cities.city_name FROM `nursing_profiles`
        LEFT JOIN townships ON townships.id = nursing_profiles.townships_id
        LEFT JOIN cities ON townships.city_id = cities.id
        LEFT JOIN special_features_junctions ON special_features_junctions.profile_id = nursing_profiles.id
        WHERE nursing_profiles.activate=1 AND nursing_profiles.id IN (" . $local_sto . ") group by nursing_profiles.id";
        $fav_nursing = DB::select($query);
        foreach($fav_nursing as $nur) {
            if($nur->special != null){
                $sfeature = $nur->special;
                $cId = $nur->id;
                if($sfeature != null){
                    $sql = "SELECT short_name FROM special_features WHERE id IN (".$sfeature.")";
                    $specialfeature = DB::select($sql);
                    $nur->special = $specialfeature;
                }            
                $sql = "SELECT * FROM method_payment WHERE profile_id = $cId";
                $payment = DB::select($sql);
                $nur->payment_method = $payment;                
            }
        }
        return $fav_nursing;
    }

    public function getPostalList($postal)
    {
        $postal = (int)$postal;
        $query = "SELECT * FROM zipcode WHERE zip7_code LIKE '".$postal."'";
        $postal_list = DB::select($query);
        if(count($postal_list)>0){
            $township = "SELECT id from townships where township_name LIKE '". $postal_list[0]->city ."'";
            $township_id = DB::select($township);
        }   
        else{
            $township_id = null;
        }
        return response()->json(Array('postal_list'=>$postal_list,'township_id'=>$township_id));
    }

    public function getCitiesName() 
    {
        $query = "SELECT cities.id, cities.city_name FROM cities";
        $city_list = DB::select($query);
        return $city_list;
    }

    public function getTownshipName()
    {
        $query = "SELECT id,township_name from townships";
        $township_list = DB::select ($query);
        return $township_list;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $hospital = HospitalProfile::where('id',$id)->first();
        return response()->json($hospital);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $favourite_list = HospitalProfile::find($id);
        $favourite_list->delete();
        return response()->json('The successfully deleted');
    }

    public function movePhoto(Request $request) 
    {
        $request = $request->all();
        foreach ($request as $file){
            $imageName = $file->getClientOriginalName();
            $imageName = str_replace(' ', '', $imageName);
            $imageName = strtolower($imageName);
            $destination = 'upload/hospital_profile/'.$imageName;
            $upload_img = move_uploaded_file($file, $destination);
        }        
    }
    
    public function profileupdate($id,Request $request) 
    {
        $request = $request->all();
        $subject = [];
        for($i=0;$i<count($request[0]['subjects'][0]['subject_id']);$i++)
        {    
            $subject[$i] = Subject::where('id',$request[0]['subjects'][0]['subject_id'][$i])->value('name');    
        }
        // Hospital Profile
        $hospital = HospitalProfile::where('id',$id)->first();
        $hospital->name = $request[0]['hospital_info']['name'];
        $hospital->logo = $request[0]['hospital_info']['logo'];
        $hospital->email = $request[0]['hospital_info']['email'];
        $hospital->phone = $request[0]['hospital_info']['phone']; 
        $hospital->address = $request[0]['hospital_info']['address'];  
        $hospital->townships_id = $request[0]['hospital_info']['townships_id'];
        $hospital->access = $request[0]['hospital_info']['access'];
        $hospital->specialist =  $request[0]['hospital_info']['specialist'];
        $hospital->details_info=  $request[0]['hospital_info']['details_info'];
        $hospital->closed_day =  $request[0]['hospital_info']['closed_day'];
        $hospital->facilities =  $request[0]['facilities'];
        $hospital->website =  $request[0]['hospital_info']['website'];
        $hospital->congestion =  $request[0]['hospital_info']['congestion'];
        $hospital->latitude =  $request[0]['hospital_info']['latitude'];
        $hospital->longitude =  $request[0]['hospital_info']['longitude'];   
        $hospital->subject = implode($subject, ',');
        $hospital->save();
       // End 
        // Schedule 
        $schedule = Schedule::where('profile_id', $id)
                    ->delete();
        for($i=0; $i<2; $i++) {
            if($i == 0) { $part = 'am'; } else { $part = 'pm'; }
            $data = array(
                'profile_id' => $id,
                'mon' => $request[0]['schedule_list'][$i][0],
                'tue' => $request[0]['schedule_list'][$i][1],
                'wed' => $request[0]['schedule_list'][$i][2],
                'thu' => $request[0]['schedule_list'][$i][3],
                'fri' => $request[0]['schedule_list'][$i][4],
                'sat' => $request[0]['schedule_list'][$i][5],
                'sun' => $request[0]['schedule_list'][$i][6],
                'part' => $part,
                'created_at' => date('Y/m/d H:i:s'),
                'updated_at' => date('Y/m/d H:i:s') 
            );
            DB::table('schedule')->insert($data);
        // End
        }
        // Special Feature
        $feature = SpecialFeaturesJunctions::where('profile_id', $id)
                    ->delete();
        for($indx=0; $indx<count($request[0]['chek_feature'][0]['special_feature_id']); $indx++) {
            $new_feature = new SpecialFeaturesJunctions();
            $new_feature->profile_id = $id;
            $new_feature->special_feature_id = $request[0]['chek_feature'][0]['special_feature_id'][$indx];
            $new_feature->save();
        }
        // End
        // SubjectJuncitonsUpdate 
        $subject = SubjectJunctions::where('profile_id', $id)
                    ->delete();
        for($indx=0; $indx<count($request[0]['subjects'][0]['subject_id']); $indx++) {
            $new_subject = new SubjectJunctions();
            $new_subject->profile_id = $id;
            $new_subject->subject_id = $request[0]['subjects'][0]['subject_id'][$indx];
            $new_subject->save();
        }
        // End
         // Gallary 
         $del_gallery = Gallery::where(['profile_id'=> $id,'type'=>'video', 'profile_type'=>'hospital'])->delete(); 
         if(count($request[0]["video"]) > 0){
            for($i=0; $i<count($request[0]["video"]); $i++) {
                $gallery = new Gallery;
                $gallery->profile_id = $id;
                $gallery->profile_type = 'hospital';
                $gallery->type = $request[0]["video"][$i]['type'];
                $gallery->photo = $request[0]["video"][$i]['photo'];
                $gallery->title = $request[0]["video"][$i]['title'];
                $gallery->description = $request[0]["video"][$i]['description'];
                $gallery->save();
            }
        }
        $del_gallery = Gallery::where(['profile_id'=> $id,'type'=>'photo', 'profile_type'=>'hospital'])->delete(); 
        if(count($request[0]["image"]) > 0){
            for($i=0; $i<count($request[0]["image"]); $i++) {
                $gallery = new Gallery;
                $gallery->profile_id = $id;
                $gallery->profile_type = 'hospital';
                $gallery->type = $request[0]["image"][$i]['type'];
                $gallery->photo = $request[0]["image"][$i]['photo'];
                $gallery->title = $request[0]["image"][$i]['title'];
                $gallery->description = $request[0]["image"][$i]['description'];
                $gallery->save();
            }
        }
        return response()->json('success');
    }
}
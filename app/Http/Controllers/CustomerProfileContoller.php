<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class CustomerProfileContoller extends Controller
{
    function getHospitalHistory($local_sto) {
        $query = "SELECT hospital_profiles.* , group_concat(special_features_junctions.special_feature_id) AS special, group_concat(subject_junctions.subject_id) AS sub, '' AS schedule_am, '' AS schedule_pm, townships.township_name, townships.city_id, cities.city_name FROM `hospital_profiles`
        LEFT JOIN townships ON townships.id = hospital_profiles.townships_id
        LEFT JOIN cities ON townships.city_id = cities.id
        LEFT JOIN special_features_junctions ON special_features_junctions.profile_id = hospital_profiles.id
        LEFT JOIN subject_junctions ON subject_junctions.profile_id = hospital_profiles.id
        WHERE hospital_profiles.activate=1 AND hospital_profiles.id IN (" . $local_sto . ") group by hospital_profiles.id";
        $hos_histories = DB::select($query);
        foreach($hos_histories as $hos) {
            $sfeature = $hos->special;
            if($sfeature != null){
                $sql = "SELECT short_name FROM special_features WHERE id IN (".$sfeature.")";
                $specialfeature = DB::select($sql);
                $hos->special = $specialfeature;
            }  
            $subject = $hos->sub;
            if($subject != null){
                $sql = "SELECT name FROM subjects WHERE id IN(".$subject.")";
                $subjects = DB::select($sql);
                $hos->sub = $subjects;
            }  
            $cId = $hos->id;
            $sql = "SELECT schedule.* FROM schedule WHERE schedule.profile_id = $cId AND schedule.part = 'am'";
            $schedule_am = DB::select($sql);
            $hos->schedule_am = $schedule_am;
            $sql = "SELECT schedule.* FROM schedule WHERE schedule.profile_id = $cId AND schedule.part = 'pm'";
            $schedule_pm = DB::select($sql);
            $hos->schedule_pm = $schedule_pm;        
        }
        return $hos_histories;
    }

    function getNursingHistory($local_sto) {
        $query = "SELECT nursing_profiles.*, group_concat(special_features_junctions.special_feature_id) AS special,'' AS payment_method, townships.township_name, townships.city_id, cities.city_name FROM `nursing_profiles`
        LEFT JOIN townships ON townships.id = nursing_profiles.townships_id
        LEFT JOIN cities ON townships.city_id = cities.id
        LEFT JOIN special_features_junctions ON special_features_junctions.profile_id = nursing_profiles.id
        WHERE nursing_profiles.activate=1 AND nursing_profiles.id IN (" . $local_sto . ") group by nursing_profiles.id";
        $nur_histories = DB::select($query);
        foreach($nur_histories as $nur) {
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
        return $nur_histories;
    }
}

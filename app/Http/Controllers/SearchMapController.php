<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Customer;
use DB;

class SearchMapController extends Controller
{
    public function getMap()
    {
      
        $id = $_GET['id'];
        $township_id = $_GET['township_id'];
        $moving_in = $_GET['moving_in'];
        $per_month = $_GET['per_month'];
        $localst = $_GET['local'];
        if($localst != 0)
        {
          $local = explode(',',$localst);
        }
        else{

            $local = 0;
        }

        $query = "SELECT '' as fav_check,'' as alphabet,n.id as nursing_id,n.id,n.latitude as lat ,n.longitude as lng, n.*,c.*,c.id as cus_id,ci.city_name,t.township_name,ty.name AS type_name
                    FROM nursing_profiles AS n
                    JOIN customers AS c  ON c.id = n.customer_id
                    LEFT JOIN townships AS t  ON t.id = c.townships_id
                    LEFT JOIN cities AS ci ON t.city_id = ci.id
                    LEFT JOIN types AS ty ON c.type_id = ty.id
                    LEFT JOIN special_features_junctions as spej on spej.customer_id = n.customer_id  
                    LEFT JOIN special_features as spe on spe.id = spej.special_feature_id
                    LEFT JOIN acceptance_transactions as acct on acct.customer_id = n.customer_id
                    LEFT JOIN medical_acceptance as med on med.id = acct.medical_acceptance_id
                    WHERE";

      
            if($id != null && $township_id == -1 && $moving_in == -1 && $per_month == -1 ){
                $query .= " t.city_id=" . $id ;    
            }
            else if($id != null && $township_id != -1 && $moving_in == -1 && $per_month == -1){
                $query .= " t.city_id=" . $id . " and t.id =".$township_id;
            }
            else if($id != null && $township_id == -1 && $moving_in != -1 && $per_month == -1){
                $query .= " t.city_id=" . $id . " and n.moving_in_to <= ".$moving_in;
            }
            else if ($id != null && $township_id == -1 && $moving_in == -1 && $per_month != -1){
                $query .= " t.city_id=" . $id . " and n.per_month_to <= ".$per_month;
            }
            else if ($id != null && $township_id == -1 && $moving_in != -1 && $per_month != -1){
                $query .= " t.city_id=" . $id . " and n.per_month_to <= ".$per_month." and n.moving_in_to <= ".$moving_in;
            }
            else if ($id != null && $township_id != -1 && $moving_in != -1 && $per_month != -1){
                $query .= " t.city_id=" . $id . " and t.id =".$township_id." and n.moving_in_to <= ".$moving_in." and n.per_month_to <= ".$per_month;
            }
            else if($id != null && $township_id != -1 && $moving_in != -1 && $per_month == -1){
                $query .= " t.city_id=" . $id . " and t.id =".$township_id." and n.moving_in_to <= ".$moving_in;
            }
            else if($id != null && $township_id != -1 && $moving_in == -1 && $per_month != -1){
                $query .= " t.city_id=" . $id . " and t.id =".$township_id." and n.per_month_to <= ".$per_month;
            }

            $query .= " group by c.id order BY n.id ASC LIMIT 26";


          $nursing_profile = DB::select($query);


         //to bind fav_nursing
         if(isset($nursing_profile)){
            for($i = 0;$i<count($nursing_profile);$i++)
            {
                $arr[] = ( $nursing_profile[$i]->nursing_id);                
            }
            if($local != 0)
            {
                for($i = 0;$i<count($local);$i++)
                {
                    $local_arr = (string)($local[$i]);
                    if(isset($arr)){
                        if(in_array($local_arr, $arr))
                        {
                            $nus_id = array_search($local_arr,$arr);
                            $nursing_profile[$nus_id]->fav_check = "check";                    
                        }
                    }              
                }
            }
         }    
         
        $alphabet = ["A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R", "S", "T", "U", "V", "W", "X", "Y", "Z"];

        for($i = 0;$i<count($nursing_profile);$i++)
        {
            for($j=0;$j<count($alphabet);$j++)
            {
                if($i == $j)
                {
                    $nursing_profile[$i] =  (array)($nursing_profile[$i]) ;
                    $nursing_profile[$i]['alphabet']  = $alphabet[$j];
                   
                }
            }
        }

     

       

        $city               = DB::table('cities')->get();
        $getCity            = DB::table('cities')->where('id', $id)->get();
        $getTownships       = DB::table('townships')->where('city_id', $id)->get();
        $special_features   = DB::table('special_features')->get();
        $fac_types          = DB::table('fac_types')->get();
        $subs = "SELECT *,'' as child from subjects where parent = " . 0 ." order by id";
        $subjects = DB::select($subs);

       
        foreach($subjects as $sub)
        {
            $id = $sub->id;
            $db_sub = "SELECT subjects.* from subjects where parent =". $id ." order by id";
            $subchild = DB::select($db_sub);
            $sub->child = $subchild;
        }
      
   
        $medical_acceptance = DB::table('medical_acceptance')->get();
        $occupations        = DB::table('occupation')->get();


      
        return response()->json([
            'getTownships' => $getTownships,
            'getCity' => $getCity,
            'city' => $city,
            'special_features' => $special_features,
            'fac_types' => $fac_types,
            'medical_acceptance' => $medical_acceptance,
            'subjects' => $subjects,
            'occupations' => $occupations,
            'nursing' => $nursing_profile,
            'alphabet' => $alphabet
        ]);
    }

    

    public function getNursingSearch($searchword)
    {

          //for city
          $id = $_GET['id'];
          $Moving_in = $_GET['Moving_in'];
          $Per_month = $_GET['Per_month'];
          $localst = $_GET['local'];
          if($localst != 0)
          {
            $local = explode(',',$localst);
          }
          else{

              $local = 0;
          }

          $query = "SELECT '' as fav_check,'' as alphabet, n.id as nursing_id,n.latitude as lat ,n.longitude as lng,c.id as cus_id,c.*,n.*, ci.id as city_id, ci.city_eng,ci.city_name,t.township_name,ty.name AS type_name 
                    from nursing_profiles as n  
                    left join customers as c on c.id = n.customer_id 
                    left join types AS ty ON c.type_id = ty.id
                    left join townships as t on t.id = c.townships_id
                    left join cities as ci on ci.id = t.city_id
                    left join fac_types as f on f.id = n.fac_type 
                    left join special_features_junctions as spej on spej.customer_id = n.customer_id  
                    left join special_features as spe on spe.id = spej.special_feature_id
                    left join acceptance_transactions as acct on acct.customer_id = n.customer_id
                    left join medical_acceptance as med on med.id = acct.medical_acceptance_id where ";

          if($id == -1)
          {
             if($searchword != 'all')
             {
                $query .= " (n.method like '%" . $searchword . "%' or n.business_entity like '%".$searchword."%') group by c.id";
             }
             else{
                 
                $query = "SELECT '' as fav_check,'' as alphabet, n.id as nursing_id,n.latitude as lat ,n.longitude as lng,c.id as cus_id,c.*,n.*, ci.id as city_id, ci.city_eng,ci.city_name,t.township_name,ty.name AS type_name 
                            from nursing_profiles as n  
                            left join customers as c on c.id = n.customer_id 
                            left join types AS ty ON c.type_id = ty.id
                            left join townships as t on t.id = c.townships_id
                            left join cities as ci on ci.id = t.city_id
                            left join fac_types as f on f.id = n.fac_type 
                            left join special_features_junctions as spej on spej.customer_id = n.customer_id  
                            left join special_features as spe on spe.id = spej.special_feature_id
                            left join acceptance_transactions as acct on acct.customer_id = n.customer_id
                            left join medical_acceptance as med on med.id = acct.medical_acceptance_id 
                            group by c.id ";
             }
          }
          else
          {
                //to check if township is check or not 
                $townshipID = $_GET['townshipID'];
                if ($townshipID[0] == '0' && count($townshipID) == 1) //get param value of hospitalsearch.vue and if value is 0 and count =1 , this condition is "No Check"
                {
                    $townshipID = '0';
                } else if ($townshipID[0] == '0' && count($townshipID) > 1) { //if count > 1, this condition is  "Check and Remove an item of array [0] and implode array 
                    unset($townshipID[0]);
                    $townshipID = implode(',', $townshipID);
                } else {
                    $townshipID = implode(',', $townshipID); // this condition is when array[0] has no '0'
                }

                //to check if specialfeature is check or not 
                $SpecialFeatureID = $_GET['SpecialFeatureID'];
                if ($SpecialFeatureID[0] == '0' && count($SpecialFeatureID) == 1) //get param value of nursingsearch.vue and if value is 0 and count =1 , this condition is "No Check"
                {
                    $SpecialFeatureID = '0';
                } else if ($SpecialFeatureID[0] == '0' && count($SpecialFeatureID) > 1) { //if count > 1, this condition is  "Check and Remove an item of array [0] and implode array 
                    unset($SpecialFeatureID[0]);
                    $SpecialFeatureID = implode(',', $SpecialFeatureID);
                } else {
                    $SpecialFeatureID = implode(',', $SpecialFeatureID); // this condition is when array[0] has no '0'
                }

                //to check if medicalacceptance is check or not 
                $MedicalAcceptanceID = $_GET['MedicalAcceptanceID'];
                if ($MedicalAcceptanceID[0] == '0' && count($MedicalAcceptanceID) == 1) //get param value of nursingsearch.vue and if value is 0 and count =1 , this condition is "No Check"
                {
                    $MedicalAcceptanceID = '0';
                } else if ($MedicalAcceptanceID[0] == '0' && count($MedicalAcceptanceID) > 1) { //if count > 1, this condition is  "Check and Remove an item of array [0] and implode array 
                    unset($MedicalAcceptanceID[0]);
                    $MedicalAcceptanceID = implode(',', $MedicalAcceptanceID);
                } else 
                {
                    $MedicalAcceptanceID = implode(',', $MedicalAcceptanceID); // this condition is when array[0] has no '0'
                }

                //to check if factype is check or not 
                $FacTypeID = $_GET['FacTypeID'];
                if ($FacTypeID[0] == '0' && count($FacTypeID) == 1) //get param value of nursingsearch.vue and if value is 0 and count =1 , this condition is "No Check"
                {
                    $FacTypeID = '0';
                } else if ($FacTypeID[0] == '0' && count($FacTypeID) > 1) { //if count > 1, this condition is  "Check and Remove an item of array [0] and implode array 
                    unset($FacTypeID[0]);
                    $FacTypeID = implode(',', $FacTypeID);
                } else {
                    $FacTypeID = implode(',', $FacTypeID); // this condition is when array[0] has no '0'
                }

                //to check if movingin is check or not 
                $MoveID = $_GET['MoveID'];
                if ($MoveID[0] == '0' && count($MoveID) == 1) //get param value of nursingsearch.vue and if value is 0 and count =1 , this condition is "No Check"
                {
                    $MoveID = '0';
                } else if ($MoveID[0] == '0' && count($MoveID) > 1) { //if count > 1, this condition is  "Check and Remove an item of array [0] and implode array 
                    unset($MoveID[0]);
                    $MoveID = implode(',', $MoveID);
                } else {
                    $MoveID = implode(',', $MoveID); // this condition is when array[0] has no '0'
                }


             

                $query .= " ci.id = ".$id;

                if($townshipID != 0 )
                {
                    $query .=   " and t.id in (".$townshipID.")";
                }
                if($SpecialFeatureID != 0)
                {
                    $query .= " and spe.id in (".$SpecialFeatureID.") ";
                }
                if($MedicalAcceptanceID != 0)
                {
                    $query .= " and med.id in (".$MedicalAcceptanceID.")";
                }
                if($FacTypeID != 0)
                {
                    $query .= " and f.id in (".$FacTypeID.")";
                }
                if($MoveID !== '0')
                {
                    $MoveID = explode(',', $MoveID);
                    if(count($MoveID) == 3) 
                    {
                        $query .= " and ( n.occupancy_condition like '%".(String)$MoveID[0]."%'  or n.occupancy_condition like '%".$MoveID[1]."%'  or n.occupancy_condition like '%".$MoveID[2]."%' ) ";
                    
                    }  
                    else  if(count($MoveID) == 2)
                    {
                        
                        $query .= " and ( n.occupancy_condition like '%".(String)$MoveID[0]."%'  or n.occupancy_condition like '%".$MoveID[1]."%' )";
                        
                    }
                    else if(count($MoveID) ==1 )
                    {
                        
                        $query .= " and ( n.occupancy_condition like '%".(String)$MoveID[0]."%' ) ";
                                
                    }
                }

                if($Moving_in != -1)
                {
                    $query .= " and n.moving_in_to <= " .$Moving_in;
                }
                if($Per_month != -1)
                {
                    $query .= " and n.per_month_to <= " .$Per_month;
                }


                $query .= " group by c.id";
          }


            $nus_data = DB::select($query);
          
           //to bind fav_nursing
            for($i = 0;$i<count($nus_data);$i++)
            {
                $arr[] = ( $nus_data[$i]->nursing_id);
               
            }
            
            if($local != 0)
            {
                for($i = 0;$i<count($local);$i++)
                {
                    $local_arr = (string)($local[$i]);
                   
                    if(in_array($local_arr, $arr))
                    {
                       $id = array_search($local_arr,$arr);
                       $nus_data[$id]->fav_check = "check";
                      
                    }
                  
                }
            }

           

            $spe_query = "SELECT spe.*,spej.customer_id from  special_features as spe join special_features_junctions as spej on spe.id = spej.special_feature_id";
            $specialfeature = DB::select($spe_query);

            $med_query = "SELECT med.*,acc.customer_id from acceptance_transactions as acc join medical_acceptance as med on acc.medical_acceptance_id = med.id";
            $medicalacceptance = DB::select($med_query);
            
            $fac_query = "SELECT fac.* from nursing_profiles as n   join fac_types  as fac on fac.id = n.fac_type";
            $factype = DB::select($fac_query);
            
            $alphabet = ["A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R", "S", "T", "U", "V", "W", "X", "Y", "Z"];

            for($i = 0;$i<count($nus_data);$i++)
            {
                for($j=0;$j<count($alphabet);$j++)
                {
                    if($i == $j)
                    {
                        $nus_data[$i] =  (array)($nus_data[$i]) ;
                        $nus_data[$i]['alphabet']  = $alphabet[$j];
                    
                    }
                }
            }

            $city               = DB::table('cities')->get();
            $getCity            = DB::table('cities')->where('id', $id)->get();
            $getTownships       = DB::table('townships')->where('city_id', $id)->get();
            $special_features   = DB::table('special_features')->get();
            $fac_types          = DB::table('fac_types')->get();
            $subjects           = DB::table('subjects')->where('parent',0)->get();
            $sub_child          = DB::table('subjects')->get();
            $medical_acceptance = DB::table('medical_acceptance')->get();
            $occupations        = DB::table('occupation')->get();
            
            return response()->json(array("nursing"=>$nus_data,
                                          "specialfeature"=>$specialfeature,
                                          "medicalacceptance"=>$medicalacceptance,
                                          "factype"=>$factype,
                                          "city"=>$city,
                                          'getTownships' => $getTownships,
                                          'getCity' => $getCity,
                                          'special_features' => $special_features,
                                          'fac_types' => $fac_types,
                                          'medical_acceptance' => $medical_acceptance,
                                          'subjects' => $subjects,
                                          'sub_child' => $sub_child,
                                          'occupations' => $occupations,
                                          'alphabet' => $alphabet

                                        ));


     }



    public function getHospitalSearch($searchword)
    {
       
        //for city
        $id = $_GET['id'];
        $townshipID = $_GET['townshipID'];
        $specialfeatureID = $_GET['specialfeatureID'];
        $subjectID = $_GET['subjectID'];
        
          
          $query ="SELECT h.id as hos_id, c.id as cus_id, h.*,c.*
                  from  hospital_profiles as h 
                  join customers as c on h.customer_id = c.id 
                  left join townships as t on t.id = c.townships_id  
                  left join cities as ci on ci.id = t.city_id
                  left join special_features_junctions as spej on spej.customer_id = c.id 
                  left join special_features as spe on spe.id = spej.special_feature_id
                  left join subject_junctions as subj on subj.customer_id = c.id
                  left join subjects as sub on sub.id = subj.subject_id      
                  where ";

        if($id == -1) 
        {
            if($searchword == "all") 
            {
                $query ="SELECT h.id as hos_id, c.id as cus_id, h.*,c.*
                        from  hospital_profiles as h     
                        join customers as c on h.customer_id = c.id 
                        left join townships as t on t.id = c.townships_id  
                        left join cities as ci on ci.id = t.city_id
                        left join special_features_junctions as spej on spej.customer_id = c.id 
                        left join special_features as spe on spe.id = spej.special_feature_id
                        left join subject_junctions as subj on subj.customer_id = c.id
                        left join subjects as sub on sub.id = subj.subject_id
                        group by c.id ";
            }
            else{

                $query .= " (ci.city_name like '%" . $searchword . "%' or t.township_name like '%" . $searchword . "%' or c.name like '%".$searchword."%') group by c.id";
            }
           
        }
        else
        {
           
               //to check if township is check or not 
            if ($townshipID[0] == '0' && count($townshipID) == 1) //get param value of hospitalsearch.vue and if value is 0 and count =1 , this condition is "No Check"
            {
                $townshipID = '0';
            } else if ($townshipID[0] == '0' && count($townshipID) > 1) { //if count > 1, this condition is  "Check and Remove an item of array [0] and implode array 
                unset($townshipID[0]);
                $townshipID = implode(',', $townshipID);
            } else {
                $townshipID = implode(',', $townshipID); // this condition is when array[0] has no '0'
            }

            //to check if specialfeature is check or not 
        
            if ($specialfeatureID[0] == '0' && count($specialfeatureID) == 1) //get param value of hospitalsearch.vue and if value is 0 and count =1 , this condition is "No Check"
            {
                $specialfeatureID = '0';
            } else if ($specialfeatureID[0] == '0' && count($specialfeatureID) > 1) { //if count > 1, this condition is  "Check and Remove an item of array [0] and implode array 
                unset($specialfeatureID[0]);
                $specialfeatureID = implode(',', $specialfeatureID);
            } else {
                $specialfeatureID = implode(',', $specialfeatureID); // this condition is when array[0] has no '0'
            }

            //to check if subject is check or not 
        
            if ($subjectID[0] == '0' && count($subjectID) == 1) //get param value of hospitalsearch.vue and if value is 0 and count =1 , this condition is "No Check"
            {                       
                $subjectID = '0';
            } else if ($subjectID[0] == '0' && count($subjectID) > 1) { //if count > 1, this condition is  "Check and Remove an item of array [0] and implode array 
                unset($subjectID[0]);
                $subjectID = implode(',', $subjectID);
            } else {
                $subjectID = implode(',', $subjectID); // this condition is when array[0] has no '0'
            }

      
                  
            if ($townshipID == '0' && $specialfeatureID == '0' &&  $subjectID == '0') {
                $query .= " ci.id = " . $id ;

            } else if ($townshipID != '0' && $specialfeatureID == '0' &&  $subjectID == '0') {
                $query .= "ci.id = " . $id . " and  t.id in (" . $townshipID . ")";
                
            } else if ($townshipID != '0' && $specialfeatureID != '0' &&  $subjectID == '0') {
                $query .= "ci.id = " . $id . " and  t.id in (" . $townshipID . ") and spe.id in (" . $specialfeatureID . ")";
                
            } else if ($townshipID != '0' && $specialfeatureID == '0' &&  $subjectID != '0') {
                $query .= "ci.id = " . $id . " and  t.id in (" . $townshipID . ") and sub.id in (" . $subjectID . ")";
                
            } else if ($townshipID == '0' && $specialfeatureID != '0' &&  $subjectID == '0') {
                $query .= "ci.id = " . $id . " and   spe.id in (" . $specialfeatureID . ")";
                
            } else if ($townshipID == '0' && $specialfeatureID == '0' &&  $subjectID != '0') {
                $query .= "ci.id = " . $id . " and sub.id in (" . $subjectID . ")";
                
            } else if ($townshipID == '0' && $specialfeatureID != '0' &&  $subjectID != '0') {
                $query .= "ci.id = " . $id . " and  spe.id in (" . $specialfeatureID . ")  and sub.id in (" . $subjectID . ")";
                
            } else if ($townshipID != '0' && $specialfeatureID != '0' &&  $subjectID != '0') {
                $query .= "ci.id = " . $id . " and  t.id in (" . $townshipID . ") and spe.id in (" . $specialfeatureID . ")  and sub.id in (" . $subjectID . ")";
                
            }
           
            if($searchword != 'undefined')
            {
               
                $query .= " and (ci.city_name like '%" . $searchword . "%' or t.township_name like '%" . $searchword . "%' or c.name like '%".$searchword."%') group by c.id";
            }
           
            $query .=  " group by c.id";
        
           
        }

        
        $hos_data = DB::select($query);
        $spe_query = "SELECT spe.*,spej.customer_id from  special_features as spe join special_features_junctions as spej on spe.id = spej.special_feature_id";
        $specialfeature = DB::select($spe_query);
        //subjects for result
        $sub_query = "SELECT sub.*,subj.customer_id from  subjects as sub join subject_junctions as subj on sub.id = subj.subject_id";
        $subject = DB::select($sub_query);
        //subjects for filter 
        $subs = "SELECT *,'' as child from subjects where parent = " . 0 ." order by id";
        $subjects = DB::select($subs); 
        $timetable = DB::table('schedule')->get();
        $sub_child = DB::table('subjects')->get();
        $city = DB::table('cities')->get();
        $getTownships  = DB::table('townships')->where('city_id', $id)->get();

        foreach($subjects as $sub)  
        {
            $id = $sub->id;
            $db_sub = "SELECT subjects.* from subjects where parent =". $id ." order by id";
            $subchild = DB::select($db_sub);
            $sub->child = $subchild;
        }
        return response()->json(array("hospital" => $hos_data, "timetable" => $timetable, "specialfeature" => $specialfeature, 
                                      "subject" => $subject,"subjects"=>$subjects,"sub_child"=>$sub_child,"city"=>$city,"township"=>$getTownships));
    }


    public function getJobSearch($searchword)
    {

         //for city
         $id = $_GET['id'];
         $townshipID = $_GET['townshipID'];
         $occupationID = $_GET['occupationID'];
         $empstatus = $_GET['empstatus'];

        $query = "SELECT j.id as jobid,j.recordstatus as job_record, j.*,c.*,n.*,h.*,
                (CASE c.type_id WHEN '2' THEN CONCAT((500000+j.id),'-',LPAD(j.id, 4, '0')) ELSE CONCAT((200000+j.id),'-',LPAD(j.id, 4, '0')) END) as jobnum 
                from  jobs as j              
                join customers as c on c.id = j.customer_id
                left Join townships as t on t.id = j.township_id 
                left Join nursing_profiles As n on n.customer_id = c.id 
                left Join hospital_profiles As h on h.customer_id = c.id 
                left Join cities as ci on ci.id = t.city_id   
                where ";

        if($id == -1)
        {

            if($searchword == 'all')
            {
                $query = "SELECT j.id as jobid, j.*,c.*,n.*,h.*,
                        (CASE c.type_id WHEN '2' THEN CONCAT((500000+j.id),'-',LPAD(j.id, 4, '0')) ELSE CONCAT((200000+j.id),'-',LPAD(j.id, 4, '0')) END) as jobnum 
                        from  jobs as j
                        join customers as c on c.id = j.customer_id
                        left Join nursing_profiles As n on n.customer_id = c.id 
                        left Join hospital_profiles As h on h.customer_id = c.id 
                        left Join townships as t on t.id = j.township_id ";         
            }
            else{
             

                $query .= " (j.title like '%" . $searchword . "%' or ci.city_name like '%" . $searchword . "%' or t.township_name like '%".$searchword."%')";
            }
           
        }
        else{

          //to check if township is check or not 
           
          if ($townshipID[0] == '0' && count($townshipID) == 1) //get param value of hospitalsearch.vue and if value is 0 and count =1 , this condition is "No Check"
          {
              $townshipID = '0';
          } else if ($townshipID[0] == '0' && count($townshipID) > 1) { //if count > 1, this condition is  "Check and Remove an item of array [0] and implode array 
              unset($townshipID[0]);
              $townshipID = implode(',', $townshipID);
          } else {
              $townshipID = implode(',', $townshipID); // this condition is when array[0] has no '0'
          }


          //to check if occupation is check or not

          if ($occupationID[0] == '0' && count($occupationID) == 1) {
              $occupationID = '0';
          } else if ($occupationID[0] == '0' && count($occupationID) > 1) {
              unset($occupationID[0]);
              $occupationID = implode(',', $occupationID);
          } else {
              $occupationID = implode(',', $occupationID);
          }

          //to check if employment status is check or not
          
          if ($empstatus[0] === '0' && count($empstatus) === 1) {
              $empstatus = '0';
          } else if ($empstatus[0] === '0' && count($empstatus) > 1) {

              unset($empstatus[0]);
              $empstatus = implode(',', $empstatus);
          } else {
              $empstatus = implode(',', $empstatus);
          }

          $query .= " t.city_id =".$id;

          if($townshipID != '0')
          {
              $query .= " and t.id in (".$townshipID.")";
          }
          if($occupationID != '0')
          {
              $query .= " and j.occupation_id in (".$occupationID.")";
          }
          if($empstatus != '0')
          {
              $empstatus = explode(',', $empstatus);
      
              if (count($empstatus) == 4) {
                  $query .= " and (j.employment_status = '". $empstatus[0] ."' or j.employment_status = '".$empstatus[1] ."' or j.employment_status = '". $empstatus[2] ."' or j.employment_status = '". $empstatus[3] ."')" ;
              }
              else if(count($empstatus) == 3)
              {
                  $query .= " and (j.employment_status = '". $empstatus[0] ."' or j.employment_status = '".$empstatus[1] ."' or j.employment_status = '". $empstatus[2] ."')" ;
              }
              else if(count($empstatus) == 2){
                  $query .= " and (j.employment_status = '". $empstatus[0] ."' or j.employment_status = '".$empstatus[1] ."')" ;
              }
              else  {
   
                  $query .= " and (j.employment_status = '".$empstatus[0] ."')";
              } 
          }

          if($searchword != 'undefined')
          {
          
            $query .= " and (j.title like '%" . $searchword . "%' or ci.city_name like '%" . $searchword . "%' or t.township_name like '%".$searchword."%')";
          }

        

        }
         
        $job_data = DB::select($query);
        $city = DB::table('cities')->get();


     
        return response()->json(array('job'=>$job_data,'city'=>$city));
    }



    public function getCity(Request $request)
    {
        $id = $request->id;
        $getTownships = DB::table('townships')->where('city_id', $id)->get();
        return response()->json($getTownships);
    }
}

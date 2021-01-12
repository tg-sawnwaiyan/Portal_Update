<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\NursingProfile;
use App\method_payment;
use App\Cooperate_Medical;
use App\Medical;
use App\Staff;
use App\HospitalProfile;
use App\AcceptanceTransaction;
use DB;
use App\special_feature;
use App\Customer;
use App\Comment;
use App\Schedule;
use App\Facility;
use App\Subject;
use App\Gallery;
use App\SpecialFeaturesJunctions;
use App\SubjectJunctions;
use App\FacType;

class ProfilePublishController extends Controller
{
    public function hospitalProfile($cusid)
    {
             
        //for hospital map
        $hospital =  DB::table('hospital_profiles') ->select('hospital_profiles.*')->where('hospital_profiles.id','=',$cusid)->get();
       
        $query  = "SELECT cities.city_name,townships.township_name from townships join cities where townships.id =".$hospital[0]->townships_id;
        $address = DB::select($query);
  
        $facility_list = Facility::select('id','description')->get();
        $hosfacility= explode(',',$hospital[0]->facilities);
        $facility = Facility::whereIn('id',$hosfacility)->select('description','id')->get();
        $logo = HospitalProfile::where('id',$cusid)->select('logo as photo')->get()->toArray();
        $gallery = Gallery::where('profile_id',$cusid)->where('type','photo')->get()->toArray();
        $images = array_merge($logo,$gallery);

        $videos = Gallery::where('profile_id',$cusid)->where('type','video')->select()->get()->toArray();
        for($i=0;$i<count($videos);$i++) {
            $first_arr = explode('v=',$videos[$i]['photo']);
            if(count($first_arr)>1) {
                $second_arr = explode('&',$first_arr[1]);
                $videos[$i]['photo'] = $second_arr[0];
            } else {
                $videos[$i]['photo'] = $videos[$i]['photo'];
            }
        }
        $query = "SELECT CONCAT((200000+customers.id),'-',LPAD(hospital_profiles.pro_num, 4, '0')) as profilenumber from customers join hospital_profiles on 
                 customers.id = hospital_profiles.customer_id where hospital_profiles.id = ".$cusid;
        $profilenumber = DB::select($query);

        return response()->json(array("hospital"=>$hospital,"images"=>$images,"videos"=>$videos,"facility_list"=>$facility_list,"facility"=>$facility,"address"=>$address,"profilenumber"=>$profilenumber));
    }

    public function nursingProfile($cusid)
    {

        $facility = NursingProfile::where('id',$cusid)->get(); 
        
        $tmp = FacType::where('id', $facility[0]['fac_type'])->first();
        $facility[0]['fac_type'] = $tmp['description'];       
        $comedical = Cooperate_Medical::where('profile_id',$cusid)->get();

        $sql = "SELECT method_payment.* from method_payment INNER JOIN nursing_profiles ON method_payment.profile_id= nursing_profiles.id WHERE method_payment.profile_id=$cusid";
        $cost = DB::select($sql);

        //forshow all medical acceptance
        $medicalacceptance = Medical::select('id','name')->get();

        //forshow custom icon
        $medical =  DB::table('acceptance_transactions') ->select('acceptance_transactions.accept_type','medical_acceptance.name')
                        ->join('medical_acceptance','medical_acceptance.id','=','acceptance_transactions.medical_acceptance_id')
                        ->where('acceptance_transactions.profile_id','=',$cusid)->get();

        $staff = Staff::where('profile_id',$cusid)->get();

         //for nursing map
        $nurselatlong = NursingProfile::where('id',$cusid)->get(); 

        $addquery  = "SELECT cities.city_name,townships.township_name from townships inner join cities on townships.city_id=cities.id where townships.id =".$nurselatlong[0]->townships_id;
        $address = DB::select($addquery);

        //for image slide show
        $logo = NursingProfile::where('id',$cusid)->select('logo as photo')->get()->toArray(); // to change

        $gallery = Gallery::where('profile_id',$cusid)->where('type','photo')->where('profile_type','nursing')->get()->toArray();
        $images = array_merge($logo,$gallery);

        $panoimages = Gallery::where('profile_id',$cusid)->where('type','panorama')->where('profile_type','nursing')->select()->orderBy('id','desc')->get();
        $videos = Gallery::where('profile_id',$cusid)->where('type','video')->where('profile_type','nursing')->select()->get()->toArray();
        for($i=0;$i<count($videos);$i++) {
            $first_arr = explode('v=',$videos[$i]['photo']);
            if(count($first_arr)>1) {
                $second_arr = explode('&',$first_arr[1]);
                $videos[$i]['photo'] = $second_arr[0];
            } else {
                $videos[$i]['photo'] = $videos[$i]['photo'];
            }
        }
        $query = "SELECT CONCAT((500000+customers.id),'-',LPAD(nursing_profiles.pro_num, 4, '0')) as profilenumber from customers join nursing_profiles on
                          customers.id = nursing_profiles.customer_id where nursing_profiles.id = ".$cusid;
        $profilenumber = DB::select($query);
        $data = array(
                "facility"  =>$facility,
                "comedical" =>$comedical,
                "medicalacceptance"=>$medicalacceptance,
                "staff"     =>$staff, 
                "nurselatlong"=>$nurselatlong,
                "cost"      =>$cost,
                "medical"   =>$medical,
                "images"    =>$images,
                "panoimages"=>$panoimages,
                "address"   =>$address,
                "videos"    =>$videos,
                "profilenumber"=>$profilenumber
            );

        return response()->json($data);
    }

    public function getComment($proid,$type)
    {
        if($type == 'nursing'){
            $sql = "SELECT comments.id,comments.title,comments.email,comments.year,comments.comment, comments.created_at from comments INNER JOIN nursing_profiles ON comments.profile_id= nursing_profiles.id WHERE comments.profile_id = $proid AND comments.status = 1";
            $comments = DB::select($sql);
            foreach ($comments as $cm) {
                $splitTimeStamp   = explode(" ",$cm->created_at);
                $cm->created_date = $splitTimeStamp[0];
                $cm->created_time = $splitTimeStamp[1];
            }
            return $comments;
        }else{
            $sql = "SELECT comments.id,comments.title,comments.email,comments.year,comments.comment, comments.created_at from comments INNER JOIN hospital_profiles ON comments.profile_id= hospital_profiles.id WHERE comments.profile_id = $proid AND comments.status = 1";
            $comments = DB::select($sql);
            foreach ($comments as $cm) {
                $splitTimeStamp   = explode(" ",$cm->created_at);
                $cm->created_date = $splitTimeStamp[0];
                $cm->created_time = $splitTimeStamp[1];
            }
            return $comments;
        }
    }

    public function getCustomer($proid,$type)
    {
        if($type == 'hospital'){
            $type = 'hospital_profiles';
        }
        else{
            $type = 'nursing_profiles';
        }
        $sql = "SELECT $type.* from $type where id = $proid";
        $customer = DB::select($sql);

        return $customer;
    }

    public function getCustomerLatLng($proid,$type)
    {
        if($type == 'hospital'){
            $type = 'hospital_profiles';
        }
        else{
            $type = 'nursing_profiles';
        }
        $sql = "SELECT $type.latitude,$type.longitude,$type.id as pro_id FROM $type where $type.id = $proid";
        $profilelatlan = DB::select($sql);

        return $profilelatlan;
    }

    public function getSpecialfeature($type,$proid){
        $sfeature = SpecialFeaturesJunctions::where('profile_id',$proid)->get()->toArray();

        if($sfeature != null){
            for($indx = 0; $indx<count($sfeature); $indx++) {
                $sql[] = special_feature::find($sfeature[$indx]['special_feature_id']);
            }
        }
        else{
            $sql = '';
        }
        return response()->json($sql);
    }

    public function getSubject($cusid){
        $sub = SubjectJunctions::where('profile_id',$cusid)->get()->toArray();

        if($sub != null){
            for($indx = 0; $indx<count($sub); $indx++) {
                $subject[] = Subject::find($sub[$indx]['subject_id']);
            }
        }
        else{
            $subject = '';
        }

        return response()->json($subject);
    }

    public function getSchedule($cusid){
        $schedule_am = Schedule::select('mon','tue','wed','thu','fri','sat','sun')->where('profile_id', $cusid)
                            ->where('part', '=', 'am')
                            ->get();
        $schedule_pm = Schedule::select('mon','tue','wed','thu','fri','sat','sun')->where('profile_id', $cusid)
                            ->where('part', '=', 'pm')
                            ->get();

        return response()->json(array("am"=> $schedule_am, "pm"=> $schedule_pm));
    }  

    public function getStaffbyCustomerId($cusid) {
        $staff = Staff::where("profile_id",$cusid)->first();

        return $staff;
    }
}

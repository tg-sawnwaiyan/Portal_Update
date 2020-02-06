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
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function hospitalProfile($cusid)
    {
        $hospital = HospitalProfile::where('id',$cusid)->get();

        //for hospital map
        $hoslatlong =  DB::table('hospital_profiles') ->select('hospital_profiles.*')
                        ->where('hospital_profiles.id','=',$cusid)->get();

        $facility_list = Facility::select('id','description')->get();
        $profile_facility =  HospitalProfile::select('facilities')->where('id',$cusid)->value('facilities');
        $hosfacility= explode(',',$profile_facility);
        $facility = Facility::whereIn('id',$hosfacility)->select('description','id')->get();
        //for image slide show
        $logo = Customer::where('id',$cusid)->select('logo as photo')->get()->toArray();
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

        return response()->json(array("hoslatlong"=>$hoslatlong,"hospital"=>$hospital,"images"=>$images,"videos"=>$videos,"facility_list"=>$facility_list,"facility"=>$facility));
    }

    public function nursingProfile($cusid)
    {

        // $feature = NursingProfile::select('feature')->where('id',$cusid)->get();
        // $method = NursingProfile::select('method')->where('id',$cusid)->get();
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
        // $nurselatlong =  DB::table('nursing_profiles') ->select('nursing_profiles.*')
        //                      ->where('nursing_profiles.id','=',$cusid)->get();
        $nurselatlong = NursingProfile::where('id',$cusid)->get(); 

        //for image slide show
        $logo = Customer::where('id',$cusid)->select('logo as photo')->get()->toArray(); // to change

        $gallery = Gallery::where('profile_id',$cusid)->where('type','photo')->get()->toArray();
        $images = array_merge($logo,$gallery);

        $panoimages = Gallery::where('profile_id',$cusid)->where('type','panorama')->select()->orderBy('id','desc')->get();
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

        return response()->json(array("facility"=>$facility,"comedical"=>$comedical,"medicalacceptance"=>$medicalacceptance,
        "staff"=>$staff, "nurselatlong"=>$nurselatlong,"cost"=>$cost,"medical"=>$medical,"images"=>$images,"panoimages"=>$panoimages,
        "videos"=>$videos));
    }

    public function getComment($proid)
    {
        $sql = "SELECT comments.id,comments.title,comments.email,comments.year,comments.comment, comments.created_at from comments INNER JOIN nursing_profiles ON comments.profile_id= nursing_profiles.id WHERE comments.profile_id = $proid AND comments.status = 1";
        $comments = DB::select($sql);
        foreach ($comments as $cm) {
            $splitTimeStamp = explode(" ",$cm->created_at);
            $cm->created_date = $splitTimeStamp[0];
            $cm->created_time = $splitTimeStamp[1];
        }
        return $comments;
    }



    public function getCustomer($proid,$type)
    {
        // $customer = Customer::where('id',$cusid)->get();
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
        // $customer = Customer::where('id',$cusid)->get();
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

    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        //
    }


    public function show()
    {
        //


    }


    public function edit($id)
    {

    }


    public function update(Request $request, $id)
    {
        //
    }


    public function destroy($id)
    {
        //
    }

    public function getStaffbyCustomerId($cusid) {
        $staff = Staff::where("profile_id",$cusid)->first();

        return $staff;
    }
}

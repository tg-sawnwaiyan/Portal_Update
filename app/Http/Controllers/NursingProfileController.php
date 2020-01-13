<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\NursingProfile;
use App\Gallery;
use App\Cooperate_Medical;
use App\method_payment;
use App\Customer;
use App\Staff;
use App\User;
use App\AcceptanceTransaction;
use App\SpecialFeaturesJunctions;
use DB;

class NursingProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       
    }

    public function edit($id) {

        $nursing = NursingProfile::where('customer_id', $id)
                    ->first();
        return $nursing;
    }

    public function movePanorama(Request $request) {
        $request = $request->all();
        foreach ($request as $file){
            $destination = 'upload/nursing_profile/Imagepanorama/'.$file->getClientOriginalName();
            $upload_img = move_uploaded_file($file, $destination);
        }
    }
    public function movePhoto(Request $request) {
        $request = $request->all();
        foreach ($request as $file){
            $destination = 'upload/nursing_profile/'.$file->getClientOriginalName();
            $upload_img = move_uploaded_file($file, $destination);
        }        
    }

    public function profileupdate($id,Request $request) { 
        $request = $request->all();

        // Customer Info List
        $customer = Customer::find($id);

        $customer->name = $request[0]['customer_info']['name'];
        $customer->email = $request[0]['customer_info']['email'];
        $customer->phone = $request[0]['customer_info']['phone'];
        $customer->address = $request[0]['customer_info']['address'];
        $customer->townships_id = $request[0]['customer_info']['townships_id'];

        $customer->save();

        $nursing = NursingProfile::where('customer_id',$id)->first();
        // Nursing Profile 
        // print_r($request);exit;
        $nursing->access = $request[0]['nursing_profile']['access'];
        $nursing->operator = $request[0]['nursing_profile']['operator'];
        $nursing->business_entity = $request[0]['nursing_profile']['business_entity'];
        $nursing->website = $request[0]['nursing_profile']['website'];
        $nursing->moving_in_from = $request[0]['nursing_profile']['moving_in_from'];
        $nursing->moving_in_to = $request[0]['nursing_profile']['moving_in_to'];
        $nursing->per_month_from = $request[0]['nursing_profile']['per_month_from'];
        $nursing->per_month_to = $request[0]['nursing_profile']['per_month_to'];
        $nursing->feature = $request[0]['nursing_profile']['feature'];
        $nursing->method = $request[0]['nursing_profile']['method'];
        $nursing->date_of_establishment = $request[0]['nursing_profile']['date_of_establishment'];
        $nursing->land_right_form = $request[0]['nursing_profile']['land_right_form'];
        $nursing->building_right_form = $request[0]['nursing_profile']['building_right_form'];
        $nursing->site_area = $request[0]['nursing_profile']['site_area'];
        $nursing->floor_area = $request[0]['nursing_profile']['floor_area'];
        $nursing->construction = $request[0]['nursing_profile']['construction'];
        $nursing->capacity = $request[0]['nursing_profile']['capacity'];
        $nursing->num_rooms = $request[0]['nursing_profile']['num_rooms'];
        $nursing->residence_form = $request[0]['nursing_profile']['residence_form'];
        $nursing->fac_type = $request[0]['nursing_profile']['fac_type'];
        $nursing->occupancy_condition = $request[0]['nursing_profile']['occupancy_condition'];
        $nursing->room_floor = $request[0]['nursing_profile']['room_floor'];
        $nursing->living_room_facilities = $request[0]['nursing_profile']['living_room_facilities'];
        $nursing->equipment = $request[0]['nursing_profile']['equipment'];
        $nursing->acceptance_remark = $request[0]['nursing_profile']['acceptance_remark'];
        $nursing->latitude = $request[0]['nursing_profile']['latitude'];
        $nursing->longitude = $request[0]['nursing_profile']['longitude'];
        $nursing->save();
        // End

        // Cooperate List
        $medical = Cooperate_Medical::where('customer_id', $id)
                        ->delete();

        for($i=0; $i<count($request[0]['cooperate_list']); $i++) {
            $cop_medical = new Cooperate_Medical;
            $cop_medical->customer_id = $id;
            $cop_medical->name = $request[0]['cooperate_list'][$i]['name'];
            $cop_medical->clinical_subject = $request[0]['cooperate_list'][$i]['subject'];
            $cop_medical->details = $request[0]['cooperate_list'][$i]['details'];
            $cop_medical->medical_expense = $request[0]['cooperate_list'][$i]['expense'];
            $cop_medical->remark = $request[0]['cooperate_list'][$i]['remark'];

            $cop_medical->save();
        }
        // End

        // Payment List
        $payment = method_payment::where('customer_id', $id)
                        ->delete();

        for($i=0; $i<count($request[0]['payment_list']); $i++) {
            $m_payment = new method_payment;
            $m_payment->customer_id = $id;
            $m_payment->payment_name = $request[0]['payment_list'][$i]['payment_name'];
            $m_payment->expense_moving = $request[0]['payment_list'][$i]['expense_moving'];
            $m_payment->monthly_fees = $request[0]['payment_list'][$i]['monthly_fees'];
            $m_payment->living_room_type = $request[0]['payment_list'][$i]['living_room_type'];
            $m_payment->area = $request[0]['payment_list'][$i]['area'];
            $m_payment->deposit = $request[0]['payment_list'][$i]['deposit'];
            $m_payment->other_use = $request[0]['payment_list'][$i]['other_use'];
            $m_payment->rent = $request[0]['payment_list'][$i]['rent'];
            $m_payment->admin_expense = $request[0]['payment_list'][$i]['admin_expense'];
            $m_payment->food_expense = $request[0]['payment_list'][$i]['food_expense'];
            $m_payment->nurse_care_surcharge = $request[0]['payment_list'][$i]['nurse_care_surcharge'];
            $m_payment->other_monthly_cost = $request[0]['payment_list'][$i]['other_monthly_cost'];
            $m_payment->refund_system = $request[0]['payment_list'][$i]['refund_system'];
            $m_payment->depreciation_period = $request[0]['payment_list'][$i]['depreciation_period'];
            $m_payment->initial_deprecration = $request[0]['payment_list'][$i]['initial_deprecration'];
            $m_payment->other_message_refund = $request[0]['payment_list'][$i]['other_message_refund'];

            $m_payment->save();
        }
        // End

        

        DB::update("UPDATE users SET name='".$request[0]['customer_info']['name']."', email='".$request[0]['customer_info']['email']."' WHERE customer_id=$id");
        // End

        // Staff Info
        $staff = Staff::where('customer_id', $id)->first();
    
        if($staff) {
            $staff->customer_id = $id;
            $staff->staff = $request[0]['staff_info']['staff'];
            $staff->nursing_staff = $request[0]['staff_info']['nursing_staff'];
            $staff->min_num_staff = $request[0]['staff_info']['min_num_staff'];
            $staff->num_staff = $request[0]['staff_info']['num_staff'];
            $staff->remarks = $request[0]['staff_info']['remarks'];
            $staff->save();
        } else {
            $new_staff = new Staff;
            $new_staff->customer_id = $id;
            $new_staff->staff = $request[0]['staff_info']['staff'];
            $new_staff->nursing_staff = $request[0]['staff_info']['nursing_staff'];
            $new_staff->min_num_staff = $request[0]['staff_info']['min_num_staff'];
            $new_staff->num_staff = $request[0]['staff_info']['num_staff'];
            $new_staff->remarks = $request[0]['staff_info']['remarks'];
            $new_staff->save();
        }
        // End

        // Accepatance
        $transition = AcceptanceTransaction::where('customer_id', $id)
                        ->delete();

        for($i=0; $i<count($request[0]['acceptance']); $i++) { 
            if($request[0]['acceptance'][$i] != '') {
                $accept_transaction = new AcceptanceTransaction;
                $accept_transaction->customer_id = $id;
                $accept_transaction->medical_acceptance_id = $request[0]['acceptance'][$i]['id'];
                $accept_transaction->accept_type = $request[0]['acceptance'][$i]['type'];
                $accept_transaction->save();
            } 
        }
        // End

        // Feature
        $feature = SpecialFeaturesJunctions::where('customer_id', $id)
                    ->delete();

        for($indx=0; $indx<count($request[0]['chek_feature'][0]['special_feature_id']); $indx++) {
            $new_feature = new SpecialFeaturesJunctions();
            $new_feature->customer_id = $id;
            $new_feature->special_feature_id = $request[0]['chek_feature'][0]['special_feature_id'][$indx];
            $new_feature->save();
        }
        // End

        // Gallary 
        if(count($request[0]["video"]) > 0){
            $del_gallery = Gallery::where(['customer_id'=> $id,'type'=>'video'])->delete(); 
            for($i=0; $i<count($request[0]["video"]); $i++) {
                $gallery = new Gallery;
                $gallery->customer_id = $id;
                $gallery->type = $request[0]["video"][$i]['type'];
                $gallery->photo = $request[0]["video"][$i]['photo'];
                $gallery->title = $request[0]["video"][$i]['title'];
                $gallery->description = $request[0]["video"][$i]['description'];
    
                $gallery->save();
            }
        }

        $del_gallery = Gallery::where(['customer_id'=> $id,'type'=>'photo'])->delete(); 
        if(count($request[0]["image"]) > 0){
            for($i=0; $i<count($request[0]["image"]); $i++) {
                $gallery = new Gallery;
                $gallery->customer_id = $id;
                $gallery->type = $request[0]["image"][$i]['type'];
                $gallery->photo = $request[0]["image"][$i]['photo'];
                $gallery->title = $request[0]["image"][$i]['title'];
                $gallery->description = $request[0]["image"][$i]['description'];
    
                $gallery->save();
            }
        }
        if(count($request[0]["panorama"]) > 0){
            $del_gallery = Gallery::where(['customer_id'=> $id,'type'=>'panorama'])->delete(); 
            for($i=0; $i<count($request[0]["panorama"]); $i++) {
                $gallery = new Gallery;
                $gallery->customer_id = $id;
                $gallery->type = $request[0]["panorama"][$i]['type'];
                $gallery->photo = $request[0]["panorama"][$i]['photo'];
                $gallery->title = $request[0]["panorama"][$i]['title'];
                $gallery->description = $request[0]["panorama"][$i]['description'];
    
                $gallery->save();
            }
        }
        // End
    }

    public function getCities($township_id) {

        $query = "SELECT townships.city_id,'' AS township_list FROM townships WHERE id = $township_id";
        $cities = DB::select($query);
        // $cId = $cities[0]['city_id'];
        foreach($cities as $city){
            $cId = $city->city_id;
            $c_query = "SELECT townships.id,townships.township_name FROM townships WHERE city_id = $cId";
            $townships = DB::select($c_query);
            $city->township_list = $townships;
        }
        return $cities;
        // return $cities;
    }
    public function getTownships($city_id) {
        $query = "SELECT townships.id,townships.township_name FROM townships WHERE townships.city_id = $city_id";
        $township_list = DB::select($query);
        $c_query = "SELECT cities.latitude, cities.longitude FROM cities WHERE cities.id = $city_id";
        $coordinate = DB::select($c_query);
        return response()->json(array("townships"=>$township_list,"coordinate"=>$coordinate));
    }
}
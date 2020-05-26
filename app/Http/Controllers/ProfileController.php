<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use App\NursingProfile;
use App\HospitalProfile;
use App\Customer;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = auth()->user();
        // $data = array('user'->$user);
        return auth()->user();
    }

    public function movelatlng($id,Request $request)
    {   
       
        // $query = "SELECT latitude,longitude,city_name FROM cities  where id = " .$request->city_id ;
        // $citylatlng = DB::select($query);         
        
        // $insert = array(
        //     'customer_id' => $id,
        //     'name' => $request->name,
        //     'latitude' => $citylatlng[0]->latitude,
        //     'longitude' => $citylatlng[0]->longitude,
        //     'townships_id' => $request->town_id,  
        //     'pro_num' => 0,   
        // ); 

        $insert = array(
            'customer_id' => $id,
            'pro_num' => 0,   
        ); 

        $type_id = DB::table('users')->select('type_id')->where('customer_id',$id)->value('type_id');
     
        if($type_id == 2){ 
            $pro_num = HospitalProfile::where('customer_id',$id)->count();
            $insert["pro_num"] = intval($pro_num) + 1;
            \DB::table('hospital_profiles')->insert($insert);
            $pro_id = \DB::table('hospital_profiles')->where('customer_id',$id)->max('id');
        }else{
            $pro_num = NursingProfile::where('customer_id',$id)->count();
            $insert["pro_num"] = intval($pro_num) + 1;
            \DB::table('nursing_profiles')->insert($insert);
            $pro_id = \DB::table('nursing_profiles')->where('customer_id',$id)->max('id');
        }  

        $cus = Customer::find($id);
        $cus->pro_num = $insert["pro_num"];
        $cus->save();

        
        return response()->json($pro_id);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

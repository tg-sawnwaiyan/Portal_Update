<?php

namespace App\Http\Controllers;

use App\Job;
use DB;
use Illuminate\Http\Request;
class JobDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $job_details = Job::all()->toArray();
        return array_reverse($job_details);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\JobDetail  $jobDetail
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {       
        $query = "SELECT (CASE customers.type_id WHEN '2' THEN  hospital_profiles.activate ELSE  nursing_profiles.activate  END) as activate,jobs.*, ci.city_name as city_name,t.township_name,customers.type_id, (CASE customers.type_id WHEN 2 THEN hospital_profiles.name  ELSE nursing_profiles.name END) as cusname,
        (CASE customers.type_id WHEN '2' THEN CONCAT((200000+customers.id),'-',LPAD(hospital_profiles.pro_num, 4, '0'),'-',LPAD(jobs.id, 4, '0')) ELSE CONCAT((500000+customers.id),'-',LPAD(nursing_profiles.pro_num, 4, '0'),'-',LPAD(jobs.id, 4, '0')) END) as jobid
        FROM `jobs`
        JOIN customers ON jobs.customer_id = customers.id
        left join hospital_profiles on hospital_profiles.id = jobs.profile_id
        left join nursing_profiles on nursing_profiles.id = jobs.profile_id
        join townships as t on t.id = jobs.township_id 
        join cities as ci on ci.id = t.city_id
        WHERE customers.recordstatus=1 and jobs.id = $id";
        $selectedJob = DB::select($query);        
        return $selectedJob;
    }
}
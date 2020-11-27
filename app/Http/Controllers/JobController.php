<?php

namespace App\Http\Controllers;

use App\Job;
use App\Occupations;
use Illuminate\Http\Request;
use DB;
use App\jobs_log;
use App\JobApply;
use App\jobApplyLog;
use \Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Input;

class JobController extends Controller
{
    public function index($type,$pro_id)
    { 
        if( $type == "admin"){
            $query = "SELECT  jobs.*,customers.type_id,customers.name,(CASE customers.type_id WHEN '2' THEN hospital_profiles.name  ELSE nursing_profiles.name END)as profile_name, (CASE customers.type_id WHEN '2' THEN CONCAT((200000+customers.id),'-',LPAD(hospital_profiles.pro_num, 4, '0'),'-',LPAD(jobs.id, 4, '0')) ELSE CONCAT((500000+customers.id),'-',LPAD(nursing_profiles.pro_num, 4, '0'),'-',LPAD(jobs.id, 4, '0')) END) as jobid 
                           FROM  jobs join customers  on jobs.customer_id = customers.id 
                           left join hospital_profiles on hospital_profiles.id = jobs.profile_id
                           left join nursing_profiles on nursing_profiles.id = jobs.profile_id
                           where customers.recordstatus = 1  group by jobs.id order by jobs.id desc ";
            $projob = DB::select($query);
            foreach($projob as $jobs){               
                $job_id = $jobs->id;
                $jobapplies =  DB::table('job_applies')->join('jobs','job_applies.job_id','=','jobs.id')
                            ->where('job_applies.job_id','=',$job_id)->count();
                $jobs->count = $jobapplies;
                $type_id = $jobs->type_id;
                $profile_id = $jobs->profile_id;            
            }          
        }else{
            if($pro_id != null)
            {
                if($type == "nursing")
                {
                    $query = "SELECT  jobs.*,customers.type_id,nursing_profiles.name as profile_name,customers.name,CONCAT((500000+customers.id),'-',LPAD(nursing_profiles.pro_num, 4, '0'),'-',LPAD(jobs.id, 4, '0'))  as jobid 
                                FROM  jobs join customers  on jobs.customer_id = customers.id 
                                left join nursing_profiles on nursing_profiles.id = jobs.profile_id
                                where customers.recordstatus = 1 
                                and nursing_profiles.id = ".$pro_id." group by jobs.id order by jobs.id desc ";
                }
                else{
                    $query = "SELECT  jobs.*,customers.type_id,hospital_profiles.name as profile_name,customers.name,CONCAT((200000+customers.id),'-',LPAD(hospital_profiles.pro_num, 4, '0'),'-',LPAD(jobs.id, 4, '0'))  as jobid 
                                FROM  jobs join customers  on jobs.customer_id = customers.id 
                                left join hospital_profiles on hospital_profiles.id = jobs.profile_id
                                where customers.recordstatus = 1 
                                and hospital_profiles.id = ".$pro_id."  group by jobs.id order by jobs.id desc ";
                }               
                $projob = DB::select($query);
                foreach($projob as $jobs){
                    $job_id = $jobs->id;
                    $jobapplies =  DB::table('job_applies')->join('jobs','job_applies.job_id','=','jobs.id')
                                ->where('job_applies.job_id','=',$job_id)->count();
                    $jobs->count = $jobapplies;
                }
            }        
        }
        $page = Input::get('page', 1);
        $size = 12;
        $data = collect($projob); 
        $profilejob = new LengthAwarePaginator(
                                $data->forPage($page, $size),
                                $data->count(), 
                                $size, 
                                $page
                            );
        return response()->json(array('profilejob'=>$profilejob));
    }

    public function getOccupationList()
    {
        // $occupationlist = Occupations::select('id','name')->get()->toArray();
        $occupationList = Occupations::select('id','name')->where('parent','!=',0)->get()->toArray();
        return response()->json($occupationList);
    }

    public function getSkill()
    {
        $job = Job::select('skills')->value('skills');
        return $job;
    }

    public function getTownshipId($city_name)
    {
        $query = "SELECT id  FROM `townships`
                    WHERE township_name = " . $city_name;
        $township_id = DB::select($query);
        return $township_id;
    }

    public function add(Request $request)
    {
        // $request->validate([
        //     'title' => 'required',
        //     'description' =>'required',
        //     'location' => 'required',
        //     'salary' => 'required',
        //     'working_hours' => 'required',
        // ],[
        //     'title.required'=>'施設種別は必須です。',
        //     'description.required'=>'仕事内容は必須です。',
        //     'location.required'=>'勤務地は必須です。',
        //     'salary.required'=>'給与は必須です。',
        //     'working_hours.required'=>'就業時間は必須です。',
        // ]);
        $string = '';
        $count = count($request->fields);
        for($i = 0;$i< $count ;$i++)
        {
            if($i == $count-1)
            {
              $string .= $request->fields[$i]['skills'];
            }else{
                $string .= $request->fields[$i]['skills'] .',';
            }
        }
        //    $cstring = '';
        //    if($request->employment_status[0]['pchecked'] == true)
        //    {
        //       $cstring .=  "Part";
        //    }
        //    else if($request->employment_status[0]['fchecked'] == true)
        //    {
        //        if($cstring == '')
        //        {
        //           $cstring = "Full" ;
        //        }
        //        else{
        //           $cstring .=  " ,Full";
        //        }
        //    }
        //     if($request->employment_status[0]['echecked'] == true)
        //    {
        //         if($cstring == '')
        //         {
        //         $cstring = "EmploymentStatus" ;
        //         }
        //         else{
        //         $cstring .=  " ,EmploymentStatus";
        //         }
        //    }
        //     if($request->employment_status[0]['cchecked'] == true)
        //    {
        //         if($cstring == '')
        //         {
        //         $cstring = "ContractEmployee" ;
        //         }
        //         else{
        //         $cstring .=  " ,ContractEmployee";
        //         }
        //    }
        //     if($request->employment_status[0]['ochecked'] == true)
        //    {
        //         if($cstring == '')
        //         {
        //         $cstring = "Other" ;
        //         }
        //         else{
        //         $cstring .=  " ,Other";
        //         }
        //    }
        // $cstring = '';
        // if($request->employment_status[0]['pchecked'] == true && $request->employment_status[0]['fchecked'] == false && $request->employment_status[0]['echecked'] == false && $request->employment_status[0]['cchecked']  == false && $request->employment_status[0]['ochecked'] == false)
        // {
        //     $cstring = "Part";
        // }
        // else if($request->employment_status[0]['fchecked'] == true && $request->employment_status[0]['pchecked'] == false && $request->employment_status[0]['echecked'] == false && $request->employment_status[0]['cchecked']  == false && $request->employment_status[0]['ochecked'] == false){

        //     $cstring = "Full";
        // }
        // else if($request->employment_status[0]['fchecked'] == false && $request->employment_status[0]['pchecked'] == false){
        //     $request->validate([
        //         'employment_status' => 'accepted',
        //     ]);
        // }
        // else{
        //     $cstring = "Part,Full";
        // }
        $job = new Job();
        // if($request->occupation_id != null)
        // {
        //     $job->occupation_id = $request->occupation_id;
        // }else{
        //     $job->occupation_id = 0;
        // }
        $job->occupation_id = $request->occupation_id;
        $job->title =$request->input('title');       
        if(isset($request->customer_id)){
            $job->customer_id= $request->customer_id;
        }else{
            $job->customer_id= auth()->user()->customer_id;
        }      
        $job->description = $request->input('description');
        $job->skills = $request->input('skills');
        // $job->city_id = $request->input('city_id');
        // $job->street_address = $request->input('str_address');
        $job->location = $request->input('location');
        $job->nearest_station = $request->input('nearest_station');
        $job->employment_status = $request->employmentstatus;
        // $job->salary_type = $request->input('salary_type');
        $job->salary = $request->input('salary');
        $job->salary_remark = $request->input('salary_remark');
        $job->allowances = $request->input('allowances');
        $job->insurance = $request->input('insurance');
        $job->working_hours = $request->input('working_hours');
        $job->holidays = $request->input('holidays');
        $job->user_id = 1;
        $job->recordstatus = 1;
        $job->zipcode_id = $request->input('zipcode_id');
        $job->township_id = $request->input('str_address');
        if($request->profile_id == 0){
            $job->profile_id = null;
        }else{
            $job->profile_id = $request->input('profile_id');
        }     
        // $query = "SELECT townships.id FROM `townships` INNER JOIN zipcode on townships.township_name = zipcode.city
        //     WHERE zipcode.id = " . $request->input('zipcode_id');
        // $tid = DB::select($query);

        // $infos = DB::table('jobs')
        // ->join('customers', 'customers.id', '=', 'jobs.customer_id')
        // ->select('jobs.*','customers.email')
        // ->where('jobs.id', '=', $jobapply->job_id)
        // ->get();
        // $tid = DB::table('townships')
        //      ->join('zipcode','zipcode.city','=','townships.township_name')
        //      ->select('townships.id')
        //       ->where('zipcode.id','=',$request->input('zipcode_id'))
        //       ->value('townships.id');
        // $job->township_id = $tid;
        $job->save();
        return $job;
    }

    public function edit($id)
    {
        // $job = Job::find($id);
        // $sql = "SELECT jobs.*, zipcode.id as zip_id, zipcode.zip7_code, zipcode.pref as cityname,zipcode.city_id, zipcode.city as township, zipcode.street from jobs inner join zipcode on jobs.zipcode_id = zipcode.id WHERE jobs.id = $id";
        $sql1 = "SELECT * FROM jobs WHERE jobs.id = $id";
        $job1 = DB::select($sql1);
        if($job1[0]->zipcode_id != null){
            $sql = "SELECT jobs.*, zipcode.id as zip_id, zipcode.zip7_code, zipcode.pref as cityname,zipcode.city_id, zipcode.city as township, zipcode.street from jobs inner join zipcode on jobs.zipcode_id = zipcode.id WHERE jobs.id = $id";
        }
        else{
            $sql = "SELECT jobs.*, townships.city_id, townships.id as township_id from jobs inner join townships on jobs.township_id = townships.id WHERE jobs.id = $id";
        }
        $job = DB::select($sql);
        return response()->json(Array("job"=>$job));
    }

    public function update($id, Request $request)
    {
        // $request->validate([
        //     'title' => 'required',
        //     'description' =>'required',
        //     'location' => 'required',
        //     'salary' => 'required',
        //     'working_hours' => 'required',
        // ]);
        $job = Job::find($id);
        if($job != null)
        {
            $string = '';
            $count = count($request->fields);
            for($i = 0;$i< $count ;$i++)
            {
                if($i == $count-1)
                {
                  $string .= $request->fields[$i]['skills'];
                }else{
                    $string .= $request->fields[$i]['skills'] .',';
                }
            }
            if($request->occupation_id != null)
            {
                $job->occupation_id = $request->occupation_id;
            }else{
                $job->occupation_id = 0;
            }
            $job->title =$request->input('title');
            if(isset($request->customer_id)){
                $job->customer_id= $request->customer_id;
            }else{
                $job->customer_id= auth()->user()->customer_id;
            }
            $job->description = $request->input('description');
            $job->skills = $request->input('skills');
            // $job->city_id = $request->input('city_id');
            // $job->street_address = $request->input('str_address');
            $job->location = $request->input('location');
            $job->nearest_station = $request->input('nearest_station');
            $job->employment_status = $request->employmentstatus;
            $job->salary_type = $request->input('salary_type');
            $job->salary = $request->input('salary');
            $job->salary_remark = $request->input('salary_remark');
            $job->allowances = $request->input('allowances');
            $job->insurance = $request->input('insurance');
            $job->working_hours = $request->input('working_hours');
            $job->holidays = $request->input('holidays');
            $job->user_id = 1;
            $job->recordstatus = 1;
            $job->zipcode_id = $request->input('zipcode_id');
            $job->township_id = $request->input('str_address');
            if($request->profile_id == 0){
                $job->profile_id = null;
            }else{
                $job->profile_id = $request->input('profile_id');
            }
            // $query = "SELECT townships.id FROM `townships` INNER JOIN zipcode on townships.township_name = zipcode.city
            //     WHERE zipcode.id = " . $request->input('zipcode_id');
            // $tid = DB::select($query);
            // $infos = DB::table('jobs')
            // ->join('customers', 'customers.id', '=', 'jobs.customer_id')
            // ->select('jobs.*','customers.email')
            // ->where('jobs.id', '=', $jobapply->job_id)
            // ->get();
            // $tid = DB::table('townships')
            //     ->join('zipcode','zipcode.city','=','townships.township_name')
            //     ->select('townships.id')
            //     ->where('zipcode.id','=',$request->input('zipcode_id'))
            //     ->value('townships.id');
            // $job->township_id = $tid;
            $job->save();
            // // $cstring = '';
            // // if($request->employment_status[0]['pchecked'] == true && $request->employment_status[0]['fchecked'] == false)
            // // {
            // //     $cstring = "Part";
            // // }
            // // else if($request->employment_status[0]['fchecked'] == true && $request->employment_status[0]['pchecked'] == false){
            // //     $cstring = "Full";
            // // }
            // // else if($request->employment_status[0]['fchecked'] == false && $request->employment_status[0]['pchecked'] == false){
            // //     $request->validate([
            // //         'employment_status' => 'accepted',
            // //     ]);
            // // }
            // // else {
            // //     $cstring = "Part,Full";
            // // }
            // if($request->occupation_id != null)
            // {
            //     $job->occupation_id = $request->occupation_id;
            // }else{
            //     $job->occupation_id = 0;
            // }
            // $job->skills = $string;
            // $job->title =$request->input('title');
            // $job->customer_id= $request->customer_id;
            // $job->description = $request->input('description');
            // $job->location = $request->input('location');
            // $job->nearest_station = $request->input('nearest_station');
            // $job->employment_status = $request->employmentstatus;
            // $job->salary = $request->input('salary');
            // $job->allowances = $request->input('allowances');
            // $job->insurance = $request->input('insurance');
            // $job->working_hours = $request->input('working_hours');
            // $job->holidays = $request->input('holidays');
            // $job->user_id = $request->user_id;
            // $job->recordstatus = $request->recordstatus;
            // $job ->update();
        }
        return response()->json("Success");
    }

    public function delete($id,$type,$pro_id)
    {
        $job = Job::find($id);
        $getJob = Job::where('id',$id)->get()->toarray();
        $getJobApply= JobApply::where('job_id',$id)->get()->toarray();
        jobApplyLog::insert($getJobApply);
        jobs_log::insert($getJob);
        JobApply::where('job_id',$id)->delete();
        $job->delete();
        if( $type == "admin"){
            $query = "SELECT  jobs.*,customers.type_id,customers.name,(CASE customers.type_id WHEN '2' THEN hospital_profiles.name  ELSE nursing_profiles.name END)as profile_name,(CASE customers.type_id WHEN '2' THEN CONCAT((200000+customers.id),'-',LPAD(hospital_profiles.pro_num, 4, '0'),'-',LPAD(jobs.id, 4, '0')) ELSE CONCAT((500000+customers.id),'-',LPAD(nursing_profiles.pro_num, 4, '0'),'-',LPAD(jobs.id, 4, '0')) END) as jobid 
                        FROM  jobs join customers  on jobs.customer_id = customers.id 
                        left join hospital_profiles on hospital_profiles.id = jobs.profile_id
                        left join nursing_profiles on nursing_profiles.id = jobs.profile_id
                        where customers.recordstatus = 1 and jobs.recordstatus = 1 group by jobs.id order by jobs.id desc ";
            $projob = DB::select($query);        
            foreach($projob as $jobs){
                $job_id = $jobs->id;
                $jobapplies =  DB::table('job_applies')->join('jobs','job_applies.job_id','=','jobs.id')
                            ->where('job_applies.job_id','=',$job_id)->count();
                $jobs->count = $jobapplies;
                $type_id = $jobs->type_id;
                $profile_id = $jobs->profile_id;
                // if($type_id == 2){
                //     $profile_table = 'nursing_profiles';
                // }else{
                //     $profile_table = 'hospital_profiles';
                // }
                // $profile_name = DB::table($profile_table)->select('id','name')->where($profile_table.'.id', '=' , $profile_id)->get();
                // $jobs->profile_name = $profile_name;
            }          
        }else{
            if($pro_id != null)
            {
                if($type == "nursing")
                {
                    $query = "SELECT  jobs.*,customers.type_id,customers.name,nursing_profiles.name as profile_name,CONCAT((500000+customers.id),'-',LPAD(nursing_profiles.pro_num, 4, '0'),'-',LPAD(jobs.id, 4, '0')) as jobid 
                                FROM  jobs join customers  on jobs.customer_id = customers.id 
                                left join job_applies on jobs.id = job_applies.job_id
                                left join nursing_profiles on nursing_profiles.id = jobs.profile_id
                                where customers.recordstatus = 1 and jobs.recordstatus = 1 and nursing_profiles.id = ".$pro_id." 
                                group by jobs.id order by jobs.id desc ";
                }
                else{
                    $query = "SELECT  jobs.*,customers.type_id,hospital_profiles.name as profile_name,customers.name,CONCAT((200000+customers.id),'-',LPAD(hospital_profiles.pro_num, 4, '0'),'-',LPAD(jobs.id, 4, '0')) as jobid 
                                FROM  jobs join customers  on jobs.customer_id = customers.id 
                                left join job_applies on jobs.id = job_applies.job_id
                                left join hospital_profiles on hospital_profiles.id = jobs.profile_id
                                where customers.recordstatus = 1 and jobs.recordstatus = 1 and hospital_profiles.id = ".$pro_id." 
                                group by jobs.id order by jobs.id desc ";
                }
            }
            $projob = DB::select($query);
            foreach($projob as $jobs){
                $job_id = $jobs->id;
                $jobapplies =  DB::table('job_applies')->join('jobs','job_applies.job_id','=','jobs.id')
                            ->where('job_applies.job_id','=',$job_id)->count();
                $jobs->count = $jobapplies;
            }           
        }
        $page = 1;
        $size = 12;
        $data = collect($projob);
        $profilejob = new LengthAwarePaginator(
                               $data->forPage($page, $size),
                               $data->count(), 
                               $size, 
                               $page
                           );
        return response()->json(array('profilejob'=>$profilejob));       
    }

    public function search(Request $request) 
    {          
        $request = $request->all();
        if(isset($request['search_word'])) {
            $search_word = $request['search_word'];
        }else{
            $search_word = null;
        }
        if(isset($request['type'])) {
            $type = $request['type'];
        }else{
            $type = null;
        }
        if(isset($request['pro_id'])) {
            $pro_id = $request['pro_id'];
        }else{
            $pro_id = null;
        }
        // $type = $request['type'];
        // $pro_id = $request['pro_id'];
        $customer_id = auth()->user()->customer_id;
        if($type == "admin"){
            $query = "SELECT  jobs.*,customers.type_id,customers.name,(CASE customers.type_id WHEN '2' THEN hospital_profiles.name  ELSE nursing_profiles.name END)as profile_name,(CASE customers.type_id WHEN '2' THEN CONCAT((200000+customers.id),'-',LPAD(hospital_profiles.pro_num, 4, '0'),'-',LPAD(jobs.id, 4, '0')) ELSE CONCAT((500000+customers.id),'-',LPAD(nursing_profiles.pro_num, 4, '0'),'-',LPAD(jobs.id, 4, '0')) END) as jobid 
                        FROM  jobs join customers  on jobs.customer_id = customers.id 
                        left join hospital_profiles on hospital_profiles.id = jobs.profile_id
                        left join nursing_profiles on nursing_profiles.id = jobs.profile_id
                        where customers.recordstatus = 1  and jobs.title like '%".$search_word."%' 
                        group by jobs.id order by jobs.id desc ";
            $jobsearchs = DB::select($query);
            foreach($jobsearchs as $jobs){
                $job_id = $jobs->id;
                $jobapplies =  DB::table('job_applies')->join('jobs','job_applies.job_id','=','jobs.id')
                            ->where('job_applies.job_id','=',$job_id)->count();
                $jobs->count = $jobapplies;
                $type_id = $jobs->type_id;
                $profile_id = $jobs->profile_id;                   
            }
        }
        else{
            if($pro_id != null)
            {
                if($type == "nursing")
                {
                    $query = "SELECT  jobs.*,customers.type_id,customers.name,nursing_profiles.name as profile_name,CONCAT((500000+customers.id),'-',LPAD(nursing_profiles.pro_num, 4, '0'),'-',LPAD(jobs.id, 4, '0'))  as jobid 
                                FROM  jobs join customers  on jobs.customer_id = customers.id 
                                left join job_applies on jobs.id = job_applies.job_id
                                left join nursing_profiles on nursing_profiles.id = jobs.profile_id
                                where customers.recordstatus = 1  and jobs.title like '%".$search_word."%' 
                                and nursing_profiles.id = ".$pro_id." group by jobs.id order by jobs.id desc ";
                }
                else{
                    $query = "SELECT  jobs.*,customers.type_id,customers.name,hospital_profiles.name as profile_name,CONCAT((200000+customers.id),'-',LPAD(hospital_profiles.pro_num, 4, '0'),'-',LPAD(jobs.id, 4, '0'))  as jobid 
                                FROM  jobs join customers  on jobs.customer_id = customers.id 
                                left join job_applies on jobs.id = job_applies.job_id
                                left join hospital_profiles on hospital_profiles.id = jobs.profile_id
                                where customers.recordstatus = 1  and jobs.title like '%".$search_word."%' 
                                and hospital_profiles.id = ".$pro_id." group by jobs.id order by jobs.id desc ";
                }                    
            }
            $jobsearchs = DB::select($query);
            foreach($jobsearchs as $jobs){
                $job_id = $jobs->id;
                $jobapplies =  DB::table('job_applies')->join('jobs','job_applies.job_id','=','jobs.id')
                            ->where('job_applies.job_id','=',$job_id)->count();
                $jobs->count = $jobapplies;
            }               
        }     
        $page = Input::get('page', 1);
        $size = 12;
        $data = collect($jobsearchs);    
        $jobsearch = new LengthAwarePaginator(
                                $data->forPage($page, $size),
                                $data->count(), 
                                $size, 
                                $page
                            );    
        return response()->json(array('jobsearch'=>$jobsearch));      
    }

    public function confirm($id)
    {
        $jobs =Job::find($id);
        if($jobs->recordstatus == 0 ) {
            $jobs->recordstatus =1;
        }
        else {
            $jobs->recordstatus =0;
        }

        $jobs->save();
            //    $jobs =Job::all()->toArray();
        $data = array("jobs"=> $jobs, "success", "Comment successfully confirmed");
        return response()->json($data);
    }

    public function getCustomerList($type)
    {
        if($type == "nursing") {
            $t = "customers.type_id = 3 and ";
        }
        else if($type == "hospital") {
            $t = "customers.type_id = 2 and ";
        }
        else {
            $t = "";
        }     
        $query = "SELECT customers.id, customers.name, customers.email, customers.type_id FROM customers WHERE $t customers.recordstatus = 1 GROUP BY customers.id";
        $cus_list = DB::select($query);
        return $cus_list;
    }

    public function getProfileList($cId, Request $request){       
        $profile = $request->profile;
        if($cId == 0)
        {
            $query = "SELECT $profile.id, $profile.name FROM $profile where $profile.name is not null and $profile.name != ''";
        }
        else{
            $query = "SELECT $profile.id, $profile.name FROM $profile
            WHERE $profile.customer_id = $cId and $profile.name is not null and $profile.name != ''";
        }
        $profile_list = DB::select($query);
        return $profile_list;
    }

    public function getProfileName($id, Request $request) 
    {
        $profile = $request->profile;
        $query = "SELECT customers.id as cus_id,customers.name as cus_name,customers.email as cus_email, $profile.id, $profile.name FROM $profile 
                join customers on customers.id = $profile.customer_id
                WHERE $profile.id = $id";            
        $profile_name = DB::select($query);
        return $profile_name;
    }
}
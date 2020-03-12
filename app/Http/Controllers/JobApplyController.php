<?php

namespace App\Http\Controllers;

use App\JobApply;
use Illuminate\Http\Request;
use App\Job;
use App\Mail\jobApplyMailToUser;
use App\Mail\jobApplyMailToCustomer;
use App\Mail\jobApplyMailToAdmin;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Input;
use DB;
class JobApplyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
            // $jobapplies = JobApply::all()->toArray();
            // return $jobapplies;
            // $sql = "SELECT job_applies.* from job_applies INNER JOIN jobs ON job_applies.job_id= jobs.id";
            // $jobapplies = DB::select($sql);
            // return $jobapplies;

    }

    public function getJobapplies($jobs_id){
        $sql = "SELECT job_applies.* from job_applies INNER JOIN jobs ON job_applies.job_id= jobs.id WHERE job_applies.job_id = $jobs_id";
        $jobapply = DB::select($sql);
        return $jobapply;
    }
 
    public function jobapplicantlist($type,$page,$search_id){
      

            if($type == "admin")
            {
                $query = "SELECT jobs.title as job_title,job_applies.*,(CASE WHEN customers.type_id = '2' THEN CONCAT((200000+customers.id),'-',LPAD(hospital_profiles.pro_num, 4, '0'),'-',LPAD(jobs.id, 4, '0')) ELSE CONCAT((500000+customers.id),'-',LPAD(nursing_profiles.pro_num, 4, '0'),'-',LPAD(jobs.id, 4, '0')) END) as jobid
                            FROM job_applies join jobs on jobs.id = job_applies.job_id
                            join customers on customers.id = jobs.customer_id
                            left join hospital_profiles on hospital_profiles.id = jobs.profile_id
                            left join nursing_profiles on nursing_profiles.id = jobs.profile_id
                            where  jobs.recordstatus = 1 and customers.recordstatus = 1 ";
               
               if($page == "job"){ 
                    $query .= " and jobs.id = ".$search_id ;
                }

                $query .= " group by job_applies.id order by job_applies.id desc ";              
            }
            else{

                if($type == "nursing") { 
                    $t = "nursing_profiles";
                    $num = 500000;
                }
                else{ 
                    $t = "hospital_profiles"; 
                    $num = 200000;
                }
    
                if($page == "profile"){
                    $p = "$t.id = $search_id";
                }
                else{ 
                    $p = "jobs.id = $search_id"; 
                }

                $query = "SELECT jobs.title as job_title,job_applies.*, ".$t.".name  as proname,CONCAT((".$num."+customers.id),'-',LPAD(".$t.".pro_num, 4, '0'),'-',LPAD(jobs.id, 4, '0')) as jobid
                            FROM job_applies join jobs on jobs.id = job_applies.job_id
                            join customers on customers.id = jobs.customer_id
                            left join ".$t." on ". $t.".id = jobs.profile_id
                            where  jobs.recordstatus = 1 and customers.recordstatus = 1
                            and ".$p." group by job_applies.id order by job_applies.id desc ";
            }

        
            $jobapplicants = DB::select($query);
            $page = Input::get('page', 1);
            $size = 12;
            $data = collect($jobapplicants);

            $jobapplicant = new LengthAwarePaginator(
                                    $data->forPage($page, $size),
                                    $data->count(), 
                                    $size, 
                                    $page
                                );
            return response()->json($jobapplicant);
        
        
    }
 public function jobApplicantDelete($id)
 {
     $jobId = JobApply::find($id);
     $jobId->delete();
    return response()->json('Successfully Delete!');
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

            $string = '';
            $count = count($request->skills);

            for($i = 0;$i< $count ;$i++)
            {

                if($i == $count-1)
                {
                    $string .= $request->skills[$i];
                }else{
                    $string .= $request->skills[$i].',';
                }

            }

            $jobapply = new JobApply;
            $jobapply->job_id = $request->job_id;
            $jobapply->first_name = $request->first_name;
            $jobapply->last_name = $request->last_name;
            $jobapply->birthday = $request->birthday;
            $jobapply->gender = $request->gender;
            $jobapply->postal = $request->postal;
            $jobapply->township_id = $request->township;
            $jobapply->street_address = $request->str_address;
            $jobapply->phone = $request->phone;
            $jobapply->email = $request->email;
            $jobapply->skill = $string;
            $jobapply->remark = $request->remark;

          
            $tid = DB::table('jobs')->join('customers', 'customers.id', '=', 'jobs.customer_id') ->select('customers.type_id')->where('jobs.id',$jobapply->job_id)->get();
            if($tid == '2')
            {
                $t = "hospital_profiles";
                $num = 200000;
            }
            else{
                $t = "nursing_profiles";
                $num = 500000;
            }
   
            $query = "SELECT j.*,$t.email,$t.name as pro_name,c.name as cus_name,ci.city_name as city_name,
                       (CASE c.type_id WHEN '2' THEN CONCAT(($num+c.id),'-',LPAD(j.id, 4, '0')) ELSE CONCAT(($num+c.id),'-',LPAD($t.pro_num, 4, '0'),'-',LPAD(j.id, 4, '0')) END) as jobnum,
                       (CASE c.type_id WHEN '2' THEN CONCAT(($num+c.id),'-',LPAD($t.pro_num, 4, '0')) ELSE CONCAT(($num+c.id),'-',LPAD($t.pro_num, 4, '0')) END) as cusnum 
                        from customers as c 
                        join jobs as j on c.id = j.customer_id 
                        join townships as t on t.id = j.township_id 
                        join cities as ci on ci.id = t.city_id
                        join ".$t." on ".$t.".id = j.profile_id where c.recordstatus=1 and j.id = " . $jobapply->job_id;

            $infos = DB::select($query);



            foreach($infos as $info) {
                $job_title = $info->title;
                $job_description = $info->description;
                $job_location = $info->location;
                $job_nearest_station = $info->nearest_station;
                $job_employment_status = $info->employment_status;
                $salary_type = $info->salary_type;
                $salary_remark = $info->salary_remark;
                $salary = $info->salary;
                // return $salary;
                $job_working_hours = $info->working_hours;
                $customer_mail = $info->email;
                $customer_name = $info->cus_name;
                $jobnum = $info->jobnum;
                $cusnum = $info->cusnum;
                $city_name = $info->city_name;
                $allowances = $info->allowances;
                $insurance = $info->insurance;
                $holidays = $info->holidays;
                $pro_name = $info->pro_name;
            }

            //  $admin_email = 'admin@t-i-s.jp';
            $admin_email = 'wutmone@management-partners.co.jp';
             $jobapply->save();
             $jobapply->job_title = $job_title;
             $jobapply->job_description = $job_description;
             $jobapply->job_location = $job_location;
             $jobapply->job_nearest_station = $job_nearest_station;
             $jobapply->job_employment_status = $job_employment_status;
             $jobapply->job_working_hours = $job_working_hours;
             $jobapply->cus_name = $customer_name;
             $jobapply->jobnum = $jobnum;
             $jobapply->cusnum = $cusnum;
             $jobapply->allowances = $allowances;
             $jobapply->insurance = $insurance;
             $jobapply->holidays = $holidays;
             $jobapply->cityname = $request->selectedCity;
             $jobapply->townshipname = $request->townshipname;
             $jobapply->pro_name = $pro_name;
             if($salary_remark != null || $salary_remark != '')
             {
                $jobapply->salary = $salary_type . ":" . number_format((int)($salary)) . "(" . $salary_remark . ")";
             }
             else{
                $jobapply->salary = $salary_type . ":" . number_format((int)($salary));
             }

           

              \Mail::to($customer_mail)->send(new jobApplyMailToCustomer($jobapply));

            if($jobapply->email != ''){
              \Mail::to($jobapply['email'])->send(new jobApplyMailToUser($jobapply));
            }             
              \Mail::to($admin_email)->send(new jobApplyMailToAdmin($jobapply));
             return response()->json('Apply successfully ');

    }
    public function getJobTitle($jobs_id) {
        $sql = "SELECT jobs.title from jobs WHERE jobs.id = $jobs_id";
        $jobapply = DB::select($sql);
        return $jobapply;
    }

    // public function getSkills()
    // {

    //     $skill = Job::select('skills')->value('skills');
    //      $array =explode(',',$skill);
    //         return ($array);

    //     }


    /**
     * Display the specified resource.
     *
     * @param  \App\JobApply  $jobApply
     * @return \Illuminate\Http\Response
     */
        public function show(JobApply $jobApply)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\JobApply  $jobApply
     * @return \Illuminate\Http\Response
     */
    public function edit(JobApply $jobApply)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\JobApply  $jobApply
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, JobApply $jobApply)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\JobApply  $jobApply
     * @return \Illuminate\Http\Response
     */
    public function destroy(JobApply $jobApply)
    {
        //
    }

    public function search(Request $request)
     {

        $search_word = $request['search_word'];
        $search_id = $request['search_id'];
        $pages = $request['pages'];
        $type = $request['type'];

        if($type == "admin")
        {
            $query = "SELECT jobs.title as job_title,job_applies.*,(CASE WHEN customers.type_id = '2' THEN CONCAT((200000+customers.id),'-',LPAD(hospital_profiles.pro_num, 4, '0'),'-',LPAD(jobs.id, 4, '0')) ELSE CONCAT((500000+customers.id),'-',LPAD(nursing_profiles.pro_num, 4, '0'),'-',LPAD(jobs.id, 4, '0')) END) as jobid
                        FROM job_applies join jobs on jobs.id = job_applies.job_id
                        join customers on customers.id = jobs.customer_id
                        left join hospital_profiles on hospital_profiles.id = jobs.profile_id
                        left join nursing_profiles on nursing_profiles.id = jobs.profile_id
                        where (job_applies.first_name like '%".$search_word."%' or job_applies.last_name like '%".$search_word."%' or job_applies.email like '%".$search_word."%') and  jobs.recordstatus = 1 and customers.recordstatus = 1 ";
          
            if($pages == "job") { 
                $query .= " and jobs.id = ".$search_id ; 
            }

            $query .= " group by job_applies.id order by job_applies.id desc ";              
        }
        else{

            if($type == "nursing"){
                 $t = "nursing_profiles"; 
                 $num = 500000;
            }
            else{ 
                $t = "hospital_profiles";
                $num = 200000;
            }
    
            if($pages == "profile"){ 
                 $p = "$t.id = $search_id"; 
            }
            else{ 
                $p = "jobs.id = $search_id"; 
            }
    
            $query = "SELECT jobs.title as job_title,job_applies.*,(CASE WHEN customers.type_id = '2' THEN ".$t.".name  ELSE ".$t.".name  END) as proname,CONCAT((".$num."+customers.id),'-',LPAD(".$t.".pro_num, 4, '0'),'-',LPAD(jobs.id, 4, '0')) as jobid
                        FROM job_applies join jobs on jobs.id = job_applies.job_id
                        join customers on customers.id = jobs.customer_id
                        left join ".$t." on ". $t.".id = jobs.profile_id
                        where (job_applies.first_name like '%".$search_word."%' or job_applies.last_name like '%".$search_word."%' or job_applies.email like '%".$search_word."%') and jobs.recordstatus = 1 and customers.recordstatus = 1 
                        and ".$p." group by job_applies.id order by job_applies.id desc ";
            
        }

        


        $jobapplicants = DB::select($query);
       
        $page = Input::get('page', 1);
        $size = 12;
        $data = collect($jobapplicants);
     

        $jobapplicant = new LengthAwarePaginator(
                                $data->forPage($page, $size),
                                $data->count(), 
                                $size, 
                                $page
                            );
                           
        return response()->json($jobapplicant);

        //     $request = $request->all();
        //     $search_word = $request['search_word'];
        //     $customer_id = auth()->user()->customer_id;
        //     $query = DB::table('job_applies');
        //     if(auth()->user()->role == 2){
        //     $query = $query->where(function($qu) use ($search_word){
        //                         $qu->where('job_applies.first_name', 'LIKE', "%{$search_word}%")
        //                             ->orWhere('job_applies.last_name', 'LIKE', "%{$search_word}%")
        //                             ->orWhere('job_applies.email', 'LIKE', "%{$search_word}%");
        //                     });
        //     $query = $query->orderBy('job_applies.id','DESC')
        //                     ->paginate(12);
        //     return response()->json($query);
        //      }else {
        //     $query = $query->leftjoin('jobs','job_applies.job_id','=','jobs.id');
        //     $query = $query->join('customers','customers.id','=','jobs.customer_id');
        //     $query = $query->where('customer_id', $customer_id);
        //     if(array_key_exists('job_id',$request)) {
        //         $query = $query->where('job_applies.job_id', $request['job_id']);
        //     }
        //     $query = $query->where(function($qu) use ($search_word){
        //                         $qu->where('job_applies.first_name', 'LIKE', "%{$search_word}%")
        //                             ->orWhere('job_applies.last_name', 'LIKE', "%{$search_word}%")
        //                             ->orWhere('job_applies.email', 'LIKE', "%{$search_word}%");
        //                     });
        //     $query = $query->orderBy('job_applies.id','DESC')
        //                 ->paginate(12);
                            
        //     return $query;
        // }
    }
}

<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\User;
use App\Customer;
use App\password_reset;
use Illuminate\Support\Facades\Mail;
use App\Mail\sendResetPasswordMail;
use Carbon;
use DB;
use Redirect;
use App\Type;
use Session;
use App\password_reset_view;
use App\Mail\customerCreateMail;
class registerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   $type = Type::all();
        $cities = DB::table('cities')->get();
        $townships = DB::table('townships')->get();
        return view('register',compact('type','townships','cities'));
    }
    public function getCities()
    {
        // $cities = $_GET['cities'];
        $data = DB::table('cities')->select('id','city_name')->get();
        return response()->json(array('result' => true,'cities' => $data),200);
    }
    public function getTownship()
    {
        $cities = $_GET['city'];
        $data = DB::table('townships')->select('id','township_name','city_id')->where('city_id',$cities)->get();
        return response()->json(array('result' => true,'townships' => $data),200);
    }
    public function getType()
    {
        $type = $_GET['type'];
        $data = DB::table('types')->select('id','name','user_id','parent')->where('parent',$type)->get();
        return response()->json(array('result' => true,'types' => $data),200);
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


        $request->validate( [
            "file('img')" => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'name' => 'required|min:3|max:50',
            'email' => 'required|email|unique:customers',
            'phone' => 'max:13',
            'password' => 'min:6|required_with:comfirm_password|same:comfirm_password',
            'comfirm_password' => 'min:6',
            //'address' =>'required',
            'cities'=> 'required',
            'township'=> 'required',
        ]);
        
  
            // $type = 2;

            // if($request->types == '3'){
            //     $type = $request->nursing;
            // }

            // $destinationPath = public_path('/images');
            $image = $request->file('img');
            
            $getName = time().'.'.$image->getClientOriginalExtension();
            
            if($request->types == 2){     
                $image->move('upload/hospital_profile/', $getName);
            }
            else{
                $image->move('upload/nursing_profile/', $getName);
            }            
            // $dbPath = $destinationPath. '/'.$input['img'];
            $customer = new Customer;
            $customer->logo= $getName;
            $customer->name = $request->name;
            $customer->email = $request->email;
            $customer->phone = $request->phone;
            $customer->type_id = $request->types;
            $customer->password = bcrypt($request->password);
            // $customer->address = $request->address;
            $customer->townships_id = $request->township;
            $customer->save();

            if($request->types == 2){
                $customer->type = '病院';
            }
            else{
                $customer->type = '介護';
            }

            // elseif($request->types == 4){
            //     $customer->type = '介護  (有料老人ホーム)';
            // }
            // elseif($request->types == 5){
            //     $customer->type = '介護 (デイサービス)';
            // }
            // elseif($request->types == 6){
            //     $customer->type = '介護  (訪問介護・看護)';
            // }
            $query = "SELECT townships.*, cities.city_name
                    FROM townships 
                    JOIN cities
                    ON cities.id = townships.city_id
                    WHERE townships.id =" . $customer->townships_id;

            $address = DB::select($query);
            foreach($address as $ad) {
                $customer->city_name = $ad->city_name;
                $customer->township_name = $ad->township_name;
            }

            // $admin_email = 'thuzar.ts92@gmail.com';
            $admin_email = 'susan@management-partners.co.jp';
            \Mail::to($admin_email)->send(new customerCreateMail($customer));

            Session::flash('success reg', "Special message goes here");
            return Redirect::back();

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
    // regisert end
    public function reset(Request $request)
    {
        // return view('auth.passwordReset');
        $getEmail = $request->email;
       
        $checkmail = User::where('email',$getEmail)->select('*')->get();
       
        if(!$checkmail->isEmpty()){
         
            $getTime = Carbon\Carbon::now();
            $token = md5($getEmail.$getTime);
            $data = array([
                'email' => $getEmail,
                'token' => $token,
                'created_at' => $getTime,
            ]);
            DB::table('password_resets')->insert($data);
            $checkmail[0]["role"] = $token;    
            \Mail::to($getEmail)->send(new sendResetPasswordMail($checkmail));
            return response()->json(['success' => 'success'], 200);
            // return back()->with('reset','Check Your email for reset password');
        }
        else{
          
            return response()->json(['error' => 'error'], 404);
            // return back()->with('reset','Email Not Exist.');
        }
    }

    public function resetpassword(Request $request)
    {
        // return view('auth.passwordReset');
        $hashPass = bcrypt($request->password);
        $token = $request->token;
        $checkmail = DB::select('SELECT email FROM password_resets WHERE token = "'.$token.'" AND created_at > DATE_SUB(CURDATE(), INTERVAL 2 DAY)');
        if(!empty($checkmail)){    
            $getEmail = $checkmail[0]->email;
            $updatePass = array(
                'password' => $hashPass
            );
            DB::table('users')->where('email',$getEmail)->update($updatePass);
            DB::table('customers')->where('email',$getEmail)->update($updatePass);
            DB::table('password_resets')->where('email',$getEmail)->delete();
            return response()->json("success");
        }
        else{
            DB::table('password_resets')->where('email',$getEmail)->delete();
            return response()->json("Expired. Please reset mail send again.");
        }
    }

    public function insertUesr(Request $request)
    {
        $getEmail = $request->email;
        $CheckUserEmail = User::where('email',$getEmail)->select('email')->value('email');
        $checkResetEmail = password_reset::where('email',$getEmail)->select('email')->value('email');
        if(!empty($checkResetEmail)){
            return back()->with('reset','Your Email is already reset password!');
        }else{
            if(!empty($CheckUserEmail)){
                $getUserId = User::where('email',$getEmail)->select('id')->value('id');
                $getCustomerId = Customer::where('email',$getEmail)->select('id')->value('id');
                $getTime = Carbon\Carbon::now();
                $data = array([
                    'email' => $getEmail,
                    'user_id' => $getUserId,
                    'customer_id' => $getCustomerId,
                    'created_at' => $getTime,
                ]);
                DB::table('password_reset')->insert($data);
                return back()->with('reset','Check Your email for new password. When admin approved,you can use your password');
            }else{
                return back()->with('reset','Your Email is not register');
            }
        }
    }
    public function getReset()
    {
        $getReset = DB::table('password_reset_view')->get();
        return response()->json($getReset);
    }
    public function approve($id)
    {
        $getEmail = password_reset::where('id',$id)->select('email')->value('email');
        $password = str_random(6);
        $hashPass = bcrypt($password);
        $updateUser = array(
            'password' => $hashPass
        );
        $updateReset = array(
            'password' => $password,
            'status' => 1
        );
        $updateCustomer = array(
            'password' => $hashPass
        );
        DB::table('password_reset')->where('id',$id)->update($updateReset);
        DB::table('users')->where('email',$getEmail)->update($updateUser);
        DB::table('customers')->where('email',$getEmail)->update($updateCustomer);
        $resetPass= password_reset_view::findOrFail($id);
        \Mail::to($getEmail)->send(new sendResetPasswordMail($resetPass));
        return response()->json('success approved and send mail');
    }

}
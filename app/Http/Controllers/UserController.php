<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Spatie\Permission\Models\Role;
use DB;
use Hash;
use App\Customer;
use App\NursingProfile;
use App\HospitalProfile;

class UserController extends Controller

{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        //  $this->middleware('permission:role-list');
        //  $this->middleware('permission:role-create', ['only' => ['create','store']]);
        //  $this->middleware('permission:role-edit', ['only' => ['edit','update']]);
        //  $this->middleware('permission:role-delete', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        $data = User::orderBy('id','DESC')->paginate(5);
        return view('users.index',compact('data'))
            ->with('i', ($request->input('page', 1) - 1) * 5);
    }

    public function checkuser(Request $request)
    {
        $lat_lng = null;
        if($request->user()->type_id == 2){
            $lat_lng = HospitalProfile::select('id','latitude','longitude')->where('customer_id', $request->user()->customer_id)->get();
        }
        else if($request->user()->type_id > 2) {
            $lat_lng = NursingProfile::select('id','latitude','longitude')->where('customer_id', $request->user()->customer_id)->get();
        }
        return response()->json(array("user"=>$request->user(), "lat_lng"=>$lat_lng));
    }

    public function checkprofile(Request $request,$type,$proid)
    {
        $lat_lng = null;        
        if($type == 'hospital'){
            $lat_lng = HospitalProfile::select('id','latitude','longitude')->where('id', $proid)->get();
        }
        else if($type == 'nursing') {
            $lat_lng = NursingProfile::select('id','latitude','longitude')->where('id', $proid)->get();
        }    
        return response()->json(array("user"=>$request->user(), "lat_lng"=>$lat_lng));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::pluck('name','name')->all();
        return view('users.create',compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [

            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|same:confirm-password',
            'roles' => 'required'
        ]);
        $input = $request->all();
        $input['password'] = Hash::make($input['password']);
        $user = User::create($input);
        $user->assignRole($request->input('roles'));
        return redirect()->route('users.index')
                     ->with('success','User created successfully');
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);
        return view('users.show',compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);
        $roles = Role::pluck('name','name')->all();
        $userRole = $user->roles->pluck('name','name')->all();
        return view('users.edit',compact('user','roles','userRole'));
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
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$id,
            'password' => 'same:confirm-password',
            'roles' => 'required'
        ]);
        $input = $request->all();
        if(!empty($input['password'])){ 
            $input['password'] = Hash::make($input['password']);
        }else{
            $input = array_except($input,array('password'));    
        }
        $user = User::find($id);
        $user->update($input);
        // DB::table('model_has_roles')->where('model_id',$id)->delete();
        $user->assignRole($request->input('roles'));
        return redirect()->route('users.index')
                        ->with('success','User updated successfully');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        User::find($id)->delete();
        return redirect()->route('users.index')
                        ->with('success','User deleted successfully');
    }

    public function movePhoto(Request $request)
    {
        $request = $request->all();
        $user = User::find(auth('api')->user()->id);
        $tmp = $request['file'];
        $imageName = $request['photo'];
        $imageName = str_replace(' ', '', $imageName);
        $imageName = strtolower($imageName);
        if($user['type_id'] == '2') {
            $destination = 'upload/hospital_profile/'.$imageName;
        }
        else {
            $destination = 'upload/nursing_profile/'.$imageName;
        }
        move_uploaded_file($tmp, $destination);        
    }

    public function changePassword(Request $request) 
    {
        $request = $request->all();
        $cusId = $request['cus_id'];
        if(auth()->user()->role == 2) {
            $customer = Customer::find($cusId);
            $user = User::find($customer['user_id']);
        }else{
            $getUser = auth('api')->user()->id;
            $customer = Customer::where('user_id',$getUser)->first();
            $user = User::find(auth('api')->user()->id);
        }    
        if (Hash::check($request['old_pass'], $user['password'])) {
            $customer->password = Hash::make($request['new_pass']);
            $user->password = Hash::make($request['new_pass']);            
            $customer->save();
            $user->save();
        } 
        else {
            return response()->json('oldpasswordwrong');
        }
    }

    public function changeEmail(Request $request) 
    {
        $request = $request->all();
        $cusId = $request['cus_id'];
        $customer = Customer::find($cusId);
        if(auth()->user()->role == 2) {            
            $user = User::find($customer['user_id']);
        }else{
            $user = User::find(auth('api')->user()->id);
        } 
        if ($request['name'] != null && $request['name'] != ''){
            $user->name = $request['name'];
            $customer->name = $request['name'];
        }
        $user->email = $request['email'];
        $user->save();        
        $customer->email = $request['email'];        
        $customer->save();
        return $customer;
    }

    public function getAdminList(Request $request) 
    {
        $admin_list = User::where('role',2)->get();
        return $admin_list;
    }

    public function deleteAdmin($id) 
    {
        $admin_list = User::find($id)->delete();
        $admin_list = User::where('role',2)->get()->toArray();
        return array_reverse($admin_list);
    }

    public function storeAdmin(Request $request) {      
        $this->validate($request, [
            'email' => 'unique:users',
            'password' => 'min:6'
        ]);
        $input = $request->all();          
        $admin = new User();
        $admin->name = $input['name'];
        $admin->email = $input['email'];
        $admin->password = Hash::make($input['password']);
        $admin->role = 2;
        $admin->type_id = 1;
        $admin->save();
        return response()->json('The Admin successfully added');
    }

    public function editAdmin($id) {
        $admin = User::find($id);
        return response()->json($admin);
    }

    public function updateAdmin(Request $request) 
    {
        $input = $request->all();
        $adminId = $input['admin_id'];
        $admin = User::find($adminId);
        if($input['old_pass'] == ''){
            $admin->name = $input['name'];
            $admin->email = $input['email'];
            $admin->save();
            return response()->json('The Admin successfully updated');
        }else{
            if(Hash::check($input['old_pass'] , $admin['password'])){
                $admin->name = $input['name'];
                $admin->email = $input['email'];
                $admin->password = Hash::make($request->input('new_pass'));
                $admin->role = 2;
                $admin->type_id = 1;
                $admin->save();
                return response()->json('The Admin successfully updated');
            }else{
                return response()->json('oldpasswordwrong');
            }
        }
    }

    // public function changePassword(Request $request) {
    //     $request = $request->all();
    //     $cusId = $request['cus_id'];
    //     if(auth()->user()->role == 2) {
    //         $customer = Customer::find($cusId);
    //         $user = User::find($customer['user_id']);
    //     }else{
    //         $user = User::find(auth('api')->user()->id);
    //     }    
    //     if (Hash::check($request['old_pass'], $user['password'])) {
    //         $user->password = Hash::make($request['new_pass']);
    //         $user->save();
    //     } 
    //     else {
    //         return response()->json('oldpasswordwrong');
    //     }
    // }
}
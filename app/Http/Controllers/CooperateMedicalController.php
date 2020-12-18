<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cooperate_Medical;
use DB;

class CooperateMedicalController extends Controller
{
    public function getCooperateByCustomerId($profile_id) {
        $cooperate_list = Cooperate_Medical::where("profile_id",$profile_id)
                            ->select('id','name','clinical_subject','details','medical_expense','remark')
                            ->get()
                            ->toArray();
        return $cooperate_list;
    }
}

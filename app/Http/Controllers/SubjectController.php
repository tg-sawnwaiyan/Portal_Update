<?php

namespace App\Http\Controllers;

use App\Subject;
use App\HospitalProfile;
use App\SubjectJunctions;
use DB;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    public function index()
    {
        $Subjects = Subject::orderBy('id', 'DESC')->paginate(20);
        for($i=0;$i<count($Subjects);$i++)
        {
            if($Subjects[$i]['parent'] != 0)
            {
               $Subjects[$i]['parent']  = Subject::where('id',$Subjects[$i]['parent'])->select('name')->value('name');
            }
            else{
                $Subjects[$i]['parent'] = "None";
            }
        }
        return response()->json($Subjects);
    }

    public function Subjectlist()
    {
        $Subjectlist = Subject::select('id','name')->where('parent',0)->get()->toArray();
        return $Subjectlist;
    }

    public function getParent()
    {
        $Subjectlist = Subject::select('id','name')->get()->toArray();
        return $Subjectlist;
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);
        if( $request->parent != null)
        {
            $Subject = new Subject();
            $Subject->name = $request->input('name');
            $Subject->user_id = 1;
            $Subject ->parent = $request->parent;
            $Subject ->recordstatus = 1;
        }
        else if( $request->parent == null)
        {
            $Subject = new Subject();
            $Subject->name = $request->input('name');
            $Subject->user_id = 1;
            $Subject ->parent = 0;
            $Subject ->recordstatus = 2;
        }
        $Subject->save();
        return $Subject;
    }

    public function edit($id)
    {
        $subject = Subject::find($id);
        return response()->json($subject);
    }

    public function update($id, Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);
        if($request->parent != null)
        {
            $Subject = Subject::find($id);
            $Subject->name = $request->input('name');
            $Subject->user_id = 1;
            $Subject ->parent = $request->parent;
            $Subject ->recordstatus = 1;
            $Subject->save();
        }
        else{
            $Subject = Subject::find($id);
            $Subject->name = $request->input('name');
            $Subject->user_id = 1;
            $Subject ->parent = 0;
            $Subject ->recordstatus = 1;
            $Subject->save();
        }
        // $Subject->update($request->all());
        return response()->json('The Subject successfully updated');
    }

    public function destroy($id)
    {
        $Subject = Subject::find($id);
        $sub_junction = "SELECT * FROM subject_junctions WHERE subject_junctions.subject_id = $id";
        $junction_data = DB::select($sub_junction);
        if(count($junction_data) != 0) {
            return response()->json(['error' => 'この診療科目に関連している病院施設がありますので削除できません。'], 404);
        }else{
            $Subject->delete();
        // return response()->json('The Subject was successfully deleted');
        $subjects = Subject::orderBy('id', 'DESC')->paginate(20);
        return response()->json($subjects);
        }        
    }

    public function search(Request $request) {
        $request = $request->all();
        if(isset($request['search_word'])) {
            $search_word = $request['search_word'];
        }else{
            $search_word = null;
        }
        $search_subjects = Subject::query()
                            ->where('name', 'LIKE', "%{$search_word}%")
                            ->orderBy('id','DESC')
                            ->paginate(20);
        return response()->json($search_subjects);
    }

    public function getHospitalClinicalSubject($customer_id) {
        $subject_list = Subject::where('parent','!=',0)->get()->toArray();

        $clinical_subject = SubjectJunctions::where('profile_id','=',$customer_id)->get()->toArray();
        for($indx=0; $indx<count($clinical_subject); $indx++) {
            for($sec_indx = 0; $sec_indx<count($subject_list); $sec_indx++) {
                if($clinical_subject[$indx]['subject_id'] == $subject_list[$sec_indx]['id']) {
                    $subject_list[$sec_indx]['checked'] = "checked";
                }
            }
        }
        return $subject_list;
    }
}
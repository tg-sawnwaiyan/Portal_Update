<?php

namespace App\Http\Controllers;
use App\special_feature;
use App\NursingProfile;
use App\HospitalProfile;
use App\SpecialFeaturesJunctions;
use Illuminate\Http\Request;
use DB;

class SpecialFeatureController extends Controller
{
    public function index($type)
    {
        $feature = special_feature::where('type','=',$type)->orderBy('id', 'desc')->paginate(20);
        return response()->json($feature);
    }

    public function getFeaturebyProfileType($profile_type,$customer_id) 
    {       
        $cooperate_list = special_feature::where('type','=',$profile_type)->get()->toArray();       
        $profile_feature = SpecialFeaturesJunctions::where('profile_id','=',$customer_id)->get()->toArray();      
        for($indx=0; $indx<count($profile_feature); $indx++) {
            for($sec_indx = 0; $sec_indx<count($cooperate_list); $sec_indx++) {
                if($profile_feature[$indx]['special_feature_id'] == $cooperate_list[$sec_indx]['id']) {
                    $cooperate_list[$sec_indx]['checked'] = "checked";
                }
            }
        }
        return $cooperate_list;
    }

    public function add(Request $request)
    {
        // $request->validate([
        //     'name' => 'required|unique:special_features',
        //     'short_name'=>'required|unique:special_features',
        //     'type'=>'required',
        // ],[
        //     'name.required' => '名前の入力が必要です。',
        //     'name.unique'=>'名前はすでに使用されています。',
        //     'short_name.unique'=>"短い名はすでに使用されています。",
        //     'short_name.required'=>'短い名の入力が必要です。',
        //     'type.required'=>'タイプの入力が必要です。'
        // ]);
        $feature = new special_feature;
        $feature->name=$request->name;
        $feature->short_name=$request->short_name;
        $feature->type=$request->type;
        $feature->user_id=1;
        $feature->recordstatus=1;
        $feature ->save();
        return $feature;
    }

    public function edit($id)
    {
        $feature = special_feature::find($id);
        return response()->json($feature);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'short_name'=>'required',
            'type'=>'required',
        ],[
            'name.required' => '名前の入力が必要です。',
            'short_name.required'=>'短い名の入力が必要です。',
            'type.required'=>'タイプの入力が必要です。',
        ]);
        $feature = special_feature::find($id);
        $feature->name = $request->name;
        $feature->short_name = $request->short_name;
        $feature->type = $request->type;
        $feature->user_id = 1;
        $feature->save();
        return response()->json('The Feature successfully updated');
    }

    public function delete($id,$type)
    {
        $feature = special_feature::find($id);
        if($type == 'nursing') {
            $feature_junction = "SELECT * FROM special_features_junctions WHERE special_features_junctions.special_feature_id = $id";
            $junction_data = DB::select($feature_junction);
            if(count($junction_data) != 0) {
                return response()->json(['error' => 'この特徴に関連している施設がありますので削除できません。'], 404);
            }else{
                $feature->delete();
                $features = special_feature::where('type',$type)->orderBy('id','DESC')->paginate(20);
                return response()->json($features);
            }
        }else{
            $feature_junction = "SELECT * FROM special_features_junctions WHERE special_features_junctions.special_feature_id = $id";
            $junction_data = DB::select($feature_junction);
            if(count($junction_data) != 0) {
                return response()->json(['error' => 'この特徴に関連している施設がありますので削除できません。'], 404);
            }else{
                $feature->delete();
                $features = special_feature::where('type',$type)->orderBy('id','DESC')->paginate(20);
                return response()->json($features);
            }
        }
    }

    public function search(Request $request,$type)
    {
        $request = $request->all();
        if(isset($request['search_word'])) {
            $search_word = $request['search_word'];
        }else{
            $search_word = null;
        }
        $special_feature = special_feature::where('type',$type)
                            ->where(function($query) use($search_word){
                                $query->where('name', 'LIKE', "%{$search_word}%")
                                ->orwhere('short_name', 'LIKE', "%{$search_word}%");
                            })
                            ->orderBy('id','DESC')
                            ->paginate(20);
        return response()->json($special_feature);
    }
}
<?php

namespace App\Http\Controllers;
use App\SpecialFeaturesJunctions;

use Illuminate\Http\Request;

class SpecialFeaturesJunctionsController extends Controller
{ 

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request = $request->all();

        $feature = SpecialFeaturesJunctions::where('profile_id', $id)
                    ->delete();

        for($indx=0; $indx<count($request[0]['special_feature_id']); $indx++) {
            $new_feature = new SpecialFeaturesJunctions();
            $new_feature->profile_id = $id;
            $new_feature->special_feature_id = $request[0]['special_feature_id'][$indx];
            $new_feature->save();
        }

        return response()->json('The Feature successfully updated');
    } 
}

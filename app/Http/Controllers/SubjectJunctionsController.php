<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\SubjectJunctions;

class SubjectJunctionsController extends Controller
{ 
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function update(Request $request, $id)
    // {
    //     $request = $request->all();

    //     $subject = SubjectJunctions::where('customer_id', $id)
    //                 ->delete();

    //     for($indx=0; $indx<count($request[0]['subject_id']); $indx++) {
    //         $new_subject = new SubjectJunctions();
    //         $new_subject->customer_id = $id;
    //         $new_subject->subject_id = $request[0]['subject_id'][$indx];
    //         $new_subject->save();
    //     }

    //     return response()->json('The Subject successfully updated');
    // }

    
}

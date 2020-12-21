<?php

namespace App\Http\Controllers;

use App\Occupations;
use DB;
use Illuminate\Http\Request;

class OccupationsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $occupation = Occupations::orderBy('id','DESC')->paginate(20);
        return response()->json($occupation);
    }

    public function typelist()
    {
        $occupationList = Occupations::select('id','name')->where('parent',0)->get()->toArray();
        return $occupationList;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:occupation',
        ]);

        if( $request->parent != null)
        {
            $occupation = new Occupations();
            $occupation->name    = $request->input('name');
            $occupation->user_id = 1;
            $occupation ->parent = $request->parent;
            $occupation ->recordstatus = 1;
        }
        else if( $request->parent == null)
        {
            $occupation = new Occupations();
            $occupation->name    = $request->input('name');
            $occupation->user_id = 1;
            $occupation ->parent = 0;
            $occupation ->recordstatus = 2;
        }

        $occupation->save();

        return $occupation;
    } 
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Occupations  $occupations
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $occupation = Occupations::find($id);
        return response()->json($occupation);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Occupations  $occupations
     * @return \Illuminate\Http\Response
     */
    public function update($id, Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);
        if($request->parent != null)
        {
            $occupation = Occupations::find($id);
            $occupation->name    = $request->input('name');
            $occupation->user_id = 1;
            $occupation ->parent = $request->parent;
            $occupation ->recordstatus = 2;
            $occupation->save();
        }
        else{
            $occupation = Occupations::find($id);
            $occupation->name    = $request->input('name');
            $occupation->user_id = 1;
            $occupation ->parent = 0;
            $occupation ->recordstatus = 2;
            $occupation->save();
        }
        return response()->json('The Type successfully updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Occupations  $occupations
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $occupation = Occupations::find($id);
        $query = "SELECT * FROM jobs WHERE jobs.occupation_id = $id";
        $jobs = DB::select($query);
        if(count($jobs) != 0){
            return response()->json(['error' => 'この求人職種に関連している施設がありますので削除できません。'], 404);
        }else{
            $occupation->delete();
        $occupations = Occupations::orderBy('id','DESC')->paginate(20);
        return response()->json($occupations);
        }
    }

    public function search(Request $request)
    {
        $request = $request->all();
        if(isset($request['search_word'])) {
            $search_word = $request['search_word'];
        }else{
            $search_word = null;
        }
        $search_occupations = Occupations::query()
                            ->where('name', 'LIKE', "%{$search_word}%")
                            ->orderBy('id','DESC')
                            ->paginate(20);
        return response()->json($search_occupations);
    }
}

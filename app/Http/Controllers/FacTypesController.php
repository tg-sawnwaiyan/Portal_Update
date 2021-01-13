<?php

namespace App\Http\Controllers;

use App\FacType;
use Illuminate\Http\Request;

class FacTypesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $facility_types = FacType::all()->toArray();
        return array_reverse($facility_types);
    } 
 
}

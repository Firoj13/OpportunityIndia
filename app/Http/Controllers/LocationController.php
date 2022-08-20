<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\State;
use App\Models\City;

class LocationController extends Controller
{
	/*
	* Get all categories.
	*/
    function getStates(){		
        $states = State::select("id","name")
        ->get()
        ->toArray();
        return response()->json($states);
	}

    function getCities($stateId=0){		
        $cities = City::select("id","city_name AS name")
		->where('state_id',$stateId)
        ->get()
        ->toArray();
        return response()->json($cities);
	}
}

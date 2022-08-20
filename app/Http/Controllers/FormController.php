<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Form;
use Validator;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class FormController extends Controller
{

	/*
	* Contact Form  
	*/
	function contact(Request $request){
	  $data = request()->post();
	  $now = Carbon::now();

	  $formId=DB::table('forms')->insertGetId([
           'form_type' => 'Contact',
           'created_at' => $now,
           'updated_at'=>$now
        ]);
	  	$insert=[];
		foreach ($data as $key=>$value) {
		    $insert[]=['formid'=>$formId,'field_name'=>$key,'field_value'=>$value,'updated_at'=>$now];
		}	
		//print_r($insert);
        DB::table('forms_data')->insert($insert);		
		return response()->json("We will contact you soon...");
	 }

	/*
	* Feedback Form  
	*/
	function feedback(Request $request){
	  $data = request()->post();
	  $now = Carbon::now();

	  $formId=DB::table('forms')->insertGetId([
           'form_type' => 'feedback',
           'created_at' => $now,
           'updated_at'=>$now
        ]);
	  	$insert=[];
		foreach ($data as $key=>$value) {
		    $insert[]=['formid'=>$formId,'field_name'=>$key,'field_value'=>$value,'updated_at'=>$now];
		}	
		//print_r($insert);
        DB::table('forms_data')->insert($insert);		
		return response()->json("Thank you for the feedback");
	 }

}

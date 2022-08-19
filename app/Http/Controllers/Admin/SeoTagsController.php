<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use App\Models\Languages;
use App\Models\SeoTagsEn;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use phpDocumentor\Reflection\Types\Collection;

class SeoTagsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');

    }
    public function index(Request $request)
    {

        if(!Auth::user()->hasPermissionTo('manage-seo-tags')){
            return Redirect::to('/admin/home')->with('warning',"Opps! You don't have sufficient permissions");
        }
        $tags = SeoTagsEn::orderBy('id','DESC');


        if($request->has('search')){
            $tags->whereRaw("id = '".$request->search."' OR name LIKE '%".$request->search."%' OR slug LIKE '%".$request->search."%'");
        }
        $items=$tags->paginate(15);

        return view('admin.seo_tags_eng.index',compact('items'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $langs = Languages::all();
        return view('admin.seo_tags_eng.create',compact('langs'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {


        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:seo_tags_en,name',
        ]);

        if($validator->fails()){
            $errors=$validator->errors()->first();
            return back()->with("warning", $errors);
        }
        $slug = str_slug($request->input('name'));


        $tags = SeoTagsEn::create(['language_code'=> $request->input('language'),'name' => $request->input('name'),'slug' => $slug]);
        if($tags) {
            return redirect()->route('seoTags')->with("added", 'Tags Has Been Added');
        }else{
            $errors = "Something went wrong";
            return back()->with("warning", $errors);
        }
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $tags = SeoTagsEn::find($id);

        return view('seo_tags_en.show',compact('tags'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $tags = SeoTagsEn::find($id);
        return view('admin.seo_tags_eng.edit',compact('tags'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:seo_tags_en,name',
        ],
            [
                'required' => 'Tag Name Is Required',
                'unique' => 'Please do any updates'
            ]
        );

        if($validator->fails()){
            $errors=$validator->errors()->first();
            return back()->with("warning", $errors);
        }
        $tags = SeoTagsEn::find($request->id);
        $slug = str_slug($request->input('name'));
        $tags->name = $request->input('name');
        $tags->slug = $slug;
        $tags->save();

        return redirect()->route('seoTags')->with("added", 'Tags Has Been Updated');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::table("seo_tags_ens")->where('id',$id)->delete();
        return redirect()->route('seo-tags-en.index')
            ->with('success','Tags deleted successfully');
    }

    public function autoLoadSeoTags(Request $request)
    {

        $data = DB::select(DB::raw("select * from seo_tags_en where name like '%$request->tag%'"));

        $data = collect($data);

        $data = $data->pluck('name');

        return response()->json($data);
    }

    function make_slug($string)
    {
        $string = trim($string);$string=strtolower($string);
        $string
            =preg_replace("/[^a-z0-9_ोौेैा्ीिीूुंःअआइईउऊएऐओऔकखगघचछजझञटठडढतथदधनपफबभमयरलवसशषहश्रक्षटठडढङणनऋड़\s-]/u",
            "", $string);
        $string = preg_replace("/[\s-]+/", " ", $string); $string = preg_replace("/[\s]/", '-', $string);

        return $string ;
    }

    public function bengali_slug($string){

          $string = trim($string);$string=strtolower($string);
        $string
            =preg_replace('/\s+/u', '-', trim($string));
        $string = preg_replace("/[\s-]+/", " ", $string); $string = preg_replace("/[\s]/", '-', $string);

        return $string ;
    }
    public function bengali_clean($string){

        $string = trim($string);$string=strtolower($string);
        $string
            =preg_replace('/\s+/u', '-', trim($string));
        $string = preg_replace("/[\s-]+/", " ", $string); $string = preg_replace("/[\s]/", '-', $string);

        return $string ;
    }

    function hindi_clean($string)
    {
        $string = trim($string);$string=strtolower($string);
        $string
            =preg_replace("/[^a-z0-9_ोौेैा्ीिीूुंःअआइईउऊएऐओऔकखगघचछजझञटठडढतथदधनपफबभमयरलवसशषहश्रक्षटठडढङणनऋड़\s-]/u",
            "", $string);
        $string = preg_replace("/[\s-]+/", " ", $string); $string = preg_replace("/[\s]/", ' ', $string);

        return $string ;
    }

}

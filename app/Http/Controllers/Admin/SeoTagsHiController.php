<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Languages;
use App\Models\SeoTagsHi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class SeoTagsHiController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:admin');

    }

    public function index(Request $request)
    {

        if (!Auth::user()->hasPermissionTo('manage-seo-tags-hi')) {
            return Redirect::to('/admin/home')->with('warning', "Opps! You don't have sufficient permissions");
        }
        $tags = SeoTagsHi::orderBy('id', 'DESC');


        if ($request->has('search')) {
            $tags->whereRaw("id = '" . $request->search . "' OR name LIKE '%" . $request->search . "%' OR slug LIKE '%" . $request->search . "%'");
        }
        $items = $tags->paginate(15);

        return view('admin.seo_tags_hi.index', compact('items'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $langs = Languages::all();
        return view('admin.seo_tags_hi.create', compact('langs'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {


        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:seo_tags_hi,name',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors()->first();
            return back()->with("warning", $errors);
        }

        $slug = $this->make_slug($request->input('name'));


        $tags = SeoTagsHi::create(['name' => $request->input('name'), 'slug' => $slug]);
        if ($tags) {
            return redirect()->route('seoTagsHi')->with("added", 'Tags Has Been Added');
        } else {
            $errors = "Something went wrong";
            return back()->with("warning", $errors);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $tags = SeoTagsHi::find($id);

        return view('seo_tags_hi.show', compact('tags'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $tags = SeoTagsHi::find($id);
        return view('admin.seo_tags_hi.edit', compact('tags'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:seo_tags_hi,name',
        ],
            [
                'required' => 'Tag Name Is Required',
                'unique' => 'Please do any updates'
            ]
        );

        if ($validator->fails()) {
            $errors = $validator->errors()->first();
            return back()->with("warning", $errors);
        }


        $tags = SeoTagsHi::find($request->id);


        $slug = $this->make_slug($request->input('name'));

        $tags->name = $request->input('name');
        $tags->slug = $slug;
        $tags->save();

        return redirect()->route('seoTagsHi')->with("added", 'Tags Has Been Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::table("seo_tags_hi")->where('id', $id)->delete();
        return redirect()->route('seo-tags-hi.index')
            ->with('success', 'Tags deleted successfully');
    }

    public function autoLoadSeoTags(Request $request)
    {

        $tag = $this->hindi_clean($request->tag);
        $data = DB::select(DB::raw("select * from seo_tags_hi where name like '%$tag%'"));

        $data = collect($data);
        $data = $data->pluck('name');
        return response()->json($data);
    }

    function make_slug($string)
    {
        $string = trim($string);

        $string
            = preg_replace("/[^a-z0-9_ोौेैा्ीिीूुंःअआइईउऊएऐओऔकखगघचछजझञटठडढतथदधनपफबभमयरलवसशषहश्रक्षटठडढङणनऋड़\s-]/u",
            "", $string);

        $string = preg_replace("/[\s-]+/", " ", $string);
        $string = preg_replace("/[\s]/", '-', $string);

        return $string;
    }

    function hindi_clean($string)
    {
        $string = trim($string);
        $string = strtolower($string);
        $string
            = preg_replace("/[^a-z0-9_ोौेैा्ीिीूुंःअआइईउऊएऐओऔकखगघचछजझञटठडढतथदधनपफबभमयरलवसशषहश्रक्षटठडढङणनऋड़\s-]/u",
            "", $string);
        $string = preg_replace("/[\s-]+/", " ", $string);
        $string = preg_replace("/[\s]/", ' ', $string);

        return $string;
    }


}

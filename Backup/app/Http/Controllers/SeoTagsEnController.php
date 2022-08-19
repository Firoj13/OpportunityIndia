<?php

namespace App\Http\Controllers;

use App\Models\SeoTagsEn;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SeoTagsEnController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:seo_tag_en-list|seo_tag_en-create|seo_tag_en-edit|seo_tag_en-delete', ['only' => ['index','show']]);
        $this->middleware('permission:seo_tag_en-create', ['only' => ['create','store']]);
        $this->middleware('permission:seo_tag_en-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:seo_tag_en-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $tags = SeoTagsEn::orderBy('id','DESC')->paginate(5);
        return view('seo_tags_en.index',compact('tags'))
            ->with('i', ($request->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('seo_tags_en.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:seo_tags_ens,name',
        ]);
        $slug = str_slug($request->input('name'));

        $tags = SeoTagsEn::create(['name' => $request->input('name'),'slug' => $slug]);

        return redirect()->route('seo-tags-en.index')
            ->with('success','Tags created successfully');
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
        return view('seo_tags_en.edit',compact('tags'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
        ]);

        $tags = SeoTagsEn::find($id);
        $tags->name = $request->input('name');
        $tags->slug = str_slug($request->input('name'));
        $tags->save();

        return redirect()->route('seo-tags-en.index')
            ->with('success','Tags updated successfully');
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
}

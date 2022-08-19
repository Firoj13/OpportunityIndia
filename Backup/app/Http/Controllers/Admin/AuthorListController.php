<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\AuthorList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;

class AuthorListController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');

    }
    public function index(Request $request)
    {



        if(!Auth::user()->hasPermissionTo('manage-authors')){
            return Redirect::to('/admin/home')->with('warning',"Opps! You don't have sufficient permissions");
        }
        $tags = AuthorList::orderBy('id','DESC');


        if($request->has('search')){
            $tags->whereRaw("id = '".$request->search."' OR name LIKE '%".$request->search."%' OR slug LIKE '%".$request->search."%' OR company LIKE '%".$request->search."%' OR designation LIKE '%".$request->search."%'");
        }
        $authors=$tags->paginate(10);

        return view('admin.author.index',compact('authors'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.author.add');
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
            'name' => 'required',
        ]);

        if($validator->fails()){
            $errors=$validator->errors()->first();
            return back()->with("warning", $errors);
        }
        if(!empty($request->author_image)){
            $uploadPath = 'opp/authors/images/';
            if(Storage::exists($request->author_image)) {
                $content = Storage::get($request->author_image);
                $content = Image::make($content);
                $content = $content->resize(400,'', function ($constraint) {
                    $constraint->aspectRatio();
                })->encode();

                Storage::disk('s3')->put($uploadPath.basename($request->author_image), $content, 'public');
                Storage::delete($request->author_image);
            }
        }

        $authors = AuthorList::create(['name'=> $request->input('name'),'company' => $request->input('company'),'designation' => $request->input('designation'),'address' => $request->input('address'),'image_path' => basename($request->input('author_image')),'phone_number' => $request->input('phone_number'),'linkedin_profile' => $request->input('linkedin_profile'),'fb_profile' => $request->input('facebook_profile'),'twitter_profile' => $request->input('twitter_profile'),'intro_desc' => $request->input('description'),'email' => $request->input('email'),'slug' => str_slug($request->input('name')),'status'=>$request->input('status')]);
        if($authors) {
            return redirect()->route('author.index')->with("added", 'Author Has Been Added');
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
        $tags = AuthorList::find($id);

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
        $author = AuthorList::find($id);

        return view('admin.author.edit',compact('author'));
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
            'name' => 'required',
        ]);

        if($validator->fails()){
            $errors=$validator->errors()->first();
            return back()->with("warning", $errors);
        }



        if(!empty($request->author_image)){
            $uploadPath = 'opp/authors/images/';
            if(Storage::exists($request->author_image)) {
                $content = Storage::get($request->author_image);
                $content = Image::make($content);
                $content = $content->resize(400,'', function ($constraint) {
                    $constraint->aspectRatio();
                })->encode();

            Storage::disk('s3')->put($uploadPath.basename($request->author_image), $content, 'public');

                Storage::delete($request->author_image);
            }
        }
        $authors = AuthorList::find($request->id);
//        dd($authors);
        $authors->name = $request->input('name');
        $authors->company = $request->input('company');
        $authors->designation = $request->input('designation');
        $authors->address = $request->input('address');
        $authors->image_path = basename($request->input('author_image'));
        $authors->phone_number = $request->input('phone_number');
        $authors->linkedin_profile = $request->input('linkedin_profile');
        $authors->fb_profile = $request->input('facebook_profile');
        $authors->twitter_profile = $request->input('twitter_profile');
        $authors->intro_desc = $request->input('description');
        $authors->email = $request->input('email');
        $authors->slug = str_slug($request->input('name'));
        $authors->status = $request->input('status');



        if( $authors->save()) {
            return redirect()->route('author.index')->with("updated", 'Author Has Been Updated');
        }else{
            $errors = "Something went wrong";
            return back()->with("warning", $errors);
        }

    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = AuthorList::find($id);
        $user->delete();
        return redirect()->route('author.index')->with('added',"Author deleted successfully");
    }
    public function status(Request $request){
        if($request->id>0){
            AuthorList::where('id',$request->id)->update(['status'=>$request->status]);
        }
        echo "1";
    }
    function fileUpload(Request $request){
        $validator = Validator::make($request->all(), [
            'file' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:8048',
        ]);
        //print_r($request->post());
        $baseFolder="temp";

        if(empty($baseFolder)){
            die("Base folder is empty...");
        }
        if($validator->fails()){
            //return $this->validation_response($validator);
        }
        $files=$request->file('images');
        $images=[];
        if(count($files)){
            foreach($files as $indx=>$file){
                # Enter logo path
                $ext =  $file->extension();
                if(!empty($file->fileName)){
                    $path = $baseFolder . '/' . $file->fileName . '.' . $ext;
                }else{
                    $path = $baseFolder . '/' . rand() . '.' . $ext;
                }
                //echo $path."\n";
                $content =file_get_contents($file);
                Storage::put($path, $content, 'public');
                $images[]=$path;
            }
        }
        return response()->json(['images'=>$images]);
    }
    public function deleteImage(Request $request){
        AuthorList::where('id',$request->authorId)->update(['image_path'=>'']);
        echo "{done}";
    }

}

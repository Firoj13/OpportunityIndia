<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AudioFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class AudioFileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');

    }
    public function index(Request $request)
    {

        if(!Auth::user()->hasPermissionTo('manage-audio-files')){
            return Redirect::to('/admin/home')->with('warning',"Opps! You don't have sufficient permissions");
        }
        $audios = AudioFile::orderBy('id','DESC');


        if($request->has('search')){
            $audios->whereRaw("id = '".$request->search."' OR name LIKE '%".$request->search."%' OR slug LIKE '%".$request->search."%'");
        }
        $audios=$audios->paginate(15);

        return view('admin.audios.index',compact('audios'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.audios.add');
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
            'name' => 'required|unique:audio_files,name',
            'status' => 'required',
            'audio_file' => 'required',
        ]);

        if($validator->fails()){
            $errors=$validator->errors()->first();
            return back()->with("warning", $errors);
        }
        if(!empty($request->audio_file)){
            $uploadPath = 'opp/audio/audios/';
            if(Storage::exists($request->audio_file)) {
                $content = Storage::get($request->audio_file);

                Storage::disk('s3')->put($uploadPath.basename($request->audio_file), $content, 'public');
                Storage::delete($request->audio_file);
            }
        }

        $authors = AudioFile::create(['name'=> $request->input('name'),'slug' => str_slug($request->input('name')),'audio_path' => basename($request->input('audio_file')),'status'=>$request->input('status')]);
        if($authors) {
            return redirect()->route('audio.index')->with("added", 'Audio Has Been Added');
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
    public function edit($id)
    {
        $audio = AudioFile::find($id);

        return view('admin.audios.edit',compact('audio'));
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
            'status' => 'required',
        ]);

        if($validator->fails()){
            $errors=$validator->errors()->first();
            return back()->with("warning", $errors);
        }



        if(!empty($request->audio_file)){
            $uploadPath = 'opp/audio/audios/';
            if(Storage::exists($request->audio_file)) {
                $content = Storage::get($request->audio_file);
                Storage::disk('s3')->put($uploadPath.basename($request->audio_file), $content, 'public');
                Storage::delete($request->audio_file);
            }
        }
        $audio = AudioFile::find($request->id);

        $audio->name = $request->input('name');
        $audio->slug = str_slug($request->input('name'));
        if(!empty($request->audio_file)) {
            $audio->audio_path = basename($request->input('audio_file'));
        }
        $audio->status  = $request->input('status');

        if($audio->save()) {
            return redirect()->route('audio.index')->with("updated", 'Audio Has Been Updated');
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
            AudioFile::where('id',$request->id)->update(['status'=>$request->status]);
        }
        echo "1";
    }
    function audioUpload(Request $request){
        $validator = Validator::make($request->all(), [
            'file' => 'nullable|mimes:audio/mpeg,mpga,mp3,wav,aac',
        ]);

        if($validator->fails()){
            $errors=$validator->errors()->first();
//        return back()->with("warning", $errors);
//        return response()->json(['warning'=>$errors]);
        }
        $baseFolder="temp";

        if(empty($baseFolder)){
            die("Base folder is empty...");
        }

        $files=$request->file('audios');
        $audios=[];
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
                $audios[]=$path;
            }
        }
        return response()->json(['audios'=>$audios]);
    }
    public function deleteImage(Request $request){
        AudioFile::where('id',$request->audioId)->update(['audio_path'=>'']);
        echo "{done}";
    }
}

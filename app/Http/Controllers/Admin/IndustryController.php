<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\CategoryLanguage;
use Auth;
use Image;
use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Venturecraft\Revisionable\Revision;
use Redirect;

class IndustryController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
    */
    public function index(Request $request)
    {   
        if(!Auth::user()->hasPermissionTo('manage-industry')){
            return Redirect::to('/admin/home')->with('warning',"Opps! You don't have sufficient permissions");
        }  

        $categories = Category::select(DB::raw("category_id as id, category_name as name,DATE_FORMAT(updated_at,'%Y/%m/%d') updatedAt, category_slug as slug, status"))
        ->leftJoin('category_relation as CR', function($join){
            $join->on('CR.child_id', '=', 'category_id');
        });
        $categories->whereRaw('CR.parent_id IS NULL');
        $categories->orderByRaw("created_at DESC");     
        
        if($request->has('search')){
            $categories->whereRaw("category_id = '".$request->search."' OR category_name LIKE '%".$request->search."%' OR category_slug LIKE '%".$request->search."%'");           
        } 
        $industries=$categories->paginate(20);
        return view('admin.categories.index',compact('industries'));
    }

    public function create()
    {        
        $sectors=$this->getSectors()->orderByRaw("category_name ASC")->get();
        $industries=$this->getIndustries()->orderByRaw("category_name ASC")->get();
        return view('admin.categories.create',compact('sectors','industries'));
    }
    
    public function edit($id)
    {   
        $sectors=$this->getSectors()->orderByRaw("category_name ASC")->get();
        $industries=$this->getIndustries()->orderByRaw("category_name ASC")->get();
        $data = Category::where('category_id',$id)->first();
        $languages=$data->languages()->get();        
        foreach($languages as $lang){
            $data->languages[$lang->language]=$lang;
        }
        
        $childs=Category::where('category_id',$id)->first()->childs()->select("category_id")->get();        

        return view('admin.categories.edit',compact('sectors','industries','childs','data'));
    }
    
    private function getSectors(){
        $categories = Category::select(DB::raw("category_id as id, category_name as name,DATE_FORMAT(updated_at,'%Y/%m/%d') updatedAt, category_slug as slug, status"))
        ->leftJoin('category_relation as CR', function($join){
            $join->on('CR.child_id', '=', 'category_id');
            $join->on('CR.relation_type','=',DB::raw("'1'"));
        });
        $categories->whereRaw('CR.parent_id IS NOT NULL');
        return $categories->orderByRaw("category_name ASC");     
    }
    
    private function getIndustries(){
        $categories = Category::select(DB::raw("category_id as id, category_name as name,DATE_FORMAT(updated_at,'%Y/%m/%d') updatedAt, category_slug as slug, status"))
        ->leftJoin('category_relation as CR', function($join){
            $join->on('CR.child_id', '=', 'category_id');
            $join->on('CR.relation_type','=',DB::raw("'1'"));
        });
        $categories->whereRaw('CR.parent_id IS NULL');
        return $categories->orderByRaw("category_name ASC");  
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //notify()->error('An error has occurred please try again later.'); 
        $id=$request->id;
        $validator = Validator::make($request->all(), [
            'name.en' => 'required|string|max:255',
            //'file' => 'mimes:jpg,png,jpeg,gif,svg|max:2048|dimensions:min_width=150,min_height=100,max_width=800,max_height=600',
        ]);
        $post=$request->all();
        
        if($validator->fails()){
            $errors=$validator->errors()->first();
            return back()->with("warning", $errors);
        }
        
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $path = 'categories/'; // enter logo path

            $image_resize = Image::make($file->getRealPath());
            $image_resize = $image_resize->encode('jpg');
            $name = time() . $file->getClientOriginalName();
            $filePath = $path . $name;
            Storage::disk('s3')->put($filePath, $image_resize,'public');
            $url= Storage::disk('s3')->url($filePath);
            $request->category_icon=basename($filePath);
            if($id>0){
                $category = Category::find($id)->first();
                $existingFile=$category->category_icon;
                if(!empty($existingFile)){
                    $filePath=$path.basename($existingFile);
                    //Storage::disk('s3')->delete($filePath);
                }
            }

            
        }

        $category = Category::firstOrNew(array('category_id' => $id));

        //For Now Enter English
        $category->category_name=$post['name']['en'];
        $category->meta_title=$post['title']['en'];
        $category->meta_description=$post['description']['en'];
        $category->meta_keywords=$post['keywords']['en'];
        $category->status=$request->status;
        if($request->category_icon){
            $category->category_icon=$request->category_icon;
        }
        
        if($request->id>0){
            $msg="Industry Has Been Updated";
        }else{
            $category->category_slug = Str::slug($post['name']['en'], '-');
            $msg="Industry Has Been Added";
        }
        $category->save();

        $langs = config('constants.languages');        
        foreach($langs as $key=>$lang){
            if(!empty($post['name'][$key])){
                $categoryLanguage=CategoryLanguage::firstOrNew(array('category_id' => $id,'language'=>$key));                    
                $categoryLanguage->category_id=$category->category_id;
                $categoryLanguage->language=$key;
                $categoryLanguage->category_name=$post['name'][$key];
                $categoryLanguage->meta_title=$post['title'][$key];
                $categoryLanguage->meta_description=$post['description'][$key];
                $categoryLanguage->meta_keywords=$post['keywords'][$key];
                $categoryLanguage->save();
            }
        }
       

        //Save Sectors
        if($request->has('sectors')){
            $data=[];  
            foreach($request->sectors as $sector){
                 $hasRelation=DB::table('category_relation')->select('child_id')->where('relation_type',1)->where('child_id',$sector)->count();
                
                if($hasRelation>0){
                    $data[$sector]=['relation_type' => 2];    
                }else{
                    $data[$sector]=['relation_type' => 1];
                }

                $category->childs()->sync($data);
            }
        }
        return back()->with("added", $msg);
    }
    
    public function status(Request $request){
        if($request->id>0){
            $category=Category::find($request->id);
            $category->status=$request->status;
            $category->save();
        }
        echo "1";
    }

    public function duplicate(Request $request){
            
        return back()->with("added", "Marked as duplicate");
    }

    public function history(Request $request){

        if(!Auth::user()->hasPermissionTo('industry-history')){
            return Redirect::to('/admin/home')->with('warning',"Opps! You don't have sufficient permissions");
        }  
        
        $revisions = Revision::with('revisionable')->where('revisionable_type','App\Models\Category')->orderByRaw("updated_at DESC"); 

        if(!empty($request->date)){       
            $date=date('Y-m-d',strtotime($request->date));
            $revisions->whereRaw("DATE(revisions.created_at) = '".$date."'");
        } 
        if(!empty($request->id)){       
            $revisions->whereRaw("revisions.revisionable_id = '".$request->id."'");
        } 
        $revisions =$revisions->paginate(20);

        return view('admin.categories.history',compact('revisions'));
        
    }
}
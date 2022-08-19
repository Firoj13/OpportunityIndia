<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Auth;
use App\Models\User;
use Avatar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Redirect;

class BuyerController extends Controller
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
        if(!Auth::user()->hasPermissionTo('manage-buyers')){
            return Redirect::to('/admin/home')->with('warning',"Opps! You don't have sufficient permissions");
        }  

        $users = User::orderBy('id','DESC')->paginate(20);
        if($request->has('search')){
            $users->whereRaw("user_id = '".$request->search."' OR name LIKE '%".$request->search."%' OR mobile LIKE =".$request->search);           
        } 
        return view("admin.buyers.index", compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {        
        return view("admin.buyers.add");
    }
    /**
     * Show the edit form for updating a resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {        
        $user = User::find($id);
        return view("admin.buyers.edit", compact("user"));
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
        
        $validationRules=[
            'name' => 'required|string|max:255',
            'mobile' => 'required|phone',
            'email' => 'required|string|email|max:255|unique:admins',
        ];

        //Validate password for fresh users
        if(empty($request->id)){
            $validationRules['password']='required|min:8';
            $validationRules['email'] = 'required|string|email|max:255|unique:admins';
        }else{
            $validationRules['email'] = 'required|string|email|max:255';
        }

        $request->validate($validationRules);



        $buyer = User::firstOrNew(array('user_id' => $id));
        $buyer->name=$request->name;
        $buyer->email=$request->email;
        $buyer->mobile=$request->mobile;
        $buyer->status=$request->status;
        
        if(!empty($request->password)){
            $buyer->password = Hash::make($request->password);
        }        
        $buyer->save();

        if($id>0){
            $msg="Buyer Has Been Updated";
        }else{
            $msg="Buyer Has Been Added";
        }
        return back()->with("added", $msg);
    }

    public function status(Request $request){
        if($request->id>0){
            User::where('id',$request->id)->update(['status'=>$request->status]);
        }
        echo "1";
    }

}
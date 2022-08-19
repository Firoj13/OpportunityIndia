<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Auth;
use App\Models\Admin;
use App\Models\Role;
use Avatar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Redirect;
class UserController extends Controller
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
    public function index()
    {
        if(!Auth::user()->hasPermissionTo('manage-users')){
            return Redirect::to('/admin/home')->with('warning',"Opps! You don't have sufficient permissions");
        } 

        $users = Admin::orderBy('id','DESC');
        if(!Auth::user()->isAdmin()){
            $users->whereHas('roles', function($q){
                $q->whereRaw("slug != 'admin'");
            });            
        }        


        $users=$users->paginate(20);
        return view("admin.users.index", compact('users'));
    }

    function filter_admin($user){
        $userRole=$user->roles()->first()->slug;
        if($userRole!=='superadmin'){
            return true;
        }
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {        
        $roles = Role::where('slug', '!=' , 'super-admin')->get();
        return view("admin.users.add", compact("roles"));
    }
    /**
     * Show the edit form for updating a resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    public function delete($id)
    {   
        $user = Admin::find($id);
        $user->delete();
        return Redirect::to('/admin/users')->with('added',"User deleted successfully");
    }    

    public function edit($id)
    {        
        if(!Auth::user()->hasPermissionTo('manage-users')){
            return Redirect::to('/admin/home')->with('warning',"Opps! You don't have sufficient permissions");
        }    

        $user = Admin::find($id);
        $roles = Role::where('slug', '!=' , 'super-admin');
        if(!Auth::user()->isAdmin()){
            $roles->where('slug', '!=' , 'admin');
        }
        $roles=$roles->get();
        $userRole=$user->roles()->first();
        return view("admin.users.edit", compact("roles","user","userRole"));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(!Auth::user()->hasPermissionTo('manage-users')){
            return Redirect::to('/admin/home')->with('warning',"Opps! You don't have sufficient permissions");
        }   
        
        //notify()->error('An error has occurred please try again later.'); 
        $id=$request->id;
        
        $validationRules=[
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:admins',
            'role' => 'required',
        ];

        //Validate password for fresh users
        if(empty($request->id)){
            $validationRules['password']='required|min:8';
            $validationRules['email'] = 'required|string|email|max:255|unique:admins';
        }else{
            $validationRules['email'] = 'required|string|email|max:255';
        }

        $request->validate($validationRules);

        $user = Admin::firstOrNew(array('id' => $id));
        $user->name=$request->name;
        $user->email=$request->email;
        $user->status=$request->status;
        if(!empty($request->password)){
            $user->password = Hash::make($request->password);
        }        
        $user->save();

        if($user){
            $msg="User Has Been Updated";
        }else{
            $msg="User Has Been Added";
        }
        
        $role = Role::where('slug',$request->role)->first();
        if($role && $user){
            $user->roles()->sync($role);
        }

        return back()->with("added", $msg);
    }

    public function status(Request $request){
        if($request->id>0){
            Admin::where('id',$request->id)->update(['status'=>$request->status]);
        }
        echo "1";
    }

}
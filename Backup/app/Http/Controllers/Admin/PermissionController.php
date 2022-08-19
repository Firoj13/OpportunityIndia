<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Auth;
use App\Models\Admin;
use App\Models\Role;
use App\Models\Permission;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class PermissionController extends Controller
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
	 * Show the application permisssions.
	 *
	 * @return \Illuminate\Http\Response
	*/
	public function index()
	{
        if(!Auth::user()->isAdmin()){
            return Redirect::to('/admin/home')->with('warning',"Opps! You don't have sufficient permissions");
        }
        		
		$roles = Role::whereRaw("slug!='super-admin' AND slug!='admin'")->get();
		$permissions = Permission::get();
	    return view("admin.permissions", compact('permissions','roles'));
	}

	/**
	 * Apply the application permisssions.
	 *
	 * @return \Illuminate\Http\Response
	*/
	public function update(Request $request)
	{
		$role = Role::where('id',$request->role)->first();
		$role->permissions()->sync($request->permissions);
		return true;
	}

	/**
	 * Add new application permisssions.
	 *
	 * @return \Illuminate\Http\Response
	*/
	public function createPermission(Request $request){

		$slug = Str::slug($request->permission);
		$createTasks = new Permission();
		$createTasks->slug = $slug ;
		$createTasks->name = $request->permission;
		$createTasks->save();

		//Always Add Permission To Admin 
		$admin_role = Role::where('slug','admin')->get();
		$createTasks->roles()->attach($admin_role);

	}

}

?>
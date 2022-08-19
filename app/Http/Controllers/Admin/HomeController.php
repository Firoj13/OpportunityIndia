<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
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
		$S3BucketPath=env('S3_BUCKET_URL','');
        $currentWeekLeads = DB::table('article_list_en')
         ->selectRAW("created_at,count(*) as total")
         ->groupBy(DB::raw("DATE_FORMAT('created_at','%Y-%m-%d')"))
         ->whereraw('created_at >= DATE(NOW()) - INTERVAL 30 DAY')
         ->get();
         foreach($currentWeekLeads as $data){

         }
        $lastWeekleads = DB::table('article_list_en')
         ->selectRAW('created_at, count(*) as total')
         ->groupBy(DB::raw("DATE_FORMAT('created_at','%Y-%m-%d')"))
         ->whereraw('created_at >= DATE(NOW()) - INTERVAL 30 DAY')
         ->get();

        $totalLeads = DB::table('article_list_en')
         ->select(DB::raw('count(*) as total'))
         ->first();

        $totalBuyers = DB::table('admins')
         ->select(DB::raw('count(*) as total'))
         ->first();

        if(Auth::user()->isAdmin()){
            return view('admin.dashboard_admin',compact('currentWeekLeads','lastWeekleads','totalBuyers','totalLeads'));
        }else{
            return view('admin.dashboard_sales');
        }
    }
}

<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Http\Request;
use App\Models\Lead;
use App\Models\LeadDetail;
use App\Models\User;
use Validator;
use Venturecraft\Revisionable\Revision;
use Redirect;

class LeadController extends Controller
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
        if(!Auth::user()->hasPermissionTo('manage-leads')){
            return Redirect::to('/admin/home')->with('warning',"Opps! You don't have sufficient permissions to view leads");
        }

        $leads=Lead::orderByRaw("leads.created_at DESC");
        
        if($request->buyerid>0){
            $userId=$request->buyerid;
            $q=$leads;
            $leads->whereHas('buyer', function($q) use($userId) {
                $q->whereRaw("user_id = '".$userId."'");
            });
        }
        
        if(!empty($request->leadDate)){
            $start=date('Y-m-d',strtotime($request->leadDate));
            $leads->whereRaw("DATE(leads.created_at) = '".$start."'");
        }

        /*if(!empty($request->leadDate)){
            $array=explode("-",$request->leadDate);
            $start=date('Y-m-d',strtotime($array[0]));
            $end=date('Y-m-d',strtotime($array[1]));
            $leads->whereRaw("leads.created_at BETWEEN '".$start."' AND '".$end."'");
        }*/

        if(!empty($request->supplierid)){
            $supplierid=$request->supplierid;
            $q=$leads;
            $leads->whereHas('supplier', function($q) use($supplierid) {
                $q->whereRaw("supplier_id = '".$supplierid."'");
            });

            //$leads->supplier->whereRaw("supplier_id = '".$request->supplierid."'");
        }

        if($request->leadid>0){
            $leads->whereRaw("lead_id = '".$request->leadid."'");
        }

        if(!empty($request->leadtype)){
            $leads->whereRaw("lead_type = '".$request->leadtype."'");
        }

        $leads=$leads->paginate(20);
        //print_r($leads->first()->supplier->supplier_id);
        return view('admin.leads.index',compact('leads'));
    }

    /**
     * Show the approve.
     *
     * @return \Illuminate\Http\Response
    */
    public function approved(Request $request)
    {
        
        if(!Auth::user()->hasPermissionTo('approve-leads')){
            return Redirect::to('/admin/home')->with('warning',"Opps! You don't have sufficient permissions to approve leads");
        }

        $leads=Lead::where('status',1)->orderByRaw("leads.created_at DESC")
        ->join("users as u","u.id","=","leads.user_id");

        if($request->buyerid>0){
            $leads->whereRaw("user_id = '".$request->buyerid."'");
        }

        if($request->has('sellerid')){
            $leads->seller()->whereRaw("brand_id = '".$request->sellerid."'");
        }

        if($request->leadid>0){
            $leads->whereRaw("lead_id = '".$request->leadid."'");
        }

        if(!empty($request->leadtype)){
            $leads->whereRaw("lead_type = '".$request->leadtype."'");
        }

        $leads=$leads->paginate(20);
        return view('admin.leads.approved',compact('leads'));
    }


    /**
     * Show the enrich.
     *
     * @return \Illuminate\Http\Response
    */    
    public function enrich(Request $request)
    {
        if(!Auth::user()->hasPermissionTo('enrich-leads')){
            return Redirect::to('/admin/home')->with('warning',"Opps! You don't have sufficient permissions to enrich leads");
        }

        $leads=Lead::where('status',3)->orderByRaw("leads.created_at DESC")
        ->join("users as u","u.id","=","leads.user_id");

        if($request->buyerid>0){
            $leads->whereRaw("user_id = '".$request->buyerid."'");
        }

        if($request->has('sellerid')){
            $leads->seller()->whereRaw("brand_id = '".$request->sellerid."'");
        }

        if($request->leadid>0){
            $leads->whereRaw("lead_id = '".$request->leadid."'");
        }

        if(!empty($request->leadtype)){
            $leads->whereRaw("lead_type = '".$request->leadtype."'");
        }

        $leads=$leads->paginate(20);
        return view('admin.leads.enrich',compact('leads'));
    }
    

    /**
     * Show the history.
     *
     * @return \Illuminate\Http\Response
    */
    public function history(Request $request)
    {
        if(!Auth::user()->hasPermissionTo('history-leads')){
            return Redirect::to('/admin/home')->with('warning',"Opps! You don't have sufficient permissions to view history");
        }

        $revisions = Revision::select('revisionable_id','revisionable_type','revisions.user_id','key','old_value','new_value','revisions.updated_at','ld.id as detailId')
        >whereRaw("(substring_index(revisionable_type,'\\\\', -1) = 'LeadDetail' or substring_index(revisionable_type,'\\\\', -1) = 'Lead' )")
        ->leftjoin("leads_details as ld","ld.id","=","revisions.revisionable_id")
        ->join('leads', function ($join) {
            $join->on('leads.lead_id', '=', 'ld.lead_id')
            ->orOn('leads.lead_id', '=', 'revisionable_id');
        });

        if($request->leadid>0){
            
            $revisions->whereRaw("(ld.lead_id = '".$request->leadid."' or leads.lead_id = '".$request->leadid."')");
        }

        if($request->buyerid>0){
            
            $revisions->whereRaw("leads.user_id = '".$request->buyerid."'");
        }    

        if(!empty($request->user)){
            
            $revisions->whereRaw("revisions.user_id = '".$request->user."'");
        }     
        
        $revisions=$revisions->orderByRaw("revisions.updated_at DESC")->paginate(20);
        #print_r($revisions->toArray());
        //die;
        return view('admin.leads.history',compact('revisions'));
    }


    /**
     * Show the lead history.
     *
     * @return \Illuminate\Http\Response
    */    
    public function lead_history(Request $request,$lead_id)
    {
        if(!Auth::user()->hasPermissionTo('history-leads')){
            return Redirect::to('/admin/home')->with('warning',"Opps! You don't have sufficient permissions to view history");
        }

        $revisions = Revision::select('revisionable_id','revisionable_type','revisions.user_id','key','old_value','new_value','revisions.updated_at','ld.id as detailId')
        ->whereRaw("(substring_index(revisionable_type,'\\\\', -1) = 'LeadDetail' or substring_index(revisionable_type,'\\\\', -1) = 'Lead' )")
        ->leftjoin("leads_details as ld","ld.id","=","revisions.revisionable_id")
        ->whereRaw("ld.lead_id = '".$lead_id."'");
        if($request->leadid>0){
            
            $revisions->whereRaw("ld.lead_id = '".$request->leadid."'");
        }

        if($request->buyerid>0){
            
            $revisions->whereRaw("l.user_id = '".$request->buyerid."'");
        }    

        if(!empty($request->user)){
            
            $revisions->whereRaw("revisions.user_id = '".$request->user."'");
        }  

        $revisions=$revisions->orderByRaw("revisions.updated_at DESC")->paginate(20);

        return view('admin.leads.history',compact('revisions','lead_id'));
    }

    /**
     * Show the edit form.
     *
     * @return \Illuminate\Http\Response
    */
    public function edit($id)
    {
        $lead=Lead::find($id);
        $fields=['investment'=>'','location'=>'','industry'=>'','sector'=>'','risk'=>'','roi'=>'','details'=>''];
        $values=$lead->detail->toArray();
        
        foreach($values as $value){
            $fields[$value['attribute_name']]=$value['attribute_value'];
        }
        return view('admin.leads.edit',compact('lead','fields'));
    }
    
    public function view($id)
    {
        $lead=Lead::find($id);
        $fields=['investment'=>'','location'=>'','industry'=>'','sector'=>'','risk'=>'','roi'=>'','details'=>''];
        $values=$lead->detail->toArray();
        
        foreach($values as $value){
            $fields[$value['attribute_name']]=$value['attribute_value'];
        }
        return view('admin.leads.view',compact('lead','fields'));
    } 

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $leadId=$request->id;
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255',
            'name' => 'required|string|max:255',
        ]);
        $lead = Lead::find($leadId);
        
        $buyer = User::find($lead->user_id);
        $lead->buyer->name=$request->name;
        $lead->buyer->email=$request->email;
        $lead->buyer->save();
        ///
        $isEnriched=false;
        foreach($request->fields as $fieldName=>$value){
			$detail = LeadDetail::firstOrNew(array('lead_id' => $leadId,'attribute_name'=>$fieldName));
			$detail->attribute_value=$value;
			$detail->lead_id=$leadId;
			$detail->save();
			$isEnriched=true;
        }
        if($isEnriched){
            $lead=Lead::find($leadId);
            $lead->status=2;
            $lead->save();
        }
        //return Redirect::to($request->request->get('http_referrer'));
        return back()->with("added", "Lead updated successfully");
    }

    public function status(Request $request){
        if($request->id>0 && $request->status>0){
            $category=Lead::find($request->id);
            $category->status=$request->status;
            $category->save();
        }
        echo "1";
    }

}
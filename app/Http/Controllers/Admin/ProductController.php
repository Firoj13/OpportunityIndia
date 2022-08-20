<?php
namespace App\Http\Controllers\Admin;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Http\Request;
use App\Models\Brand; 
use App\Models\Product;    
use App\Models\ProductLanguage;
use App\Models\ProductAttributes;
use App\Models\ProductMedia;
use Validator;
use Redirect;
use Venturecraft\Revisionable\Revision;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Image;
use Carbon\Carbon;

class ProductController extends Controller
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
    
    public function index(Request $request,$brandId=0)
    {
        if(!Auth::user()->hasPermissionTo('manage-products')){
            return Redirect::to('/admin/home')->with('warning',"Opps! You don't have sufficient permissions to view products");
        }

        $products=Product::orderByRaw("created_at DESC");
        
        if(!empty($brandId)){
            $products->where('brand_id',$brandId);
        }

        if(!empty($request->productSearch)){
            $products->whereRaw("product_id = '".$request->productSearch."' OR product_name LIKE '%".$request->productSearch."%'");           
        }   
        if(!empty($request->brandSearch)){
            $brandSearch=$request->brandSearch;
            $q=$products;
            $products->whereHas('brand', function($q) use($brandSearch) {
                $q->whereRaw("brand_id = '".$brandSearch."' OR company_name LIKE '%".$brandSearch."%'");
            });
            //$products->brand()->whereRaw("brand_id1 = '".$request->brandSearch."' OR company_name LIKE '%".$request->brandSearch."%'");           
        }  
        if(!empty($request->productId)){
            $products->whereRaw("product_id = '".$request->productId."'");           
        }  

        if(!empty($request->productName)){
            $products->whereRaw("product_name LIKE '%".$request->productName."%'");           
        }  

        $products=$products->paginate(20);
        
        //print_r($brands);
        if($brandId>0){
        	$brand = Brand::select('brand_id','company_name')->firstWhere('brand_id', $brandId);
            return view('admin.product.index',compact('products','brand'));
        }else{
            return view('admin.product.index_all',compact('products'));
        }
    }


    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    
    public function add(Request $request,$brandId=0)
    {
        
        if(!Auth::user()->hasPermissionTo('manage-products')){
            return Redirect::to('/admin/home')->with('warning',"Opps! You don't have sufficient permissions to add products");
        }

        $brand = Brand::select('brand_id','company_name')->firstWhere('brand_id', $brandId); 
        if(!$brand){
            return Redirect::to('/admin/products')->with('warning',"Opps! Please select manufacturer to add product");
        }

        return view('admin.product.add',compact('brand'));
    }    

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    
    public function edit(Request $request,$productId)
    {
        
        if(!Auth::user()->hasPermissionTo('manage-products')){
            return Redirect::to('/admin/home')->with('warning',"Opps! You don't have sufficient permissions to edit products");
        }
        $product=Product::find($productId);

        $languages=$product->languages()->get();        
        foreach($languages as $lang){
            $product->languages[$lang->language]=$lang;
        }

        return view('admin.product.edit',compact('product'));
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //sleep('5');
        $validator = Validator::make($request->all(), [
            'productName.en'=>'required',
            'brandId'=>'required',
            'description.en'=>'required',
        ]);
        
        $post=$request->all();

        if($validator->fails()){
            $errors=$validator->errors()->first();
            return redirect()->back()->withErrors($validator)->withInput();
            //return back()->with("warning", $errors)->withInput();
        }
        $product = Product::firstOrNew(['product_id'=>$request->productId]);
        if(empty($request->productId)){
        	$product->brand_id=$request->brandId;
        	$product->product_id;
        	$msg="Product added ";
        }else{
        	$msg="Product updated ";
        }
		$product->product_name=$request->productName['en']; 
		$product->product_description=$request->description['en']; 
		$product->save();

        if(!empty($request->companyVideo)){
            $media = ProductMedia::updateOrCreate(
                ['product_id' => $product->product_id, 'product_media_type' => '1'],
                ['media_url' =>$request->companyVideo]
            );
        }
        //Move Media to S3 from temparary folder
        if($request->banners){
            $uploadPath = 'brands/product/';
            foreach($request->banners as $banner){
                if(Storage::exists($banner)) {
                    $content = Storage::get($banner);         
                    Storage::disk('s3')->put($uploadPath.basename($banner), $content, 'public');
                    Storage::delete($banner);
                    ProductMedia::updateOrCreate(
                    ['product_id' => $product->product_id, 'product_media_type' => '2'],
                    ['media_url' =>basename($banner)]
                    );
                }
            }
        }

        $langs = config('constants.languages');        
        foreach($langs as $key=>$lang){
            if(!empty($request->productName[$key])){
                $productLanguage=ProductLanguage::firstOrNew(array('product_id' => $product->product_id,'language'=>$key));              
                $productLanguage->product_id=$product->product_id;
                $productLanguage->language=$key;
                $productLanguage->product_name=$request->productName[$key];
                $productLanguage->description=$request->description[$key];
                $productLanguage->save();
            }
        }

		if(count($request->attribute)>0){
			$this->addAttribute($product->product_id,$request->attribute);
		}
        print_r($request->attribute);
		return back()->with("added", $msg);

	}

	/*
	* Add/Update attribute
	*/	
	private function addAttribute($productId,$attributes){
		#Add product Attbutes
		foreach($attributes as $attribute){
			$data=[
			'product_id'=>$productId,
			'attribute_column'=>$attribute['key'],
			'attribute_value'=>$attribute['value']
			];
			if(!empty($attribute['id'])){
				ProductAttributes::where('product_attr_id',$attribute['id'])->update($data);	
			}else{
				ProductAttributes::create($data);
			}
		}
	}

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    
    public function history(Request $request){

        $revisions = Revision::with('revisionable')
        ->where('revisionable_type','App\Models\Product')
        ->orderByRaw("updated_at DESC"); 

        if(!empty($request->date)){       
            $date=date('Y-m-d',strtotime($request->date));
            $revisions->whereRaw("DATE(revisions.created_at) = '".$date."'");
        } 
        
        if(!empty($request->id)){       
            $revisions->whereRaw("revisions.revisionable_id = '".$request->id."'");
        } 

        $revisions =$revisions->paginate(20);
        return view('admin.product.history',compact('revisions'));        
    }    

}
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Brand;
use Illuminate\Support\Facades\DB;
use App\Models\ProductAttributes;
use Validator;
use Carbon\Carbon;
use App\Models\ProductMedia;
use Illuminate\Support\Facades\Storage;
use Image;


class ProductController extends Controller
{

    private function validation_response($validator){
		$errors=$validator->errors()->messages();
		array_walk_recursive($errors, function ($value, $key) use (&$error){
			$error = $value;
		}, $error);

        return response($this->status(422,true,$error),422);
    }
    
    private function status($code=200,$error=false,$message=""){
        return array(
          'code'=>$code,
          'error'=>$error,
          'message'=>$message
        );
    }
	
	/*
	* Get brand product | logged in user
	*/
	function getBrandProducts(Request $request){
		$user=$request->user();
		$brandId = Brand::select('brand_id')->where('user_id', $user->id)->first()->brand_id;
		
		#Get products data
        $items = DB::table('brand_products')
            ->select('product_id as productId','product_name as productName','product_description as productDescription')
            ->where('brand_id',$brandId)
            ->get();
		$products=[];
        if(count($items)>0){
            foreach($items as $item){
				#Get locations data
				$attributes=ProductAttributes::select('product_attr_id as id','attribute_column as attributeKey','attribute_value as attributeValue')
				->where('product_id',$item->productId)
				->get();
				
				#Get product images
				$productImages=ProductMedia::select('product_media_id as id','media_url as url')
				->where('product_id',$item->productId)
				->where('product_media_type',2)
				->get();
				
				#Get product Video
				$video=ProductMedia::select('product_media_id as id','media_url as url')
				->where('product_id',$item->productId)
				->where('product_media_type',1)
				->get()
				->first();
				
				$productVideo="";
				if($video){
					$productVideo=$video->url;
				}
				$products[] = array(
					'productId' => $item->productId,
					'productName' => $item->productName,
					'productDescription' => $item->productDescription,
					'productImages' => $productImages,
					'attributes' => $attributes,
					'productVideo'=>$productVideo
				);
            }
        }
		return  response()->json(array_merge($this->status(),['products'=>$products]));
	}
	
	
	/*
	* Add/update Product under brand 
	*/
	function update(Request $request){
		
		$user=$request->user();
		$validator = Validator::make($request->all(), [
            'products' => 'required',
        ]);

        if($validator->fails()){
            return $this->validation_response($validator);
        }
		
		$brandId = Brand::select('brand_id')->where('user_id', $user->id)->first()->brand_id;
		//print_r($request->products);
		//die;
		if(!empty($request->products)){
		   if(count($request->products)>0){
		     foreach($request->products as $item){
				if(!empty($item['productName'])){
					$data=[
						'brand_id'=>$brandId,
						'product_name'=>$item['productName'],
						'product_description'=>$item['productDescription'],
						'product_status' =>1
					];
					$now = Carbon::now();
					if(!empty($item['productId'])){
						$product =Product::select('product_id')->where('product_id',$item['productId'])->where('brand_id',$brandId)->get()->first();
						$productId=$product->product_id;
						Product::where('product_id',$product->product_id)->update($data);	
					}else{
						$data['created_at']=$now;
						$product =Product::create($data);
						$productId =$product->product_id;
					}
		           
					if(!empty($item['productVideo'])){
						ProductMedia::updateOrCreate(
							['product_id' =>  $product->product_id,'product_media_type'=>1],
							['media_url' => $item['productVideo'],'product_id' =>  $product->product_id,'product_media_type'=>1]
						);
					}
					
					if(count($item['attributes'])>0){
						$this->addAttribute($productId,$item['attributes']);
					}		

					if(count($item['productImages'])>0){
						$this->addImage($productId,$item['productImages']);
					}					
				}
		     }
		   }
	   }
	   return  response()->json(array_merge($this->status(200,false,"Products updated"),['products'=>$request->products]));
	}
	
	/*
	* Delete product
	*/
	function delete(Request $request){
		$user=$request->user();
        $validator = Validator::make($request->all(), [
            'productId' => 'required',
        ]);

        if($validator->fails()){
            return $this->validation_response($validator);
        }
		Product::where('product_id', $request->productId)->delete();
		return  response()->json($this->status(200,false,"Product deleted"));
	}
	
	/*
	* Upload product image
	*/
    function uploadImage(Request $request){

        $user=$request->user();
        $validator = Validator::make($request->all(), [
            'file' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
        ]);

        if($validator->fails()){
            return $this->validation_response($validator);
        }

        $brandId = Brand::select('brand_id')->where('user_id', $user->id)->first()->brand_id;
        $uploadPath = 'brands/product/'; // enter logo path
        $filePath=$uploadPath.time().".jpg";
		//Slider Banner uploading
        if ($request->hasFile('file')) {
			$file = $request->file('file');
			$image_resize = Image::make($file->getRealPath());
			$image_resize = $image_resize->encode('jpg');            
			Storage::disk('s3')->put($filePath, $image_resize,'public');
			$url= Storage::disk('s3')->url($filePath);
			return  response()->json(array_merge($this->status(),['url'=>$url]));
        }
    }	
	
	/*
	* Add/Update Media to database
	*/
	private function addImage($productId,$images){
		$uploadPath = 'brands/product/'; // Enter logo path
		foreach ($images as $image){
            $data=[
				'product_id' => $productId,
                'product_media_type' => 2,
                'media_url' => $image['url']
			];	
			
			if(!empty($image['id'])){
				//Delete existing file from cloud
				//$existingFile=ProductMedia::where('product_media_id',$image['id'])->get()->first()->media_url;
				//if(!empty($existingFile)){
				//	$path=$uploadPath.basename($existingFile);
				//	Storage::disk('s3')->delete($path);
				//}				
				$response =ProductMedia::where('product_media_id',$image['id'])->update($data);	
			}else{
				$response = ProductMedia::create($data);
			}
		}
	}
	
	/*
	* Delete the Image
	*/
	function deleteImage(Request $request){
		$user=$request->user();
		$brandId = Brand::select('brand_id')->where('user_id', $user->id)->first()->brand_id;
		$productBrand=ProductMedia::select('BP.brand_id,media_url')
		->Join('brand_products AS BP', 'brand_products_media.product_id', '=', 'BP.product_id')
		->where('product_media_id',$request->id)
		->get()
		->first();
		if($productBrand->brand_id!=$brandId){
			response()->json($this->status(401,false,"Not authorize to delete."));
		}
		$existingFile=$productBrand->media_url;
		if(!empty($existingFile)){
			$path=$uploadPath.basename($existingFile);
			Storage::disk('s3')->delete($path);
		}
		ProductMedia::where('product_media_id',$request->id)->where('brand_id',$brandId)->delete();
		return  response()->json($this->status(200,false,"Product image deleted."));
	}
	
	/*
	* Add/Update attribute
	*/	
	private function addAttribute($productId,$attributes){
		#Add product Attbutes
		foreach($attributes as $item){
			$data=[
			'product_id'=>$productId,
			'attribute_column'=>$item['attributeKey'],
			'attribute_value'=>$item['attributeValue']
			];
			if(!empty($item['id'])){
				ProductAttributes::where('product_attr_id',$item['id'])->update($data);	
			}else{
				ProductAttributes::create($data);
			}
		}
	}
	
	/*
	* Delete the attribute
	*/
	function deleteAttribute(Request $request){
		$user=$request->user();
		$brandId = Brand::select('brand_id')->where('user_id', $user->id)->first()->brand_id;
		$productBrandId=ProductAttributes::select('BP.brand_id')
		->Join('brand_products AS BP', 'brand_products_attributes.product_id', '=', 'BP.product_id')
		->where('product_attr_id',$request->attributeId)
		->get()
		->first();
		if($productBrandId->brand_id!=$brandId){
			response()->json($this->status(401,false,"Not authorize to delete."));
		}
		ProductAttributes::where('product_attr_id',$request->attributeId)->where('product_id',$request->productId)->delete();
		return  response()->json($this->status(200,false,"Product attribute deleted."));		
	}
}

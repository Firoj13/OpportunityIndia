<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use \Venturecraft\Revisionable\RevisionableTrait;

class Brand extends Model
{

    use RevisionableTrait;
    
    protected $primaryKey = 'brand_id';


    /**
     * The primary key associated with the table.
     *
     * @var string
     */

    protected $hidden = [
        'activated_at','created_at ','updated_at '
    ];


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'brand_id','user_id','company_name', 'brand_name', 'owner_name','owner_email','comp_address','comp_desc', 'is_active','is_verified','activated_at'
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User','user_id');
    }

    public function categories()
    {
        return $this->hasMany('App\Models\BrandCategory','brand_id','brand_id');
    }

    public function activeMembership()
    {
		$date=date('Y-m-d');
        return $this->hasOne('App\Models\BrandMembership','brand_id','brand_id')->where('expiry_date','>',$date);
    }

    public function membership()
    {
        return $this->hasOne('App\Models\BrandMembership','brand_id','brand_id');
    }


    public function languages()
    {
        return $this->hasMany(BrandLanguage::class,'brand_id','brand_id');
    }


    public function primary()
    {
        return $this->hasOne('App\Models\BrandCategory','brand_id','brand_id')->where('mapping_type',1);
    }

    public function secondry()
    {
        return $this->hasMany('App\Models\BrandCategory','brand_id','brand_id')->where('mapping_type',2);
    }

    public function locations()
    {
        return $this->hasMany('App\Models\Location','brand_id','brand_id');
    }

    public function state()
    {
        return $this->hasOne('App\Models\State','id','comp_state');
    }

    public function city()
    {
        return $this->hasOne('App\Models\City','id','comp_city');
    }

    public function video()
    {
        return $this->hasOne('App\Models\Media','brand_id','brand_id')->where('media_type','=', 1)->where('media_subtype','=', 3);
    }    

    public function products()
    {
        return $this->hasMany(Product::class,'brand_id','brand_id');
    }
    
	public function products_images()
    {
        $products=$this->hasMany(Product::class,'brand_id','brand_id');
		foreach($products as $i=>$product){
			$image=$product->hasOne('App\Models\ProductMedia','product_id')->where('product_media_type','=', 2);
			$products[$i]->image=$image;
		}
		return $products;
    }

    public function sliders()
    {
        return $this->hasMany('App\Models\Media','brand_id','brand_id')->where('media_type','=', 2)->where('media_subtype','=', 1);
    }
    
	public function banner()
    {
        return $this->hasOne('App\Models\Media','brand_id','brand_id')->where('media_type','=', 2)->where('media_subtype','=', 2);
    } 

	public function getBrandCategory($brandId,$industryId,$sectorId)
    {
        return DB::table('brand_categories')
            ->select('brand_categories.id')
            ->where('brand_id',$brandId)
            ->where('industry_id',$industryId)
            ->where('sector_id',$sectorId)
            ->get();
    }
	
    public function insertBrandCategory($brandId,$industryId,$sectorId){
        $chkRecord = $this->getBrandCategory($brandId,$industryId,$sectorId);
        if(!empty($chkRecord)){
             DB::table('brand_categories')->insert([
                'brand_id' => $brandId,
                'industry_id' => $industryId,
                'sector_id' => $sectorId,
                'mapping_type' => 1
            ]);
             return 1;
        } else{
            return 0;
        }
    }
    
    public function getProductCount()
    {
        return $this->products->count();
    } 
    
    public function getyoutubethumb($url){
        $youtubeID = $this->getYouTubeVideoId($url);
        return $thumbURL = 'https://img.youtube.com/vi/' . $youtubeID . '/mqdefault.jpg';
    }

    private function getYouTubeVideoId($pageVideUrl) {
        $link = $pageVideUrl;
        $video_id = explode("?v=", $link);
        if (!isset($video_id[1])) {
            $video_id = explode("youtu.be/", $link);
        }
        $youtubeID = $video_id[1];
        if (empty($video_id[1])) $video_id = explode("/v/", $link);
        $video_id = explode("&", $video_id[1]);
        $youtubeVideoID = $video_id[0];
        if ($youtubeVideoID) {
            return $youtubeVideoID;
        } else {
            return false;
        }
    }    

	public function isPaid(){
		$membership = $this->activeMembership;
		if(isset($membership)){
			return true;
		}else{
			return false;	
		}
	}
}

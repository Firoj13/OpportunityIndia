<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use \Venturecraft\Revisionable\RevisionableTrait;

class Product extends Model
{
    use HasFactory;
    
    use RevisionableTrait;

	public $timestamps  = true;
	
    protected $table = 'brand_products';
	
	protected $primaryKey = 'product_id'; // or null
	
	protected $hidden = [
        'product_status','created_at','updated_at'
    ];

	protected $fillable = [
        'product_id','brand_id','product_name', 'product_description', 'product_status'
    ];

    public function brand()
    {
        return $this->belongsTo('App\Models\Brand','brand_id','brand_id');
    }

    public function Attributes()
    {
        return $this->hasMany('App\Models\ProductAttributes','product_id');
    }
    
    public function languages()
    {
        return $this->hasMany(ProductLanguage::class,'product_id','product_id');
    }

    public function video()
    {
        return $this->hasOne('App\Models\ProductMedia','product_id')->where('product_media_type','=', 1);
    }

	public function images()
    {
        return $this->hasMany('App\Models\ProductMedia','product_id')->where('product_media_type','=', 2);
    }
	
	public function image()
    {
        return $this->belongsTo('App\Models\ProductMedia','product_id')->where('product_media_type','=', 2);
    }

    public function GetProductAttributes($productId,$productName,$productValue)
    {
        return DB::table('brand_products_attributes')
            ->select('brand_products_attributes.product_attr_id')
            ->where('product_id	',$productId)
            ->where('attribute_column',$productName)
            ->where('attribute_value',$productValue)
            ->get();
    }

    public function brand_products_media($productId,$mediaUrl,$type){

           return DB::table('brand_products_media')->insert([
                'product_id' => $productId,
                'product_media_type' => $type,
                'media_url' => $mediaUrl,
                'status' => 1
            ]);
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

}

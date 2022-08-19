<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use \Venturecraft\Revisionable\RevisionableTrait;

class Category extends Model
{
    use HasFactory;    
    use RevisionableTrait;

    protected $table = 'categories';
    
    protected $primaryKey = 'category_id';

    protected $revisionCreationsEnabled = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'category_name','category_slug','meta_title','meta_description', 'meta_keywords', 'category_icon','category_image','status'
    ];

    
    public function languages()
    {
        return $this->hasMany(CategoryLanguage::class,'category_id','category_id');
    }


    public function childs() {

      return $this->belongsToMany(Category::class,'category_relation','parent_id', 'child_id');
            
    }

    public function parents(){

        return $this->belongsToMany(Category::class,'category_relation','child_id', 'parent_id');            
    }

    public function getIndustryBrands()
    {
       return $this->hasMany(Category::class,'category_relation','parent_id', 'child_id')->whereUserId($this->id)->count();
    }

    public function getIndustryCount()
    {
        return  \DB::table('brand_categories')->where('industry_id', '=', $this->id)->count();
    } 

    public function getSectorCount()
    {
        return  \DB::table('brand_categories')->where('sector_id', '=', $this->id)->count();
    } 

    static public function getIndustries()
    {
        return \DB::table('categories')->select(\DB::raw("category_id as id, category_name as name,DATE_FORMAT(updated_at,'%Y/%m/%d') updatedAt, category_slug as slug, status"))
        ->leftJoin('category_relation as CR', function($join){
            $join->on('CR.child_id', '=', 'category_id');
            $join->on('CR.relation_type','=',\DB::raw("'1'"));
        })->whereRaw("CR.parent_id IS NULL")
        ->get();
    } 

    static public function getSectors($id)
    {
        return \DB::table('categories')->select(\DB::raw("category_id as id, category_name as name,DATE_FORMAT(updated_at,'%Y/%m/%d') updatedAt, category_slug as slug, status"))
        ->leftJoin('category_relation as CR', function($join){
            $join->on('CR.child_id', '=', 'category_id');
            $join->on('CR.relation_type','=',\DB::raw("'1'"));
        })->whereRaw("CR.parent_id ='".$id."'")
        ->get();
    } 

}

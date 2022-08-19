<?php

namespace App\Http\Controllers;
use App\Models\Brand;
use App\Models\Category;
use App\Models\State;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
class SitemapController extends Controller
{
    
    const URL ="https://dealer.franchiseindia.com/" ;
	
    public function index()
    {		
        ini_set('memory_limit', '-1');

        $siteMapInitializer = "<?xml version=\"1.0\" encoding=\"UTF-8\"?><urlset xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\">";
        $siteMapTerminator  = "</urlset>";

        /* Brands Site map Generation start */
        $siteMapData  = '';
        $brands = Brand::select('brands.profile_name as slug', 'brands.brand_id as id' , 'brands.updated_at')
			->whereIn('brands.profile_status', ['12', '11'])
            ->get();
        foreach ($brands as $brand) {
            $siteMapData .= "<url>
                                <loc>".self::URL."manufacturer/".$brand->slug."-".$brand->id."</loc>
                                <lastmod>".date('Y-m-d', strtotime($brand->updated_at))."</lastmod>
                            </url>";
        }


        Storage::getFacadeRoot()->put( "sitemap_brands.xml", $siteMapInitializer.$siteMapData.$siteMapTerminator);
        /* Brands Site map Generation End */

       /* Category page Site map Generation Start */
        $siteMapData = "";
        $categories = Category::select('categories.category_slug as slug')
            ->where('categories.status',1)
            ->get();

        foreach ($categories as $key => $category) {
            $siteMapData .= "<url>
                            <loc>".self::URL."dir/".$category->slug."</loc>
                            <lastmod>".date('Y-m-d')."</lastmod>
                        </url>";
        }
        Storage::getFacadeRoot()->put( "sitemap_category.xml", $siteMapInitializer.$siteMapData.$siteMapTerminator);
        /* Category page Site map Generation End */

        /* City Site map Generation Start */
        $siteMapData = "";
        $locations = DB::table('special_package')
            ->select('slug','type')
            ->where('status_str','Active')
            ->get()
            ->toArray();
        foreach ($locations as $key => $location) {
			if($location->type==2){
				$siteMapData .= "<url>
					<loc>".self::URL."investment/".$location->slug."</loc>
					<lastmod>".date('Y-m-d')."</lastmod>
				</url>";
			}else{
				$siteMapData .= "<url>
                                <loc>".self::URL."location/".$location->slug."</loc>
                                <lastmod>".date('Y-m-d')."</lastmod>
                            </url>";
			}
        }
        Storage::getFacadeRoot()->put( "sitemap_city_location.xml", $siteMapInitializer.$siteMapData.$siteMapTerminator);
        /* City Site map Generation End */

        /* State Category Site map Generation Start */
        $siteMapData = "";
        $states = State::select('slug as state_slug', 'id as state_id')
            ->get();
        $category = Category::select('categories.category_slug as slug', 'categories.category_id as cat_id')
            ->where('categories.status',1)
            ->get();
        foreach ($states as $skey => $state) {
            $StateBrand = DB::table('brand_locations')->where('state_id', $state->state_id)
                ->count();
            if($StateBrand > 0){
                foreach ($category as $ckey => $cat){
                    $CategoryBrand = DB::table('brand_categories')->where('sector_id', $cat->cat_id)
                        ->count();
                    if($CategoryBrand > 0){
                        $siteMapData .= "<url>
                                <loc>".self::URL."loc-".$state->state_slug."/".$cat->slug."</loc>
                                <lastmod>".date('Y-m-d')."</lastmod>
                            </url>";
                    }
                }
            }

        }
        Storage::getFacadeRoot()->put( "sitemap_state_category.xml", $siteMapInitializer.$siteMapData.$siteMapTerminator);

        /* State Category page Site map Generation End */

        /*
         *  Main SiteMap
         */

        $siteMapInitializer = "<?xml version=\"1.0\" encoding=\"UTF-8\"?><urlset xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\">";
        $siteMapTerminator  = "</urlset>";

        $siteMapData = '<url>
                             <loc>'.self::URL.'</loc>
                             <lastmod>'.date('Y-m-d').'</lastmod>
                            </url>
                            <url>
                            <loc>'.self::URL.'aboutus</loc>
                                <lastmod>'.date('Y-m-d').'</lastmod>
                            </url>
                            <url>
                            <loc>'.self::URL.'contactus</loc>
                                <lastmod>'.date('Y-m-d').'</lastmod>
                            </url>
                            <url>
                                <loc>'.self::URL.'feedback</loc>
                                <lastmod>'.date('Y-m-d').'</lastmod>
                            </url>
                            <url>
                                <loc>'.self::URL.'news</loc>
                                <lastmod>'.date('Y-m-d').'</lastmod>
                            </url>
                            <url>
                                <loc>'.self::URL.'videos</loc>
                                <lastmod>'.date('Y-m-d').'</lastmod>
                            </url>
                            <url>
                                <loc>'.self::URL.'testimonials</loc>
                                <lastmod>'.date('Y-m-d').'</lastmod>
                            </url>
                            <url>
                                <loc>'.self::URL.'termsofuse</loc>
                                <lastmod>'.date('Y-m-d').'</lastmod>
                            </url>

                            <url>
                                <loc>'.self::URL.'sitemap_brands.xml</loc>
                                <lastmod>'.date('Y-m-d').'</lastmod>
                            </url>
                            <url>
                                <loc>'.self::URL.'sitemap_category.xml</loc>
                                <lastmod>'.date('Y-m-d').'</lastmod>
                            </url>
                            <url>
                                <loc>'.self::URL.'sitemap_city_location.xml</loc>
                                <lastmod>'.date('Y-m-d').'</lastmod>
                            </url>
                            <url>
                                <loc>'.self::URL.'sitemap_state_category.xml</loc>
                                <lastmod>'.date('Y-m-d').'</lastmod>
                            </url>';

        Storage::getFacadeRoot()->put( "sitemap.xml", $siteMapInitializer.$siteMapData.$siteMapTerminator);

        echo "Sitemap Generated...";
    }
}

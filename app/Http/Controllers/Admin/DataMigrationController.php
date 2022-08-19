<?php

namespace App\Http\Controllers\Admin;

use App\Http\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Models\AuthorList;
use App\Models\FranchisorContentRef;
use App\Models\HindiContentAssignedTag;
use App\Models\ArticleListEn;
use App\Models\ArticleListHi;
use App\Models\NewsListEn;
use App\Models\NewsListHi;
use App\Models\SeoTagsEn;
use App\Models\SeoTagsHi;
use Illuminate\Support\Facades\Artisan;


class DataMigrationController extends Controller
{
    /**
     * DataMigrationController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    /**
     *Migrating assigned tags from news/articles
     */
    public function migrateKickers()
    {
        Artisan::call('route:clear');

die;
        $this->processKickers( 'NewsListEn','SeoTagsEn','ContentAssignedTag', 'en', Config('constants.CONTENT_TYPE.NEWS'));
//        $this->processKickers( "NewsListHi",'SeoTagsHi','HindiContentAssignedTag', 'hi', Config('constants.CONTENT_TYPE.NEWS'));

        $this->processKickers( 'ArticleListEn','SeoTagsEn','ContentAssignedTag', 'en', Config('constants.CONTENT_TYPE.ARTICLE'));
//        $this->processKickers( 'HindiContentList','SeoTagsHi','HindiContentAssignedTag', 'hi', Config('constants.CONTENT_TYPE.ARTICLE'));
    }

    /**
     * @param $tableToProcess
     * @param $seoTagsTable
     * @param $assignedTagsTable
     * @param $languageCode
     * @param $contentType
     */
    public function processKickers($tableToProcess, $seoTagsTable, $assignedTagsTable, $languageCode, $contentType)
    {
        $tableModel = "App\\Models\\$tableToProcess";
        $seoModel = "App\\Models\\$seoTagsTable";
        $assignedTagsSeoModel = "App\\Models\\$assignedTagsTable";
        $processList = $tableModel::query()->select('id', 'primary_tag_id')->where('primary_tag_id','!=','')->whereNotNull('primary_tag_id')->get();



        foreach($processList as $value) {
            if(!is_numeric($value['primary_tag_id']) && !empty($value['primary_tag_id'])) {

                $checkSeoExists = $seoModel::where('name', $value['primary_tag_id'])->first();

                if(empty($checkSeoExists)) {
                    $insertSeo = $seoModel::create([
                        'name' => $value['primary_tag_id'],
                        'slug' => str_slug($value['primary_tag_id']),
                        'language_code' => $languageCode,
                        'frequency' => 0
                    ]);

                    if($insertSeo) {
                        $insertedTagId = ($insertSeo->id);

                        if(!empty($insertedTagId)) {
                            $assignedTagsSeoModel::create([
                                'content_id' => $value['id'],
                                'tag_id' => $insertedTagId,
                                'sequence_order' => 0,
                                'content_type' => $contentType,
                                'frequency' => 0
                            ]);
                        }
                    }

                } else {
                    $insertedTagId = $checkSeoExists->id;
                }

                if(!empty($insertedTagId) && is_numeric($insertedTagId)) {

                    $tableModel::query()->where('id', $value['id'])->update([
                        'primary_tag_id' => $insertedTagId
                    ]);

                }
            }
        }
    }

    /**
     *Migrating related brands for news/articles
     */
    public function migrateFranchisorIds()
    {
        $this->processRelatedBrands( 'NewsListEn', 'en', Config('constants.CONTENT_TYPE.NEWS'));
        $this->processRelatedBrands( "NewsListHi", 'hi', Config('constants.CONTENT_TYPE.NEWS'));

        $this->processRelatedBrands( 'ArticleListEn', 'en', Config('constants.CONTENT_TYPE.ARTICLE'));
        $this->processRelatedBrands( 'ArticleListHi', 'hi', Config('constants.CONTENT_TYPE.ARTICLE'));

    }

    /**
     * @param $tableToProcess
     * @param $languageCode
     * @param $contentType
     */
    private function processRelatedBrands($tableToProcess, $languageCode, $contentType)
    {
        $tableModel = "App\\Models\\$tableToProcess";
        $contents = $tableModel::query()->select('id', 'related_brand')->where('related_brand','!=','')->whereNotNull('related_brand')->get();
        foreach ($contents as $content) {
            $relatedBrands = $content->related_brand;
            if(!empty($relatedBrands)) {
                $relatedBrandArray = explode(',', $relatedBrands);
                if(!empty($relatedBrandArray) && count($relatedBrandArray) > 0) {
                    foreach ($relatedBrandArray as $relatedBrand) {
                        try {
                            $existingResultCount = FranchisorContentRef::query()
                                ->where('content_id', $content->id)
                                ->where('franchisor_id', $relatedBrand)
                                ->where('language_code', $languageCode)
                                ->where('content_type', $contentType)
                            ->count();

                            if($existingResultCount == 0) {
                                FranchisorContentRef::query()->create([
                                    'content_id' => $content->id,
                                    'franchisor_id' => $relatedBrand,
                                    'language_code' => $languageCode,
                                    'content_type' => $contentType,
                                ]);
                            }
                        } Catch(\Exception $e) {
                            print_r($e->getMessage());
                        }
                    }
                }
            }
        }
    }

    /**
     *Generate slugs for the seo tags
     */
    public function slugifyKickers()
    {
        $seoTags  = SeoTagsEn::query()
            ->where('name', '!=', '')
            ->whereNotNull('name')
//            ->whereNull('slug')
            ->get();
        foreach($seoTags as $tag) {
            SeoTagsEn::query()->where('id', $tag->id)->update([
                'slug' => str_slug($tag->name)
            ]);
        }

        $seoTags  = SeoTagsHi::query()->where('name', '!=', '')
            ->whereNotNull('name')
//            ->whereNull('slug')
            ->get();
        foreach($seoTags as $tag) {
            SeoTagsHi::query()->where('id', $tag->id)->update([
                'slug' => str_replace(" ", "-", $tag->name)
            ]);
        }
    }

    /**
     *Generate slugs for the seo tags
     */
    public function migrateAuthors()
    {
        $allAuthors = AuthorList::query()->get();
        foreach ($allAuthors as $author) {
            AuthorList::query()->where('id', $author->id)
                                ->update([
                                    'slug' => str_slug($author->name)
                                ]);
        }
//        $this->processAuthors( 'NewsListEn');
//        $this->processAuthors( "NewsListHi");

        $this->processAuthors( 'ArticleListEn');
        $this->processAuthors( 'ArticleListHi');
    }

    private function processAuthors($tableToProcess)
    {
        $tableModel = "App\\Models\\$tableToProcess";
        $authors = $tableModel::query()->select('id', 'author', 'author_id')
//            ->where('author_id', '=', 0)
            ->where('author','!=','')
            ->whereNotNull('author')
            ->get();
        foreach ($authors as $author) {

            $checkAuthor = AuthorList::query()->where('name', $author->author)->first();

            try {
                if(empty($checkAuthor)) {
                    $authorInsert  = AuthorList::query()->create([
                        'name' => $author->author,
                        'slug' => str_slug($author->author),
                        'status' => 1,
                        'company' => '',
                        'designation' => '',
                        'address' => '',
                        'image_path' => '',
                        'phone_number' => '',
                        'linkedin_profile' => '',
                        'fb_profile' => '',
                        'twitter_profile' => '',
                        'intro_desc' => '',
                        'email' => '',
                    ]);

                    $authorId  = $authorInsert;
                } else {
                    $authorId = $checkAuthor->id;
                }

                $tableModel::query()->where('id', $author->id)->update([
                    'author_id' => $authorId
                ]);
            } Catch (\Exception $e) {
                echo $e->getMessage();
            }

        }
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Models\AudioFile;
use App\Models\AuthorList;
use App\Models\ContentAssignedTag;
use App\Models\ArticleListEn;
use App\Models\SeoTagsEn;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Frontend\SitemapController;

class ArticleController extends Controller
{
    /**
     * ArticleController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    /**
     * @param Request $request
     * @return $this|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index(Request $request)
    {
        if (!Auth::user()->hasPermissionTo('manage-articles')) {
            return Redirect::to('/admin/home')->with('warning', "Opps! You don't have sufficient permissions");
        }

        $articles = ArticleListEn::orderBy('id', 'DESC');

        if ($request->has('search')) {
            $articles->whereRaw("id = '" . $request->search . "' OR title LIKE '%" . $request->search . "%'");
        }

        $articles = $articles->paginate(20);
        return view('admin.articles.index', compact('articles'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create(Request $request)
    {
        $tags = SeoTagsEn::all();
        $authers = AuthorList::all()->where('status', 1);
        return view('admin.articles.create', compact('tags', 'authers'));
    }

    /**
     * @param Request $request
     * @return $this
     */
    public function store(Request $request)
    {
        $tagsInsert = false;
        $slider = null;
        $isNoindexNoFollow = 0;

        $validator = Validator::make($request->all(), [
            'title' => 'required|unique:article_list_en,title|max:100',
            'tags' => 'required',
            'author' => 'required',
            'home_title' => 'required|max:65',
            'short_description' => 'required',
            'associated_tags' => 'required',
            'description' => 'required',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors()->first();
            return back()->with("warning", $errors);
        }

        if (!empty($request->article_image)) {
            $uploadPath = Config("constants.ARTICLE_UPLOAD_PATH");
            Helper::storageUpload($request->article_image, $uploadPath, Config('constants.IMAGE'));
        }

        if (!empty($request->slider) && $request->slider === 'yes') {
            $slider = Carbon::now();
        }
        if( ($request->noindexnofollow) && !empty($request->noindexnofollow)){
            $isNoindexNoFollow = 1;
        }

        $articles = ArticleListEn::query()->create([
            'primary_tag_id' => $request->input('tags'),
            'title' => $request->input('title'),
            'home_title' => $request->input('home_title'),
            'author_id' => $request->input('author'),
            'total_views' => 0,
            'image_path' => basename($request->input('article_image')),
            'audio_id' => $request->input('audio'),
            'short_desc' => $request->input('short_description'),
            'content' => $request->input('description'),
            'status' => $request->input('status'),
            'is_slider' => $slider,
            'is_noindexnofollow' => $isNoindexNoFollow,
        ]);

        foreach ($request->associated_tags as $keys => $tag) {
            $tagsInsert = ContentAssignedTag::query()->create([
                'content_id' => $articles->id,
                'tag_id' => $tag,
                'sequence_order' => $keys + 1,
                'content_type' => 1,
            ]);
        }
        if ($articles && $tagsInsert) {
            (new SitemapController)->upArticleInSiteRSS();
            return redirect()->route('article.index')->with("added", 'Article Has Been Added Successfully');
        } else {
            $errors = "Something went wrong";
            return back()->with("warning", $errors);
        }
    }

    public function edit(Request $request)
    {
        $article = ArticleListEn::query()->find($request->id);
        return view('admin.articles.edit', compact('article'));
    }

    /**
     * @param Request $request
     * @return $this
     */
    public function update(Request $request)
    {
        $tagsInsert = false;
        $isNoindexNoFollow = 0;
        $validator = Validator::make($request->all(), [
            // 'title' => 'required|max:75',
            'tags' => 'required',
            'author' => 'required',
            // 'home_title' => 'required|max:65',
            'short_description' => 'required',
            'associated_tags' => 'required',
            'description' => 'required',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors()->first();
            return back()->with("warning", $errors);
        }

        if (!empty($request->article_image)) {
            $uploadPath = Config("constants.ARTICLE_UPLOAD_PATH");
            Helper::storageUpload($request->article_image, $uploadPath, Config('constants.IMAGE'));
        }

        $article = ArticleListEn::query()->find($request->id);
        $slider = $request->slider;
        if ($slider === 'yes') {
            if (!empty($request->slider_timestamp) && ($request->slider_timestamp != null)) {
                $slider = $request->slider_timestamp;
            } else {
                $slider = Carbon::now();
            }
        } elseif ($slider === 'no') {
            $slider = null;
        } else {
            $slider = null;
        }

        if( ($request->noindexnofollow) && !empty($request->noindexnofollow)){
            $isNoindexNoFollow = 1;
        }

        $article->primary_tag_id = $request->input('tags');
        $article->title = $request->input('title');
        $article->home_title = $request->input('home_title');
        $article->author_id = $request->input('author');

        if (!empty($request->input('article_image'))) {
            $article->image_path = basename($request->input('article_image'));
        }

        $article->audio_id = $request->input('audio');
        $article->short_desc = $request->input('short_description');
        $article->content = $request->input('description');
        $article->status = $request->input('status');
        $article->is_slider = $slider;
        $article->is_noindexnofollow = $isNoindexNoFollow;
        $article->updated_by = Auth::id();

        $article->save();
        $tagsUpdates = ContentAssignedTag::query()->where('content_id', $request->id)->delete();

        foreach ($request->associated_tags as $keys => $tag) {
            $tagsInsert = ContentAssignedTag::query()->create([
                'content_id' => $article->id,
                'tag_id' => $tag,
                'sequence_order' => $keys + 1,
                'content_type' => 1,
            ]);
        }

        if ($article->save() && $tagsUpdates && $tagsInsert) {
            (new SitemapController)->upArticleInSiteRSS();
            return redirect()->route('article.index')->with("updated", 'Article Has Been Updated');
        } else {
            $errors = "Something went wrong";
            return back()->with("warning", $errors);
        }
    }

    /**
     * @param Request $request
     */
    public function status(Request $request)
    {
        if ($request->id > 0) {
            ArticleListEn::query()->where('id', $request->id)->update(['status' => $request->status]);
        }
        echo "1";
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getKickersSelects(Request $request)
    {
        $data = [];
        if ($request->has('q')) {
            $search = $request->q;
            $class = request()->type == 1 ? SeoTagsEn::query() : SeoTagsEn::query();
            $data = $class->select("id", "name")
                ->where('name', 'LIKE', "%$search%")
                ->get();
        }
        return response()->json($data);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAuthorsSelects(Request $request)
    {
        $data = [];
        if ($request->has('q')) {
            $search = $request->q;
            $class = AuthorList::query();
            $data = $class->select("id", "name")
                ->where('name', 'LIKE', "%$search%")
                ->where('status', 1)
                ->get();
        }
        return response()->json($data);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    function articleImageUpload(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'images' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:8048',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors()->first();
//            return back()->with("warning", $errors);
//            return response()->json(['warning'=>$errors]);
        }
        $baseFolder = "temp";

        if (empty($baseFolder)) {
            die("Base folder is empty...");
        }
        ini_set('extension', 'php_fileinfo.so');
        $files = $request->file('images');
        $images = [];
        if (count($files)) {
            foreach ($files as $file) {
                # Enter logo path
                $ext = $file->extension();
                if (!empty($file->fileName)) {
                    $path = $baseFolder . '/' . $file->fileName . '.' . $ext;
                } else {
                    $path = $baseFolder . '/' . rand() . '.' . $ext;
                }
                $content = file_get_contents($file);
                Storage::put($path, $content, 'public');
                $images[] = $path;
            }
        }
        return response()->json(['images' => $images]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAudioFiles(Request $request)
    {
        $data = [];
        if ($request->has('q')) {
            $search = $request->q;
            $class = AudioFile::query()->where('status', 1);
            $data = $class->select("id", "name")
                ->where('name', 'LIKE', "%$search%")
                ->where('status', 1)
                ->get();
        }
        return response()->json($data);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    function articleAudioUpload(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'file' => 'nullable|mimes:audio/mpeg,mpga,mp3,wav,aac',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors()->first();
//        return back()->with("warning", $errors);
//        return response()->json(['warning'=>$errors]);
        }
        $baseFolder = "temp";

        if (empty($baseFolder)) {
            die("Base folder is empty...");
        }

        $files = $request->file('audios');
        $audios = [];
        if (count($files)) {
            foreach ($files as $file) {
                # Enter logo path
                $ext = $file->extension();
                if (!empty($file->fileName)) {
                    $path = $baseFolder . '/' . $file->fileName . '.' . $ext;
                } else {
                    $path = $baseFolder . '/' . rand() . '.' . $ext;
                }
                $content = file_get_contents($file);
                Storage::put($path, $content, 'public');
                $audios[] = $path;
            }
        }
        return response()->json(['audios' => $audios]);
    }

    /**
     * @param Request $request
     */
    public function deleteArticleImage(Request $request)
    {
        ArticleListEn::query()->where('id', $request->imageId)->update(['image_path' => '']);
        echo "{done}";
    }

}

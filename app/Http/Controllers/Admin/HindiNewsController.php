<?php

namespace App\Http\Controllers\Admin;

use App\Http\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Models\AuthorList;
use App\Models\HindiContentAssignedTag;
use App\Models\NewsListHi;
use App\Models\SeoTagsEn;
use App\Models\SeoTagsHi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class HindiNewsController extends Controller
{
    /**
     * NewsController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function index(Request $request)
    {
        if (!Auth::user()->hasPermissionTo('manage-news-hi')) {
            return Redirect::to('/admin/home')->with('warning', "Opps! You don't have sufficient permissions");
        }

        $news = NewsListHi::query()->orderBy('id', 'DESC');

        if ($request->has('search')) {
            $news->whereRaw("id = '" . $request->search . "' OR title LIKE '%" . $request->search . "%'");
        }
        $news = $news->paginate(20);
        return view('admin.news-hi.index', compact('news'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create(Request $request)
    {
        $tags = SeoTagsEn::query()->where('language_code', 'hi')->get();
        $authers = AuthorList::all()->where('status', 1);
        return view('admin.news-hi.create', compact('tags', 'authers'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|unique:content_list|max:65',
            'tags' => 'required',
            'author' => 'required',
            'home_title' => 'required|max:50',
            'short_description' => 'required',
            'associated_tags' => 'required',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors()->first();
            return back()->with("warning", $errors);
        }

        if (!empty($request->news_image)) {
            $uploadPath = Config("constants.NEWS_HINDI_UPLOAD_PATH");

            Helper::storageUpload($request->news_image, $uploadPath, Config('constants.IMAGE'));
        }
        $news = NewsListHi::query()->create([
            'primary_tag_id' => $request->input('tags'),
            'title' => $request->input('title'),
            'home_title' => $request->input('home_title'),
            'author_id' => $request->input('author'),
            'total_views' => 0,
            'image_path' => basename($request->input('news_image')),
            'short_desc' => $request->input('short_description'),
            'content' => $request->input('description'),
            'status' => $request->input('status'),
        ]);

        $tagsInsert = false;
        foreach ($request->associated_tags as $keys => $tag) {
            $tagsInsert = HindiContentAssignedTag::query()->create([
                'content_id' => $news->id,
                'tag_id' => $tag,
                'sequence_order' => $keys + 1,
                'content_type' => 2
            ]);
        }

        if ($news && $tagsInsert) {
            return redirect()->route('news-hi.index')->with("added", 'News Has Been Added Successfully');
        } else {
            $errors = "Something went wrong";
            return back()->with("warning", $errors);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit(Request $request)
    {
        $singleNews = NewsListHi::query()->find($request->id);
        return view('admin.news-hi.edit', compact('singleNews'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request){
        $tagsInsert = false;
        $validator = Validator::make($request->all(), [
            'title' =>  'required|max:65',
            'tags' =>  'required',
            'author' =>  'required',
            'home_title' =>  'required|max:50',
            'short_description' => 'required',
            'associated_tags' => 'required',
        ]);

        if($validator->fails()){
            $errors=$validator->errors()->first();
            return back()->with("warning", $errors);
        }

        $news = NewsListHi::query()->find($request->id);

        if(!empty($request->news_image)){
            $uploadPath = Config("constants.NEWS_HINDI_UPLOAD_PATH");
            Helper::storageUpload($request->news_image, $uploadPath, Config('constants.IMAGE'));
        }

        $news->primary_tag_id =  $request->input('tags');
        $news->title = $request->input('title');
        $news->home_title = $request->input('home_title');
        $news->author_id = $request->input('author');
        if (!empty($request->input('news_image'))){
            $news->image_path = basename($request->input('news_image'));
        }

        $news->short_desc = $request->input('short_description');
        $news->content = $request->input('description');
        $news->status = $request->input('status');

        $tagsUpdates = HindiContentAssignedTag::query()->where('content_id', $request->id)->delete();

        foreach ($request->associated_tags as $keys=> $tag) {
            $tagsInsert = HindiContentAssignedTag::query()->create([
                'content_id' => $news->id,
                'tag_id' => $tag,
                'sequence_order' => $keys + 1,
                'content_type' => 2
            ]);
        }

        if($news->save() && $tagsUpdates && $tagsInsert) {
            return redirect()->route('news-hi.index')->with("updated", 'News Has Been Updated');
        }else{
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
            NewsListHi::query()->where('id', $request->id)->update(['status' => $request->status]);
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
            $class = request()->type == 1 ? SeoTagsHi::query() : SeoTagsHi::query();
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
    function newsImageUpload(Request $request)
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
                //echo $path."\n";
                $content = file_get_contents($file);
                Storage::put($path, $content, 'public');
                $images[] = $path;
            }
        }
        return response()->json(['images' => $images]);

    }

    /**
     * @param Request $request
     */
    public function deleteNewsImage(Request $request){
        NewsListHi::query()->where('id', $request->newsId)->update(['image_path' => '']);
        echo "{पूर्ण हुआ}";
    }

}

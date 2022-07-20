<?php

namespace App\Http\Controllers;

use App\Models\Content;
use App\Models\ContentFile;
use App\Models\ContentCategory;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;

/**
 * Class ContentController
 * @package App\Http\Controllers
 */
class ContentController extends Controller
{
    public static $pageTitle = 'Article';
    // public static $pageDescription = 'Content Description';
    // public static $modelName = 'App\Models\Content';
    public static $permissionName = 'content';
    public static $folderPath = 'content';
    public static $routePath = 'contents';
    public static $pageBreadcrumbs = [];

    function __construct()
    {
        $this->middleware('permission:'.self::$permissionName.'-list', ['only' => ['index']]);
        $this->middleware('permission:'.self::$permissionName.'-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:'.self::$permissionName.'-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:'.self::$permissionName.'-delete', ['only' => ['destroy']]);
        $this->middleware('permission:'.self::$permissionName.'-show', ['only' => ['show']]);

        self::$pageBreadcrumbs[] = [
            'page' => '/application/'.self::$routePath,
            'title' => 'List '.self::$pageTitle,
        ];
    }

    public function index(Request $req)
    {
        if ($req->ajax()) {
            return Datatables::of(Content::with('contentCategory'))->addIndexColumn()->make(true);
        }

        $contentCategories = ContentCategory::pluck('name', 'id');

        $pageTitle = self::$pageTitle;
        $pageBreadcrumbs = self::$pageBreadcrumbs;
        $permissionName = self::$permissionName;
        $routePath = self::$routePath;

        return view(self::$folderPath.'.index', compact('pageTitle', 'pageBreadcrumbs', 'permissionName', 'routePath', 'contentCategories'));
    }

    public function create()
    {
        $content = new Content();
        $contentCategories = ContentCategory::pluck('name', 'id');

        $pageTitle = self::$pageTitle;
        $pageBreadcrumbs = self::$pageBreadcrumbs;
        $pageBreadcrumbs[] = [
            'page' => '/application/'.self::$routePath.'/create',
            'title' => 'Create '.self::$pageTitle,
        ];
        $routePath = self::$routePath;
        
        return view(self::$folderPath.'.create', compact('content', 'pageTitle', 'pageBreadcrumbs', 'routePath', 'contentCategories'));
    }

    public function store(Request $request)
    {
        $req = $request->all();
        $req['created_by'] = auth()->user()->id;
        if ($request->file('file')) {
            $name = $request->file('file')->getClientOriginalName();
            $fileName = rand().'_'.time().'_'.$name;  
            $request->file->move(public_path('uploads/content'), $fileName);

            $req['file'] = $fileName;
            $req['file_dir'] = 'uploads/content';
        }
        $contentFile = [];
        if ($request->file('gallery') && count($request->file('gallery'))) {
            foreach ($request->file('gallery') as $key => $value) {
                $name = $request->file('gallery')[$key]->getClientOriginalName();
                $fileName = rand().'_'.time().'_'.$name;  
                $request->gallery[$key]->move(public_path('uploads/content_file'), $fileName);

                $contentFile[] = [
                    'file' => $fileName,
                    'file_dir' => 'uploads/content_file',
                ];
            }
        }

        $content = Content::create($req);
        if (count($contentFile)) {
            $content->contentFiles()->createMany($contentFile);
        }

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'code' => 200,
                'message' => self::$pageTitle.' created successfully'
            ], 200);
        }

        return redirect()->route(self::$routePath.'.index')
            ->with('success', self::$pageTitle.' created successfully.');
    }

    public function show($id)
    {
        $content = Content::find($id);

        $pageTitle = self::$pageTitle;
        $pageBreadcrumbs = self::$pageBreadcrumbs;
        $pageBreadcrumbs[] = [
            'page' => '/application/'.self::$routePath.'/'.$id,
            'title' => 'Show '.self::$pageTitle,
        ];
        $routePath = self::$routePath;

        return view(self::$folderPath.'.show', compact('content', 'pageTitle', 'pageBreadcrumbs', 'routePath'));
    }

    public function edit($id)
    {
        $content = Content::find($id);
        $contentCategories = ContentCategory::pluck('name', 'id');

        $pageTitle = self::$pageTitle;
        $pageBreadcrumbs = self::$pageBreadcrumbs;
        $pageBreadcrumbs[] = [
            'page' => '/application/'.self::$routePath.'/'.$id.'/edit',
            'title' => 'Update '.self::$pageTitle,
        ];
        $routePath = self::$routePath;

        return view(self::$folderPath.'.edit', compact('content', 'pageTitle', 'pageBreadcrumbs', 'routePath', 'contentCategories'));
    }

    public function update(Request $request, $id)
    {
        $content = Content::find($id);
        $req = $request->all();
        if ($request->file('file')) {
            $name = $request->file('file')->getClientOriginalName();
            $fileName = rand().'_'.time().'_'.$name;  
            $request->file->move(public_path('uploads/content'), $fileName);

            $req['file'] = $fileName;
            $req['file_dir'] = 'uploads/content';
        }
        $contentFile = [];
        if ($request->file('gallery') && count($request->file('gallery'))) {
            foreach ($request->file('gallery') as $key => $value) {
                $name = $request->file('gallery')[$key]->getClientOriginalName();
                $fileName = rand().'_'.time().'_'.$name;  
                $request->gallery[$key]->move(public_path('uploads/content_file'), $fileName);

                $contentFile[] = [
                    'file' => $fileName,
                    'file_dir' => 'uploads/content_file',
                ];
            }
        }

        $content->update($req);
        if (count($contentFile)) {
            $content->contentFiles()->createMany($contentFile);
        }

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'code' => 200,
                'message' => self::$pageTitle.' updated successfully'
            ], 200);
        }

        return redirect()->route(self::$routePath.'.index')
            ->with('success', self::$pageTitle.' updated successfully');
    }

    public function destroy(Request $req, $id)
    {
        $content = Content::find($id)->delete();

        if ($req->ajax()) {
            return response()->json([
                'success' => true,
                'code' => 200,
                'message' => self::$pageTitle.' deleted successfully'
            ], 200);
        }

        return redirect()->route(self::$routePath.'.index')
            ->with('success', self::$pageTitle.' deleted successfully');
    }

    public function destroyContentFile(Request $req, $id)
    {
        $content = ContentFile::find($id)->delete();

        if ($req->ajax()) {
            return response()->json([
                'success' => true,
                'code' => 200,
                'message' => 'File deleted successfully'
            ], 200);
        }

        return redirect()->route(self::$routePath.'.index')
            ->with('success', 'File deleted successfully');
    }
}

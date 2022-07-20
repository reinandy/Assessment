<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;

/**
 * Class PermissionController
 * @package App\Http\Controllers
 */
class PermissionController extends Controller
{
    public static $pageTitle = 'Permission';
    // public static $pageDescription = 'Permission Description';
    // public static $modelName = 'App\Models\Permission';
    public static $permissionName = 'permission';
    public static $folderPath = 'permission';
    public static $routePath = 'permissions';
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
            return Datatables::of(Permission::query())->addIndexColumn()->make(true);
            // return Datatables::of(Permission::with('roles'))->addIndexColumn()->make(true);
        }

        $pageTitle = self::$pageTitle;
        $pageBreadcrumbs = self::$pageBreadcrumbs;
        $permissionName = self::$permissionName;
        $routePath = self::$routePath;

        return view(self::$folderPath.'.index', compact('pageTitle', 'pageBreadcrumbs', 'permissionName', 'routePath'));
    }

    public function create()
    {
        $permission = new Permission();

        $pageTitle = self::$pageTitle;
        $pageBreadcrumbs = self::$pageBreadcrumbs;
        $pageBreadcrumbs[] = [
            'page' => '/application/'.self::$routePath.'/create',
            'title' => 'Create '.self::$pageTitle,
        ];
        $routePath = self::$routePath;
        
        return view(self::$folderPath.'.create', compact('permission', 'pageTitle', 'pageBreadcrumbs', 'routePath'));
    }

    public function store(Request $request)
    {
        $req = $request->all();
        $req['guard_name'] = 'web';
        $permission = Permission::create($req);

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
        $permission = Permission::find($id);

        $pageTitle = self::$pageTitle;
        $pageBreadcrumbs = self::$pageBreadcrumbs;
        $pageBreadcrumbs[] = [
            'page' => '/application/'.self::$routePath.'/'.$id,
            'title' => 'Show '.self::$pageTitle,
        ];
        $routePath = self::$routePath;

        return view(self::$folderPath.'.show', compact('permission', 'pageTitle', 'pageBreadcrumbs', 'routePath'));
    }

    public function edit($id)
    {
        $permission = Permission::find($id);

        $pageTitle = self::$pageTitle;
        $pageBreadcrumbs = self::$pageBreadcrumbs;
        $pageBreadcrumbs[] = [
            'page' => '/application/'.self::$routePath.'/'.$id.'/edit',
            'title' => 'Update '.self::$pageTitle,
        ];
        $routePath = self::$routePath;

        return view(self::$folderPath.'.edit', compact('permission', 'pageTitle', 'pageBreadcrumbs', 'routePath'));
    }

    public function update(Request $request, $id)
    {
        $permission = Permission::find($id);
        $req = $request->all();
        $permission->update($req);

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
        $permission = Permission::find($id)->delete();

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
}

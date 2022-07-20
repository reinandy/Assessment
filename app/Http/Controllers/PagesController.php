<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Spatie\Permission\Models\Role;
use App\Models\Content;
use App\Models\ContentCategory;

class PagesController extends Controller
{
    public static $pageTitle = 'Pages';
    public static $pageDescription = 'Pages Description';
    public static $modelName = 'App\Models\Pdf';
    public static $folderPath = 'test';
    public static $permissionName = 'test';
    public static $pageBreadcrumbs = [
        [
            'page' => '/',
            'title' => 'Application',
        ],
        [
            'page' => 'test',
            'title' => 'Test',
        ]
    ];

    public function index()
    {
        if (auth()->user()) {
            return redirect()->route('dashboard');
        }
        
        $pageTitle = 'Login';
        $pageDescription = 'Some description for the page';

        return view('pages.login', compact('pageTitle', 'pageDescription'));
    }

    public function username()
    {
        return 'username';
    }

    public function login(Request $request)
    {
        if (Auth::attempt($request->only('username', 'password'))) {
            $request->session()->regenerate();
            return redirect()->route('dashboard');
        } else {
            return back()->withErrors([
                'username' => 'The provided credentials do not match our records.',
            ]);
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('login');
    }

    public function dashboard()
    {
        $contents = Content::with(['contentCategory'])->orderBy('created_at', 'desc')->get();
        $myContents = Content::with(['contentCategory'])->where('created_by', auth()->user()->id)->limit(5)->get();
        $contentCategories = ContentCategory::pluck('name', 'id');

        $pageTitle = 'Explore Now';

        return view('pages.dashboard', compact('pageTitle', 'contents', 'contentCategories', 'myContents'));
    }

    public function detail($id)
    {
        $contents = Content::with(['contentCategory'])->find($id);
        $myContents = Content::with(['contentCategory'])->where('created_by', auth()->user()->id)->limit(5)->get();
        $contentCategories = ContentCategory::pluck('name', 'id');
        $recomContents = Content::with(['contentCategory'])->where('id', '!=', $id)->orderBy('created_at', 'desc')->limit(2)->get();

        $pageTitle = 'Detail';

        return view('pages.detail', compact('pageTitle', 'contents', 'myContents', 'contentCategories', 'recomContents'));
    }

    public function forgot(Request $request)
    {
        
    }
}

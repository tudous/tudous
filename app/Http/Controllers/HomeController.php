<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Http\Requests\HomeRequest;
use App\Models\Topic;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth',['except' => ['index', 'show','permissionDenied']]);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response                     
     */
    public function index()
    {
        
        return view('home');
    }

    public function search(HomeRequest $request)
    {
        $wd=$request->wd;
        $topics=Topic::where('title','like',"%$wd%")
                    ->orWhere('body','like',"%$wd%")
                    ->paginate(20);
        //return $result;
        return view('search.search',compact('topics'));
  
    }


    public function permissionDenied()
    {
        // 如果当前用户有权限访问后台，直接跳转访问
        if (config('administrator.permission')()) {
            return redirect(url(config('administrator.uri')), 302);
        }
        // 否则使用视图
        return view('permission_denied');
    }
}

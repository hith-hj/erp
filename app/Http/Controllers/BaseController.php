<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\View;

class BaseController extends Controller
{
    public function setTrails($titles = [])
    {
        $path_arr = explode('/',request()->path());
        $name = __('locale.'.Str::ucfirst(Str::plural($path_arr[0])));
        $tail = __('locale.'.Str::ucfirst($path_arr[1]));
        $link = str_contains(request()->path(),'all') ? 
            "javascript:void(0)" :
             $path_arr[0].'/all';

        $breadcrumbs = [
            ['link' => "/", 'name' => __('locale.Home')],
            ['link' => $link, 'name' => $name],
            ['name' => count($titles)>0?implode('-',$titles):$tail]
        ];
        return View::share('breadcrumbs',$breadcrumbs);
    }
}

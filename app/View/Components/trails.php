<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\View;

class trails extends Component
{
    public $breadcrumbs;
    public $titles;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($titles = [])
    {
        $path_arr = explode('/',request()->path());
        $name = __('locale.'.Str::ucfirst(Str::plural($path_arr[0])));
        $tail = __('locale.'.Str::ucfirst($path_arr[1]));
        $link = str_contains(request()->path(),'all') ? 
            "javascript:void(0)" :
             $path_arr[0].'/all';

        $this->breadcrumbs = [
            ['link' => "/", 'name' => __('locale.Home')],
            ['link' => $link, 'name' => $name],
            ['name' => count($titles)>0?implode('-',$titles):$tail]
        ];
        // return View::share('breadcrumbs',$breadcrumbs);
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.trails');
    }
}

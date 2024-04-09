<?php

namespace App\Http\Controllers\Section;

use App\Http\Controllers\BaseController;
use App\Http\Repositories\Section\SectionRepository;
use Illuminate\Http\Request;

class SectionController extends BaseController
{
    private $repo;

    public function __construct(SectionRepository $repo)
    {
        $this->repo = $repo;
    }
    

    public function index()
    {
        $breadcrumbs = [
            ['link' => "/", 'name' => "Home"], ['link' => "javascript:void(0)", 'name' => "Card"], ['name' => "Basic Card"]
          ];
        $cards = $this->repo->all();
        return view('main.cards.index',['breadcrumbs'=>$breadcrumbs,'cards'=>$cards]);
    }

    
    public function create()
    {
        return view('cards.create');
    }

    
    public function store(Request $request)
    {
        return $this->repo->add($request);
    }
    

    public function show($id)
    {
        dd($id);
        return $this->repo->find($id);
    }

   
    public function edit($id)
    {
        //
    }


    public function update(Request $request, $id)
    {
        //
    }


    public function destroy($id)
    {
        //
    }
}

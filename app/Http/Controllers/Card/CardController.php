<?php

namespace App\Http\Controllers\Card;

use App\Http\Controllers\BaseController;
use App\Http\Repositories\Card\CardRepository;
use Illuminate\Http\Request;

class CardController extends BaseController
{
    private $repo;
    public function __construct()
    {
        $this->repo = new CardRepository();
    }    

    public function index()
    {
        $this->setTrails();
        $cards = $this->repo->all();
        return view('main.card.index',['cards'=>$cards]);
    }

    public function create($type)
    {
        return view('main.card.create',[
            'cardType'=>$type,
        ]);
    }
    
    public function store(Request $request)
    {
        $card = $this->repo->add($request);
        return redirect()->route('card.show',['id'=>$card->id]);
    }

    public function show($id)
    {
        $this->setTrails();
        
        return view('main.card.show',[
            'card'=>$this->repo->find($id),
        ]);
    }
   
    public function edit($id)
    {
        $card = $this->repo->find($id);
        return view('main.card.create',[
            'card'=>$card,
            'cardType'=>$card->type,
        ]);
    }

    public function update(Request $request, $id)
    {
        $card = $this->repo->update($request,$id);
        return redirect()->route('card.show',['id'=>$id]);
    }

    public function delete($id)
    {
        $this->repo->delete($id);
        return redirect()->route('card.all');
    }
}

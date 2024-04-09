<?php 

namespace App\Http\Repositories;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Http\FormRequest;

use Illuminate\Http\Request;

interface BaseRepository
{
    public function all(): Collection;
    public function find(int $id) : Model;
    public function add($request) : Model;
    public function update($request,int $id) : bool;
    public function delete(int $id) : bool;
    public function allWith(array|string $relation) : Collection;
    public function findWith(int $id, array|string $relation, array|string $attributes) : Model;
}
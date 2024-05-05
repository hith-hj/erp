<?php

namespace App\Http\Repositories;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class BaseRepository implements Repository
{
    private $model;
    public function __construct($model)
    {
        $this->model = $model;
    }

    public function all(string|array $columns = ['*']): Collection
    {
        return $this->model::all($columns);
    }

    public function find(int $id, string|array $columns = ['*']): Model
    {
        return $this->model::findOrFail($id, $columns);
    }

    public function add(array $data): Model
    {
        return $this->model::create($data);
    }

    public function update(int $id, array $data): bool
    {
        return $this->model::findOrFail($id)->update($data);
    }

    public function delete(int $id): bool
    {
        return $this->model::findOrFail($id)->delete();
    }

    public function allWith(
        array|string $relation = [],
        string|array $columns = ['*']
    ): Collection {
        return $this->model::with($relation)->get($columns);
    }

    public function paginateWith(
        int $perPage = 5,
        array|string $relation = [],
        array|string $columns = ['*'],
    ): Collection {
        return $this->model::with($relation)->paginate($perPage, $columns);
    }

    public function findWith(
        int $id,
        array|string $relation = [],
        string|array $columns = ['*']
    ): Model {
        return $this->model::with($relation)->find($id, $columns);
    }

    public function getWithWhere(
        string $model,
        string|array $with = [],
        array $where = [],
        array $columns = ['*']
    ) : Collection {
        $model = '\App\Models\\' . ucfirst(trim($model));
        return $model::with($with)->where($where)->get($columns);
    }
}

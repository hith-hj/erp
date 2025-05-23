<?php

namespace App\Http\Repositories;

use Closure;
use Exception;
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
        return $this->model::with($relation)->findOrFail($id, $columns);
    }

    public function getWithWhere(
        string $model,
        string|array $with = [],
        array $where = [],
        array $columns = ['*']
    ): Collection {
        $model = '\App\Models\\' . ucfirst(trim($model));
        return $model::with($with)->where($where)->get($columns);
    }

    public function firstWithWhere(
        string $model,
        string|array $with = [],
        array $where = [],
        array $columns = ['*'],
    ): Model {
        return $this->getWithWhere($model, $with, $where, $columns)?->first();
    }

    /**
     *
     * @param string $model Model to call
     * @param array $callable array of methods to call on the model
     * @param string $getter type of getter get(), first(), ...
     * @param array $columns array of columns to get
     * @return Collection|Model the returned value deppend on the getter
     **/
    public function getter(
        string $model,
        array $callable = [],
        string $getter = 'get',
        array $columns = ['*']
    ): Collection|Model|null {
        $model = '\App\Models\\' . ucfirst(trim($model));
        $query = $model::query();
        foreach ($callable as $key => $value) {
            if (in_array($key, ['has', 'whereHas',])) {
                $query->$key(...$value);
            } else {
                $query->$key($value);
            }
        }
        return $query->$getter($columns);
    }

    public function throw(string $message,int $code=0)
    {
        throw new Exception($message,$code);
    }
}

<?php

namespace App\Repositories;


use Exception;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use App\Contracts\RepositoryContract;

class BaseRepository implements RepositoryContract
{
    /**
     * @var Model
     */
    private Model $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function findById(int $id, array $columns = ['*'], array $relations = []): Model
    {
        return $this->findByCriteria(['id' => $id], $columns, $relations);
    }

    public function findByUuid(string $uuid, array $columns = ['*'], array $relations = [], string $columnName = 'id'): Model
    {
        return $this->findByCriteria([$columnName => $uuid], $columns, $relations);
    }

    public function findByCriteria(array $criteria, array $columns = ['*'], array $relations = []): Model
    {
        return $this->make()->select($columns)->with($relations)->where($criteria)->firstOrFail();
    }

    public function getByCriteria(
        array $criteria,
        array $columns = ['*'],
        array $relations = [],
        int $limit = null,
        int $offset = 0
    ): Collection
    {
        $query = $this->make()->select($columns)->with($relations)->where($criteria);
        $query = $query->offset($offset);
        if ($limit != null) {
            $query = $query->take($limit);
        }
        return $query->get();
    }

    public function getPaginatedByCriteria(
        array $criteria,
        int $perPage = null,
        array $columns = ['*'],
        array $relations = [],
        string $orderBy = 'created_at',
        string $direction = 'desc'
    ): LengthAwarePaginator
    {
        if ($perPage == null) {
            $perPage = config('defaults.pager.per_page');
        }
        $query = $this->make()->select($columns)->with($relations)->where($criteria);
        return $query->orderBy($orderBy, $direction)->paginate($perPage);
    }

    public function create(array $attributes): Model
    {
        return $this->make()->create($attributes);
    }

    public function get(array $columns = ['*'], array $relations = [], int $limit = null, int $offset = 0): Model
    {
        $query = $this->make()->select($columns)->with($relations);
        $query = $query->offset($offset);
        if ($limit != null) {
            $query = $query->take($limit);
        }
        return $query->get();
    }

    public function update(Model $model, array $attributes): bool
    {
        return $model->update($attributes);
    }

    public function delete(Model $model): bool
    {
        return $model->delete();
    }

    /**
     * Make a new instance of the entity to query on
     *
     * @param array $with
     * @return Builder
     */
    public function make(array $with = array()): Builder
    {
        return $this->model->with($with);
    }
}

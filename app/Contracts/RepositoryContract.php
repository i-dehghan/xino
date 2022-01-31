<?php

namespace App\Contracts;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;

interface RepositoryContract
{
    /**
     * @param int $id
     * @param array $columns
     * @param array $relations
     * @return Model
     * @throws ModelNotFoundException
     */
    public function findById(int $id, array $columns = ['*'], array $relations = []): Model;

    /**
     * @param string $uuid
     * @param array $columns
     * @param array $relations
     * @return Model
     * @throws ModelNotFoundException
     */
    public function findByUuid(string $uuid, array $columns = ['*'], array $relations = []): Model;

    /**
     * @param array $criteria
     * @param array $columns
     * @param array $relations
     * @return Model
     * @throws ModelNotFoundException
     */
    public function findByCriteria(array $criteria, array $columns = ['*'], array $relations = []): Model;

    /**
     * @param array $criteria
     * @param array $columns
     * @param array $relations
     * @param int|null $limit
     * @param int $offset
     * @return Collection
     */
    public function getByCriteria(
        array $criteria,
        array $columns = ['*'],
        array $relations = [],
        int $limit = null,
        int $offset = 0
    ): Collection;

    /**
     * @param array $criteria
     * @param int|null $perPage
     * @param array $columns
     * @param array $relations
     * @param string $orderBy
     * @param string $direction
     * @return LengthAwarePaginator
     */
    public function getPaginatedByCriteria(
        array $criteria,
        int $perPage = null,
        array $columns = ['*'],
        array $relations = [],
        string $orderBy = 'created_at',
        string $direction = 'desc'
    ): LengthAwarePaginator;

    /**
     * @param array $attributes
     * @return Model
     */
    public function create(array $attributes): Model;

    /**
     * @param Model $model
     * @param array $attributes
     * @return void
     */
    public function update(Model $model, array $attributes): bool;

    /**
     * @param Model $model
     * @return bool
     */
    public function delete(Model $model): bool;
}

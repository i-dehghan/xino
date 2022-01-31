<?php

namespace App\Services;

use App\Repositories\ConfigRepository;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Model;

class ConfigService
{
    private ConfigRepository $configRepository;

    public function __construct(ConfigRepository $configRepository)
    {
        $this->configRepository = $configRepository;
    }


    /**
     * Gets configs and use the input perPage
     *
     * @param int $perPage
     * @return Paginator
     */
    public function getPaginatedConfigs(
        int $perPage
    ): Paginator
    {
        $perPage = ($perPage > 50 || $perPage < 1) ? config('defaults.pager.per_page') : $perPage;
        $contentCriteria = [];

        $columns = [
            '*'
        ];
        return $this->configRepository->getPaginatedByCriteria($contentCriteria, $perPage, $columns, []);
    }

    /**
     *
     * Find config
     *
     * @param int $configId
     * @return Model
     */
    public function find(int $configId): Model
    {
        return $this->configRepository->findByCriteria(['id' => $configId], ['*'], []);
    }

    /**
     *
     * Create config
     *
     * @param array $attributes
     * @return bool
     */
    public function create(array $attributes): bool
    {
        $config = $this->configRepository->create($attributes);
        return $config->exists;
    }


    /**
     *
     * Update config
     *
     * @param Model $config
     * @param array $attributes
     * @return bool
     */
    public function update(Model $config, array $attributes): bool
    {
        return $this->configRepository->update($config, $attributes);
    }

    /**
     *
     * Delete config
     *
     * @param Model $config
     * @return bool
     */
    public function delete(Model $config): bool
    {
        return $this->configRepository->delete($config);
    }

}

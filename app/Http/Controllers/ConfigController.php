<?php

namespace App\Http\Controllers;

use App\Http\Requests\ConfigRequest;
use App\Http\Resources\Config\ConfigCollection;
use App\Http\Resources\Config\ConfigResource;
use App\Models\Config;
use App\Services\ConfigService;
use Facade\FlareClient\Http\Exceptions\NotFound;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use phpDocumentor\Reflection\Types\Collection;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class ConfigController extends Config
{
    private $configService;

    public function __construct(ConfigService $configService)
    {
        $this->configService = $configService;
    }

    /**
     *
     * Configs
     *
     * Get paginated configs.
     *
     * @group Configs
     *
     * @queryParam perPage int The pagination per page (defaults to 18).
     *
     * @apiResource 200 App\Http\Resources\Config\ConfigCollection
     * @apiResourceModel App\Models\Config paginate=18
     * @responseField data The data.
     * @responseField meta Any other complementary information such as message, current_page, from, last_page, per_page, to, total, and ....
     *
     *
     * @return ConfigCollection
     */

    public function index(): ConfigCollection
    {
        $perPage = (int)\request()->get('perPage', 18);
        $configs = $this
            ->configService
            ->getPaginatedConfigs($perPage);
        return new ConfigCollection($configs);
    }


    /**
     *
     * Config
     *
     * Get config.
     *
     * @authenticated
     * @group Admin/Configs
     *
     * @urlParam config integer required The config id.
     *
     * @apiResource 200 App\Http\Resources\Config\ConfigResource
     * @apiResourceModel App\Models\Config
     * @responseField data The data.
     *
     *
     * @param int $config
     * @return ConfigResource
     */
    public function get(Config $config)
    {
        return new ConfigResource($config);
    }


    /**
     *
     * Create
     *
     * Create config.
     *
     * @authenticated
     * @group Admin/Configs
     *
     * @response 422 scenario="Sent data are not valid"
     * {
     *     "message": "The given data was invalid.",
     *     "errors": {
     *         "title": [
     *             "title is required."
     *         ]
     *     }
     * }
     * @response 400 scenario="Bad request"
     * {
     *     "message": "Could not create config."
     * }
     * @apiResource 201 App\Http\Resources\Config\ConfigResource
     * @apiResourceModel App\Models\Config
     * @responseField data The data.
     *
     * @param ConfigRequest $request
     * @return JsonResponse
     */
    public function post(ConfigRequest $request): JsonResponse
    {
        if (
            $this->configService
                ->create($request->validated())) {
            return new JsonResponse(['meta' => ['message' => 'Success!']], 201);
        }
        throw new BadRequestHttpException('Could Not Create Config!');
    }

    /**
     *
     * Update
     *
     * Update config.
     *
     * @authenticated
     * @group Admin/Configs
     *
     * @urlParam config integer required The config id.
     *
     * @response 422 scenario="Sent data are not valid"
     * {
     *     "message": "The given data was invalid.",
     *     "errors": {
     *         "title": [
     *             "title is required."
     *         ]
     *     }
     * }
     * @response 400 scenario="Bad request"
     * {
     *     "message": "Could not create config."
     * }
     * @apiResource 200 App\Http\Resources\Admin\Config\ConfigResource
     * @apiResourceModel App\Models\Config
     * @responseField data The data.
     *
     * @param ConfigRequest $request
     * @param int $config
     * @return JsonResponse
     */
    public function put(ConfigRequest $request, Config $config): JsonResponse
    {
        if (
            $this->configService
                ->update($config, $request->validated())) {
            return new JsonResponse(['meta' => ['message' => 'Success!']], 201);

        }
        throw new BadRequestHttpException('Could Not Create Config!');

    }

    /**
     * Delete
     *
     * Delete config.
     *
     * @authenticated
     * @group Admin/Configs
     *
     * @urlParam config integer required The config id.
     *
     * @response 400 scenario="Bad request"
     * {
     *     "message": "Could not delete config."
     * }
     * @response 200 scenario="Config deleted"
     * {
     *     "meta": {
     *         "message": [
     *             "Success!"
     *         ]
     *     }
     * }
     * @responseField meta The complementary information.
     *
     * @param int $config
     * @return JsonResponse
     */
    public function remove(Config $config): JsonResponse
    {
        if ($this->configService->delete($config)) {
            return new JsonResponse(['meta' => ['message' => 'Success!']], 200);
        }
        throw new BadRequestHttpException('Could Not Delete Config!');
    }

    /**
     *
     * Config List
     *
     * Get list configs.
     *
     * @group Configs
     *
     * @apiResource 200 array
     * @responseField data The data.
     *
     *
     * @return array
     */

    public function list(): array
    {
        return config()->all();
    }

    /**
     * Find Config System
     *
     * get config system.
     *
     *
     * @urlParam config string required The config key.
     *
     * @response 400 scenario="Bad request"
     * {
     *     "message": "Could not find config."
     * }
     * @responseField meta The complementary information.
     *
     * @param string $config
     * @return array
     */
    public function getSystemConfig(string $config): array
    {
        $configs = config($config);
        if (isset($configs)) {
            return config($config);
        }
        throw new ModelNotFoundException('Could Not Find Config!');
    }
}

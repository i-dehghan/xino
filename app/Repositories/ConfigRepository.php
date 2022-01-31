<?php

namespace App\Repositories;

use App\Models\Config;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;

class ConfigRepository extends BaseRepository
{
    public function __construct(Config $model)
    {
        parent::__construct($model);
    }

}

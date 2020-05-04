<?php

namespace App\Core\Infrastructure\Repositories;

use App\Core\Infrastructure\Repositories\Contract\PlanRepository;
use App\Domain\Models\Plan;
use MicroServiceWorld\Core\Infrastructure\Repositories\Criteria\DepartmentCriteria;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Eloquent\BaseRepository;

/**
 * Class PlanRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class PlanRepositoryEloquent extends BaseRepository implements PlanRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Plan::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
        $this->pushCriteria(app(DepartmentCriteria::class));
    }

    public function getPlanByDepartmentName(String $departmentName):Plan{
        return $this->firstWhere('department', $departmentName);
    }

}

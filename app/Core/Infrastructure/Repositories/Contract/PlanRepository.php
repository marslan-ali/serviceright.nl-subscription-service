<?php

namespace App\Core\Infrastructure\Repositories\Contract;
use App\Domain\Models\Plan;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface PlanRepository.
 *
 * @package namespace App\Repositories;
 */
interface PlanRepository extends RepositoryInterface
{
    public function getPlanByDepartmentName(String $departmentName): Plan;
}

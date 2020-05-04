<?php

namespace App\Core\Infrastructure\Repositories;

use App\Core\Infrastructure\Repositories\Contract\PlanItemRepository;
use App\Domain\Models\PlanItem;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Eloquent\BaseRepository;

/**
 * Class PlanItemRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class PlanItemRepositoryEloquent extends BaseRepository implements PlanItemRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return PlanItem::class;
    }



    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

}

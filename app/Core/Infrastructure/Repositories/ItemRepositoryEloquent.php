<?php

namespace App\Core\Infrastructure\Repositories;

use App\Core\Infrastructure\Repositories\Contract\ItemRepository;
use App\Domain\Models\Item;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Eloquent\BaseRepository;

/**
 * Class ItemRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class ItemRepositoryEloquent extends BaseRepository implements ItemRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Item::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
